<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Define department codes.
     */
    protected $departmentCodes = [
        "marketing" => "04",
        "law" => "15",
        "mathematics" => "05",
        "physics" => "18",
        "history and civilization" => "23",
        "soil and environmental sciences" => "10",
        "economics" => "01",
        "geology and mining" => "17",
        "management studies" => "03",
        "statistics" => "24",
        "chemistry" => "12",
        "coastal studies and disaster management" => "19",
        "accounting and information systems" => "07",
        "computer science and engineering" => "13",
        "sociology" => "06",
        "botany" => "11",
        "public administration" => "09",
        "philosophy" => "20",
        "political science" => "16",
        "biochemistry and biotechnology" => "21",
        "finance and banking" => "14",
        "mass communication and journalism" => "22",
        "english" => "02",
        "bangla" => "08"
    ];

    /**
     * Normalize department names.
     */
    private function normalizeDepartmentName($department)
    {
        // Replace "&" with "and", convert to lowercase, and trim spaces
        return strtolower(str_replace('&', 'and', trim($department)));
    }

    /**
     * Map the rows from the Excel file to the User model attributes.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Check if essential fields are empty and skip row if they are
        if (empty($row['name']) || empty($row['email']) || empty($row['password']) || empty($row['department'])) {
            return null; // Skip this row if essential fields are missing
        }
    
        // Normalize the department name
        $departmentName = $this->normalizeDepartmentName(trim($row['department']));
        $departmentCode = $this->departmentCodes[$departmentName] ?? null;
    
        if (!$departmentCode) {
            throw new \Exception('Invalid department in the imported data: ' . trim($row['department']));
        }
    
        $sessionYear = explode('-', trim($row['session']));
        $lastTwoDigitsOfSession = substr(end($sessionYear), -2);
    
        // Check if member_id exists in the Excel row; if not, generate a new one
        $memberId = isset($row['member_id']) ? trim($row['member_id']) : $this->generateNewMemberId($departmentCode, $lastTwoDigitsOfSession);
    
        // Ensure the member_id is unique
        $existingMember = User::where('member_id', $memberId)->first();
        if ($existingMember) {
            return null; // Skip the row if the member ID already exists
        }
    
        // Handle nullable date of birth
        $dateOfBirth = $this->parseDate($row['date_of_birth'] ?? null);
    
        return new User([
            'name'              => trim($row['name']),
            'email'             => trim($row['email']),
            'password'          => Hash::make(trim($row['password'])),
            'phone'             => trim($row['phone']),
            'usertype'          => trim($row['usertype']),
            'session'           => trim($row['session']),
            'department'        => trim($row['department']),
            'gender'            => trim($row['gender']),
            'date_of_birth'     => $dateOfBirth,
            'blood_group'       => trim($row['blood_group']),
            'class_roll'        => trim($row['class_roll']),
            'father_name'       => trim($row['father_name']),
            'mother_name'       => trim($row['mother_name']),
            'current_address'   => trim($row['current_address']),
            'permanent_address' => trim($row['permanent_address']),
            'image'             => trim($row['image']),
            'skills'            => trim($row['skills']),
            'transaction_id'    => trim($row['transaction_id']),
            'custom_form'       => trim($row['custom_form']),
            'is_approved'       => trim($row['is_approved']),
            'member_id'         => $memberId,
        ]);
    }
    
    
    /**
     * Helper function to parse date from various formats or Excel date format.
     */
    private function parseDate($date)
    {
        // Check if the date is a numeric Excel date and convert it
        if (is_numeric($date)) {
            // Convert Excel numeric date to a PHP date
            return Carbon::createFromDate(1900, 1, 1)->addDays($date - 2); // Excel starts on 1/1/1900; subtract 2 for correct offset
        }
    
        // Otherwise, parse as a standard date string
        return Carbon::parse($date);
    }
    

    /**
     * Generate a new unique member ID based on the highest numeric part across all member IDs.
     */
    private function generateNewMemberId($departmentCode, $lastTwoDigitsOfSession)
    {
        // Fetch the last member ID by ordering the users table by 'id' in descending order
        $lastMember = User::orderBy('id', 'desc')->first();

        // Initialize the default starting number
        $newFormNumber = 1130;

        if ($lastMember) {
            // Extract the last four digits of the member_id from the last record
            $lastFormNumber = (int)substr($lastMember->member_id, -4);

            // Increment the last form number by 1
            $newFormNumber = $lastFormNumber + 1;
        }

        // Return the new member ID with department code, session year, and the new form number
        return $departmentCode . $lastTwoDigitsOfSession . str_pad($newFormNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Define validation rules for the import.
     */
    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6',
            'phone'             => 'required|max:15',
            'usertype'          => 'required|in:user,volunteer',
            'date_of_birth'     => 'nullable', // Ensure it's a valid date
            'gender'            => 'required|in:male,female', // Include "other"
            'session'           => 'required|max:20',
            'department'        => 'required|string|max:100',
            'blood_group'       => 'nullable|string|max:3',
            'class_roll'        => 'required|string',
            'father_name'       => 'required|string|max:255',
            'mother_name'       => 'required|string|max:255',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'transaction_id'    => 'required|string|max:100',
            'custom_form'       => 'nullable|string|max:500',
            'is_approved'       => 'required|boolean',
        ];
    }

    /**
     * Customize validation error messages.
     */
    public function customValidationMessages()
    {
        return [
            'member_id.required'       => 'Member ID is required.',
            'name.required'            => 'Name is required.',
            'email.required'           => 'Email is required.',
            'email.email'              => 'Email must be a valid email address.',
            'email.unique'             => 'This email is already registered.',
            'password.required'        => 'Password is required.',
            'password.min'             => 'Password must be at least 6 characters.',
            'usertype.required'        => 'User type is required.',
            'usertype.in'              => 'Invalid user type provided.',
            'date_of_birth.date_format' => 'Date of birth must be in YYYY-MM-DD format.',
            'gender.required'          => 'Gender is required.',
            'gender.in'                => 'Invalid gender value. Accepted values: male, female.',
        ];
    }
}
