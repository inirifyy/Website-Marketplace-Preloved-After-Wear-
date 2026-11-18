<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Konten website yang dikelola admin: banner beranda, edukasi, statistik, dll.
 * Kolom mengikuti model SiteContent dan SiteContentSeeder.
 * Dilewati kalau tabel sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_contents')) {
            return;
        }

        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section')->index(); // hero_banner, education, announcement, about, stat
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

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
