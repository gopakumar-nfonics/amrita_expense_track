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
        'financial_year_id',
        'amount',
        'status',
        'advance_amount',
    ];

    // (optional) relationship to Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function sourceCity()
    {
        return $this->belongsTo(\App\Models\City::class, 'source_city');
    }

    public function destinationCity()
    {
        return $this->belongsTo(\App\Models\City::class, 'destination_city');
    }
    public function details()
    {
        return $this->hasMany(TravelExpenseDetail::class, 'travel_expense_id');
    }
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
    public function stream()
    {
        return $this->belongsTo(\App\Models\Stream::class, 'stream_id');
    }

}
