<?php

namespace Modules\BBB\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\BBB\Entities\BbbSetting;


class BbbSettingController extends Controller
{
    public function settings()
    {
        $setting = BbbSetting::getData();
        // $setting->security_salt     = saasEnv('BBB_SECURITY_SALT');
        // $setting->server_base_url   = saasEnv('BBB_SERVER_BASE_URL');
        $setting->security_salt     = env('BBB_SECURITY_SALT', '');
        $setting->server_base_url   = env('BBB_SERVER_BASE_URL', '');

        return view('bbb::settings', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $request->validate([
            'password_length' => 'required',
            'max_participants' => 'required',
            'record' => 'required',
            'duration' => 'required',
            'security_salt' => 'required',
            'server_base_url' => 'required',
        ]);

        try {
            BbbSetting::updateOrCreate([
                'lms_id' => SaasInstitute()->id,
            ], [
                'password_length'                           => $request->password_length,
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
            ]);

            $security_salt      = $request->security_salt;
            $server_base_url    = $request->server_base_url;

            SaasEnvSetting(SaasDomain(), 'BBB_SECURITY_SALT', $security_salt);
            SaasEnvSetting(SaasDomain(), 'BBB_SERVER_BASE_URL',  $server_base_url);

            Artisan::call('config:clear');
            Toastr::success('BBB Setting updated successfully !', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), trans('common.Failed'));
            return redirect()->back();
        }
    }
}
