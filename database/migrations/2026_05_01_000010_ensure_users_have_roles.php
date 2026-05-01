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
        // Ensure all users have a proper role - set to 'lawyer' if null or empty
        DB::table('users')
            ->where('role', null)
            ->orWhere('role', '')
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
