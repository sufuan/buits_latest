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
            $table->string('title')->nullable();              // Title of the email template
            $table->text('body')->nullable();                // Body of the email
            $table->string('image')->nullable();  // Optional image in the email
            $table->string('logo')->nullable();   // Optional logo in the email
            $table->string('icon')->nullable();   // Optional icon in the email
            $table->string('button')->nullable(); // Button text
            $table->string('button_url')->nullable();  // URL for the button
            $table->text('footer_text')->nullable();    // Footer text
            $table->string('copyright_text')->nullable(); // Copyright text
         
            $table->text('about_us')->nullable(); // About Us section
            $table->string('contact_us')->nullable(); // Contact Us information
            $table->boolean('facebook')->default(1)->nullable();   // Boolean to show Facebook
            $table->boolean('instagram')->default(1)->nullable();  // Boolean to show Instagram
            $table->boolean('twitter')->default(1)->nullable();    // Boolean to show Twitter
            $table->boolean('status')->default(1)->nullable();     // Status: active or inactive (default active)
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
