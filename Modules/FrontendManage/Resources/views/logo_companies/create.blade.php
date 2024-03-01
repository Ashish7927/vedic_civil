@extends('backend.master')

@section('mainContent')
    <section class="sms-breadcrumb mb-20 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>Companies</h1>
                <div class="bc-pages">
                    <a href="#">@if(isset($editData)) {{__('common.Edit')}} @else {{__('common.Add')}} @endif Company</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            
            <div class="row">
                <div class="col-lg-12">

                    <div class="white-box">
                        @if(isset($editData))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => route('frontend.logo-companies.update',$editData->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                            
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-lg-12  ">
                                        <div class="input-effect">
                                            <input readonly
                                                class="primary-input form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                type="text" name="title" autocomplete="off"
                                                value="{{isset($editData)? $editData->name : '' }}">
                                            <label>{{__('frontendmanage.Name')}} </label>
                                           
                                        </div>
                                    </div><br><br>
                                    <div class="col-lg-12  ">
                                        <div class="input-effect">
                                            <input
                                                class="primary-input form-control"
                                                type="checkbox" name="show_log_in_front"
                                                value="1" @if (@$editData->show_log_in_front == 1) checked
                                                       @endif >
                                            <label>Show Log in Front Page <span>*</span> </label>
                                           
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(isset($editData))
                                <div class="col-lg-12 mt-40 text-center tooltip-wrapper">
                                    <button class="primary-btn fix-gr-bg tooltip-wrapper ">
                                        <span class="ti-check"></span>
                                        {{__('common.Update')}}
                                    </button>
                                </div>

                            @else

                                <!-- <div class="col-lg-12 mt-40 text-center tooltip-wrapper">
                                    <button class="primary-btn fix-gr-bg tooltip-wrapper ">
                                        <span class="ti-check"></span>
                                        {{__('common.Add')}}
                                    </button>
                                </div> -->

                            @endif

                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
@push('scripts')
    <script>
        $('#summernote').summernote({
            placeholder: 'Write here',
            tabsize: 2,
            height: 200
        });
        $('.popover').css("display", "none");

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview1").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput1").change(function () {
            readURL1(this);
        });

    </script>
@endpush
