@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'e-Latih LMS'}} | {{__('common.Dashboard')}} @endsection
@section('css')
    <link href="{{asset('public/frontend/elatihlmstheme/css/class_details.css')}}" rel="stylesheet"/>

@endsection

@section('mainContent')
    <x-my-dashboard-page-section/>
@endsection
@section('js')
    <script src="{{asset('public/frontend/elatihlmstheme/js/class_details.js')}}"></script>
    <script>
    $(document).ready(function(){

        var url = "{{ route('cp_data_with_ajax') }}";
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            success: function(result){
                console.log(result);
            }
        });

    });
</script>
@endsection

<?php 
    $user = Auth::user();
    $name = $user->name;
    $citizenship = $user->citizenship;
    $race = $user->race;
    $email = $user->email;
    $gender = $user->gender;
    $employment_status = $user->employment_status;
    $job_designation = $user->job_designation;
    $sector = $user->sector;
    $highest_academic = $user->highest_academic;
    $current_residing = $user->current_residing;
    $zip = $user->zip;
?>
<script> 

    let text = "";
    if("<?php echo $name; ?>" == ""){
        text += "Full Name\n";
    }
    if("<?php echo $citizenship; ?>" == ""){
        text += "Citizenship\n";
    }
    if("<?php echo $race; ?>" == ""){
        text += "Race\n";
    }
    if("<?php echo $email; ?>" == ""){
        text += "email\n";
    }
    if("<?php echo $gender; ?>" == ""){
        text += "gender\n";
    }
    if("<?php echo $employment_status; ?>" == ""){
        text += "employment_status\n";
    }
    if("<?php echo $job_designation; ?>" == ""){
        text += "job_designation\n";
    }
    if("<?php echo $sector; ?>" == ""){
        text += "sector\n";
    }
    if("<?php echo $highest_academic; ?>" == ""){
        text += "highest_academic\n";
    }
    if("<?php echo $current_residing; ?>" == ""){
        text += "current_residing\n";
    }
    if("<?php echo $zip; ?>" == ""){
        text += "zip\n";
    }
    if(text!=""){
        if (confirm("Please complete your profile!") == true) {
            window.location.replace("/my-profile");
        } 
    }


    //console.log(<?php //echo $user; ?>); 
</script>

