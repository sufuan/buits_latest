<?php

namespace App\Exports;

use App\User ;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select([
            'id', 
            'name', 
            'email', 
            'phone', 
            'usertype', 
            'session', 
            'department', 
            'gender', 
            'date_of_birth', 
            'blood_group', 
            'class_roll', 
            'father_name', 
            'mother_name', 
            'current_address', 
            'permanent_address', 
            'image', 
            'skills', 
            'transaction_id', 
            'custom-form', 
            'is_approved',
        ])->get(); // Fetch all user data except password
    }

    public function headings(): array
    {
        return [
            'id', 
            'name', 
            'email', 
            'phone', 
            'usertype', 
            'session', 
            'department', 
            'gender', 
            'date_of_birth', 
            'blood_group', 
            'class_roll', 
            'father_name', 
            'mother_name', 
            'current_address', 
            'permanent_address', 
            'image', 
            'skills', 
            'transaction_id', 
            'custom-form', 
            'is_approved',
        ];
    }
}
