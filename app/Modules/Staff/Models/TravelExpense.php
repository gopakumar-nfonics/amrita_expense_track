<?php

namespace App\Modules\Staff\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelExpense extends Model
{
    use HasFactory;

    protected $table = 'tbl_travel_expenses';

    protected $fillable = [
        'staff_id',
        'title',
        'from_date',
        'to_date',
        'source_city',
        'destination_city',
        'amount',
        'status',
    ];

    // (optional) relationship to Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
