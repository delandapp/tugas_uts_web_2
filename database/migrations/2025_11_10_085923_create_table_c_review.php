<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('c_review', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK user
            $table->uuid('m_users_id');
            $table->foreign('m_users_id')
                ->references('id')->on('users')
                ->cascadeOnUpdate()->cascadeOnDelete();

            // FK place
            $table->uuid('m_place_id');
            $table->foreign('m_place_id')
                ->references('id')->on('m_place')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedTinyInteger('rating'); // 1..5
            $table->text('comment')->nullable();
            $table->string('photo_url', 255)->nullable();
            $table->enum('status', ['pending', 'published', 'rejected'])->default('pending');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['m_place_id', 'status', 'created_at'], 'idx_c_review_place_status_time');
            $table->index(['m_users_id', 'created_at'], 'idx_c_review_user_time');
            $table->index('rating', 'idx_c_review_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('c_review');
    }
};
