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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('set null')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'temporary', 'freelance'])->default('full-time');
            $table->enum('experience_level', ['entry', 'mid', 'senior', 'executive'])->default('entry');
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('currency')->default('PHP');
            $table->boolean('hide_salary')->default(false);
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->enum('status', ['draft', 'published', 'closed', 'expired'])->default('draft');
            $table->integer('application_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index('company_id');
            $table->index('category_id');
            $table->index('status');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
