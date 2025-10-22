<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_type',
        'email_address',
        'recipient_name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('email_type', $type);
    }

    public function scopeBudgetReport($query)
    {
        return $query->where('email_type', 'budget_report');
    }

    // Static methods for easy access
    public static function getBudgetReportEmails()
    {
        return self::active()->budgetReport()->pluck('email_address')->toArray();
    }

    public static function getBudgetReportRecipients()
    {
        return self::active()->budgetReport()->get(['email_address', 'recipient_name']);
    }
}
