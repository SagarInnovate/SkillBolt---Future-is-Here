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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique(); // Unique reference code
            $table->foreignId('user_id')->constrained();
            $table->string('transaction_type'); // commission, payout, bonus, etc.
            $table->foreignId('reference_id')->nullable(); // ID of related entity
            $table->string('reference_type')->nullable(); // Model class of related entity
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('INR'); // Currency code
            $table->enum('type', ['credit', 'debit'])->default('credit');
            $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('completed');
            $table->decimal('balance_after', 10, 2); // Balance after this transaction
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamps();
            
            $table->index(['user_id', 'transaction_type']);
            $table->index(['reference_type', 'reference_id']);
            $table->index('transaction_code');
            $table->index(['status', 'created_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
