<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category as Categories;
use App\Models\FinancialYear;
use App\Models\PaymentRequest;
use App\Models\Budget as Budgets;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BudgetReportExport;

class ReportsController extends Controller
{
    public function index()
    {
        $budgets = Budgets::select('tbl_budget.*')
    ->selectRaw('(SELECT SUM(payment_milestones.milestone_total_amount) 
                  FROM payment_request
                  INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                  INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                  INNER JOIN tbl_category ON payment_request.category_id = tbl_category.id
                  WHERE (payment_request.category_id = tbl_budget.category_id 
                         OR tbl_category.parent_category = tbl_budget.category_id)
                  AND payment_request.payment_status = "completed") as used_amount')
    ->from('tbl_budget')
    ->whereNull('tbl_budget.deleted_at')
    ->with(['category' => function ($query) {
        $query->select('tbl_category.*')
              ->selectRaw('(SELECT SUM(payment_milestones.milestone_total_amount) 
                            FROM payment_request
                            INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                            INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                            WHERE payment_request.category_id = tbl_category.id 
                            AND payment_request.payment_status = "completed") as used_amount_by_subcategory')
              ->whereNull('tbl_category.deleted_at')
              ->with(['children' => function ($subQuery) {
                  $subQuery->select('tbl_category.*')
                           ->selectRaw('(SELECT SUM(payment_milestones.milestone_total_amount) 
                                         FROM payment_request
                                         INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                                         INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                                         WHERE payment_request.category_id = tbl_category.id 
                                         AND payment_request.payment_status = "completed") as used_amount')
                           ->whereNull('tbl_category.deleted_at');
              }]);
    }])
    ->orderBy('id')
    ->get();

// Initialize the categories array
$categories = [];

foreach ($budgets as $budget) {
    // Retrieve sub-categories if available
    $subCategories = [];
    foreach ($budget->category->children as $subCategory) {
        $subCategories[] = [
            'id' => $subCategory->id, // Assuming you want to include the ID
            'name' => $subCategory->category_name, // Adjust this field based on your data
            'expense' => number_format_indian($subCategory->used_amount) // Access the correct field for used amount
        ];
    }

    // Push the formatted data into the categories array
    $categories[] = [
        'category' => $budget->category->category_name, // Adjust this field based on your data
        'allocated' => number_format_indian($budget->amount), // Format the allocated amount
        'sub_categories' => $subCategories,
        'total_expense' => number_format_indian($budget->used_amount), // Sum of the used amount
        'balance' => number_format_indian($budget->amount - $budget->used_amount), // Calculate the balance
    ];
}

// Now $categories contains the structured data with correct subcategory expenses


// At this point, $categories will have the structured data you want


//print_r($categories);exit();

// Now you can pass $categories to the view or use it further in the controller

        return view('reports.index',compact('categories'));
    }

    public function reportdata(Request $request) {
        // Get search value
        $searchValue = $request->input('search.value');
    
        // Get pagination parameters
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
    
        // Build the query
        $query = Budgets::select('tbl_budget.*')
            ->selectRaw('(SELECT COALESCE(SUM(payment_milestones.milestone_total_amount), 0) 
                          FROM payment_request
                          INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                          INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                          INNER JOIN tbl_category ON payment_request.category_id = tbl_category.id
                          WHERE (payment_request.category_id = tbl_budget.category_id 
                                 OR tbl_category.parent_category = tbl_budget.category_id)
                          AND payment_request.payment_status = "completed") as used_amount')
            ->from('tbl_budget')
            ->leftJoin('tbl_category', 'tbl_budget.category_id', '=', 'tbl_category.id') // Join with tbl_category
            ->whereNull('tbl_budget.deleted_at')
            ->with(['category' => function ($query) {
                $query->select('tbl_category.*')
                      ->selectRaw('(SELECT COALESCE(SUM(payment_milestones.milestone_total_amount), 0) 
                                    FROM payment_request
                                    INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                                    INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                                    WHERE payment_request.category_id = tbl_category.id 
                                    AND payment_request.payment_status = "completed") as used_amount_by_subcategory')
                      ->whereNull('tbl_category.deleted_at')
                      ->with(['children' => function ($subQuery) {
                          $subQuery->select('tbl_category.*')
                                   ->selectRaw('(SELECT COALESCE(SUM(payment_milestones.milestone_total_amount), 0) 
                                                 FROM payment_request
                                                 INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                                                 INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                                                 WHERE payment_request.category_id = tbl_category.id 
                                                 AND payment_request.payment_status = "completed") as used_amount')
                                   ->whereNull('tbl_category.deleted_at');
                      }]);
            }])
            ->orderBy('id');
    
        // Apply search filter
        if ($searchValue) {
            $query->where(function($q) use ($searchValue) {
                $q->where('tbl_category.category_name', 'LIKE', "%$searchValue%")
                  ->orWhere('tbl_budget.amount', 'LIKE', "%$searchValue%");
            });
        }
    
        // Get total count before pagination
        $totalCount = $query->count();
    
        // Apply pagination
        $budgets = $query->skip($start)->take($length)->get();
    
        // Initialize the categories array
        $categories = [];
    
        foreach ($budgets as $budget) {
            // Retrieve sub-categories if available
            $subCategories = [];
            foreach ($budget->category->children as $subCategory) {
                $subCategories[] = [
                    'id' => $subCategory->id, // Including the ID of the subcategory
                    'name' => $subCategory->category_name, // Subcategory name
                    'expense' => number_format_indian($subCategory->used_amount) // Formatting used amount in Indian currency
                ];
            }
    
            // Push the formatted data into the categories array
            $categories[] = [
                'category' => $budget->category->category_name, // Main category name
                'allocated' => number_format_indian($budget->amount), // Allocated amount formatted
                'sub_categories' => $subCategories, // List of subcategories
                'total_expense' => number_format_indian($budget->used_amount), // Sum of used amounts formatted
                'balance' => number_format_indian($budget->amount - $budget->used_amount), // Balance calculated and formatted
            ];
        }
    
        // Returning the data as JSON response for DataTables or other frontend use
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $totalCount, // You can modify this if you want to return filtered count
            'data' => $categories
        ]);
    }

    public function exportBudgetReport()
    {
        $budgets = Budgets::select('tbl_budget.*')
    ->selectRaw('(SELECT SUM(payment_milestones.milestone_total_amount) 
                  FROM payment_request
                  INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                  INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                  INNER JOIN tbl_category ON payment_request.category_id = tbl_category.id
                  WHERE (payment_request.category_id = tbl_budget.category_id 
                         OR tbl_category.parent_category = tbl_budget.category_id)
                  AND payment_request.payment_status = "completed") as used_amount')
    ->from('tbl_budget')
    ->whereNull('tbl_budget.deleted_at')
    ->with(['category' => function ($query) {
        $query->select('tbl_category.*')
              ->selectRaw('(SELECT SUM(payment_milestones.milestone_total_amount) 
                            FROM payment_request
                            INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                            INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                            WHERE payment_request.category_id = tbl_category.id 
                            AND payment_request.payment_status = "completed") as used_amount_by_subcategory')
              ->whereNull('tbl_category.deleted_at')
              ->with(['children' => function ($subQuery) {
                  $subQuery->select('tbl_category.*')
                           ->selectRaw('(SELECT SUM(payment_milestones.milestone_total_amount) 
                                         FROM payment_request
                                         INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                                         INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                                         WHERE payment_request.category_id = tbl_category.id 
                                         AND payment_request.payment_status = "completed") as used_amount')
                           ->whereNull('tbl_category.deleted_at');
              }]);
    }])
    ->orderBy('id')
    ->get();

// Initialize the categories array
$categories = [];

foreach ($budgets as $budget) {
    // Retrieve sub-categories if available
    $subCategories = [];
    foreach ($budget->category->children as $subCategory) {
        $subCategories[] = [
            'id' => $subCategory->id, // Assuming you want to include the ID
            'name' => $subCategory->category_name, // Adjust this field based on your data
            'expense' => number_format_indian($subCategory->used_amount) // Access the correct field for used amount
        ];
    }

    // Push the formatted data into the categories array
    $categories[] = [
        'category' => $budget->category->category_name, // Adjust this field based on your data
        'allocated' => number_format_indian($budget->amount), // Format the allocated amount
        'sub_categories' => $subCategories,
        'total_expense' => number_format_indian($budget->used_amount), // Sum of the used amount
        'balance' => number_format_indian($budget->amount - $budget->used_amount), // Calculate the balance
    ];
}
  return Excel::download(new BudgetReportExport($categories), 'BUET_BE_Report.xlsx');
    }
    
    
}