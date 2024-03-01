<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Modules\Payment\Entities\Checkout;
use App\BillingDetails;
use Carbon\Carbon;
use App\Models\User;
use Awobaz\Compoships\Compoships;

class PackageEnrolled extends Model
{
    // use Compoships;

    protected $table = 'package_enrolleds';

    protected $fillable = ['user_id', 'package_id', 'purchase_price'];

    protected $appends = ['enrolledDate'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('packageenrolldata', function (Builder $builder) {
            $builder->whereHas('user', function ($query) {
                $query->where('is_corporate_user', '=', 1);
            });
        });
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function getenrolledDateAttribute()
    {
        return Carbon::parse($this->created_at)->isoformat('Do MMMM Y H:ss a');
    }

    public function scopeEnrollStudent($query)
    {
        return $query->whereHas('package', function ($query) {
            $query->where('user_id', Auth::id());
        });
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'tracking', 'tracking')->withDefault();
    }

    public function bill()
    {
        return $this->belongsTo(BillingDetails::class, 'tracking', 'tracking_id')->withDefault();
    }
}
