<?php $version = 'v=' . config('app.version'); ?>
<link rel="stylesheet" href="{{asset('backend/css/jquery-ui.css')}}?{{ $version }}"/>
<link rel="stylesheet" href="{{asset('backend/vendors/font_awesome/css/all.min.css')}}?{{ $version }}"/>
<link rel="stylesheet" href="{{asset('backend/css/themify-icons.css')}}?{{ $version }}"/>
<link rel="stylesheet" href="{{asset('chat/css/style.css')}}?{{ $version }}">
<link rel="stylesheet" href="{{asset('css/preloader.css')}}?{{ $version }}"/>
@if (isModuleActive("WhatsappSupport"))
<link rel="stylesheet" href="{{asset('whatsapp-support/style.css')}}?{{ $version }}"/>
@endif
<link rel="stylesheet" href="{{asset('backend/css/app.css')}}?{{ $version }}">
@if(isRtl())
<link rel="stylesheet" href="{{asset('backend/css/backend_style_rtl.css')}}?{{ $version }}"/>
@else
<link rel="stylesheet" href="{{asset('backend/css/backend_style.css')}}?{{ $version }}"/>
@endif
@stack('styles')
