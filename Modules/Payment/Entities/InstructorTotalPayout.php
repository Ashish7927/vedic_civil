<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class InstructorTotalPayout extends Model
{
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
