<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class CourseAuthenticationToken extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['user_id'];

    protected $table = "course_authentication_token";

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('courseenrolldata', function (Builder $builder) {
            $builder->whereHas('user', function ($query) {
                $query->where('is_corporate_user', '=', 0);
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }
}
