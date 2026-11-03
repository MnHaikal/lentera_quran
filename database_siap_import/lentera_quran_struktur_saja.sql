-- ========================================================
-- STRUKTUR DATABASE LENTERA QUR'AN (lentera_quran)
-- Aplikasi Web Lentera Qur'an (Al-Qur'an, Tahlil, & Doa)
-- Server: MySQL 8.0+ / MariaDB 10.4+
-- Karakter: UTF-8 Unicode (utf8mb4_unicode_ci)
-- Catatan: File ini mendefinisikan seluruh struktur tabel (DDL)
--          agar pembuatan akun baru dan fitur sistem berjalan langsung
-- ========================================================

CREATE DATABASE IF NOT EXISTS `lentera_quran` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lentera_quran`;

SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;
SET @OLD_TIME_ZONE=@@TIME_ZONE;
SET TIME_ZONE='+07:00';
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0;

-- --------------------------------------------------------
-- Struktur Tabel: `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `user_settings`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE `user_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `ukuran_font_arab` tinyint unsigned NOT NULL DEFAULT '28',
  `tampilkan_latin` tinyint(1) NOT NULL DEFAULT '1',
  `tampilkan_terjemahan` tinyint(1) NOT NULL DEFAULT '1',
  `tema` enum('terang','gelap','sistem') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sistem',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_settings_user_id_unique` (`user_id`),
  CONSTRAINT `user_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `surahs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `surahs`;
CREATE TABLE `surahs` (
  `id` tinyint unsigned NOT NULL,
  `nama_arab` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_latin` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `arti` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_ayat` smallint unsigned NOT NULL,
  `tempat_turun` enum('mekah','madinah') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `audio_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `ayahs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `ayahs`;
CREATE TABLE `ayahs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `surah_id` tinyint unsigned NOT NULL,
  `nomor_ayat` smallint unsigned NOT NULL,
  `teks_arab` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teks_latin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `terjemahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `juz` tinyint unsigned NOT NULL,
  `halaman` smallint unsigned DEFAULT NULL,
  `audio_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ayahs_surah_id_nomor_ayat_unique` (`surah_id`,`nomor_ayat`),
  KEY `ayahs_juz_index` (`juz`),
  FULLTEXT KEY `ayahs_terjemahan_teks_latin_fulltext` (`terjemahan`,`teks_latin`),
  CONSTRAINT `ayahs_surah_id_foreign` FOREIGN KEY (`surah_id`) REFERENCES `surahs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `tafsirs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tafsirs`;
CREATE TABLE `tafsirs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ayah_id` bigint unsigned NOT NULL,
  `sumber` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tafsirs_ayah_id_unique` (`ayah_id`),
  CONSTRAINT `tafsirs_ayah_id_foreign` FOREIGN KEY (`ayah_id`) REFERENCES `ayahs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `tahlil_items`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tahlil_items`;
CREATE TABLE `tahlil_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `urutan` smallint unsigned NOT NULL,
  `judul` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teks_arab` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teks_latin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `terjemahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_baca` tinyint unsigned NOT NULL DEFAULT '1',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahlil_items_urutan_index` (`urutan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `doa_categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `doa_categories`;
CREATE TABLE `doa_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` smallint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doa_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `doas`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `doas`;
CREATE TABLE `doas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `doa_category_id` bigint unsigned NOT NULL,
  `judul` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(170) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teks_arab` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teks_latin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `terjemahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doas_slug_unique` (`slug`),
  KEY `doas_doa_category_id_foreign` (`doa_category_id`),
  CONSTRAINT `doas_doa_category_id_foreign` FOREIGN KEY (`doa_category_id`) REFERENCES `doa_categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `bookmarks`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `bookmarks`;
CREATE TABLE `bookmarks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `bookmarkable_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookmarkable_id` bigint unsigned NOT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookmarks_user_id_bookmarkable_type_bookmarkable_id_unique` (`user_id`,`bookmarkable_type`,`bookmarkable_id`),
  KEY `bookmarks_bookmarkable_type_bookmarkable_id_index` (`bookmarkable_type`,`bookmarkable_id`),
  CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `last_reads`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `last_reads`;
CREATE TABLE `last_reads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `surah_id` tinyint unsigned NOT NULL,
  `ayah_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `last_reads_user_id_unique` (`user_id`),
  KEY `last_reads_surah_id_foreign` (`surah_id`),
  KEY `last_reads_ayah_id_foreign` (`ayah_id`),
  CONSTRAINT `last_reads_ayah_id_foreign` FOREIGN KEY (`ayah_id`) REFERENCES `ayahs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `last_reads_surah_id_foreign` FOREIGN KEY (`surah_id`) REFERENCES `surahs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `last_reads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `sessions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `password_reset_tokens`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `cache`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `cache_locks`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `jobs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `job_batches`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `failed_jobs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur Tabel: `migrations`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- CONTOH QUERY SQL UNTUK MEMBUAT AKUN BARU LANGSUNG DI DATABASE
-- Password default di bawah: password123 (ter-hash Bcrypt $2y$12$...)
-- ========================================================
--
-- 1. Akun Pengguna Biasa (User):
-- INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`)
-- VALUES ('Ahmad Fulan', 'ahmad@example.com', '$2y$12$6vce1HI.ZqHXrmIJG7PAA.474jYDs2YJ2Ijom7iUcjD55tageWcKS', 'user', NOW(), NOW());
--
-- 2. Pengaturan Tampilan Akun (Wajib dibuat untuk setiap user):
-- INSERT INTO `user_settings` (`user_id`, `ukuran_font_arab`, `tampilkan_latin`, `tampilkan_terjemahan`, `tema`, `created_at`, `updated_at`)
-- VALUES (LAST_INSERT_ID(), 28, 1, 1, 'sistem', NOW(), NOW());

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
SET SQL_NOTES=@OLD_SQL_NOTES;
