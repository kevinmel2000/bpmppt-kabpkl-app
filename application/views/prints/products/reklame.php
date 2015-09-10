<?php $reklame_data = bi_flip_array(unserialize($reklame_data)) ?>
<table>
    <tbody>
        <tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr class="align-center">
    <td colspan="5" style="width:100%">
<p><span style="font-family: 'Times New Roman'; font-size: 12px; background-color: transparent;">IZIN MENYELENGGARAAN REKLAME</span></p><p><span style="font-family: 'Times New Roman'; font-size: 12px; background-color: transparent;">NOMOR : <?php echo '510.8 / '.$surat_nomor.' / BPM PPT / Rekl'.($pengajuan_jenis == 'Perpanjangan' ? '.P' : '').' / '.print_blnthn_head($surat_tanggal) ?></span></p>
    </td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr>
    <td style="width:10%"><p><span style="font-family: 'Times New Roman'; font-size: 12px;">Dasar :</span></p></td>
    <td colspan="4" style="width:90%" class="align-justify">
        <ol class="lower-alpha">
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Peraturan Bupati Pekalongan No. 12 Tahun 2012 tentang Pendelegasian Kewenangan Penandatanganan Perizinan dan Non Perizinan Kepada Kepala Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</span></li>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Surat permohonan izin pemasangan reklame dari Sdr. <?php echo $pemohon_nama?> tanggal permohonan <?php echo format_date($surat_tanggal) ?> tentang Permohonan <?php echo ($pengajuan_jenis == 'Pendaftaran Baru' ? 'baru' : 'Perpanjangan ') ?> Izin Reklame <b><?php echo parse_reklamedata($reklame_data) ?></b>.</span></li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr class="align-center">
    <td colspan="5"><span style="font-family: 'Times New Roman'; font-size: 12px;">M E N G I Z I N  K A N</span></td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="5" style="width:100%"><p><span style="font-family: 'Times New Roman'; font-size: 12px;">Kepada :</span></p></td>
</tr>
<tr>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;">1. Nama</span></td>
    <td style="width:2%"><span style="font-family: 'Times New Roman'; font-size: 12px;">:</span></td>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php echo strtoupper($pemohon_nama.( $pemohon_usaha ? ' ('.$pemohon_usaha.')' : '')) ?></span></td>
</tr>
<tr>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;">2. Alamat</span></td>
    <td style="width:2%"><span style="font-family: 'Times New Roman'; font-size: 12px;">:</span></td>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php echo $pemohon_alamat ?></span></td>
</tr><tr>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;">3. Tempat/Lok. Pemasangan</span></td>
    <td style="width:2%"><span style="font-family: 'Times New Roman'; font-size: 12px;">:</span></td>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php echo (count($reklame_data) == 1 ? $reklame_data[0]['tempat'] : 'Terlampir') ?></span></td>
</tr>
<tr>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;">4. Tema Pemasangan</span></td>
    <td style="width:2%"><span style="font-family: 'Times New Roman'; font-size: 12px;">:</span></td>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php echo (count($reklame_data) == 1 ? $reklame_data[0]['tema'] : 'Terlampir') ?></span></td>
</tr>
<tr>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;">5. Ukuran</span></td>
    <td style="width:2%"><span style="font-family: 'Times New Roman'; font-size: 12px;">:</span></td>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php echo (count($reklame_data) == 1 ? $reklame_data[0]['panjang'].' m x '.$reklame_data[0]['lebar'].' m'.(isset($reklame_data[0]['2x']) && $reklame_data[0]['2x'] == 1 ? ' (Dua muka)' : '' ) : 'Terlampir') ?></span></td>
</tr>
<tr>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;">6. Jumlah</span></td>
    <td style="width:2%"><span style="font-family: 'Times New Roman'; font-size: 12px;">:</span></td>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php echo $reklame_juml_val.' '.$reklame_juml_unit ?></span></td>
</tr>
<tr>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;">7. Jangka Waktu Pemasangan</span></td>
    <td style="width:2%"><span style="font-family: 'Times New Roman'; font-size: 12px;">:</span></td>
    <td colspan="2" style="width:30%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php echo $reklame_range_tgl_text.' ( '.format_date($reklame_range_tgl_mulai).' s/d '.format_date($reklame_range_tgl_selesai).' )' ?></span></td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="5" style="width:100%"><p><span style="font-family: 'Times New Roman'; font-size: 12px;">Dengan Ketentuan :</span></p></td>
</tr>
<tr>
    <td colspan="5" style="width:100%" class="align-justify">
        <ol>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Membayar pajak reklame di Dinas Pendapatan dan pengelolaan Keuangan Daerah Kabupaten Pekalongan;</span></li>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Pemasangan papan reklame harus dikoordinasikan dengan Dinas Pekerjaan Umum (DPU) Kabupaten Peklaongan/Balai Pelaksana Teknis Bina Marga Wilayah Kabupaten Pekalongan agar tidak mengganggu lalulintas umum, khususnya untuk reklame spanduk tidak boleh melintang di jalan;</span></li>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Di dalam pelaksanaannya wajib menjaga kebersihan, keamanan, ketertiban, keindahan, kesopanan, dan kesusilaan sesuai dengan kepribadian Bangsa Indonesia.</span></li>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Pemegang izin apabila memperpanjang/memperbaharui masa berlaku izinnya harus mengajukan permohonan selambat-lambatnya 1 (satu) bulan sebelum masa izin berakhir;</span></li>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Apabila masa berlaku izin sudah habis dan tidak diperbaharui, maka reklame tersebut harus dibongkar dengan biaya ditanggung oleh pemegang izin;</span></li>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Apabila dalam waktu 15 (lima belas) hari setelah masa berlaku izin berakhir, pemohon tidak melakukan pemboingkaran, maka Pemerintah Daerah akan melakukan pembongkaran terhadap papan reklame tersebut.</span></li><li><span style="font-family: 'Times New Roman'; font-size: 12px;">Apabila Reklame Konstruksi yang diizinkan, paling lambat 2 bulan dari tanggal dikeluarkannya izin, reklame konstruksi tersebut belum berdiri, maka izin penyelenggaraan reklame tersebut dinyatakan tidak berlaku lagi/dibatalkan;</span></li>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Apabila terdapat kekeliruan/kesalahan maka diadakan perubahan sebagaimana mestinya atau dapat dicabut;</span></li>
            <li><span style="font-family: 'Times New Roman'; font-size: 12px;">Keputusan ini mulai berlaku pada tanggal ditetapkan.</span></li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="4" style="width:55%"></td>
    <td style="width:45%">
        <p><span style="font-family: 'Times New Roman'; font-size: 12px;">Ditetapkan di <?php echo $skpd_kab ?></span></p>
        <p><span style="font-family: 'Times New Roman'; font-size: 12px;">Pada Tanggal <?php print_blnthn_foot($surat_tanggal) ?></span></p>
    </td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr class="align-center">
    <td colspan="4" style="width:55%"></td>
    <td style="width:45%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php print_ttd_kadin() ?></span></td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr><td colspan="5" style="width:100%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php print_tembusan($data_tembusan) ?></span></td></tr>
</tbody></table><span style="font-family: 'Times New Roman'; font-size: 12px;">
<?php if (count($reklame_data) > 1): ?>

    <?php echo print_table_reklame($reklame_data) ?>
    </span><table class="pagebreak">
    <tbody><tr><td colspan="5"><span style="font-family: 'Times New Roman'; font-size: 12px;">LAMPIRAN IZIN REKLAME <?php echo strtoupper($pemohon_usaha ?: $pemohon_nama) ?>.</span></td></tr>
    <tr><td class="empty" colspan="5" style="width:100%"></td></tr><tr><td class="empty" colspan="5" style="width:100%"></td></tr>
    <tr><td class="empty" colspan="5" style="width:100%"></td></tr>
    <tr class="align-center">
        <td colspan="3" style="width:55%"></td>
        <td colspan="2" style="width:45%"><p><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php echo $skpd_kab ?>,<?php print_blnthn_foot($surat_tanggal) ?></span></p></td>
    </tr>
    <tr><td class="empty" colspan="5" style="width:100%"></td></tr>
    <tr class="align-center">
        <td colspan="3" style="width:55%"></td>
        <td colspan="2" style="width:45%"><span style="font-family: 'Times New Roman'; font-size: 12px;"><?php print_ttd_kadin() ?></span></td>
    </tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
</tbody></table><span style="font-family: 'Times New Roman'; font-size: 12px;">
<?php endif; ?>
</span>
