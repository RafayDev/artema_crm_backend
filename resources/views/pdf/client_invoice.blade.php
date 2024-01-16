<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
    .header-table {
        width: 100%;
    }

    .header-table,
    th,
    td {
        /* border: 1px solid black; */
    }

    th,
    td {
        /* height: 75px; */
        font-weight: 100;
    }

    /* Set specific width for each column */
    .column1 {
        width: 40%;
        /* Adjust as needed */
    }

    .column2 {
        width: 20%;
        /* Adjust as needed */
        text-align: left;
        vertical-align: top;
    }

    .column3 {
        width: 40%;
        /* Adjust as needed */
        text-align: right;
        vertical-align: top;
    }

    .column4 {
        width: 60%;
        text-align: left;
        vertical-align: top;
    }

    .column5 {
        width: 40%;
        text-align: right;
        vertical-align: top;
    }

    .bill-to {
        margin-top: 100px;
    }

    .down-border {
        border-bottom: 1px solid black;
        margin-top: -10px;
    }

    .middle-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .middle-table th {
        border: 2px solid black;
        /* text-align: center; */
        font-weight: light;
    }

    .middle-table td {
        border: 2px solid black;
        /* text-align: center; */
    }

    .middle-table td:nth-child(1),
    .middle-table th:nth-child(1) {
        width: 20%;
        /* Adjust as needed */
    }

    .middle-table td:nth-child(2),
    .middle-table th:nth-child(2) {
        width: 30%;
        /* Adjust as needed */
    }

    .middle-table td:nth-child(3),
    .middle-table th:nth-child(3) {
        width: 25%;
        /* Adjust as needed */
    }

    .middle-table td:nth-child(4),
    .middle-table th:nth-child(4) {
        width: 25%;
        /* Adjust as needed */
    }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td class="column1" style="font-size: 12px; font-weight: light;"><b>{{$company->company_name}}</b><br>
                {{$company->company_name}}<br>
                {{$company->company_address}}1<br>
                {{$company->company_phone}}
                <div class="bill-to">
                    <p style="font-size:13px;"><b>Bill To:</b></p>
                    <div class="down-border"></div>
                    <p style="margin-top:2px;font-size:13px;">{{$user->name}}</p>
                </div>
            </td>
            <td class="column2" style="text-align: left; font-size:25px; color:#C4C4C4;">INVOICE</td>
            <td class="column3">
                <img src="./logos/{{$company->company_logo}}" alt="Gryphon Medical Solutions LLC" width="200" height="65">
                <div style="font-weight: light;text-align: left; margin-left:100px; margin-top:40px;">
                    <p style="font-size:13px;"><b>Invoice #:</b> {{$client_invoice->id}}</p>
                    <p style="font-size:13px; margin-top:-10px;"><b>Invoice Date:</b> {{$client_invoice->created_at->format('d-m-Y')}}</p>
                    <div class="down-border"></div>
                    <p style="font-size:13px; margin-top:2px; background-color:#E5E5E5 ;"><b>Due Amount:</b> $ {{$client_invoice->total}}</p>
                    <div class="down-border"></div>
                </div>
            </td>
        </tr>
    </table>
    <div style="margin-top:10px">
        <table class="middle-table" style="text-align:center; font-size:14px;">
            <tr>
                <td>Due Date</td>
                <td>Terms</td>
                <td>Sale Rep</td>
            </tr>
            <tr>
                <th>2021-01-11</th>
                <th>Due on Receipt</th>
                <th>{{$client->name}}</th>
            </tr>
        </table>
    </div>
    <div style="margin-top:50px">
        <table class="middle-table" style="text-align:left; font-size:14px;">
        <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price ($)</th>
                    <th>Total ($)</th>
                </tr>
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
        </table>
    </div>
    <div style="margin-top:50px">
        <table class="header-table">
            <tr>
                <td class="column4">
                    <div style="font-size: 15px; font-weight: light;">
                    <p>Thank you for trusting Gryphon Medical Solutions LLC for your surgical instrumentation needs.</p>
                    </div>
                    <div style="font-size: 13px; font-weight: light; margin-top:90px">
                        <p>To pay online, go to {{$invoice->payment_link}}</p>
                    </div>
                </td>
                <td class="column5">
                <div style="font-weight: light;text-align: left; margin-left:100px;">
                    <p style="font-size:13px;"><b>Subtotal:</b> ${{$client_invoice->sub_total}}</p>
                    <p style="font-size:13px; margin-top:-10px;"><b> Sales Tax:&nbsp; $ {{$client_invoice->sales_tax}}</b> </p>
                    <div class="down-border"></div>
                    <p style="font-size:13px; margin-top:-10px;"><b> Frieght Charges:</b> &nbsp;$ {{$client_invoice->frieght_charges}} </p>
                    <p style="font-size:13px; margin-top:-10px;"><b> Payments:</b> &nbsp;$ {{$client_invoice->total}} </p>
                    <div class="down-border"></div>
                    <p style="font-size:13px; margin-top:2px; background-color:#E5E5E5 ;"><b>Amount Due:</b>&nbsp; $ {{$client_invoice->total}}</p>
                    <div class="down-border"></div>
                </div>
                </td>
            </tr>
        </table>
        <div>
</body>

</html>