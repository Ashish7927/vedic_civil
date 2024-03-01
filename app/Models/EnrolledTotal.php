<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledTotal extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'amount', 'tax_amount', 'hrdc_amount', 'myll_amount',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
