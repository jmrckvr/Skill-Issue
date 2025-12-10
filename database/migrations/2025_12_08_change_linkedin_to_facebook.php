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
            // Rename linkedin_url to facebook_url if it exists
            if (Schema::hasColumn('users', 'linkedin_url')) {
                $table->renameColumn('linkedin_url', 'facebook_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename back to linkedin_url if rolling back
            if (Schema::hasColumn('users', 'facebook_url')) {
                $table->renameColumn('facebook_url', 'linkedin_url');
            }
        });
    }
};
