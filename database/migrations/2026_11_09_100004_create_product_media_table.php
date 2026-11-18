<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Foto dan video milik produk. Ikut terhapus kalau produknya dihapus.
 * Dilewati kalau tabel sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_media')) {
            return;
        }

        Schema::create('product_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_media');
    }
};
