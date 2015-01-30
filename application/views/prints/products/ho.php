<?php if ($ho_lama_no) : ?>
<table style="position: absolute; top: 0; right: 0; min-width: 0; width: auto; float: right; font-size: 9px; line-height: 1.2em; border: 1px solid #000;">
    <tr>
        <td width="45%"><?php echo $surat_jenis_pengajuan ?> HO Nomor</td>
        <td width="10%">:</td>
        <td width="45%"><?php echo $ho_lama_no ?></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?php echo $ho_lama_tgl ?></td>
    </tr>
    <tr>
        <td>Izin Gangguan (HO)</td>
        <td>:</td>
        <td><?php echo $ho_lama_ho ?></td>
    </tr>
</table>
<?php endif; ?>
<table>
    <tbody>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td colspan="7" style="width:100% font-size: 14px;" class="align-center bold">KEPUTUSAN BUPATI PEKALONGAN</td>
</tr>
<tr>
    <td colspan="7" style="width:100%; font-size: 14px;" class="align-center bold">NOMOR : <?php echo '510.8 /'.nbs(8).'/ BPMPPT / '.$surat_kode.' / '.print_blnthn_head($surat_tanggal) ?></td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <!-- <td colspan="2" style="width:30%"></td> -->
    <td colspan="2" style="width:40%; font-size: 14px;">IZIN GANGGGUAN (HO) JENIS USAHA / KEGIATAN</td>
    <td style="width:2%">:</td>
    <td colspan="4" style="width:47%" class="bold"><?php echo '('.$usaha_jenis.') * ('.$usaha_nama.')' ?> *</td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <!-- <td colspan="2" style="width:30%"></td> -->
    <td colspan="2" style="width:40%"><p>ATAS NAMA</p></td>
    <td style="width:2%">:</td>
    <td colspan="4" style="width:47%" class="bold"><?php echo strtoupper($pemohon_nama) ?></td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td colspan="7" style="width:100%" class="align-center bold">BUPATI PEKALONGAN,</td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>Membaca</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify"><p>Surat Permohonan Saudara <strong><?php echo $pemohon_nama ?></strong> <?php echo (strtolower($pemohon_jabatan) == 'atas nama' ? 'atas nama <strong>'.$usaha_nama.'</strong>' : 'selaku '.$pemohon_jabatan)?>, Alamat di <strong><?php echo $pemohon_alamat ?></strong>, tanggal <?php echo format_date($pemohon_tanggal) ?> untuk Izin tempat usaha <?php echo $usaha_jenis ?>, yang terletak di <?php echo $usaha_alamat ?>.</p></td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>Menimbang</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify">
        <ol>
            <li>Bahwa permohonan tersebut telah diumumkan menurut cara-cara tersebut dalam pasal 5 Undang-undang Gangguan ( HO )</li>
            <li>Bahwa dalam satu bulan tidak diterima keberatan dari pemilik, pengusaha atau persil-persil yang berbatasan dengan persil tersebut.</li>
            <li>Bahwa tidak ada hal-hal yang mungkin menimbulkan bahaya kerugian atau gangguan atas tanah sekitarnya.</li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>Mengingat</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify">
        <ol>
            <li>Undang-undang Gangguan (HO) Stbl Tahun 1926 yang telah beberapa kali diubah dan terakhir ditambah dengan Ordinantie Stbl Tahun 1940 Nomor 450;</li>
            <li>Undang-undang Nomor 13 Tahun 1950 tentang Pembentukan Daerah-daerah  Kabupaten dalam lingkungan Propinsi Jawa Tengah;</li>
            <li>Undang-undang Nomor 9 tahun 1965 tentang Pembentukan Daerah Tingkat II Batang dengan mengubah Undang-undang Nomor 13 Tahun 1950 tentang Pembentukan Daerah-daerah Kabupaten dalam lingkungan Propinsi Jawa Tengah;</li>
            <li>Undang-Undang Nomor 32 Tahun 2004 tentang Pemerintahan Daerah sebagaimana telah diubah beberapa kali terakhir dengan Undang-undang Nomor 8 Tahun 2005 tentang Perubahan Kedua atas Undang- Undang Nomor 32 Tahun 2004 tentang Pemerintahan Daerah;</li>
            <li>Undang-undang Nomor 28 Tahun 2009 tentang Pajak Daerah dan Retribusi Daerah;</li>
            <li>Undang-Undang Nomor 32 Tahun 2009 tentang Perlindungan dan Pengelolaan Lingkungan Hidup;</li>
            <li>Peraturan Pemerintah Nomor 21 Tahun 1988 tentang Perubahan Batas Wilayah Kotamadya Daerah Tingkat II Pekalongan dan Kabupaten Daerah Tingkat II Batang;</li>
            <li>Peraturan Menteri Dalam Negeri Nomor 7 tahun 1993 tentang Izin Mendirikan Bangunan dan Izin Undang-undang Gangguan bagi Perusahaan Industri;</li>
            <li>Peraturan Daerah Kabupaten Pekalongan Nomor 2 tahun 2000 tentang Retribusi Izin Gangguan (HO);</li>
            <li>Peraturan Bupati Pekalongan Nomor : 12 Tahun 2012 tentang Pendelegasian Kewenangan Penandatanganan Perizinan dan Non Perizinan Kepada Kepala Badan Penanaman Modal dan Pelayanan Perizinan Terpadu Kabupaten Pekalongan;</li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td colspan="7" style="width:100%" class="align-center bold">M E M U T U S K A N :</td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>Menetapkan</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify"></td>
</tr>
<tr>
    <td style="width:20%"><p>KESATU</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify"><p>Memberi Izin Gangguan ( HO ) kepada Saudara <strong><?php echo $pemohon_nama ?></strong> <?php echo (strtolower($pemohon_jabatan) == 'atas nama' ? 'atas nama <strong>'.$usaha_nama.'</strong>' : 'selaku '.$pemohon_jabatan)?>, Alamat Kantor di <?php echo $pemohon_alamat ?>, untuk Izin tempat usaha <strong><?php echo $usaha_jenis ?></strong> yang terletak <?php echo $usaha_alamat ?> di atas tanah milik <?php echo $usaha_tanah_milik ?> di <?php echo $usaha_lokasi ?> dengan luas tempat usaha ± <?php echo $usaha_luas ?> M<sup>2</sup>.<br>Adapun persil tersebut berbatasan :</p></td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td colspan="2" style="width:22%"></td>
    <td class="empty" colspan="5">
        <table style="min-width: 0;">
            <tr>
                <td style="20%">Sebelah Utara</td>
                <td style="width:2%">:</td>
                <td colspan="3" style="78%"><?php echo $usaha_tetangga_utara ?></td>
            </tr>
            <tr>
                <td style="20%">Sebelah Timur</td>
                <td style="width:2%">:</td>
                <td colspan="3" style="78%"><?php echo $usaha_tetangga_timur ?></td>
            </tr>
            <tr>
                <td style="20%">Sebelah Selatan</td>
                <td style="width:2%">:</td>
                <td colspan="3" style="78%"><?php echo $usaha_tetangga_selatan ?></td>
            </tr>
            <tr>
                <td style="20%">Sebelah Barat</td>
                <td style="width:2%">:</td>
                <td colspan="3" style="78%"><?php echo $usaha_tetangga_barat ?></td>
            </tr>
        </table>
    </td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td colspan="2"></td>
    <td colspan="5" style="width:78%" class="align-justify">
        <p>Dengan ketentuan bahwa selambat-lambatnya dalam waktu 3 (tiga) bulan sesudah tanggal Keputusan ini, pendirian perusahaan yang dimaksudkan harus sudah selesai dikerjakan dan mulai dijalankan dengan syarat-syarat sebagai berikut :</p>
        <ol>
            <li>Perusahaan harus diatur sedemikian rupa sehingga tidak menganggu tetangga.</li>
            <li>Peredaran udara didalam ruangan harus cukup.</li>
            <li>Penempatan peralatan / mesin maupun bahan-bahan harus dijaga agar tidak menimbulkan gangguan pencemaran udara/debu uap/getaran maupun air limbah cair dilingkungan sekitarnya.</li>
            <li>Apabila proses kegiatan perusahaan menimbulkan gejolak negatif baik yang bersifat ekologis maupun sosiologis, maka pemohon yang tercantum dalam izin harus bersedia menyelesaikan dan sanggup menerima sanksi sesuai dengan peraturan yang berlaku.</li>
            <li>Harus menyediakan alat pemadam kebakaran yang memenuhi syarat.</li>
        </ol>
        <br>
        <p>UNTUK DIPERHATIKAN :</p>
        <ol>
            <li>Supaya disediakan kotak obat-obatan selengkap-lengkapnya untuk PPPK.</li>
            <li>Dimuka perusahaan ditempat yang mudah dibaca supaya dipasang sebuah papan nama perusahaan, tanggal dan nomor izin ini ditulis dalam huruf cetak (balok) nama perusahaan, yang berukuran paling kecil 5 (lima) Cm.</li>
            <li>Supaya melengkapi persyaratan / ketentuan–ketentuan izin lainnya yang berhubungan dengan perusahaan ini.</li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>KEDUA</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify">
        <p>Surat Keputusan ini berlaku sejak ditetapkan dengan ketentuan :</p>
        <ol class="lower-alpha">
            <li>Izin sewaktu-waktu dapat dicabut apabila dikemudian hari ternyata menurut situasi perkembangan perusahaan maupun lingkungan masyarakat ternyata izin tersebut sudah tidak memenuhi ketentuan lagi.</li>
            <li>Surat Keputusan ini berlaku selama perusahaan melakukan usahanya.</li>
            <li>Dalam rangka pengawasan dan pengendalian wajib melakukan daftar olang setiap 3 ( tiga ) tahun.</li>
            <li>Bahwa apabila persyaratan yang diwajibkan untuk perusahaan tersebut tidak dipenuhi, maka izin tersebut akan dicabut.</li>
            <li>Bahwa izin yang ditetapkan / dikeluarkan ini merupakan persyaratan pendirian suatu usaha/perusahaan yang harus dipenuhi sesuai dengan peraturan yang berlaku.</li>
            <li>Apabila ada perselisihan atau sengketa didalam perusahaan yang diberikan izin ini maka Pemerintah Daerah dapat menutup perusahaan tersebut dan akan dibuka kembali setelah masalahnya dapat diselesaikan dengan musyawarah.</li>
            <li>Bahwa segala sesuatu akan diadakan perubahan sebagaimana mestinya, apabila dikemudian hari ternyata terdapat kekeliruan dalam penetapan ini.</li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>KETIGA</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify">Keputusan ini mulai berlaku pada tanggal ditetapkan.</td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td colspan="6" style="width:60%"></td>
    <td style="width:40%">
        <p>Ditetapkan di <?php echo $skpd_kab ?></p>
        <p>Pada Tanggal <?php print_blnthn_foot($surat_tanggal) ?></p>
    </td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="5" style="width:60%"></td>
    <td colspan="2" style="width:40%"><?php print_ttd_kadin() ?></td>
</tr>
<tr><td colspan="7" style="width:100%"><?php print_tembusan($data_tembusan) ?></td></tr>
    </tbody>
</table>
