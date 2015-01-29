<?php
$bangunan_area = unserialize($bangunan_area);
$bangunan_tanah = unserialize($bangunan_tanah);;
?>
<table>
    <tbody>
        <tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="7">KEPUTUSAN BUPATI PEKALONGAN</td>
</tr>
<tr><td colspan="7" class="empty"></td></tr>
<tr class="align-center bold">
    <td colspan="7" style="width:100%">NOMOR : <?php echo '640 /'.nbs(6).'/ IMB / BPMPPT / '.print_blnthn_head($surat_tanggal) ?></td>
</tr>
<tr><td colspan="7" class="empty"></td></tr>
<tr class="align-center bold">
    <td colspan="7">TENTANG</td>
</tr>
<tr><td colspan="7" class="empty"></td></tr>
<tr class="align-center bold">
    <td colspan="7">IZIN MENDIRIKAN/MEREHAB/MEROBOHKAN BANGUNAN<br><?php echo strtoupper($bangunan_area['guna'][0].' atas nama '.$pemohon_nama) ?> </td>
</tr>
<tr><td colspan="7" class="empty"></td></tr>
<tr class="align-center bold">
    <td colspan="7">KEPALA <?php echo strtoupper($skpd_name) ?><br><?php echo strtoupper($skpd_city) ?></td>
</tr>
<tr><td colspan="7" class="empty"></td></tr>
<tr>
    <td colspan="3" style="width:30%"></td>
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
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td colspan="7" style="width:100%" class="align-center bold underline">M E M U T U S K A N :</td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%" class="bold">Menetapkan</td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%"></td>
</tr>
<tr>
    <td style="width:20%"><p>KESATU</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%">Memberikan Izin Kepada :</td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="width:30%">Nama Pemohon</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%" class="bold"><?php echo strtoupper($pemohon_nama) ?></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="width:30%"><p>Alamat Pemohon</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo $pemohon_alamat ?></p></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="width:30%"><p>Maksud Permohonan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo $bangunan_maksud ? 'Mendirikan bangunan baru' : 'Merehab bangunan' ?></p></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="width:30%"><p class="bold">Penggunaan Bangunan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p class="bold"><?php echo bi_imploder($bangunan_area['guna']) ?></p></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="width:30%"><p>Lokasi Bangunan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo $bangunan_lokasi_kel.' '.$bangunan_lokasi_kec.'<br>'.'Kabupaten Pekalongan' ?></p></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="width:30%"><p>Luas / Keadaan Tanah</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo '± '.$bangunan_tanah['luas'][0].' M<sup>2</sup> / '.strtoupper($bangunan_tanah_keadaan) ?></p></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="width:30%"><p>Status Tanah</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo ($bangunan_tanah_status == 'hm' ? 'Hak Milik, No, '.$bangunan_tanah['no'][0] : 'Hak Guna Bangunan').', an. '.$bangunan_tanah['an'][0] ?></p></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="width:30%"><p>Luas Bangunan</p></td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:47%"><p><?php echo '± '.($bangunan_area['panjang'][0] * $bangunan_area['lebar'][0]).' M<sup>2</sup>' ?></p></td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>KEDUA</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%">Ketentuan-ketentuan :</td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="5" style="width:78%" class="align-justify">
        <ol>
            <li>Pelaksanaan pembangunan tidak boleh menyimpang dari lampiran yang   merupakan bagian tak terpisahkan dari keputusan ini.</li>
            <li>Pelaksanaan pembangunan sesuai dengan Perda No. 1 Tahun  2012  Tetang Retribusi Daerah.</li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>KETIGA</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify">Hal –hal yang harus diperhatikan dan ditaati oleh penerima / pemegang Izin</td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="5" style="width:78%" class="align-justify">
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
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td style="width:20%"><p>KEEMPAT</p></td>
    <td style="width:2%">:</td>
    <td colspan="5" style="width:78%" class="align-justify">Mencatat bahwa :</td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="5" style="width:78%" class="align-justify">
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
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr>
    <td colspan="6" style="width:60%"></td>
    <td style="width:40%" class="bold ">
        <p>Ditetapkan di : <?php echo $skpd_kab ?></p>
        <p class="underline">Pada Tanggal : <?php echo nbs(6).bdate('%F', $created_on).' '.bdate('%Y') ?></p>
    </td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="5" style="width:60%"></td>
    <td colspan="2" style="width:40%"><?php print_ttd_kadin() ?></td>
</tr>
    </tbody>
</table>
<table class="pagebreak bordered" style="font-size: 9px; border: 1px solid #000">
<tr class="align-center">
    <td colspan="4" style="width:35%"><?php echo '<span class="bold">pemerintah '.strtoupper($skpd_city).'</span><br>'.word_wrap('KEPALA '.strtoupper($skpd_name), 32).'<br>'.$skpd_address.' Telp. '.$skpd_telp.' '.$skpd_kab ?></td>
    <td colspan="3" style="width:50%">SURAT KETETAPAN RETRIBUSI DAERAH<br><br><br>(SKRD)<br>Tahun <?php echo bdate('%Y', $created_on) ?></td>
    <td style="width:15%">NO URUT :</td>
</tr>
<tr class="align-center unbordered">
    <td colspan="6" style="width:70%"></td>
    <td colspan="2" style="width:30%">Masa<br>Tahun</td>
</tr>
<tr class="unbordered">
    <td style="width:5%"></td>
    <td style="width:25%">Dasar<span class="rfloat">1.</span></td>
    <td style="width:70%" colspan="6">Peraturan Daerah Kabupaten Pekalongan Nomor 1 Tahun 2012 tentang Retribusi Daerah BAB V Retribusi Perizinan Tertentu.</td>
</tr>
<tr class="unbordered"><td class="empty" colspan="8"></td></tr>
<tr class="unbordered">
    <td colspan="2" style="width:30%">Nama</td>
    <td colspan="6" style="width:70%"><span style="float: left;">:</span><span style="margin-left: 10px;"><?php echo $pemohon_nama ?></span></td>
</tr>
<tr class="unbordered">
    <td colspan="2" style="width:30%">Alamat</td>
    <td colspan="6" style="width:70%"><span style="float: left;">:</span><span style="margin-left: 10px;"><?php echo $pemohon_alamat ?></span></td>
</tr>
<tr class="unbordered">
    <td colspan="2" style="width:30%">Nomor Pokok Wajib Retribusi (NPWR)</td>
    <td colspan="6" style="width:70%"><span style="float: left;">:</span><span style="margin-left: 10px;"><?php echo $pemohon_nama ?></span></td>
</tr>
<tr class="unbordered">
    <td colspan="2" style="width:30%">Jenis IMB</td>
    <td colspan="6" style="width:70%"><span style="float: left;">:</span><span style="margin-left: 10px;"><?php echo $bangunan_maksud ?></span></td>
</tr>
<tr class="unbordered">
    <td colspan="2" style="width:30%">Lokasi Izin</td>
    <td colspan="6" style="width:70%"><span style="float: left;">:</span><span style="margin-left: 10px;"><?php echo $bangunan_lokasi_kel.' '.$bangunan_lokasi_kec ?></span></td>
</tr>
<tr class="unbordered">
    <td colspan="2" style="width:30%">Tanggal Jatuh Tempo</td>
    <td colspan="6" style="width:70%"><span style="float: left;">:</span><span style="margin-left: 10px;"><?php echo $pemohon_nama ?></span></td>
</tr>
<tr class="unbordered"><td class="empty" colspan="8"></td></tr>
<tr class="align-center">
    <td style="whidth:5%">No</td>
    <td>Kode Rekening</td>
    <td colspan="5">URAIAN RETRIBUSI DAERAH</td>
    <td rowspan="2">Jumlah<br>Rp</td>
</tr>
<tr class="align-center">
    <td style="whidth:5%">1.</td>
    <td>10301.1.2.03.01.03</td>
    <td colspan="5">Retribusi Izin Mendirikan Bangunan (IMB)</td>
</tr>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" colspan="5" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" colspan="5" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<?php $bangunan_area = bi_flip_array($bangunan_area); foreach ($bangunan_area as $area): ?>
<tr class="unbordered">
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td style="width:20%" colspan="3">Luas Bang. <?php echo $area['guna'] ?></td>
    <td style="width:35%">: <?php echo $area['panjang'].' &times; '.$area['lebar'] ?></td>
    <td>= <?php echo $area['luas'] ?> m<sup>2</sup></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<?php endforeach ?>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" colspan="5" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<?php $bangunan_koefisien = bi_flip_array(unserialize($bangunan_koefisien)) ?>
<?php foreach ($bangunan_koefisien as $i => $koef): ?>
<tr class="unbordered">
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td style="width:20%" colspan="3">Koefisien <?php echo $bangunan_area[$i]['guna'] ?></td>
    <td style="width:35%">: <?php echo $koef['bwk'].' &times; '.$koef['luas'].' &times; '.$koef['tinggi'].' &times; '.$koef['guna'].' &times; '.$koef['letak'].' &times; '.$koef['kons'] ?></td>
    <td>= <?php echo $koef['koef'] ?></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<?php endforeach ?>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" colspan="5" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<tr class="unbordered">
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td style="width:60%" colspan="5">Formulir</td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<?php $bangunan_hasil = unserialize($bangunan_hasil); $tot = 0; ?>
<?php foreach ($bangunan_area as $i => $area): ?>
<tr class="unbordered">
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td style="width:20%" colspan="3">Sempadan <?php echo $area['guna'] ?></td>
    <td style="width:35%">: 0,25 % &times; 1.000.000 &times; <?php echo $area['luas'].' &times; '.$bangunan_koefisien[$i]['koef'] ?></td>
    <td class="empty"></td>
    <td class="align-right" style="border: solid #000; border-width: 0 1px 0 1px"><?php $tot += $bangunan_hasil[$i]['sempendan']; echo format_number($bangunan_hasil[$i]['sempendan'], 0) ?></td>
</tr>
<tr class="unbordered">
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td style="width:20%" colspan="3">Pengawasan</td>
    <td style="width:35%">: 0,02 % &times; 1.000.000 &times; <?php echo $area['luas'].' &times; '.$bangunan_koefisien[$i]['koef'] ?></td>
    <td class="empty"></td>
    <td class="align-right" style="border: solid #000; border-width: 0 1px 0 1px"><?php $tot += $bangunan_hasil[$i]['pengawasan']; echo format_number($bangunan_hasil[$i]['pengawasan'], 0) ?></td>
</tr>
<tr class="unbordered">
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td style="width:20%" colspan="3">Koreksi</td>
    <td style="width:35%">: 0,01 % &times; 1.000.000 &times; <?php echo $area['luas'].' &times; '.$bangunan_koefisien[$i]['koef'] ?></td>
    <td class="empty"></td>
    <td class="align-right" style="border: solid #000; border-width: 0 1px 0 1px"><?php $tot += $bangunan_hasil[$i]['koreksi']; echo format_number($bangunan_hasil[$i]['koreksi'], 0) ?></td>
</tr>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" colspan="5" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<?php endforeach ?>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" colspan="5" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" colspan="5" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
</tr>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="bordered" colspan="5">Jumlah Ketetapan Pokok Restribusi</td>
    <td class="bordered align-right"><?php echo format_number($tot, 0) ?></td>
</tr>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="bordered" colspan="5">Jumlah Sanksi</td>
    <td class="bordered align-right">-</td>
</tr>
<tr>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="empty" style="border: solid #000; border-width: 0 1px 0 1px"></td>
    <td class="bordered" colspan="5">Jumlah Keseluruhan</td>
    <td class="bordered align-right"><?php echo format_number($tot, 0) ?></td>
</tr>
<tr>
    <td colspan="8">
        <p>Dengan Huruf :</p>
        <p>PERHATIAN :</p>
        <ol>
            <li>Pembayaran harap dilakukan melalui bendaharawan khusus BPMPPT</li>
            <li>Apabila SKRD ini tidak atau kurang dibayar lewat waktu 30 hari setelah diterima atau<br>( tanggal jatuh tempo ) dikenakan sanksi administrasi berupa bunga sebesar 2 % perbulan</li>
        </ol>
    </td>
</tr>
<tr class="unbordered">
    <td colspan="5" style="width:60%"></td>
    <td colspan="3" class="align-center" style="width:40%;"><?php print_ttd_kadin() ?></td>
</tr>
</table>
