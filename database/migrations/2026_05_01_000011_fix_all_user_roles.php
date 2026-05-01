<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set any NULL or empty roles to 'lawyer' as default
        DB::table('users')
            ->whereNull('role')
            ->orWhere('role', '')
            ->update(['role' => 'lawyer']);

        // Optional: Verify all roles are either 'admin' or 'lawyer'
        // If there are other values, set them to 'lawyer'
        DB::table('users')
            ->whereNotIn('role', ['admin', 'lawyer'])
            ->update(['role' => 'lawyer']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left empty
    }
};
