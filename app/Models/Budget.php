<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_budget';

    protected $fillable = ['financial_year_id', 'category_id', 'amount', 'notes'];

    // Define relationships
    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class, 'financial_year_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
