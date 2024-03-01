{{-- <div class="@if (isset($editdata)) col-lg-9 @else  col-lg-12  @endif"> --}}
<div class="@if (permissionCheck('bbb.meetings.store')) col-lg-9 @else  col-lg-12 @endif">
    <div class="main-title">
        <h3 class="mb-20">{{ __('bbb.Class') }} {{ __('bbb.List') }}</h3>
    </div>

    <div class="QA_section QA_section_heading_custom check_box_table">
        <div class="QA_table">
            <div class="">
                <table id="lms_table" class="table Crm_table_active3">
                    <thead>
                        <tr>
                        <tr>
                            <th>{{ __('common.SL') }}</th>
                            <th> {{ __('bbb.ID') }}</th>
                            <th> {{ __('zoom.Class') }}</th>
                            @if (!isTrainer(Auth::user()))
                                <th> {{ __('zoom.Instructor') }}</th>
                            @endif
                            <th> {{ __('bbb.Topic') }}</th>
                            <th> {{ __('common.Price') }}</th>
                            <th> {{ __('bbb.Date') }}</th>
                            <th> {{ __('bbb.Time') }}</th>
                            <th> {{ __('bbb.Duration') }}</th>
                            <th> {{ __('bbb.Join as Moderator') }}</th>
                            <th> {{ __('bbb.Join as Attendee') }}</th>
                            <th> {{ __('common.Status') }}</th>
                            <th> {{ __('bbb.Admin Review') }}</th>
                            <th>{{ __('bbb.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
