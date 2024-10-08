<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pending_users', function (Blueprint $table) {
            $table->string('member_id')->nullable()->first(); // Add as the first column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Remove member_id from the pending_users table
         Schema::table('pending_users', function (Blueprint $table) {
            $table->dropColumn('member_id');
        });
    }
};
