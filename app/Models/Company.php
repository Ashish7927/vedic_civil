<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\CorporateManager;
use App\Models\SpnCity;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use App\City;

class Company extends Model
{
    use HasFactory;

    public function corporate_admin()
    {
        return $this->belongsTo(User::class, 'corporate_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'corporate_id', 'id');
    }

    public function managers()
    {
        return $this->hasMany(CorporateManager::class, 'corporate_id');
    }

    public function learners()
    {
        return $this->hasMany(User::class, 'corporate_id', 'id')->where('is_corporate_user', 1);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'corporate_id', 'id');
    }

    public function enrolls()
    {
        return $this->hasManyThrough(Course::class, CourseEnrolled::class);
    }

    public function businessNature(){
        return $this->belongsTo(BusinessActivities::class, 'business_activity_id', 'id');
    }

    public function states()
    {
        return $this->belongsTo(SpnCity::class, 'state', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'state');
    }

    //public function getNoOfEmployeesAttribute($type){
    //    if($type == 1)
    //        return '1-100 employees';
    //    if($type == 2)
    //        return '101-500 employees';
    //    if($type == 3)
    //        return '501-1000 employees';
    //    if($type == 4)
    //        return 'More than 1000 employees';
    //    return '';
    //}

    public function admins()
    {
        return $this->hasMany(CorporateAdmin::class, 'corporate_id');
    }
}
