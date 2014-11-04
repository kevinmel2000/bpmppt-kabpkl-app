--
-- MySQL 5.5.40
-- Tue, 04 Nov 2014 07:17:08 +0000
--

DROP TABLE `baka_auth_groupperms`;
CREATE TABLE `baka_auth_groupperms` (
   `group_id` smallint(4) unsigned not null,
   `perms_id` smallint(4) unsigned not null,
   PRIMARY KEY (`group_id`,`perms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `baka_auth_groupperms` (`group_id`, `perms_id`) VALUES
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4'),
('1', '5'),
('1', '6'),
('1', '7'),
('1', '8'),
('1', '9'),
('1', '10'),
('1', '11'),
('1', '12'),
('1', '13'),
('1', '14'),
('1', '15'),
('1', '16'),
('1', '17'),
('1', '18'),
('1', '19'),
('1', '20'),
('1', '21'),
('1', '22'),
('1', '23'),
('1', '24'),
('1', '25'),
('1', '26'),
('1', '27'),
('1', '28'),
('1', '29'),
('1', '30'),
('1', '31'),
('1', '32'),
('2', '1'),
('3', '16'),
('3', '17'),
('3', '18'),
('3', '19'),
('3', '20'),
('3', '21'),
('3', '22'),
('3', '23'),
('3', '24'),
('4', '16'),
('4', '17'),
('4', '18'),
('4', '19'),
('4', '20'),
('4', '21'),
('4', '25'),
('5', '16'),
('5', '17'),
('5', '18'),
('5', '19'),
('5', '20'),
('5', '21'),
('5', '26'),
('5', '27'),
('5', '28'),
('5', '29'),
('5', '30'),
('5', '31'),
('5', '32');

DROP TABLE `baka_auth_groups`;
CREATE TABLE `baka_auth_groups` (
   `id` int(11) not null auto_increment,
   `key` varchar(50) not null,
   `name` varchar(100) not null,
   `description` varchar(255) not null,
   `default` tinyint(1) not null default '0',
   `active` tinyint(1) not null default '1',
   `can_delete` tinyint(1) not null default '1',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;

INSERT INTO `baka_auth_groups` (`id`, `key`, `name`, `description`, `default`, `active`, `can_delete`) VALUES
('1', 'admins', 'Administrator', 'Super Administrator', '0', '1', '0'),
('2', 'users', 'Users', 'Pengguna Biasa', '1', '1', '0'),
('3', 'bag_1', 'Bagian 1', 'Bagian Pertama', '0', '1', '1'),
('4', 'bag_2', 'Bagian 2', 'Bagian Kedua', '0', '1', '1'),
('5', 'bag_3', 'Bagian 3', 'Bagian Ketiga', '0', '1', '1');

DROP TABLE `baka_auth_permissions`;
CREATE TABLE `baka_auth_permissions` (
   `id` int(11) not null auto_increment,
   `name` varchar(100) not null,
   `description` varchar(255) not null,
   `status` tinyint(1) not null default '1',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=33;

INSERT INTO `baka_auth_permissions` (`id`, `name`, `description`, `status`) VALUES
('1', 'login', 'Login ke Aplikasi', '1'),
('2', 'setting_application', 'Mengelola Pengaturan Aplikasi', '1'),
('3', 'admin_application', 'Mengelola Administrasi Aplikasi', '1'),
('4', 'backstore_application', 'Mengelola Backup dan Restore', '1'),
('5', 'debug_application', 'Debuging Application', '1'),
('6', 'manage_users', 'Mengelola Pengguna', '1'),
('7', 'create_users', 'Membuat Pengguna', '1'),
('8', 'view_users', 'Melihat Pengguna', '1'),
('9', 'update_users', 'Memperbarui Pengguna', '1'),
('10', 'delete_users', 'Menghapus Pengguna', '1'),
('11', 'manage_groups', 'Mengelola Kelompok Pengguna', '1'),
('12', 'create_groups', 'Membuat Kelompok Pengguna', '1'),
('13', 'view_groups', 'Melihat Kelompok Pengguna', '1'),
('14', 'update_groups', 'Memperbarui Kelompok Pengguna', '1'),
('15', 'delete_groups', 'Menghapus Kelompok Pengguna', '1'),
('16', 'manage_data', 'Mengelola Data', '1'),
('17', 'create_data', 'Membuat Data', '1'),
('18', 'view_data', 'Melihat Data', '1'),
('19', 'update_data', 'Memperbarui Data', '1'),
('20', 'delete_data', 'Menghapus Data', '1'),
('21', 'review_data', 'Memeriksa Data', '1'),
('22', 'manage_data_siup', 'Mengelola Dokumen ijin Usaha Perdagangan', '1'),
('23', 'manage_data_tdp', 'Mengelola Dokumen ijin TDP', '1'),
('24', 'manage_data_wisata', 'Mengelola Dokumen ijin Pariwisata', '1'),
('25', 'manage_data_imb', 'Mengelola Dokumen ijin Mendirikan bangunan', '1'),
('26', 'manage_data_lokasi', 'Mengelola Dokumen ijin Lokasi', '1'),
('27', 'manage_data_reklame', 'Mengelola Dokumen ijin Reklame', '1'),
('28', 'manage_data_b3', 'Mengelola Dokumen ijin B3', '1'),
('29', 'manage_data_ho', 'Mengelola Dokumen ijin Ganggunan', '1'),
('30', 'manage_data_iplc', 'Mengelola Dokumen ijin Pembuangan Limbah', '1'),
('31', 'manage_data_iui', 'Mengelola Dokumen ijin Usaha Industri', '1'),
('32', 'manage_data_iup', 'Mengelola Dokumen ijin Usaha Pertambangan', '1');

DROP TABLE `baka_auth_usergroups`;
CREATE TABLE `baka_auth_usergroups` (
   `user_id` int(11) unsigned not null,
   `group_id` int(11) unsigned not null,
   KEY `user_id` (`user_id`),
   KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `baka_auth_usergroups` (`user_id`, `group_id`) VALUES
('1', '1'),
('2', '2'),
('2', '3'),
('3', '2'),
('3', '4'),
('4', '2'),
('4', '5');

DROP TABLE `baka_system_settings`;
CREATE TABLE `baka_system_settings` (
   `id` int(11) not null auto_increment,
   `key` varchar(100) not null,
   `value` longtext not null,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=57;

INSERT INTO `baka_system_settings` (`id`, `key`, `value`) VALUES
('1', 'app_data_show_limit', '10'),
('2', 'app_date_format', '%j %F %Y'),
('3', 'app_datetime_format', '%j %F %Y, %H:%i:%s'),
('4', 'auth_username_length_min', '4'),
('5', 'auth_username_length_max', '20'),
('6', 'auth_password_length_min', '4'),
('7', 'auth_password_length_max', '20'),
('8', 'auth_allow_registration', '1'),
('9', 'auth_captcha_registration', '1'),
('10', 'auth_email_activation', '0'),
('11', 'auth_email_act_expire', '172800'),
('12', 'auth_use_username', '1'),
('13', 'auth_login_by', 'login'),
('14', 'auth_login_by_username', '1'),
('15', 'auth_login_by_email', '1'),
('16', 'auth_login_record_ip', '1'),
('17', 'auth_login_count_attempts', '1'),
('18', 'auth_login_max_attempts', '5'),
('19', 'auth_login_attempt_expire', '259200'),
('20', 'auth_use_recaptcha', '0'),
('21', 'auth_recaptcha_public_key', ''),
('22', 'auth_recaptcha_private_key', ''),
('23', 'auth_username_blacklist', 'admin, administrator, mod, moderator, root'),
('24', 'auth_username_blacklist_prepend', 'the, sys, system, site, super'),
('25', 'auth_username_exceptions', ''),
('26', 'email_protocol', '0'),
('27', 'email_mailpath', ''),
('28', 'email_smtp_host', ''),
('29', 'email_smtp_user', ''),
('30', 'email_smtp_pass', ''),
('31', 'email_smtp_port', ''),
('32', 'email_smtp_timeout', '30'),
('33', 'email_wordwrap', '0'),
('34', 'email_mailtype', '0'),
('35', 'email_priority', '2'),
('36', 'skpd_name', 'Badan Penanaman Modal dan Pelayanan Perizinan Terpadu'),
('37', 'skpd_address', 'Jalan Sindoro No. 9 Kajen'),
('38', 'skpd_kab', 'Kajen'),
('39', 'skpd_city', 'Kabupaten Pekalongan'),
('40', 'skpd_prov', 'Jawa Tengah'),
('41', 'skpd_telp', '(0285) 381992'),
('42', 'skpd_fax', '(0285) 381992'),
('43', 'skpd_pos', '51161'),
('44', 'skpd_web', 'http://bpmppt.kab-pekalongan.go.id'),
('45', 'skpd_email', 'bpmppt.kab.pekalongan@gmail.com'),
('46', 'skpd_logo', 'asset/img/logo.png'),
('47', 'skpd_lead_name', 'M. JANU HARYANTO,SH.MH'),
('48', 'skpd_lead_nip', '19570126 198007 1 001'),
('49', 'skpd_lead_jabatan', 'Pembina Tingkat I'),
('50', 'welcome_title', 'Selamat Datang di BPMPPT App'),
('51', 'welcome_login', '<p>Aplikasi &copy; Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</p>\n<p>Silahkan login untuk dapat menggunakan aplikasi ini.</p>'),
('52', 'welcome_register', '<p>Aplikasi &copy; Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</p>\n<p>Silahkan login untuk dapat menggunakan aplikasi ini.</p>'),
('53', 'welcome_forgot', '<p>Aplikasi &copy; Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</p>\n<p>Silahkan login untuk dapat menggunakan aplikasi ini.</p>'),
('54', 'welcome_resend', '<p>Aplikasi &copy; Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</p>\n<p>Silahkan login untuk dapat menggunakan aplikasi ini.</p>'),
('55', 'b3_teknis', '<p>Izin Penyimpanan Sementara Limbah Bahan Berbahaya dan Beracun (B3) harus memenuhi persyaratan sebagai berikut :</p>\n<ol class=\"decimal\">\n<li>Jenis Limbah Bahan Berbahaya dan Beracun yang Disimpan <ol class=\"lower-alpha\">\n<li>Penanggungjawab Kegiatan tidak diperkenankan menyimpan dan menerima limbah bahan berbahaya dan beracun dari pihak atau sumber lain, hanya menyimpan fly ash batubara, bottom ash batubara, kertas saring bekas, kemasan bekas (drum, jerigen bekas obat), aki bekas, kain majun terkontaminasi oli, jarum suntik bekas, kain kassa bekas, sarung tangan bekas, minyak pelumas bekas/oli bekas, slude IPAL yang berasal dari kegiatannya.</li>\n<li>Jika menyimpan jenis limbah bahan berbahaya dan beracun di luar fly ash batubara, bottom ash batubara, kertas saring bekas, kemasan bekas (drum, jerigen bekas obat), aki bekas, kain majun terkontaminasi oli, jarum suntik bekas, kain kassa bekas, sarung tangan bekas, minyak pelumas bekas/oli bekas, sludge IPAL, maka Penanggungjawab Kegiatan wajib melaporkan atau konsultasi ke Bupati Pekalongan cq. Kantor Lingkungan Hidup Kabupaten Pekalongan;</li>\n<li>Simbol dan label disesuaikan dengan jenis dan karakteristik limbah bahan berbahaya dan beracun.</li>\n</ol>\n</li>\n<li>Bangunan Penyimpanan <ol class=\"lower-alpha\">\n<li>Rancang bangun dan luas penyimpanan sesuai dengan jenis, jumlah dan karakteristik limbah bahan berbahaya dan beracun yang dimiliki : <ol>\n<li>Tempat Penyimpanan Sementara (TPS) : <ol>\n<li>... berukuran : ..., terletak di titik koordinat S : ... dan E : ...\n</li>\n</ol>\n</li>\n<li>Lay out tempat penyimpanan seperti pada lampiran I;</li>\n<li>Desain tempat penyimpanan seperti pada lampiran II.</li>\n</ol>\n</li>\n<li>Kondisi tempat penyimpanan tersebut dibutir 2).a) di atas tidak dapat diubah ataupun dipindah tanpa seizin Bupati Pekalongan Cq. Kantor Lingkungan Hidup Kabupaten Pekalongan;</li>\n<li>Tidak diperkenankan menyimpan sementara limbah bahan berbahaya dan beracun di tempat lain selain tempat penyimpanan sebagaimana butir 2).a);</li>\n<li>Butir 2).a) diatas harus mengacu pada Keputusan Kepala Bapedal Nomor : Kep-01/Bapedal/09/1995 tentang Tata Cara dan Persyaratan Teknis Penyimpanan dan Pengumpulan Limbah Bahan Berbahaya dan Beracun dalam Lampiran 3.2 dan Peraturan Menteri Negara Lingkungan Hidup Nomor 30 Tahun 2009 tentang Tata Laksana Perizinan dan Pengawasan Pengelolaan Limbah Bahan Berbahaya dan Beracun serta Pengawasan Pemulihan akibat Pencemaran Limbah Bahan Berbahaya dan Beracun Lampiran II poin II.C.</li>\n</ol>\n</li>\n<li>Keselamatan dan Kesehatan Kerja (K3) <p>Peralatan keselamatan dan kesehatan kerja yang umum (standar) harus dimiliki oleh penanggungjawab kegiatan, termasuk antara lain alarm, peralatan pemadam kebakaran, shower / eye wash dan fasilitas tanggap darurat.</p>\n</li>\n</ol>'),
('56', 'iplc_teknis', '<ol class=\"lower-alpha\">\n<li><p>Ketentuan Teknis</p>\n<p>Pembuangan air limbah pabrik Pengolahan Karet Mentah dengan kapasitas produksi [limbah_kapasitas_produksi] Ton/hari harus memenuhi persyaratan :</p>\n<ol class=\"decimal\">\n<li><p>Debit maksimum air limbah yang dibuang [limbah_debit_max_proses] m3/hari (Proses pengolahan getah karet menjadi karet kering) harus memenuhi persyaratan baku mutu air limbah sesuai dengan Peraturan Daerah Provinsi Jawa Tengah Nomor 5 Tahun 2012. Dengan kualitas air limbah, yaitu konsentrasi dan beban pencemaran maksimum sebagai berikut :</p>\n{% echo iplc_debits($debits) %}\n</li>\n<li>Pembuangan air limbah dimaksud dibuang ke Sungai Kawung Dukuh Blimbing Desa Pedawang Kecamatan Karanganyar Kabupaten Pekalongan.</li>\n<li>Melakukan pemantauan dan pencatatan harian debit air limbah yang dibuang ke air atau sumber air.</li>\n<li>Tidak menggabungkan saluran pembuangan air limbah dengan saluran drainase atau saluran lainnya.</li>\n<li>Melakukan pemantauan pada titik-titik pantau di inlet dan outlet Instalasi Pengolahan Air Limbah (IPAL) setiap satu bulan sekali dan pemantauan air / badan air penerima sebelum dan sesudah bercampur air limbah setiap 6 (enam) bulan sekali dengan biaya ditanggung perusahaan.</li>\n<li>Tidak melakukan pengenceran air limbah dan apabila air limbah tersebut akan dimanfaatkan untuk kegiatan lain harus dilakukan penelitian terlebih dahulu sesuai dengan ketentuan yang berlaku.</li>\n</ol>\n</li>\n<li><p>Kewajiban Pihak Perusahaan</p>\n<ol>\n<li>Melaporkan hasil pemantauan analisa air limbah di inlet dan outlet IPAL setiap 1 (satu) bulan sekali dan hasil analisa kualitas air di badan air penerima sebelum dan sesudah bercampur air limbah setiap 6 (enam) bulan sekali kepada Bupati Pekalongan Cq. Kepala Kantor Lingkungan Hidup Kabupaten Pekalongan.</li>\n<li>Mendaftarkan ulang perpanjangan izin secara tertulis kepada Bupati Pekalongan Cq. Kepala Kantor Lingkungan Hidup Kabupaten Pekalongan selambat-lambatnya 3 (tiga) bulan sebelum masa berlakunya Izin Pembuangan Air Limbah berakhir.</li>\n<li>Melaksanakan dan memenuhi semua ketentuan yang ditetapkan oleh Pemerintah Pusat maupun Pemerintah Daerah dalam kaitannya dengan Pembuangan Air Limbah</li>\n</ol>\n</li>\n</ol>');
