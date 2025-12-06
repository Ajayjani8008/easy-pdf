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
        Schema::create('conversion_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->unique(); // Unique job identifier
            $table->foreignId('uploaded_file_id')->constrained('uploaded_files')->onDelete('cascade');
            $table->string('conversion_type'); // word, excel, powerpoint, etc.
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->text('error_message')->nullable();
            $table->string('output_file_id')->nullable(); // Reference to converted file
            $table->json('metadata')->nullable(); // Additional conversion data
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index('job_id');
            $table->index('status');
            $table->index('uploaded_file_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversion_jobs');
    }
};

