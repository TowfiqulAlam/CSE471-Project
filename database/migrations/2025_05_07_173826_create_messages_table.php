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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
        
            // Sender (employer or job seeker)
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        
            // Receiver (employer or job seeker)
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
        
            // Job context
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
        
            // Message content
            $table->text('message');
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
