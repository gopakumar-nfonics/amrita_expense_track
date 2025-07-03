<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'category_id',
        'stream_id',
        'associated',
        'amount',
        'status',
        'advance_amount',
        'final_amount',
    ];

    public function staff()
    {
        return $this->belongsTo(\App\Modules\Staff\Models\Staff::class, 'staff_id');
    }
    public function sourceCity()
    {
        return $this->belongsTo(City::class, 'source_city');
    }

    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function stream()
    {
        return $this->belongsTo(Stream::class, 'stream_id');
    }
    public function details()
    {
        return $this->hasMany(\App\Modules\Staff\Models\TravelExpenseDetail::class, 'travel_expense_id');
    }
}
