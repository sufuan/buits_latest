<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');              // Title of the email template
            $table->text('body');                 // Body of the email
            $table->string('image')->nullable();  // Optional image in the email
            $table->string('logo')->nullable();   // Optional logo in the email
            $table->string('icon')->nullable();   // Optional icon in the email
            $table->string('button')->nullable(); // Button text
            $table->string('button_url')->nullable();  // URL for the button
            $table->text('footer_text')->nullable();    // Footer text
            $table->string('copyright_text')->nullable(); // Copyright text
            $table->string('type');               // Type of the email (e.g., promotional, transactional)
            $table->text('about_us')->nullable(); // About Us section
            $table->string('contact_us')->nullable(); // Contact Us information
            $table->string('facebook')->nullable();   // Facebook URL
            $table->string('instagram')->nullable();  // Instagram URL
            $table->string('twitter')->nullable();    // Twitter URL
            $table->boolean('status')->default(1);    // Status: active or inactive
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
        Schema::dropIfExists('email_templates');
    }
}
