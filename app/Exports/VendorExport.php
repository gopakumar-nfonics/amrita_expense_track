<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class VendorExport implements FromArray, WithEvents
{
    protected $vendorData;
    protected $grandTotalAmount = 0;
    protected $grandTotalProposalAmount = 0;
    protected $startDate;
    protected $endDate;

    public function __construct(array $vendorData, $startDate, $endDate)
    {
        $this->vendorData = $vendorData;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function array(): array
{
    // Format start and end dates if they are provided
    $formattedStartDate = $this->startDate ? \Carbon\Carbon::parse($this->startDate)->format('d-M-Y') : 'N/A';
    $formattedEndDate = $this->endDate ? \Carbon\Carbon::parse($this->endDate)->format('d-M-Y') : 'N/A';

    $data[] = ['Amrita Vishwa Vidyapeetham (ASE/ASA)', '', '', '', '', '', '', '', '',''];
    $data[] = ['Vendor Wise - Payment Reports', '', '', '', '', '', '', '','', ''];
    $data[] = ["Period: From {$formattedStartDate} To {$formattedEndDate}", '', '', '', '', '', '', '','', ''];
    $data[] = ['#', 'Vendor', 'Proposal', 'RO #', 'Milestone', 'Invoice #', 'Invoice Description','Payment Date','UTR #', 'Amount', 'Total'];

    $serialNumber = 1; // Initialize serial number for vendors

    foreach ($this->vendorData as $vendor) {
        $vendorRowCount = 0; // Track rows added for each vendor

        foreach ($vendor['proposals'] as $proposal) {
            $milestones = $proposal['milestones'];

            if (!empty($milestones)) {
                // For the first milestone of each vendor, add vendor and proposal data
                if ($vendorRowCount === 0) {
                    $data[] = [
                        $serialNumber++, // Serial number for the vendor
                        $vendor['vendor_name'],  // Vendor Name
                        $proposal['proposal_title'],  // Proposal Title (only for first milestone)
                        $proposal['proposal_ro'],     // RO (only for first milestone)
                        $milestones[0]['milestone_name'], // First Milestone Name
                        $milestones[0]['invoice_id'], // First Milestone Invoice #
                        $milestones[0]['invoice_notes'],
                        $milestones[0]['transaction_date'], // First Milestone Payment Date
                        $milestones[0]['milestone_amount'], // First Milestone Amount
                        $milestones[0]['utr_number'], // First utr_number
                        $proposal['total_milestone_amount'],  // Total (for proposal)
                    ];

                    // Update grand total for amount from the first milestone
                    $this->grandTotalAmount += $this->convertToFloat($milestones[0]['milestone_amount'] ?? 0);
                }

                $proposalAmount = $proposal['total_milestone_amount'] ?? 0;
                $this->grandTotalProposalAmount += $this->convertToFloat($proposalAmount);

                // For subsequent milestones, leave the vendor and proposal fields empty
                for ($i = 1; $i < count($milestones); $i++) {
                    $data[] = [
                        '', // Serial number
                        '', // Vendor Name (leave empty for subsequent milestones)
                        '', // Proposal Title (leave empty for subsequent milestones)
                        '', // RO (leave empty for subsequent milestones)
                        $milestones[$i]['milestone_name'], // Milestone
                        $milestones[$i]['invoice_id'], // Invoice #
                        $milestones[$i]['invoice_notes'],
                        $milestones[$i]['transaction_date'], // Payment Date
                        $milestones[$i]['milestone_amount'], // Amount
                        $milestones[$i]['utr_number'],
                        
                        '',  // Leave Total empty for milestone rows
                    ];

                    // Accumulate the grand total for each subsequent milestone
                    $this->grandTotalAmount += $this->convertToFloat($milestones[$i]['milestone_amount'] ?? 0);
                }

                $vendorRowCount++;
            }
        }
    }

        // Total row
        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

    
        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = 5; // Starting after headers (first 4 rows for titles and headers)
    
                // Title row styling
                $sheet->mergeCells('A1:K1');
                $sheet->mergeCells('A2:K2');
                $sheet->mergeCells('A3:K3');
                $this->applyTitleStyle($sheet, 'A1:K1');
                $this->applyTitleStyle($sheet, 'A2:K2');
                $this->applyTitleStyle($sheet, 'A3:K3');
    
                // Header row styling
                $sheet->getStyle('A4:K4')->applyFromArray($this->getHeaderStyle());
    
                // Apply default font and vertical alignment
                $sheet->getStyle('A:K')->applyFromArray([
                    'font' => ['name' => 'Verdana', 'size' => 11],
                    'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                ]);
    
                $serialNumber = 1;

                
            // Bold and align specific columns (C, E, F, G)
            $this->applyBoldRightAlign($sheet, 'J');
            $this->applyBoldRightAlign($sheet, 'K');

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(40);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(50);
            $sheet->getColumnDimension('H')->setWidth(25);
            $sheet->getColumnDimension('I')->setWidth(25);
            $sheet->getColumnDimension('J')->setWidth(25);
            $sheet->getColumnDimension('K')->setWidth(25);
    
                // Iterate over each vendor and their proposals
                foreach ($this->vendorData as $vendor) {
                    // Track the starting row for this vendor
                    $vendorRowStart = $rowCount;
    
                    // Count the total number of milestones for this vendor across all proposals
                    $totalMilestones = array_sum(array_map(function ($proposal) {
                        return count($proposal['milestones']);
                    }, $vendor['proposals']));
    
                    // Merge vendor name across the required number of rows
                    if ($totalMilestones > 1) {
                        $sheet->mergeCells("A$rowCount:A" . ($rowCount + $totalMilestones - 1));
                        $sheet->mergeCells("B$rowCount:B" . ($rowCount + $totalMilestones - 1));
                    }
    
                    // Set the vendor name and serial number in the first row for this vendor
                    $sheet->setCellValue("A$rowCount", $serialNumber++);
                    $sheet->setCellValue("B$rowCount", $vendor['vendor_name']);
    
                    // Loop through each proposal
                    foreach ($vendor['proposals'] as $proposal) {
                        // Track the starting row for this proposal
                        $proposalRowStart = $rowCount;
    
                        // Count the number of milestones for this proposal
                        $milestoneCount = count($proposal['milestones']);
    
                        // Merge proposal title and RO # across the required number of rows if there are multiple milestones
                        if ($milestoneCount > 1) {
                            $sheet->mergeCells("C$rowCount:C" . ($rowCount + $milestoneCount - 1));
                            $sheet->mergeCells("D$rowCount:D" . ($rowCount + $milestoneCount - 1));
                            $sheet->mergeCells("K$rowCount:K" . ($rowCount + $milestoneCount - 1)); // Merge total amount column
                        }
    
                        // Set the proposal title and RO number in the first row for this proposal
                        $sheet->setCellValue("C$rowCount", $proposal['proposal_title']);
                        $sheet->setCellValue("D$rowCount", $proposal['proposal_ro']);
                        $sheet->setCellValue("K$rowCount", $proposal['total_milestone_amount']);
    
                        // Loop through each milestone for this proposal
                        foreach ($proposal['milestones'] as $milestone) {
                            // Set the milestone details for each milestone row
                            $sheet->setCellValue("E$rowCount", $milestone['milestone_name']);
                            $sheet->setCellValue("F$rowCount", $milestone['invoice_id']);
                            $sheet->setCellValue("G$rowCount", $milestone['invoice_notes']);
                            $sheet->setCellValue("H$rowCount", $milestone['transaction_date']);
                            $sheet->setCellValue("I$rowCount", $milestone['utr_number']);
                            $sheet->setCellValue("J$rowCount", $milestone['milestone_amount']);
    
                            // Increment the row count after processing each milestone
                            $rowCount++;
                        }
                    }
                }
    
                $lastRow = $rowCount+1; // $rowIndex is the current row after all category and subcategory rows

                $sheet->getStyle("A$lastRow:K$lastRow")->applyFromArray($this->getTotalRowStyle());
                
                $sheet->mergeCells("A$lastRow:J$lastRow");

                $sheet->setCellValue("A$lastRow", 'Grand Total ');
                //$sheet->setCellValue("H$lastRow", number_format_indian($this->grandTotalAmount)); // Accessing the class property
                $sheet->setCellValue("k$lastRow", number_format_indian($this->grandTotalProposalAmount)); // Accessing the class property

                $sheet->getStyle("A$lastRow:I$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                
                // Apply borders to the data range
                $sheet->getStyle("A1:K$rowCount")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
    



   
// Helper to get border style
private function getBorderStyle()
{
    return [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];
}


    // Helper to style title rows
    private function applyTitleStyle($sheet, $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'name' => 'Verdana'],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE2E2E2'],
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
    }

    // Helper to apply bold and right alignment to specific columns
    private function applyBoldRightAlign($sheet, $column)
    {
        $sheet->getStyle($column)->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
            ],
        ]);
    }

    // Helper to get header row style
    private function getHeaderStyle()
    {
        return [
            'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF'], 'name' => 'Verdana'],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0070C0'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
    }

    // Helper to get total row style
    private function getTotalRowStyle()
    {
        return [
            'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF'], 'name' => 'Verdana'],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0070C0'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
    }

    // Helper to convert values to float
    private function convertToFloat($value)
    {
        return floatval(str_replace(',', '', $value));
    }
 
    
}