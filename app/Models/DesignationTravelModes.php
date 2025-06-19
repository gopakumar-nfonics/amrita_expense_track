<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationTravelModes extends Model
{
    use HasFactory;

    protected $table = 'designation_travel_modes';

    protected $fillable = ['designation_id', 'travel_mode_id', 'status'];
}
