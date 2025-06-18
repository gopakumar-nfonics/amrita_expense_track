<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class StaffImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        \Log::info('Starting collection processing. Total rows: ' . $collection->count());
        foreach ($collection as $row) {
            try {
                $designationName = trim($row['designation'] ?? '');

                if (empty($designationName)) {
                    throw new \Exception('Designation is empty');
                }

                $designation = Designation::where('title', $designationName)->first();

                if (!$designation) {
                    $designation = Designation::create([
                        'title' => $designationName,
                        'code' => $this->generateDesignationCode($designationName)
                    ]);
                }
                \Log::info('Designation created/found: ' . json_encode($designation->toArray()));


                Staff::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => \Hash::make((string) $row['password']),
                    'designation_id' => $designation->id,
                    'created_by' => Auth::id(),
                ]);
                \Log::info('Row imported successfully: ' . $row['email']);
            } catch (\Exception $e) {
                \Log::error('Error importing row: ' . json_encode($row) . ' - ' . $e->getMessage());
            }
        }
    }

    private function generateDesignationCode($designationName)
    {
        // Generate acronym from first letters of each word
        $words = preg_split('/\s+/', $designationName);
        $acronym = '';
        foreach ($words as $word) {
            $acronym .= strtoupper($word[0]);
        }

        // If acronym is too short, fallback to first 3 letters
        if (strlen($acronym) < 2) {
            $acronym = strtoupper(substr($designationName, 0, 3));
        }

        // Ensure uniqueness of code
        $baseCode = $acronym;
        $code = $baseCode;
        $counter = 1;

        while (Designation::where('code', $code)->exists()) {
            $code = $baseCode . $counter;
            $counter++;
        }

        return $code;
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required',
            '*.email' => 'required|email|unique:tbl_staff,email',
            '*.password' => 'required|min:8',
            '*.designation' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.name.required' => 'Name is required.',
            '*.email.required' => 'Email is required.',
            '*.email.email' => 'Email must be a valid email address.',
            '*.email.unique' => 'Email has already been taken.',
            '*.password.required' => 'Password is required.',
            '*.designation.required' => 'Designation is required.',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = $failure;
            \Log::error('Row ' . $failure->row() . ' failed validation: ' . json_encode($failure->errors()));
        }
    }
}
