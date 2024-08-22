<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'department';
    protected $fillable = ['department_name', 'department_code', 'address', 'campus_id'];

    public function campus(){
        return $this->belongsTo(Campus::class,'campus_id');
    }
}
