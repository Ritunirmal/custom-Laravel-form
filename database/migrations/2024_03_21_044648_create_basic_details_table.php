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
        Schema::create('basic_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['select', 'text','textarea','email','number' ,'checkbox', 'radio','date','file']);
            $table->longText('label');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('pattern', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('readonly')->default(false);
            $table->timestamps();
        });
    }
  
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_details');
    }
};
