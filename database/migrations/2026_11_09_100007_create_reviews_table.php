<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * Tabel ulasan. Strukturnya mengikuti database/coba_after_wear_schema.sql.
 * Dilewati otomatis kalau tabel reviews sudah ada.
 *
 * PENTING: tabel products dan users harus sudah ada sebelum migration ini
 * dijalankan, karena reviews punya foreign key ke keduanya.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reviews')) {
            return;
        }

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            // Satu pembeli hanya boleh satu ulasan per produk.
            $table->unique(['product_id', 'reviewer_id'], 'reviews_product_reviewer_unique');
        });

        // Batas rating 1-5 di level database (MySQL 8.0.16+ / MariaDB 10.2+).
        // Dilewati di driver lain (mis. SQLite untuk test) karena tidak mendukungnya.
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_rating_check CHECK (rating BETWEEN 1 AND 5)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};