<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Lawyer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For any lawyer users without a lawyer_id, try to link them to existing lawyer by email
        $lawyerUsers = User::where('role', 'lawyer')->whereNull('lawyer_id')->get();
        
        foreach ($lawyerUsers as $user) {
            $lawyer = Lawyer::where('email', $user->email)->first();
            
            if ($lawyer) {
                $user->update(['lawyer_id' => $lawyer->id]);
            } else {
                // Create a lawyer record if none exists
                $newLawyer = Lawyer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => '',
                    'specialization' => '',
                    'experience_years' => 0,
                ]);
                $user->update(['lawyer_id' => $newLawyer->id]);
            }

          
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a data fix, reversing would be complex. Intentionally left empty.
    }
};
