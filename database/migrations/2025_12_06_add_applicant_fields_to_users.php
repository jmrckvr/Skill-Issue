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
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('email');
            $table->string('location')->nullable()->after('contact_number');
            $table->text('skills')->nullable()->after('location');
            $table->text('bio')->nullable()->after('skills');
            $table->string('profile_picture')->nullable()->after('bio');
            $table->string('resume_path')->nullable()->after('profile_picture');
            $table->string('linkedin_url')->nullable()->after('resume_path');
            $table->string('github_url')->nullable()->after('linkedin_url');
            $table->string('portfolio_url')->nullable()->after('github_url');
            $table->boolean('is_applicant')->default(false)->after('portfolio_url');
            $table->boolean('is_employer')->default(false)->after('is_applicant');
            $table->index('is_applicant');
            $table->index('is_employer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['is_applicant']);
            $table->dropIndex(['is_employer']);
            $table->dropColumn([
                'contact_number',
                'location',
                'skills',
                'bio',
                'profile_picture',
                'resume_path',
                'linkedin_url',
                'github_url',
                'portfolio_url',
                'is_applicant',
                'is_employer',
            ]);
        });
    }
};
