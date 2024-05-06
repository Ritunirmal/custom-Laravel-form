<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('user_registration_fields', function (Blueprint $table) {
            $customFields = DB::table('custom_form_fields')->get();
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            foreach ($customFields as $field) {
                switch ($field->type) {
                    case 'select':
                    case 'text':
                    case 'number':
                    case 'email':
                    case 'radio':
                        // For select, text, number, email, and radio types, create a string column
                        $table->string($field->name)->nullable();
                        break;
                    case 'checkbox':
                        // For checkbox type, create a boolean column with default value false
                        $table->boolean($field->name)->default(false);
                        break;
                    case 'date':
                        // For date type, create a date column
                        $table->date($field->name)->nullable();
                        break;
                    // Add more cases for other field types as needed
                    default:
                        // Handle unknown field types or skip them
                        break;
                }
            }
            $table->string('fee')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_registration_fields');
    }
};
