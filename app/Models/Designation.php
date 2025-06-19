<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'designation';
    
    protected $fillable = [
        'title',
        'code',
    ];

    public function travelModes()
    {
        return $this->belongsToMany(TravelMode::class, 'designation_travel_modes', 'designation_id', 'travel_mode_id');
    }
}
