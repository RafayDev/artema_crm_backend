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
        width: 25%;
        /* Adjust as needed */
    }

    .column2 {
        width: 25%;
        /* Adjust as needed */
        text-align: left;
        /* vertical-align: top; */
    }

    .column3 {
        width: 50%;
        text-align: right;
    }

    .column4 {
        width: 60%;
        text-align: left;
        vertical-align: top;
    }

    .column5 {
        width: 40%;
        text-align: left;
        vertical-align: top;
    }

    .column6 {
        width: 50%;
        text-align: left;
        vertical-align: top;
    }

    .column7 {
        width: 50%;
        text-align: left;
        vertical-align: top;
        padding: 10px;
    }

    .bill-to {
        margin-top: 100px;
    }

    .down-border {
        border-bottom: 1px solid #bbb;
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

    @page {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        /* padding: 5px; */
    }

    #product {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    #product td,
    #product th {
        border-bottom: 1px solid #bbb;
        padding: 10px;
    }
    </style>
</head>

<body>
    <div style="padding:10px">
        <h2 style="color:#0077c5">INVOICE</h2>
        <div style="margin-top:20px">
            <table class="header-table">
                <tr>
                    <td class="column1" style="font-size: 12px; font-weight: light;">
                        <b>{{$company->company_name}}</b><br>
                        {{$company->company_address}}
                    </td>
                    <td class="column2" style="font-size: 12px; font-weight: light;">
                        <div style="margin-top:-15px">
                            {{$company->email}}<br>
                            {{$company->company_phone}}<br>
                            {{$company->website}}
                        </div>
                    </td>
                    <td class="column3">
                        <img src="./logos/{{$company->company_logo}}" alt="Gryphon Medical Solutions LLC" style="width: 90%;">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="margin-top:10px;background-color:#ebf4fa;padding:10px;">
        <h3 style="color:#0077c5;font-weight:light;">{{$user->name}}</h3>
        <table class="header-table">
            <tr>
                <td class="column4" style="font-size: 12px; font-weight: light;">
                    <b>Bill to</b><br>
                    {{$user->name}}<br>
                    {{$user->address}}

                </td>
                <td class="column5" style="font-size: 12px; font-weight: light;">
                    <b>Ship to</b><br>
                    {{$user->name}}<br>
                    {{$user->address}}
                </td>
            </tr>
        </table>
        <hr style="border-top: 1px solid #bbb; margin-top:40px;margin-bottom:30px;">
        <div style="font-size: 12px; font-weight: light; margin-bottom:30px;">
            <b> Invoice details</b><br>
            Invoice no.: {{$client_invoice->id}}<br>
            Invoice date: {{$client_invoice->created_at->format('d-m-Y')}}<br>
            Due date: {{$client_invoice->due_date}}
        </div>
    </div>
    <div style="margin-top:10px">
        <table id="product">
            <tr>
                <td>#</td>
                <td>Date</td>
                <td>Product or Service</td>
                <td>SKU</td>
                <td>Qty</td>
                <td>Rate</td>
                <td>Amount</td>
            </tr>
            @foreach($client_invoice_products as $invoice_product)
            <tr>
                <td style="font-weight:light;">{{$loop->iteration}}</td>
                <td style="font-weight:light;"></td>
                <td style="font-weight:light;">
                    {{$invoice_product->product->category->category_name}}<br>{{$invoice_product->product->product_name}}
                </td>
                <td style="font-weight:light;">{{$invoice_product->sku}}</td>
                <td style="font-weight:light;">{{$invoice_product->quantity}}</td>
                <td style="font-weight:light;">${{$invoice_product->price}}</td>
                <td style="font-weight:light;">${{$invoice_product->total}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div style="margin-top:0px">
        <table class="header-table">
            <tr>
                <td class="column6">
                    <div style="font-weight: light; padding:10px">
                        <p style="font-size: 18px;">Note to customer</p>
                        <p style="font-size: 12px;">Thank you for considering {{$company->company_name}} to meet
                            your surgical instruments needs!</p>
                        <div style="font-size: 13px; font-weight: light; margin-top:90px">
                            <p>To pay online, go to {{$client_invoice->payment_link}}</p>
                        </div </div>
                        <table class="table-header" style="font-weight: light; padding:10px">
                            <td class="column6">
                                <img src="./img/sba.jpg" alt="Gryphon Medical Solutions LLC" style="width: 50%;">
                            </td>
                            <td class="column7">
                                <img src="./img/duns.jpg" alt="Gryphon Medical Solutions LLC"
                                    style="width: 90%; margin-top:-15px;margin-left:-100px">
                            </td>
                        </table>
                </td>
                <td class="column7">
                    <div style="font-weight: light;text-align: left; margin-left:100px;">
                        <p style="font-size:13px;">Subtotal &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; ${{$client_invoice->sub_total}}</p><br>
                        <p style="font-size:13px; margin-top:-10px;"> Sales Tax &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;${{$client_invoice->sales_tax}}</p>
                            <p style="font-size:13px; margin-top:-10px;"> Frieght Charges &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;${{$client_invoice->frieght_charges}}</p>
                        <div class="down-border" style="margin-top:10px;"></div>
                        <p style="font-size:13px; margin-top:10px;"><b> Total</b> &nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<b style="font-size:16px">${{$client_invoice->total}}</b>
                        </p>
                        <div class="down-border" style="margin-top:10px;"></div>
                        <p style="font-size:13px; margin-top:10px;"> Due date &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;{{$client_invoice->due_date}}</p>
                    </div>
                </td>
            </tr>
        </table>
        <div>
</body>

</html>