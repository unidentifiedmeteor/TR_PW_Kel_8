-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 05:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `image_path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama`, `harga`, `image_path`) VALUES
(2, 'Bolognese', 14000, 'gambar_makanan/9f3a8900ac69217f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin', '123', 'admin'),
(3, 'user satu', 'user1', 'user'),
(4, 'user dua', 'user2', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- tabel tr_orders
-- Query SQL untuk membuat tabel tr_orders
CCREATE TABLE tr_orders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    
    -- Kolom Foreign Key ke Menu
    menu_id INT(11) NOT NULL,
    
    -- Detail Item Pesanan
    quantity INT(11) NOT NULL,
    
    -- Kolom Foreign Key ke User/Staff
    order_by_user_id INT(11) NOT NULL,
    
    -- Informasi Transaksi
    order_date DATETIME NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL, 
    status VARCHAR(50) NOT NULL,
    
    PRIMARY KEY (id),
    
    -- 1. Relasi ke Tabel MENU (DULU: tr_pwirestoran)
    FOREIGN KEY (menu_id) 
        REFERENCES menu(id) -- DIKOREKSI: Menggunakan 'menu'
        ON UPDATE CASCADE 
        ON DELETE RESTRICT, 
        
    -- 2. Relasi ke Tabel ROLES (DULU: tr_roles)
    FOREIGN KEY (order_by_user_id) 
        REFERENCES roles(id) -- DIKOREKSI: Menggunakan 'roles'
        ON UPDATE CASCADE 
        ON DELETE RESTRICT
) ENGINE=InnoDB;