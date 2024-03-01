<?php

namespace Modules\BBB\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;
use Modules\CourseSetting\Entities\Course;
use Modules\VirtualClass\Entities\VirtualClass;
use Modules\BBB\Entities\BbbMeeting;
use Modules\BBB\Entities\BbbMeetingUser;
use Modules\BBB\Entities\BbbSetting;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\User;

class BbbMeetingController extends Controller
{
    public function __construct()
    {
        Artisan::call('config:clear');
    }

    public function index()
    {
        $data['setting']    = BbbSetting::getData();
        $data['user']       = Auth::user();

        $instructors = User::select('id', 'name')->where('role_id', 14);

        if (check_whether_cp_or_not() || isPartner()) {
            $instructors = $instructors->where('cp_id', Auth::id());
        }

        $instructors = $instructors->get();

        $data['instructors']    = $instructors;
        $data['classes']        = VirtualClass::select('id', 'title')->where('host', 'BBB')->latest()->get();

        // $data['env']['security_salt']   = saasEnv('BBB_SECURITY_SALT');
        // $data['env']['server_base_url'] = saasEnv('BBB_SERVER_BASE_URL');

        $data['env']['security_salt']   = env('BBB_SECURITY_SALT', '');
        $data['env']['server_base_url'] = env('BBB_SERVER_BASE_URL', '');

        return view('bbb::meeting.meeting', $data);
    }

    public function datatable() {
        $query = BbbMeeting::with('class', 'instructor')->orderBy('id', 'DESC');

        if (check_whether_cp_or_not() || isPartner()) {
            $query = $query->where('created_by', Auth::id());
        }

        if (isTrainer(Auth::user())) {
            $query = $query->where('instructor_id', Auth::id());
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('price', function ($query) {
                return ($query->price != null) ? getPriceFormat($query->price) : '';
            })
            ->addColumn('class_title', function ($query) {
                return ($query->class) ? $query->class->title : '';
            })
            ->addColumn('instructor', function ($query) {
                return ($query->instructor) ? $query->instructor->name : '';
            })
            ->editColumn('duration', function ($query) {
                return ($query->duration == 0) ? 'Unlimited Min' : $query->duration.' Min';
            })
            ->addColumn('join_as_moderator', function ($query) {
                $join_as_moderator = '';

                if ($query->status == 1) {
                    $join_as_moderator = '<form action="'.route('bbb.meetingStart').'" method="post">
                        '.csrf_field().'
                        <input type="hidden" name="meetingID" value="'.$query->meeting_id.'">
                        <input type="hidden" name="type" value="Moderator">
                        <button type="submit" class="primary-btn small fix-gr-bg">Join as Moderator</button>
                    </form>';
                }

                return $join_as_moderator;
            })
            ->addColumn('join_as_attendee', function ($query) {
                $join_as_attendee = '';

                if ($query->status == 1) {
                    $join_as_attendee = '<form action="'.route('bbb.meetingStart').'" method="post">
                        '.csrf_field().'
                        <input type="hidden" name="meetingID" value="'.$query->meeting_id.'">
                        <input type="hidden" name="type" value="Attendee">
                        <button type="submit" class="primary-btn small fix-gr-bg">Join as
                            Attendee</button>
                    </form>';
                }

                return $join_as_attendee;
            })
            ->addColumn('status', function ($query) {
                if ($query->status == 0) {
                    $status = '<span class="badge badge-warning">In Review</span>';
                } elseif ($query->status == 1) {
                    $status = '<span class="badge badge-success">Approved</span>';
                } elseif ($query->status == 2) {
                    $status = '<span class="badge badge-danger">Rejected</span>';
                }

                return $status;
            })
            ->editColumn('admin_review', function ($query) {
                $admin_review = '';

                if ($query->status == 2) {
                    $admin_review = $query->admin_review;
                }

                return $admin_review;
            })
            ->addColumn('action', function ($query) {
                $view = '';
                if (permissionCheck('bbb.meetings.index')) {
                    $view = '<a class="dropdown-item" href="'.route('bbb.meetings.show', $query->id).'">'.__('bbb.View').'</a>';
                }

                $edit = '';
                if (permissionCheck('bbb.meetings.edit')) {
                    $edit = '<a class="dropdown-item" href="'.route('bbb.meetings.edit', $query->id).'">'.__('bbb.Edit').'</a>';
                }

                $delete = '';
                if (permissionCheck('bbb.meetings.destroy')) {
                    $delete = '<a class="dropdown-item" data-toggle="modal" data-target="#d'.$query->id.'" href="#">'.__('bbb.Delete').'</a>';
                }

                $approve_reject = '';
                if (isAdmin()) {
                    if ($query->status == 0) {
                        $approve_reject = '<a onclick="approve_meeting_modal('.$query->id.')" class="dropdown-item">'.trans('bbb.Approve Meeting').'</a>

                        <a onclick="reject_meeting_modal('.$query->id.')" class="dropdown-item">'.trans('bbb.Reject Meeting').'</a>';
                    }
                }

                $actioinView = '<div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                                    ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                        ' . $view . '
                                        ' . $edit . '
                                        ' . $delete . '
                                        ' . $approve_reject . '
                                    </div>
                                </div>';

                return $actioinView;
            })
            ->rawColumns(['join_as_moderator', 'join_as_attendee', 'status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'instructor_id'         => 'required',
            'class_id'              => 'required',
            'topic'                 => 'required',
            'attendee_password'     => 'required',
            'moderator_password'    => 'required',
            'date'                  => 'required',
            'time'                  => 'required',
            'price'                 => 'required',
        ]);

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $createMeeting = Bigbluebutton::create([
                'meetingID'                             => "spn-" . date('ymd' . rand(0, 100)),
                'meetingName'                           => $request->topic,
                'attendeePW'                            => $request->attendee_password,
                'moderatorPW'                           => $request->moderator_password,
                'welcomeMessage'                        => $request->welcome_message,
                'dialNumber'                            => $request->dial_number,
                'maxParticipants'                       => $request->max_participants,
                'logoutUrl'                             => $request->logout_url,
                'record'                                => $request->record,
                'duration'                              => $request->duration,
                'isBreakout'                            => $request->is_breakout,
                'moderatorOnlyMessage'                  => $request->moderator_only_message,
                'autoStartRecording'                    => $request->auto_start_recording,
                'allowStartStopRecording'               => $request->allow_start_stop_recording,
                'webcamsOnlyForModerator'               => $request->webcams_only_for_moderator,
                'copyright'                             => $request->copyright,
                'muteOnStart'                           => $request->mute_on_start,
                'lockSettingsDisableMic'                => $request->lock_settings_disable_mic,
                'lockSettingsDisablePrivateChat'        => $request->lock_settings_disable_private_chat,
                'lockSettingsDisablePublicChat'         => $request->lock_settings_disable_public_chat,
                'lockSettingsDisableNote'               => $request->lock_settings_disable_note,
                'lockSettingsLockedLayout'              => $request->lock_settings_locked_layout,
                'lockSettingsLockOnJoin'                => $request->lock_settings_lock_on_join,
                'lockSettingsLockOnJoinConfigurable'    => $request->lock_settings_lock_on_join_configurable,
                'guestPolicy'                           => $request->guest_policy,
                'redirect'                              => $request->redirect,
                'joinViaHtml5'                          => $request->join_via_html5,
                'state'                                 => $request->state,
            ]);

            if ($createMeeting) {
                $local_meeting = BbbMeeting::create([
                    'meeting_id'                                => $createMeeting['meetingID'],
                    'instructor_id'                             => $request->instructor_id,
                    'class_id'                                  => $request->class_id,
                    'topic'                                     => $request->topic,
                    'slug'                                      => Str::slug($request->topic, '-'),
                    'attendee_password'                         => $request->attendee_password,
                    'moderator_password'                        => $request->moderator_password,
                    'date'                                      => $request->date,
                    'time'                                      => $request->time,
                    'price'                                     => $request->price,
                    'datetime'                                  => strtotime($request->date . " " . $request->time),
                    'welcome_message'                           => $request->welcome_message,
                    'dial_number'                               => $request->dial_number,
                    'max_participants'                          => $request->max_participants,
                    'logout_url'                                => $request->logout_url,
                    'record'                                    => $request->record,
                    'duration'                                  => $request->duration,
                    'is_breakout'                               => $request->is_breakout,
                    'moderator_only_message'                    => $request->moderator_only_message,
                    'auto_start_recording'                      => $request->auto_start_recording,
                    'allow_start_stop_recording'                => $request->allow_start_stop_recording,
                    'webcams_only_for_moderator'                => $request->webcams_only_for_moderator,
                    'copyright'                                 => $request->copyright,
                    'mute_on_start'                             => $request->mute_on_start,
                    'lock_settings_disable_mic'                 => $request->lock_settings_disable_mic,
                    'lock_settings_disable_private_chat'        => $request->lock_settings_disable_private_chat,
                    'lock_settings_disable_public_chat'         => $request->lock_settings_disable_public_chat,
                    'lock_settings_disable_note'                => $request->lock_settings_disable_note,
                    'lock_settings_locked_layout'               => $request->lock_settings_locked_layout,
                    'lock_settings_lock_on_join'                => $request->lock_settings_lock_on_join,
                    'lock_settings_lock_on_join_configurable'   => $request->lock_settings_lock_on_join_configurable,
                    'guest_policy'                              => $request->guest_policy,
                    'redirect'                                  => $request->redirect,
                    'join_via_html5'                            => $request->join_via_html5,
                    'state'                                     => $request->state,
                    'created_by'                                => Auth::user()->id,
                ]);

                if ($local_meeting) {
                    $user               = new BbbMeetingUser();
                    $user->meeting_id   = $local_meeting->id;
                    $user->user_id      = $request->instructor_id;
                    $user->moderator    = 1;
                    $user->save();
                }
            }

            Toastr::success('Class created successful', 'Success');
            return redirect()->route('bbb.meetings');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function classStore($data)
    {
        try {
            $createMeeting = Bigbluebutton::create([
                'meetingID'                             => "spn-" . date('ymd' . rand(0, 100)),
                'meetingName'                           => $data['topic'],
                'attendeePW'                            => $data['attendee_password'],
                'moderatorPW'                           => $data['moderator_password'],
                'welcomeMessage'                        => $data['welcome_message'],
                'dialNumber'                            => $data['dial_number'],
                'maxParticipants'                       => $data['max_participants'],
                'logoutUrl'                             => $data['logout_url'],
                'record'                                => $data['record'],
                'duration'                              => $data['duration'],
                'isBreakout'                            => $data['is_breakout'],
                'moderatorOnlyMessage'                  => $data['moderator_only_message'],
                'autoStartRecording'                    => $data['auto_start_recording'],
                'allowStartStopRecording'               => $data['allow_start_stop_recording'],
                'webcamsOnlyForModerator'               => $data['webcams_only_for_moderator'],
                'copyright'                             => $data['copyright'],
                'muteOnStart'                           => $data['mute_on_start'],
                'lockSettingsDisableMic'                => $data['lock_settings_disable_mic'],
                'lockSettingsDisablePrivateChat'        => $data['lock_settings_disable_private_chat'],
                'lockSettingsDisablePublicChat'         => $data['lock_settings_disable_public_chat'],
                'lockSettingsDisableNote'               => $data['lock_settings_disable_note'],
                'lockSettingsLockedLayout'              => $data['lock_settings_locked_layout'],
                'lockSettingsLockOnJoin'                => $data['lock_settings_lock_on_join'],
                'lockSettingsLockOnJoinConfigurable'    => $data['lock_settings_lock_on_join_configurable'],
                'guestPolicy'                           => $data['guest_policy'],
                'redirect'                              => $data['redirect'],
                'joinViaHtml5'                          => $data['join_via_html5'],
                'state'                                 => $data['state'],
            ]);

            if ($createMeeting) {
                $local_meeting = BbbMeeting::create([
                    'meeting_id'                                => $createMeeting['meetingID'],
                    'instructor_id'                             => $data['instructor_id'],
                    'class_id'                                  => $data['class_id'],
                    'topic'                                     => $data['topic'],
                    'attendee_password'                         => $data['attendee_password'],
                    'moderator_password'                        => $data['moderator_password'],
                    'date'                                      => $data['date'],
                    'time'                                      => $data['time'],
                    'datetime'                                  => $data['datetime'],
                    'welcome_message'                           => $data['welcome_message'],
                    'dial_number'                               => $data['dial_number'],
                    'max_participants'                          => $data['max_participants'],
                    'logout_url'                                => $data['logout_url'],
                    'record'                                    => $data['record'],
                    'duration'                                  => $data['duration'],
                    'is_breakout'                               => $data['is_breakout'],
                    'moderator_only_message'                    => $data['moderator_only_message'],
                    'auto_start_recording'                      => $data['auto_start_recording'],
                    'allow_start_stop_recording'                => $data['allow_start_stop_recording'],
                    'webcams_only_for_moderator'                => $data['webcams_only_for_moderator'],
                    'copyright'                                 => $data['copyright'],
                    'mute_on_start'                             => $data['mute_on_start'],
                    'lock_settings_disable_mic'                 => $data['lock_settings_disable_mic'],
                    'lock_settings_disable_private_chat'        => $data['lock_settings_disable_private_chat'],
                    'lock_settings_disable_public_chat'         => $data['lock_settings_disable_public_chat'],
                    'lock_settings_disable_note'                => $data['lock_settings_disable_note'],
                    'lock_settings_locked_layout'               => $data['lock_settings_locked_layout'],
                    'lock_settings_lock_on_join'                => $data['lock_settings_lock_on_join'],
                    'lock_settings_lock_on_join_configurable'   => $data['lock_settings_lock_on_join_configurable'],
                    'guest_policy'                              => $data['guest_policy'],
                    'redirect'                                  => $data['redirect'],
                    'join_via_html5'                            => $data['join_via_html5'],
                    'state'                                     => $data['state'],
                    'created_by'                                => Auth::user()->id,
                ]);
            }

            $user               = new BbbMeetingUser();
            $user->meeting_id   = $local_meeting->id;
            $user->user_id      = $data['instructor_id'];
            $user->moderator    = 1;
            $user->save();

            if ($local_meeting) {
                $result['message']  = '';
                $result['type']     = true;

                return $result;
            } else {
                $result['message']  = '';
                $result['type']     = false;
            }
        } catch (\Exception $e) {
            $result['message']  = $e->getMessage();
            $result['type']     = false;

            return $result;
        }
    }

    public function show(int $id)
    {
        $localMeetingData = BbbMeeting::findOrFail($id);
        return view('bbb::meeting.meetingDetails', compact('localMeetingData'));
    }

    public function edit(int $id)
    {
        $data['setting']                = BbbSetting::getData();
        $data['user']                   = Auth::user();
        $data['editdata']               = BbbMeeting::findOrFail($id);

        $instructors        = User::select('id', 'name')->where('role_id', 14);

        if (check_whether_cp_or_not() || isPartner()) {
            $instructors    = $instructors->where('cp_id', Auth::id());
        }

        $instructors            = $instructors->get();
        $data['instructors']    = $instructors;

        $data['classes']                = VirtualClass::select('id', 'title')->where('host', 'BBB')->latest()->get();
        // $data['env']['security_salt']   = saasEnv('BBB_SECURITY_SALT');
        // $data['env']['server_base_url'] = saasEnv('BBB_SERVER_BASE_URL');
        $data['env']['security_salt']   = env('BBB_SECURITY_SALT', '');
        $data['env']['server_base_url'] = env('BBB_SERVER_BASE_URL', '');

        return view('bbb::meeting.meeting', $data);
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'topic'             => 'required',
                'instructor_id'     => 'required',
                'class_id'          => 'required',
                'attendee_password' => 'required',
                'date'              => 'required',
                'time'              => 'required',
                'price'             => 'required',
            ]);

            BbbMeeting::updateOrCreate([
                'id'    => $id
            ], [
                'topic'                                     => $request->topic,
                'slug'                                      => Str::slug($request->topic, '-'),
                'attendee_password'                         => $request->attendee_password,
                'moderator_password'                        => $request->moderator_password,
                'date'                                      => $request->date,
                'time'                                      => $request->time,
                'price'                                     => $request->price,
                'instructor_id'                             => $request->instructor_id,
                'class_id'                                  => $request->class_id,
                'datetime'                                  => strtotime($request->date." ".$request->time),
                'welcome_message'                           => $request->welcome_message,
                'dial_number'                               => $request->dial_number,
                'max_participants'                          => $request->max_participants,
                'logout_url'                                => $request->logout_url,
                'record'                                    => $request->record,
                'is_breakout'                               => $request->is_breakout,
                'moderator_only_message'                    => $request->moderator_only_message,
                'auto_start_recording'                      => $request->auto_start_recording,
                'allow_start_stop_recording'                => $request->allow_start_stop_recording,
                'webcams_only_for_moderator'                => $request->webcams_only_for_moderator,
                'copyright'                                 => $request->copyright,
                'mute_on_start'                             => $request->mute_on_start,
                'lock_settings_disable_mic'                 => $request->lock_settings_disable_mic,
                'lock_settings_disable_private_chat'        => $request->lock_settings_disable_private_chat,
                'lock_settings_disable_public_chat'         => $request->lock_settings_disable_public_chat,
                'lock_settings_disable_note'                => $request->lock_settings_disable_note,
                'lock_settings_locked_layout'               => $request->lock_settings_locked_layout,
                'lock_settings_lock_on_join'                => $request->lock_settings_lock_on_join,
                'lock_settings_lock_on_join_configurable'   => $request->lock_settings_lock_on_join_configurable,
                'guest_policy'                              => $request->guest_policy,
                'redirect'                                  => $request->redirect,
                'join_via_html5'                            => $request->join_via_html5,
                'state'                                     => $request->state,
            ]);

            Toastr::success('Class updated successful', 'Success');
            return redirect()->route('bbb.meetings');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Error');
            return redirect()->route('bbb.meetings');
        }
    }


    public function destroy(int $id)
    {
        $meeting = BbbMeeting::findOrFail($id);

        Bigbluebutton::close(['meetingId' => $meeting->meeting_id]);
        BbbMeetingUser::where('meeting_id', $meeting->id)->delete();

        $meeting->delete();

        Toastr::success('Class Delete successful', 'Success');
        return redirect()->route('bbb.meetings');
    }

    public function meetingStart(Request $request)
    {
        $request->validate([
            'type'      => 'required',
            'meetingID' => 'required',
        ]);

        $type       = $request->type;
        $meetingID  = $request->meetingID;

        $meeting = Bigbluebutton::getMeetingInfo([
            'meetingID' => $meetingID,
        ]);

        $localBbbMeeting = BbbMeeting::where('meeting_id', $request->meetingID)->first();

        if (count($meeting) == 0) {
            Bigbluebutton::create([
                'meetingID'                             => $localBbbMeeting->meeting_id,
                'meetingName'                           => $localBbbMeeting->topic,
                'attendeePW'                            => $localBbbMeeting->attendee_password,
                'moderatorPW'                           => $localBbbMeeting->moderator_password,
                'welcomeMessage'                        => $localBbbMeeting->welcome_message,
                'dialNumber'                            => $localBbbMeeting->dial_number,
                'maxParticipants'                       => $localBbbMeeting->max_participants,
                'logoutUrl'                             => $localBbbMeeting->logout_url,
                'record'                                => $localBbbMeeting->record,
                'duration'                              => $localBbbMeeting->duration,
                'isBreakout'                            => $localBbbMeeting->is_breakout,
                'moderatorOnlyMessage'                  => $localBbbMeeting->moderator_only_message,
                'autoStartRecording'                    => $localBbbMeeting->auto_start_recording,
                'allowStartStopRecording'               => $localBbbMeeting->allow_start_stop_recording,
                'webcamsOnlyForModerator'               => $localBbbMeeting->webcams_only_for_moderator,
                'copyright'                             => $localBbbMeeting->copyright,
                'muteOnStart'                           => $localBbbMeeting->mute_on_start,
                'lockSettingsDisableMic'                => $localBbbMeeting->lock_settings_disable_mic,
                'lockSettingsDisablePrivateChat'        => $localBbbMeeting->lock_settings_disable_private_chat,
                'lockSettingsDisablePublicChat'         => $localBbbMeeting->lock_settings_disable_public_chat,
                'lockSettingsDisableNote'               => $localBbbMeeting->lock_settings_disable_note,
                'lockSettingsLockedLayout'              => $localBbbMeeting->lock_settings_locked_layout,
                'lockSettingsLockOnJoin'                => $localBbbMeeting->lock_settings_lock_on_join,
                'lockSettingsLockOnJoinConfigurable'    => $localBbbMeeting->lock_settings_lock_on_join_configurable,
                'guestPolicy'                           => $localBbbMeeting->guest_policy,
                'redirect'                              => $localBbbMeeting->redirect,
                'joinViaHtml5'                          => $localBbbMeeting->join_via_html5,
                'state'                                 => $localBbbMeeting->state,
            ]);

            $meeting = Bigbluebutton::getMeetingInfo([
                'meetingID' => $meetingID,
            ]);
        }

        if ($type == "Moderator") {
            $url = Bigbluebutton::start([
                'meetingID' => $meetingID,
                'password'  => $meeting['moderatorPW'],
                'userName'  => Auth::user()->name,
            ]);
        } else {
            $url = Bigbluebutton::start([
                'meetingID' => $meetingID,
                'password'  => $meeting['attendeePW'],
                'userName'  => Auth::user()->name,
            ]);
        }

        return redirect()->to($url);
    }

    public function meetingStartAsAttendee($course_id, $meeting_id)
    {
        $course = Course::find($course_id);

        if (Auth::check() && $course->isLoginUserEnrolled) {
            Bigbluebutton::getMeetingInfo([
                'meetingID' => $meeting_id,
            ]);

            $localBbbMeeting = BbbMeeting::where('meeting_id', $meeting_id)->first();

            if (!$localBbbMeeting->isRunning()) {
                Toastr::error('Class Not Running', 'Failed');
                return redirect()->back();
            }

            $url = Bigbluebutton::start([
                'meetingID' => $meeting_id,
                'password'  => $localBbbMeeting->attendee_password,
                'userName'  => Auth::user()->name,
            ]);

            return redirect()->to($url);
        } else {
            Toastr::error('Access Failed!', 'Failed');
            return redirect()->back();
        }
    }

    public function recordList($meeting_id)
    {
        try {
            $meeting = BbbMeeting::findOrFail($meeting_id);

            $recorList = Bigbluebutton::getRecordings([
                'meetingID' => $meeting->meeting_id ?? '0'
            ]);

            return view('bbb::meeting.class_record_list', compact('recorList'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function approve_meeting(Request $request) {
        try {
            $meeting = BbbMeeting::where('id', $request->meeting_id)->first();

            if ($meeting) {
                $meeting->status = 1;

                if ($meeting->save()) {
                    $apiToken   = \Config::get('app.bbb_secret');
                    $headers    = ['Authorization'=> 'Bearer '.$apiToken];

                    $data = [
                        'name'                              => $meeting->topic,
                        'anyToStartSession'                 => false,
                        'joinAsModerator'                   => false,
                        'logo'                              => asset('assets/course/no_image.png'),
                        'record'                            => $meeting->record,
                        'muteOnStart'                       => $meeting->mute_on_start,
                        'welcomeMessage'                    => $meeting->welcome_message,
                        'allowModsToUnmuteUsers'            => true,
                        'wallpaper'                         => asset('assets/course/no_image.png'),
                        'logoutUrl'                         => $meeting->logout_url,
                        'darkColor'                         => "#0080FF",
                        'lightColor'                        => "#7BDEFF",
                        'primaryColor'                      => "#002C9B",
                        'meetingLayout'                     => 'SMART_LAYOUT',
                        'lockSettingsDisablePrivateChat'    => $meeting->lock_settings_disable_private_chat,
                        'requireModeratorApproval'          => false,
                        'autoJoin'                          => true
                    ];

                    $bbbCreateClassApiURL           = \Config::get('app.bbb_create_class_api_url');
                    $bbbCreateClassApiResponse      = Http::withHeaders($headers)->post($bbbCreateClassApiURL, $data);
                    $bbbCreateClassApiStatusCode    = $bbbCreateClassApiResponse->status();

                    if ($bbbCreateClassApiStatusCode != 200) {
                        $bbbCreateClassApiResponseBody  = json_decode($bbbCreateClassApiResponse->getBody(), true);
                        $bbbCreateClassApiStatusData    = $bbbCreateClassApiResponseBody['body'];

                        Toastr::error($bbbCreateClassApiStatusData['statusMsg'], 'Error');
                        return redirect()->route('bbb.meetings');
                    }

                    $user = User::where('id', $meeting->created_by)->first();
                    send_email($user, 'send_meeting_approve_mail', [
                        'meeting_id' => $meeting->meeting_id,
                        'topic' => $meeting->topic,
                        'date' => date('d/m/Y', strtotime($meeting->date)).' '.$meeting->time
                    ]);

                    $response['success'] = true;
                    $response['message'] = 'Meeting Approved Successfully.';
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Meeting not found.';
            }

            return response()->json($response);
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function reject_meeting(Request $request) {
        try {
            $meeting = BbbMeeting::where('id', $request->meeting_id)->first();

            if ($meeting) {
                $meeting->status = 2;
                $meeting->admin_review = $request->review;

                if ($meeting->save()) {
                    $user = User::where('id', $meeting->created_by)->first();
                    send_email($user, 'send_meeting_reject_mail', [
                        'meeting_id' => $meeting->meeting_id,
                        'topic' => $meeting->topic,
                        'admin_review' => $meeting->admin_review,
                        'date' => date('d/m/Y', strtotime($meeting->date)).' '.$meeting->time
                    ]);

                    $response['success'] = true;
                    $response['message'] = 'Meeting Rejected Successfully.';
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Meeting not found.';
            }

            return response()->json($response);
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();

            return response()->json($response);
        }
    }
}
