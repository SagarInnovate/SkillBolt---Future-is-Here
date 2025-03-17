<?php
// database/migrations/2025_03_17_000001_fix_permission_user_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First check if the table exists
        if (Schema::hasTable('permission_user')) {
            // Add timestamps columns to the permission_user table
            Schema::table('permission_user', function (Blueprint $table) {
                if (!Schema::hasColumn('permission_user', 'created_at')) {
                    $table->timestamp('created_at')->nullable();
                }
                if (!Schema::hasColumn('permission_user', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('permission_user')) {
            Schema::table('permission_user', function (Blueprint $table) {
                $table->dropColumn(['created_at', 'updated_at']);
            });
        }
    }
};