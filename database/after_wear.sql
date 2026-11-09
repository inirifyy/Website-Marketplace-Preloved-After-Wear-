-- AFTER WEAR: dokumentasi struktur database (MySQL/MariaDB)
--
-- File ini mengikuti migration Laravel di database/migrations dan hanya
-- dokumentasi / jalan pintas untuk DATABASE BARU YANG KOSONG.
--
-- ATURAN:
--  1) Cara utama membuat tabel: php artisan migrate  (lalu php artisan db:seed)
--  2) Skrip ini TIDAK memakai DROP TABLE. Aman, tapi CREATE TABLE IF NOT EXISTS
--     tidak memperbaiki tabel lama yang strukturnya berbeda.
--  3) Jangan pernah menjalankan php artisan migrate:fresh pada database berisi data.
--  4) Backup database sebelum mengubah struktur.
--  5) Kalau tabel dibuat lewat skrip ini, tabel migrations tetap kosong. Migration
--     proyek ini sudah dilindungi Schema::hasTable(), jadi php artisan migrate
--     tetap aman dijalankan sesudahnya (tabel yang ada dilewati).
--  6) Data awal (kategori, konten, akun admin) diisi lewat php artisan db:seed.

CREATE DATABASE IF NOT EXISTS after_wear
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE after_wear;

-- 1. Pengguna. Kolom role/phone/address ditambah migration
--    2026_11_09_100001_add_role_phone_address_to_users_table.
CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  email_verified_at TIMESTAMP NULL DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('buyer','seller','admin') NOT NULL DEFAULT 'buyer',
  phone VARCHAR(30) NULL,
  address TEXT NULL,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Kategori produk
CREATE TABLE IF NOT EXISTS categories (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL,
  description TEXT NULL,
  icon VARCHAR(100) NULL,
  image VARCHAR(500) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  `order` INT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY categories_name_unique (name),
  UNIQUE KEY categories_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Produk di katalog (status: ready/sold_out; approval_status: hanya "approved" tampil)
CREATE TABLE IF NOT EXISTS products (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  seller_id BIGINT UNSIGNED NOT NULL,
  category_id BIGINT UNSIGNED NULL,
  name VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  item_condition VARCHAR(100) NULL,
  material VARCHAR(100) NULL,
  usage_duration VARCHAR(100) NULL,
  flaws TEXT NULL,
  location VARCHAR(255) NULL,
  status ENUM('ready','sold_out') NOT NULL DEFAULT 'ready',
  approval_status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY products_slug_unique (slug),
  KEY products_status_approval_index (status, approval_status),
  CONSTRAINT products_seller_id_foreign
    FOREIGN KEY (seller_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT products_category_id_foreign
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Foto dan video produk
CREATE TABLE IF NOT EXISTS product_media (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id BIGINT UNSIGNED NOT NULL,
  media_type ENUM('image','video') NOT NULL DEFAULT 'image',
  file_path VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT product_media_product_id_foreign
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Pengajuan produk dari seller (menunggu verifikasi admin)
CREATE TABLE IF NOT EXISTS product_submissions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  seller_id BIGINT UNSIGNED NOT NULL,
  category_id BIGINT UNSIGNED NULL,
  name VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  item_condition VARCHAR(100) NULL,
  material VARCHAR(100) NULL,
  usage_duration VARCHAR(100) NULL,
  flaws TEXT NULL,
  location VARCHAR(255) NULL,
  contact_whatsapp VARCHAR(30) NULL,
  submission_status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  admin_note TEXT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY product_submissions_status_index (submission_status),
  CONSTRAINT product_submissions_seller_id_foreign
    FOREIGN KEY (seller_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT product_submissions_category_id_foreign
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Foto/video pada pengajuan produk
CREATE TABLE IF NOT EXISTS product_submission_media (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  submission_id BIGINT UNSIGNED NOT NULL,
  media_type ENUM('image','video') NOT NULL DEFAULT 'image',
  file_path VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT product_submission_media_submission_id_foreign
    FOREIGN KEY (submission_id) REFERENCES product_submissions (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Ulasan (satu pembeli satu ulasan per produk)
CREATE TABLE IF NOT EXISTS reviews (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id BIGINT UNSIGNED NOT NULL,
  reviewer_id BIGINT UNSIGNED NOT NULL,
  rating TINYINT UNSIGNED NOT NULL,
  comment TEXT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY reviews_product_reviewer_unique (product_id, reviewer_id),
  CONSTRAINT reviews_rating_check CHECK (rating BETWEEN 1 AND 5),
  CONSTRAINT reviews_product_id_foreign
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
  CONSTRAINT reviews_reviewer_id_foreign
    FOREIGN KEY (reviewer_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Konten website: banner beranda, edukasi, statistik, dll.
CREATE TABLE IF NOT EXISTS site_contents (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  section VARCHAR(255) NOT NULL,
  `key` VARCHAR(255) NULL,
  title VARCHAR(255) NOT NULL,
  subtitle VARCHAR(255) NULL,
  content TEXT NULL,
  image VARCHAR(255) NULL,
  button_text VARCHAR(255) NULL,
  button_url VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  `order` INT NOT NULL DEFAULT 0,
  metadata JSON NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY site_contents_section_index (section),
  KEY site_contents_key_index (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SHOW TABLES;
