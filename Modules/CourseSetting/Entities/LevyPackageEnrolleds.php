<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Builder;
use Modules\CourseSetting\Entities\Package;
use App\Models\User;
use Modules\Payment\Entities\Checkout;
use Carbon\Carbon;

class LevyPackageEnrolleds extends Model
{
    protected $fillable = ['user_id', 'package_id', 'purchase_price'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
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
