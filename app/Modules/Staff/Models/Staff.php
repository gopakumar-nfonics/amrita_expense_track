<?php

namespace App\Modules\Staff\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_staff';

    protected $fillable = [
        'name', 'email', 'password', 'created_by',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
