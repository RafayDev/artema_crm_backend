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
        <h2 style="color:#0077c5">ESTIMATE</h2>
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
                            {{$company->wesite}}
                        </div>
                    </td>
                    <td class="column3">
                        <img src="./logos/{{$company->company_logo}} alt="Gryphon Medical Solutions LLC" style="width: 90%;">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="margin-top:10px;background-color:#ebf4fa;padding:10px;">
        <h3 style="color:#0077c5;font-weight:light;">Courtney Gill</h3>
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
            <b> Estimate details</b><br>
            Estimate no.: {{$query->id}}<br>
            Estimate date: {{$query->created_at->format('d-m-Y')}}<br>
            Expiration date:  {{$query->created_at->addDays(7)->format('d-m-Y')}}
        </div>
    </div>
    <div style="margin-top:30px">
        <table id="product">
            <tr>
                <td>#</td>
                <td>Date</td>
                <td>Product or Service</td>
                <td>SKU</td>
                <td>Qty</td>
                <!-- <td>Rate</td>
                <td>Amount</td> -->
            </tr>
            @foreach($queryProducts as $query_product)
            <tr>
                <td style="font-weight:light;">{{$loop->iteration}}</td>
                <td style="font-weight:light;"></td>
                <td style="font-weight:light;">{{$query_product->category->category_name}}<br>{{$query_product->product->product_name}}</td>
                <td style="font-weight:light;">{{$query_product->sku}}/td>
                <td style="font-weight:light;">{{$query_product->quantity}}</td>
                <!-- <td style="font-weight:light;">$150.00</td>
                <td style="font-weight:light;">$750.00</td> -->
            </tr>
            @endforeach
        </table>
    </div>
    <div style="margin-top:10px">
        <table class="header-table">
            <tr>
                <td class="column6">
                    <div style="font-weight: light; padding:10px">
                        <p style="font-size: 18px;">Note to customer</p>
                        <p style="font-size: 12px;">Thank you for considering {{$company->company_name}} to meet
                            your surgical instruments needs!</p>
                    </div>
                    <table class="table-header" style="font-weight: light; padding:10px">
                        <td class="column6">
                        <img src="./img/sba.jpg" alt="Gryphon Medical Solutions LLC" style="width: 50%;">
                        </td>
                        <td class="column7">
                        <img src="./img/duns.jpg" alt="Gryphon Medical Solutions LLC" style="width: 90%; margin-top:-15px;margin-left:-100px">
                        </td>
                    </table>
                </td>
                <td class="column7">
                    <div style="font-weight: light;text-align: left; margin-left:100px;">
                        <!-- <p style="font-size:13px;">Subtotal &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; $0.00</p><br>
                        <p style="font-size:13px; margin-top:-10px;"> Sales Tax &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;$100000.00</p>
                        <div class="down-border" style="margin-top:10px;"></div>
                        <p style="font-size:13px; margin-top:10px;"><b> Total</b> &nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<b style="font-size:16px">$0.00</b>
                        </p> -->
                        <div class="down-border" style="margin-top:10px;"></div>
                        <p style="font-size:13px; margin-top:10px;"> Expiry date &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp; {{$query->created_at->addDays(7)->format('d-m-Y')}}</p>
                    </div>
                </td>
            </tr>
        </table>
        <div>
</body>

</html>