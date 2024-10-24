<?php
namespace App\Services;

use App\User;

class MemberIdService
{
    public function generateNewMemberId($volunteer, $isUpdate = false, $existingMemberId = null)
    {
        // Define department codes
        $departmentCodes = [
            "Marketing" => "04",
            "Law" => "15",
            "Mathematics" => "05",
            "Physics" => "18",
            "History & Civilization" => "23",
            "Soil & Environmental Sciences" => "10",
            "Economics" => "01",
            "Geology & Mining" => "17",
            "Management Studies" => "03",
            "Statistics" => "24",
            "Chemistry" => "12",
            "Coastal Studies and Disaster Management" => "19",
            "Accounting & Information Systems" => "07",
            "Computer Science and Engineering" => "13",
            "Sociology" => "06",
            "Botany" => "11",
            "Public Administration" => "09",
            "Philosophy" => "20",
            "Political Science" => "16",
            "Biochemistry and Biotechnology" => "21",
            "Finance and Banking" => "14",
            "Mass Communication and Journalism" => "22",
            "English" => "02",
            "Bangla" => "08"
        ];

        // Get department code
        $departmentCode = $departmentCodes[$volunteer->department] ?? null;

        // Check if the department code is valid
        if (!$departmentCode) {
            throw new \Exception('Invalid department.');
        }

        // Extract last two digits of the session (assuming session format is YYYY-YYYY)
        $sessionYear = explode('-', $volunteer->session);
        $lastTwoDigitsOfSession = substr(end($sessionYear), -2);

        // If this is an update, preserve the last form number and only update the department and session
        if ($isUpdate && $existingMemberId) {
            // Extract the last form number from the existing member ID (last 4 digits)
            $lastFormNumber = substr($existingMemberId, -4);
        } else {
            // For new users, generate a new form number
            $lastFormNumber = $this->getNewFormNumber();
        }

        // Return the new member ID with department code, session year, and the form number
        $newMemberId = $departmentCode . $lastTwoDigitsOfSession . $lastFormNumber;

        return $newMemberId;
    }

    private function getNewFormNumber()
    {
        // Fetch the last member ID by ordering the users table by 'id' in descending order
        $lastMember = User::orderBy('id', 'desc')->first();

        // Initialize the default starting number
        $newFormNumber = 1130;

        if ($lastMember) {
            // Extract the last four digits of the member_id from the last record
            $lastFormNumber = (int)substr($lastMember->member_id, -4);

            // Increment the last form number by 1 (only for new user creation)
            $newFormNumber = $lastFormNumber + 1;
        }

        // Return the new form number, padded to 4 digits
        return str_pad($newFormNumber, 4, '0', STR_PAD_LEFT);
    }
}
