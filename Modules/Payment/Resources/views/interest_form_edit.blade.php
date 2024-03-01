@extends('backend.master')

@section('mainContent')


    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>Interest Form Edit </h1>
                <div class="bc-pages">
                    <a href="{{url('/dashboard')}}">{{__('common.Dashboard')}} </a>
                    <a href="{{route('admin.interest.form')}}">Interest Form</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area student-details">
        <div class="container-fluid p-0">
            <div class="row">
              
                <div class="col-md-12">
                    
                    
                    <div class="white_box_30px">
                        <div class="row  mt_0_sm">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12">


                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <input type="hidden" name="selectTab" id="selectTab">
                                    <div role="tabpanel"
                                         class="tab-pane "
                                         id="group_email_sms">

                                        

                                    </div>

                                    <div role=""
                                         class="
                                            
                                             "
                                         id="indivitual_email_sms">
                                        <div class="white_box_30px pl-0 pr-0 pt-0">
                                            <form action="{{route('admin.interestFormUpdate')}}" method="POST" id="updateCourseForm"
                                                  enctype="multipart/form-data">
                                                @csrf
                                               
                                                <div class="row">
                                                    @if(\Illuminate\Support\Facades\Auth::user()->role_id!=1 && \Illuminate\Support\Facades\Auth::user()->role_id!=7 )
                                                    
                                                    @endif
                                                    <div
                                                        class=" @if(\Illuminate\Support\Facades\Auth::user()->role_id==1) col-xl-8 @else col-xl-12  @endif">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label mt-1"
                                                                   for="">Full Name</label>
                                                                <label>{{$data->full_name}}</label>
                                                        </div>
                                                    </div>

                                                   

                                                
                      

                                                </div>
                                                <input type="hidden" name="id" class="course_id"
                                                       value="{{$data->id}}">
                                                

                                                            <div class="row  ">
                                                                <div class="col-md-12">
                                                                    <label class="primary_input_label mt-1"
                                                                           for=""> Status</label>
                                                                </div>
                                                                <div class="col-md-3 mb-25">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                        for="status0">
                                                                    <input type="radio"
                                                                           class="common-radio status0"
                                                                           id="status0"
                                                                           name="status"
                                                                           value="0" {{@$data->status==0?"checked":""}}>
                                                                        <span class="checkmark mr-2" data-toggle="tooltip" title="0"></span>      Pending</label>
                                                                </div>
                                                                <div class="col-md-3 mb-25">

                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                        for="status1">
                                                                    <input type="radio"
                                                                           class="common-radio status1"
                                                                           id="status1"
                                                                           name="status"
                                                                           value="1" {{@$data->status==1?"checked":""}}>


                                                                        <span
                                                                         data-toggle="tooltip" title="1"
                                                                         class="checkmark mr-2"></span> Completed</label>
                                                                </div>
                                                          
                                                    
                                                  
                                                    <div class="col-lg-12 text-center pt_15">
                                                        <div class="d-flex justify-content-center">
                                                            
                                                                @if(check_whether_cp_or_not() || isPartner() || isAdmin() || isHRDCorp() || isMyLL())
                                                                   
                                                                    <button style="margin-right: 18px" class="primary-btn semi_large2  fix-gr-bg" id="submit_button_parent"  type="submit"><i
                                                                            class="ti-check update_check"></i>
                                                                        <span class="btn_text_submit">{{__('common.Update')}} {{__('courses.Course')}}</span>
                                                                        
                                                                    </button>
                                                                @endif
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                    

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" id="branchSelectType">
    <input type="hidden" id="branchName">
@endsection



@push('scripts')
   

@endpush
