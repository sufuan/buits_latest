<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToAccountToPendingUsersTable extends Migration
{
    public function up()
    {
        Schema::table('pending_users', function (Blueprint $table) {
            $table->string('to_account')->after('transaction_id');
        });
    }

    public function down()
    {
        Schema::table('pending_users', function (Blueprint $table) {
            $table->dropColumn('to_account');
        });
    }
}
