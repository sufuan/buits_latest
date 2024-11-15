<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontendSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontend_settings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable()->default('BUITS'); 
            $table->string('logo')->nullable();   // Logo of the business
            $table->string('phone')->nullable();  // Contact phone number
            $table->string('email')->nullable();  // Contact email
            $table->string('address')->nullable(); // Address of the business
            $table->text('footer_text')->nullable(); // Footer text for the frontend
            $table->string('facebook')->nullable();   // Facebook URL
            $table->string('instagram')->nullable();  // Instagram URL
            $table->string('twitter')->nullable();    // Twitter URL
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frontend_settings');
    }
}
