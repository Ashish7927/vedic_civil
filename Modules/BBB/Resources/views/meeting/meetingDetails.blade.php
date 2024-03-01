@extends('backend.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ __('bbb.Class') }} {{ __('bbb.Details') }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">{{ __('common.Dashboard') }}</a>
                    <a href="#">{{ __('bbb.Class') }}</a>
                    <a href="#">{{ __('bbb.Details') }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="mb-30"> {{ __('bbb.Topic') }}</h3>
                </div>
                <div class="col-md-2 pull-right  text-right">
                    @if (permissionCheck('bbb.meetings.edit'))
                        <a href="{{ route('bbb.meetings.edit', $localMeetingData->id) }}"
                            class="primary-btn small fix-gr-bg ">
                            <span class="ti-pencil-alt"></span>{{ __('bbb.Edit') }}
                        </a>
                    @endif
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="" class="display school-table school-table-style w-100">

                                <tr>
                                    <th>#</th>
                                    <th>{{ __('bbb.Name') }}</th>
                                    <th>{{ __('bbb.Status') }}</th>
                                </tr>

                                <tr>
                                    <td> @php $sl = 1 @endphp {{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Topic') }}</td>
                                    <td>{{ $localMeetingData->topic }}</td>
                                </tr>

                                <tr>
                                    <td> @php $sl = 1 @endphp {{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('common.Price') }}</td>
                                    <td>{{ getPriceFormat($localMeetingData->price) }}</td>
                                </tr>

                                <tr>
                                    <td> {{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Start Date Time') }} </td>
                                    <td>{{ $localMeetingData->date }} {{ $localMeetingData->time }}</td>
                                </tr>
                                <tr>
                                    <td> {{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Class Id') }} </td>
                                    <td>{{ $localMeetingData->meeting_id }}</td>
                                </tr>
                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Attendee Password') }}</td>
                                    <td>{{ $localMeetingData->attendee_password }}</td>
                                </tr>
                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Moderator Password') }}</td>
                                    <td>{{ $localMeetingData->moderator_password }}</td>
                                </tr>

                                @if ($localMeetingData->status == 1)
                                    <tr>
                                        <td>{{ $sl++ }} </td>
                                        <td class="propertiesname"> {{ __('bbb.Moderator Join') }} </td>
                                        <td>
                                            <form action="{{ route('bbb.meetingStart') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="meetingID"
                                                    value="{{ $localMeetingData->meeting_id }}">
                                                <input type="hidden" name="type" value="Moderator">
                                                <button type="submit" class="btn btn-primary">Join</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ $sl++ }} </td>
                                        <td class="propertiesname"> {{ __('bbb.Attendee Join') }} </td>
                                        <td>
                                            <form action="{{ route('bbb.meetingStart') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="meetingID"
                                                    value="{{ $localMeetingData->meeting_id }}">
                                                <input type="hidden" name="type" value="Attendee">
                                                <button type="submit" class="btn btn-primary">Join</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Welcome Message') }} </td>
                                    <td>{{ @$localMeetingData->welcome_message }}</td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Dial Number') }} </td>
                                    <td>{{ @$localMeetingData->dial_number }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Max Participants') }} </td>
                                    <td>{{ @$localMeetingData->max_participants }}</td>
                                </tr>
                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Logout Url') }} </td>
                                    <td>{{ @$localMeetingData->logout_url }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Duration') }} </td>
                                    <td>{{ @$localMeetingData->duration }}</td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Record') }} </td>
                                    <td>{{ @$localMeetingData->record == false ? 'False' : 'True' }}</td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Is Breakout') }} </td>
                                    <td>{{ @$localMeetingData->is_breakout == false ? 'False' : 'True' }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Moderator Only Message') }} </td>
                                    <td>{{ @$localMeetingData->moderator_only_message == false ? 'False' : 'True' }}</td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Auto Start Recording') }} </td>
                                    <td>{{ @$localMeetingData->auto_start_recording == false ? 'False' : 'True' }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Allow Start Stop Recording') }} </td>
                                    <td>{{ @$localMeetingData->allow_start_stop_recording == false ? 'False' : 'True' }}</td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Webcams Only For moderator') }} </td>
                                    <td>{{ @$localMeetingData->webcams_only_ror_moderator == false ? 'False' : 'True' }}</td>
                                </tr>
                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Copyright') }} </td>
                                    <td>{{ @$localMeetingData->copyright }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Mute On Start') }} </td>
                                    <td>{{ @$localMeetingData->mute_on_start == false ? 'False' : 'True' }}</td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Webcams Only For Moderator') }} </td>
                                    <td>{{ @$localMeetingData->webcams_only_for_moderator == false ? 'False' : 'True' }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Disable Cam') }} </td>
                                    <td>{{ @$localMeetingData->lock_settings_disable_cam == false ? 'False' : 'True' }}</td>
                                </tr>
                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Disable Mic') }} </td>
                                    <td>{{ @$localMeetingData->lock_settings_disable_mic == false ? 'False' : 'True' }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Lock On Join') }} </td>
                                    <td>{{ @$localMeetingData->lock_settings_lock_on_join == false ? 'False' : 'True' }}</td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Lock On Join Configurable') }}
                                    </td>
                                    <td>{{ @$localMeetingData->lock_settings_lock_on_join_configurable == false ? 'False' : 'True' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Join Via Html 5') }} </td>
                                    <td>{{ @$localMeetingData->join_via_html5 == false ? 'False' : 'True' }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Disable Private Chat') }} </td>
                                    <td>{{ @$localMeetingData->lock_settings_disable_private_chat == false ? 'False' : 'True' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Disable Public Chat') }} </td>
                                    <td>{{ @$localMeetingData->lock_settings_disable_public_chat == false ? 'False' : 'True' }}
                                    </td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Disable Note') }} </td>
                                    <td>{{ @$localMeetingData->lock_settings_disable_note == false ? 'False' : 'True' }}</td>
                                </tr>


                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Locked Layout') }} </td>
                                    <td>{{ @$localMeetingData->lock_settings_locked_layout == false ? 'False' : 'True' }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Lock On Join') }} </td>
                                    <td>{{ @$localMeetingData->lock_settings_lock_on_oin == false ? 'False' : 'True' }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Lock Settings Sock On Join Configurable') }}
                                    </td>
                                    <td>{{ @$localMeetingData->lock_settings_sock_on_join_configurable == false ? 'False' : 'True' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Guest Policy') }} </td>
                                    <td>{{ @$localMeetingData->guest_policy }}</td>
                                </tr>

                                <tr>
                                    <td>{{ $sl++ }} </td>
                                    <td class="propertiesname">{{ __('bbb.Redirect') }} </td>
                                    <td>{{ @$localMeetingData->redirect == false ? 'False' : 'True' }}</td>
                                </tr>

                                @if ($localMeetingData->status == 2)
                                    <tr>
                                        <td>{{ $sl++ }} </td>
                                        <td class="propertiesname">{{ __('bbb.Admin Review') }} </td>
                                        <td>{{ $localMeetingData->admin_review }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
