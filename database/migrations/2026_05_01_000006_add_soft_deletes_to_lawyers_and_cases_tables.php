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
        Schema::table('lawyers', function (Blueprint $table): void {
            $table->softDeletes();
        });

        Schema::table('cases', function (Blueprint $table): void {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyers', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });

        Schema::table('cases', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
};
