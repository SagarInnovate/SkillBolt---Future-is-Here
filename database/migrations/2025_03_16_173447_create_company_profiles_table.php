<?php
// database/migrations/2023_01_01_000004_create_company_profiles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('industry', 100)->nullable();
            $table->string('size', 50)->nullable();
            $table->string('website')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->index('company_name');
            $table->index('verification_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_profiles');
    }
};