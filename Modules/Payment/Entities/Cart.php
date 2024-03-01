<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\CourseSetting\Entities\Course;
use Rennokki\QueryCache\Traits\QueryCacheable;
use App\User;

class Cart extends Model
{


    protected $fillable = ['course_id','user_id','price','instructor_id','tracking'];
    protected $guarded  = ['id'];

    public function course(){

        return $this->belongsTo(Course::class,'course_id','id');
    }

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

    public function instructor(){

        return $this->belongsTo(User::class,'instructor_id','id');
    }

    public function bundle(){

        return $this->belongsTo(BundleCoursePlan::class,'bundle_course_id','id');
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'tracking', 'tracking');
    }
}
