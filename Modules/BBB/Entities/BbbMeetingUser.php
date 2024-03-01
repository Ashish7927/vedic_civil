<?php

namespace Modules\BBB\Entities;

// use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class BbbMeetingUser extends Model
{
    // use Tenantable;

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [];
}
