-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2022 at 08:58 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasirdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `harga_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_kategori`, `nama`, `harga_barang`, `jumlah`) VALUES
(1, 12, 'Susu Indomilk', 5500, 87),
(2, 11, 'Permen Sugus', 2500, 29),
(3, 11, 'Oreo', 9000, 22),
(4, 11, 'Tango Wafer Susu', 7800, 16),
(5, 11, 'Biskuat', 3500, 10),
(6, 11, 'Wafer Superstar', 2000, 30),
(8, 12, 'susu bendera', 5000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `disbarang`
--

CREATE TABLE `disbarang` (
  `id_diskon` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `potongan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `disbarang`
--

INSERT INTO `disbarang` (`id_diskon`, `id_barang`, `qty`, `potongan`) VALUES
(5, 1, 2, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_barang`
--

INSERT INTO `kategori_barang` (`id_kategori`, `nama_kategori`) VALUES
(11, 'Makanan'),
(12, 'Minuman'),
(14, 'Snack'),
(15, 'pokok');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `email` varchar(25) NOT NULL,
  `alamat` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `kontak`, `email`, `alamat`) VALUES
(1, 'Asep', '08568868155', 'dafransi@yahoo.com', 'Jalan cipinang jaya RT 15 RW 01 No 13 '),
(3, 'Lucas', '085677989', 'lucas@gmail.com', 'Jalan Pegangsaan Timur'),
(4, 'Susan', '0218778762', 'susan@gmail.com', 'Jalan manado deket pasar citayem RT 14 R'),
(10, 'james harden', '08568868166', 'james@gmail.com', 'Jalan cipinang lontar RT 15 RW 01 No 13');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id_role`, `nama_role`) VALUES
(1, 'admin'),
(2, 'kasir');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl_wkt` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembali` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `id_user`, `tgl_wkt`, `total`, `bayar`, `kembali`) VALUES
(1, 1, 5, '2022-08-22 10:37:57', 30000, 50000, 20000),
(2, 1, 5, '2022-08-22 10:39:10', 37400, 50000, 12600),
(3, 3, 5, '2022-08-22 10:40:02', 34700, 40000, 5300),
(5, 3, 5, '2022-08-22 14:08:39', 22000, 50000, 28000),
(6, 4, 8, '2022-09-09 13:36:54', 35500, 36500, 1000),
(8, 3, 5, '2022-09-22 00:45:32', 77500, 78500, 1000),
(9, 1, 5, '2022-09-22 01:41:14', 17000, 20000, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_transaksi_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `diskon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id_transaksi_detail`, `id_transaksi`, `id_barang`, `harga`, `qty`, `total`, `diskon`) VALUES
(1, 1, 1, 5500, 5, 27500, 2500),
(2, 1, 2, 2500, 2, 5000, 0),
(3, 2, 2, 2500, 2, 5000, 0),
(4, 2, 3, 9000, 1, 9000, 0),
(5, 2, 4, 7800, 3, 23400, 0),
(6, 3, 4, 7800, 4, 31200, 0),
(7, 3, 5, 3500, 1, 3500, 0),
(9, 5, 1, 5500, 4, 22000, 2500),
(10, 5, 2, 2500, 1, 2500, 0),
(11, 6, 2, 2500, 5, 12500, 0),
(12, 6, 3, 9000, 1, 9000, 0),
(13, 6, 1, 5500, 3, 16500, 2500),
(17, 8, 1, 5500, 14, 77000, 2000),
(18, 8, 2, 2500, 1, 2500, 0),
(19, 9, 1, 5500, 3, 16500, 2000),
(20, 9, 2, 2500, 1, 2500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_role`, `nama_user`, `username`, `password`) VALUES
(1, 1, 'daniel', 'daniels', '$2y$10$.X12C5yGl22Kig/CRjJzfuAhAwAU3Ok4MXg4tPPpFqze.SXvNg11m'),
(2, 2, 'frans', 'fransiscus', '$2y$10$R6SCrT.Nq9Wa7VQRFAZOUeTZnhbU5BbrbtPSRvvge6ETuIxxiWpZW'),
(3, 2, 'lumban', 'lumban', '$2y$10$LUhmYMMjzfNGb6Gk1PXCHuFh9sDTYNFNvT4quQ5OVJNS3ywvACrt6'),
(4, 1, 'sayaadmin', 'sayaadmin', '$2y$10$dRh33Ifc83qdrRl1Dw.asey8svc5EznYMn0tdK1I2ZA8rBy2xF80u'),
(5, 2, 'sayakasir', 'sayakasir', '$2y$10$y2K.jKITMDVhrVm1rEhaSeJ/JohjuR7UdMpVBkmud9b3tbfDBo50W'),
(6, 1, 'aa', 'sada', '$2y$10$gWsD/tMaO07F/AON9ctYx.q8Q4lD.eMqjTGiu9IXhu/1enSF/fcYq'),
(7, 1, 'testadmin', 'testadmin', '$2y$10$IIjHw2ZRS6N.0unIKS7uNukBqJN7iqdXk8cZqCCEUkvhR7W3o/Md.'),
(8, 2, 'testkasir', 'testkasir', '$2y$10$kb7o8SPdR46DWK5c/pbTf.slCz.I5Tgji5/6UuBBThI3qjXFUBpMq');

-- --------------------------------------------------------

--
-- Table structure for table `warung`
--

CREATE TABLE `warung` (
  `id_warung` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_warung` varchar(25) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `kontak` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `warung`
--

INSERT INTO `warung` (`id_warung`, `id_user`, `nama_warung`, `alamat`, `kontak`) VALUES
(1, 4, 'ABCDEFG', 'Jalan Cipinang Jaya Riau RT 14 RW 06 NO 13', '08568868177');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `disbarang`
--
ALTER TABLE `disbarang`
  ADD PRIMARY KEY (`id_diskon`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `warung`
--
ALTER TABLE `warung`
  ADD PRIMARY KEY (`id_warung`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `disbarang`
--
ALTER TABLE `disbarang`
  MODIFY `id_diskon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_barang` (`id_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `disbarang`
--
ALTER TABLE `disbarang`
  ADD CONSTRAINT `disbarang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_3` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_detail_ibfk_4` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role_user` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
