<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class StaffExport implements FromArray, WithEvents
{
    protected Collection $staffData;
    protected string|null $year;
    public $grandTotalExpense = 0;
    public $grandTotalAdvance = 0;
    public $grandTotalBalance = 0;

    public function __construct(Collection $staffData, $year = null)
    {
        $this->staffData = $staffData;
        $this->year = $year;
    }

    public function array(): array
    {
        $year = $this->year ?? 'N/A';

        $data = [];
        $data[] = ['Amrita Vishwa Vidyapeetham (ASE/ASA)', '', '', '', '', '', ''];
        $data[] = ['Staff Wise - Travel Expense', '', '', '', '', '', ''];
        $data[] = ["Year: {$year}", '', '', '', '', '', ''];
        $data[] = ['#', 'Staff', 'Trip Details', 'Date Period', 'Expense', 'Paid', 'Balance'];

        $serial = 1;

        foreach ($this->staffData as $staff) {
            $first = true;
            foreach ($staff->travelexpense as $expense) {
                // Trip name with city route
                $tripName = $expense->title ?? '';
                $source = $expense->sourceCity->name ?? 'N/A';
                $destination = $expense->destinationCity->name ?? 'N/A';
                $tripDetails = "{$tripName} ({$source} → {$destination})";

                // Date period + days
                $fromDate = \Carbon\Carbon::parse($expense->from_date);
                $toDate = \Carbon\Carbon::parse($expense->to_date);
                $days = $fromDate->diffInDays($toDate) + 1;
                $datePeriod = $fromDate->format('d-m-y') . ' to ' . $toDate->format('d-m-y') . " ({$days} days)";

                $expenseAmount = $expense->amount ?? 0;
                $advanceAmount = $expense->advance_amount ?? 0;
                $finalamount = $expense->final_amount ?? 0;
                $paidamount = abs($advanceAmount + $finalamount);
                $balance = abs($expenseAmount - $paidamount);

                $data[] = [
                    $first ? $serial : '',                    // #
                    $first ? $staff->name : '',               // Staff
                    $tripDetails,                             // Trip Details
                    $datePeriod,                              // Period
                    number_format($expenseAmount, 2),         // Expense
                    number_format($paidamount, 2),         // Paid
                    number_format($balance, 2),               // Balance
                ];

                $first = false;
            }

            $serial++;
        }

        return $data;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = 5; // First 4 rows are for title and headers
    
                // 🔹 Merge and style titles
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                $this->applyTitleStyle($sheet, 'A1:G1');
                $this->applyTitleStyle($sheet, 'A2:G2');
                $this->applyTitleStyle($sheet, 'A3:G3');

                // 🔹 Header styling
                $sheet->getStyle('A4:G4')->applyFromArray($this->getHeaderStyle());

                // 🔹 Freeze header row
                $sheet->freezePane('A5');

                // 🔹 Column widths
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(30); // Staff
                $sheet->getColumnDimension('C')->setWidth(40); // Trip Details
                $sheet->getColumnDimension('D')->setWidth(30); // Date Period
                $sheet->getColumnDimension('E')->setWidth(20); // Expense
                $sheet->getColumnDimension('F')->setWidth(20); // Paid
                $sheet->getColumnDimension('G')->setWidth(20); // Balance
    
                // 🔹 Font & alignment for all cells
                $sheet->getStyle('A:G')->applyFromArray([
                    'font' => ['name' => 'Verdana', 'size' => 10],
                    'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                ]);

                $serial = 1;

                foreach ($this->staffData as $staff) {
                    $expenseCount = $staff->travelexpense->count();
                    $first = true;

                    foreach ($staff->travelexpense as $expense) {
                        $fromDate = \Carbon\Carbon::parse($expense->from_date);
                        $toDate = \Carbon\Carbon::parse($expense->to_date);
                        $days = $fromDate->diffInDays($toDate) + 1;
                        $period = $fromDate->format('d-m-y') . ' to ' . $toDate->format('d-m-y') . " ({$days} days)";

                        $trip = ($expense->title ?? ' ') . ' (' .
                            ($expense->sourceCity->name ?? 'N/A') . ' → ' .
                            ($expense->destinationCity->name ?? 'N/A') . ')';

                        $expenseAmount = $expense->amount ?? 0;
                        $advanceAmount = $expense->advance_amount ?? 0;
                        $finalamount = $expense->final_amount ?? 0;
                        $paidamount = abs($advanceAmount + $finalamount);
                        $balance = abs($expenseAmount - $paidamount);

                        $this->grandTotalExpense += $this->convertToFloat($expenseAmount);
                        $this->grandTotalAdvance += $this->convertToFloat($paidamount);
                        $this->grandTotalBalance += $this->convertToFloat($balance);

                        // 🔹 Merge cells for serial number and staff name
                        if ($first && $expenseCount > 1) {
                            $mergeRow = $rowCount + $expenseCount - 1;
                            $sheet->mergeCells("A$rowCount:A$mergeRow");
                            $sheet->mergeCells("B$rowCount:B$mergeRow");
                            $sheet->setCellValue("A$rowCount", $serial++);
                            $sheet->setCellValue("B$rowCount", $staff->name);
                            $first = false;
                        } elseif ($first) {
                            $sheet->setCellValue("A$rowCount", $serial++);
                            $sheet->setCellValue("B$rowCount", $staff->name);
                            $first = false;
                        }

                        // 🔹 Fill data row
                        $sheet->setCellValue("C$rowCount", $trip);
                        $sheet->setCellValue("D$rowCount", $period);
                        $sheet->setCellValue("E$rowCount", number_format_indian($expenseAmount));
                        $sheet->setCellValue("F$rowCount", number_format_indian($paidamount));
                        $sheet->setCellValue("G$rowCount", number_format_indian($balance));

                        $rowCount++;
                    }
                }

                // 🔹 Grand Total Row
                $sheet->mergeCells("A$rowCount:D$rowCount");
                $sheet->setCellValue("A$rowCount", "Grand Total");
                $sheet->getStyle("A$rowCount:D$rowCount")->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $sheet->setCellValue("E$rowCount", number_format_indian($this->grandTotalExpense ?? 0));
                $sheet->setCellValue("F$rowCount", number_format_indian($this->grandTotalAdvance ?? 0));
                $sheet->setCellValue("G$rowCount", number_format_indian($this->grandTotalBalance ?? 0));

                // 🔹 Style grand total row
                $sheet->getStyle("A$rowCount:G$rowCount")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEFEFEF'],
                    ],
                ]);

                // 🔹 Optional: Format numbers as currency
                $sheet->getStyle("E5:G$rowCount")->getNumberFormat()
                    ->setFormatCode('#,##0.00');

                // 🔹 Apply borders to the full range
                $sheet->getStyle("A1:G$rowCount")->applyFromArray([
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