<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('referral_clicks', function (Blueprint $table) {
            $table->id();
            $table->string('referral_code', 50);
            $table->ipAddress('ip_address');
            $table->text('user_agent')->nullable();
            $table->string('source', 50)->nullable(); // Which platform the click came from
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->timestamp('created_at');
            
            $table->index('referral_code');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_clicks');
    }
};