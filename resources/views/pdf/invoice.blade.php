<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
    @page {
        margin: 10px;
        padding: 5px;
    }

    body {
        font-family: 'Arial', sans-serif;
        color: #671b1d;
        margin: 0;
        padding: 0;
    }

    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 100px;
        border-bottom: 1px solid #ddd;
        padding: 0 50px;
        background-color: #fff;
        z-index: 1000;
    }

    .footer {
        position: absolute;
        bottom: 0;
        left: 0;
        border-top: 1px solid #ddd;
        background-color: #fff;
        box-sizing: border-box;
        /* padding: 15px; */
        text-align: center;
        z-index: 1000;
        width: 100%;
    }

    .container {
        padding-top: 120px;
        padding-bottom: 130px;
        margin: 0 auto;
    }


    .logo img {
        width: 200px;
        margin-left: -50px;
    }

    h1 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 8px 15px;
    }

    th,
    td {
        border: 1px solid #ddd;
    }

    th {
        background-color: #f3f3f3;
        color: #671b1d;
    }

    .total-row {
        background-color: #f3f3f3;
    }

    .total-row td {
        font-weight: bold;
        color: #671b1d;
    }

    .footer-section,
    .footer-contact {
        display: inline-block;
        vertical-align: top;
        width: 25%;
        margin-top: 5px;
        margin-left:20px;
        margin-right:20px;
        box-sizing: border-box;
        font-size: 14px;
    }

    address {
        display: block;
        margin: 5px 0;
    }

    .footer-notice {
        text-align: center;
        margin-top: 10px;
        font-size: 12px;
        color: #888;
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
    <div class="header">
        <div class="logo">
            <img src="./img/logo.png" alt="Company Logo">
        </div>
        <h1>Invoice</h1>
    </div>

    <div class="container">
        <!-- Invoice Info -->
        @php
        $total = 0;
        @endphp
        <table class="invoice-header">
            <tbody>
                <tr>
                    <td width="50%">
                        <strong>Company Name:</strong>
                        {{$company->company_name}}<br>

                        <strong>Client Name:</strong>
                        {{$user->name}}<br>

                        <strong>Email:</strong>
                        {{$user->email}}<br>

                        <strong>Phone:</strong>
                        {{$company->company_phone}}<br>

                        <strong>Address:</strong>
                        {{$icompany->company_address}}
                    </td>
                    <td width="50%" style="text-align: right;">
                        <strong>Date:</strong>
                        {{$invoice->created_at->format('d-m-Y')}}<br>

                        <strong>Invoice No:</strong>
                        AML-{{$invoice->id}}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Product Info -->
        <table style="text-align:center; font-size:14px; ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Size</th>
                    <th>Price Per Unit ($)</th>
                    <th>Quantity</th>
                    <th>Total Price ($)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoiceProducts as $invoice_product)
                @php
                $total += $invoice_product->total_price;
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$invoice_product->product->product_name}}</td>
                    <td>{{$invoice_product->sku}}</td>
                    <td>{{$invoice_product->size}}</td>
                    <td>{{$invoice_product->price}} $</td>
                    <td>{{$invoice_product->quantity}}</td>
                    <td>{{$invoice_product->total}} $</td>
                </tr>
                @endforeach
                    <tr class="total-row">
                        <td colspan="6">Sales Tax ($)</td>
                        <td>{{$invoice->sales_tax}} $</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="6">Freight Charges($)</td>
                        <td>{{$invoice->freight_charges}} $</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="6">Total ($)</td>
                        <td>{{$invoice->total}} $</td>
                    </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="footer-section">
            <strong>Pakistan Office</strong>
            <address>J-371 DHA EME Canal Bank Road,Lahore</address>
        </div>
        <div class="footer-section">
            <strong>Head Office</strong>
            <address>7901 4th St. N STE 10963,Saint Petersburg, Florida, 33702</address>
        </div>
        <div class="footer-section">
            <strong>UK Office</strong>
            <address>UNIT 2 65 ALEXANDRA ROAD SLOUGH SL1 2NQ</address>
        </div>
        <div style="margin-top:20px">
            <span><strong>Email:</strong> sales@artemamedical.com</span>
            <span><strong>Phone:</strong> + 1 (210) 468 7779</span>
        </div>
        <div class="footer-notice">
            System Generated Invoice
        </div>
    </div>
</body>

</html>