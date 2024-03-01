<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auditTrailLearnerProfile extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => ''
        ]);

    }
}
