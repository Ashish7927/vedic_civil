<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrdcPayout extends Model
{
    use HasFactory;

    public function instructor() {
        return $this->belongsTo(User::class);
    }
}
