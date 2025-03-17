<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained();
            $table->foreignId('user_id')->constrained(); // The user who earns the commission
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])->default('pending');
            $table->foreignId('payout_id')->nullable()->constrained('payouts')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // For storing additional information
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commissions');
    }
};