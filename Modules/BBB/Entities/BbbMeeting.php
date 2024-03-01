<?php

namespace Modules\BBB\Entities;

// use App\Traits\Tenantable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;
use Modules\VirtualClass\Entities\VirtualClass;
use Rennokki\QueryCache\Traits\QueryCacheable;

class BbbMeeting extends Model
{
    // use Tenantable;

    protected static $flushCacheOnUpdate = true;

    protected $guarded = [];
    public function isRunning(){
        return Bigbluebutton::isMeetingRunning($this->meeting_id);
    }

    public function class()
    {
        return $this->belongsTo(VirtualClass::class, 'class_id')->withDefault();
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id')->withDefault();
    }
}
