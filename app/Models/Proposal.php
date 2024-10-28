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

    public function proposalro()
    {
        return $this->belongsTo(ProposalRo::class, 'id','proposal_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function programme()
    {
        return $this->belongsTo(Stream::class, 'programme_id','id');
    }
}
