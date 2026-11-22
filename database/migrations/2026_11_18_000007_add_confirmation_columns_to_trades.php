<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->boolean('initiator_confirmed')->default(false)->after('completed_at');
            $table->boolean('receiver_confirmed')->default(false)->after('initiator_confirmed');
        });
    }

    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropColumn(['initiator_confirmed', 'receiver_confirmed']);
        });
    }
};
