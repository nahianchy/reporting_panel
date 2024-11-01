<!-- resources/views/report.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Purchasers Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('fetchData') }}" class="btn btn-primary">Generate Report</a>
        </div>
        <div class="container mt-5">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Top Purchasers Report</h2>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Customer Phone</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportData as $data)
                                <tr>
                                    <td>{{ $data->product_name }}</td>
                                    <td>{{ $data->customer_name }}</td>
                                    <td>{{ $data->customer_phone }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ number_format($data->price, 2) }}</td>
                                    <td>{{ number_format($data->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Gross Total:</td>
                                <td class="fw-bold">{{ number_format($grossTotal, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer text-muted text-center">
                    Report generated on {{ now()->format('Y-m-d') }}
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
