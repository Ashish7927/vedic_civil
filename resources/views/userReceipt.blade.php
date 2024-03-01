<!DOCTYPE html>
<html lang="en">

<head>
    <title>receipt-user</title>
    <link rel="stylesheet" href="{{public_path('css/bootstrap.min.css')}}">
    <style type="text/css">
        body {
            background: #ffffff;
            border: 1px solid;
            padding: 20px;
        }

        @page {
            size: a4 landscape;
        }

        .table>thead>tr>td {
            background: #c0c0c057;
        }

        .logo-img {
            width: 100%;
            max-width: 200px;
            /*border-top: 1px solid #ddd;*/
            /*border-bottom: 1px solid #ddd;*/
            padding: 5px;
        }

        .footer-logo-img {
            width: 100%;
            max-width: 100px;
            /*padding-left: 10rem;*/
        }
    </style>
</head>

<body>
    <table width="700" align="center">
        <tbody>
            <tr>
                <td align="center">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td style="width:70%; vertical-align: center; padding-top: 30px;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img class="logo-img" src="{{ public_path('uploads/editor-image/HRDCorpLogo-01-p619t8tdt51ghw3vbeulbvu7i3z9blja41poix5khs.png1643334555.png') }}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width:30%; vertical-align: center; font-size: 9px;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <strong>PEMBANGUNAN SUMBER MANUSIA BERHAD (545143-D)</strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Wisma HRD Corp, Jalan Beringin,
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Damansara Height,
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    50490 Kuala Lumpur, Malaysia.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Tel : +603 2096 4800
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Fax : +603 2096 4907/4846
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Website : www.hrdcorp.gov.my
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    SST Registration No. : W10-1906-32000027
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table width="100%" style="border-top: 1px solid; padding-top: 20px;">
                        <tbody>
                            <tr>
                                <td style="width:70%; vertical-align: center; font-size: 9px; padding-top: 20px;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="100%">
                                                        <tbody>
                                                            <tr><td>ISSUED TO :</td></tr>
                                                            <tr><td><strong>{{ ($checkout_info->user) ? $checkout_info->user->name : '-' }}</strong></td></tr>
                                                            <tr><td>{{ $checkout_info->billing->address1 }}</td></tr>
                                                            <tr><td>{{ $checkout_info->billing->address2 }}</td></tr>
                                                            <tr><td>{{ $checkout_info->billing->zip_code . ' ' .  $checkout_info->billing->city_text }}</td></tr>
                                                            <tr><td>{{ $checkout_info->billing->cityDetails->name . ' ' . $checkout_info->billing->countryDetails->name }}</td></tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width:30%; vertical-align: center; font-size: 9px; padding-top: 20px;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    @if ($print_type == 'receipt')
                                                                        @php
                                                                            $label = 'RECEIPT';
                                                                        @endphp

                                                                        {{ $label }} :
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        {{ $checkout_info->receipt_no }}
                                                                    @elseif ($print_type == 'invoice')
                                                                        @php
                                                                            $label = 'TAX INVOICE';
                                                                        @endphp

                                                                        {{ $label }} :
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        {{ $checkout_info->invoice_no }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    DATE :
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    {{ date('d/m/Y', strtotime($checkout_info->courses->first()->created_at)) }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table width="100%" class="table table-bordered" style="font-size: 9px; padding-top: 20px;">
                        <thead>
                            <tr>
                                <td>NO.</td>
                                <td>COURSE TITLE</td>
                                <td>CONTENT PROVIDER</td>
                                <td>COURSE DURATION</td>
                                <td>QTY</td>
                                <td>UNIT PRICE</td>
                                <td>AMOUNT</td>
                                <td>SST</td>
                                <td>TOTAL AMOUNT <br> INCLUSIVE SST</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($checkout_info)
                                @php
                                    $total_tax_rate = json_decode($checkout_info->tax_json);
                                @endphp

                                @foreach ($checkout_info->courses as $key => $courseEnroll)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ ($courseEnroll->course) ? $courseEnroll->course->title : '-' }}</td>
                                        <td>{{ (isset($courseEnroll->course) && isset($courseEnroll->course->user)) ? $courseEnroll->course->user->name : '-' }}</td>
                                        <td>{{ ($courseEnroll->course) ? MinuteFormat($courseEnroll->course->duration) : '-' }}</td>
                                        <td>1</td>
                                        <td>{{ ($courseEnroll->course) ? getPriceFormat($courseEnroll->course->price) : getPriceFormat(0) }}</td>
                                        <td>{{ ($courseEnroll->course) ? getPriceFormat($courseEnroll->course->price) : getPriceFormat(0) }}</td>
                                        @if (count($total_tax_rate) > 0)
                                            @php
                                                $tax_amt = 0;
                                            @endphp

                                            @foreach ($total_tax_rate as $tax)
                                                @php
                                                    $tax_amt += ($courseEnroll->course->price / 100) * $tax->value;
                                                @endphp
                                            @endforeach
                                        @endif
                                        <td>{{ getPriceFormat($tax_amt) }}</td>
                                        <td>{{ ($courseEnroll->course) ? getPriceFormat($courseEnroll->course->price + $tax_amt) : getPriceFormat(0) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <table width="100%">
                        <tbody>
                            <tr>
                                <td style="width:70%; vertical-align: center;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width:30%; vertical-align: center; font-size: 9px; padding-top: 20px;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="100%">
                                                        <tbody>
                                                            <tr style="border-top: 1px solid; border-bottom: 1px solid;">
                                                                <td>
                                                                    @php
                                                                        $taxArr = json_decode($checkout_info->tax_json);
                                                                        $total_tax_rate = 0;
                                                                        $total_tax_amount = 0;
                                                                    @endphp

                                                                    @foreach ($taxArr as  $value)
                                                                        @php
                                                                            $total_tax_rate += $value->value;
                                                                        @endphp
                                                                    @endforeach

                                                                    TOTAL SST ({{ $total_tax_rate }}%)
                                                                </td>
                                                                <td>
                                                                    {{  getPriceFormat($checkout_info->total_tax)  }}
                                                                </td>
                                                            </tr>
                                                            <tr style="border-bottom: 1px solid;">
                                                                <td>
                                                                    <strong>GRAND TOTAL</strong>
                                                                </td>
                                                                <td>
                                                                    <strong>{{ getPriceFormat($checkout_info->purchase_price) }}</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table width="100%" style="border-top: 1px solid; padding-top: 20px;">
                        <tbody>
                            <tr>
                                <td style="width:40%; vertical-align: center; padding-top: 10px;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img class="footer-logo-img" src="{{ public_path('uploads/images/23-01-2022/61eca4d64f9d4.png') }}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width:60%; vertical-align: center; font-size: 9px; padding-top: 10px;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: left; color: #c0c0c0">
                                                    This is a computer-generated invoice, no signature is required.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
