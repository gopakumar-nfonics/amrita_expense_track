<?php

namespace App\Modules\Staff\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelExpenseDetail extends Model
{
    use HasFactory;

    protected $table = 'travel_expense_details';

    protected $fillable = [
        'travel_expense_id',
        'travel_head',
        'expenditure',
        'amount',
        'file_path'
    ];
}
