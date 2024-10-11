<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category as Categories;
use App\Models\FinancialYear;
use App\Models\PaymentRequest;
use App\Models\Budget as Budgets;
use App\Models\Vendor;
use Carbon\Carbon;
use App\Models\Stream;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BudgetReportExport;

class ReportsController extends Controller
{
    public function index()
    {

        return view('reports.index');
    }

    public function reportdata(Request $request)
    {
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
            $query->where(function ($q) use ($searchValue) {
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
                    'expense' => number_format_indian($subCategory->used_amount  ?? 0) // Access the correct field for used amount
                ];
            }

            // Push the formatted data into the categories array
            $categories[] = [
                'category' => $budget->category->category_name, // Adjust this field based on your data
                'allocated' => number_format_indian($budget->amount ?? 0), // Format the allocated amount
                'sub_categories' => $subCategories,
                'total_expense' => number_format_indian($budget->used_amount ?? 0), // Sum of the used amount with a default of 0
                'balance' => number_format_indian(($budget->amount ?? 0) - ($budget->used_amount ?? 0)), // Calculate the balance with defaults
            ];
        }
        return Excel::download(new BudgetReportExport($categories), 'BUET_BE_Report.xlsx');
    }

    public function vendorreport()
    {
        /* $invoices = Invoice::with('paymentRequests')->where('invoice_status', 1)->get();

        print_r($invoices);exit();*/

        $query = Vendor::with(['proposals' => function ($query) {
            $query->where('proposal_status', 1)
                ->with(['invoices' => function ($query) {
                    $query->where('invoice_status', 1)
                        ->select('id', 'invoice_id', 'proposal_id', 'invoice_status', 'milestone_id')
                        ->with(['paymentRequests' => function ($query) {
                            $query->select('id', 'invoice_id', 'transaction_date');
                        }]);
                }, 'paymentMilestones' => function ($query) {
                    $query->select('id', 'proposal_id', 'milestone_title', 'milestone_total_amount');
                }, 'proposalro' => function ($query) {
                    $query->select('id', 'proposal_id', 'proposal_ro'); // Adjust if needed
                }])
                ->orderBy('id'); // Order proposals by their ID
        }])
            ->where('vendor_status', 'verified')
            ->orderBy('id');

        // Get total count before pagination
        $totalCount = $query->count();

        // Apply pagination
        $vendors = $query->get();

        // Initialize the vendor data array
        $vendorData = [];

        foreach ($vendors as $vendor) {
            $vendorDetails = [
                'vendor_name' => $vendor->vendor_name, // Adjust this to your vendor name field
                'proposals' => []
            ];

            foreach ($vendor->proposals as $proposal) {
                // Check if there are invoices with status = 1
                if ($proposal->invoices->isNotEmpty()) {
                    $proposalDetails = [
                        'proposal_title' => $proposal->proposal_title, // Adjust to your proposal title field
                        'proposal_ro' => $proposal->proposalro ? $proposal->proposalro->proposal_ro : null, // Accessing the RO field
                        'milestones' => [],
                        'total_milestone_amount' => 0 // Initialize total milestone amount for this proposal
                    ];

                    foreach ($proposal->paymentMilestones as $milestone) {
                        // Find the corresponding invoice(s) for the milestone
                        $relatedInvoices = $proposal->invoices->where('milestone_id', $milestone->id)->where('invoice_status', 1); // Check for invoice status

                        foreach ($relatedInvoices as $invoice) {
                            $milestoneDetails = [
                                'milestone_name' => $milestone->milestone_title, // Adjust to your milestone name field
                                'milestone_amount' => $milestone->milestone_total_amount, // Adjust to your milestone amount field
                                'invoice_id' => $invoice->invoice_id, // Include the invoice ID
                                'transaction_date' => $invoice->paymentRequests ? $invoice->paymentRequests->transaction_date : null // Get transaction date
                            ];

                            $proposalDetails['milestones'][] = $milestoneDetails;

                            // Add to total milestone amount for the proposal
                            $proposalDetails['total_milestone_amount'] += $milestone->milestone_total_amount; // Summing milestone amounts
                        }
                    }

                    // Only add the proposal if it has milestones
                    if (!empty($proposalDetails['milestones'])) {
                        $vendorDetails['proposals'][] = $proposalDetails;
                    }
                }
            }

            // Only add vendors that have proposals
            if (!empty($vendorDetails['proposals'])) {
                $vendorData[] = $vendorDetails;
            }
        }

        // Returning the data as JSON response for DataTables or other frontend use
        
//print_r($vendorDetails);exit();

        return view('reports.vendor_report', compact('vendorData'));
    }

    public function vendordata(Request $request)
    {
        $searchValue = $request->input('search.value');

        // Get pagination parameters
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Build the query for verified vendors with their related proposals and invoices
        $query = Vendor::with(['proposals' => function ($query) {
            $query->where('proposal_status', 1)
                ->with(['invoices' => function ($query) {
                    $query->where('invoice_status', 1)
                        ->select('id', 'invoice_id', 'proposal_id', 'invoice_status', 'milestone_id')
                        ->with(['paymentRequests' => function ($query) {
                            $query->select('id', 'invoice_id', 'transaction_date');
                        }]);
                }, 'paymentMilestones' => function ($query) {
                    $query->select('id', 'proposal_id', 'milestone_title', 'milestone_total_amount');
                }, 'proposalro' => function ($query) {
                    $query->select('id', 'proposal_id', 'proposal_ro'); // Adjust if needed
                }])
                ->orderBy('id'); // Order proposals by their ID
        }])
            ->where('vendor_status', 'verified')
            ->orderBy('id');


        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('vendor_name', 'LIKE', "%$searchValue%"); // Adjust 'vendor_name' if necessary
            });
        }

        // Get total count before pagination
        $totalCount = $query->count();

        // Apply pagination
        $vendors = $query->skip($start)->take($length)->get();

        // Initialize the vendor data array
        $vendorData = [];

        foreach ($vendors as $vendor) {
            $vendorDetails = [
                'vendor_name' => $vendor->vendor_name, // Adjust this to your vendor name field
                'proposals' => []
            ];

            foreach ($vendor->proposals as $proposal) {
                // Check if there are invoices with status = 1
                if ($proposal->invoices->isNotEmpty()) {
                    $proposalDetails = [
                        'proposal_title' => $proposal->proposal_title, // Adjust to your proposal title field
                        'proposal_ro' => $proposal->proposalro ? $proposal->proposalro->proposal_ro : null, // Accessing the RO field
                        'milestones' => [],
                        'total_milestone_amount' => 0 // Initialize total milestone amount for this proposal
                    ];

                    foreach ($proposal->paymentMilestones as $milestone) {
                        // Find the corresponding invoice(s) for the milestone
                        $relatedInvoices = $proposal->invoices->where('milestone_id', $milestone->id)->where('invoice_status', 1); // Check for invoice status

                        foreach ($relatedInvoices as $invoice) {
                            $milestoneDetails = [
                                'milestone_name' => $milestone->milestone_title, // Adjust to your milestone name field
                                'milestone_amount' => number_format_indian($milestone->milestone_total_amount ?? 0), // Adjust to your milestone amount field
                                'invoice_id' => $invoice->invoice_id, // Include the invoice ID
                                'transaction_date' => $invoice->paymentRequests ? Carbon::parse($invoice->paymentRequests->transaction_date)->format('d-m-Y') : null // Get transaction date
                            ];

                            $proposalDetails['milestones'][] = $milestoneDetails;

                            // Add to total milestone amount for the proposal
                            $proposalDetails['total_milestone_amount'] += $milestone->milestone_total_amount; // Summing milestone amounts
                        }
                    }

                    $proposalDetails['total_milestone_amount'] = number_format_indian($proposalDetails['total_milestone_amount'], 2, '.', ',');

                    // Only add the proposal if it has milestones
                    if (!empty($proposalDetails['milestones'])) {
                        $vendorDetails['proposals'][] = $proposalDetails;
                    }
                }
            }

            // Only add vendors that have proposals
            if (!empty($vendorDetails['proposals'])) {
                $vendorData[] = $vendorDetails;
            }
        }

        // Returning the data as JSON response for DataTables or other frontend use
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $totalCount, // You can modify this if you want to return filtered count
            'data' => $vendorData
        ]);
    }

    public function programmereport()
    {
      
    return view('reports.programme_report', ['data' => $data]); // Pass data to the view if needed
}

public function programmedata(Request $request)
{
    // Get search value and pagination parameters
    $searchValue = $request->input('search.value');
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);

    // Fetch all streams with their payment requests
    $query = Stream::with(['paymentRequests' => function ($query) {
        $query->select(
                'payment_request.stream_id',
                'payment_request.category_id',
                DB::raw('COALESCE(SUM(payment_milestones.milestone_total_amount), 0) as total_expense') // Ensure correct column
            )
            ->join('invoices', 'payment_request.invoice_id', '=', 'invoices.id')
            ->join('payment_milestones', 'invoices.milestone_id', '=', 'payment_milestones.id')
            ->where('payment_request.payment_status', 'completed')
            ->groupBy('payment_request.stream_id', 'payment_request.category_id'); // Group by stream and category
    }]);

    // Apply search filter if needed
    if ($searchValue) {
        $query->where('stream_name', 'LIKE', "%$searchValue%"); // Filter streams by name
    }

    // Get total count before pagination
    $totalCount = $query->count();

    // Apply pagination
    $streams = $query->skip($start)->take($length)->get();

    // Initialize the data array
    $data = [];

    foreach ($streams as $stream) {
        $categoriesArray = []; // Initialize categories array for this stream
        $totalProgramExpense = 0; // Initialize total program expense for this stream

        // Process each payment request for the current stream
        foreach ($stream->paymentRequests as $paymentRequest) {
            // Get the category related to the payment request
            $category = Category::with('children')->find($paymentRequest->category_id);

            if ($category) {
                // Determine parent category name
                $parentCategoryName = $category->parent ? $category->parent->category_name : $category->category_name;
                 
                // Initialize parent category if it doesn't exist
                if (!isset($categoriesArray[$parentCategoryName])) {
                    $categoriesArray[$parentCategoryName] = [
                        'category_name' => $parentCategoryName,
                        'total_expense' => 0,
                    ];
                }

                // Update the total expense for the parent category
                $categoriesArray[$parentCategoryName]['total_expense'] += $paymentRequest->total_expense;

                // Update the total program expense
                $totalProgramExpense += $paymentRequest->total_expense;
            }
        }

        // Push stream-wise data along with total program expense
        $data[] = [
            'stream_name' => $stream->stream_name,
            'total_program_expense' => $totalProgramExpense, // Total expense for the program
            'categories' => array_values($categoriesArray) // Convert to a standard array
        ];
    }

    // Return JSON response for DataTables
    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalCount,
        'recordsFiltered' => $totalCount,
        'data' => $data,
    ]);
}

}
