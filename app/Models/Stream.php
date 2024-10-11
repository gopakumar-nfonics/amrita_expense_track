<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stream extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stream';

    protected $fillable = ['stream_name', 'stream_code','campus_id','department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function paymentRequests()
    {
        return $this->hasMany(PaymentRequest::class, 'stream_id');
    }
}
