<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReceipt extends Model
{
    use HasFactory;

    public function receipt_courses()
    {
        return $this->hasMany(UserReceiptCourse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
