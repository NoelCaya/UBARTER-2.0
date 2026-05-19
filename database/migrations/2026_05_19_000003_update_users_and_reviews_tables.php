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
        // Update users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'avatar_url')) {
                $table->string('avatar_url')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('avatar_url');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'rating')) {
                $table->decimal('rating', 3, 2)->default(5.0)->after('phone');
            }
            if (!Schema::hasColumn('users', 'trades_count')) {
                $table->integer('trades_count')->default(0)->after('rating');
            }
        });

        // Update reviews table
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'trade_id')) {
                $table->foreignId('trade_id')->nullable()->constrained('trades')->onDelete('set null')->after('item_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumnIfExists('avatar_url');
            $table->dropColumnIfExists('bio');
            $table->dropColumnIfExists('phone');
            $table->dropColumnIfExists('rating');
            $table->dropColumnIfExists('trades_count');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeignIdFor('Trade');
            $table->dropColumnIfExists('trade_id');
        });
    }
};
