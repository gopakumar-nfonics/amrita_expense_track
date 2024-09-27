<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'proposal_id',
        'milestone_id',
        'vendor_id', // Add this line
        'invoice_number',
        'invoice_date',
        'invoice_file',
        'invoice_notes'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function milestone()
    {
        return $this->belongsTo(PaymentMilestone::class, 'milestone_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function proposalro()
    {
        return $this->belongsTo(ProposalRo::class, 'proposal_id','proposal_id');
    }

    public function paymentRequests()
    {
        return $this->hasMany(PaymentRequest::class);
    }
}
