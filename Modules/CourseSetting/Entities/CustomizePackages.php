<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class CustomizePackages extends Model
{
    protected $fillable = ['id','cpa_id','created_by','name','price','expiry_period','description','image','status','aprove_status','aproved_by','total_courses','published_at','submitted_at'];
     protected $casts = [
        'courses' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'cpa_id');
    }   

    public function customize_package_courses()
    {
        return $this->hasMany(CustomizePackageCourse::class);
    }
    
}

