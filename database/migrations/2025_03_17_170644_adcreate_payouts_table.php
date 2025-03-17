<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['bank_transfer', 'upi', 'wallet_credit'])->default('bank_transfer');
            $table->enum('status', ['processing', 'completed', 'failed'])->default('processing');
            $table->string('transaction_id')->nullable();
            $table->text('payment_details')->nullable(); // JSON encoded payment details
            $table->timestamp('payout_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('transaction_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payouts');
    }
};