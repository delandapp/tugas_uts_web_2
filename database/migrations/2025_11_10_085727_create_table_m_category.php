<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_category', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('icon', 150)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique('name', 'uniq_m_category_name');
            $table->index(['created_at', 'updated_at'], 'idx_m_category_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_category');
    }
};
