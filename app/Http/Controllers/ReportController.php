<?php

namespace App\Http\Controllers;

use App\Models\PurchaseHistory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generateReport()
    {
        $reportData = PurchaseHistory::selectRaw('
                   products.name as product_name,
                   users.name as customer_name,
                   users.phone as customer_phone,
                   purchase_histories.quantity,
                   products.price,
                   purchase_histories.total_price
               ')
            ->join('users', 'purchase_histories.user_id', '=', 'users.id')
            ->join('products', 'purchase_histories.product_id', '=', 'products.id')
            ->orderBy('total_price', 'desc')
            ->get();

        $grossTotal = PurchaseHistory::sum('total_price');

        return view('report', [
            'reportData' => $reportData,
            'grossTotal' => $grossTotal
        ]);
    }
}
