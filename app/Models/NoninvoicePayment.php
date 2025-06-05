<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoninvoicePayment extends Model
{
    use HasFactory;

    protected $table = 'noninvoice_payment';

    protected $fillable = [
        'title',
        'reference_id',
        'financial_year_id',
        'category_id',
        'stream_id',
        'payment_status',
        'amount',
        'transaction_date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function year()
    {
        return $this->belongsTo(FinancialYear::class,  'financial_year_id', 'id');
    }
    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }
}
