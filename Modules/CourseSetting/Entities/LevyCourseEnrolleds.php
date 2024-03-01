<?php

namespace Modules\CourseSetting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\Checkout;

class LevyCourseEnrolleds extends Model
{
    protected $table = 'levy_course_enrolleds';

    protected $fillable = ['user_id', 'course_id', 'purchase_price'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'tracking', 'tracking')->withDefault();
    }

}
