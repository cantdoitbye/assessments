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
        Schema::create('result_categories', function (Blueprint $table) {
              $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "Assertive", "Passive", "Systematic"
            $table->string('code'); // e.g., "A", "B", "SYS"
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->unique(['assessment_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_categories');
    }
};
