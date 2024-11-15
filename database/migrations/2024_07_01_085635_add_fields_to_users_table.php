<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->enum('usertype', ['user', 'volunteer', 'executive'])->default('user');
            $table->string('session')->nullable();
            $table->string('department')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('class_roll')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('image')->nullable();
            $table->text('skills')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('custom-form')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'usertype', 'session', 'department', 'gender', 'date_of_birth',
                'blood_group', 'class_roll', 'father_name', 'mother_name', 'current_address',
                'permanent_address', 'image', 'skills', 'transaction_id', 'custom-form'
            ]);
        });
    }
}
