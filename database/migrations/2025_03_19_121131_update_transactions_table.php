<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Add signature for transaction verification
            $table->string('signature')->nullable()->before('created_at');
            $table->boolean('is_locked')->default(true)->before('created_at');
            
            
            // Replace separate reference_id and reference_type with morphs if they exist
            if (Schema::hasColumn('transactions', 'reference_id') && Schema::hasColumn('transactions', 'reference_type')) {
                // Drop the existing columns
                $table->dropColumn(['reference_id', 'reference_type']);
                
                // Add the morphs columns
                $table->nullableMorphs('reference'); // Morphs will create `reference_id` & `reference_type`
               
            } 
            // If they don't exist, just add the morphs columns
            else {
                $table->nullableMorphs('reference'); // Morphs will create `reference_id` & `reference_type`
            
            }
            
            // Add reconciliation related fields
            $table->timestamp('last_verified_at')->nullable()->before('created_at');
    
            
            // Add indexes for better performance if they don't exist
            if (!Schema::hasIndex('transactions', ['user_id', 'type', 'status'])) {
                $table->index(['user_id', 'type', 'status']);
            }
            if (!Schema::hasIndex('transactions', ['transaction_type'])) {
                $table->index('transaction_type');
            }
        });
        
        // Update existing records to add signatures
        DB::statement('UPDATE transactions SET signature = MD5(CONCAT(id, user_id, amount, type, created_at)) WHERE signature IS NULL');
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn(['signature', 'is_locked', 'last_verified_at']);
            
            // Replace morphs with original columns if needed
            $table->dropMorphs('reference');
            $table->foreignId('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            
            // Drop any added indexes
            $table->dropIndex(['user_id', 'type', 'status']);
            $table->dropIndex(['transaction_type']);
        });
    }
};