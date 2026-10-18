-- AFTER WEAR: skema database MySQL/MariaDB
-- PENTING:
-- 1) Skrip ini ditujukan untuk DATABASE KOSONG / DATABASE BARU.
-- 2) Skrip ini TIDAK menghapus tabel yang sudah ada.
-- 3) CREATE TABLE IF NOT EXISTS tidak memperbaiki struktur tabel lama.
-- 4) Backup database lama sebelum mengubah struktur.
-- 5) Jangan jalankan php artisan migrate sebelum migration Laravel diselaraskan
--    dengan skema ini.

CREATE DATABASE IF NOT EXISTS after_wear
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE after_wear;

-- Tabel pengguna. Role tidak boleh ditentukan dari form registrasi publik;
-- penentuan role seller/admin harus divalidasi di backend.
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

CREATE TABLE IF NOT EXISTS password_reset_tokens (
  email VARCHAR(255) NOT NULL,
  token VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sessions (
  id VARCHAR(255) NOT NULL,
  user_id BIGINT UNSIGNED NULL,
  ip_address VARCHAR(45) NULL,
  user_agent TEXT NULL,
  payload LONGTEXT NOT NULL,
  last_activity INT NOT NULL,
  PRIMARY KEY (id),
  KEY sessions_user_id_index (user_id),
  KEY sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cache (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  expiration INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cache_locks (
  `key` VARCHAR(255) NOT NULL,
  owner VARCHAR(255) NOT NULL,
  expiration INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS jobs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  queue VARCHAR(255) NOT NULL,
  payload LONGTEXT NOT NULL,
  attempts TINYINT UNSIGNED NOT NULL,
  reserved_at INT UNSIGNED NULL,
  available_at INT UNSIGNED NOT NULL,
  created_at INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY jobs_queue_index (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS job_batches (
  id VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  total_jobs INT NOT NULL,
  pending_jobs INT NOT NULL,
  failed_jobs INT NOT NULL,
  failed_job_ids LONGTEXT NOT NULL,
  options MEDIUMTEXT NULL,
  cancelled_at INT NULL,
  created_at INT NOT NULL,
  finished_at INT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS failed_jobs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  uuid VARCHAR(255) NOT NULL,
  connection TEXT NOT NULL,
  queue TEXT NOT NULL,
  payload LONGTEXT NOT NULL,
  exception LONGTEXT NOT NULL,
  failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY failed_jobs_uuid_unique (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Laravel migration log. Laravel migrations must be reconciled separately
-- before using artisan migrate against a database created manually.
CREATE TABLE IF NOT EXISTS migrations (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  migration VARCHAR(255) NOT NULL,
  batch INT NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL,
  description TEXT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY categories_name_unique (name),
  UNIQUE KEY categories_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  KEY products_seller_id_index (seller_id),
  KEY products_category_id_index (category_id),
  KEY products_status_approval_index (status, approval_status),
  CONSTRAINT products_seller_id_foreign
    FOREIGN KEY (seller_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT products_category_id_foreign
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS product_media (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id BIGINT UNSIGNED NOT NULL,
  media_type ENUM('image','video') NOT NULL DEFAULT 'image',
  file_path VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY product_media_product_id_index (product_id),
  CONSTRAINT product_media_product_id_foreign
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  KEY product_submissions_seller_id_index (seller_id),
  KEY product_submissions_category_id_index (category_id),
  KEY product_submissions_status_index (submission_status),
  CONSTRAINT product_submissions_seller_id_foreign
    FOREIGN KEY (seller_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT product_submissions_category_id_foreign
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Media yang dikirim saat penjual mengajukan produk.
CREATE TABLE IF NOT EXISTS product_submission_media (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  submission_id BIGINT UNSIGNED NOT NULL,
  media_type ENUM('image','video') NOT NULL DEFAULT 'image',
  file_path VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY submission_media_submission_id_index (submission_id),
  CONSTRAINT submission_media_submission_id_foreign
    FOREIGN KEY (submission_id) REFERENCES product_submissions (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reviews (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id BIGINT UNSIGNED NOT NULL,
  reviewer_id BIGINT UNSIGNED NOT NULL,
  rating TINYINT UNSIGNED NOT NULL,
  comment TEXT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY reviews_product_id_index (product_id),
  KEY reviews_reviewer_id_index (reviewer_id),
  CONSTRAINT reviews_rating_check CHECK (rating BETWEEN 1 AND 5),
  CONSTRAINT reviews_product_id_foreign
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
  CONSTRAINT reviews_reviewer_id_foreign
    FOREIGN KEY (reviewer_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS site_contents (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  content_key VARCHAR(100) NOT NULL,
  title VARCHAR(255) NULL,
  body TEXT NULL,
  image_path VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY site_contents_content_key_unique (content_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data awal kategori. INSERT IGNORE aman untuk nama/slug yang sudah unik.
INSERT IGNORE INTO categories (name, slug, description, created_at, updated_at)
VALUES
  ('Atasan', 'atasan', 'Kaos, kemeja, dan pakaian atasan.', NOW(), NOW()),
  ('Bawahan', 'bawahan', 'Celana, rok, dan pakaian bawahan.', NOW(), NOW()),
  ('Dress', 'dress', 'Dress dan pakaian terusan.', NOW(), NOW()),
  ('Outerwear', 'outerwear', 'Jaket, blazer, cardigan, dan luaran.', NOW(), NOW()),
  ('Aksesori', 'aksesori', 'Tas, ikat pinggang, dan aksesori lainnya.', NOW(), NOW());

-- Contoh konten awal slider/edukasi; bisa diedit admin dari aplikasi nanti.
INSERT IGNORE INTO site_contents
  (content_key, title, body, image_path, is_active, sort_order, created_at, updated_at)
VALUES
  ('hero_1', 'Beri Kesempatan Kedua untuk Pakaianmu',
   'Temukan pakaian preloved yang masih layak pakai di After Wear.',
   NULL, 1, 1, NOW(), NOW()),
  ('hero_2', 'Gaya Lebih Sadar',
   'Pilih kembali pakaian yang sudah ada dan bantu mengurangi limbah tekstil.',
   NULL, 1, 2, NOW(), NOW()),
  ('textile_education', 'Kenali Dampak Limbah Tekstil',
   'Menggunakan kembali pakaian yang masih layak adalah salah satu langkah untuk memperpanjang masa pakainya.',
   NULL, 1, 3, NOW(), NOW());

-- Verifikasi tabel yang tersedia.
SHOW TABLES;
