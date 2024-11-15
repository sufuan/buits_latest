<?php

namespace App\Exports;

use App\User; // Make sure the namespace is correct for your User model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::withTrashed()->get()->map(function ($user) {
            // If the user is deleted, return "User has been deleted" for all fields
            if ($user->deleted_at) {
                return [
                    'member_id' => $user->member_id,
                    'name' => 'User has been deleted',
                    'email' => 'User has been deleted',
                    'phone' => 'User has been deleted',
                    'usertype' => 'User has been deleted',
                    'session' => 'User has been deleted',
                    'department' => 'User has been deleted',
                    'gender' => 'User has been deleted',
                    'date_of_birth' => 'User has been deleted',
                    'blood_group' => 'User has been deleted',
                    'class_roll' => 'User has been deleted',
                    'father_name' => 'User has been deleted',
                    'mother_name' => 'User has been deleted',
                    'current_address' => 'User has been deleted',
                    'permanent_address' => 'User has been deleted',
                    'image' => 'User has been deleted',
                    'skills' => 'User has been deleted',
                    'transaction_id' => 'User has been deleted',
                    'custom_form' => 'User has been deleted',
                    'is_approved' => 'User has been deleted',
                ];
            }

            // If the user is not deleted, return actual user data
            return [
                'member_id' => $user->member_id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'usertype' => $user->usertype,
                'session' => $user->session,
                'department' => $user->department,
                'gender' => $user->gender,
                'date_of_birth' => $user->date_of_birth,
                'blood_group' => $user->blood_group,
                'class_roll' => $user->class_roll,
                'father_name' => $user->father_name,
                'mother_name' => $user->mother_name,
                'current_address' => $user->current_address,
                'permanent_address' => $user->permanent_address,
                'image' => $user->image,
                'skills' => $user->skills,
                'transaction_id' => $user->transaction_id,
                'custom_form' => $user->custom_form,
                'is_approved' => $user->is_approved,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Member ID', 
            'Name', 
            'Email', 
            'Phone', 
            'User Type', 
            'Session', 
            'Department', 
            'Gender', 
            'Date of Birth', 
            'Blood Group', 
            'Class Roll', 
            'Father Name', 
            'Mother Name', 
            'Current Address', 
            'Permanent Address', 
            'Image', 
            'Skills', 
            'Transaction ID', 
            'Custom Form', 
            'Is Approved',
        ];
    }
}
