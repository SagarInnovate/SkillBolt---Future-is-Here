<?php
// database/migrations/2023_01_01_000006_create_permission_user_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('granted_at')->useCurrent();
            
            $table->unique(['user_id', 'permission_id']);
            $table->index(['permission_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_user');
    }
};