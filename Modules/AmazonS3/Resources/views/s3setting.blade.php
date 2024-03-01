@extends('backend.master')

@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('common.Aws S3 Setting')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('setting.Settings')}}</a>
                    <a href="#">{{__('common.Aws S3 Setting')}}</a>
                </div>
            </div>
        </div>
    </section>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="">
                        <div class="row">

                            <div class="col-lg-12">

                                <div class="tab-content " id="myTabContent">



                                    <div class="tab-pane fade white_box_30px  show active" id="Company_Information"
                                         role="tabpanel" aria-labelledby="Company_Information-tab">

                                        <div class="main-title mb-25">
                                            <h3 class="mb-0">{{__('common.Aws S3 Setting')}}</h3>
                                        </div>

                                        <form action="{{route('AwsS3SettingSubmit')}}" method="post">
                                            @csrf

                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="">{{__('common.Access Key Id')}}</label>
                                                        <input class="primary_input_field"
                                                               placeholder="{{__('common.Access Key Id')}}" type="text"
                                                               id="" name="access_key_id" value="{{env('AWS_ACCESS_KEY_ID')??''}}">
                                                    </div>
                                                </div>


                                                <div class="col-xl-6">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="">{{__('common.Secret Key')}}</label>
                                                        <input class="primary_input_field"
                                                               placeholder="{{__('common.Secret Key')}}" type="text"
                                                               id="" name="secret_key" value="{{env('AWS_SECRET_ACCESS_KEY')??''}}">
                                                    </div>
                                                </div>


                                                <div class="col-xl-6">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="">{{__('common.Default Region')}}</label>
                                                        <input class="primary_input_field"
                                                               placeholder="{{__('common.Default Region')}}"
                                                               type="text" id="" name="default_region" value="{{env('AWS_DEFAULT_REGION')??''}}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="">{{__('common.AWS Bucket')}}</label>
                                                        <input class="primary_input_field"
                                                               placeholder="{{__('common.AWS Bucket')}}"
                                                               type="text" id="" name="bucket" value="{{env('AWS_BUCKET')??''}}">
                                                    </div>
                                                </div>

                                            </div>


                                        <div class="col-12 mb-10 pt_15">
                                            <div class="submit_btn text-center">
                                                <button type="submit" class="primary_btn_large" data-toggle="tooltip"><i
                                                        class="ti-check"></i> {{__('common.Save')}}</button>
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
    </section>
@endsection

