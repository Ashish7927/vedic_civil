<!-- /*27-april*/ -->
<style type="text/css">
@media only screen and (max-width: 575px){
  .invoice_part_iner{
    padding: 24px 18px;
  }
  .main-title h3{
    font-size: 15px;
  }
  .table_btn_wrap .primary_btn{
    padding: 7px 16px;
  }
  .common_table_header .table_btn_wrap > ul{
    flex-wrap: unset;
  }
  .table.custom_table3 tbody tr td, .table.custom_table3 thead tr th{
    font-size: 14px;
  }
  .table.custom_table3 thead tr th{
    padding: 9px 18px 10px 0;
  }
}
/*#course_list .second_column { width: 33% ;}*/
@media only screen and (max-width: 367px){
.logo_image_invoice{
        max-width: 145px!important;
}
}
</style>


<div>
    <section class="admin-visitor-area up_st_admin_visitor pt-5 mt-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-9">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30 text-uppercase">INV-{{$enroll->id+1000}}</h3>
                        </div>
                        <div class="table_btn_wrap">
                            <ul>

                                <li>
                                    <button class="primary_btn printBtn">{{__('student.Print')}}</button>
                                </li>
                                <li>
                                    <button class="primary_btn downloadBtn">{{__('student.Download')}}</button>


                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- invoice print part here -->
                    <div class="invoice_print pb-5">
                        <div class="container-fluid p-0">
                            <div id="invoice_print" class="invoice_part_iner">
                                <table style=" margin-bottom: 30px" class="table">
                                    <tbody>
                                    <td>
                                        <img style="max-width: 193px" src="{{getCourseImage(Settings('logo') )}}"
                                             alt="{{ Settings('site_name')  }}" class="logo_image_invoice">
                                        <p style="color:#000000;"><i>Managed By MyLL Sdn Bhd</i></p>
                                    </td>
                                    <td style="text-align: right">
                                        <h3 class="invoice_no black_color" style=" margin-bottom: 10px" ;>
                                            INV-{{$enroll->id+1000}}</h3>
                                    </td>
                                    </tbody>
                                </table>


                                <table style="margin-bottom: 0 !important;" class="table">
                                    <tbody>
                                    <tr>
                                        <td class="w-50">
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span
                                                    class="black_color">{{__('student.Date')}}: </span><span>{{date('d F Y',strtotime(@$enroll->billing->created_at))}}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span
                                                    class="black_color">{{__('student.Pay Method')}}: </span><span>{{$enroll->payment_method}}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                @if($enroll->courses->sum('purchase_price') == 0 )
                                                    <span class="black_color">{{__('student.Status')}}: </span>
                                                    <span class="black_color">{{__('common.Paid')}}</span></p>
                                            @else
                                                <span class="black_color">{{__('student.Status')}}: </span>
                                                <span
                                                    class="black_color">{{$enroll->status==1?__('student.Paid'):__('student.Unpaid')}}</span></p>
                                            @endif
                                        </td>
                                        <td>
                                            {{--<p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span
                                                    class="black_color">{{__('student.Company')}}: </span><span>{{Settings('site_title') }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span
                                                    class="black_color">{{__('student.Phone')}}: </span><span>{{Settings('phone') }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span
                                                    class="black_color">{{__('student.Email')}}: </span><span>{{Settings('email') }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span
                                                    class="black_color">{{__('student.Address')}}: </span><span>{{Settings('address') }}</span>
                                            </p>--}}
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                                <h4 style=" font-size: 16px; font-weight: 500; color: #000000; margin-top: 0; margin-bottom: 3px "
                                    class="black_color"
                                    ;>{{__('student.Billed To')}},</h4>

                                <table style="margin-bottom: 35px !important;" class="table">
                                    <tbody>
                                    <td>
                                        <p class="invoice_grid"
                                           style="font-size:14px; font-weight: 400; color:#3C4777;">
                                            <span
                                                class="black_color">{{__('student.Name')}}: </span><span> {{@$enroll->billing->first_name}} {{@$enroll->billing->last_name}}</span>
                                        </p>
                                        <p class="invoice_grid"
                                           style="font-size:14px; font-weight: 400; color:#3C4777;">
                                            <span
                                                class="black_color">{{__('student.Phone')}}: </span><span> {{@$enroll->billing->phone}} </span>
                                        </p>
                                        <p class="invoice_grid"
                                           style="font-size:14px; font-weight: 400; color:#3C4777;">
                                            <span
                                                class="black_color">{{__('student.Email')}}: </span><span> {{@$enroll->billing->email}} </span>
                                        </p>
                                        <p class="invoice_grid"
                                           style="font-size:14px; font-weight: 400; color:#3C4777;">
                                            <span class="black_color">{{__('student.Address')}}: </span>
                                            <span class="black_color">
                                            {{@$enroll->billing->address2}}
                                                {{@$enroll->billing->city}}, {{@$enroll->billing->zip_code}}
                                                {{@$enroll->billing->country}}
                                            </span>
                                        </p>
                                    </td>
                                    </tbody>
                                </table>
                                <h2 style=" font-size: 18px; font-weight: 500; color: #000000; margin-top: 70px; margin-bottom: 33px "
                                    class="black_color"
                                    ;>{{__('student.Order List')}}</h2>

                                <table class="table custom_table3 mb-0" id="course_list">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            <span class="pl-3">
                                            {{__('common.SL')}}
                                            </span>
                                        </th>
                                        <th scope="col" class="black_color second_column">{{__('student.Course name')}}</th>
                                        <th scope="col" class="black_color">{{__('common.Discount')}}</th>
                                        <th scope="col" class="black_color">{{__('student.Price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $total =0;
                                        $discount = 0;
                                    @endphp
                                    @if(isset($enroll->courses))
                                        @foreach($enroll->courses as $key=>$item)

                                            <tr>
                                                <td class="black_color">
                                                 <span class="pl-3">
                                                {{++$key}}
                                                 </span>
                                                </td>
                                                <td class="second_column">
                                                    <h5 class="black_color">   {{@$item->course->title}}</h5>

                                                </td>
                                                <td class="black_color">
                                                    @if($item->discount!=0)
                                                        {{getPriceFormat($item->discount)}}
                                                    @endif

                                                </td>
                                                <td class="black_color">
                                                    {{getPriceFormat($item->purchase_price)}}
                                                </td>
                                            </tr>
                                            @php
                                                $total =$total+$item->purchase_price;
                                            @endphp
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td></td>
                                        <td class="second_column"></td>
                                        <td class="text-right">{{__('student.Sub Total')}}</td>
                                        <td>{{getPriceFormat($enroll->price)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="second_column"></td>
                                        <td class="text-right">{{__('common.Discount')}}</td>
                                        @php
                                            $purchase_price = $enroll->purchase_price - $enroll->total_tax;
                                        @endphp

                                        @if(($enroll->price - $purchase_price) == 0)
                                            <td>{{ $enroll->price - $purchase_price }}</td>
                                        @else
                                            <td>{{ getPriceFormat($enroll->price - $purchase_price) }}</td>
                                        @endif
                                    </tr>
                                    {{-- @if(hasTax()) --}}
                                        <tr>
                                            <td></td>
                                            <td class="second_column"></td>
                                            <td class="text-right">{{__('tax.TAX')}}</td>
                                            <td>{{getPriceFormat($enroll->total_tax)}}</td>
                                        </tr>
                                    {{-- @endif --}}
                                    <tr>
                                        <td></td>
                                        <td class="second_column"></td>
                                        <td class="text-right">{{__('student.Total')}}</td>
                                        <td>{{getPriceFormat($enroll->purchase_price)}}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="row mt-5">
                                    <div class="col-lg-2">
                                        <b>Remarks:</b>
                                    </div>
                                    <div class="col-lg-10">
                                        <p style="color:#00000">This is computer generated receipt and no signature is required. By using the HRD Corp e-LATiH platform, you expressly agree and accept all transactions are strictly between you and MyLL, of which PSMB is not a party to the transactions.</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- invoice print part end -->
                </div>
            </div>
        </div>
    </section>
    <div id="editor"></div>
</div>
