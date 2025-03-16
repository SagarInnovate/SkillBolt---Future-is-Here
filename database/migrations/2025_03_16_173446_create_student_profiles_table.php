<?php
// database/migrations/2023_01_01_000003_create_student_profiles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained()->onDelete('cascade');
            $table->string('college')->nullable();
            $table->year('graduation_year')->nullable();
            $table->string('branch', 100)->nullable();
            $table->text('skills')->nullable();
            $table->timestamps();
            
            $table->index('college');
            $table->index('graduation_year');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_profiles');
    }
};