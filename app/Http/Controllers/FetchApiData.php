<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Import the Log facade

class FetchApiData extends Controller
{
    protected $signature = 'fetch:api-data';
    protected $description = 'Fetch data from the API and store it in the database';

    public function handle()
    {
        // dd('hello');
        // Fetch data from API
        $response = Http::get('https://raw.githubusercontent.com/Bit-Code-Technologies/mockapi/main/purchase.json');

        // \Log::info($response);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $purchase) {
                // Check or create User
                $user = User::firstOrCreate(
                    ['name' => $purchase['name'], 'phone' => $purchase['user_phone']]
                );

                // Check or create Product
                $product = Product::firstOrCreate(
                    ['product_code' => $purchase['product_code']],
                    [
                        'name' => $purchase['product_name'],
                        'price' => $purchase['product_price']
                    ]
                );

                // Calculate total price for this purchase
                $totalPrice = $purchase['purchase_quantity'] * $purchase['product_price'];

                // Create Purchase History record
                PurchaseHistory::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'order_no' => $purchase['order_no'],
                    'quantity' => $purchase['purchase_quantity'],
                    'total_price' => $totalPrice
                ]);
            }

            return redirect()->route('report')->with('success', 'Report data fetched successfully.');
        } else {
            return redirect()->route('report')->with('error', 'Failed to fetch data from the API.');
        }
    }
}
