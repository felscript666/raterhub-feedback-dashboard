-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.1.72-community - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping data for table trp_quality.needs_met: 31 rows
/*!40000 ALTER TABLE `needs_met` DISABLE KEYS */;
REPLACE INTO `needs_met` (`nm_id`, `result_id`, `rating`, `nm_comment`) VALUES
	(1, 13, 'MM-HM', 'Definisi sebagian konteks'),
	(2, 14, 'MM-HM', 'Definisi umum'),
	(3, 15, 'MM-HM', 'Penjelasan luas'),
	(4, 16, 'MM-HM', 'Informasi umum'),
	(5, 17, 'MM-HM', 'Kurang lengkap'),
	(6, 18, 'FullyM', 'Jawaban langsung'),
	(7, 19, 'MM-HM', 'Informasi tidak langsung'),
	(8, 20, 'HM', 'Jawaban jelas'),
	(9, 21, 'HM', 'Jawaban jelas'),
	(10, 22, 'HM', 'Jawaban jelas'),
	(11, 23, 'MM-HM', 'Interpretasi medis'),
	(12, 24, 'MM-HM', 'Penjelasan cukup'),
	(13, 25, 'MM-HM', 'Penjelasan lengkap'),
	(14, 26, 'MM-HM', 'Informasi akademik'),
	(15, 27, 'MM-HM', 'Definisi umum'),
	(16, 28, 'MM-HM', 'Informasi lengkap'),
	(17, 29, 'MM-HM', 'Penjelasan baik'),
	(18, 30, 'MM-HM', 'Penjelasan lengkap'),
	(19, 31, 'MM-HM', 'Definisi cukup'),
	(20, 32, 'FailsM', 'Error page'),
	(21, 33, 'FullyM', 'Website utama'),
	(22, 34, 'FailsM', 'Hanya gambar'),
	(23, 35, 'FailsM-SM', 'Sebagian relevan'),
	(24, 36, 'FailsM-SM', 'Sebagian relevan'),
	(25, 37, 'FailsM-SM', 'Sebagian relevan'),
	(28, 46, 'HM to FullyM', 'Memberikan jawaban mendalam dan sangat akurat terhadap query medis YMYL.'),
	(31, 42, 'MM to HM', 'Sesuai dengan interpretasi query lagu galau, namun variasi lagu terbatas pada selera tertentu.'),
	(32, 46, 'HM to FullyM', 'Memberikan jawaban mendalam dan sangat akurat terhadap query medis YMYL.'),
	(33, 43, 'HM', 'Sangat membantu untuk kueri medis terkait otot atau tulang punggung.'),
	(34, 50, 'FailsM', 'Benar-benar tidak sesuai dengan maksud kueri mengenai tokoh Yasonna Laoly.'),
	(35, 51, 'FailsM', 'Hasil memberikan download game Minecraft untuk kueri tentang istilah tokoh "Bagong".');
/*!40000 ALTER TABLE `needs_met` ENABLE KEYS */;

-- Dumping data for table trp_quality.page_quality: 43 rows
/*!40000 ALTER TABLE `page_quality` DISABLE KEYS */;
REPLACE INTO `page_quality` (`pq_id`, `result_id`, `rating`, `pq_comment`) VALUES
	(1, 1, 'High+', 'Recipe lengkap dan berkualitas'),
	(2, 2, 'Low', 'Video kualitas rendah'),
	(3, 3, 'Low-Medium', 'Iklan mengganggu'),
	(4, 4, 'Lowest', 'Hacked / spam'),
	(5, 5, 'Highest', 'Website pemerintah'),
	(6, 6, 'High+', 'Portal resmi'),
	(7, 7, 'Low-Medium', 'Konten cukup'),
	(8, 8, 'High+', 'Website sekolah resmi'),
	(9, 9, 'High', 'Bank terpercaya'),
	(10, 10, 'Low-Medium', 'Engagement rendah'),
	(11, 11, 'Highest', 'Data pemerintah'),
	(12, 12, 'Lowest-Low', 'Banyak iklan'),
	(13, 15, 'Low+', 'Banyak iklan dan tidak original'),
	(14, 16, 'Medium', 'Penjelasan terbatas'),
	(15, 17, 'Lowest', 'Konten copy'),
	(16, 19, 'Medium', 'Wikipedia standar'),
	(17, 20, 'Highest', 'Website pemerintah'),
	(18, 21, 'Low-Medium', 'Konten biasa'),
	(19, 22, 'Low-Medium', 'Konten biasa'),
	(20, 24, 'High+', 'Konten medis'),
	(21, 25, 'Highest', 'Sumber terpercaya'),
	(22, 26, 'Highest', 'Akademik'),
	(23, 28, 'Highest', 'Rumah sakit terpercaya'),
	(24, 29, 'High', 'Konten baik'),
	(25, 30, 'Highest', 'Platform medis'),
	(26, 32, 'Medium-High', 'Halaman error resmi'),
	(27, 33, 'Highest', 'Website resmi'),
	(28, 35, 'High+', 'Government'),
	(29, 36, 'High+', 'Government'),
	(30, 37, 'Highest', 'Website resmi'),
	(31, 38, 'Medium+ to High', 'Tujuan halaman berita faktual YMYL. Konten profesional namun kurang investigasi original dan menggunakan konten sindikasi (AP/AFP). Relevan untuk standar organisasi berita kredibel namun tidak mencapai Highest karena kurangnya nilai unik.'),
	(32, 39, 'Low to Low+', 'Konten aslinya berguna mengenai rebranding KIP Kuliah, namun tata letak sangat terganggu oleh iklan invasif (Distracting Ads) sesuai Section 5.3 General Guidelines yang menyulitkan akses informasi.'),
	(33, 40, 'High to High+', 'Topik YMYL religi dengan standar kualitas tinggi. Menunjukkan E-E-A-T yang kuat, penjelasan mendalam tentang sejarah kepausan, serta menggunakan referensi dari dokumen resmi gereja (seperti Lumen Gentium).'),
	(35, 42, 'Low+ to Medium', 'Meskipun dari portal berita terpercaya, iklan sangat invasif dan mengganggu konten utama (Distracting Ads).'),
	(34, 41, 'High+ to Highest', 'Konten medis sangat otoritatif dari rumah sakit ternama. E-E-A-T sangat tinggi untuk topik batu empedu.'),
	(36, 43, 'High+ to Highest', 'Topik YMYL Kesehatan; sangat akurat, otoritatif (institusi ternama), dan konten orisinal.'),
	(37, 44, 'Medium+ to High', 'Memberikan gambaran umum yang jelas tentang Pakistan, navigasi baik, konten relevan.'),
	(38, 45, 'Low to Medium', 'Reputasi website kuat, namun tidak menunjukkan keahlian khusus dan konten kurang orisinal.'),
	(39, 46, 'High+ to Highest', 'Topik YMYL Kesehatan; ditulis oleh praktisi gigi berlisensi dengan tingkat E-E-A-T yang sangat tinggi.'),
	(42, 45, 'Low to Medium', 'Reputasi portal kuat, namun konten kurang orisinal dan tidak menunjukkan keahlian khusus pada topik BPJS.'),
	(43, 46, 'High+ to Highest', 'Topik YMYL Kesehatan; ditulis oleh praktisi gigi berlisensi dengan tingkat E-E-A-T yang sangat tinggi.'),
	(44, 50, 'Low to Low+', 'Halaman tidak relevan dengan kueri tokoh publik; tidak ada keterkaitan informasi.'),
	(45, 51, 'Lowest to Low', 'Halaman download pihak ketiga; risiko keamanan dan konten tidak sesuai (Bagong vs Minecraft).');
/*!40000 ALTER TABLE `page_quality` ENABLE KEYS */;

-- Dumping data for table trp_quality.queries: 39 rows
/*!40000 ALTER TABLE `queries` DISABLE KEYS */;
REPLACE INTO `queries` (`query_id`, `query_text`, `locale`, `user_intent`) VALUES
	(1, 'Page Quality', 'id_ID', 'Recipe page'),
	(2, 'Page Quality', 'id_ID', 'Video info'),
	(3, 'Page Quality', 'id_ID', 'Lyrics'),
	(4, 'Page Quality', 'id_ID', 'Spam page'),
	(5, 'Page Quality', 'id_ID', 'Government training'),
	(6, 'Page Quality', 'id_ID', 'Portal login'),
	(7, 'Page Quality', 'id_ID', 'Name meaning'),
	(8, 'Page Quality', 'id_ID', 'School info'),
	(9, 'Page Quality', 'id_ID', 'Bank info'),
	(10, 'Page Quality', 'id_ID', 'Recipe video'),
	(11, 'Page Quality', 'id_ID', 'Gov data'),
	(12, 'Page Quality', 'id_ID', 'Education'),
	(13, 'arti eksploitasi', 'id_ID', 'Definisi kata'),
	(14, 'apakah bob barker masih hidup', 'id_ID', 'Status hidup'),
	(15, 'hhd', 'id_ID', 'Multi meaning'),
	(16, 'arti eksim', 'id_ID', 'Definisi penyakit'),
	(17, 'Bantuan Pangan Non Tunai', 'id_ID', 'Program bantuan'),
	(18, 'sscasn-bkn-go-id', 'id_ID', 'Website intent'),
	(19, 'Page Quality', 'id_ID', 'News Article'),
	(20, 'Page Quality', 'id_ID', 'News Article'),
	(21, 'Page Quality', 'id_ID', 'Encyclopedia Article'),
	(23, 'lagu yang gamon', 'id_ID', 'Mencari rekomendasi lagu galau/gagal move on'),
	(22, 'puisi', 'id_ID', 'Mencari contoh atau definisi puisi'),
	(24, 'apa yang dimaksud tulang punggung', 'id_ID', 'Mencari definisi tulang punggung (medis/kiasan)'),
	(25, 'pakistan bahasa apa', 'id_ID', 'Mencari info bahasa resmi/nasional di Pakistan'),
	(26, 'Teuku Ryan', 'id_ID', 'Mencari informasi umum/berita selebriti'),
	(27, 'Apa yang dimaksud kohesi', 'id_ID', 'Mencari definisi kohesi dalam berbagai konteks'),
	(30, 'Page Quality', 'id_ID', 'Informasi Medis/Penyakit'),
	(31, 'Page Quality', 'id_ID', 'Tips Kesehatan Ginjal'),
	(32, 'Page Quality', 'id_ID', 'Informasi Produk Kecantikan'),
	(33, 'Page Quality', 'id_ID', 'Informasi Ketenagakerjaan/BPJS'),
	(34, 'Page Quality', 'id_ID', 'Informasi Kesehatan Gigi (YMYL)'),
	(35, 'yasonna laoly', 'id_ID', 'Mencari informasi tentang tokoh publik terkait'),
	(36, 'Jelaskan apa yang dimaksud Bagong???', 'id_ID', 'Mencari info tokoh wayang atau istilah terkait'),
	(37, 'Apa yang dimaksud kartu', 'id_ID', 'Mencari definisi umum atau jenis-jenis kartu'),
	(38, 'Page Quality', 'id_ID', 'Health/Medis & Lifestyle evaluation'),
	(39, 'cc', 'id_ID', NULL),
	(40, 'â€¢ Tidak ada nilai unik di MC\r\n<br/>â€¢ Iklan yang Mengganggu', 'id_ID', NULL),
	(41, 'res', 'id_ID', NULL);
/*!40000 ALTER TABLE `queries` ENABLE KEYS */;

-- Dumping data for table trp_quality.results: 48 rows
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
REPLACE INTO `results` (`result_id`, `query_id`, `web_label`, `lp_link`, `image`) VALUES
	(1, 1, 'sasa', 'https://www.sasa.co.id/kreasisasa/recipe/sapo-tahu', NULL),
	(2, 2, 'youtube', 'https://www.youtube.com/watch?v=Bx9el0fV-QU', NULL),
	(3, 3, 'sonora', 'https://www.sonora.id/read/423969499/lirik-lagu-one-more-night-maroon-5-lengkap-dengan-terjemahan', NULL),
	(4, 4, 'klamathshuttle', 'https://www.klamathshuttle.com/pelican-charters.html', NULL),
	(5, 5, 'kemkes', 'https://lms.kemkes.go.id/courses/29b4499f-382e-44a3-b899-54d1dcff941d', NULL),
	(6, 6, 'umkm', 'https://hr-sdma.umkm.go.id/', NULL),
	(7, 7, 'cekartinama', 'https://cekartinama.com/arti-nama-62327-syaddad.html', NULL),
	(8, 8, 'sdnsofifi', 'https://sdnsofifi.sch.id/?kelas=alexis17', NULL),
	(9, 9, 'hanabank', 'https://www.hanabank.co.id/line-bank', NULL),
	(10, 10, 'youtube', 'https://www.youtube.com/watch?v=UhjdnwMecxY', NULL),
	(11, 11, 'kaltimprov', 'https://disbun.kaltimprov.go.id/halaman/kabupaten-kutai-timur', NULL),
	(12, 12, 'ahzaa', 'https://www.ahzaa.net/2023/11/latihan-soal-asesmen-sumatif-akhir_17.html', NULL),
	(13, 13, 'langlangbuana', 'SCRB', NULL),
	(14, 13, 'oxford', 'SCRB', NULL),
	(15, 13, 'gramedia', 'https://www.gramedia.com/literasi/eksploitasi-adalah/', NULL),
	(16, 13, 'wikipedia', 'https://id.wikipedia.org/wiki/Eksploitasi', NULL),
	(17, 13, 'kbbi', 'kbbi.web.id', NULL),
	(18, 14, 'google', 'SCRB', NULL),
	(19, 14, 'wikipedia', 'https://id.wikipedia.org/wiki/Bob_Barker', NULL),
	(20, 14, 'kpi', 'https://kpi.go.id', NULL),
	(21, 14, 'cnn', 'https://cnnindonesia.com', NULL),
	(22, 14, 'liputan6', 'https://liputan6.com', NULL),
	(23, 15, 'scrb', 'SCRB', NULL),
	(24, 15, 'halodoc', 'https://halodoc.com', NULL),
	(25, 15, 'alodokter', 'https://alodokter.com', NULL),
	(26, 15, 'repository', 'pdf', NULL),
	(27, 16, 'wikipedia', 'https://id.wikipedia.org/wiki/Eksim', NULL),
	(28, 16, 'siloam', 'https://siloamhospitals.com', NULL),
	(29, 16, 'halodoc', 'https://halodoc.com', NULL),
	(30, 16, 'alodokter', 'https://alodokter.com', NULL),
	(31, 17, 'scrb', 'SCRB', NULL),
	(32, 17, 'kemensos', 'error page', NULL),
	(33, 18, 'sscasn', 'https://sscasn.bkn.go.id', NULL),
	(34, 18, 'images', 'SCRB', NULL),
	(35, 18, 'dikdin', 'https://dikdin.bkn.go.id', NULL),
	(36, 18, 'register', 'https://sscasn.bkn.go.id/register', NULL),
	(37, 18, 'bkn', 'https://bkn.go.id', NULL),
	(38, 19, 'VOA Indonesia', 'https://www.voaindonesia.com/a/kehadiran-siswa-di-sekolah-sekolah-nigeria-capai-rekor-terendah-karena-ketidakamanan/6264799.html', NULL),
	(39, 20, 'Okezone', 'https://edukasi.okezone.com/read/2025/02/04/65/3110409/kip-kuliah-akan-ganti-nama-mendikti-saintek-menyesuaikan-kabinet-merah-putih?page=all', NULL),
	(40, 21, 'Wikipedia ID', 'https://id.wikipedia.org/wiki/Paus_(Gereja_Katolik)', NULL),
	(44, 25, 'Wikipedia ID (Negara)', 'https://id.wikipedia.org/wiki/Pakistan', NULL),
	(42, 23, 'Kompas TV', 'https://www.kompas.tv/lifestyle/541235/8-rekomendasi-lagu-gamon', NULL),
	(43, 38, 'Siloam Hospitals', 'https://www.siloamhospitals.com/informasi-siloam/artikel/penyebab-otot-belakang-lutut-sakit', NULL),
	(41, 30, 'Gleneagles Hospital', 'https://www.gleneagles.com.sg/id/conditions-diseases/gallstones/symptoms-causes', NULL),
	(45, 33, 'Tempo.co', 'https://www.tempo.co/ekonomi/pemotongan-gaji-untuk-bpjs-ketenagakerjaan-ketahui-berapa-besarannya-2094', NULL),
	(46, 34, 'FKG UM Surabaya', 'https://fkg.um-surabaya.ac.id/homepage/news_article?slug=penyebab-gigi-karies-dan-bagaimana-cara-mengatasinya', '1780755533_screencapture-app-crowdgen-projects-2026-05-30-09_32_56.png'),
	(50, 35, 'St. Francis Pantries', 'https://stfrancispantries.org/', '1776884081_financial information has been verified.PNG'),
	(51, 36, 'Babojoy Games', 'https://mpid.babojoy.com/games/d/com-mojang-minecraftpe.html', '');
/*!40000 ALTER TABLE `results` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
