<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\EmailDigest;
use Illuminate\Support\Facades\Mail;
use App\Models\Budget;
use App\Models\PaymentMilestone;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\DB;

class BudgetEmailDigest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digest:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send budget exhaustion email for categories below 10% threshold';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentfinancialYear = FinancialYear::where('is_current', 1)->first();
        $financialYearId = $currentfinancialYear->id;

        $categoryWiseBudgets = Budget::with('category')
            ->select('category_id', \DB::raw('SUM(amount) as total_amount'))
            ->where('financial_year_id', $financialYearId)
            ->groupBy('category_id')
            ->orderBy('total_amount', 'DESC') // Order by total_amount in descending order
            ->get();

        $totalMilestoneByCategory = PaymentMilestone::join('invoices', 'payment_milestones.id', '=', 'invoices.milestone_id')
            ->join('payment_request', 'invoices.id', '=', 'payment_request.invoice_id')
            ->leftJoin('tbl_category as child_category', 'payment_request.category_id', '=', 'child_category.id') // LEFT JOIN for child_category
            ->leftJoin('tbl_category as parent_category', 'child_category.parent_category', '=', 'parent_category.id') // Get parent category from child category
            ->join('proposal', 'payment_milestones.proposal_id', '=', 'proposal.id') // join with proposal table
            ->where('payment_request.payment_status', 'completed') // Filter by payment status
            ->when($financialYearId, function ($query) use ($financialYearId) {
                $query->where('proposal.proposal_year', $financialYearId); // Filter by financial year
            })
            ->select(
                DB::raw('COALESCE(parent_category.id, child_category.id) as parent_category_id'), // Get the parent category or fallback to child category
                DB::raw('COALESCE(parent_category.category_name, child_category.category_name) as parent_category_name'), // Get the parent category name or fallback
                DB::raw('SUM(payment_milestones.milestone_total_amount) as total_milestone_amount') // Sum the milestones
            )
            ->groupBy('parent_category_id', 'parent_category_name') // Group by parent category
            ->orderBy('total_milestone_amount', 'DESC') // Order by total milestone amount
            ->get();

        $this->categorybudgetused = [];
        foreach ($totalMilestoneByCategory as $milestone) {
            // Use parent_category_id directly since child categories are grouped under parent
            $categoryIdToUse = $milestone->parent_category_id;

            // Get total budget for the category
            $budgetAmount = $categoryWiseBudgets->where('category_id', $categoryIdToUse)->sum('total_amount');

            // Calculate used and remaining
            $usedAmount = $milestone->total_milestone_amount;
            $remainingAmount = $budgetAmount - $usedAmount;
            $remainingPercent = $budgetAmount > 0 ? ($remainingAmount / $budgetAmount) * 100 : 0;

            $this->categorybudgetused[] = [
                'parent_category_id' => $milestone->parent_category_id,
                'parent_category_name' => $milestone->parent_category_name,
                'total_milestone_amount' => $usedAmount,
                'budget_amount' => $budgetAmount,
                'remaining_amount' => $remainingAmount,
                'remaining_percent' => round($remainingPercent, 2),
            ];
        }

        $this->categorybudgetused = collect($this->categorybudgetused)->filter(function ($item) {
            return $item['remaining_percent'] <= 10;
        })->values();

        $subject = "Budget Exhaustion Alert";
        $digestemail = env('CONTACT_MAIL');
        if (count($this->categorybudgetused) > 0) {
            Mail::to($digestemail)->send(new EmailDigest($this->categorybudgetused, $subject));
        }

    }
}
