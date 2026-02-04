<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->integer('failed_attempts')->default(0)->after('password');
            $table->timestamp('locked_until')->nullable()->after('failed_attempts');
            $table->timestamp('last_login_at')->nullable()->after('locked_until');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['failed_attempts', 'locked_until', 'last_login_at', 'last_login_ip']);
        });
    }
};
