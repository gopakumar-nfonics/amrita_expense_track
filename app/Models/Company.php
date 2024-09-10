<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'company';
    protected $fillable = ['company_name', 'company_code', 'email ', 'phone', 'gst', 'pan', 'address', 'user_id'];
}
