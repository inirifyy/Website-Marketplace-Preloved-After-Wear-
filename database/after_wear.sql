CREATE DATABASE IF NOT EXISTS after_wear
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE after_wear;

-- /isi struktur tabel database

USE after_wear;

-- 1. Akun pengguna, penjual, dan admin
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer',
    phone VARCHAR(30) NULL,
    address TEXT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- kalo tabel users sdh ada pake ini:

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer',
    phone VARCHAR(30) NULL,
    address TEXT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- or tanpa menghapus tabel

ALTER TABLE users 
ADD COLUMN role ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer' AFTER password,
ADD COLUMN phone VARCHAR(30) NULL AFTER role,
ADD COLUMN address TEXT NULL AFTER phone;

-- 2. Kategori produk
CREATE TABLE IF NOT EXISTS categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- jika sdh ada

DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- or tanpa hapus

ALTER TABLE categories 
ADD COLUMN slug VARCHAR(120) NOT NULL UNIQUE AFTER name,
ADD COLUMN description TEXT NULL AFTER slug;

-- 3. Produk preloved
CREATE TABLE IF NOT EXISTS products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seller_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    item_condition VARCHAR(100) NULL,
    material VARCHAR(100) NULL,
    usage_duration VARCHAR(100) NULL,
    flaws TEXT NULL,
    location VARCHAR(255) NULL,
    status ENUM('ready', 'sold_out') NOT NULL DEFAULT 'ready',
    approval_status ENUM('pending', 'approved', 'rejected')
        NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_products_seller
        FOREIGN KEY (seller_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

*jika sdh ada

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seller_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    item_condition VARCHAR(100) NULL,
    material VARCHAR(100) NULL,
    usage_duration VARCHAR(100) NULL,
    flaws TEXT NULL,
    location VARCHAR(255) NULL,
    status ENUM('ready', 'sold_out') NOT NULL DEFAULT 'ready',
    approval_status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_products_seller
        FOREIGN KEY (seller_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4. Foto dan video produk
CREATE TABLE IF NOT EXISTS product_media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    media_type ENUM('image', 'video') NOT NULL DEFAULT 'image',
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_media_product
        FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Rating dan ulasan
CREATE TABLE IF NOT EXISTS reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    reviewer_id BIGINT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL,
    comment TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT chk_reviews_rating CHECK (rating BETWEEN 1 AND 5),
    CONSTRAINT fk_reviews_product
        FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_reviews_reviewer
        FOREIGN KEY (reviewer_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Pengajuan produk dari penjual
CREATE TABLE IF NOT EXISTS product_submissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seller_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    item_condition VARCHAR(100) NULL,
    material VARCHAR(100) NULL,
    usage_duration VARCHAR(100) NULL,
    flaws TEXT NULL,
    location VARCHAR(255) NULL,
    contact_whatsapp VARCHAR(30) NULL,
    submission_status ENUM('pending', 'approved', 'rejected')
        NOT NULL DEFAULT 'pending',
    admin_note TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_submissions_seller
        FOREIGN KEY (seller_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_submissions_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- 7. Konten beranda dan edukasi
CREATE TABLE IF NOT EXISTS site_contents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_key VARCHAR(100) NOT NULL UNIQUE,
    title VARCHAR(255) NULL,
    body TEXT NULL,
    image_path VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- 8. Data awal kategori
INSERT IGNORE INTO categories (name, slug, description, created_at, updated_at)
VALUES
('Pakaian', 'pakaian', 'Kategori pakaian preloved dan fashion', NOW(), NOW()),
('Barang Elektronik', 'barang-elektronik', 'Kategori gadget dan elektronik', NOW(), NOW()),
('Perabot', 'perabot', 'Kategori perabotan rumah dan furnitur', NOW(), NOW()),
('Skincare', 'skincare', 'Kategori perawatan kulit dan kecantikan', NOW(), NOW()),
('Buku', 'buku', 'Kategori buku, novel, dan bacaan', NOW(), NOW()),
('Lainnya', 'lainnya', 'Kategori barang lainnya', NOW(), NOW());

-- Periksa tabel yang berhasil dibuat
SHOW TABLES;