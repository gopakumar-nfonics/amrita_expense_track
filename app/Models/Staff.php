<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'tbl_staff';

    protected $fillable = [
        'name',
        'email',
        'password',
        'designation_id',
        'created_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
}
