<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\User;

class CorporateAdmin extends Model
{
    use HasFactory;

    protected $table = 'corporate_admin';

    public function corporate()
    {
        return $this->belongsTo(Company::class, 'corporate_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'corporate_admin_id', 'id');
    }
}
