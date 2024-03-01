<?php

namespace Modules\Role\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Role extends Model
{


    protected $guarded = ['id'];

    public function user()
    {
    	return $this->belongsTo(User::class)->withDefault();
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('Roles');
        });
        self::updated(function ($model) {
            Cache::forget('Roles');
        });
        self::deleted(function ($model) {
            Cache::forget('Roles');
        });
    }
}
