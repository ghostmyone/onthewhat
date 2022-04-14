-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 28 Jan 2022 pada 23.35
-- Versi server: 5.7.34-log
-- Versi PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbmv`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_deposit`
--

CREATE TABLE `data_deposit` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `PaymentMetod` varchar(255) NOT NULL,
  `InvoiceId` varchar(255) NOT NULL,
  `UniqAmount` int(11) NOT NULL,
  `Balance` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_harga`
--

CREATE TABLE `data_harga` (
  `Id` int(11) NOT NULL,
  `GroupName` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Price2` int(11) NOT NULL,
  `MarkUp` float NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_harga`
--

INSERT INTO `data_harga` (`Id`, `GroupName`, `Price`, `Price2`, `MarkUp`, `Status`) VALUES
(1, 'VIP', 0, 10000, 1.015, 1),
(2, 'VIP', 10000, 100000, 1.015, 1),
(3, 'VIP', 100000, 500000, 1.01, 1),
(4, 'VIP', 500000, 1000000, 1.005, 1),
(5, 'VIP', 1000000, 2000000, 1.001, 1),
(6, 'VIP', 2000000, 10000000, 1.001, 1),
(7, 'resseler', 0, 10000, 1.04, 1),
(8, 'resseler', 10000, 100000, 1.03, 1),
(9, 'resseler', 100000, 500000, 1.03, 1),
(10, 'resseler', 500000, 1000000, 1.02, 1),
(11, 'resseler', 1000000, 2000000, 1.008, 1),
(12, 'resseler', 2000000, 10000000, 1.004, 1),
(13, 'members', 0, 10000, 1.05, 1),
(14, 'members', 10000, 100000, 1.04, 1),
(15, 'members', 100000, 500000, 1.04, 1),
(16, 'members', 500000, 1000000, 1.03, 1),
(17, 'members', 1000000, 2000000, 1.02, 1),
(18, 'members', 2000000, 10000000, 1.07, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_item`
--

CREATE TABLE `data_item` (
  `Id` int(11) NOT NULL,
  `ItemName` varchar(255) NOT NULL,
  `ItemSku` varchar(255) NOT NULL,
  `ItemPrice` int(11) NOT NULL,
  `ProductCode` varchar(255) NOT NULL,
  `ItemStatus` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_order`
--

CREATE TABLE `data_order` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL DEFAULT '0',
  `Email` varchar(255) NOT NULL DEFAULT 'mvteam.sda@gmail.com',
  `Payment` varchar(255) NOT NULL,
  `ItemId` varchar(255) NOT NULL,
  `ItemName` varchar(255) NOT NULL,
  `NickName` varchar(255) NOT NULL,
  `InvoiceId` varchar(255) NOT NULL,
  `StatusOrder` int(11) NOT NULL COMMENT '0.Unpaid1.Paid2.Expired3.Failed4.Failed by server5.Success 6.pending',
  `TanggalOrder` date NOT NULL,
  `TanggalUpdate` datetime DEFAULT NULL,
  `Game` varchar(255) NOT NULL,
  `Ket` varchar(255) NOT NULL DEFAULT '  ',
  `Amount` int(11) NOT NULL,
  `Note` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_product`
--

CREATE TABLE `data_product` (
  `Id` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `ProductCode` varchar(255) NOT NULL,
  `ProductImage` varchar(255) NOT NULL,
  `ProductTutor` text NOT NULL,
  `ProductLink` varchar(255) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ProductStatus` int(11) NOT NULL,
  `ProductType` int(11) NOT NULL COMMENT '0. Manual / 1.Otomatis',
  `ProductCat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_product`
--

INSERT INTO `data_product` (`Id`, `ProductName`, `ProductCode`, `ProductImage`, `ProductTutor`, `ProductLink`, `CreatedAt`, `ProductStatus`, `ProductType`, `ProductCat`) VALUES
(1, 'Higgs Domino', 'HD', 'https://demo11.mvtech.my.id/assets/upload/home/product/0a81ee00e26faa756e6327675d15ae6e.png', 'Masukan user id higgs domino anda. Contoh : 60002112 ', '-', '2021-10-04 17:23:02', 1, 1, 'Games'),
(2, 'FREE FIRE', 'FF', 'https://demo11.mvtech.my.id/assets/upload/home/product/8b9fc87aa9a9b6f863be7fb0c3343020.png', 'Untuk menemukan ID Anda, klik pada ikon karakter. User ID tercantum di bawah nama karakter Anda. Contoh: <b>81237123</b>.', '-', '2021-10-04 17:36:48', 1, 1, 'Games'),
(3, 'MOBILE LEGEND', 'ML', 'https://demo11.mvtech.my.id/assets/upload/home/product/c987e2edbd89bb6634b84dbcd44462f0.png', 'Format No Tujuan disi gabungan antara user_id dan zone_id.Contoh: User Id = 12345678 , Zone Id= 1234.Contoh format = <b>123456781234</b>', '-', '2021-10-04 17:39:05', 1, 1, 'Games'),
(4, 'POINT BLANK', 'PB', 'https://demo11.mvtech.my.id/assets/upload/home/product/f96a8f1b3b2d9892c93fa4638ec5f745.png', 'Untuk menemukan Zepetto ID Anda, silakan kunjungi Halaman Beranda zepetto dan log-in, Kemudian Anda dapat lihat Zepetto ID Anda tercantum di pojok atas kanan layar.', '-', '2021-10-04 17:47:57', 1, 1, 'Games'),
(5, 'Valorant', 'VALO', 'https://demo11.mvtech.my.id/assets/upload/home/product/df7cebe237b7aa4ba89b64b5a0faa92e.png', 'Untuk menemukan Riot ID Anda, buka halaman profil akun dan salin Riot ID+Tag menggunakan tombol yang tersedia disamping Riot ID. (Contoh: <b>mvstore#212</b>)', '-', '2021-10-04 17:49:09', 1, 1, 'Games'),
(6, 'PUBG MOBILE', 'PUBGM', 'https://demo11.mvtech.my.id/assets/upload/home/product/bf5323bfef08dbd8202fd1bb52bda527.png', 'Untuk menemukan ID Anda, klik pada ikon karakter. User ID tercantum di bawah nama karakter Anda. Contoh: <b>81237123</b>.', '-', '2021-10-04 17:51:03', 1, 1, 'Games'),
(7, 'Call of Duty MOBILE', 'CODM', 'https://demo11.mvtech.my.id/assets/upload/home/product/8c4c90e65eed4486119a5e97f9063dbd.png', 'Format no pelanggan = playerid (open ID).Contoh : no pelanggan = 401481375599948625960.', '-', '2021-10-04 17:52:23', 1, 1, 'Games'),
(8, 'Genshin Impact', 'GEN', 'https://demo11.mvtech.my.id/assets/upload/home/product/be60cb8057f4c469499053eea4a8be77.png', 'Format No Tujuan Gabungan Id Server + UID List ID Server 001 = Asia Server 002 = America Server 003 = Europe Server 004 = TW, HK, MO Server. CONTOH : Server = <b> Asia Server</b> UID = <b> 012345678 </b> . Maka no tujuan di isi = <b>001012345678</b>', '-', '2021-10-04 17:54:44', 1, 1, 'Games'),
(9, 'Steam Wallet (IDR)', 'SW', 'https://demo11.mvtech.my.id/assets/upload/home/product/2c1f22b9e46e1ae1f7a70d5e44515ec2.png', 'Masukan nomer hp anda Contoh : 08133xxxxx, Voucher akan dikirimkan di bagian SN/Ket.', '-', '2021-10-04 17:56:41', 1, 1, 'Voucher'),
(10, 'PULSA ALL OPERATOR', 'PULSA', 'https://demo11.mvtech.my.id/assets/upload/home/product/9b2a91102d91934ee58d945fde399e6a.png', 'Masukan Nomer tujuan, Contoh : 081xxxx', 'http://localhost/mcustom/pulsa', '2021-10-04 17:58:11', 1, 1, 'Pulsa & Data'),
(13, 'PLN', 'PLN', 'https://demo11.mvtech.my.id/assets/upload/home/product/41431387aa0779a0875df8a1c8a68a7c.png', 'Masukkan nomor meter/Id pelanggan, Token akan dikirim via email dibagian sn/ket / bisa di lihat di transaksi histori.', '-', '2021-12-22 18:21:08', 1, 1, 'Voucher'),
(14, 'PAKET DATA', 'DATA', 'https://demo11.mvtech.my.id/assets/upload/home/product/d8f516b1b4a103e7d6b56d1b05d18aad.png', 'Masukan Nomer tujuan, Contoh : 081xxxx', 'http://localhost/mcustom/data', '2021-12-28 15:28:03', 1, 1, 'Pulsa & Data'),
(15, 'Speed Drifters', 'SD', 'https://demo11.mvtech.my.id/assets/upload/home/product/392164da85a064e18fdeaeaae3d1776b.png', 'Masukan User ID Speed Drifters anda. Contoh no pelanggan = 1209429029', '-', '2021-12-31 06:33:46', 1, 1, 'Games'),
(16, 'Sausage Man', 'SSA', 'https://demo11.mvtech.my.id/assets/upload/home/product/1ad243a5fe9e8223e35546e13ccb3321.png', 'Untuk menemukan ID Anda, Contoh = 9lzuwk', '-', '2021-12-31 06:34:30', 1, 1, 'Games'),
(17, 'GOOGLE PLAY INDONESIA', 'GPCIDR', 'https://demo11.mvtech.my.id/assets/upload/home/product/b55e8c1587684f58200fd43f4839950a.png', 'Masukan nomer hp anda Contoh : 08133xxxxx, Voucher akan dikirimkan di bagian SN/Ket.', '-', '2021-12-31 06:45:00', 1, 1, 'Voucher');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_setting`
--

CREATE TABLE `data_setting` (
  `Id` int(11) NOT NULL,
  `SiteName` varchar(255) NOT NULL,
  `BonusRegist` int(11) NOT NULL,
  `Resseler1` float NOT NULL,
  `Member1` float NOT NULL,
  `Resseler2` float NOT NULL,
  `Member2` float NOT NULL,
  `Api` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_setting`
--

INSERT INTO `data_setting` (`Id`, `SiteName`, `BonusRegist`, `Resseler1`, `Member1`, `Resseler2`, `Member2`, `Api`) VALUES
(1, 'TUTOR.ID', 0, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_slide`
--

CREATE TABLE `data_slide` (
  `Id` int(11) NOT NULL,
  `NameSlide` varchar(255) NOT NULL,
  `DescSlide` text NOT NULL,
  `FotoSlide` varchar(255) NOT NULL,
  `StatusSlide` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_slide`
--

INSERT INTO `data_slide` (`Id`, `NameSlide`, `DescSlide`, `FotoSlide`, `StatusSlide`, `CreatedAt`) VALUES
(3, 'Slide 1', 'Slide 1 desc', 'https://mvstore.id/assets/upload/home/slide/667ee3178cabacc76613dc96d0bbe5ea.png', 1, '2021-09-29 07:28:33'),
(4, 'Slide 2', 'Slide 2 Desc', 'https://mvstore.id/assets/upload/home/slide/1c18d22683544aa41d56b1721cd13c61.png', 1, '2021-09-29 07:50:13'),
(5, 'Slide 3', 'Desc 3', 'http://localhost/custom/assets/upload/home/slide/3acdf1a5fe6f84dd5e9596da46d5dafd.pnghttps://mvstore.id/assets/upload/home/slide/622b8dc818c33a39b3bb4439411521e4.png', 0, '2021-09-30 10:54:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_untung`
--

CREATE TABLE `data_untung` (
  `Id` int(11) NOT NULL,
  `InvoiceId` varchar(255) NOT NULL,
  `Untung` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Tanggal` date DEFAULT NULL,
  `Created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'resseler', 'Resseler mvstore.id'),
(4, 'VIP', 'Vip resseler');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `Balance` int(11) NOT NULL DEFAULT '0',
  `ApiKey` varchar(255) NOT NULL,
  `PrivateKey` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `Balance`, `ApiKey`, `PrivateKey`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$10$xH6tC8kMT.y75eV.VDTT5eVcjgYnEpOd16qERtttmFk9KRCOXCQK6', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1643383607, 1, 'Admin', 'istrator', 'ADMIN', '0', 96116, 'ed7baaeecc4f6d3c8de5f7acfaa10ecb', '64e1b8d34f425d19e1ee2ea7236d3028');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_deposit`
--
ALTER TABLE `data_deposit`
  ADD PRIMARY KEY (`Id`);

--
-- Indeks untuk tabel `data_harga`
--
ALTER TABLE `data_harga`
  ADD PRIMARY KEY (`Id`);

--
-- Indeks untuk tabel `data_item`
--
ALTER TABLE `data_item`
  ADD PRIMARY KEY (`Id`);

--
-- Indeks untuk tabel `data_order`
--
ALTER TABLE `data_order`
  ADD PRIMARY KEY (`Id`);

--
-- Indeks untuk tabel `data_product`
--
ALTER TABLE `data_product`
  ADD PRIMARY KEY (`Id`);

--
-- Indeks untuk tabel `data_setting`
--
ALTER TABLE `data_setting`
  ADD PRIMARY KEY (`Id`);

--
-- Indeks untuk tabel `data_slide`
--
ALTER TABLE `data_slide`
  ADD PRIMARY KEY (`Id`);

--
-- Indeks untuk tabel `data_untung`
--
ALTER TABLE `data_untung`
  ADD PRIMARY KEY (`Id`);

--
-- Indeks untuk tabel `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indeks untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_deposit`
--
ALTER TABLE `data_deposit`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_harga`
--
ALTER TABLE `data_harga`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT untuk tabel `data_item`
--
ALTER TABLE `data_item`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_order`
--
ALTER TABLE `data_order`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_product`
--
ALTER TABLE `data_product`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `data_setting`
--
ALTER TABLE `data_setting`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_slide`
--
ALTER TABLE `data_slide`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `data_untung`
--
ALTER TABLE `data_untung`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
