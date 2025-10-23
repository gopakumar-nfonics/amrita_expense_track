<?php
namespace App\Services;

use DB;
use App\Models\Budget as Budgets;
use App\Models\FinancialYear;

class BudgetReportService
{
    /**
     * Build category-wise budget data for a given financial year and optionally a category filter.
     *
     * @param int|null $financialYearId
     * @param int|null $categoryId
     * @param int $start
     * @param int $length
     * @return array [categories => [...], financialYear => FinancialYear|null]
     */
    public function getReportData($financialYearId = null, $categoryId = null, $start = 0, $length = 1000)
    {
        $query = Budgets::select('tbl_budget.*')
            ->selectRaw('(
                COALESCE((
                    SELECT SUM(payment_milestones.milestone_total_amount)
                    FROM payment_request
                    INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                    INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                    INNER JOIN proposal ON payment_milestones.proposal_id = proposal.id
                    INNER JOIN tbl_category ON payment_request.category_id = tbl_category.id
                    WHERE (payment_request.category_id = tbl_budget.category_id 
                           OR tbl_category.parent_category = tbl_budget.category_id)
                      AND payment_request.payment_status = "completed"
                      AND proposal.proposal_year = tbl_budget.financial_year_id
                ), 0) +
                COALESCE((
                    SELECT SUM(noninvoice_payment.amount)
                    FROM noninvoice_payment
                    INNER JOIN tbl_category ON noninvoice_payment.category_id = tbl_category.id
                    WHERE (noninvoice_payment.category_id = tbl_budget.category_id 
                           OR tbl_category.parent_category = tbl_budget.category_id)
                      AND noninvoice_payment.payment_status = "completed"
                      AND noninvoice_payment.financial_year_id = tbl_budget.financial_year_id
                ), 0) +
                COALESCE((
                    SELECT SUM(advance_amount)
                    FROM tbl_travel_expenses
                    INNER JOIN tbl_category ON tbl_travel_expenses.category_id = tbl_category.id
                    WHERE (tbl_travel_expenses.category_id = tbl_budget.category_id 
                        OR tbl_category.parent_category = tbl_budget.category_id)
                    AND tbl_travel_expenses.status IN ("advance_received", "expense_submitted")
                    AND tbl_travel_expenses.financial_year_id = tbl_budget.financial_year_id
                ), 0) +
                COALESCE((
                    SELECT SUM(ted.amount)
                    FROM tbl_travel_expenses te
                    INNER JOIN travel_expense_details ted ON ted.travel_expense_id = te.id
                    WHERE ted.travel_head IN (
                        SELECT id FROM tbl_category WHERE parent_category = tbl_budget.category_id
                    )
                    AND te.status = "expense_settled"
                    AND te.financial_year_id = tbl_budget.financial_year_id
                ), 0)
            ) as used_amount')
            ->leftJoin('tbl_category', 'tbl_budget.category_id', '=', 'tbl_category.id')
            ->whereNull('tbl_budget.deleted_at')
            ->with([
                'category' => function ($query) use ($financialYearId) {
                    $query->select('tbl_category.*')
                        ->addSelect(DB::raw('(
                            COALESCE((
                                SELECT SUM(payment_milestones.milestone_total_amount)
                                FROM payment_request
                                INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                                INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                                INNER JOIN proposal ON payment_milestones.proposal_id = proposal.id
                                WHERE payment_request.category_id = tbl_category.id
                                AND payment_request.payment_status = "completed"
                                ' . ($financialYearId ? 'AND proposal.proposal_year = ' . (int) $financialYearId : '') . '
                            ), 0) +
                            COALESCE((
                                SELECT SUM(noninvoice_payment.amount)
                                FROM noninvoice_payment
                                WHERE noninvoice_payment.category_id = tbl_category.id
                                AND noninvoice_payment.payment_status = "completed"
                                ' . ($financialYearId ? 'AND noninvoice_payment.financial_year_id = ' . (int) $financialYearId : '') . '
                            ), 0) +
                            COALESCE((
                                SELECT SUM(advance_amount)
                                FROM tbl_travel_expenses
                                WHERE tbl_travel_expenses.category_id = tbl_category.id
                                AND tbl_travel_expenses.status IN ("advance_received", "expense_submitted")
                                ' . ($financialYearId ? 'AND tbl_travel_expenses.financial_year_id = ' . (int) $financialYearId : '') . '
                            ), 0) +
                            COALESCE((
                                SELECT SUM(ted.amount)
                                FROM tbl_travel_expenses te
                                INNER JOIN travel_expense_details ted ON ted.travel_expense_id = te.id
                                WHERE ted.travel_head IN (SELECT id FROM tbl_category WHERE parent_category = tbl_category.id)
                                AND te.status = "expense_settled"
                                ' . ($financialYearId ? 'AND te.financial_year_id = ' . (int) $financialYearId : '') . '
                            ), 0)
                        ) as used_amount_by_subcategory'))
                        ->whereNull('tbl_category.deleted_at')
                        ->with([
                            'children' => function ($subQuery) use ($financialYearId) {
                                $subQuery->select('tbl_category.*')
                                    ->addSelect(DB::raw('(
                                        COALESCE((
                                            SELECT SUM(payment_milestones.milestone_total_amount)
                                            FROM payment_request
                                            INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                                            INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                                            INNER JOIN proposal ON payment_milestones.proposal_id = proposal.id
                                            WHERE payment_request.category_id = tbl_category.id
                                            AND payment_request.payment_status = "completed"
                                            ' . ($financialYearId ? 'AND proposal.proposal_year = ' . (int) $financialYearId : '') . '
                                        ), 0) +
                                        COALESCE((
                                            SELECT SUM(noninvoice_payment.amount)
                                            FROM noninvoice_payment
                                            WHERE noninvoice_payment.category_id = tbl_category.id
                                            AND noninvoice_payment.payment_status = "completed"
                                            ' . ($financialYearId ? 'AND noninvoice_payment.financial_year_id = ' . (int) $financialYearId : '') . '
                                        ), 0) +
                                        COALESCE((
                                            SELECT SUM(advance_amount)
                                            FROM tbl_travel_expenses
                                            WHERE tbl_travel_expenses.category_id = tbl_category.id
                                            AND tbl_travel_expenses.status IN ("advance_received", "expense_submitted")
                                            ' . ($financialYearId ? 'AND tbl_travel_expenses.financial_year_id = ' . (int) $financialYearId : '') . '
                                        ), 0) +
                                        COALESCE((
                                            SELECT SUM(ted.amount)
                                            FROM tbl_travel_expenses te
                                            INNER JOIN travel_expense_details ted ON ted.travel_expense_id = te.id
                                            WHERE ted.travel_head = tbl_category.id
                                            AND te.status = "expense_settled"
                                            ' . ($financialYearId ? 'AND te.financial_year_id = ' . (int) $financialYearId : '') . '
                                        ), 0)
                                    ) as used_amount'))
                                    ->whereNull('tbl_category.deleted_at');
                            }
                        ]);
                }
            ])->orderBy('id');

        if ($categoryId) {
            $query->where('tbl_category.id', $categoryId);
        }

        if ($financialYearId) {
            $query->where('tbl_budget.financial_year_id', $financialYearId);
        }

        $query->skip($start)->take($length);
        $budgets = $query->get();

        $categories = [];
        foreach ($budgets as $budget) {
            $subCategories = [];
            if ($budget->category && $budget->category->children) {
                foreach ($budget->category->children as $subCategory) {
                    $subCategories[] = [
                        'id' => $subCategory->id,
                        'name' => $subCategory->category_name,
                        'expense' => $this->formatIndian($subCategory->used_amount ?? 0),
                        'raw_expense' => floatval($subCategory->used_amount ?? 0),
                    ];
                }
            }

            $used = floatval($budget->used_amount ?? 0);
            $allocated = floatval($budget->amount ?? 0);
            $categories[] = [
                'category' => $budget->category->category_name ?? 'Unknown',
                'allocated' => $this->formatIndian($allocated),
                'allocated_raw' => $allocated,
                'sub_categories' => $subCategories,
                'total_expense' => $this->formatIndian($used),
                'total_expense_raw' => $used,
                'balance' => $this->formatIndian($allocated - $used),
                'balance_raw' => $allocated - $used,
            ];
        }

        $financialYear = FinancialYear::find($financialYearId);

        return [
            'categories' => $categories,
            'financialYear' => $financialYear ? $financialYear->year : null,
        ];
    }

    protected function formatIndian($amount)
    {
        // use your helper or a local formatting. Fallback simple formatting:
        if (is_null($amount)) $amount = 0;
        return number_format((float)$amount, 2);
    }
}
