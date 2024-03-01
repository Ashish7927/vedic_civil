<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="generator" content="pdf2htmlEX"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="{{public_path('css/bootstrap.min.css')}}">
    <script src="{{public_path('js/jquery.slim.min.js')}}"></script>
    <script src="{{public_path('js/popper.min.js')}}"></script>
    <script src="{{public_path('js/bootstrap.bundle.min.js')}}"></script>
    <title>Transcript Sample</title>
    <link href="{{public_path('css/transcript_sample.css')}}" rel="stylesheet">
    <style>
        /* need create a new folder 'fonts' in storage folder and store the fonts.ttf */
        @font-face {
            font-family: 'Amiri-Bold';
            src: url({{ storage_path('fonts\Amiri-Bold.ttf') }}) format("truetype"); 
        }
        @font-face {
            font-family: 'NotoSansSC-Bold';
            src: url({{ storage_path('fonts\NotoSansSC-Bold.otf') }}) format("truetype"); 
        }
        @font-face {
            font-family: 'Catamaran-Bold';
            src: url({{ storage_path('fonts\Catamaran-Bold.ttf') }}) format("truetype");
        }

    .ta {
        font-family : Catamaran-Bold;
        font-weight: 400 !important;
        line-height: 80%;
    }
    .zh {
        font-family : NotoSansSC-Bold;
        font-weight: 400 !important;
        line-height: 80%;
    }
    .ar {
        font-family :Amiri-Bold;
        font-weight: 400 !important;
        line-height: 80%;
    }
        td {
            text-align: center !important;
        }
    </style>
</head>
@php $total_minutes = 0; @endphp
@foreach($data as $one)
    @if($one->is_completed == 1)
        @php
                $total_minutes += $one->course->duration;
        @endphp
    @endif
@endforeach
<body>
<div class="container" id="airports-container">
    <div class="row header-row">
         <img class="logo" src="{{public_path('images/logo.png')}}" alt="Malaysia Airports Logo"/>
        <div class="header-col-6">
            <h1 class="header-title">Learning Transcript</h1>
        </div>
    </div>
@php
    $images = Auth::user()->image;

    $images = str_replace('', '', $images);

@endphp
    <hr class="underlined">
    <div class="avatar-row">
        <img class="rounded-circle avatar-img" src="{{public_path($images)}}" alt="Avatar"/>
        <p class="s1">{{Auth::user()->name}}</p>
        <p class="email-href"><a href="mailto:mazlank@malaysiaairports.com.my">{{Auth::user()->email}}</a></p>
    </div>
    <div class="table-row table-responsive">
        <figure>
            <figcaption class="d-none">Learning Resource List</figcaption>
            <table class="table table-hover table-condensed ">
                <thead>
                <tr>
                    <td colspan="4">
                        <p class="s2-normal text-left">Export Date: {{$date}}</p>
                    </td>
                    <td colspan="2">
                        <p class="s2-normal text-right">Total minutes: {{$total_minutes}}m</p>
                    </td>
                </tr>
                <tr>
                    <th id="no">
                        <p class="s3">No</p>
                    </th>
                    <th id="learning_resource">
                        <p class="s3">COURSE TITLE</p>
                    </th>
                    <th id="type">
                        <!-- <p class="s2">TYPE</p> -->
                        <p class="s3">VERSION</p>
                    </th>
                    <th id="provider">
                        <p class="s3">PROVIDER</p>
                    </th>
                    <th id="duration">
                        <p class="s3">DURATION (MIN)</p>
                    </th>
                    <th id="completion_date">
                        <p class="s3">COMPLETION DATE</p>
                    </th>
                </tr>
                </thead>
                <tbody>
                @php
                    $i=1;
                @endphp
                @foreach($data as $one)
                    @if($one->is_completed == 1)
                        @php
                            $startTime = new \DateTime($one->created_at);
                            $finishTime = new \DateTime($one->completion_date);

                            $diff = $startTime->diff($finishTime);

                            $hours = $diff->h;
                            $hours = $hours + ($diff->days*24);
                        @endphp
                        <tr><td>
                                <p class="s3">{{ $i++ }}</p>
                            </td>
                            <td>
                                @if(preg_match("/\p{Han}+/u", $one->course->title))
                                    <p class="s3 zh">{{$one->course->title}}</p>
                                @elseif (preg_match("/\p{Arabic}+/u", $one->course->title))
                                    <p class="s3 ar">{{$one->course->title}}</p>
                                @elseif (preg_match("/\p{Tamil}+/u", $one->course->title))
                                    <p class="s3 ta">{{$one->course->title}}</p>
                                @else
                                    <p class="s3">{{$one->course->title}}</p>
                                @endif
                            </td>
                            <td>
                                @if(($one->course->price == 0 && $one->course->discount_price == null))
                                    <p class="s3">Free</p>
                                @else
                                    <p class="s3">Premium</p>
                                @endif
                               
                                <!-- @if($one->course->course_type == 1)
                                    <p class="s3">Micro-credential</p>
                                @elseif($one->course->course_type == 2)
                                    <p class="s3">Claimable</p>
                                @elseif($one->course->course_type == 3)
                                    <p class="s3">Other</p>
                                @else
                                    <p class="s3">Interactive</p>
                                @endif -->
                            </td>
                            <td>
                                <p class="s3">{{$one->course->user->name}}</p>
                            </td>
                            <td>
                                <p class="s3">{{$one->course->duration}}</p>
                            </td>
                            <td>
                            @php
                            $date = $one->completion_date;
                            $createDate = new DateTime($date);
                            $strip = $createDate->format('d M Y');
                            @endphp
                                <p class="s3">{{$strip}}</p>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </figure>
    </div>
</div>
</body>
</html>
