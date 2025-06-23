<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAllowanceAccommodation extends Model
{
    use HasFactory;

    protected $table = 'daily_allowance_accommodations';

    protected $fillable = [
        'designation_id', 
        'city_tier_id', 
        'allowance_amount', 
        'accommodation_amount'
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'city_tier_id');
    }
}
