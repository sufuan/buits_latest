<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Map the rows from the Excel file to the User model attributes.
     *
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'              => $row['name'],
            'email'             => $row['email'],
            'password'          => Hash::make($row['password']),
            'phone'             => $row['phone'],
            'usertype'          => $row['usertype'],
            'session'           => $row['session'],
            'department'        => $row['department'],
            'gender'            => $row['gender'],
            'date_of_birth'     => Carbon::parse($row['date_of_birth']),
            'blood_group'       => $row['blood_group'],
            'class_roll'        => $row['class_roll'],
            'father_name'       => $row['father_name'],
            'mother_name'       => $row['mother_name'],
            'current_address'   => $row['current_address'],
            'permanent_address' => $row['permanent_address'],
            'image'             => $row['image'],
            'skills'            => $row['skills'],
            'transaction_id'    => $row['transaction_id'],
            'custom_form'       => $row['custom_form'],
            'is_approved'       => $row['is_approved'],
        ]);
    }

    /**
     * Define validation rules for the import.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6',
            'phone'             => 'nullable|max:15',
            'usertype'          => 'required|in:,user,volunteer', // Example user types
            'date_of_birth'     => 'nullable|date_format:Y-m-d',
            'gender'            => 'required|in:male,female,other',
            'session'           => 'nullable|max:20',
            'department'        => 'nullable|string|max:100',
            'blood_group'       => 'nullable|string|max:3',
            'class_roll'        => 'nullable|numeric',
            'father_name'       => 'nullable|string|max:255',
            'mother_name'       => 'nullable|string|max:255',
            'current_address'   => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'transaction_id'    => 'nullable|string|max:100',
            'custom_form'       => 'nullable|string|max:500',
            'is_approved'       => 'nullable|boolean',
        ];
    }

    /**
     * Customize validation error messages.
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'name.required'          => 'Name is required.',
            'email.required'         => 'Email is required.',
            'email.email'            => 'Email must be a valid email address.',
            'email.unique'           => 'This email is already registered.',
            'password.required'      => 'Password is required.',
            'password.min'           => 'Password must be at least 6 characters.',
            'usertype.required'      => 'User type is required.',
            'usertype.in'            => 'Invalid user type provided.',
            'date_of_birth.date_format' => 'Date of birth must be in YYYY-MM-DD format.',
            'gender.required'        => 'Gender is required.',
            'gender.in'              => 'Invalid gender value. Accepted values: male, female, other.',
        ];
    }
}
