-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 01, 2026 at 06:25 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dikampus_aja`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_kategori`, `nama_kategori`, `created_at`) VALUES
(1, 'Makanan', '2026-10-01 04:09:49'),
(2, 'Minuman', '2026-10-01 04:09:49'),
(3, 'Snack', '2026-10-01 04:09:49'),
(4, 'ATK', '2026-10-01 04:09:49'),
(5, 'Fotokopi', '2026-10-01 04:09:49'),
(6, 'Produk Mahasiswa', '2026-10-01 04:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_tenant` int NOT NULL,
  `total` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('menunggu','diproses','siap_diambil','selesai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `metode_pembayaran` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bayar saat mengambil pesanan',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_order`),
  KEY `id_user` (`id_user`),
  KEY `id_tenant` (`id_tenant`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `id_tenant`, `total`, `catatan`, `status`, `metode_pembayaran`, `created_at`) VALUES
(1, 10, 1, 18000, 'mie ayam nya jangan pake sayur', 'selesai', 'Bayar saat mengambil pesanan', '2026-10-01 04:34:51'),
(2, 10, 1, 17000, '', 'selesai', 'Bayar saat mengambil pesanan', '2026-10-01 04:36:17'),
(3, 10, 8, 125000, '', 'selesai', 'Bayar saat mengambil pesanan', '2026-10-01 06:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id_detail` int NOT NULL AUTO_INCREMENT,
  `id_order` int NOT NULL,
  `id_produk` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga` int NOT NULL,
  `subtotal` int NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_order` (`id_order`),
  KEY `id_produk` (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id_detail`, `id_order`, `id_produk`, `jumlah`, `harga`, `subtotal`) VALUES
(1, 1, 4, 1, 8000, 8000),
(2, 1, 2, 1, 10000, 10000),
(3, 2, 3, 1, 5000, 5000),
(4, 2, 1, 1, 12000, 12000),
(5, 3, 16, 1, 125000, 125000);

-- --------------------------------------------------------

--
-- Table structure for table `print_orders`
--

DROP TABLE IF EXISTS `print_orders`;
CREATE TABLE IF NOT EXISTS `print_orders` (
  `id_print` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_tenant` int NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_layanan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `estimasi_harga` int NOT NULL DEFAULT '0',
  `status` enum('menunggu','diproses','siap_diambil','selesai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_print`),
  KEY `id_user` (`id_user`),
  KEY `id_tenant` (`id_tenant`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `print_orders`
--

INSERT INTO `print_orders` (`id_print`, `id_user`, `id_tenant`, `nama_file`, `jenis_layanan`, `jumlah`, `catatan`, `estimasi_harga`, `status`, `created_at`) VALUES
(1, 2, 6, '6e774dfe4b4d_2giliair.jpg', 'Print Hitam Putih', 3, 'print rangkap 2', 1500, 'selesai', '2026-10-01 04:29:31'),
(2, 10, 6, '226eebf9f51f_16dc623e4c760aa1cae22016fde7a2c4.jpg', 'Print Hitam Putih', 1, 'print 3rangkap', 500, 'menunggu', '2026-10-01 05:55:21'),
(3, 10, 6, 'feb00de35c22_images__3_.jpeg', 'Fotokopi', 1, 'print ini bolo', 300, 'dibatalkan', '2026-10-01 06:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `print_services`
--

DROP TABLE IF EXISTS `print_services`;
CREATE TABLE IF NOT EXISTS `print_services` (
  `id_layanan` int NOT NULL AUTO_INCREMENT,
  `id_tenant` int NOT NULL,
  `nama_layanan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_layanan`),
  KEY `id_tenant` (`id_tenant`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `print_services`
--

INSERT INTO `print_services` (`id_layanan`, `id_tenant`, `nama_layanan`, `harga`, `aktif`) VALUES
(1, 6, 'Print Hitam Putih', 500, 1),
(2, 6, 'Print Warna', 1500, 1),
(3, 6, 'Fotokopi', 300, 1),
(4, 6, 'Jilid', 5000, 1),
(5, 6, 'Scan', 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `id_tenant` int NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `nama_produk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` int NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_produk`),
  KEY `id_tenant` (`id_tenant`),
  KEY `id_kategori` (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_produk`, `id_tenant`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `stok`, `foto`, `status`, `created_at`) VALUES
(1, 1, 1, 'Nasi Goreng', 'Nasi goreng dengan telur dan sayuran.', 12000, 9, '4c9b509231d07c82.jpeg', 'aktif', '2026-10-01 04:09:49'),
(2, 1, 1, 'Mie Ayam', 'Mie ayam dengan pangsit dan sawi.', 10000, 7, '8a08097ee35e77f6.jpeg', 'aktif', '2026-10-01 04:09:49'),
(3, 1, 2, 'Es Teh Manis', 'Teh manis dingin segar.', 5000, 14, 'e2477a801007309a.jpg', 'aktif', '2026-10-01 04:09:49'),
(4, 1, 2, 'Jus Alpukat', 'Jus alpukat dengan susu coklat.', 8000, 4, 'ad43b90622ca4ddb.jpeg', 'aktif', '2026-10-01 04:09:49'),
(5, 2, 1, 'Nasi Ayam Geprek', 'Ayam geprek sambal pedas dengan nasi.', 13000, 12, 'd8944b070f311948.jpg', 'aktif', '2026-10-01 04:09:49'),
(6, 3, 3, 'Tempe Mendoan', 'Cemilan tapioka renyah.', 10000, 20, '9fc4e871ae1df1c6.jpeg', 'aktif', '2026-10-01 04:09:49'),
(7, 3, 3, 'Pisang Coklat', 'Pisang goreng isi coklat.', 6000, 0, '0572954e2a2b80ca.jpeg', 'aktif', '2026-10-01 04:09:49'),
(8, 4, 1, 'Nasi Campur', 'Nasi dengan aneka lauk.', 14000, 10, '92e2c58c4ac95e3e.jpeg', 'aktif', '2026-10-01 04:09:49'),
(9, 4, 2, 'Kopi Susu', 'Kopi susu dingin.', 9000, 25, '9fd82d8f939f95b0.jpeg', 'aktif', '2026-10-01 04:09:49'),
(10, 5, 1, 'Soto Ayam', 'Soto ayam hangat dengan nasi.', 12000, 9, 'bc4b62d2cabc57dd.jpeg', 'aktif', '2026-10-01 04:09:49'),
(11, 5, 2, 'Es Jeruk', 'Jeruk peras segar.', 6000, 18, 'a52cdeeca075f1c8.jpeg', 'aktif', '2026-10-01 04:09:49'),
(12, 5, 4, 'Pulpen Hitam', 'Pulpen tinta hitam.', 3000, 40, 'e6084117d1d78b2d.jpeg', 'aktif', '2026-10-01 04:09:49'),
(13, 7, 2, 'Americano', '', 13000, 7, '3f98b0eaef131e61.jpeg', 'aktif', '2026-10-01 05:38:08'),
(14, 7, 2, 'Latte', '', 15000, 7, '79157d49e52ca537.jpeg', 'aktif', '2026-10-01 05:38:26'),
(15, 7, 2, 'Matcha', '', 9000, 9, 'b4d8112e563e134c.jpeg', 'aktif', '2026-10-01 05:39:04'),
(16, 8, 6, 'jual kipas bekas', 'jual lagi BU', 125000, 0, '71ad313cd9b4613f.png', 'aktif', '2026-10-01 06:11:50');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
CREATE TABLE IF NOT EXISTS `tenants` (
  `id_tenant` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nama_tenant` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_tenant` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Warung',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `lokasi` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buka` tinyint(1) NOT NULL DEFAULT '1',
  `status_verifikasi` enum('pending','terverifikasi','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tenant`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id_tenant`, `id_user`, `nama_tenant`, `jenis_tenant`, `deskripsi`, `lokasi`, `foto`, `buka`, `status_verifikasi`, `created_at`) VALUES
(1, 3, 'Warung A', 'Warung', 'Warung A menyediakan berbagai makanan dan minuman dengan harga terjangkau dan rasa yang enak.', '150 m dari kampus', 'e0957acf78f90791.jpg', 1, 'terverifikasi', '2026-10-01 04:09:49'),
(2, 4, 'Warung B', 'Warung', 'Aneka lauk dan minuman segar untuk mahasiswa.', '250 m dari kampus', 'a11440b51df58d5c.jpg', 1, 'terverifikasi', '2026-10-01 04:09:49'),
(3, 5, 'Warung C', 'Warung', 'Snack dan jajanan favorit mahasiswa.', 'Samping gerbang kampus', 'db65d73edaca7eb6.jpg', 1, 'terverifikasi', '2026-10-01 04:09:49'),
(4, 6, 'Kantin Fakultas', 'Kantin', 'Kantin di dalam gedung fakultas, menu harian lengkap.', 'Lantai 1 Gedung Fakultas', '2da122662a6f94fa.jpg', 1, 'terverifikasi', '2026-10-01 04:09:49'),
(5, 7, 'Kantin Kampus', 'Kantin', 'Kantin pusat kampus dengan banyak pilihan menu.', 'Area tengah kampus', '092e03f2897ed2d3.jpg', 1, 'terverifikasi', '2026-10-01 04:09:49'),
(6, 8, 'Fotokopi Kampus', 'Fotokopi/Print', 'Print, fotokopi, jilid, dan scan dokumen.', '100 m dari kampus', 'e28ea9268787c92f.jpg', 1, 'terverifikasi', '2026-10-01 04:09:49'),
(7, 9, 'Kopi Mahasiswa', 'Usaha Mahasiswa', 'Usaha kopi milik mahasiswa.', 'Taman kampus', '6a4329715f62d0aa.jpg', 1, 'terverifikasi', '2026-10-01 04:09:49'),
(8, 11, 'jual tv bekas', 'Usaha Mahasiswa', '', '', '8038f0bf68dcc953.png', 1, 'ditolak', '2026-10-01 06:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('mahasiswa','tenant','fotokopi','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin', 'admin@dikampusaja.com', '$2y$12$9yHgFxvFeqaH1VnUUoIetOJexjv0MO4Wy.qTRtjlOXUAF75T6QNq6', 'admin', '2026-10-01 04:09:49'),
(2, 'Andi Pratama', 'andi', 'mahasiswa@dikampusaja.com', '$2y$12$6SwjvkFOK5o39Wz7aOLIkuzyImSOmBPkh0BUIkwWKgIPGJ35.Nsum', 'mahasiswa', '2026-10-01 04:09:49'),
(3, 'Pemilik Warung A', 'warung1', 'warung1@dikampusaja.com', '$2y$12$lDlpN9kv8RiEFNHs6jyOx.cfZiJiP5DgyVtuFCtaaOfcSXmJ29KFe', 'tenant', '2026-10-01 04:09:49'),
(4, 'Pemilik Warung B', 'warung2', 'warung2@dikampusaja.com', '$2y$12$lDlpN9kv8RiEFNHs6jyOx.cfZiJiP5DgyVtuFCtaaOfcSXmJ29KFe', 'tenant', '2026-10-01 04:09:49'),
(5, 'Pemilik Warung C', 'warung3', 'warung3@dikampusaja.com', '$2y$12$lDlpN9kv8RiEFNHs6jyOx.cfZiJiP5DgyVtuFCtaaOfcSXmJ29KFe', 'tenant', '2026-10-01 04:09:49'),
(6, 'Pengelola Kantin Fakultas', 'kantinfak', 'kantinfakultas@dikampusaja.com', '$2y$12$lDlpN9kv8RiEFNHs6jyOx.cfZiJiP5DgyVtuFCtaaOfcSXmJ29KFe', 'tenant', '2026-10-01 04:09:49'),
(7, 'Pengelola Kantin Kampus', 'kantinkampus', 'kantinkampus@dikampusaja.com', '$2y$12$lDlpN9kv8RiEFNHs6jyOx.cfZiJiP5DgyVtuFCtaaOfcSXmJ29KFe', 'tenant', '2026-10-01 04:09:49'),
(8, 'Petugas Fotokopi', 'fotokopi', 'fotokopi@dikampusaja.com', '$2y$12$.oXhv/65YCmgrmZqRFiLmemk2BRDOzEuCVvJmUA..J.rcd1XEoFQa', 'fotokopi', '2026-10-01 04:09:49'),
(9, 'Budi Usaha', 'budi', 'kopimhs@dikampusaja.com', '$2y$12$lDlpN9kv8RiEFNHs6jyOx.cfZiJiP5DgyVtuFCtaaOfcSXmJ29KFe', 'tenant', '2026-10-01 04:09:49'),
(10, 'rayyan', 'ray', 'ray@gmail.com', '$2y$10$kxlqzXkW1ceeWfDSL7MNB.2NJefGJkIAQH55GFZy8ayBMRC5ZAZxO', 'mahasiswa', '2026-10-01 04:12:09'),
(11, 'ulok', 'ulok', 'ulok@ulok.com', '$2y$10$6ngk.O3aC6WVUez/32OKw.VO6ENHsvDnGDQQtxNKdMpo1PijLFFue', 'tenant', '2026-10-01 06:09:27');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_tenant`) REFERENCES `tenants` (`id_tenant`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `products` (`id_produk`);

--
-- Constraints for table `print_orders`
--
ALTER TABLE `print_orders`
  ADD CONSTRAINT `print_orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `print_orders_ibfk_2` FOREIGN KEY (`id_tenant`) REFERENCES `tenants` (`id_tenant`);

--
-- Constraints for table `print_services`
--
ALTER TABLE `print_services`
  ADD CONSTRAINT `print_services_ibfk_1` FOREIGN KEY (`id_tenant`) REFERENCES `tenants` (`id_tenant`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_tenant`) REFERENCES `tenants` (`id_tenant`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `categories` (`id_kategori`) ON DELETE SET NULL;

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
