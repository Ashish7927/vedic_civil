<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PackageCustomRequest extends Model
{
    protected $fillable = ['id','cpa_id','full_name','email_address','  phone_number','company_name','company_registration','updated_by','request_status'];

public function user()
{
    return $this->belongsTo(User::class,'cpa_id');
}
}

