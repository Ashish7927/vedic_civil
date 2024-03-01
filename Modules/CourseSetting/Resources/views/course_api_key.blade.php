@extends('backend.master')
@push('styles')
    <?php $version = 'v=' . config('app.version'); ?>
    <link rel="stylesheet" href="{{ asset('backend/css/student_list.css') }}?{{ $version }}"/>
    <style>
        .progress-bar {
            background-color: #9734f2;
        }
        input .label {
            width: 200px;
        }
        .hide_show_secret_key {
            margin-top: -23px!important;
            margin-right: 12px!important;
            float: right!important;
        }
    </style>
@endpush
@section('mainContent')
    <div class="container-fluid p-0 ">
        <section class="sms-breadcrumb white-box" style="margin-bottom: 80px">
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <h1>{{__('courses.Course Api Key')}}</h1>
                    <div class="bc-pages">
                        <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                        <a href="#">{{__('courses.Courses')}}</a>
                        <a href="#">{{__('courses.Course Api Key')}}</a>
                    </div>
                </div>
            </div>
        </section>

        <form action="{{route('course.courseApiKeyGenerate')}}" method="POST">
            @csrf
            <div class="col-lg-12 col-md-12 no-gutters">
                <div class="main-title">
                    <li>
                        <input type="submit" class="primary-btn radius_30px mr-10 fix-gr-bg" value="Generate Api Key" />
                    </li>
                </div>
            </div>
        </form>
        <div class="mb-3">
            <label for="course-api-client-key" class="form-label"><?= __('courses.Course Api Client Key') ?></label>
            <input type="text" readonly class="form-control" id="course-api-client-key" value="{{@$courseApiToken->client_key ?? null}}" />
        </div>
        <div class="mb-3">
            <label for="course-api-secret-key" class="form-label"> <?= __('courses.Course Api Secret Key') ?></label>
            <input type="password" readonly class="form-control" id="course-api-secret-key" value="{{@$courseApiToken->secret_key ?? null}}" />
            <img src="{{ asset('images/eye.png') }}" class="hide_show_secret_key" style="max-height: 13px; margin-top: 14px;">
        </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).on('click','.hide_show_secret_key',function(){
            if($('#course-api-secret-key').is("[type=password]"))
            {
                $("#course-api-secret-key").prop("type", "text");
                $(this).attr("src","{{ asset('images/eye_slash.png') }}");
                // $(this).addClass('fa-eye-slash');
                // $(this).removeClass('fa-eye');
            }else{
                $("#course-api-secret-key").prop("type", "password");
                $(this).attr("src","{{ asset('images/eye.png') }}");
                // $(this).removeClass('fa-eye-slash');
                // $(this).addClass('fa-eye');
            }
        })
    </script>
@endpush

