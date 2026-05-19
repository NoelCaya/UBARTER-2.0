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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('initiator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('initiator_item_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('receiver_item_id')->constrained('items')->onDelete('cascade');
            $table->enum('status', ['Pending', 'Accepted', 'Rejected', 'Completed', 'Cancelled'])->default('Pending');
            $table->text('message')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('initiator_id');
            $table->index('receiver_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
