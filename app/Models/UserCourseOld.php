<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserCourseOld extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'user_course_olds';

    protected $fillable = [
        'UserName', 'Email', 'UserStatus', 'Title', 'Type', 'Duration', 'Status', 'Pass', 'StartDate', 'EndDate'
    ];

}
