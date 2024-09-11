<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalRo extends Model
{
    use HasFactory;
    protected $table = 'proposal_ro';

    protected $fillable = [
        'proposal_id',
        'proposal_ro',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
