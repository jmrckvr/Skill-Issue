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
            // Rename portfolio_url to instagram_url if it exists
            if (Schema::hasColumn('users', 'portfolio_url')) {
                $table->renameColumn('portfolio_url', 'instagram_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename back to portfolio_url if rolling back
            if (Schema::hasColumn('users', 'instagram_url')) {
                $table->renameColumn('instagram_url', 'portfolio_url');
            }
        });
    }
};
