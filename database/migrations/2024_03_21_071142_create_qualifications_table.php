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
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->longText('qualifications_name');
            $table->longText('name');
            $table->enum('input_type', ['select', 'input', 'checkbox', 'radio','date']);
            $table->boolean('mandatory')->default(false);
            $table->unsignedInteger('sort_order')->default(0); // New column for sorting order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('custom_form_field_options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};
