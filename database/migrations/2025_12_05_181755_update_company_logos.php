<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;
use App\Models\Job;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update company logos from their jobs
        $companies = Company::all();
        foreach ($companies as $company) {
            $job = Job::where('company_id', $company->id)->first();
            if ($job && $job->logo) {
                $company->update(['logo_path' => $job->logo]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set logos back to null
        Company::query()->update(['logo_path' => null]);
    }
};
