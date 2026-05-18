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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('category')->default('General');
            $table->enum('condition', ['New', 'Slightly Used', 'Used'])->default('Slightly Used');
            $table->enum('item_type', ['Barter', 'Donation'])->default('Barter');
            $table->string('image_url')->nullable();
            $table->integer('views')->default(0);
            $table->integer('wishlist_count')->default(0);
            $table->integer('rating')->default(5);
            $table->decimal('seller_rating', 3, 2)->default(5.0);
            $table->enum('status', ['Active', 'Pending', 'Traded', 'Archived'])->default('Active');
            $table->timestamp('posted_at')->useCurrent();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('category');
            $table->index('item_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
