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
        <h2 style="color:#f68b1e">INVOICE</h2>
        <div style="margin-top:20px">
            <table class="header-table">
                <tr>
                    <td class="column1" style="font-size: 12px; font-weight: light;">
                        <b>Artema Medical Group</b><br>
                        7901 4th St. N STE 10963,Saint Petersburg, Florida, 33702
                    </td>
                    <td class="column2" style="font-size: 12px; font-weight: light;">
                        <div style="margin-top:-15px">
                        sales@artemamedical.com<br>
                        +1 352-778-1116<br>
                     www.artemamed.com
                        </div>
                    </td>
                    <td class="column3">
                        <img src="./img/logo_3.png" alt="Artema Medical Solutions LLC" style="width: 90%;">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="margin-top:0px;background-color:#fcead9;padding:10px;">
        <h3 style="color:#f68b1e;font-weight:light;">{{$user->name}}</h3>
        <table class="header-table">
            <tr>
                <td class="column4" style="font-size: 12px; font-weight: light;">
                    <b>Bill to</b><br>
                    {{$user->name}}<br>
                    {{$company->company_name}}<br>
                    {{$company->company_address}}

                </td>
                <td class="column5" style="font-size: 12px; font-weight: light;">
                    <b>Ship to</b><br>
                    {{$user->name}}<br>
                    {{$company->company_name}}<br>
                    {{$company->company_address}}
                </td>
            </tr>
        </table>
        <hr style="border-top: 1px solid #bbb; margin-top:40px;margin-bottom:30px;">
        <div style="font-size: 12px; font-weight: light; margin-bottom:30px;">
            <b> Invoice details</b><br>
            Invoice no.: AML-{{$invoice->id}}<br>
            Invoice date: {{$invoice->created_at->format('d-m-Y')}}<br>
        </div>
    </div>
    <div style="margin-top:30px">
        <table id="product">
            <tr>
                <td>#</td>
                <td>Date</td>
                <td>Product Name</td>
                <td>SKU</td>
                <td>Qty</td>
                <td>Rate</td>
                <td>Amount</td>
            </tr>
            @foreach($invoiceProducts as $invoice_product)
               
            <tr>
                <td style="font-weight:light;">{{$loop->iteration}}</td>
                <td style="font-weight:light;">{{$invoice->created_at->format('d-m-Y')}}</td>
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
                        <p style="font-size: 12px;">Thank you for considering Artema Medical Group to meet
                            your surgical instruments needs!</p>
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
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; ${{$invoice->sub_total}}</p><br>
                        <p style="font-size:13px; margin-top:-10px;"> Sales Tax &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;${{$invoice->sales_tax}}</p>
                            <p style="font-size:13px; margin-top:-10px;"> Freight Charges &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;${{$invoice->frieght_charges}}</p>
                        <div class="down-border" style="margin-top:10px;"></div>
                        <p style="font-size:13px; margin-top:10px;"><b> Total</b> &nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<b style="font-size:16px">${{$invoice->total}}</b>
                        </p>
                        <!-- <div class="down-border" style="margin-top:10px;"></div>
                        <p style="font-size:13px; margin-top:10px;"> Due date &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;{{$invoice->due_date}}</p> -->
                    </div>
                </td>
            </tr>
        </table>
        <div>
</body>

</html>