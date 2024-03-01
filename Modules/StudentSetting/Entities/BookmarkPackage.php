<?php

namespace Modules\StudentSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Package;
use Modules\CourseSetting\Entities\Lession;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Carbon\Carbon;
use App\User;

class BookmarkPackage extends Model
{
    protected $fillable = [];

    protected $appends =['bookmarkDate'];

    public function package()
    {
    	return $this->belongsTo(Package::class)->withDefault();
    }

    public function user()
    {
    	return $this->belongsTo(User::class)->withDefault();
    }

    public function lesson()
    {
        return $this->belongsTo(Lession::class)->withDefault();
    }

    public function getbookmarkDateAttribute()
    {
        return Carbon::parse($this->created_at)->isoformat('Do MMMM Y');
    }
}
