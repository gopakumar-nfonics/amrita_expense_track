<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMilestone extends Model
{
    use HasFactory;

    protected $table = 'payment_milestones';

    protected $fillable = [
        'proposal_id',
        'milestone_title',
        'milestone_date',
        'milestone_amount',
        'milestone_gst',
        'milestone_total_amount',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'milestone_id', 'id');
    }
}
