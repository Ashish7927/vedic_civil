<?php

namespace Modules\CourseSetting\Entities;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Package;
class auditTrailPackage extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => ''
        ]);

    }
    public function package(){
        return $this->belongsTo(Package::class,'package_id','id');
    }
}
