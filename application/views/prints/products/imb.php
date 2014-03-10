<tr><td colspan="7" style="width:100%">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="7">KEPUTUSAN KEPALA BADAN PENANAMAN MODAL DAN PELAYANAN PERIZINAN TERPADU<br>KABUPATEN PEKALONGAN</td>
</tr>
<tr><td colspan="7">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="7" style="width:100%">NOMOR : 640/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper('/IMB/BPM PPT/'.format_roman(bdate('m', $created_on)).'/'.bdate('Y')) ?></td>
</tr>
<tr><td colspan="7">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="7">TENTANG</td>
</tr>
<tr><td colspan="7">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="7">IZIN MENDIRIKAN / MEREHAB / MEROBOHKAN BANGUNAN</td>
</tr>
<tr><td colspan="7">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="7">KEPALA <?php echo strtoupper($skpd_name) ?><br><?php echo strtoupper($skpd_city) ?></td>
</tr>
<tr><td colspan="7">&nbsp;</td></tr>
<tr>
    <td colspan="3" style="width:30%">&nbsp;</td>
    <td style="width:10%">
        <p>Membaca</p>
        <p>Menimbang</p>
        <p>Mengingat</p>
    </td>
    <td style="width:2%">
        <p>:</p>
        <p>:</p>
        <p>:</p>
    </td>
    <td colspan="2" style="width:47%">
        <p>dst ;</p>
        <p>dst ;</p>
        <p>dst ;</p>
    </td>
</tr>
<tr><td colspan="7" style="width:100%">&nbsp;</td></tr>
<tr>
    <td colspan="7" style="width:100%" class="align-center bold underline">M E M U T U S K A N :</td>
</tr>
<tr><td colspan="7" style="width:100%">&nbsp;</td></tr>
<tr>
    <td style="width:20%" class="bold">Menetapkan</td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%">&nbsp;</td>
</tr>
<tr>
    <td style="width:20%"><p>KESATU</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%">Memberikan Izin Kepada :</td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%">Nama Pemohon</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%" class="bold"><?php echo strtoupper($pemohon_nama) ?></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%"><p>Alamat Pemohon</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo $pemohon_alamat ?></strong></p></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%"><p>Pekerjaan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo $pemohon_kerja ?></p></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%"><p>Maksud Permohonan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo $bangunan_maksud ? 'Mendirikan bangunan baru' : 'Merehab bangunan' ?></p></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%"><p class="bold">Penggunaan Bangunan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p class="bold"><?php echo strtoupper($bangunan_guna) ?></p></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%"><p>Lokasi Bangunan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo $bangunan_lokasi ?></p></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%"><p>Luas / Keadaan Tanah</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo '&#177; '.$bangunan_tanah_luas.' M<sup>2</sup> / '.strtoupper($bangunan_tanah_keadaan) ?></p></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%"><p>Status Tanah</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo ($bangunan_tanah_status == 'hm' ? 'Hak Milik, No, '.$bangunan_milik_no : 'Hak Guna Bangunan').', an. '.$bangunan_milik_an ?></p></td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" style="width:30%"><p>Luas Bangunan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo '&#177; '.$bangunan_luas.' M<sup>2</sup>' ?></p></td>
</tr>
<tr><td colspan="7" style="width:100%">&nbsp;</td></tr>
<tr>
    <td style="width:20%"><p>KEDUA</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%">Ketentuan-ketentuan :</td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="5" style="width:78%">
        <ol>
            <li>Pelaksanaan pembangunan tidak boleh menyimpang dari lampiran yang   merupakan bagian tak terpisahkan dari keputusan ini.</li>
            <li>Pelaksanaan pembangunan sesuai dengan Perda No. 1 Tahun  2012  Tetang Retribusi Daerah.</li>
        </ol>
    </td>
</tr>
<tr><td colspan="7" style="width:100%">&nbsp;</td></tr>
<tr>
    <td style="width:20%"><p>KETIGA</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%">Hal –hal yang harus diperhatikan dan ditaati oleh penerima / pemegang Izin</td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="5" style="width:78%">
        <ol>
            <li>Pemegang Izin sebagaimana dimaksud diktum KESATU Keputusan ini wajib membayar Retribusi Izin Mendirikan Bangunan sebesar sebagaimana tercantum dalam Surat Ketetapan Retribusi Daerah ( SKRD ).</li>
            <li>Selama pelaksanaan pekerjaan / kegiatan fisik berlangsung sekali-kali tidak boleh menimbulkan kerugian pihak lain / tetangga / lingkungan.</li>
            <li>Penerima / pemegang Izin wajib melaksanakan segala usaha  pembangunan untuk terciptanya keselarasan dan kelestarian lingkungan.</li>
            <li>Tiap-tiap kali apabila pondasi, dinding dan kerangka atap bangunan akan / sedang dikerjakan,penerima / pemegang Izin ataupun pelaksana / pemborong pekerjaan wajib memberitahukan hal itu kepada pengawasan bangunan untuk diperiksa dan disetujui .</li>
            <li>Untuk pekerjaan beton / baja harus sesuai dengan Gambar Detail dan perhitungan yang telah diperiksa dan disetujui oleh Kepala Dinas Pekerjaan Umum.</li>
            <li>Guna menghindari terjadinya kecelakaan karena tersengat aliran listrik, maka bangunan yang didirikan dengan kawat jaringan listrik tegangan menengah harus mempunyai jarak tegangan minimal 3 meter.</li>
            <li>Sesuai dengan fungsi bangunan, penerima / pemegang izin / pemilik bangunan diwajibkan menyediakan fasilitas alat pencegahan kebakaran menurut ketentuan yang berlaku.</li>
            <li>Pembuatan, perubahan / penghilangan bagian-bagian bangunan / unsur-unsur penunjang lain seperti jalan jembatan maupun unsur penunjang lain, harus berdasarkan rencana konstruksi yang secara teknis telah diperiksa dan disetuji oleh Kepala Dinas Pekejaan Umum.</li>
            <li>Izin Mendirikan / Merubah / Merobohkan Bangunan ( IMB ) ini dapat dicabut apabila :
                <ol class="lower-alpha">
                    <li>Dalam waktu 6 ( enam ) bulan terhitung mulai tanggal Surat Keputusan Izin,  pelaksanaan / kegiatan fisik dimulai selama 6 ( enam ) bulan berturut-turut,kecuali permohonan untuk perpanjangan waktu yang bersangkutan dikabulkan.</li>
                    <li>Ternyata dalam permohonan Izin yang diajukan, terdapat keterangan yang tidak benar / palsu atau dipalsukan.</li>
                    <li>Pelaksanaan pembangunan ternyata menyimpang dari gambar rencana yang telah disahkan yang merupakan lampiran surat keputusan izin.</li>
                </ol>
            </li>
        </ol>
    </td>
</tr>
<tr><td colspan="7" style="width:100%">&nbsp;</td></tr>
<tr>
    <td style="width:20%"><p>KEEMPAT</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%">Mencatat bahwa :</td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="5" style="width:78%">
        <ol>
            <li>Izin ini tidak memberikan hak untuk pemakaian / penguasaan tanah.</li>
            <li>Retribusi IMB / biaya lain yang telah dibayarkan tidak dapat diminta kembali apabila :
                <ol class="lower-alpha">
                    <li>Setelah surat Izin ini diberikan ternyata tidak dipergunakan sebagaimana  penggunaan bangunan.</li>
                    <li>Karena suatu alasan yang sah, permohonan ini tidak dapat dikabulkan / dikabulkan sebagian.</li>
                </ol>
            </li>
            <li>Bagian-bagian bangunan / unsur-unsur penunjangannya yang tidak diizinkan seperti tercantum pada gambar rencana lampiran surat izin ini dengan tanda warna kuning, harus dihilangkan / dibonkar penerima / pemegang Izin sendiri.</li>
            <li>Apabila di kemudian hari ternyata terdapat kekeliruan dalam penetapannya akan dilakukan perbaikan / peninjauan kembali sebagaimana mestinya.</li>
        </ol>
    </td>
</tr>
<tr><td colspan="7" style="width:100%">&nbsp;</td></tr>
<tr>
    <td colspan="6" style="width:60%">&nbsp;</td>
    <td style="width:40%" class="bold ">
        <p>Ditetapkan di : Kajen</p>
        <p class="underline">Pada Tanggal :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo bdate('F', $created_on).' '.bdate('Y') ?></p>
    </td>
</tr>
<tr><td colspan="7" style="width:100%">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="5" style="width:60%">&nbsp;</td>
    <td colspan="2" style="width:40%">
        <p>An. BUPATI PEKALONGAN</p>
        <p>KEPALA <?php echo strtoupper($skpd_name) ?></p>
        <p><?php echo strtoupper($skpd_city) ?></p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p class="underline"><?php echo strtoupper($skpd_lead_name) ?></p>
        <p>Pembina Tingkat I</p>
        <p>NIP. <?php echo strtoupper($skpd_lead_nip) ?></p>
    </td>
</tr>
