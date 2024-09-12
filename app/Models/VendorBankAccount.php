<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'beneficiary_name',
        'account_no',
        'ifsc_code',
        'bank_name',
        'branch_name',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
