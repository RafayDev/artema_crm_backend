<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            margin: 0px;
            padding: 0px;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 100px;
            position: relative;
        }

        .page-background {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('./logos/{{$company->company_logo}}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: contain;
            z-index: -2;
        }

        .opacity-layer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: white;
            opacity: 0.85;
            pointer-events: none;
            z-index: -1;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background-color: #ffffff;
            border-bottom: 1px solid #eee;
            padding: 10px;
            z-index: 1000;
        }

        .header img {
            width: 140px;
            margin-left: 20px; 
        }

        .container {
            width: 95%;
            margin: 2em auto;
        }

        h1, h2 {
            margin: 0.5em 0;
        }

        h1 {
            text-align: center;
            font-size: 24px;
        }

        h2 {
            text-align: center;
            font-size: 20px;
            color: #666;
        }

        h3 {
            text-align: right;
            font-size: 16px;
            color: #999;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2em;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 0.5em 1em;
        }

        th {
            background-color: #f5f5f5;
        }

        td {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #2c3e50;
            padding: 20px 0;
            z-index: 999;
        }

        .footer-content {
            width: 100%;
            margin: 0 auto;
            color: #ecf0f1;
        }

        .footer-content p {
            text-align: center;
            margin: 10px 0;
        }
        .invoice-header {
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .invoice-header td {
        vertical-align: top;
        padding: 10px;
        font-size: 14px;
        color: #666;
        border: none;
    }
    </style>
</head>

<body>
    <div class="page-background"></div>
    <div class="opacity-layer"></div>

    <div class="header">
        <img src="./logos/{{$company->company_logo}}" alt="Company Logo">
    </div>
    
    <div class="container">
        <h1>Invoice</h1>
        <h2>{{$company->company_name}}</h2>
        <table class="invoice-header">
            <tbody>
                <tr>
                    <td width="50%" style="text-align: left;">

                        <strong>Client Name:</strong>
                        {{$user->name}}<br>

                        <strong>Email:</strong>
                        {{$user->email}}<br>

                        <strong>Phone:</strong>
                        {{$user->phone}}<br>

                        <strong>Address:</strong>
                        {{$user->address}}
                    </td>
                    <td width="50%" style="text-align: right;">
                        <strong>Date:</strong>
                        {{$client_invoice->created_at->format('d-m-Y')}}<br>
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="font-size:12px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price ($)</th>
                    <th>Total ($)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($client_invoice_products as $invoice_product)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$invoice_product->product->product_name}}</td>
                    <td>{{$invoice_product->sku}}</td>
                    <td>{{$invoice_product->size}}</td>
                    <td>{{$invoice_product->quantity}}</td>
                    <td>{{$invoice_product->price}} $</td>
                    <td>{{$invoice_product->total}} $</td>
                </tr>
                @endforeach
                <tr class="total-row">
                        <td colspan="6">Sales Tax ($)</td>
                        <td>{{$client_invoice->sales_tax}} $</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="6">Freight Charges($)</td>
                        <td>{{$client_invoice->frieght_charges}} $</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="6">Total ($)</td>
                        <td>{{$client_invoice->total}} $</td>
                    </tr>
            </tbody>
        </table>
        <div style="margin-top:100px"></div>
    </div>

    <div class="footer">
        <div class="footer-content">
            <p><strong>Company Address:</strong>{{$company->company_address}}</p>
            <p><strong>Email:</strong> {{$client->email}}</p>
            <p><strong>Phone:</strong> {{$company->company_phone}}</p>
            <p style="font-size:12px; text-align:right;">System Generated</p>
        </div>
    </div>
</body>

</html>
