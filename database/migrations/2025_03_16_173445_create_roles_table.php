<?php
// database/migrations/2023_01_01_000001_create_roles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            ['name' => 'student', 'description' => 'Regular student user'],
            ['name' => 'company', 'description' => 'Company/recruiter account'],
            ['name' => 'admin', 'description' => 'Platform administrator'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};