<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BudgetReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $categories;
    public $financialYear;
    public $recipientName;

    /**
     * @param array $categories
     * @param string|null $financialYear
     */
    public function __construct(array $categories, $financialYear = null, $recipientName = null)
    {
        $this->categories = $categories;
        $this->financialYear = $financialYear;
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        return $this->subject('Budget Utilization Report')
                    ->view('emails.budget_report')
                    ->with([
                        'categories' => $this->categories,
                        'financialYear' => $this->financialYear,
                        'recipientName' => $this->recipientName,
                    ]);
    }
}
