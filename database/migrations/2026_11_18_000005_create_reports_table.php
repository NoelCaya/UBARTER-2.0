<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reported_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('conversation_id')->nullable()->constrained('conversations')->onDelete('set null');
            $table->enum('reason', [
                'Fraudulous Behavior',
                'Inappropriate Behavior',
                'Verbal Abuse',
                'Spam',
                'Fake Item Listing',
                'Scam Attempt',
                'Other',
            ]);
            $table->text('details')->nullable();
            $table->enum('status', ['Pending', 'Reviewed', 'Resolved', 'Dismissed'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
