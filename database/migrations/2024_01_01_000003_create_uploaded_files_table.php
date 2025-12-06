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
        Schema::create('uploaded_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_id')->unique(); // Unique identifier for the file
            $table->string('original_name');
            $table->string('type')->default('pdf'); // File type (pdf, docx, etc.)
            $table->timestamp('expires_at'); // Auto-delete after this time
            $table->timestamps();
            
            $table->index('file_id');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_files');
    }
};

