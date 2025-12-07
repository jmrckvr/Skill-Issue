<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\Company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Assign company logos to jobs that don't have their own logo
        $jobs = Job::whereNull('logo')->get();

        foreach ($jobs as $job) {
            $company = Company::find($job->company_id);
            if ($company && $company->logo_path) {
                $job->update(['logo' => $company->logo_path]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set logos back to null for jobs that inherited them
        DB::table('jobs')->whereNull('logo')->orWhereRaw('logo LIKE "%pinimg%"')->update(['logo' => null]);
    }
};
