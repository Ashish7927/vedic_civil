<div>
    <style>
        .pb_50 {
            padding-bottom: 50px;
        }
    </style>
    <div class="main_content_iner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="purchase_history_wrapper pb_50">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('certificate.My Certificates & Transcript')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        @if(count($certificate_records)==0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    <p class="text-center">{{__('certificate.Certificate Not Found!')}}</p>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-xl-3 col-md-3">
                                    <div class="short_select d-flex align-items-center pt-0 pb-3">
                                        <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Filter By')}}:</h5>
                                        <input type="hidden" id="siteUrl" value="{{route(\Request::route()->getName())}}">
                                        <select class="theme_select my-course-select w-100" id="versionFilter">
                                            <option value="" data-display="{{__('setting.Version')}}">{{__('common.Select')}} {{__('setting.Version')}}</option>
                                            <option value="free" <?php if(isset($_GET['version'])){ if($_GET['version']=='free'){ echo 'selected'; } } ?>>Free</option>
                                            <option value="paid" <?php if(isset($_GET['version'])){ if($_GET['version']=='paid'){ echo 'selected'; } } ?>>Premium</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-3 offset-md-6 offset-xl-6" style="text-align: center">
                                            <button
                                                class="theme_btn w-100 text-center" type="button"
                                                onclick=" window.open('{{ route('myProfile.download') }}','_blank')">{{__('student.Download')}} {{__('student.Transcript')}}</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3 mb-0">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('common.Date')}}</th>
                                                <th scope="col">{{__('common.Course')}}</th>
                                                <th scope="col">{{__('setting.Version')}}</th>
                                                <th scope="col">{{__('certificate.Certificate No')}}</th>
                                                <th scope="col" style="text-align: center">{{__('common.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = ($certificate_records->currentpage()-1)* $certificate_records->perpage() + 1;@endphp
                                            @if(isset($certificate_records))
                                                @foreach ($certificate_records as $key=>$certificate)
                                                {{-- @dd($certificate) --}}
                                                    <tr>
                                                        <td scope="row">{{ $i++ }}</td>

                                                        <td>{{ date(Settings('active_date_format'), strtotime($certificate->created_at)) }}</td>

                                                        <td>
                                                            {{@$certificate->course->title}}

                                                        </td>
                                                        <td>
                                                            @if(($certificate->course->price == 0 && $certificate->course->discount_price == null))
                                                                <p>Free</p>
                                                            @else
                                                                <p>Premium</p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{@$certificate->certificate_id}}

                                                        </td>
                                                        <td>
                                                            <a href="{{route('certificateDownload',$certificate->certificate_id)}}"
                                                               class="link_value theme_btn small_btn4">{{__('common.Download')}}</a>
                                                          <!--  <a href="{{route('certificateCheck',$certificate->certificate_id)}}"
                                                               class="link_value theme_btn small_btn4">{{__('common.View')}}</a>-->
														</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        {{ $certificate_records->appends(Request::all())->links() }}
                                    </div>
                                </div>
                            </div>
                            
                        @endif

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>