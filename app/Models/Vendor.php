<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor';
    protected $fillable = ['vendor_name', 'vendor_code', 'email', 'phone', 'company_id', 'gst', 'pan', 'address','user_id','contact_person'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
    public function states()
    {
        return $this->hasMany(State::class,'id','state');
    }
    public function banckaccount()
    {
        return $this->belongsTo(VendorBankAccount::class,'id','vendor_id');
    }
}
