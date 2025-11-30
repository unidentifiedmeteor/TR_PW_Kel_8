-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 30 Nov 2025 pada 06.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tr_pwrestoran`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `image_path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `nama`, `harga`, `image_path`) VALUES
(3, 'Cheese Burger', 45000, 'menu_cheeseburger.jpg'),
(4, 'Classic Burger', 47000, 'menu_classicburger.jpg'),
(5, 'Tomato Pizza', 48000, 'menu_tomatopizza.jpg'),
(6, 'Sausage Pizza', 50000, 'menu_sausagepizza.jpg'),
(7, 'Fried Chicken', 40000, 'menu_friedchicken.jpg'),
(8, 'Fried Fries', 25000, 'menu_friedfries.jpg'),
(9, 'Sweet Cola', 15000, 'menu_sweetcola.jpg'),
(10, 'Milk Coffee', 15000, 'menu_milkcoffee.jpg'),
(11, 'Choco Ice Cream', 20000, 'menu_chocoicecream.jpg'),
(13, 'Onion Burger', 48000, 'menu_onionburger.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin', '123', 'admin'),
(3, 'user satu', 'user1', 'user'),
(4, 'user dua', 'user2', 'user'),
(5, 'aisyahimut', 'kamulucu', 'user'),
(6, 'kasir1', '12345', 'kasir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_orders`
--

CREATE TABLE `tr_orders` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_by_user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tr_orders`
--

INSERT INTO `tr_orders` (`id`, `menu_id`, `quantity`, `order_by_user_id`, `order_date`, `total_price`, `status`) VALUES
(2, 3, 1, 5, '2025-11-28 22:18:37', 45000.00, 'done'),
(3, 4, 1, 5, '2025-11-28 22:18:37', 47000.00, 'done'),
(4, 6, 1, 5, '2025-11-28 22:18:37', 50000.00, 'done'),
(5, 9, 1, 5, '2025-11-28 22:18:37', 15000.00, 'done'),
(6, 5, 1, 5, '2025-11-28 22:18:37', 48000.00, 'done'),
(7, 3, 1, 5, '2025-11-28 22:48:32', 45000.00, 'done'),
(8, 4, 1, 5, '2025-11-28 22:48:32', 47000.00, 'done'),
(9, 6, 1, 5, '2025-11-28 22:48:32', 50000.00, 'done'),
(10, 9, 1, 5, '2025-11-28 22:48:32', 15000.00, 'done'),
(11, 5, 1, 5, '2025-11-28 22:48:32', 48000.00, 'done'),
(12, 4, 1, 5, '2025-11-29 02:21:59', 47000.00, 'done'),
(13, 8, 1, 5, '2025-11-29 02:21:59', 25000.00, 'done'),
(14, 5, 1, 5, '2025-11-29 02:21:59', 48000.00, 'done'),
(15, 3, 1, 5, '2025-11-29 02:40:04', 45000.00, 'done'),
(16, 4, 1, 5, '2025-11-29 02:40:04', 47000.00, 'done'),
(17, 5, 1, 5, '2025-11-29 02:40:04', 48000.00, 'done'),
(18, 9, 1, 5, '2025-11-29 02:54:08', 15000.00, 'done'),
(19, 10, 1, 5, '2025-11-29 02:54:08', 15000.00, 'done'),
(20, 4, 1, 5, '2025-11-29 04:00:39', 47000.00, 'done'),
(21, 4, 1, 5, '2025-11-29 17:04:39', 47000.00, 'done'),
(22, 5, 1, 5, '2025-11-29 17:18:28', 48000.00, 'done'),
(23, 4, 1, 5, '2025-11-29 17:28:52', 47000.00, 'done'),
(24, 4, 1, 5, '2025-11-29 17:30:13', 47000.00, 'done'),
(25, 4, 1, 5, '2025-11-29 17:33:16', 47000.00, 'done'),
(26, 3, 1, 5, '2025-11-29 17:33:16', 45000.00, 'done'),
(27, 5, 1, 5, '2025-11-29 17:36:51', 48000.00, 'done'),
(28, 9, 1, 5, '2025-11-29 17:57:29', 15000.00, 'done'),
(29, 8, 1, 5, '2025-11-29 18:11:02', 25000.00, 'done'),
(30, 11, 1, 5, '2025-11-29 18:11:02', 20000.00, 'done'),
(31, 4, 1, 5, '2025-11-29 20:20:41', 47000.00, 'done'),
(32, 3, 1, 5, '2025-11-29 20:27:22', 45000.00, 'done'),
(33, 11, 1, 5, '2025-11-29 20:29:12', 20000.00, 'done'),
(34, 9, 1, 5, '2025-11-29 20:40:00', 15000.00, 'done'),
(35, 4, 1, 5, '2025-11-29 20:45:40', 47000.00, 'done'),
(36, 7, 1, 5, '2025-11-29 21:08:53', 40000.00, 'done'),
(37, 6, 1, 5, '2025-11-29 21:18:38', 50000.00, 'done'),
(38, 10, 1, 5, '2025-11-29 21:20:21', 15000.00, 'done'),
(39, 8, 1, 5, '2025-11-29 21:29:02', 25000.00, 'done'),
(40, 8, 1, 5, '2025-11-29 21:36:58', 25000.00, 'done'),
(41, 9, 1, 5, '2025-11-29 21:44:02', 15000.00, 'done'),
(42, 5, 1, 5, '2025-11-29 21:49:55', 48000.00, 'done'),
(43, 4, 1, 5, '2025-11-29 22:07:52', 47000.00, 'done'),
(44, 5, 1, 5, '2025-11-29 22:12:20', 48000.00, 'done'),
(45, 6, 1, 5, '2025-11-29 22:23:59', 50000.00, 'done'),
(46, 5, 1, 5, '2025-11-29 22:27:25', 48000.00, 'done'),
(47, 4, 1, 5, '2025-11-29 22:31:27', 47000.00, 'done'),
(48, 5, 1, 5, '2025-11-29 22:59:23', 48000.00, 'done'),
(49, 11, 1, 5, '2025-11-29 22:59:23', 20000.00, 'done'),
(50, 5, 1, 5, '2025-11-29 23:01:07', 48000.00, 'done'),
(51, 5, 1, 5, '2025-11-29 23:10:02', 48000.00, 'done'),
(52, 5, 1, 5, '2025-11-29 23:14:21', 48000.00, 'done'),
(53, 4, 1, 5, '2025-11-29 23:25:03', 47000.00, 'done'),
(54, 6, 1, 5, '2025-11-29 23:25:56', 50000.00, 'done'),
(55, 5, 1, 5, '2025-11-29 23:33:14', 48000.00, 'done'),
(56, 5, 1, 5, '2025-11-29 23:40:50', 48000.00, 'done'),
(57, 5, 1, 5, '2025-11-29 23:46:37', 48000.00, 'done'),
(58, 5, 1, 5, '2025-11-30 01:08:49', 48000.00, 'done'),
(59, 6, 1, 5, '2025-11-30 01:08:49', 50000.00, 'done');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tr_orders`
--
ALTER TABLE `tr_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `order_by_user_id` (`order_by_user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tr_orders`
--
ALTER TABLE `tr_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tr_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tr_orders`
--
ALTER TABLE `tr_orders`
  ADD CONSTRAINT `tr_orders_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tr_orders_ibfk_2` FOREIGN KEY (`order_by_user_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
