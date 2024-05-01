@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('courses.Courses')}} @endsection
@section('css') @endsection

@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/classes.js')}}"></script>
@endsection
@section('mainContent')

<div>
    <div class="breadcrumb_area bradcam_bg_2" style="background-image: url('/public/frontend/elatihlmstheme/img/banner/banner_bookademo.jpg');background-size: auto 100%;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="breadcam_wrap">
                        <h3>
                        Get Corporate Access
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-image: url('/public/frontend/elatihlmstheme/img/banner/bookademo_body_bg.png');background-size: 100% 100%;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-10 offset-sm-1">
                <div class="mt_40 mb_40" style="text-align: center;">
                    <h1 class="h1">
                    Accelerate your talent development and business transformation with e-LATiH Corporate Access
                    </h1>
                </div>
            </div>
        </div>
        <div class="row align-items-center mb_40">
            <div class="col-lg-5 offset-sm-1">
                <ul class="ml-5">
                    <li class="mb-3"><img style="width: 20px;" src="/public/frontend/elatihlmstheme/img/banner/tic_icon.png"> FREE 1-month trial</li>
                    <li class="mb-3"><img style="width: 20px;" src="/public/frontend/elatihlmstheme/img/banner/tic_icon.png"> Learn anytime, anywhere from the world’s leading content providers</li>
                    <li class="mb-3"><img style="width: 20px;" src="/public/frontend/elatihlmstheme/img/banner/tic_icon.png"> Track, monitor, and manage the employees’ learning journey</li>
                </ul>
            </div>
            <div class="col-lg-5">
                <ul class="ml-5">
                    <li class="mb-3"><img style="width: 20px;" src="/public/frontend/elatihlmstheme/img/banner/tic_icon.png"> Full admin management and advanced reporting</li>
                    <li class="mb-3"><img style="width: 20px;" src="/public/frontend/elatihlmstheme/img/banner/tic_icon.png"> Curate and upload e-learning courses specifically for your organisation</li>
                    <li class="mb-3"><img style="width: 20px;" src="/public/frontend/elatihlmstheme/img/banner/tic_icon.png"> Integrated levy system for HRD Corp registered employers</li>
                </ul>
            </div>
        </div>
        <div class="" >
            <div class="col-lg-8 offset-sm-2 p-4" style="background-color:white; -moz-box-shadow: 0 0 3px #ccc; -webkit-box-shadow: 0 0 3px #ccc;box-shadow: 0 0 3px #ccc; border-radius: 3px;">
                <form action="{{route('saveAdemo')}}" method="post">
                @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input type="text" class="form-control" id="full_name" placeholder="Full Name" name="full_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email_address">Email Address</label>
                                <input type="email" class="form-control" id="email_address" placeholder="email@example.com" name="email_address" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" placeholder="+601 XXXX XXX" name="phone_number" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" class="form-control" id="company_name" placeholder="ABC Inc." name="company_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_registration_no">Company Registration No.</label>
                                <input type="text" class="form-control" id="company_registration_no" placeholder="XXXX XXXX XXXX" name="company_registration_no" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" id="location" placeholder="Select your location" name="location" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="industry">Industry</label>
                                <select class="form-control" id="industry" name="industry" required>
                                    <option>Select an industry</option>
                                    <option value="Accomodation/Food Beverage Service Activities">Accomodation/Food Beverage Service Activities</option>
                                    <option value="Agriculture/Forestry/Fishing">Agriculture/Forestry/Fishing</option>
                                    <option value="Arts/Entertainment/Recreation/Construction">Arts/Entertainment/Recreation/Construction</option>
                                    <option value="Education">Education</option>
                                    <option value="Electricity/Gas/Steam/Air conditioning Supply">Electricity/Gas/Steam/Air conditioning Supply</option>
                                    <option value="Financial/Insurance/Takaful activities">Financial/Insurance/Takaful activities</option>
                                    <option value="Human Health/Social Work Activities">Human Health/Social Work Activities</option>
                                    <option value="Information/Communication">Information/Communication</option>
                                    <option value="Manufacturing">Manufacturing</option>
                                    <option value="Mining/Quarrying">Mining/Quarrying</option>
                                    <option value="Professional/Scientific/Technical Activities">Professional/Scientific/Technical Activities</option>
                                    <option value="Public Administration/Defence/Compulsory Social Security">Public Administration/Defence/Compulsory Social Security</option>
                                    <option value="Real Estate Activities">Real Estate Activities</option>
                                    <option value="Transportation/Storage">Transportation/Storage</option>
                                    <option value="Water Supply/Sewage/Waste Management/Remediation Activities">Water Supply/Sewage/Waste Management/Remediation Activities</option>
                                    <option value="Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles">Wholesale/Retail Trade/Repair of Motor Vehicles/Motorcycles</option>
                                    <option value="Others">Others</option>

                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_of_employees">No. of Employees</label>
                                <input type="number" class="form-control" id="no_of_employees" placeholder="0" name="no_of_employees" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="hrd_corp">HRD Corp Registered Employers</label>
                            <div class="radio">
                            
                                <label><input type="radio" name="hrd_corp" value="Yes" checked> Yes</label>
                                <label><input type="radio" name="hrd_corp" value="No"> No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label><input type="checkbox" name="" checked required> By submitting your info in the form above, you agree to our Terms of Use and Privacy Policy. We may use this info to contact you and/or use the data to personalise your experience.</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn" style="background:#EF4D23; color:white;width:100%;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 offset-sm-4 mb-4 mt-4">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <a class="btn" style="color:#F15C33; border:1px solid #F15C33; width:100%" href="{{url('/')}}">Back to Homepage</a>
                    </div>
                    <div class="col-lg-6">
                        <a class="btn" style="color:#F15C33; border:1px solid #F15C33; width:100%" href="{{ route('corporate_access_page') }}">Learn More</a>
                    </div>
                </div>
            </div>
            
           
        </div>
    </div>
</div>

<div class="mt-5">
    <x-corporate-access-page-trusted-by-section :homeContent="$homeContent"/>
</div>
{{-- <div class="container-fluid" style="background-color:#F2F2F2;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-10 offset-sm-1"></div>
                <div class="mt_40">
                    <h1 class="h1">
                    Trusted by
                    </h13>
                </div>
            </div>
        </div>
        <div class="row align-items-center offset-sm-1 pb-4">
            
        @foreach($companies as $company)
        <div class="col-lg-3 mt_40">
                <img class="img" src="{{ $company->logo }}">
            </div>
        @endforeach
        
            <!-- <div class="col-lg-12 ml-5 mb_40">
                <img class="img" src="/public/frontend/elatihlmstheme/img/banner/image 21.png">
            </div>
             -->
        </div>
       
            
           
        </div>
    </div>
</div> --}}
@endsection