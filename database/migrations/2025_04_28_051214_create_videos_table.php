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
        Schema::create('videos', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('title'); // Video Title (e.g., "Mastering Laravel Basics")
            $table->text('description')->nullable(); // Small optional description
            $table->string('url'); // YouTube / Vimeo / Uploaded video link
            $table->string('skill_name'); // Related skill (matches skills.name field)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
