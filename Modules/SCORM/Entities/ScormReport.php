<?php

namespace Modules\SCORM\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class ScormReport extends Model
{
    use Tenantable;

    protected $fillable = [];
}
