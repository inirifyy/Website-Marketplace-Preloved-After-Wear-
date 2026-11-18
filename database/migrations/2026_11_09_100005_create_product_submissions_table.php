<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Pengajuan produk dari seller yang menunggu verifikasi admin.
 * Dilewati kalau tabel sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_submissions')) {
            return;
        }

        Schema::create('product_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name', 200);
            $table->text('description');
            $table->decimal('price', 12, 2)->default(0);
            $table->string('item_condition', 100)->nullable();
            $table->string('material', 100)->nullable();
            $table->string('usage_duration', 100)->nullable();
            $table->text('flaws')->nullable();
            $table->string('location')->nullable();
            $table->string('contact_whatsapp', 30)->nullable();
            $table->enum('submission_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable(); // alasan penolakan
            $table->timestamps();

            $table->index('submission_status', 'product_submissions_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_submissions');
    }
};
