<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users');
            $table->foreignId('referred_user_id')->constrained('users');
            $table->enum('status', ['pending', 'successful', 'failed'])->default('pending');
            $table->timestamp('conversion_date')->nullable();
            $table->timestamps();
            
            $table->unique(['referrer_id', 'referred_user_id']);
            $table->index(['referrer_id', 'status']);
            $table->index('referred_user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('referrals');
    }
};

