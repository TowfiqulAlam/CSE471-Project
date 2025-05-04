<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Link to the job (which contains the original salary)
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');

            // Link to the hired job seeker
            $table->foreignId('job_seeker_id')->constrained('users')->onDelete('cascade');

            // Task name/title
            $table->string('name');

            // Task status
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');

            // Employer approval
            $table->boolean('approved')->default(false);

            // Payment amount — copied from job.salary
            $table->decimal('payment_amount', 8, 2)->nullable();

            // Payment status
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
}
