<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class VendorExport implements FromArray, WithEvents
{
    protected $vendorData;

    public function __construct(array $vendorData)
    {
        $this->vendorData = $vendorData;
    }

    public function array(): array
    {
        $data[] = ['Amrita Vishwa Vidyapeetham (ASE/ASA)', '', '', '', '', '', '', '','',''];
        $data[] = ['Vendor Wise - Payment Reports', '', '', '', '', '', '', '','',''];
        $data[] = ['Period: From 01-Jul-2024 To 26-Sep-2024', '', '', '', '', '', '', '','',''];
        $data[] = ['#', 'Vendor', 'Proposal', 'RO #', 'Milestone', 'Invoice #', 'Payment Date', 'Amount', 'Total'];
    
        $serialNumber = 1; // Initialize serial number for vendors
    
        foreach ($this->vendorData as $vendor) {
            $vendorRowCount = 0; // Track rows added for each vendor
    
            foreach ($vendor['proposals'] as $proposal) {
                $proposalRowCount = 0; // Track rows added for each proposal
                $milestones = $proposal['milestones'];
    
                // Only include proposals with milestones
                if (!empty($milestones)) {
                    // Prepare the row for the vendor
                    if ($vendorRowCount === 0) {
                        $data[] = [
                            $serialNumber++, // Serial number for the vendor
                            $vendor['vendor_name'],  // Vendor Name
                            '', // Proposal Title
                            '', // RO
                            '', // Milestone Name
                            '', // Milestone Amount
                            '', // Invoice ID
                            '', // Transaction Date
                            ''  // Total (if any)
                        ];
                    }
    
                    // Prepare the row for the proposal
                    if ($proposalRowCount === 0) {
                        // Fill proposal title and RO for the first milestone
                        $data[count($data) - 1][2] = $proposal['proposal_title'];
                        $data[count($data) - 1][3] = $proposal['proposal_ro'];
                        $data[count($data) - 1][8] = $proposal['total_milestone_amount'];  // Set Total for the proposal
                    }
    
                    foreach ($milestones as $milestone) {
                        $data[] = [
                            '', // Serial number (leave empty for milestone rows)
                            '', // Vendor Name (leave empty for merged cell)
                            '', // Proposal Title (leave empty for merged cell)
                            '', // RO
                            $milestone['milestone_name'], // Milestone
                            $milestone['invoice_id'], // Invoice #
                            $milestone['transaction_date'], // Payment Date
                            $milestone['milestone_amount'], // Amount
                            '',  // Leave Total empty for milestone rows
                        ];
                    }
    
                    $vendorRowCount++;
                }
            }
        }
    
        return $data;
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = count($this->vendorData) + 1; // Total rows including header
    
                // Header row styling
                $sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF0070C0'],
                    ],
                ]);
    
                // Merge cells for Vendor Name, Proposal Title, and Total
                $vendorRowCount = 0;
                foreach ($this->vendorData as $vendor) {
                    $vendorRowCount++;
    
                    // Merge vendor name cells
                    $sheet->mergeCells("A$rowCount:A" . ($rowCount + $vendorRowCount - 1));
    
                    foreach ($vendor['proposals'] as $proposal) {
                        $proposalRowCount = 0;
    
                        // Merge proposal title cells if there are multiple milestones
                        if (count($proposal['milestones']) > 1) {
                            $proposalRowCount++;
                            $sheet->mergeCells("B$rowCount:B" . ($rowCount + $proposalRowCount - 1));
                            $sheet->mergeCells("C$rowCount:C" . ($rowCount + $proposalRowCount - 1));
                            $sheet->mergeCells("I$rowCount:I" . ($rowCount + $proposalRowCount - 1)); // Merge Total column
                        }
    
                        // Increment row count by the number of milestones
                        $rowCount += count($proposal['milestones']);
                    }
                }
    
                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(30);
                $sheet->getColumnDimension('E')->setWidth(25);
                $sheet->getColumnDimension('F')->setWidth(20);
                $sheet->getColumnDimension('G')->setWidth(20);
                $sheet->getColumnDimension('H')->setWidth(20);
                $sheet->getColumnDimension('I')->setWidth(20);
    
                // Apply borders
                $sheet->getStyle("A1:H$rowCount")->applyFromArray([
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
    
}
