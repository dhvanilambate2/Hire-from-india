<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->enum('work_type', ['full_time', 'part_time', 'contract', 'freelance', 'internship', 'temporary']);
            $table->decimal('salary', 10, 2);
            $table->enum('salary_type', ['hourly', 'weekly', 'monthly', 'yearly', 'fixed'])->default('monthly');
            $table->integer('hours_per_week')->nullable();
            $table->date('post_date');
            $table->longText('overview');
            $table->enum('status', ['active', 'closed', 'blocked'])->default('active');
            $table->text('block_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
