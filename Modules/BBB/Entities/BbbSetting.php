<?php

namespace Modules\BBB\Entities;

// use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BbbSetting extends Model
{
    // use Tenantable;
    protected static $flushCacheOnUpdate = true;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        // self::created(function ($model) {
        //     Cache::forget('BbbSetting_'.SaasDomain());
        // });
        // self::updated(function ($model) {
        //     Cache::forget('BbbSetting_'.SaasDomain());
        // });
        // self::deleted(function ($model) {
        //     Cache::forget('BbbSetting_'.SaasDomain());
        // });
    }

    public static function getData()
    {
        // return Cache::rememberForever('BbbSetting_' . SaasDomain(), function () {
        //     $setting = DB::table('bbb_settings')->where('lms_id', SaasInstitute()->id)->first();
        //     if (!$setting) {
                $setting = DB::table('bbb_settings')->first();
            // }
            return $setting;
        // });
    }
}
