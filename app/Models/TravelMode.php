<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelMode extends Model
{
    use HasFactory;

    protected $table = 'travel_mode';

    protected $fillable = ['name', 'code', 'parent_mode'];

    public function parent()
    {
        return $this->belongsTo(TravelMode::class, 'parent_mode');
    }

    public function children()
    {
        return $this->hasMany(TravelMode::class, 'parent_mode');
    }
}
