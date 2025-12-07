<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Job;
use App\Models\Company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Assign company logos to jobs that don't have logos
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
        // Jobs that had null logos are set back to null
        Job::whereNotNull('logo')->each(function ($job) {
            $company = Company::find($job->company_id);
            if ($company && $company->logo_path && $job->logo === $company->logo_path) {
                $job->update(['logo' => null]);
            }
        });
    }
};
