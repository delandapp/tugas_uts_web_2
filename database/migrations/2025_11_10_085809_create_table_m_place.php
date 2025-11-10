<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_place', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK merchant
            $table->uuid('m_merchant_id');
            $table->foreign('m_merchant_id')
                ->references('id')->on('m_merchant')
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

            // Rating aggregates
            $table->decimal('avg_rating', 3, 2)->default(0.00);
            $table->unsignedInteger('review_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('m_merchant_id', 'idx_m_place_merchant');
            $table->index('m_category_id', 'idx_m_place_category');
            $table->index(['lat', 'lng'], 'idx_m_place_geo');
            $table->index(['avg_rating', 'review_count'], 'idx_m_place_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_place');
    }
};
