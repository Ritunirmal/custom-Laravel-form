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
        Schema::create('basic_details_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('basic_details')->onDelete('cascade');
            $table->foreignId('dependent_field_id')->constrained('basic_details')->onDelete('cascade');
            $table->foreignId('option_id')->nullable()->constrained('basic_details_options')->onDelete('cascade');
            $table->foreignId('dependent_option_id')->nullable()->constrained('basic_details_options')->onDelete('cascade');
            $table->boolean('show_options')->default(true);
            $table->boolean('disable_field')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_details_controls');
    }
};
