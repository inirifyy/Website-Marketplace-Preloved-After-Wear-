<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * PERBAIKAN untuk database yang dibuat dari database/coba_after_wear_schema.sql
 * (skema lama). Di skema itu:
 *   - categories tidak punya kolom icon, image, is_active, order
 *     -> halaman kategori / katalog error "Unknown column 'is_active'".
 *   - site_contents memakai content_key/body/sort_order (tidak cocok dengan model).
 *
 * Migration ini tidak melakukan apa-apa di database yang sudah benar.
 * Data lama site_contents TIDAK dihapus: tabelnya diganti nama menjadi
 * site_contents_legacy lalu tabel baru yang benar dibuat.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (! Schema::hasColumn('categories', 'icon')) {
                    $table->string('icon', 100)->nullable();
                }
                if (! Schema::hasColumn('categories', 'image')) {
                    $table->string('image', 500)->nullable();
                }
                if (! Schema::hasColumn('categories', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
                if (! Schema::hasColumn('categories', 'order')) {
                    $table->unsignedInteger('order')->default(0);
                }
            });
        }

        if (Schema::hasTable('site_contents')
            && Schema::hasColumn('site_contents', 'content_key')
            && ! Schema::hasColumn('site_contents', 'section')) {
            Schema::rename('site_contents', 'site_contents_legacy');

            Schema::create('site_contents', function (Blueprint $table) {
                $table->id();
                $table->string('section')->index();
                $table->string('key')->nullable()->index();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->text('content')->nullable();
                $table->string('image')->nullable();
                $table->string('button_text')->nullable();
                $table->string('button_url')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('order')->default(0);
                $table->json('metadata')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Sengaja kosong: perbaikan skema tidak di-rollback agar data aman.
    }
};
