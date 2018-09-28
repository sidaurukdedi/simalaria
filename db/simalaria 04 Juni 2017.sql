-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2017 at 02:34 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simalaria`
--

-- --------------------------------------------------------

--
-- Table structure for table `asal_keg`
--

CREATE TABLE IF NOT EXISTS `asal_keg` (
  `asal_keg` int(1) NOT NULL AUTO_INCREMENT,
  `nama_keg` text,
  PRIMARY KEY (`asal_keg`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `asal_keg`
--

INSERT INTO `asal_keg` (`asal_keg`, `nama_keg`) VALUES
(1, 'PCD'),
(2, 'ACD'),
(3, 'SK'),
(4, 'FUP'),
(5, 'SM'),
(6, 'Kader'),
(7, 'MBS'),
(8, 'MFS');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id_department` varchar(4) NOT NULL,
  `department` varchar(32) NOT NULL,
  PRIMARY KEY (`id_department`),
  KEY `id_department` (`id_department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id_department`, `department`) VALUES
('01', 'Management'),
('02', 'Human Resource'),
('03', 'Finance'),
('04', 'General Affair'),
('05', 'Project');

-- --------------------------------------------------------

--
-- Table structure for table `desa`
--

CREATE TABLE IF NOT EXISTS `desa` (
  `id_desa` int(3) NOT NULL AUTO_INCREMENT,
  `nama_desa` varchar(20) NOT NULL,
  `id_pkm` varchar(11) NOT NULL,
  `jml_penduduk` int(10) NOT NULL,
  `tahun` int(4) NOT NULL,
  PRIMARY KEY (`id_desa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `desa`
--

INSERT INTO `desa` (`id_desa`, `nama_desa`, `id_pkm`, `jml_penduduk`, `tahun`) VALUES
(11, 'desa1', 'P3173060202', 50000, 50000),
(12, 'desa2', 'P3173060202', 60000, 60000),
(13, 'desa3', 'P3173060202', 20000, 20000),
(14, 'desa4', 'P3173060202', 100000, 100000),
(15, 'desa5', 'P3173060202', 40000, 40000);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE IF NOT EXISTS `education` (
  `id_education` varchar(4) NOT NULL,
  `education` varchar(32) NOT NULL,
  PRIMARY KEY (`id_education`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id_education`, `education`) VALUES
('01', 'SD'),
('02', 'SMP'),
('03', 'SMA'),
('04', 'STM'),
('05', 'SMK'),
('06', 'PGA'),
('07', 'D3'),
('08', 'S1'),
('09', 'S2'),
('10', 'S4');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id_employee` int(4) NOT NULL AUTO_INCREMENT,
  `no_employee` varchar(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `place_of_birth` varchar(25) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `id_religion` varchar(4) NOT NULL,
  `id_marital_status` varchar(4) NOT NULL,
  `child` int(3) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `id_last_education` varchar(4) NOT NULL,
  `school_majors` varchar(25) NOT NULL,
  `school_name` varchar(100) NOT NULL,
  `year_graduation` varchar(4) NOT NULL,
  `existing_job` varchar(30) NOT NULL,
  `join_date` date NOT NULL,
  `id_department` varchar(4) NOT NULL,
  `id_employment` varchar(4) NOT NULL,
  `id_employee_status` varchar(4) NOT NULL,
  `resign_date` date DEFAULT NULL,
  `prob_date` date DEFAULT NULL,
  `contract1_start` date DEFAULT NULL,
  `contract2_start` date DEFAULT NULL,
  `contract3_start` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id_employee`),
  KEY `id_employment` (`id_employment`),
  KEY `id_department` (`id_department`),
  FULLTEXT KEY `id_last_education` (`id_last_education`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id_employee`, `no_employee`, `name`, `place_of_birth`, `date_of_birth`, `gender`, `address`, `id_religion`, `id_marital_status`, `child`, `no_hp`, `no_telp`, `photo`, `id_last_education`, `school_majors`, `school_name`, `year_graduation`, `existing_job`, `join_date`, `id_department`, `id_employment`, `id_employee_status`, `resign_date`, `prob_date`, `contract1_start`, `contract2_start`, `contract3_start`, `end_date`) VALUES
(4, 'ST-004', 'Hasanudin', 'Tasikmalaya', '1969-07-05', 'M', 'Kp. Sukamukti RT/RW.007/002 DS/ Kec. Puspahiang-Tasikmalaya 46471', '03', '02', 2, '08131072839', '-', 'ST-004_Hasanudin_17-02-01.png', '06', '-', 'PGA Negeri Sukamanah Tasikmalaya', '1989', 'General Admin', '1995-09-01', '04', '06', '01', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'ST-011', 'Abdullah', 'Jakarta', '1967-04-09', 'M', 'Jl. Tebet Utara 1 G/ 1 RT 007/ 001, Kel. Tebet Timur, Kec. Tebet, Jakarta Selatan', '03', '02', 2, '082113060151', '021-83703747', 'ST-011_Abdullah_17-02-01.png', '01', '-', '-', '-', 'OB', '2002-01-11', '04', '09', '01', NULL, NULL, NULL, NULL, NULL, NULL),
(12, '001991', 'Jhon Tornado', 'Makau', '1979-03-07', 'M', 'Jatiwaringin Estate', '06', '02', 0, '085766699911', '021777222', '001991_Jhon_Tornado_17-05-26.png', '08', 'Teknik Informatika', 'STMIK Anu', '2014', 'Web Administrator', '2017-05-01', '01', '07', '01', NULL, '2017-05-01', NULL, NULL, NULL, '2017-07-01');

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

CREATE TABLE IF NOT EXISTS `employee_status` (
  `id_employee_status` varchar(4) NOT NULL,
  `employee_status` varchar(32) NOT NULL,
  PRIMARY KEY (`id_employee_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_status`
--

INSERT INTO `employee_status` (`id_employee_status`, `employee_status`) VALUES
('01', 'Full Time'),
('02', 'Contract'),
('03', 'Resign');

-- --------------------------------------------------------

--
-- Table structure for table `employment`
--

CREATE TABLE IF NOT EXISTS `employment` (
  `id_employment` varchar(4) NOT NULL,
  `employment` varchar(50) NOT NULL,
  PRIMARY KEY (`id_employment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employment`
--

INSERT INTO `employment` (`id_employment`, `employment`) VALUES
('01', 'Presiden Director'),
('02', 'Deputy Director'),
('03', 'Director'),
('04', 'HR Manager'),
('05', 'HR Staff'),
('06', 'General Admin'),
('07', 'IT Staff'),
('08', 'Driver'),
('09', 'Office Boy'),
('10', 'Accountant'),
('11', 'Finance Staff'),
('12', 'Junior Architect'),
('13', 'Architect'),
('14', 'Senior Architect'),
('15', 'Partner Architect'),
('16', 'Koordinator Concept'),
('17', 'Quality Control'),
('18', 'Junior Drafter'),
('19', 'Drafter'),
('20', 'Senior Drafter'),
('21', 'Project Assistant'),
('22', 'Secretary');

-- --------------------------------------------------------

--
-- Table structure for table `fu3bl`
--

CREATE TABLE IF NOT EXISTS `fu3bl` (
  `id_fu3bl` int(1) NOT NULL AUTO_INCREMENT,
  `hasil_fu3bl` text NOT NULL,
  PRIMARY KEY (`id_fu3bl`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fu3bl`
--

INSERT INTO `fu3bl` (`id_fu3bl`, `hasil_fu3bl`) VALUES
(1, 'Pos'),
(2, 'Neg');

-- --------------------------------------------------------

--
-- Table structure for table `fu4`
--

CREATE TABLE IF NOT EXISTS `fu4` (
  `id_fu4` int(1) NOT NULL AUTO_INCREMENT,
  `hasil_fu4` text NOT NULL,
  PRIMARY KEY (`id_fu4`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fu4`
--

INSERT INTO `fu4` (`id_fu4`, `hasil_fu4`) VALUES
(1, 'Pos'),
(2, 'Neg');

-- --------------------------------------------------------

--
-- Table structure for table `fu14`
--

CREATE TABLE IF NOT EXISTS `fu14` (
  `id_fu14` int(1) NOT NULL AUTO_INCREMENT,
  `hasil_fu14` text NOT NULL,
  PRIMARY KEY (`id_fu14`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fu14`
--

INSERT INTO `fu14` (`id_fu14`, `hasil_fu14`) VALUES
(1, 'Pos'),
(2, 'Neg');

-- --------------------------------------------------------

--
-- Table structure for table `fu28`
--

CREATE TABLE IF NOT EXISTS `fu28` (
  `id_fu28` int(1) NOT NULL AUTO_INCREMENT,
  `hasil_fu28` text NOT NULL,
  PRIMARY KEY (`id_fu28`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fu28`
--

INSERT INTO `fu28` (`id_fu28`, `hasil_fu28`) VALUES
(1, 'Pos'),
(2, 'Neg');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_obat`
--

CREATE TABLE IF NOT EXISTS `hasil_obat` (
  `id_pengobatan` int(1) NOT NULL AUTO_INCREMENT,
  `hasil_pengobatan` text NOT NULL,
  PRIMARY KEY (`id_pengobatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `hasil_obat`
--

INSERT INTO `hasil_obat` (`id_pengobatan`, `hasil_pengobatan`) VALUES
(1, 'S'),
(2, 'Gagal Pengobatan Karena Kepatuhan'),
(3, 'GPfo'),
(4, 'Follow Up Tidak Lengkap');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kelamin`
--

CREATE TABLE IF NOT EXISTS `jenis_kelamin` (
  `jns_kelamin` int(1) NOT NULL AUTO_INCREMENT,
  `nama_kelamin` varchar(10) NOT NULL,
  PRIMARY KEY (`jns_kelamin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jenis_kelamin`
--

INSERT INTO `jenis_kelamin` (`jns_kelamin`, `nama_kelamin`) VALUES
(1, 'L'),
(2, 'P');

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE IF NOT EXISTS `kabupaten` (
  `id_kab` int(10) NOT NULL,
  `nama_kab` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_kab`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kabupaten`
--

INSERT INTO `kabupaten` (`id_kab`, `nama_kab`) VALUES
(3306, 'Kabupaten Purworejo');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE IF NOT EXISTS `kegiatan` (
  `id_kegiatan` int(3) NOT NULL AUTO_INCREMENT,
  `nama_pkm` varchar(30) NOT NULL,
  `bulan` varchar(15) NOT NULL,
  `tahun` int(4) NOT NULL,
  `suspek` int(7) NOT NULL,
  `sd_diperiksa` int(7) DEFAULT NULL,
  `negatif_rdt` int(7) NOT NULL,
  `negatif_mikro` int(7) NOT NULL,
  `negatif_pcr` int(7) NOT NULL,
  `skrin_pos` int(7) NOT NULL,
  `skrin_neg` int(7) NOT NULL,
  `kelambu_anc` int(10) NOT NULL,
  `kelambu_imun` int(10) NOT NULL,
  `kelambu_balita` int(10) NOT NULL,
  `kelambu_lain` int(10) NOT NULL,
  PRIMARY KEY (`id_kegiatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `nama_pkm`, `bulan`, `tahun`, `suspek`, `sd_diperiksa`, `negatif_rdt`, `negatif_mikro`, `negatif_pcr`, `skrin_pos`, `skrin_neg`, `kelambu_anc`, `kelambu_imun`, `kelambu_balita`, `kelambu_lain`) VALUES
(3, 'Grabag', 'Januari', 2016, 3000, NULL, 3, 13, 2, 2, 15, 22, 25, 32, 15);

-- --------------------------------------------------------

--
-- Table structure for table `kerja`
--

CREATE TABLE IF NOT EXISTS `kerja` (
  `id_kerja` int(1) NOT NULL AUTO_INCREMENT,
  `jns_kerja` text,
  PRIMARY KEY (`id_kerja`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `kerja`
--

INSERT INTO `kerja` (`id_kerja`, `jns_kerja`) VALUES
(1, 'Nelayan'),
(2, 'Petani'),
(3, 'Buruh Tambang'),
(4, 'Ibu Rumah tangga'),
(5, 'Pegawai'),
(6, 'TNI'),
(7, 'POLRI'),
(8, 'Berkebun'),
(9, 'Perambah Hutan'),
(10, 'Pedagang'),
(11, 'Petambak');

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi`
--

CREATE TABLE IF NOT EXISTS `klasifikasi` (
  `id_klasifikasi` int(1) NOT NULL AUTO_INCREMENT,
  `klas_kasus` text NOT NULL,
  PRIMARY KEY (`id_klasifikasi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `klasifikasi`
--

INSERT INTO `klasifikasi` (`id_klasifikasi`, `klas_kasus`) VALUES
(1, 'Indigenous'),
(2, 'Kasus Impor');

-- --------------------------------------------------------

--
-- Table structure for table `kondisi`
--

CREATE TABLE IF NOT EXISTS `kondisi` (
  `id_kondisi` int(1) NOT NULL AUTO_INCREMENT,
  `kondisi_pasien` text NOT NULL,
  PRIMARY KEY (`id_kondisi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kondisi`
--

INSERT INTO `kondisi` (`id_kondisi`, `kondisi_pasien`) VALUES
(1, 'Malaria Berat'),
(2, 'Malaria Tanpa Komplikasi');

-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi`
--

CREATE TABLE IF NOT EXISTS `konfirmasi` (
  `id_konf` int(1) NOT NULL AUTO_INCREMENT,
  `jns_konfirmasi` text,
  PRIMARY KEY (`id_konf`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `konfirmasi`
--

INSERT INTO `konfirmasi` (`id_konf`, `jns_konfirmasi`) VALUES
(1, 'PCR'),
(2, 'Mikroskop'),
(3, 'RDT');

-- --------------------------------------------------------

--
-- Table structure for table `logistik`
--

CREATE TABLE IF NOT EXISTS `logistik` (
  `id_pkm` varchar(11) NOT NULL,
  `bulan` varchar(15) DEFAULT NULL,
  `rdt` int(7) NOT NULL,
  `act` int(7) NOT NULL,
  `primaquin` int(7) NOT NULL,
  `artesunate_injeksi` int(7) NOT NULL,
  `artemeter_injeksi` int(7) NOT NULL,
  `kina_tablet` int(7) NOT NULL,
  `kina_injeksi` int(7) NOT NULL,
  `doksi_tablet` int(7) NOT NULL,
  KEY `id_pkm` (`id_pkm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logistik`
--

INSERT INTO `logistik` (`id_pkm`, `bulan`, `rdt`, `act`, `primaquin`, `artesunate_injeksi`, `artemeter_injeksi`, `kina_tablet`, `kina_injeksi`, `doksi_tablet`) VALUES
('P3173060202', 'Januari', 123, 456, 235, 2357, 245, 234, 2367, 234);

-- --------------------------------------------------------

--
-- Table structure for table `marital_status`
--

CREATE TABLE IF NOT EXISTS `marital_status` (
  `id_marital_status` varchar(4) NOT NULL,
  `marital_status` varchar(32) NOT NULL,
  PRIMARY KEY (`id_marital_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marital_status`
--

INSERT INTO `marital_status` (`id_marital_status`, `marital_status`) VALUES
('01', 'Single'),
('02', 'Marriage');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE IF NOT EXISTS `obat` (
  `id_obat` int(2) NOT NULL AUTO_INCREMENT,
  `jenis_obat` text,
  PRIMARY KEY (`id_obat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `jenis_obat`) VALUES
(1, 'ACT'),
(2, 'Primaquine'),
(3, 'Kina'),
(4, 'Non ACT'),
(5, 'ACT dan Primaquine'),
(6, 'Kina dan Tetrasicline dan Primaquine'),
(7, 'Kina dan Doksisiklin dan Primaquine'),
(8, 'Kina dan Primaquine'),
(9, 'Kina Injeksi'),
(10, 'Artesunate Injeksi'),
(11, 'Artemeter Injeksi');

-- --------------------------------------------------------

--
-- Table structure for table `parasit`
--

CREATE TABLE IF NOT EXISTS `parasit` (
  `id_parasit` int(1) NOT NULL AUTO_INCREMENT,
  `jenis_parasit` text,
  PRIMARY KEY (`id_parasit`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `parasit`
--

INSERT INTO `parasit` (`id_parasit`, `jenis_parasit`) VALUES
(1, 'Pf'),
(2, 'Pv'),
(3, 'Pm'),
(4, 'Po'),
(5, 'Pk'),
(6, 'Kp');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE IF NOT EXISTS `pasien` (
  `no` int(5) NOT NULL AUTO_INCREMENT,
  `id_pasien` varchar(20) DEFAULT NULL,
  `nm_pasien` varchar(200) DEFAULT NULL,
  `asal_keg` int(1) DEFAULT NULL,
  `umur` int(3) DEFAULT NULL,
  `jns_kelamin` int(1) DEFAULT NULL,
  `dusun` varchar(25) DEFAULT NULL,
  `desa` varchar(25) DEFAULT NULL,
  `lintang` varchar(11) DEFAULT NULL,
  `bujur` varchar(11) DEFAULT NULL,
  `tgl_riwayat` date NOT NULL,
  `tgl_sakit` date NOT NULL,
  `tgl_kunjung` date DEFAULT NULL,
  `tgl_obat` date NOT NULL,
  `pekerjaan` int(2) DEFAULT NULL,
  `id_konf` int(1) DEFAULT NULL,
  `id_parasit` int(1) DEFAULT NULL,
  `id_obat` int(2) DEFAULT NULL,
  `id_kondisi` int(1) DEFAULT NULL,
  `id_rawat` int(1) DEFAULT NULL,
  `id_fu4` int(1) DEFAULT NULL,
  `id_fu14` int(1) DEFAULT NULL,
  `id_fu28` int(1) DEFAULT NULL,
  `id_fu3bl` int(1) DEFAULT NULL,
  `id_klasifikasi` int(1) NOT NULL,
  `id_rujukdari` int(1) DEFAULT NULL,
  `id_rujukan` int(1) DEFAULT NULL,
  `id_pengobatan` int(1) DEFAULT NULL,
  `id_pkm` varchar(11) DEFAULT NULL,
  `bulan` varchar(15) DEFAULT NULL,
  `tahun` int(4) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `asal_keg` (`asal_keg`),
  KEY `jns_kelamin` (`jns_kelamin`),
  KEY `pekerjaan` (`pekerjaan`),
  KEY `konf_lab` (`id_konf`),
  KEY `jns_parasit` (`id_parasit`),
  KEY `jns_obat` (`id_obat`),
  KEY `kond_pasien` (`id_kondisi`),
  KEY `rawat_pasien` (`id_rawat`),
  KEY `fu4` (`id_fu4`),
  KEY `fu14` (`id_fu14`),
  KEY `fu28` (`id_fu28`),
  KEY `fu3bl` (`id_fu3bl`),
  KEY `rujuk_di` (`id_rujukdari`),
  KEY `rujuk_ke` (`id_rujukan`),
  KEY `id_pkm` (`id_pkm`),
  KEY `klas_kasus` (`id_klasifikasi`),
  KEY `pasien_ibfk_15` (`id_pengobatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`no`, `id_pasien`, `nm_pasien`, `asal_keg`, `umur`, `jns_kelamin`, `dusun`, `desa`, `lintang`, `bujur`, `tgl_riwayat`, `tgl_sakit`, `tgl_kunjung`, `tgl_obat`, `pekerjaan`, `id_konf`, `id_parasit`, `id_obat`, `id_kondisi`, `id_rawat`, `id_fu4`, `id_fu14`, `id_fu28`, `id_fu3bl`, `id_klasifikasi`, `id_rujukdari`, `id_rujukan`, `id_pengobatan`, `id_pkm`, `bulan`, `tahun`) VALUES
(1, 'P3306050201201701001', 'Fajar', 1, 14, 2, 'sumbersari', 'Kaligono', '-7.651670', '109.922931', '2017-01-07', '2017-01-10', '2017-01-10', '2017-01-10', 11, 1, 1, 5, 2, 1, 2, 2, 2, 2, 2, 2, 1, 1, 'P3306050201', '1', 0),
(2, 'P3306050201201701001', '', 1, 73, 2, 'tumpangrejo', 'kaligono', '-8', '110', '2017-01-10', '2017-01-16', '2017-01-16', '2017-01-16', 2, 1, 1, 5, 2, 1, 2, 2, 2, 2, 1, 2, 2, 1, 'P3306050201', '1', 0),
(3, 'P330604020201701003', '', 2, 32, 2, 'genting', 'durensari', '-8', '110', '2017-01-16', '2017-01-16', '2017-01-16', '2017-01-16', 11, 2, 1, 5, 1, 2, 2, 2, 2, 2, 1, 3, 1, 1, 'P3306040202', '1', 0),
(4, 'P3306050201201702001', '', 1, 9, 2, 'sigayang', 'Jatirejo', '-8', '110', '2017-02-09', '2017-02-09', '2017-02-09', '2017-02-09', 11, 2, 1, 5, 1, 2, 2, 2, 2, 2, 2, 3, 2, 1, 'P3306050201', '2', 0),
(5, 'P3306120201201703001', '', 2, 45, 2, 'karanganyar', 'kedungpomahan wetan', '-8', '110', '2017-03-11', '2017-03-11', '2017-03-11', '2017-03-11', 7, 1, 1, 5, 2, 2, 1, 2, 2, 2, 2, 3, 2, 1, 'P3306120201', '3', 0),
(6, '1', 'dadang1', 1, 35, 1, NULL, 'desa1', NULL, NULL, '2016-01-12', '2016-01-12', '2016-01-12', '2016-01-12', 1, 1, 1, 6, 1, 1, 1, 1, NULL, NULL, 1, 1, 2, 3, 'P3306010201', 'Januari', 2016),
(7, '2', 'dadang2', 2, 22, 1, NULL, 'desa2', NULL, NULL, '2016-01-17', '2016-01-17', '2016-01-17', '2016-01-17', 2, 2, 2, 9, 2, 1, 2, 1, NULL, NULL, 2, 2, 1, 3, 'P3306010201', 'Januari', 2016),
(8, '3', 'dadang3', 3, 88, 2, NULL, 'desa3', NULL, NULL, '2016-01-10', '2016-01-10', '2016-01-10', '2016-01-10', 3, 2, 3, 5, 2, 2, 1, 2, NULL, NULL, 1, 1, 2, 3, 'P3306010201', 'Januari', 2016),
(9, '4', 'dadang4', 1, 44, 1, NULL, 'desa1', NULL, NULL, '2016-01-20', '2016-01-20', '2016-01-20', '2016-01-20', 5, 2, 1, 1, 1, 2, 2, 1, NULL, NULL, 2, 2, 2, 3, 'P3306010201', 'Januari', 2016),
(10, '5', 'dadang5', 5, 13, 2, NULL, 'desa2', NULL, NULL, '2016-01-09', '2016-01-09', '2016-01-09', '2016-01-09', 6, 2, 4, 11, 1, 2, 1, 2, NULL, NULL, 1, 1, 1, 3, 'P3306010201', 'Januari', 2016),
(11, 'P4306120201201703001', 'dadang1', 1, 35, 1, NULL, 'desa1', NULL, NULL, '2016-01-12', '2016-01-12', '2016-01-12', '2016-01-12', 1, 1, 1, 6, 1, 1, 1, 1, NULL, NULL, 1, 1, 2, 3, 'P3306010201', 'Januari', 2016),
(12, 'P4306120201201703001', 'dadang2', 2, 22, 1, NULL, 'desa2', NULL, NULL, '2016-01-17', '2016-01-17', '2016-01-17', '2016-01-17', 2, 2, 2, 9, 2, 1, 2, 1, NULL, NULL, 2, 2, 1, 3, 'P3306010201', 'Januari', 2016),
(13, 'P4306120201201703001', 'dadang3', 3, 88, 2, NULL, 'desa3', NULL, NULL, '2016-01-10', '2016-01-10', '2016-01-10', '2016-01-10', 3, 2, 3, 5, 2, 2, 1, 2, NULL, NULL, 1, 1, 2, 3, 'P3306010201', 'Januari', 2016),
(14, 'P4306120201201703001', 'dadang4', 1, 44, 1, NULL, 'desa1', NULL, NULL, '2016-01-20', '2016-01-20', '2016-01-20', '2016-01-20', 5, 2, 1, 1, 1, 2, 2, 1, NULL, NULL, 2, 2, 2, 3, 'P3306010201', 'Januari', 2016),
(15, 'P4306120201201703001', 'dadang5', 5, 13, 2, NULL, 'desa2', NULL, NULL, '2016-01-09', '2016-01-09', '2016-01-09', '2016-01-09', 6, 2, 4, 11, 1, 2, 1, 2, NULL, NULL, 1, 1, 1, 3, 'P3306010201', 'Januari', 2016);

-- --------------------------------------------------------

--
-- Table structure for table `pemetaan`
--

CREATE TABLE IF NOT EXISTS `pemetaan` (
  `id_peta` int(2) NOT NULL AUTO_INCREMENT,
  `lintang` varchar(15) NOT NULL,
  `bujur` varchar(15) NOT NULL,
  `kategori` text NOT NULL,
  PRIMARY KEY (`id_peta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pemetaan`
--

INSERT INTO `pemetaan` (`id_peta`, `lintang`, `bujur`, `kategori`) VALUES
(5, '123456', '123456', 'V'),
(6, '32456', '123754', 'V');

-- --------------------------------------------------------

--
-- Table structure for table `penduduk`
--

CREATE TABLE IF NOT EXISTS `penduduk` (
  `id_penduduk` int(3) NOT NULL AUTO_INCREMENT,
  `id_pkm` varchar(11) NOT NULL,
  `jml_pddk` int(8) NOT NULL,
  PRIMARY KEY (`id_penduduk`),
  KEY `id_pkm` (`id_pkm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `id_user` int(2) NOT NULL AUTO_INCREMENT,
  `nama` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `nama` (`nama`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_user`, `nama`, `password`) VALUES
(1, 'coba', 'a3040f90cc20fa672fe31efcae41d2db'),
(2, 'cobi', '202cb962ac59075b964b07152d234b70'),
(3, 'cobo', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `perawatan`
--

CREATE TABLE IF NOT EXISTS `perawatan` (
  `id_rawat` int(1) NOT NULL AUTO_INCREMENT,
  `jenis_rawatan` text NOT NULL,
  PRIMARY KEY (`id_rawat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `perawatan`
--

INSERT INTO `perawatan` (`id_rawat`, `jenis_rawatan`) VALUES
(1, 'RJ'),
(2, 'RI');

-- --------------------------------------------------------

--
-- Table structure for table `puskemas`
--

CREATE TABLE IF NOT EXISTS `puskemas` (
  `id_pkm` varchar(11) NOT NULL,
  `nama_pkm` varchar(30) DEFAULT NULL,
  `id_kab` int(10) NOT NULL,
  PRIMARY KEY (`id_pkm`),
  KEY `id_kab` (`id_kab`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `puskemas`
--

INSERT INTO `puskemas` (`id_pkm`, `nama_pkm`, `id_kab`) VALUES
('P3306010201', 'Grabag', 3306),
('P3306020201', 'Ngombol', 3306),
('P3306030201', 'Bragolan', 3306),
('P3306030202', 'Bubutan', 3306),
('P3306040201', 'Bagelen', 3306),
('P3306040202', 'Dadirejo', 3306),
('P3306050201', 'Kaligesing', 3306),
('P3306060201', 'PKM Purworejo', 3306),
('P3306060202', 'Mranti', 3306),
('P3306060203', 'Cangkrep', 3306),
('P3306070201', 'Banyu Urip', 3306),
('P3306070202', 'Seboro Krapayak', 3306),
('P3306080201', 'Bayan', 3306),
('P3306090201', 'Kutoarjo', 3306),
('P3306090202', 'Wirun', 3306),
('P3306090203', 'Semawung Daleman', 3306),
('P3306100201', 'Butuh', 3306),
('P3306100202', 'Sruwoh Rejo', 3306),
('P3306110201', 'Pituruh', 3306),
('P3306110202', 'Karang Getas', 3306),
('P3306110203', 'Banyu Asin', 3306),
('P3306120201', 'Kemiri', 3306),
('P3306120202', 'Winong', 3306),
('P3306130201', 'Bruno', 3306),
('P3306140201', 'Gebang', 3306),
('P3306150101', 'Loano', 3306),
('P3306160201', 'Bener', 3306);

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE IF NOT EXISTS `religion` (
  `id_religion` varchar(4) NOT NULL,
  `religion` varchar(32) NOT NULL,
  PRIMARY KEY (`id_religion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `religion`
--

INSERT INTO `religion` (`id_religion`, `religion`) VALUES
('01', 'Budha'),
('02', 'Hindu'),
('03', 'Islam'),
('04', 'Katholik'),
('05', 'Kristen Protestant'),
('06', 'Etc..');

-- --------------------------------------------------------

--
-- Table structure for table `rujuk_dari`
--

CREATE TABLE IF NOT EXISTS `rujuk_dari` (
  `id_rujukdari` int(1) NOT NULL AUTO_INCREMENT,
  `asal_rujuk` text NOT NULL,
  PRIMARY KEY (`id_rujukdari`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rujuk_dari`
--

INSERT INTO `rujuk_dari` (`id_rujukdari`, `asal_rujuk`) VALUES
(1, 'Pustu'),
(2, 'Poskesdes'),
(3, 'Polindes'),
(4, 'Klinik'),
(5, 'Kader');

-- --------------------------------------------------------

--
-- Table structure for table `rujuk_ke`
--

CREATE TABLE IF NOT EXISTS `rujuk_ke` (
  `id_rujukan` int(1) NOT NULL AUTO_INCREMENT,
  `tujuan_rujuk` text NOT NULL,
  PRIMARY KEY (`id_rujukan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rujuk_ke`
--

INSERT INTO `rujuk_ke` (`id_rujukan`, `tujuan_rujuk`) VALUES
(1, 'Rumah Sakit'),
(2, 'Puskesmas Lain');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buku`
--

CREATE TABLE IF NOT EXISTS `tbl_buku` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `penulis` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `isbn` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tbl_buku`
--

INSERT INTO `tbl_buku` (`id`, `judul`, `penulis`, `isbn`) VALUES
(1, 'Learning PHP, MySQL & JavaScript', 'Robin Nixon', 'ISBN-13: 978-1491918661'),
(2, 'PHP and MySQL for Dynamic Web Sites', 'Larry Ullman', 'ISBN-13: 978-0321784070'),
(3, 'PHP Cookbook', 'David Sklar', 'ISBN-13: 978-1449363758'),
(4, 'Programming PHP', 'Kevin Tatroe', 'ISBN-13: 978-1449392772'),
(5, 'Modern PHP: New Features and Good Practices', 'Josh Lockhart', 'ISBN-13: 978-1491905012'),
(6, 'Modern PHP New Features and Good Practices', 'Josh Lockhart', 'ISBN-13: 978-1491905012'),
(7, 'Learning PHP MySQL & JavaScript', 'Robin Nixon', 'ISBN-13: 978-1491918661'),
(8, 'PHP and MySQL for Dynamic Web Sites', 'Larry Ullman', 'ISBN-13: 978-0321784070'),
(9, 'PHP Cookbook', 'David Sklar', 'ISBN-13: 978-1449363758'),
(10, 'Programming PHP', 'Kevin Tatroe', 'ISBN-13: 978-1449392772'),
(11, 'Modern PHP New Features and Good Practices', 'Josh Lockhart', 'ISBN-13: 978-1491905012'),
(12, 'Learning PHP MySQL & JavaScript', 'Robin Nixon', 'ISBN-13: 978-1491918661'),
(13, 'PHP and MySQL for Dynamic Web Sites', 'Larry Ullman', 'ISBN-13: 978-0321784070'),
(14, 'PHP Cookbook', 'David Sklar', 'ISBN-13: 978-1449363758'),
(15, 'Programming PHP', 'Kevin Tatroe', 'ISBN-13: 978-1449392772'),
(16, 'Modern PHP New Features and Good Practices', 'Josh Lockhart', 'ISBN-13: 978-1491905012'),
(17, 'Learning PHP MySQL & JavaScript', 'Robin Nixon', 'ISBN-13: 978-1491918661'),
(18, 'PHP and MySQL for Dynamic Web Sites', 'Larry Ullman', 'ISBN-13: 978-0321784070'),
(19, 'PHP Cookbook', 'David Sklar', 'ISBN-13: 978-1449363758'),
(20, 'Programming PHP', 'Kevin Tatroe', 'ISBN-13: 978-1449392772');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(1) NOT NULL,
  `id_employee` int(4) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `level` enum('Admin','Staff','HR') NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_employee`, `username`, `password`, `level`) VALUES
(1, 12, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
(2, 4, 'staff', '1253208465b1efa876f982d8a9e73eef', 'Staff'),
(4, 3, 'pur1', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
(5, 8, 'HR', 'fd4c638da5f85d025963f99fe90b1b1a', 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `vektor`
--

CREATE TABLE IF NOT EXISTS `vektor` (
  `id_pkm` varchar(11) NOT NULL,
  `bulan` varchar(15) DEFAULT NULL,
  `jenis_tp` text NOT NULL,
  `lintangv` int(15) NOT NULL,
  `bujurv` int(15) NOT NULL,
  `luas_tp` int(15) NOT NULL,
  `jenis_kendali` text,
  `kategori` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vektor`
--

INSERT INTO `vektor` (`id_pkm`, `bulan`, `jenis_tp`, `lintangv`, `bujurv`, `luas_tp`, `jenis_kendali`, `kategori`) VALUES
('P3173060202', 'Januari', 'sungai', 123456, 123456, 45, NULL, 'V'),
('P3173060202', 'Januari', 'kolam', 32456, 123754, 1000, 'larvasida', 'V');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_ibfk_3` FOREIGN KEY (`pekerjaan`) REFERENCES `kerja` (`id_kerja`),
  ADD CONSTRAINT `pasien_ibfk_6` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`);

--
-- Constraints for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD CONSTRAINT `penduduk_ibfk_1` FOREIGN KEY (`id_pkm`) REFERENCES `puskemas` (`id_pkm`);

--
-- Constraints for table `puskemas`
--
ALTER TABLE `puskemas`
  ADD CONSTRAINT `puskemas_ibfk_1` FOREIGN KEY (`id_kab`) REFERENCES `kabupaten` (`id_kab`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
