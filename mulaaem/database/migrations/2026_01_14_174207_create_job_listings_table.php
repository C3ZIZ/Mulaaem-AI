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
        Schema::create('job_listings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('recruiter_id')->constrained('users')->cascadeOnDelete()->index();
        
        $table->string('title');
        $table->string('slug')->unique();
        $table->longText('description');
        $table->text('requirements_for_ai')->nullable();
        
        // Enum Columns
        $table->string('type')->default('full-time')->index();
        $table->string('location')->index();
        $table->string('salary_range')->nullable();
        
        // Status & Timestamps
        $table->boolean('is_active')->default(true)->index();
        $table->timestamp('closes_at')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
