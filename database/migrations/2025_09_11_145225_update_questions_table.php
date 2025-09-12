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
        Schema::table('questions', function (Blueprint $table) {
            // Drop existing type enum
            $table->dropColumn('type');
        });
        
        Schema::table('questions', function (Blueprint $table) {
            // Add new expanded type enum
            $table->enum('type', ['true_false', 'likert_3', 'likert_5', 'likert_7', 'multiple_choice', 'situational_choice'])
                  ->default('multiple_choice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
              Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        
        Schema::table('questions', function (Blueprint $table) {
            $table->enum('type', ['multiple_choice', 'likert_scale', 'situational_choice'])
                  ->default('multiple_choice');
        });
        });
    }
};
