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
        Schema::table('custom_form_field_options', function (Blueprint $table) {
            $table->integer('data_extra_years')->nullable()->default(0)->after('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_form_field_options', function (Blueprint $table) {
            $table->dropColumn('data_extra_years');
        });
    }
};
