<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('c_merchant_photo', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('m_merchant_id');
            $table->foreign('m_merchant_id')
                ->references('id')->on('m_merchant')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('photo_url', 255);
            $table->unsignedSmallInteger('sequence')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['m_merchant_id', 'sequence'], 'idx_c_merchant_photo_merchant_sequence');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('c_merchant_photo');
    }
};
