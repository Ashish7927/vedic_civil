@extends('backend.master')
@section('table'){{__('testimonials')}}@endsection
@push('styles')
    <link href="{{asset('backend/vendors/nestable/jquery.nestable.min.css')}}" rel="stylesheet">
    <style>
        
            .dd {
                position: relative;
                display: block;
                margin: 0;
                padding: 0;
                max-width: 100%;
                list-style: none;
                font-size: 13px;
                line-height: 20px;
            }


            .dd-list {
                display: block;
                position: relative;
                margin: 0;
                padding: 0;
                list-style: none;
            }


            .dd-list .dd-list {
                padding-left: 30px;
            }


            .dd-collapsed .dd-list {
                display: none;
            }


            .dd-item,
            .dd-empty,
            .dd-placeholder {
                display: block;
                position: relative;
                margin: 0;
                padding: 0;
                min-height: 20px;
                font-size: 13px;
                line-height: 20px;
                margin-bottom: 5px;
            }


            .dd-handle {
                display: block;
                margin: 0px;
                text-decoration: none;
                border: 1px solid #ebebeb;
                background: rgba(0, 0, 0, .03);
                -webkit-border-radius: 3px;
                border-radius: 0px;
                background: #F5F7FB;
                padding: 2px 10px;
                border: 0;
                height: 50px;
                line-height: 46px;
                font-size: 14px;
                font-weight: 400;
                color: #415094;
                padding-left: 30px;
                cursor: grab;

            }


            .dd-handle .menu_icon {
                float: left;
                padding: 0px 16px;
                font-size: 14px;
                font-weight: 400;
                border: 0;
                border: 1px solid #F5F7FB;
                box-sizing: border-box;
                border-radius: 23px 0px 0px 23px;
                color: #415094;
                background: #fff;
                height: 46px;
                margin-right: 12px;
                position: absolute;
                left: 0;
                top: 0;
            }


            .edit_icon {
                float: right;
                cursor: pointer;
                font-size: 16px;
                color: #707DB7;
                font-weight: 400;
                padding-right: 20px;
                height: 46px;
                line-height: 46px;
                position: absolute;
                right: 0;
                top: 0;
            }


            .dd-item > button {
                display: none;
                position: relative;
                cursor: pointer;
                float: left;
                width: 60px;
                height: 46px;
                padding: 0;
                text-indent: 100%;
                white-space: nowrap;
                overflow: hidden;
                border: 0;
                background: transparent;
                font-size: 12px;
                line-height: 1;
                text-align: center;
                font-weight: bold;
                line-height: 46px;
                margin-left: 0px;
                z-index: 99;
                width: 38px;
            }


            .dd-item > button:before {
                content: "\e61a";
                position: absolute;
                left: 0;
                top: 0;
                font-family: 'themify';
                font-size: 14px;
                color: #415094;
                top: 0px;
                left: 0px;
                font-size: 14px;
            }


            .dd-item > button[data-action="collapse"]:before {
                content: '\e622';
                font-size: 14px;
            }


            .dd-placeholder,
            .dd-empty {
                margin: 5px 0;
                padding: 0;
                min-height: 46px;
                background: #f2fbff;
                border: 1px dashed #415094;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                border-radius: 10px;
            }


            .dd-empty {
                border: 1px dashed #415094;
                min-height: 100px;
                background-color: #e5e5e5;
                background-size: 60px 60px;
                background-position: 0 0, 30px 30px;
            }


            .dd-dragel {
                position: absolute;
                pointer-events: none;
                z-index: 9999;
            }


            .dd-dragel > .dd-item .dd-handle {
                margin-top: 0;
            }


            .dd-dragel .dd-handle {
                -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
                box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
            }

            /**
            * Nestable Extras
            */

            /* .nestable-lists {
                display: block;
                clear: both;
                padding: 30px 0;
                width: 100%;
                border: 0;
                border-top: 2px solid #ddd;
                border-bottom: 2px solid #ddd;
            } */

            @media only screen and (min-width: 700px) {

                .dd + .dd , .dd_1 + .dd_1 {
                    margin-left: 2%;
                }
            }


            .dd-hover > .dd-handle {
                background: #2ea8e5 !important;
            }


            .dd-dragel > .dd3-item > .dd3-content {
                margin: 0;
            }

            .collapge_arrow_normal::after {
                content: "\f107";
                color: #ffffff;
                top: 4px;
                right: 4px;
                padding-top: 5px;
                position: absolute;
                font-family: "Font Awesome\ 5 Free";
            }

            .panel-title[aria-expanded="true"] .collapge_arrow_normal::after {
                content: "\f106";
            } 

            .btn_zindex {
                z-index: 1000;
            }

            .btn_div {
                margin-top: -43px;
                max-height: 10px;
            }


            .card-header {
                padding: 5px;
            }

            .card {
                margin-top: 5px;
            }

            .button {
                border: none;
                color: white;
                padding: 10px 14px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                margin-right: 0!important;
                border-radius: 50%;
                height: 40px;
                width: 40px;
                line-height:22px!important;
            }

            .settingBtn{
                position: absolute;
                left: 11px;
                top: 14px;;
            }
    </style>
@endpush
@section('mainContent')
    @include("backend.partials.alertMessage")
    @php
        $currentTheme=currentTheme();
    @endphp
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('frontendmanage.Corporate Access Page Content')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('frontendmanage.Frontend CMS')}}</a>
                    <a class="active" href="{{url('frontend/corporate-access-page-content')}}">{{__('frontendmanage.Corporate Access Page Content')}}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-20 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal" action="{{route('frontend.corporateAccessPageContentUpdate')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                        <div class="white-box">
                            <div class="col-md-12 ">
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    <input type="hidden" name="id" value="{{@$corporate_access_page_content->id}}">
                                <div class="row mb-30">
                                    <div class="col-md-12">
                                        <div class="row" id="unlock_business_box">
                                            <div class="col-xl-12 ">
                                                <div class="mb_25">
                                                    Unlock your business potential
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row mb-25">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <div class="row ">
                                                                <div class="col-xl-6 mb-25">
                                                                    <div class="col-xl-12 mb-25">
                                                                            <select name="cp_multi_input[]" id="cp_multi_input" class=" mb-15" data-maximum-selection-length="18" multiple>
                                                                            </select>
                                                                    </div>
                                                                    <div class="col-xl-12 text-right">
                                                                        <button id="add_cp_btn" type="button"
                                                                                class="primary-btn small fix-gr-bg  mt-3">
                                                                            <span class="ti-plus"></span> 
                                                                               ADD CONTENT PROVIDER</label>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6" id="cpList">
                                                                    @include('frontendmanage::corporate_access_page_content_unlockbusiness')
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <hr>
                                                <br>
                                            </div>
                                        </div>

                                        <div class="row" id="trusted_by_box">
                                            <div class="col-xl-12 ">
                                                <div class="mb_25">
                                                    Trusted by
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row mb-25">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <div class="row ">
                                                                <div class="col-xl-6 mb-25">
                                                                    <div class="col-xl-12 mb-25">
                                                                            <select name="ca[]" id="ca_multi_input" class="primary_multiselect mb-15" data-maximum-selection-length="20" multiple>
                                                                            </select>
                                                                    </div>
                                                                    <div class="col-xl-12 text-right">
                                                                        <button id="add_ca_btn" type="button"
                                                                                class="primary-btn small fix-gr-bg  mt-3">
                                                                            <span class="ti-plus"></span> 
                                                                                ADD CORPORATE ACCESS</label>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6" id="caList">
                                                                    @include('frontendmanage::corporate_access_page_content_trustedby')
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <hr>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script src="{{asset('backend/vendors/nestable/jquery.nestable.min.js')}}"></script>
    <script>

        $(document).ready(function() {
            // Select2 Multiple
            $('#cp_multi_input').select2({
                width: "100%",
                placeholder: "Select Content Provider / Partner",
                allowClear: true,
                ajax: {
                    url: "{{  route('cp_which_not_added_with_ajax') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1 ,     
                        }
                    },
                    cache: true
                }
            });

            $('#ca_multi_input').select2({
                width: "100%",
                placeholder: "Select Corporate",
                allowClear: true,
                ajax: {
                    url: "{{  route('corporate_which_not_added_with_ajax') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1 ,     
                        }
                    },
                    cache: true
                }
            });
        });
        
    </script>
@endpush
