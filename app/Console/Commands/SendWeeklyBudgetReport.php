<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\BudgetReportMail;
use App\Services\BudgetReportService;
use App\Models\FinancialYear;
use App\Models\EmailConfiguration;

class SendWeeklyBudgetReport extends Command
{
    protected $signature = 'report:weekly-budget {--to=}';
    protected $description = 'Send weekly budget utilization email';

    protected $service;

    public function __construct(BudgetReportService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        // Get current financial year
        $currentFinancialYear = FinancialYear::where('is_current', 1)->first();

        if (!$currentFinancialYear) {
            $this->error('No current financial year found (is_current = 1).');
            return;
        }

        $financialYearId = $currentFinancialYear->id;

        // Build data
        $data = $this->service->getReportData($financialYearId);

        $categories = $data['categories'];
        $financialYear = $data['financialYear'];

        $recipientName = EmailConfiguration::where('is_active', true)
    ->where('email_type', 'budget_report')
    ->orderBy('created_at', 'desc')
    ->value('recipient_name');


        // Determine recipients: optional --to email or fallback to config/DB
        $to = $this->option('to');

        $recipients = [];
        if ($to) {
            $recipients[] = $to;
        } else {
            // Get email addresses from EmailConfiguration table
            $emailAddresses = EmailConfiguration::where('is_active', true)
                ->where('email_type', 'budget_report')
                ->orderBy('created_at', 'desc')
                ->pluck('email_address')
                ->toArray();
            
            // Use only database entries
            $recipients = $emailAddresses;
        }

        foreach ($recipients as $email) {
            Mail::to($email)->queue(new BudgetReportMail($categories, $financialYear,$recipientName));
        }

        $this->info('Weekly budget report queued for: ' . implode(',', $recipients));
    }
}
