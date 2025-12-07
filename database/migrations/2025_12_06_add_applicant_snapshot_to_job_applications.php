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
        // Add columns to existing job_applications table if it exists
        if (Schema::hasTable('job_applications')) {
            Schema::table('job_applications', function (Blueprint $table) {
                if (!Schema::hasColumn('job_applications', 'applicant_name')) {
                    $table->string('applicant_name')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('job_applications', 'applicant_email')) {
                    $table->string('applicant_email')->nullable()->after('applicant_name');
                }
                if (!Schema::hasColumn('job_applications', 'applicant_phone')) {
                    $table->string('applicant_phone')->nullable()->after('applicant_email');
                }
                if (!Schema::hasColumn('job_applications', 'applicant_location')) {
                    $table->string('applicant_location')->nullable()->after('applicant_phone');
                }
                if (!Schema::hasColumn('job_applications', 'applicant_skills')) {
                    $table->text('applicant_skills')->nullable()->after('applicant_location');
                }
                if (!Schema::hasColumn('job_applications', 'applicant_bio')) {
                    $table->text('applicant_bio')->nullable()->after('applicant_skills');
                }
                if (!Schema::hasColumn('job_applications', 'applicant_profile_picture')) {
                    $table->string('applicant_profile_picture')->nullable()->after('applicant_bio');
                }
                if (!Schema::hasColumn('job_applications', 'resume_path')) {
                    $table->string('resume_path')->nullable()->after('applicant_profile_picture');
                }
                if (!Schema::hasColumn('job_applications', 'application_status')) {
                    $table->enum('application_status', ['pending', 'reviewed', 'rejected', 'hired'])->default('pending')->after('resume_path');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('job_applications')) {
            Schema::table('job_applications', function (Blueprint $table) {
                $columns = [
                    'applicant_name',
                    'applicant_email',
                    'applicant_phone',
                    'applicant_location',
                    'applicant_skills',
                    'applicant_bio',
                    'applicant_profile_picture',
                    'resume_path',
                    'application_status',
                ];

                $existingColumns = [];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('job_applications', $column)) {
                        $existingColumns[] = $column;
                    }
                }

                if (!empty($existingColumns)) {
                    $table->dropColumn($existingColumns);
                }
            });
        }
    }
};
