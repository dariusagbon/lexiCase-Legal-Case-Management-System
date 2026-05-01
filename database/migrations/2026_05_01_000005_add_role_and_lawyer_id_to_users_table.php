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
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role')->default('admin')->after('email');
            $table->unsignedBigInteger('lawyer_id')->nullable()->after('role');
            $table->foreign('lawyer_id')->references('id')->on('lawyers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['lawyer_id']);
            $table->dropColumn(['lawyer_id', 'role']);
        });
    }
};
