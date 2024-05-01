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
                                    <h3 class="mb-0">{{__('certificate.My History')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        @if(count($course_records)==0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    <p class="text-center">{{__('certificate.History Not Found!')}}</p>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3 mb-0">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('common.Course')}}</th>

                                                <th scope="col">{{__('certificate.Duration')}}</th> 
                                                <th scope="col">{{__('certificate.StartDate')}}</th>
                                                <th scope="col">{{__('certificate.EndDate')}}</th>
                                                <th scope="col">{{__('certificate.Pass')}}</th>
                                                <th scope="col">{{__('common.Status')}}</th>
                                                <th scope="col" style="text-align: center">{{__('common.Action')}}</th>                                           </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = ($course_records->currentpage()-1)* $course_records->perpage() + 1;@endphp
                                            @if(isset($course_records))
                                                @foreach ($course_records as $key=>$course)
                                                
                                                <tr>
                                                    <td scope="row">
                                                        {{ $i++ }}
                                                    </td>
                                                    <td>
                                                        {{@$course->Title}}
                                                    </td>

                                                    <td>
                                                        {{@$course->Duration}}
                                                    </td>
                                                    <td>
                                                        {{ date(Settings('active_date_format'), strtotime($course->StartDate)) }}
                                                    </td>
                                                    <td>
                                                        {{ date(Settings('active_date_format'), strtotime($course->EndDate)) }}
                                                    </td>
                                                    <td>
                                                        {{ $course->Pass }}
                                                    </td>
                                                    <td>
                                                        {{ $course->Status}}
                                                    </td>
                                                    <td>
                                                            <a href="{{route('historycertificateDownload',$course->id)}}"
                                                               class="link_value theme_btn small_btn4">{{__('common.Download')}}</a>
                                                        </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        {{ $course_records->links() }}
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