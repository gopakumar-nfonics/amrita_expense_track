<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proposal';

    protected $fillable = [
        'proposal_id',
        'proposal_title',
        'proposal_date',
        'proposal_description',
        'proposal_cost',
        'proposal_gst',
        'proposal_total_cost',
        'proposal_status',
        'vendor_id',
    ];

    public function paymentMilestones()
    {
        return $this->hasMany(PaymentMilestone::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
