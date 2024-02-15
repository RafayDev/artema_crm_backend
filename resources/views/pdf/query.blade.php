<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
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
            {{$company->company_address}}<br>
                {{$company->company_phone}}
                <div class="bill-to">
                    <p style="font-size:13px;"><b>Quotation From:</b></p>
                    <div class="down-border"></div>
                    <p style="margin-top:2px;font-size:13px;">{{$user->name}}</p>
                </div>
            </td>
            <td class="column2" style="text-align: left; font-size:25px; color:#C4C4C4;">Quotation</td>
            <td class="column3">
                <img src="./logos/{{$company->company_logo}}" alt="Gryphon Medical Solutions LLC" width="200" height="65">
                <div style="font-weight: light;text-align: left; margin-left:100px; margin-top:40px;">
                    <p style="font-size:13px;"><b>Quotation #:</b> {{$query->id}}</p>
                    <p style="font-size:13px; margin-top:-10px;"><b>Quotation Date:</b> {{$query->created_at->format('d-m-Y')}}</p>
                </div>
            </td>
        </tr>
    </table>
    <div style="margin-top:50px">
        <table class="middle-table" style="text-align:left; font-size:14px;">
            <tr>
                <td>Items</td>
                <td>Description</td>
                <td>SKU</td>
                <td>Size</td>
                <td>Quantity</td>
            </tr>
            @foreach($queryProducts as $query_product)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$query_product->product->product_name}}</td>
                    <td>{{$query_product->sku}}</td>
                    <td>{{$query_product->size}}</td>
                    <td>{{$query_product->quantity}}</td>
                </tr>
                @endforeach
        </table>
    </div>
    <div style="margin-top:50px">
        <table class="header-table">
            <tr>
                <td class="column4">
                    <div style="font-size: 15px; font-weight: light;">
                    <p>Thank you for trusting {{$company->company_name}} for your surgical instrumentation needs.</p>
                    </div>
                </td>
                <td class="column5">
                <!-- <div style="font-weight: light;text-align: left; margin-left:100px;">
                    <p style="font-size:13px;"><b>Subtotal:</b> $0.00</p>
                    <p style="font-size:13px; margin-top:-10px;"><b> Sales Tax:&nbsp; $0.00</b> </p>
                    <div class="down-border"></div>
                    <p style="font-size:13px; margin-top:-10px;"><b> Total:</b> &nbsp;$0.00 </p>
                    <p style="font-size:13px; margin-top:-10px;"><b> Payments:</b> &nbsp;$0.00 </p>
                    <div class="down-border"></div>
                    <p style="font-size:13px; margin-top:2px; background-color:#E5E5E5 ;"><b>Amount Due:</b>&nbsp; $ 0.00</p>
                    <div class="down-border"></div>
                </div> -->
                </td>
            </tr>
        </table>
        <div>
</body>

</html>