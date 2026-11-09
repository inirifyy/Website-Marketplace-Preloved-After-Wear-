<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Foto/video yang dikirim seller bersama pengajuan produk.
 * Model ProductSubmissionMedia memakai kolom submission_id.
 * Dilewati kalau tabel sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_submission_media')) {
            return;
        }

        Schema::create('product_submission_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('product_submissions')->cascadeOnDelete();
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_submission_media');
    }
};
