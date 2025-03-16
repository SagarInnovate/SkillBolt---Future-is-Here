<?php
// database/migrations/2023_01_01_000008_create_affiliate_details_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('affiliate_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('affiliate_code', 50)->unique();
            $table->integer('total_referrals')->default(0);
            $table->timestamps();
            
            $table->index('affiliate_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('affiliate_details');
    }
};