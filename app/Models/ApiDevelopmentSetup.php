<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiDevelopmentSetup extends Model
{
    protected $fillable = [];

    use HasFactory;

    protected $table = "courses_api_development_setups";
}
