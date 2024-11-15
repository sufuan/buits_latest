<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAboutUsDescriptionToFrontendSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('frontend_settings', function (Blueprint $table) {
            $table->text('about_us_description')->nullable();
        });
    }

    public function down()
    {
        Schema::table('frontend_settings', function (Blueprint $table) {
            $table->dropColumn('about_us_description');
        });
    }
}
