<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'blocked_until')) {
                $table->timestamp('blocked_until')->nullable();
            }
            if (!Schema::hasColumn('users', 'block_reason')) {
                $table->text('block_reason')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['blocked_until', 'block_reason']);
        });
    }
};
