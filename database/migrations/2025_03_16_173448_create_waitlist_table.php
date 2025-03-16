<?php
// database/migrations/2023_01_01_000007_create_waitlist_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('waitlist', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('referral_code', 50)->nullable();
            $table->boolean('is_invited')->default(false);
            $table->foreignId('converted_user_id')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index('email');
            $table->index('referral_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('waitlist');
    }
};