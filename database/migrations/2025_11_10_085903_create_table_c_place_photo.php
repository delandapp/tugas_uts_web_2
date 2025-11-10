<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('c_place_photo', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('m_place_id');
            $table->foreign('m_place_id')
                ->references('id')->on('m_place')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('photo_url', 255);
            $table->unsignedSmallInteger('sequence')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['m_place_id', 'sequence'], 'idx_c_place_photo_place_sequence');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('c_place_photo');
    }
};
