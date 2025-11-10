<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('c_promo', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK merchant
            $table->uuid('m_merchant_id');
            $table->foreign('m_merchant_id')
                ->references('id')->on('m_merchant')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['m_merchant_id', 'active'], 'idx_c_promo_merchant_active');
            $table->index(['starts_at', 'ends_at'], 'idx_c_promo_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('c_promo');
    }
};
