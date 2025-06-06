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
use App\Exports\VendorExport;
use App\Exports\ProgramDataExport;

class ReportsController extends Controller
{
    public $vendorData = [];
    public $data = [];
    public $categories = [];

    public function index()
    {
        $category = Category::whereNull('parent_category')
        ->whereHas('budgets') // Only include categories with associated budgets
        ->orderBy('category_name')
        ->get();

        $financialYears = FinancialYear::orderBy('year', 'desc')->get();

        return view('reports.index',compact('category', 'financialYears'));
    }

    public function reportdata(Request $request)
    {
        // Get search value
        $searchValue = $request->input('search.value');
        $categoryId = $request->input('category'); // Get the selected program ID

        session()->forget(['category_data', 'financial_year_id']);  // Remove program_data from session

        $financialYearId = $request->input('financial_year'); // Get the selected financial year ID

        // Get pagination parameters
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Build the query
        $query = Budgets::select('tbl_budget.*')
    ->selectRaw('(SELECT COALESCE(SUM(payment_milestones.milestone_total_amount), 0) 
                  FROM payment_request
                  INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                  INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                  INNER JOIN proposal ON payment_milestones.proposal_id = proposal.id
                  INNER JOIN tbl_category ON payment_request.category_id = tbl_category.id
                  WHERE (payment_request.category_id = tbl_budget.category_id 
                         OR tbl_category.parent_category = tbl_budget.category_id)
                  AND payment_request.payment_status = "completed"
                  AND proposal.proposal_year = tbl_budget.financial_year_id
                 ) as used_amount')
    ->from('tbl_budget')
    ->leftJoin('tbl_category', 'tbl_budget.category_id', '=', 'tbl_category.id')
    ->whereNull('tbl_budget.deleted_at')
    ->with(['category' => function ($query) {
        $query->select('tbl_category.*')
            ->withCasts(['used_amount_by_subcategory' => 'decimal:2']) // optional for formatting
            ->addSelect(DB::raw('(SELECT COALESCE(SUM(payment_milestones.milestone_total_amount), 0) 
                          FROM payment_request
                          INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                          INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                          INNER JOIN proposal ON payment_milestones.proposal_id = proposal.id
                          WHERE payment_request.category_id = tbl_category.id 
                          AND payment_request.payment_status = "completed"
                          AND proposal.proposal_year = ' . (int) request()->get('financial_year_id', 0) . '
                         ) as used_amount_by_subcategory'))
            ->whereNull('tbl_category.deleted_at')
            ->with(['children' => function ($subQuery) {
                $subQuery->select('tbl_category.*')
                    ->addSelect(DB::raw('(SELECT COALESCE(SUM(payment_milestones.milestone_total_amount), 0) 
                                  FROM payment_request
                                  INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                                  INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                                  INNER JOIN proposal ON payment_milestones.proposal_id = proposal.id
                                  WHERE payment_request.category_id = tbl_category.id 
                                  AND payment_request.payment_status = "completed"
                                  AND proposal.proposal_year = ' . (int) request()->get('financial_year_id', 0) . '
                                 ) as used_amount'))
                    ->whereNull('tbl_category.deleted_at');
            }]);
    }])
    ->orderBy('id');




        // Apply program filter if provided
        if ($categoryId) {
            $query->where('tbl_category.id', $categoryId);
        }

        // Apply financial year filter if provided
        if ($financialYearId) {
            $query->where('tbl_budget.financial_year_id', $financialYearId);
        }

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
        // $categories = [];
        $this->categories = [];

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
            $this->categories[] = [
                'category' => $budget->category->category_name, // Main category name
                'allocated' => number_format_indian($budget->amount), // Allocated amount formatted
                'sub_categories' => $subCategories, // List of subcategories
                'total_expense' => number_format_indian($budget->used_amount), // Sum of used amounts formatted
                'balance' => number_format_indian($budget->amount - $budget->used_amount), // Balance calculated and formatted
            ];
        }

        $financialYear = FinancialYear::find($financialYearId);

        // Check if the financial year exists
        if ($financialYear) {
            // Store the year in the session instead of the ID
            session(['financial_year' => $financialYear->year]);
        } else {
            // Handle the case where the financial year is not found
            session(['financial_year' => null]); // or handle as needed
        }

        // session(['program_data' => $this->data]);
        session([
            'category_data' => $this->categories,
        ]);

        // Returning the data as JSON response for DataTables or other frontend use
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $totalCount, // You can modify this if you want to return filtered count
            'data' => $this->categories,
        ]);
    }

    public function exportBudgetReport()
    {
        $expCategoryData = session('category_data', []);
        $financialYear = session('financial_year');
        // print_r($financialYear); exit();

        return Excel::download(new BudgetReportExport($expCategoryData, $financialYear), 'BUET_BE_Report.xlsx');
    }

    public function vendorreport()
    {
        $vendors=Vendor::where('vendor_status', 'verified')->orderBy('vendor_name')->get();

        return view('reports.vendor_report',compact('vendors'));
    }

   

    public function vendordata(Request $request)
{
    $searchValue = $request->input('search.value');
    $vendorId = $request->input('vendor'); // Get selected vendor

    // Get pagination parameters
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);

    // Clear the session data for vendor_data
    session()->forget(['vendor_data', 'start_date', 'end_date']);  // Remove vendor_data from session

    // Retrieve start and end date from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Build the query for verified vendors with filtered proposals and invoices
    $query = Vendor::with(['proposals' => function ($query) use ($request) {
        $query->where('proposal_status', 1)
            ->with(['invoices' => function ($query) use ($request) {
                $query->where('invoice_status', 1)
                    ->select('id', 'invoice_id', 'proposal_id', 'invoice_status', 'milestone_id', 'invoice_notes')
                    ->with(['paymentRequests' => function ($query) use ($request) {
                        $query->select('id', 'invoice_id', 'transaction_date', 'utr_number');
                        
                        // Apply date filters within the paymentRequests subquery
                        if ($request->has('start_date') && $request->start_date != '') {
                            $query->whereDate('transaction_date', '>=', \Carbon\Carbon::createFromFormat('d-m-Y', $request->start_date));
                        }
        
                        if ($request->has('end_date') && $request->end_date != '') {
                            $query->whereDate('transaction_date', '<=', \Carbon\Carbon::createFromFormat('d-m-Y', $request->end_date));
                        }
                    }]);
            }, 'paymentMilestones' => function ($query) {
                $query->select('id', 'proposal_id', 'milestone_title', 'milestone_total_amount');
            }, 'proposalro' => function ($query) {
                $query->select('id', 'proposal_id', 'proposal_ro');
            }])
            ->orderBy('id'); // Order proposals by their ID
    }])
    ->where('vendor_status', 'verified')
    
    // Use whereHas to filter vendors based on transaction_date in paymentRequests
    ->whereHas('proposals.invoices.paymentRequests', function ($query) use ($request) {
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('transaction_date', '>=', \Carbon\Carbon::createFromFormat('d-m-Y', $request->start_date));
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('transaction_date', '<=', \Carbon\Carbon::createFromFormat('d-m-Y', $request->end_date));
        }
    })
    ->orderBy('id');

    // Apply vendor filter if provided
    if ($vendorId) {
        $query->where('id', $vendorId);
    }

    // Apply search filter
    if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('vendor_name', 'LIKE', "%$searchValue%");
        });
    }

    // Get total count before pagination
    $totalCount = $query->count();

    // Apply pagination
    $vendors = $query->skip($start)->take($length)->get();

    // Initialize the vendor data array
    $this->vendorData = []; 

    foreach ($vendors as $vendor) {
        $vendorDetails = [
            'vendor_name' => $vendor->vendor_name,
            'proposals' => []
        ];

        foreach ($vendor->proposals as $proposal) {
            if ($proposal->invoices->isNotEmpty()) {
                $proposalDetails = [
                    'proposal_title' => $proposal->proposal_title,
                    'proposal_ro' => $proposal->proposalro ? $proposal->proposalro->proposal_ro : null,
                    'milestones' => [],
                    'total_milestone_amount' => 0
                ];

                foreach ($proposal->paymentMilestones as $milestone) {
                    $relatedInvoices = $proposal->invoices->where('milestone_id', $milestone->id)->where('invoice_status', 1);

                    foreach ($relatedInvoices as $invoice) {
                       
                            $milestoneDetails = [
                                'milestone_name' => $milestone->milestone_title,
                                'milestone_amount' => number_format_indian($milestone->milestone_total_amount ?? 0),
                                'invoice_id' => $invoice->invoice_id,
                                'transaction_date' => $invoice->paymentRequests ? Carbon::parse($invoice->paymentRequests->transaction_date)->format('d-m-Y') : null,
                                'utr_number' => $invoice->paymentRequests ? $invoice->paymentRequests->utr_number : null,
                                'invoice_notes' => $invoice->invoice_notes,
                            ];
                            if($milestoneDetails['transaction_date']!=null)
                            {

                            $proposalDetails['milestones'][] = $milestoneDetails;
                            $proposalDetails['total_milestone_amount'] += $milestone->milestone_total_amount;
                        }
                    }
                }

                $proposalDetails['total_milestone_amount'] = number_format_indian($proposalDetails['total_milestone_amount'], 2, '.', ',');

                if (!empty($proposalDetails['milestones'])) {
                    $vendorDetails['proposals'][] = $proposalDetails;
                }
            }
        }

        if (!empty($vendorDetails['proposals'])) {
            $this->vendorData[] = $vendorDetails;
            // session(['vendor_data' => $this->vendorData]);
        }
    }

    // Store vendor_data, start_date, and end_date in the session
    session([
        'vendor_data' => $this->vendorData,
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]);

    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalCount,
        'recordsFiltered' => $totalCount,
        'data' => $this->vendorData
    ]);
}


    public function vendordataexport()
    {
        $expvendorData = session('vendor_data', []);
        $startDate = session('start_date');
        $endDate = session('end_date');
    
        return Excel::download(new VendorExport($expvendorData, $startDate, $endDate), 'BUET_VR_Report.xlsx');
    }

    public function programmereport()
    {

        $streams=Stream::orderBy('stream_name')->get();
      
    return view('reports.programme_report',compact('streams')); // Pass data to the view if needed
}

public function programmedata(Request $request)
{
    // Get search value and pagination parameters
    $searchValue = $request->input('search.value');
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);
    $programmeId = $request->input('programme_id'); // Get the selected program ID
    
    // Clear the session data for program_data
    session()->forget(['program_data', 'start_date', 'end_date']);  // Remove program_data from session

    $startDate = $request->input('start_date'); // Get start date
    $endDate = $request->input('end_date'); // Get end date

    // Fetch all streams with their payment requests
    $query = Stream::whereHas('paymentRequests', function ($query) use ($startDate, $endDate) {
        $query->where('payment_status', 'completed');

        // Apply date filters within whereHas to ensure the Stream has relevant paymentRequests
        if ($startDate) {
            $query->where('transaction_date', '>=', Carbon::parse($startDate));
        }
        if ($endDate) {
            $query->where('transaction_date', '<=', Carbon::parse($endDate));
        }
    })
    ->with(['paymentRequests' => function ($query) use ($startDate, $endDate) { // Apply filters here too
        $query->select(
                'payment_request.stream_id',
                'payment_request.category_id', 
                'transaction_date',
                DB::raw('COALESCE(SUM(payment_milestones.milestone_total_amount), 0) as total_expense') 
            )
            ->join('invoices', 'payment_request.invoice_id', '=', 'invoices.id')
            ->join('payment_milestones', 'invoices.milestone_id', '=', 'payment_milestones.id')
            ->where('payment_request.payment_status', 'completed');

        // Apply date filters here to limit data within the date range for grouping
        if ($startDate) {
            $query->where('transaction_date', '>=', Carbon::parse($startDate));
        }
        if ($endDate) {
            $query->where('transaction_date', '<=', Carbon::parse($endDate));
        }

        $query->groupBy('payment_request.stream_id', 'payment_request.category_id', 'transaction_date');
    }]);

// Apply program filter if provided
if ($programmeId) {
    $query->where('id', $programmeId);
}

// Apply search filter if needed
if ($searchValue) {
    $query->where('stream_name', 'LIKE', "%$searchValue%"); // Filter streams by name
}



    // Print the SQL query and bindings
    // $sql = $query->toSql();
    // $bindings = $query->getBindings();

    // echo "SQL Query: " . $sql . "\n";
    // echo "Bindings: " . json_encode($bindings) . "\n";

   // exit(1);
    // Get total count before pagination
    $totalCount = $query->count();

    // Apply pagination
    $streams = $query->skip($start)->take($length)->get();

    // Initialize the data array
    $this->data = []; 

    foreach ($streams as $stream) {
        $categoriesArray = []; // Initialize categories array for this stream
        $totalProgramExpense = 0; // Initialize total program expense for this stream

        // Process each payment request for the current stream
        foreach ($stream->paymentRequests as $paymentRequest) {
            // Get the category related to the payment request
            if($paymentRequest->transaction_date != null){
            $category = Category::with('children')->find($paymentRequest->category_id);

            if ($category) {
                // Determine parent category name
                $parentCategoryName = $category->parent ? $category->parent->category_name : $category->category_name;
                 
                // Initialize parent category if it doesn't exist
                if (!isset($categoriesArray[$parentCategoryName])) {
                    $categoriesArray[$parentCategoryName] = [
                        'category_name' => $parentCategoryName,
                        'total_expense' => 0,
                        'dop' => $paymentRequest->transaction_date,
                    ];
                }

                // Update the total expense for the parent category
                $categoriesArray[$parentCategoryName]['total_expense'] += $paymentRequest->total_expense;

                // Update the total program expense
                $totalProgramExpense += $paymentRequest->total_expense;
            }
            }
        }

    
        // Push stream-wise data along with total program expense
        $this->data[] = [
            'stream_name' => $stream->stream_name,
            'total_program_expense' => number_format_indian($totalProgramExpense), // Total expense for the program
            'categories' => array_values($categoriesArray) // Convert to a standard array
        ];
    }

    // session(['program_data' => $this->data]);
    session([
        'program_data' => $this->data,
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]);

    // Return JSON response for DataTables
    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalCount,
        'recordsFiltered' => $totalCount,
        'data' =>  $this->data,
    ]);
}


public function exportprogrammedata()
{

    $expProgramData = session('program_data', []);
    $startDate = session('start_date');
    $endDate = session('end_date');

    return Excel::download(new ProgramDataExport($expProgramData, $startDate, $endDate), 'BUET_PRGM_Report.xlsx');
   
}

}