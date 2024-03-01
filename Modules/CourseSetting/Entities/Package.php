<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Package extends Model
{
    protected $fillable = [];

    protected $casts = [
        'courses' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package_courses()
    {
        return $this->hasMany(PackageCourse::class);
    }

    public function categories()
    {
        return $this->hasMany(PackageCategory::class);
    }
    public function corporate_user(){
        return $this->belongsTo(User::class,'corporate_id');
    }

    public function enrollUsers()
    {
        return $this->belongsToMany(User::class, 'package_enrolleds', 'package_id', 'user_id');
    }

    public function getTotalReviewAttribute()
    {
        return $this->total_rating;
    }

    public function getStarWiseReviewAttribute()
    {
        $data['1'] = $this->activeReviews->where('star', '1')->count();
        $data['2'] = $this->activeReviews->where('star', '2')->count();
        $data['3'] = $this->activeReviews->where('star', '3')->count();
        $data['4'] = $this->activeReviews->where('star', '4')->count();
        $data['5'] = $this->activeReviews->where('star', '5')->count();
        $data['total'] = $data['1'] + $data['2'] + $data['3'] + $data['4'] + $data['5'];
        return $data;
    }

    public function activeReviews()
    {
        return $this->hasMany(PackageReview::class, 'package_id', 'id')->where('status', 1);
    }

    public function reviews()
    {
        return $this->hasMany(PackageReview::class, 'package_id')->select('user_id', 'package_id', 'status', 'comment', 'star');
    }

    public function cartUsers()
    {
        return $this->belongsToMany(User::class, 'carts', 'package_id', 'user_id');
    }

    public function getIsLoginUserEnrolledAttribute()
    {
        if (\auth()->user()->role_id == 1) {
            return true;
        }

        if (\auth()->user()->role_id == 2) {
            if ($this->user_id == \auth()->user()->id) {
                return true;
            }
        }

        if (auth()->user()->role_id == 4 || auth()->user()->role_id > 5) {
            if (Settings('staff_can_view_course') == 'yes') {
                return true;
            }
        }

        if (!$this->enrollUsers->where('id', \auth()->user()->id)->count()) {
            return false;
        } else {
            return true;
        }

        return false;
    }

    public function getIsGuestUserCartAttribute()
    {
        if (session()->has('cart')) {
            foreach (session()->get('cart') as $item) {
                if ($item['package_id'] == $this->id) {
                    return true;
                }
            }
        }

        return false;
    }

    public function enrolls()
    {
        return $this->hasMany(PackageEnrolled::class, 'package_id', 'id');
    }

    public function enrolled_package_qty($package_id)
    {
        return PackageEnrolled::select('quantity')->where('user_id', Auth::id())->where('package_id', $package_id)->first();
    }

    public function enrolled_custom_package_qty($package_id)
    {
        return PackageEnrolled::select('quantity')->where('user_id', Auth::id())->where('package_id', $package_id)->first();
    }
}
