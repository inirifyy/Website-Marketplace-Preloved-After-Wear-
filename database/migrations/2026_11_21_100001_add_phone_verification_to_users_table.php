<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Verifikasi NOMOR HP (bukan email). Kode OTP disimpan dalam bentuk hash,
 * bukan teks asli. Tiap kolom dicek dulu (hasColumn) supaya aman dijalankan
 * di database yang sudah dibuat manual lewat SQL.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable();
            }
            if (! Schema::hasColumn('users', 'phone_otp_hash')) {
                $table->string('phone_otp_hash')->nullable();
            }
            if (! Schema::hasColumn('users', 'phone_otp_expires_at')) {
                $table->timestamp('phone_otp_expires_at')->nullable();
            }
            if (! Schema::hasColumn('users', 'phone_otp_sent_at')) {
                $table->timestamp('phone_otp_sent_at')->nullable();
            }
            if (! Schema::hasColumn('users', 'phone_otp_attempts')) {
                $table->unsignedTinyInteger('phone_otp_attempts')->default(0);
            }
        });
    }

    public function down(): void
    {
        foreach (['phone_otp_attempts', 'phone_otp_sent_at', 'phone_otp_expires_at', 'phone_otp_hash', 'phone_verified_at'] as $column) {
            if (Schema::hasColumn('users', $column)) {
                Schema::table('users', fn (Blueprint $table) => $table->dropColumn($column));
            }
        }
    }
};
