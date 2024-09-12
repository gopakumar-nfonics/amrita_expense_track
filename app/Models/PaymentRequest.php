<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $table = 'payment_request';

    protected $fillable = [
        'payment_request_id',
        'invoice_id',
        'stream_id',
        'category_id',
        'payment_status',
    ];

    // Define relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
