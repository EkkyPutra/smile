-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 27 Okt 2022 pada 20.16
-- Versi server: 10.3.36-MariaDB-cll-lve
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `botcsmco_pm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_master`
--

CREATE TABLE `tbl_master` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '0: Unknown, 1: Role User, 2: Project Type; 3: Division',
  `value` varchar(200) DEFAULT NULL,
  `background` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `access_level` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tbl_master`
--

INSERT INTO `tbl_master` (`id`, `type`, `value`, `background`, `color`, `access_level`) VALUES
(1, 1, 'administrator', 'E4EDFC', '4885ED', '{\"project\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"lists\":1,\"add\":1,\"edit\":1,\"delete\":1}},\"users\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"lists\":1,\"add\":1,\"edit\":1,\"delete\":1}},\"activity\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"add\":1,\"edit\":1,\"delete\":1}},\"comment\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"add\":1,\"reply\":1}}}'),
(2, 1, 'senior leader', 'E5FAFA', '0FAEAD', '{\"project\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"lists\":1,\"add\":1,\"edit\":1,\"delete\":1}},\"users\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"lists\":1,\"add\":1,\"edit\":1,\"delete\":1}},\"activity\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"add\":1,\"edit\":1,\"delete\":1}},\"comment\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"add\":1,\"reply\":1}}}'),
(3, 1, 'reguler user', 'FBECFD', 'BE2DCD', '{\"project\":{\"is_super\":0,\"as_divisi\":0,\"access\":{\"lists\":1,\"add\":0,\"edit\":0,\"delete\":0}},\"users\":{\"is_super\":0,\"as_divisi\":0,\"access\":{\"lists\":0,\"add\":0,\"edit\":0,\"delete\":0}},\"activity\":{\"is_super\":0,\"as_divisi\":1,\"as_assign\":1,\"access\":{\"list\":1,\"add\":1,\"edit\":1,\"delete\":1}},\"comment\":{\"is_super\":1,\"as_divisi\":1,\"access\":{\"add\":1,\"reply\":1}}}'),
(4, 1, 'user project', 'FFF3D9', 'FFB000', '{\"project\":{\"is_super\":0,\"as_divisi\":1,\"access\":{\"lists\":1,\"add\":1,\"edit\":1,\"delete\":1}},\"users\":{\"is_super\":0,\"as_divisi\":0,\"access\":{\"lists\":0,\"add\":0,\"edit\":0,\"delete\":0}},\"activity\":{\"is_super\":0,\"as_divisi\":1,\"access\":{\"add\":1,\"edit\":1,\"delete\":1}},\"comment\":{\"is_super\":0,\"as_divisi\":1,\"access\":{\"add\":1,\"reply\":1}}}'),
(5, 3, 'GS East', 'E4EDFC', '4885ED', ''),
(6, 3, 'GS West', 'E5FAFA', '0FAEAD', ''),
(7, 3, 'Infra', 'FBECFD', 'BE2DCD', ''),
(8, 3, 'CA', 'FFF3D9', 'FFB000', ''),
(9, 2, 'Project', '', '', ''),
(10, 2, 'BAU', '', '', ''),
(11, 3, 'CSM', 'C5C5C5', '6A6A6A', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project`
--

CREATE TABLE `tbl_project` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '0',
  `divisi` int(11) NOT NULL DEFAULT 0,
  `priority` int(11) NOT NULL DEFAULT 0 COMMENT '0: Not, 1: TOP',
  `type` int(11) NOT NULL DEFAULT 0,
  `deadline` date NOT NULL,
  `progress` int(11) DEFAULT 0,
  `link` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT current_timestamp(),
  `slug` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tbl_project`
--

INSERT INTO `tbl_project` (`id`, `name`, `divisi`, `priority`, `type`, `deadline`, `progress`, `link`, `description`, `created`, `updated`, `slug`) VALUES
(13, 'CPM - Fitting out Malang', 7, 1, 9, '2023-03-31', 10, 'https://docs.google.com/spreadsheets/d/1ZbaUZNxJ8AG9dYrhdaJ0G7JZNoDfBfW9/edit#gid=1419272708', 'Pekerjaan fitting out Malang periode 2022', '2022-10-25 10:55:11', '2022-10-27 12:13:32', 'cpm---fitting-out-malang'),
(14, 'IM - Pengelolaan Gudang Nasional', 7, 0, 10, '2022-10-12', 0, 'https://winona-tsel.mit.id/index.php#!/api/Enggano.id.mit.ineom.warehouse.Warehousetask', 'Pengelolaan rutin , pelaporan bulanan untuk 19 Gudang Nasional Semester II Tahun 2022', '2022-10-25 11:15:44', '2022-10-27 08:49:14', 'im---pengelolaan-gudang-nasional'),
(16, 'Modernisasi CCTV  di Gedung TTC Padang', 7, 0, 9, '2022-12-31', 47, 'https://365tsel-my.sharepoint.com/:f:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022?csf=1&web=1&e=UFlgAD', 'Modernisasi CCTV di TTC Padang, \r\nNilai PO Rp 1.738.926.500, \r\nKamera indoor 45 unit\r\nKamera outdoor 14 unit', '2022-10-27 10:18:04', '2022-10-27 10:09:07', 'modernisasi-cctv--di-gedung-ttc-padang'),
(17, 'Modernisasi CCTV Gedung TTC Kenanga Pekanbaru', 7, 0, 9, '2022-12-31', 45, 'https://365tsel-my.sharepoint.com/:f:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022?csf=1&web=1&e=UFlgAD', 'Modernisasi CCTV di TTC Kenanga Pekanbaru\r\nNilai PO : Rp 1.330.473.500\r\nKamera indoor 32 unit, \r\nKamera outdoor 9 unit', '2022-10-27 10:54:31', '2022-10-27 10:20:55', 'modernisasi-cctv-gedung-ttc-kenanga-pekanbaru'),
(18, 'Modernisasi CCTV Gedung TTC HR Muhammad Surabaya', 7, 0, 9, '2022-12-31', 45, 'https://365tsel-my.sharepoint.com/:f:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022?csf=1&web=1&e=UFlgAD', 'Modernisasi CCTV di TTC HR Muhammad Surabaya\r\nNiai PO : Rp 1.351.295.683\r\nKamera indoor 49 unit\r\nKamera outdoor 13 unit', '2022-10-27 10:57:36', '2022-10-27 10:21:47', 'modernisasi-cctv-gedung-ttc-hr-muhammad-surabaya'),
(19, 'Modernisasi CCTV Gedung TTC Solo Baru', 7, 0, 9, '2022-12-31', 44, 'https://365tsel-my.sharepoint.com/:f:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022?csf=1&web=1&e=UFlgAD', 'Modernisasi CCTV di TTC Solo Baru\r\nNilai PO : Rp 1.063.506.550\r\nKamera indoor 32 unit\r\nKamera outdoor 11 unit', '2022-10-27 10:59:57', '2022-10-27 10:22:02', 'modernisasi-cctv-gedung-ttc-solo-baru'),
(20, 'Modernisasi CCTV Gedung TTC Sudiang Makassar', 7, 0, 9, '2022-12-31', 0, 'https://365tsel-my.sharepoint.com/:f:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022?csf=1&web=1&e=UFlgAD', 'Modernisasi CCTV di TTC Sudiang Makassar\r\nNilai PO : Rp 2.166.580.860\r\nKamera indoor 94 unit\r\nKamera outdoor 7 unit', '2022-10-27 11:19:16', '2022-10-27 10:22:17', 'modernisasi-cctv-gedung-ttc-sudiang-makassar'),
(21, 'Modernisasi CCTV Gedung TTC Pontianak', 7, 0, 9, '2022-12-31', 0, 'https://365tsel-my.sharepoint.com/:f:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022?csf=1&web=1&e=UFlgAD', 'Modernisasi CCTV di TTC Pontianak\r\nNilai PO : Rp 933.054.584\r\nKamera indoor 22 unit\r\nKamera outdoor 9 unit', '2022-10-27 11:28:52', '2022-10-27 10:22:30', 'modernisasi-cctv-gedung-ttc-pontianak'),
(22, 'Modernisasi CCTV Gedung TTC Timika', 7, 0, 9, '2022-12-31', 0, 'https://365tsel-my.sharepoint.com/:f:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022?csf=1&web=1&e=UFlgAD', 'Modernisasi CCTV di TTC Timika\r\nNilai PO : Rp 1.005.701.292\r\nKamera indoor 28 unit\r\nKamera outdoor 8 unit', '2022-10-27 11:29:47', '2022-10-27 10:22:46', 'modernisasi-cctv-gedung-ttc-timika'),
(23, 'IM  - Perbaikan Area Penyimpanan gudang Sentul', 7, 0, 9, '2022-12-31', 53, 'http://www.google.com', 'Penambahan space penyimpanan gudang Sentul, dengan membuat perkerasan area simpan di halaman samping dan belakang (300m2), dampak dari penggabungan gudang Jatikeramat.', '2022-10-27 14:51:52', '2022-10-27 07:54:01', 'im----perbaikan-area-penyimpanan-gudang-sentul'),
(24, 'IM - Project IM', 7, 1, 9, '2022-10-28', 0, 'http://www.detik.com', '1. cyod\r\n2. digitalisasi dokumen - elibrary (SOP, legalitas WO Dokumen)\r\n3. write off dokumen (nasional ready)\r\n4. kontrak gudang manado\r\n5. ijin limbah b3 makasar\r\n6. report bulanan selama 1 semester\r\nsemester II 2022\r\n7. WO non infra batch 4 2022 (ikut batch nya NAM)\r\n8. Pelepasan Aset - WO Infra (validasi data usulan, \r\n9. validasi pengeluaran barang, BAST dgn mitra)\r\n\r\n10. penerbitan ND reminder ke-XX (per 2 bulan)\r\n\r\n11. perbaikan area penyimpanan sentul\r\n\r\nnote :\r\ne-library untuk upload ke winona progra thn 2023\r\n(1 semester)\r\n', '2022-10-27 14:57:22', '2022-10-27 12:13:56', 'im---project-im'),
(25, 'IM - Choose Your Own Device PO 1', 7, 0, 9, '2022-12-31', 75, 'https://ptintikomberlianmustika-my.sharepoint.com/:x:/g/personal/lariyadi_intikom_co_id/EePdWUyongxAm3oL3_DOI0gBTeM7YtoCZDbCVTySbfK27A?rtime=mlJXj7i32kg', 'Deployment Laptop Lenovo Choose Your Own Device Batch 1\r\n', '2022-10-27 15:29:19', '2022-10-27 08:29:19', 'im---choose-your-own-device-po-1'),
(26, 'IM - Choose Your Own Device PO 2', 7, 0, 9, '2023-03-31', 35, 'https://ptintikomberlianmustika-my.sharepoint.com/:x:/g/personal/lariyadi_intikom_co_id/EePdWUyongxAm3oL3_DOI0gBTeM7YtoCZDbCVTySbfK27A?rtime=mlJXj7i32kg', 'Deployment Laptop Lenovo Choose Your Own Device Batch 2', '2022-10-27 15:32:44', '2022-10-27 08:32:44', 'im---choose-your-own-device-po-2'),
(27, 'IM - elibrary', 7, 0, 9, '2022-12-31', 25, 'https://winona-tsel.mit.id/index.php#!/api/Enggano.id.mit.ineom.warehouse.Documentorganization', 'Pembuatan SOP, legalitas WO Dokumen', '2022-10-27 15:35:21', '2022-10-27 08:35:55', 'im---elibrary'),
(28, 'IM - Write Off Dokumen', 7, 0, 9, '2022-12-31', 0, 'https://winona-tsel.mit.id/index.php#!/api/Enggano.id.mit.ineom.warehouse.Documentorganization', 'Write Off Dokumen (Nasional)', '2022-10-27 15:39:11', '2022-10-27 08:39:11', 'im---write-off-dokumen'),
(29, 'IM - kontrak gudang manado', 7, 0, 10, '2022-11-30', 30, 'https://www.telkomsel.com', 'Perpanjangan Kontrak Gudang Manado', '2022-10-27 15:42:32', '2022-10-27 08:42:32', 'im---kontrak-gudang-manado'),
(30, 'IM - ijin limbah b3 makassar', 7, 0, 9, '2022-12-31', 50, 'https://winona-tsel.mit.id/index.php#!/api/Enggano.id.mit.ineom.warehouse.Warehousetask', 'Pembuatan Ijin Pengelolaan Limbah B3 Gudang Makassar', '2022-10-27 15:46:11', '2022-10-27 08:46:11', 'im---ijin-limbah-b3-makassar'),
(31, 'IM - Usulan WO non infra batch 4 2022', 7, 0, 10, '2022-11-30', 0, 'https://www.google.com', 'Usulan Penghapusan Asset Non Infra Batch 4 2022', '2022-10-27 15:50:57', '2022-10-27 08:50:57', 'im---usulan-wo-non-infra-batch-4-2022'),
(32, 'IM - Pelepasan Aset - WO Infra Batch 2 2022', 7, 0, 10, '2022-11-30', 0, 'https://www.google.com', 'validasi data usulan, validasi pengeluaran barang, BAST dgn mitra', '2022-10-27 15:52:27', '2022-10-27 08:52:27', 'im---pelepasan-aset---wo-infra-batch-2-2022'),
(33, 'IM - penerbitan ND reminder ke asset holder', 7, 0, 10, '2023-06-30', 0, 'https://winona-tsel.mit.id/index.php#!/api/Enggano.id.mit.ineom.warehouse.Warehousetask', 'ND reminder per 2 bulan (mencantumkan urutan reminder tiap ND terbit)', '2022-10-27 15:54:14', '2022-10-27 08:54:14', 'im---penerbitan-nd-reminder-ke-asset-holder'),
(35, 'OAID - Enhance PORTAL & PORTAL Mobile', 7, 0, 9, '2023-04-29', 50, 'https://www.figma.com/proto/qTKsM6vvdnBJp3fDo2ERsI/DigiPro_Telkomsel?page-id=1%3A3&node-id=3340%3A52974&viewport=241%2C48%2C0.02&scaling=scale-down&starting-point-node-id=3340%3A52974&show-proto-sideb', 'Penambahan fitur PORTAL', '2022-10-27 18:19:44', '2022-10-27 11:24:01', 'oaid---enhance-portal--portal-mobile'),
(36, 'OAID - SIMPLE Mobile', 7, 0, 9, '2023-09-30', 5, 'https://www.figma.com/proto/SuMlNjm4u3VEv1fWj3L3g4/Portal-Mobile-Responsive?page-id=1%3A3&node-id=1204%3A23436&viewport=73%2C153%2C0.02&scaling=scale-down&starting-point-node-id=1113%3A21694&show-prot', 'SIMPLE versi mobile web view', '2022-10-27 18:21:41', '2022-10-27 11:23:44', 'oaid---simple-mobile'),
(37, 'OAID - Enhance SMILE Dashboard', 7, 0, 9, '2023-08-31', 30, 'https://www.figma.com/proto/zorLiDfcv5t1qKjax3udNg/SMILE-Project?page-id=9%3A2&node-id=11%3A137&viewport=402%2C48%2C0.06&scaling=min-zoom&starting-point-node-id=11%3A137', 'Penambahan fitur dashboard csm (smile dashboard)', '2022-10-27 18:26:05', '2022-10-27 11:26:05', 'oaid---enhance-smile-dashboard'),
(38, 'OAID - Maintenance and Post Implementation Ecorr', 7, 0, 10, '2023-12-31', 20, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=2116%3A44170&node-id=7860%3A119297&viewport=269%2C48%2C0.13&scaling=scale-down&starting-point-node-id=7860%3A128498&s', 'Pencatatan next feature Ecorr', '2022-10-27 18:28:30', '2022-10-27 12:11:29', 'oaid---maintenance-and-post-implementation-ecorr'),
(39, 'OAID - Maintenance and Post Implementation Digital ID Card', 7, 0, 9, '2023-12-31', 10, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=1%3A2&node-id=2080%3A44160&viewport=402%2C48%2C0.14&scaling=scale-down&starting-point-node-id=4232%3A80738&show-proto', 'Penambahan fitur digital ID Card', '2022-10-27 18:30:02', '2022-10-27 12:12:08', 'oaid---maintenance-and-post-implementation-digital-id-card'),
(40, 'OAID - Maintenance and Post Implementation Digital Business Card', 7, 0, 10, '2023-07-31', 20, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=1%3A2&node-id=2080%3A44160&viewport=402%2C48%2C0.14&scaling=scale-down&starting-point-node-id=4232%3A80738&show-proto', 'Penambahan fitur kartu nama digital', '2022-10-27 18:31:38', '2022-10-27 12:11:13', 'oaid---maintenance-and-post-implementation-digital-business-card'),
(41, 'OAID - Enhance Travel Online', 7, 0, 9, '2023-04-30', 25, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=1%3A2&node-id=10330%3A168768&viewport=402%2C48%2C0.14&scaling=scale-down&starting-point-node-id=4232%3A80738&show-pro', 'Terintegrasi dengan traveloka', '2022-10-27 18:33:08', '2022-10-27 11:33:08', 'oaid---enhance-travel-online'),
(42, 'OAID - Enhance Transport x Ride Sharing', 7, 0, 9, '2023-06-30', 25, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=1%3A2&node-id=2080%3A44160&viewport=402%2C48%2C0.14&scaling=scale-down&starting-point-node-id=4232%3A80738&show-proto', 'Fitur ride sharing feturing gocar', '2022-10-27 18:37:29', '2022-10-27 11:37:29', 'oaid---enhance-transport-x-ride-sharing'),
(43, 'OAID - Penambahan Fitur DMS', 7, 0, 9, '2022-12-31', 80, 'https://www.figma.com/proto/ILRrXpBT8rJWRlKZGHOcpa/Telkomsel---DMS?page-id=1%3A2&node-id=1%3A16&viewport=269%2C48%2C0.02&scaling=scale-down&starting-point-node-id=1%3A550&show-proto-sidebar=1', 'Penambahan fitur dan template dokumen untuk mempermudah karyawan membuat dokumen', '2022-10-27 18:39:20', '2022-10-27 11:39:20', 'oaid---penambahan-fitur-dms'),
(44, 'OAID - Smart Meeting Room', 7, 0, 9, '2023-05-31', 80, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=1%3A2&node-id=3948%3A78922&viewport=402%2C48%2C0.14&scaling=scale-down&starting-point-node-id=4232%3A80738&show-proto', 'Aplikasi pemesanan ruang meeting', '2022-10-27 18:41:20', '2022-10-27 11:41:20', 'oaid---smart-meeting-room'),
(45, 'OAID - Travel Management BoD', 7, 0, 9, '2023-05-31', 25, 'https://www.figma.com/proto/zorLiDfcv5t1qKjax3udNg/SMILE-Project?page-id=9%3A2&node-id=11%3A137&viewport=402%2C48%2C0.06&scaling=min-zoom&starting-point-node-id=11%3A137', 'Pemesanan tiket untuk BoD', '2022-10-27 18:43:00', '2022-10-27 11:43:00', 'oaid---travel-management-bod'),
(46, 'OAID - Building+', 7, 0, 9, '2023-02-28', 55, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=1%3A3&node-id=210%3A1013&viewport=284%2C48%2C0.13&scaling=scale-down&starting-point-node-id=3912%3A79092', 'Penyempurnaan fitur', '2022-10-27 18:44:28', '2022-10-27 11:44:28', 'oaid---building'),
(47, 'OAID - Delisia', 7, 0, 9, '2023-08-30', 15, 'https://www.figma.com/proto/zorLiDfcv5t1qKjax3udNg/SMILE-Project?page-id=9%3A2&node-id=11%3A137&viewport=402%2C48%2C0.06&scaling=min-zoom&starting-point-node-id=11%3A137', 'Dashboard for Corporate Affair', '2022-10-27 18:45:34', '2022-10-27 11:45:34', 'oaid---delisia'),
(48, 'OAID - FSKDOP Apps', 7, 0, 9, '2024-01-31', 70, 'https://tia.telkomsel.co.id/FSKDOP/', 'Penyempurnaan aplikasi pemesanan mobil dinas pejabat', '2022-10-27 18:46:53', '2022-10-27 12:11:47', 'oaid---fskdop-apps'),
(49, 'OAID - Repair and Maintenance Apps', 7, 0, 9, '2023-05-31', 15, 'https://www.figma.com/proto/zorLiDfcv5t1qKjax3udNg/SMILE-Project?page-id=9%3A2&node-id=11%3A137&viewport=402%2C48%2C0.06&scaling=min-zoom&starting-point-node-id=11%3A137', 'Aplikasi pencatatan error dan gangguan di gedung', '2022-10-27 18:48:15', '2022-10-27 11:48:15', 'oaid---repair-and-maintenance-apps'),
(50, 'OAID - MyVisitors (New VMS Nationwide and TTC)', 7, 0, 9, '2023-05-01', 89, 'https://www.figma.com/proto/PpP5p0jin6KY4OruUQAcpT/Visitor-Management-System?page-id=1%3A3&node-id=17%3A2905&viewport=370%2C48%2C0.02&scaling=scale-down&starting-point-node-id=17%3A2905&show-proto-sid', 'Pencatatan keluar masuk barang dan orang di gedung dan TTC', '2022-10-27 18:49:38', '2022-10-27 11:49:38', 'oaid---myvisitors-new-vms-nationwide-and-ttc'),
(51, 'OAID - Smart Locker for BSD', 7, 0, 9, '2023-02-28', 25, 'https://www.figma.com/proto/LHnAKSzxpXjO8Fv7gd9BgT/BSD-Telkomsel?node-id=43%3A2996&scaling=scale-down&page-id=2%3A4596&starting-point-node-id=43%3A2996&show-proto-sidebar=1', 'Loker dengan kunci digital di gedung BSD', '2022-10-27 18:51:30', '2022-10-27 11:51:30', 'oaid---smart-locker-for-bsd'),
(52, 'OAID - Parking Apps for BSD', 7, 0, 9, '2023-01-31', 25, 'https://www.figma.com/proto/LHnAKSzxpXjO8Fv7gd9BgT/BSD-Telkomsel?node-id=43%3A2996&scaling=scale-down&page-id=2%3A4596&starting-point-node-id=43%3A2996&show-proto-sidebar=1', 'Pencatatan parkir di gedung office BSD', '2022-10-27 18:56:05', '2022-10-27 11:56:05', 'oaid---parking-apps-for-bsd'),
(53, 'OAID - Landingpage and AR Office BSD', 7, 0, 9, '2023-04-30', 18, 'https://www.figma.com/proto/LHnAKSzxpXjO8Fv7gd9BgT/BSD-Telkomsel?node-id=43%3A2996&scaling=scale-down&page-id=2%3A4596&starting-point-node-id=43%3A2996&show-proto-sidebar=1', 'Landingpage untuk mengakses semua layanan kantor di office BSD', '2022-10-27 18:56:56', '2022-10-27 11:56:56', 'oaid---landingpage-and-ar-office-bsd'),
(54, 'OAID - Wayfinder for BSD', 7, 0, 9, '2023-02-28', 20, 'https://www.figma.com/proto/LHnAKSzxpXjO8Fv7gd9BgT/BSD-Telkomsel?node-id=43%3A2996&scaling=scale-down&page-id=2%3A4596&starting-point-node-id=43%3A2996&show-proto-sidebar=1', 'Penunjuk arah gedung dan layout di gedung BSD', '2022-10-27 18:58:24', '2022-10-27 11:58:24', 'oaid---wayfinder-for-bsd'),
(55, 'OAID - HotSeat', 7, 0, 9, '2023-03-30', 40, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=1%3A2&node-id=1849%3A58144&viewport=402%2C48%2C0.14&scaling=scale-down&starting-point-node-id=4232%3A80738&show-proto', 'Pembagian tempat duduk dan request lokasi kerja Telkomsel', '2022-10-27 18:59:34', '2022-10-27 11:59:34', 'oaid---hotseat'),
(56, 'OAID - CCTV and Access Control Nationwide Dashboard', 7, 0, 9, '2023-03-31', 50, 'https://www.figma.com/proto/hCxy0VgIPpt34YeUCbltcF/SMILE-%26-Moana-Project?page-id=1%3A3&node-id=1402%3A1003&viewport=284%2C48%2C0.13&scaling=scale-down&starting-point-node-id=3912%3A79092', 'Dashboard untuk integrasi cctv dan akses kontrol', '2022-10-27 19:01:13', '2022-10-27 12:01:13', 'oaid---cctv-and-access-control-nationwide-dashboard'),
(57, 'OAID - ELibrary', 7, 0, 9, '2023-03-31', 50, 'https://www.figma.com/proto/qTKsM6vvdnBJp3fDo2ERsI/DigiPro_Telkomsel?page-id=1%3A3&node-id=1920%3A24257&viewport=-506%2C-353%2C0.03&scaling=scale-down&starting-point-node-id=11%3A802', 'Search Engine dokumen Telkomsel', '2022-10-27 19:02:44', '2022-10-27 12:02:44', 'oaid---elibrary'),
(58, 'OAID - Projek Monitoring', 7, 1, 9, '2023-03-30', 95, 'https://pm.botcsm.com/projects/management', 'Database projek CSM', '2022-10-27 19:03:41', '2022-10-27 12:13:21', 'oaid---projek-monitoring'),
(59, 'OAID - Administrasi Infra', 7, 0, 10, '2023-03-31', 80, 'https://tia.telkomsel.co.id/SMILE/', 'Pengaturan budget dan administrasi di Infra', '2022-10-27 19:05:07', '2022-10-27 12:05:07', 'oaid---administrasi-infra'),
(60, 'OAID - Maintenance Wayfinder TSO Lt. 10', 7, 0, 10, '2023-03-31', 80, 'https://tia.telkomsel.co.id/SMILE/', 'Memastikan way-finder berfungsi dengan baik', '2022-10-27 19:06:34', '2022-10-27 12:14:28', 'oaid---maintenance-wayfinder-tso-lt-10'),
(61, 'OAID - Maintenance device LED Video Wall', 7, 0, 10, '2023-03-31', 60, 'https://tia.telkomsel.co.id/SMILE/', 'Memastikan LED Video Wall di TSO berjalan dengan baik', '2022-10-27 19:07:50', '2022-10-27 12:07:50', 'oaid---maintenance-device-led-video-wall'),
(62, 'OAID - Maintenance Device Digital Signage', 7, 0, 10, '2023-03-30', 80, 'https://tia.telkomsel.co.id/SMILE/', 'Memastikan Digital Signage Telkomsel berjalan dengan baik', '2022-10-27 19:08:50', '2022-10-27 12:08:50', 'oaid---maintenance-device-digital-signage'),
(63, 'OAID - Maintenance Device Office Automation', 7, 0, 10, '2023-03-30', 80, 'https://tia.telkomsel.co.id/SMILE/', 'Memastikan semua device OAID berjalan dengan baik, terutama di lantai 21', '2022-10-27 19:09:41', '2022-10-27 12:09:41', 'oaid---maintenance-device-office-automation');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_activities`
--

CREATE TABLE `tbl_project_activities` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(200) NOT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `evidence` varchar(200) NOT NULL,
  `user` varchar(200) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_activities`
--

INSERT INTO `tbl_project_activities` (`id`, `project_id`, `name`, `progress`, `evidence`, `user`, `created`, `updated`) VALUES
(14, 1, 'design figma', 12, 'telkomsel.com', 'faridhi', '2022-10-13 17:39:50', '2022-10-13 10:39:50'),
(16, 1, 'test update 2', 25, 'www.yahdinfaridhi.com', 'faridhi', '2022-10-14 09:22:39', '2022-10-14 02:22:39'),
(17, 1, 'Draft BR', 27, 'file:///C:/Users/yagisan/Documents/Ttd%20Document/Jira_NFT%20VMS%20Enhancement%202022.pdf', 'admin01', '2022-10-14 14:19:36', '2022-10-18 06:46:50'),
(18, 2, 'Aktivitas 1.1', 0, 'Yahdinfaridhi.com', 'faridhi', '2022-10-16 06:29:50', '2022-10-15 23:31:44'),
(19, 2, 'Tes 2', 60, 'Telkomsel.com', 'faridhi', '2022-10-16 06:30:30', '2022-10-18 04:32:05'),
(20, 6, 'Progress 1', 10, 'https://yahdinfaridhi.com', 'jsomplak', '2022-10-20 17:24:34', '2022-10-20 10:24:34'),
(21, 8, 'Aktivitas pertama', 5, 'https://telkomsel.com', 'user_infra', '2022-10-24 09:30:33', '2022-10-24 02:30:42'),
(23, 8, 'aktivitas ketiga', 9, 'https://google.com', 'user_infra', '2022-10-24 09:32:06', '2022-10-24 02:32:30'),
(24, 8, 'aktivitas ke empat', 15, 'https://google.com', 'user_infra', '2022-10-24 09:34:21', '2022-10-24 02:34:21'),
(25, 9, 'aktivitas pertama kali', 1, 'https://yahdinfaridhi.com', 'user_infra', '2022-10-24 09:34:59', '2022-10-24 02:34:59'),
(26, 12, 'Design UI', 40, 'http://www.google.com', 'jsomplak', '2022-10-24 21:02:59', '2022-10-24 14:02:59'),
(27, 13, 'Proses sourching procurement untuk perencana dan pengawas per tanggal 6 Oktober 2022', 10, 'https://www.google.com', 'admin01', '2022-10-25 11:02:11', '2022-10-25 04:02:11'),
(30, 16, 'Modernisasi CCTV TTC Padang WI', 2, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20Kenanga%20dan%20PKU/Padang%20W1%20of%201710', 'HerijadiSoe', '2022-10-27 10:37:35', '2022-10-27 03:37:35'),
(31, 16, 'Modernisasi CCTV TTC Padang', 47, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20Kenanga%20dan%20PKU/Padang%20W2%20of%202510', 'HerijadiSoe', '2022-10-27 10:39:32', '2022-10-27 03:39:32'),
(32, 17, 'Modernisasi W1', 3, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20Kenanga%20dan%20PKU/PKU%20W2%20of%202510202', 'HerijadiSoe', '2022-10-27 11:33:45', '2022-10-27 04:33:45'),
(33, 17, 'Modernisasi progress W2', 45, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20Kenanga%20dan%20PKU/PKU%20W2%20of%202510202', 'HerijadiSoe', '2022-10-27 11:38:27', '2022-10-27 04:38:27'),
(34, 18, 'Progress W1 : 3 sd  7 Okt 2022', 8, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20HR%20Muh,%20Sobar,%20Sudiang,%20Timika,%20P', 'HerijadiSoe', '2022-10-27 17:27:52', '2022-10-27 10:27:52'),
(35, 18, 'Progress W2 : 10 sd 14 Okt 2022', 42, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20HR%20Muh,%20Sobar,%20Sudiang,%20Timika,%20P', 'HerijadiSoe', '2022-10-27 17:29:50', '2022-10-27 10:29:50'),
(36, 18, 'Progress W3 : 17 sd 21 Okt 2022', 45, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20HR%20Muh,%20Sobar,%20Sudiang,%20Timika,%20P', 'HerijadiSoe', '2022-10-27 17:30:58', '2022-10-27 10:30:58'),
(37, 19, 'Progress W1 : 3 sd 7 Okt 2022', 0, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20HR%20Muh,%20Sobar,%20Sudiang,%20Timika,%20P', 'HerijadiSoe', '2022-10-27 17:38:37', '2022-10-27 10:38:37'),
(38, 19, 'Progress W2 : 10 sd 14 Okt 2022', 34, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20HR%20Muh,%20Sobar,%20Sudiang,%20Timika,%20P', 'HerijadiSoe', '2022-10-27 17:39:41', '2022-10-27 10:39:41'),
(39, 19, 'Progress W3 : 17 sd 21 Okt 2022', 44, 'https://365tsel-my.sharepoint.com/:x:/r/personal/herijadi_soebagijo_telkomsel_co_id/Documents/Report%20TTC%207%20lokasi%20Okt%202022/Weekly%20report%20TTC%20HR%20Muh,%20Sobar,%20Sudiang,%20Timika,%20P', 'HerijadiSoe', '2022-10-27 17:40:47', '2022-10-27 10:40:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_comment`
--

CREATE TABLE `tbl_project_comment` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `user` varchar(200) NOT NULL,
  `comment` text NOT NULL,
  `comment_id` int(11) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='	';

--
-- Dumping data untuk tabel `tbl_project_comment`
--

INSERT INTO `tbl_project_comment` (`id`, `project_id`, `user`, `comment`, `comment_id`, `created`) VALUES
(12, 1, 'admin01', 'Test Comment by Ekky\n', 0, '2022-10-14 04:28:39'),
(13, 1, 'faridhi', 'mantap', 0, '2022-10-14 09:22:45'),
(14, 1, 'faridhi', 'mantap 2', 0, '2022-10-14 09:22:50'),
(15, 1, 'faridhi', 'dff', 14, '2022-10-14 16:14:02'),
(16, 1, 'admin01', 'test', 0, '2022-10-14 16:14:04'),
(17, 2, 'faridhi', 'Komen 1', 0, '2022-10-16 06:31:09'),
(18, 1, 'faridhi', 'balas test 1', 16, '2022-10-18 09:53:38'),
(19, 1, 'faridhi', 'balas test 2', 16, '2022-10-18 09:54:05'),
(20, 2, 'faridhi', 'halo', 17, '2022-10-18 10:55:00'),
(21, 2, 'faridhi', 'halo 2', 17, '2022-10-18 10:55:16'),
(22, 2, 'faridhi', 'komen 2', 0, '2022-10-18 10:55:22'),
(23, 2, 'faridhi', 'haloooooo halooo', 0, '2022-10-18 11:29:00'),
(24, 6, 'jsomplak', 'test', 0, '2022-10-20 17:22:57'),
(25, 6, 'jsomplak', 'teesttt', 24, '2022-10-20 17:23:03'),
(26, 6, 'jsomplak', 'test 2', 24, '2022-10-20 17:23:18'),
(27, 6, 'fathul', 'test test commen', 24, '2022-10-21 13:56:06'),
(28, 6, 'admin01', 'balas 4', 24, '2022-10-23 20:50:07'),
(29, 6, 'admin01', 'balas5', 24, '2022-10-23 20:50:22'),
(30, 6, 'admin01', 'Balas tes', 24, '2022-10-23 23:29:34'),
(31, 8, 'admin01', 'Udah sampai mana progressnya?', 0, '2022-10-24 09:09:38'),
(32, 8, 'admin01', 'belum', 31, '2022-10-24 09:09:45'),
(33, 8, 'admin01', 'test komen', 31, '2022-10-24 09:09:57'),
(34, 8, 'user_infra', 'oke', 0, '2022-10-24 09:32:34'),
(35, 9, 'admin02', 'test komen 1', 0, '2022-10-24 09:39:08'),
(36, 12, 'jsomplak', 'Test Comment\n', 0, '2022-10-24 21:03:13'),
(37, 13, 'admin01', 'Oke', 0, '2022-10-25 11:06:10'),
(38, 13, 'admin01', 'test', 0, '2022-10-25 14:05:52'),
(39, 14, 'admin02', 'test', 0, '2022-10-26 10:06:29'),
(40, 14, 'user_infra', 'tes\ntes', 0, '2022-10-27 14:30:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_pic`
--

CREATE TABLE `tbl_project_pic` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '0: Member, 1: Leader'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tbl_project_pic`
--

INSERT INTO `tbl_project_pic` (`id`, `project_id`, `user_id`, `type`) VALUES
(1, 1, 4, 1),
(2, 2, 1, 1),
(3, 2, 3, 0),
(4, 2, 4, 0),
(5, 3, 1, 1),
(6, 3, 4, 0),
(7, 4, 1, 1),
(8, 4, 4, 0),
(9, 5, 1, 1),
(10, 5, 4, 0),
(11, 5, 4, 0),
(12, 6, 1, 1),
(13, 6, 2, 0),
(14, 6, 3, 0),
(15, 7, 5, 1),
(16, 7, 2, 0),
(17, 7, 2, 0),
(23, 10, 5, 1),
(24, 10, 2, 0),
(25, 8, 5, 1),
(26, 8, 2, 0),
(27, 11, 9, 1),
(28, 11, 5, 0),
(29, 12, 2, 1),
(30, 9, 5, 1),
(31, 9, 2, 0),
(34, 15, 2, 1),
(35, 15, 7, 0),
(53, 23, 12, 1),
(55, 25, 15, 1),
(56, 25, 12, 0),
(57, 26, 15, 1),
(58, 26, 12, 0),
(62, 27, 15, 1),
(63, 27, 16, 0),
(64, 27, 17, 0),
(65, 28, 15, 1),
(66, 28, 16, 0),
(67, 28, 17, 0),
(68, 28, 12, 0),
(69, 29, 15, 1),
(70, 29, 17, 0),
(71, 29, 16, 0),
(72, 30, 15, 1),
(73, 30, 17, 0),
(74, 14, 12, 1),
(75, 14, 17, 0),
(76, 31, 12, 1),
(77, 32, 12, 1),
(78, 33, 16, 1),
(79, 34, 18, 1),
(80, 34, 19, 0),
(89, 16, 18, 1),
(90, 16, 19, 0),
(101, 17, 18, 1),
(102, 17, 19, 0),
(103, 18, 18, 1),
(104, 18, 19, 0),
(105, 19, 18, 1),
(106, 19, 19, 0),
(107, 20, 18, 1),
(108, 20, 19, 0),
(109, 21, 18, 1),
(110, 21, 19, 0),
(111, 22, 18, 1),
(112, 22, 19, 0),
(123, 36, 26, 1),
(124, 36, 24, 0),
(125, 36, 27, 0),
(126, 36, 25, 0),
(127, 36, 23, 0),
(128, 35, 24, 1),
(129, 35, 27, 0),
(130, 35, 26, 0),
(131, 35, 25, 0),
(132, 35, 23, 0),
(133, 37, 24, 1),
(134, 37, 27, 0),
(135, 37, 26, 0),
(136, 37, 23, 0),
(137, 37, 25, 0),
(146, 41, 26, 1),
(147, 41, 27, 0),
(148, 41, 23, 0),
(149, 41, 24, 0),
(150, 41, 25, 0),
(151, 42, 27, 1),
(152, 42, 26, 0),
(153, 42, 23, 0),
(154, 42, 24, 0),
(155, 43, 24, 1),
(156, 43, 26, 0),
(157, 44, 24, 1),
(158, 44, 26, 0),
(159, 44, 27, 0),
(160, 45, 26, 1),
(161, 46, 27, 1),
(162, 47, 26, 1),
(164, 49, 27, 1),
(165, 50, 24, 1),
(166, 51, 24, 1),
(167, 52, 24, 1),
(168, 53, 24, 1),
(169, 54, 24, 1),
(170, 55, 24, 1),
(171, 56, 27, 1),
(172, 56, 24, 0),
(173, 57, 26, 1),
(174, 57, 24, 0),
(175, 57, 27, 0),
(176, 57, 23, 0),
(181, 59, 25, 1),
(183, 61, 26, 1),
(184, 62, 26, 1),
(185, 63, 26, 1),
(189, 40, 26, 1),
(190, 40, 24, 0),
(191, 40, 27, 0),
(192, 38, 27, 1),
(193, 38, 24, 0),
(194, 38, 26, 0),
(195, 48, 24, 1),
(196, 39, 27, 1),
(197, 39, 24, 0),
(198, 58, 27, 1),
(199, 58, 24, 0),
(200, 58, 26, 0),
(201, 58, 23, 0),
(202, 13, 11, 1),
(203, 24, 15, 1),
(204, 60, 26, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `role` int(11) NOT NULL,
  `divisi` int(11) DEFAULT 0,
  `handphone` varchar(200) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `role`, `divisi`, `handphone`, `avatar`, `created`, `updated`) VALUES
(1, 'administrator', 'admin01', 1, 11, '0822222222222', '', '2022-10-07 16:09:38', NULL),
(6, 'User GS West', 'user_gswest', 4, 6, '08116333333', '', '2022-10-23 21:41:12', '2022-10-23 21:41:12'),
(7, 'User GS East', 'user_gseast', 4, 5, '08116333334', '', '2022-10-23 21:41:44', '2022-10-23 21:41:44'),
(8, 'User Infra', 'user_infra', 4, 7, '08116333335', '', '2022-10-23 21:42:14', '2022-10-23 21:42:14'),
(9, 'User CAPC', 'user_ca', 4, 8, '08116333336', '', '2022-10-23 21:42:44', '2022-10-23 21:42:44'),
(11, 'Erlangga', 'erlangga', 3, 7, '0811987806', '', '2022-10-25 10:54:43', '2022-10-25 10:54:43'),
(12, 'Doni Hidayat', 'donihid', 3, 7, '08111891679', '', '2022-10-25 11:15:36', '2022-10-25 11:15:36'),
(13, 'Tiosari Orion Tambunan', 'TiosariTam', 2, 11, ' 0811169592', '', '2022-10-26 11:21:46', '2022-10-26 11:21:46'),
(14, 'April Vivadijanto', 'AprilDij', 2, 7, '0811880058', '', '2022-10-26 11:22:39', '2022-10-26 11:22:39'),
(15, 'M. Rizqi Kurniawan', 'MKur', 3, 7, '0811229024', '', '2022-10-26 11:23:26', '2022-10-26 11:23:26'),
(16, 'Mochamad Zakaria', 'mochamadzak', 3, 7, '0811229024', '', '2022-10-26 11:24:02', '2022-10-26 11:24:02'),
(17, 'Muhti Fahmi', 'MuhtiFah', 3, 7, '08118117134', '', '2022-10-26 11:24:43', '2022-10-26 11:24:43'),
(18, 'Stefanus C Widyananto', 'StefanusWid', 3, 7, '0811206464', '', '2022-10-26 11:25:15', '2022-10-26 11:25:15'),
(19, 'Herijadi Soebagijo', 'HerijadiSoe', 3, 7, '0811103443', '', '2022-10-26 11:25:57', '2022-10-26 11:25:57'),
(20, 'Sukma S Kisworo', 'SukmaKis', 3, 7, '0811987747', '', '2022-10-26 11:26:20', '2022-10-26 11:26:20'),
(21, 'Muhammad A Anshari', 'MuhammadAns', 3, 7, '0811800040', '', '2022-10-26 11:26:55', '2022-10-26 11:26:55'),
(22, 'Riza Sulistiyanto', 'RizaSul', 3, 7, '0811918248', '', '2022-10-26 11:27:24', '2022-10-26 11:27:24'),
(23, 'Yagi A Santosa', 'yagisan', 3, 7, '0811100438', '', '2022-10-26 11:27:57', '2022-10-26 11:27:57'),
(24, 'Alfredo Phileo', 'AlfredoPhi', 3, 7, '08111990593', '', '2022-10-26 11:28:25', '2022-10-26 11:28:25'),
(25, 'Eka F Afriana', 'EkaAfr', 3, 7, '0811101784', '', '2022-10-26 11:29:12', '2022-10-26 11:29:12'),
(26, 'Fathul R Said', 'FathulSad', 3, 7, '08111186898', '', '2022-10-26 11:29:40', '2022-10-26 11:29:40'),
(27, 'Yahdin Faridhi', 'YahdinFar', 3, 7, '0811644421', '', '2022-10-26 11:30:10', '2022-10-26 11:30:10'),
(28, 'Andi Agus Akbar', 'AndiAkb', 2, 11, '0811885332', '', '2022-10-26 11:31:21', '2022-10-26 11:31:21'),
(29, 'Irfan Husni', 'IrfanHus', 2, 6, '0811707007', '', '2022-10-26 11:33:35', '2022-10-26 11:33:35'),
(30, 'Laurentius AK Nugroho', 'LaurentiusNug', 2, 8, '08119629993', '', '2022-10-26 11:34:36', '2022-10-26 11:34:36'),
(31, 'Anhari Fiftyanto', 'anharifif', 2, 5, '0811393039', '', '2022-10-26 11:35:25', '2022-10-26 11:35:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user_access`
--

CREATE TABLE `tbl_user_access` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `type` int(11) NOT NULL COMMENT 'User Access Type',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tbl_user_access`
--

INSERT INTO `tbl_user_access` (`id`, `username`, `password`, `last_login`, `type`, `created`, `updated`) VALUES
(1, 'admin01', '$2y$08$YXDdJ34.ZAa3PvgzTqZrW.p6nWBwdIxJW8DioMuCRYabVmJcaQFTG', '2022-10-27 19:59:40', 1, '2022-10-07 16:09:38', '2022-10-26 03:14:32'),
(2, 'jsomplak', '$2y$08$wUWeFNCb99lCx4hqnEIKkuRMkzkHK.2VqaqEaKNfKllfuJQBdHUY6', '2022-10-25 21:55:07', 4, '2022-10-11 00:19:49', '2022-10-24 12:22:32'),
(3, 'yahdin', '$2y$08$yajAAHIFS2UUldHvRmQR9eoLIEMdEPueanXTcPEP2nLgmghM1SCsm', '2022-10-11 10:41:18', 3, '2022-10-11 10:41:18', '2022-10-11 03:41:18'),
(4, 'faridhi', '$2y$08$OhsjP0dUQ/yl1O90tdl1u.P0HvTmdOtXF/7EYKsHigh31xjFovN/y', '2022-10-20 17:05:24', 4, '2022-10-11 10:44:31', '2022-10-11 03:44:31'),
(5, 'fathul', '$2y$08$dJ.t9DN5XMDaK6zL4Xf1NuVO84vXbI.mn0Nuoi0qY95jWg6FYU6Xm', '2022-10-25 10:35:12', 1, '2022-10-20 17:21:30', '2022-10-24 14:52:35'),
(6, 'user_gswest', '$2y$08$Edwv/McSqA82.IlFoYQIzOcdz5a57f.X.EE5iJAOlM59cgOiIwPr2', '2022-10-25 10:08:06', 4, '2022-10-23 21:41:12', '2022-10-23 14:41:12'),
(7, 'user_gseast', '$2y$08$d7Zg2Ye6CexxM55nNzkAT.cIsW89RY9wOGTB78Mi8jyf/0N946rGS', '2022-10-24 09:14:50', 4, '2022-10-23 21:41:44', '2022-10-23 14:41:44'),
(8, 'user_infra', '$2y$08$2rZtsQEfQkwvZwYmUHfmieef3/fmePSqK35fXNmSG1ATGXS.x/vxW', '2022-10-27 16:09:43', 4, '2022-10-23 21:42:14', '2022-10-23 14:42:14'),
(9, 'user_ca', '$2y$08$fvqqtQ9dsSq/cJjawqPvWeqldrq9povi7xaaCQR2kPBXPoM3Ocr02', '2022-10-23 21:53:33', 4, '2022-10-23 21:42:44', '2022-10-23 14:42:44'),
(10, 'admin02', '$2y$08$rbwCRxRLg55dHSjrKc7MKeK7kVlUIGRRm6j8ljK21huN6Pk2BZKDy', '2022-10-26 10:05:45', 1, '2022-10-24 09:38:35', '2022-10-26 03:06:14'),
(11, 'erlangga', '$2y$08$mtEIbqVAvfNURMBgr8kd1eKSGzRppXvD9UPHz3CJOsnO8/5jyMLdS', '2022-10-26 16:14:22', 3, '2022-10-25 10:54:43', '2022-10-25 03:54:43'),
(12, 'donihid', '$2y$08$tuDNB7RkIugjGGcheWe2M.YSj716bZpAPB8x8Q/5S/OitbIn0QJOK', '2022-10-25 11:15:36', 3, '2022-10-25 11:15:36', '2022-10-25 04:15:36'),
(13, 'TiosariTam', '$2y$08$Hl0SnIm3yeKfEir1VmrCXOuOL6Kz4tbaLj.zjUx..nzF8QqtdjizG', '2022-10-26 11:21:46', 2, '2022-10-26 11:21:46', '2022-10-26 04:21:46'),
(14, 'AprilDij', '$2y$08$kEU/sUh5ND4aW4QtSabAsu6UfRTCEVDDtUgnlmezYV.NE0LPNXbs6', '2022-10-26 11:22:39', 2, '2022-10-26 11:22:39', '2022-10-26 04:22:39'),
(15, 'MKur', '$2y$08$QInGYpA85tOEXeRnZVHYuei9LqrcUgn0vRm7WW4dKmOWHTRQUmzQK', '2022-10-26 11:23:26', 3, '2022-10-26 11:23:26', '2022-10-26 04:23:26'),
(16, 'mochamadzak', '$2y$08$FBd5/VT8KqsxT3Jju3r6Sebokepx.h6KMsOXF9XrNrdE5iBIXsZde', '2022-10-26 11:24:02', 3, '2022-10-26 11:24:02', '2022-10-26 04:24:02'),
(17, 'MuhtiFah', '$2y$08$MJv5VDWeQtoDyBBMIz8Z0OHA0fgfXdM1XxhcANmTlgGOMuRlwLn6q', '2022-10-26 11:24:43', 3, '2022-10-26 11:24:43', '2022-10-26 04:24:43'),
(18, 'StefanusWid', '$2y$08$HME3rWCIvAf/duTMg.qZD.FNP9mF8BKVAuaubabA7v6o9h5ckaJDS', '2022-10-26 11:25:15', 3, '2022-10-26 11:25:15', '2022-10-26 04:25:15'),
(19, 'HerijadiSoe', '$2y$08$pblgcgDURje49P4A7E2Oau/bQjLNghb.NWc1bQD1vB3AlouHbyntq', '2022-10-27 17:23:57', 3, '2022-10-26 11:25:57', '2022-10-26 04:25:57'),
(20, 'SukmaKis', '$2y$08$saqPAC4tGTp1FE/4xraIiOlRygKnh20VfnilXH33ccLqnPwaJ.raW', '2022-10-26 11:26:20', 3, '2022-10-26 11:26:20', '2022-10-26 04:26:20'),
(21, 'MuhammadAns', '$2y$08$c97Vdfub996NzUP.dpaHOuGEk6NCeBKzRf6LQ6xXR/pwwYBXHLiPa', '2022-10-26 11:26:55', 3, '2022-10-26 11:26:55', '2022-10-26 04:26:55'),
(22, 'RizaSul', '$2y$08$h/JMrxMyiCaxKQMgNHdcPejKlYHlJpKkTa72z6rNfiFhcv.UDAI76', '2022-10-26 11:27:24', 3, '2022-10-26 11:27:24', '2022-10-26 04:27:24'),
(23, 'yagisan', '$2y$08$k7SJu50p0b9jql.gY..b6u6QmOa57rvzCUXSi7kbW5kZ9l3kg7zQi', '2022-10-26 11:27:57', 3, '2022-10-26 11:27:57', '2022-10-26 04:27:57'),
(24, 'AlfredoPhi', '$2y$08$ueZaQ8oBZkYN.IsxMBlY1.jVNEjQThomWBs1QW.D5Np4zDKYKAGB6', '2022-10-26 11:28:25', 3, '2022-10-26 11:28:25', '2022-10-26 04:28:25'),
(25, 'EkaAfr', '$2y$08$HJKh.M4NFAFHdiQhXzKgaesmh2K.2aaxj6v35YJabtn40dnFkOCQq', '2022-10-26 11:29:12', 3, '2022-10-26 11:29:12', '2022-10-26 04:29:12'),
(26, 'FathulSad', '$2y$08$MX8HUZ11gFm5fPI2NXmisuQ.hdbyq6nF.ltRHmO/HtEEf0/mxvqvO', '2022-10-27 18:24:43', 3, '2022-10-26 11:29:40', '2022-10-26 04:29:40'),
(27, 'YahdinFar', '$2y$08$JyrhO.8T3kjkyZs7W6d.7OWuObPX.6aqtea.WQHcdkW9OejAOK2Uq', '2022-10-27 10:55:51', 3, '2022-10-26 11:30:10', '2022-10-26 04:30:10'),
(28, 'AndiAkb', '$2y$08$uGwj2A8cxqVVGJbXPELajOig8Ks7wPhUSvtiVSwEmAd7fNI8lk7CK', '2022-10-26 11:31:21', 2, '2022-10-26 11:31:21', '2022-10-26 04:32:44'),
(29, 'IrfanHus', '$2y$08$H4KLQFNFPIUqXD5aw.ku/OpeXV/oSpegUGCHVs0uz5deUZRmmtxYC', '2022-10-26 11:33:35', 2, '2022-10-26 11:33:35', '2022-10-26 04:33:35'),
(30, 'LaurentiusNug', '$2y$08$Oqop5CAUGVDyUUbGcnK1V.S1V5QP2HMu4j51om6urhdRlYLsle.AK', '2022-10-26 11:34:36', 2, '2022-10-26 11:34:36', '2022-10-26 04:34:36'),
(31, 'anharifif', '$2y$08$u62eTfPRQsFFsVftsgHDSetGyl8jvByjK1aYGgljYXJ7hKz2UEtAm', '2022-10-26 11:35:25', 2, '2022-10-26 11:35:25', '2022-10-26 04:35:25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_master`
--
ALTER TABLE `tbl_master`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indeks untuk tabel `tbl_project`
--
ALTER TABLE `tbl_project`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indeks untuk tabel `tbl_project_activities`
--
ALTER TABLE `tbl_project_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_project_comment`
--
ALTER TABLE `tbl_project_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_project_pic`
--
ALTER TABLE `tbl_project_pic`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indeks untuk tabel `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_master`
--
ALTER TABLE `tbl_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_project`
--
ALTER TABLE `tbl_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_activities`
--
ALTER TABLE `tbl_project_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_comment`
--
ALTER TABLE `tbl_project_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_pic`
--
ALTER TABLE `tbl_project_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;
