{{--@component('mail::message')--}}
{{--    Hello {{$data["name"]}},--}}

    {{--    Please be informed that you still have some pending courses to be explored.--}}


    {{--    Visit {{ $data['content'] }} to continue your courses.--}}

    {{--    Thank You!--}}
{{--@endcomponent--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<style>
    .social_links {
        background: #F4F4F8;
        padding: 15px;
        margin: 30px 0 30px 0;
    }
    .social_links a {
        display: inline-block;
        font-size: 15px;
        color: #252B33;
        padding: 5px;
    }
    .blue_div{
        color: rgb(255, 255, 255);
        font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;
        text-align: center;
        background-color: #212F64;
        padding: 30px;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        margin: 0px;
    }
    .h1_header{
        color: rgb(255, 255, 255);
        font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;
        text-align: center;
        background-color: #212F64;
        padding: 30px;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        margin: 0px;
    }
</style>
<div class="">
    <div class="blue_div">
        <h1 class="h1_header">
            <img src="https://elatihdev.hrdcorp.gov.my/public/logo2.png">
        </h1>
    </div>

    <div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
        <p style="color: rgb(85, 85, 85);"><br>Hello {{$data["name"]}},</p>
        <p style="color: rgb(85, 85, 85);"> You have pending courses in your e-LATiH account waiting to be completed. We also added more interesting features and resources for you to explore.
</p>
        <p style="color: rgb(85, 85, 85);"> To access the courses, <b>{{ $data['content'] }}</b> </p>
        <p style="color: rgb(85, 85, 85);"> Feel free to reach out to elatih@hrdcorp.gov.my if you need further assistance. </p>
        <p style="color: rgb(85, 85, 85);"> Happy learning! </p>
    </div>
</div>

<div class="email_invite_wrapper" style="text-align: center">
    <div class="social_links">
        e-LATiH All Rights Reserved.
    </div>
</div>
