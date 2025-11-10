<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_merchant', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK owner -> users
            $table->uuid('m_users_id');
            $table->foreign('m_users_id')
                ->references('id')->on('users')
                ->cascadeOnUpdate()->cascadeOnDelete();

            // FK category
            $table->uuid('m_category_id')->nullable();
            $table->foreign('m_category_id')
                ->references('id')->on('m_category')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->string('name', 150);
            $table->string('address', 255)->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('open_hours', 120)->nullable();
            $table->string('whatsapp_number', 25)->nullable();
            $table->enum('status', ['pending', 'active', 'rejected', 'inactive'])->default('pending');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('m_users_id', 'idx_m_merchant_users');
            $table->index('m_category_id', 'idx_m_merchant_category');
            $table->index(['lat', 'lng'], 'idx_m_merchant_geo');
            $table->index(['status', 'updated_at'], 'idx_m_merchant_status_time');
            $table->index('whatsapp_number', 'idx_m_merchant_wa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_merchant');
    }
};
