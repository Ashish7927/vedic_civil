<?php

namespace Modules\Certificate\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Package;

class CertificatePackage extends Model
{
    protected $fillable = [];
    
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id')->withDefault();
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'certificate_id', 'id')->withDefault();
    }
}
