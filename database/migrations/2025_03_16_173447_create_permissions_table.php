<?php
// database/migrations/2023_01_01_000005_create_permissions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default permissions
        DB::table('permissions')->insert([
            ['name' => 'can_sell', 'description' => 'Can sell projects on the platform'],
            ['name' => 'can_affiliate', 'description' => 'Can refer users and earn commission'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};