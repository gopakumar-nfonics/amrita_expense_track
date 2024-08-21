<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class FinancialYear extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'financial_year';

    protected $fillable = ['year'];

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'financial_year_id');
    }

    
}
