<tr><td colspan="5" style="width:100%">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="5" style="width:100%">
        <p>KEPUTUSAN KEPALA BADAN PENANAMAN MODAL DAN PELAYANAN PERIZINAN TERPADU<br>KABUPATEN PEKALONGAN<br>NOMOR : <?php echo $surat_nomor?>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/<?php echo strtoupper(format_roman(bdate('m', $created_on)).'/'.bdate('Y')) ?></p>
    </td>
</tr>
<tr><td colspan="5" style="width:100%">&nbsp;</td></tr>
<tr>
    <td style="width:10%"><p>Dasar :</p></td>
    <td colspan="4" style="width:90%">
        <ol class="lower-alpha">
            <li>Peraturan Daerah Kabupaten Pekalongan no 1 Tahun 2012 tentang Retribusi Daerah</li>
            <li>Peraturan Bupati Pekalongan No. 12 Tahun 2012 tentang Pendelegasian Kewenangan Penandatanganan Perizinan dan Non Perizinan Kepada Kepala Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</li>
            <li>Surat permohonan izin pemasangan reklame dari Sdr. <?php echo $pemohon_nama?> tanggal permohonan <?php echo $surat_tanggal?> tentang Permohonan Izin Reklame <b><?php echo $reklame_jenis ?></b>.</li>
        </ol>
    </td>
</tr>
<tr><td colspan="5" style="width:100%">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="5">M E N G I Z I N  K A N</td>
</tr>
<tr><td colspan="5" style="width:100%">&nbsp;</td></tr>
<tr>
    <td colspan="5" style="width:100%"><p>Kepada :</p></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">
        <ol>
            <li>Nama</li>
            <li>Alamat</li>
            <li>Tempat/Lok. Pemasangan</li>
            <li>Tema Pemasangan</li>
            <li>Ukuran</li>
            <li>Jumlah</li>
            <li>Jangka Waktu Pemasangan</li>
        </ol>
    </td>
    <td style="width:2%">
        <ol class="none">
            <li>:</li>
            <li>:</li>
            <li>:</li>
            <li>:</li>
            <li>:</li>
            <li>:</li>
            <li>:</li>
        </ol>
    </td>
    <td colspan="3" style="width:68%">
        <ol class="none">
            <li><?php echo $pemohon_nama ?></li>
            <li><?php echo $pemohon_alamat ?></li>
            <li><?php echo $reklame_lokasi ?></li>
            <li><?php echo $reklame_tema ?></li>
            <li><?php echo $reklame_ukuran_panjang.' m x '.$reklame_ukuran_lebar.' m' ?></li>
            <li><?php echo $reklame_juml.' Unit' ?></li>
            <li><?php echo '1 (satu) Bulan '.$reklame_range_tgl_mulai.' '.$reklame_range_tgl_selesai ?></li>
        </ol>
    </td>
</tr>
<tr><td colspan="5" style="width:100%">&nbsp;</td></tr>
<tr>
    <td colspan="5" style="width:100%"><p>Dengan Ketentuan :</p></td>
</tr>
<tr>
    <td colspan="5" style="width:100%">
        <ol>
            <li>Menaati Peraturan Daerah Kabupaten Peklaongan No. 1 Tahun 2012 tentang Retribusi Daerah</li>
            <li>Membayar pajak reklame di Dinas Pendapatan dan pengelolaan Keuangan Daerah Kabupaten Pekalongan</li>
            <li>Pemasangan papan reklame harus dikoordinasikan dengan Dinas Pekerjaan Umum (DPU) Kabupaten Peklaongan/Balai Pelaksana Teknis Bina Marga Wilayah Kabupaten Pekalongan agar tidak mengganggu lalulintas umum, khususnya untuk reklame spanduk tidak boleh melintang di jalan.</li>
            <li>Di dalam pelaksanaannya wajib menjaga kebersihan, keamanan, ketertiban, keindahan, kesopanan, dan kesusilaan sesuai dengan kepribadian Bangsa Indonesia.</li>
            <li>Pemegang izin apabila memperpanjang/memperbaharui masa berlaku izinnya harus mengajukan permohonan selambat-lambatnya 1 (satu) bulan sebelum masa izin berakhir</li>
            <li>Apabila masa berlaku izin sudah habis dan tidak diperbaharui, maka reklame tersebut harus dibongkar dengan biaya ditanggung oleh pemegang izin.</li>
            <li>Apabila dalam waktu 12 (lima belas) hari setelah masa berlaku izin berakhir, pemohon tidak melakukan pemboingkaran, maka Pemerintah Daerah akan melakukan pembongkaran terhadap papan reklame tersebut.</li>
            <li>Apabila terdapat kekeliruan/kesalahan maka diadakan perubahan sebagaimana mestinya atau dapat dicabut</li>
            <li>Jeputusan ini mulai berlaku pada tanggal ditetapkan.</li>
        </ol>
    </td>
</tr>
<tr><td colspan="5" style="width:100%">&nbsp;</td></tr>
<tr>
    <td colspan="4" style="width:60%">&nbsp;</td>
    <td colspan="1" style="width:40%">
        <p>Ditetapkan di : Kajen</p>
        <p class="underline">Pada Tanggal :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo bdate('F', $created_on).' '.bdate('Y') ?></p>
    </td>
</tr>
<tr><td colspan="5" style="width:100%">&nbsp;</td></tr>
<tr class="align-center bold">
    <td colspan="3" style="width:60%">&nbsp;</td>
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
<tr><td colspan="5" style="width:100%">&nbsp;</td></tr>
<tr>
    <td colspan="5" style="width:100%"><p>Tembusan :</p></td>
</tr>
<tr>
    <td colspan="5" style="width:100%">
        <ol>
            <li>Inspektur Kabupaten Pekalongan</li>
            <li>Ka. DPU Kabupaten Pekalongan</li>
            <li>Ka. DPPKD Kabupaten Pekalongan</li>
            <li>Ka Dinhub Kominfo Kabupaten Pekalongan</li>
            <li>Ka. Satpol PP Kabupaten Pekalongan</li>
            <li>Ka. Bag. Hukum Setda Kabupaten Pekalongan</li>
            <li>Camat Kajen dan Wonopringgo Kabupaten Pekalongan</li>
        </ol>
    </td>
</tr>