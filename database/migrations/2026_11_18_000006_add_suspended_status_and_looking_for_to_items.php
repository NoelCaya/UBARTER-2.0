<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add looking_for column to items if it doesn't exist
        if (!Schema::hasColumn('items', 'looking_for')) {
            Schema::table('items', function (Blueprint $table) {
                $table->string('looking_for')->nullable()->after('item_type');
            });
        }
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('looking_for');
        });
    }
};
