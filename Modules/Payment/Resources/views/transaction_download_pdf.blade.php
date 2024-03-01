<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaction Download PDFt</title>
    <style>
        body {
            margin-left: -5px;
            font-family: Tahoma, sans-serif;
            font-style: normal;
            font-weight: normal;
            font-size: 9pt;
            width: 100%;
            height: 100%;
        }
        .container {
            border: 1px solid rgb(128, 128, 128);
            width: 90%;
            margin: 0 auto;
            padding: 10px 60px 30px 60px;
        }

        .row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            position: relative;
        }

        .p-upper {
            text-transform: uppercase;
        }

        .p-bold {
            font-weight: bold;
        }

        #footer hr {
            margin-bottom: 0 !important;
            border-top: 1px solid #333333;
        }
        #footer .footer-content {
            color: rgb(128, 128, 128);
        }

        #header hr {
            border-top: 1px solid #333333;
            margin-top: 10px !important;
        }
        #header .logo-content {
            background-color: #F9F400 !important;
            padding: 10px 20px;
            border: 3px solid #1b1b00;
            display: flex;
        }
        #header .row .w-70 {
            width: 240px;
            height: 135px;
        }
        #header .row .w-30 {
            width: 300px;
            right: 15px;
            position: absolute;
            top: 0;
        }
        #header .w-30 .company-infor {
            /*height: 20px;*/
            line-height: 10px;
        }

        .fax-infor {
            /*line-height: 20px;*/
            width: 100%;
        }
        .fax-infor table {
            width: 100%;
        }
        .fax-infor table tr td:first-child {
            width: 74% !important;
        }
        .fax-infor table tr td:nth-child(2) {
            width: 26% !important;
        }

        .total-price {
            margin-top: 10px;
        }
        .total-price .price-div {
            min-width: 300px;
            margin: 15px 0 40px auto;
        }
        .total-price .table-price tr {
            border-bottom: 2px solid #333333;
            border-top: 2px solid #333333;
        }
        .total-price .table-price td {
            text-align: center;
            vertical-align: middle;
            padding: 0 !important;
        }

        .list-product-table {
            margin-top: 20px;
        }
        .list-product-table tr td {
            border-top-style: solid;
            border-top-width: 1pt;
            border-left-style: solid;
            border-left-width: 1pt;
            border-bottom-style: solid;
            border-bottom-width: 1pt;
            border-right-style: solid;
            border-right-width: 1pt;
        }
        .list-product-table tr:first-child td {
            background-color: #E7E6E6;
        }

        .list-product-table tr {
            height: 40px;
        }

        .text-center {
            text-align: center;
        }

        .d-grid {
            display: -ms-grid;
            display: grid;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <header id="header">
            <div class="row">
                <div class="w-70">
                    <p class="logo-content">{{@$query->user->name}}</p>
                </div>
                <div class="w-30">
                    <p class="company-infor p-upper p-bold">{{@$query->user->name}}</p>
                    @if(@$query->user->address != '')
                    <p class="company-infor">{{@$query->user->address}}, {{@$query->user->city_text}}</p>
                    @endif
                    <p class="company-infor">Tel:{{@$query->user->phone}}</p>
                    <p class="company-infor">Fax:+603 2096 4907/4846</p>
                    <p class="company-infor">Website:{{URL::to('')}}</p>
                    @if($query->user->sst_registration_no ?? 'None')
                        <p class="company-infor">SST Registration No.:{{@$query->user->sst_registration_no}}</p>
                    @endif
                </div>
            </div>
            <hr/>
        </header>
        @php($i = 1)
        @php($grandTotal = 0)
        <div class="row">
            <div class="fax-infor">
                <table>
                    <tr>
                        <td>
                            <strong>PEMBANGUNAN SUMBER MANUSIA BERHAD (545143-D)</strong>
                        </td>
                        <td>
                            TAX INVOICE : {{@$query->invoice_id}}
                        </td>
                    </tr>
                    <tr>
                      <td>
                          Wisma HRD Corp, Jalan Beringin,
                      </td>
                        <td>
                            Date : {{@date("d-m-Y")}}
                        </td>
                    </tr>
                    <tr>
                      <td>
                          Damansara Height,
                      </td>
                      <tr>
                          <td>
                              50490 Kuala Lumpur, Malaysia.
                          </td>
                      </tr>
                    </tr>
                </table>
            </div>
        </div>
        <div class="text-center">
            <div class="d-grid">
                <table class="list-product-table">
                    <tr>
                        <td>
                            NO.
                        </td>
                        <td>
                            COURSE TITLE
                        </td>
                        <td>
                            QTY
                        </td>
                        <td>
                            UNIT PRICE
                        </td>
                        <td>
                            TOTAL COURSE FEE EXCLUSIVE OF 6% SST
                        </td>
                        <td>
                            DEDUCTION OF 30% CONSUMER FEE
                        </td>
                        <td>
                            TOTAL 70% OF COURSE FEE
                        </td>
                    </tr>
                    @foreach($datas as $data)
                        @php($grandTotal += $data['unit_price'] * $data['qty'] * (100 - Settings('commission') - Settings('hrdc_commission')) /100)
                    <tr>
                        <td>
                            {{$i++}}
                        </td>
                        <td>
                            {{$data['title']}}
                        </td>
                        <td>
                            {{$data['qty']}}
                        </td>
                        <td>
                            {{getPriceFormat($data['unit_price'])}}
                        </td>
                        <td>
                            {{getPriceFormat($data['unit_price'] * $data['qty'])}}
                        </td>
                        <td>
                            {{getPriceFormat($data['unit_price'] * $data['qty'] * (Settings('commission') + Settings('hrdc_commission')) /100)}}
                        </td>
                        <td>
                            {{getPriceFormat($data['unit_price'] * $data['qty'] * (100 - Settings('commission') - Settings('hrdc_commission')) /100)}}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row total-price">
            <div class="price-div">
                <table class="table table-price">
                    <tbody>
                    <tr>
                        <td class="table-title">
                            GRAND TOTAL
                        </td>
                        <td class="table-title">
                            {{getPriceFormat($grandTotal)}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>
</html>
