<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Tabel produk yang tampil di katalog.
 * Dilewati kalau tabel sudah ada. Butuh tabel users dan categories lebih dulu.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products')) {
            return;
        }

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name', 200);
            $table->string('slug', 220)->unique();
            $table->text('description');
            $table->decimal('price', 12, 2)->default(0);
            $table->string('item_condition', 100)->nullable();
            $table->string('material', 100)->nullable();
            $table->string('usage_duration', 100)->nullable();
            $table->text('flaws')->nullable();
            $table->string('location')->nullable();
            // ready = tersedia, sold_out = habis
            $table->enum('status', ['ready', 'sold_out'])->default('ready');
            // Hanya produk "approved" yang tampil di katalog publik.
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->index(['status', 'approval_status'], 'products_status_approval_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
