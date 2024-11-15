<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'manirujjamanakash@gmail.com')->first();
        if (is_null($user)) {
            $user = new User();
            $user->name = "Maniruzzaman Akash";
            $user->email = "manirujjamanakash@gmail.com";
            $user->password = Hash::make('12345678');
            $user->phone = "1234567890"; // Example phone number
            $user->usertype = "user"; // Example user type
            $user->session = "2023"; // Example session
            $user->department = "IT"; // Example department
            $user->gender = "male"; // Example gender
            $user->date_of_birth = "1990-01-01"; // Example date of birth
            $user->blood_group = "A+"; // Example blood group
            $user->class_roll = "123"; // Example class roll
            $user->father_name = "John Doe"; // Example father's name
            $user->mother_name = "Jane Doe"; // Example mother's name
            $user->current_address = "123 Main St, City"; // Example current address
            $user->permanent_address = "456 Oak Ave, Town"; // Example permanent address
            $user->image = "avatar.jpg"; // Example image path
            $user->skills = "PHP, Laravel, JavaScript"; // Example skills
            $user->transaction_id = "ABC123XYZ"; // Example transaction ID
            $user->save();
        }
    }
}
