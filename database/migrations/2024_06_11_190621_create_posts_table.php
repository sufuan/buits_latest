<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable(); // Add password field
            $table->enum('post_status', ['pending', 'published'])->default('pending');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Make user_id nullable
            $table->string('phone')->nullable();
            $table->string('session')->nullable();
            $table->string('department')->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->text('skills')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('custom_form')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
