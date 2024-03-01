<div class="modal-dialog modal_1000px modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('courses.Course Statistics')}}</h4>
            <button type="button" class="close " data-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>

        <div class="modal-body">
                <h3 class="text-center">{{$course->title}}</h3>
                <hr>

        <div class="row mt-20 white-box" style="max-height: 500px; overflow:auto">
                @foreach ($course->enrolls as $key => $enroll)
                    <div class="col-lg-12 mt-2 d-flex">
                            @php
                                $percentage=round($course->userTotalPercentage($enroll->user_id,$enroll->course_id));
                                if ($percentage < 100) {
                                    $status='Fail';
                                } else {
                                    $status='Pass';
                                }
                            @endphp
                                <div class="col-lg-2">
                                    {{$key+1}}
                                </div>
                                <div class="col-lg-6">
                                    {{$enroll->user->name}}
                                </div>
                                <div class="col-lg-4">

                                    <button class="primary-btn radius_30px mr-10 fix-gr-bg" > {{$status}}</button>
                                </div>
                    </div>
                    @endforeach


        </div>

        <div class="col-lg-12 text-center pt_15">
            <div class="d-flex justify-content-center">
                <button class="primary-btn semi_large2  fix-gr-bg" data-dismiss="modal"
                        type="button"><i
                        class="ti-check"></i> {{__('common.Close')}}
                </button>
            </div>
        </div>
        </div>
    </div>
</div>