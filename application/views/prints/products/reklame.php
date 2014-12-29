<table>
    <tbody>
        <tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="5" style="width:100%">
        <p>SURAT IZIN BUPATI PEKALONGAN</p>
        <p>NOMOR : <?php echo '510.8 / '.$surat_nomor.' / BPM PPT / Rekl'.($pengajuan_jenis == 'Perpanjangan' ? '.P' : '').' / '.print_blnthn_head($surat_tanggal) ?></p>
        <p>IZIN PEMASANGAN REKLAME</p>
    </td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr>
    <td style="width:10%"><p>Dasar :</p></td>
    <td colspan="4" style="width:90%">
        <ol class="lower-alpha">
            <li>Peraturan Bupati Pekalongan No. 12 Tahun 2012 tentang Pendelegasian Kewenangan Penandatanganan Perizinan dan Non Perizinan Kepada Kepala Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</li>
            <li>Surat permohonan izin pemasangan reklame dari Sdr. <?php echo $pemohon_nama?> tanggal permohonan <?php echo format_date($surat_tanggal) ?> tentang Permohonan <?php echo ($pengajuan_jenis == 'Pendaftaran Baru' ? 'baru' : 'Perpanjangan ') ?> Izin Reklame <b><?php echo parse_reklamedata($reklame_data) ?></b>.</li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="5">M E N G I Z I N  K A N</td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="5" style="width:100%"><p>Kepada :</p></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">1. Nama</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo strtoupper($pemohon_nama.( $pemohon_usaha ? ' ('.$pemohon_usaha.')' : '')) ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">2. Alamat</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $pemohon_alamat ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">3. Tempat/Lok. Pemasangan</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo (count($reklame_data) == 1 ? $reklame_data[0]['tempat'] : 'Terlampir') ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">4. Tema Pemasangan</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo (count($reklame_data) == 1 ? $reklame_data[0]['tema'] : 'Terlampir') ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">5. Ukuran</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo (count($reklame_data) == 1 ? $reklame_data[0]['panjang'].' m x '.$reklame_data[0]['lebar'].' m'.($reklame_data[0]['2x'] == 1 ? ' (Dua muka)' : '' ) : 'Terlampir') ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">6. Jumlah</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $reklame_juml_val.' '.$reklame_juml_unit ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">7. Jangka Waktu Pemasangan</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $reklame_range_tgl_text.' ( '.format_date($reklame_range_tgl_mulai).' s/d '.format_date($reklame_range_tgl_selesai).' )' ?></td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="5" style="width:100%"><p>Dengan Ketentuan :</p></td>
</tr>
<tr>
    <td colspan="5" style="width:100%" class="align-justify">
        <ol>
            <li>Membayar pajak reklame di Dinas Pendapatan dan pengelolaan Keuangan Daerah Kabupaten Pekalongan</li>
            <li>Pemasangan papan reklame harus dikoordinasikan dengan Dinas Pekerjaan Umum (DPU) Kabupaten Peklaongan/Balai Pelaksana Teknis Bina Marga Wilayah Kabupaten Pekalongan agar tidak mengganggu lalulintas umum, khususnya untuk reklame spanduk tidak boleh melintang di jalan.</li>
            <li>Di dalam pelaksanaannya wajib menjaga kebersihan, keamanan, ketertiban, keindahan, kesopanan, dan kesusilaan sesuai dengan kepribadian Bangsa Indonesia.</li>
            <li>Pemegang izin apabila memperpanjang/memperbaharui masa berlaku izinnya harus mengajukan permohonan selambat-lambatnya 1 (satu) bulan sebelum masa izin berakhir</li>
            <li>Apabila masa berlaku izin sudah habis dan tidak diperbaharui, maka reklame tersebut harus dibongkar dengan biaya ditanggung oleh pemegang izin.</li>
            <li>Apabila dalam waktu 15 (lima belas) hari setelah masa berlaku izin berakhir, pemohon tidak melakukan pemboingkaran, maka Pemerintah Daerah akan melakukan pembongkaran terhadap papan reklame tersebut.</li>
            <li>Apabila terdapat kekeliruan/kesalahan maka diadakan perubahan sebagaimana mestinya atau dapat dicabut</li>
            <li>Jeputusan ini mulai berlaku pada tanggal ditetapkan.</li>
        </ol>
    </td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="4" style="width:55%"></td>
    <td style="width:45%">
        <p>Ditetapkan di : <?php echo $skpd_kab ?></p>
        <p class="underline">Pada Tanggal : <?php print_blnthn_foot($surat_tanggal) ?></p>
    </td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="4" style="width:55%"></td>
    <td style="width:45%"><?php print_ttd_kadin() ?></td>
</tr>
<tr><td class="empty" colspan="5" style="width:100%"></td></tr>
<?php if (strlen($data_tembusan) > 0): ?>
<tr>
    <td colspan="5" style="width:100%">
        <p>Tembusan :</p>
        <ol>
        <?php foreach (unserialize($data_tembusan) as $tembusan) : ?>
            <li><?php echo $tembusan ?>;</li>
        <?php endforeach ?>
        </ol>
    </td>
</tr>
<?php endif ?>
</table>
<?php if (count($reklame_data) > 1): ?>
<table class="pagebreak">
    <tr>
        <td colspan="5" class="bold"><?php echo strtoupper('Lampiran Izin Reklame '.($pemohon_usaha ?: $pemohon_nama)) ?>.</td>
    </tr>
    <tr><td class="empty" colspan="5" style="width:100%"></td></tr>
    <tr style="border:1px solid #000" class="bold">
        <td class="align-center" style="border:1px solid #000; width:5%">No.</td>
        <td class="align-center" style="border:1px solid #000; width:25%">Jenis Reklame</td>
        <td class="align-center" style="border:1px solid #000; width:25%">Tema</td>
        <td class="align-center" style="border:1px solid #000; width:30%">Lokasi</td>
        <td class="align-center" style="border:1px solid #000; width:15%">Ukuran (M)</td>
    </tr>
    <?php $i = 1; foreach ($reklame_data as $lampiran): ?>
    <tr style="border:1px solid #000">
        <td class="align-center" style="border:1px solid #000"><?php echo $i ?></td>
        <td style="border:1px solid #000"><?php echo $lampiran['jenis'] ?></td>
        <td style="border:1px solid #000"><?php echo $lampiran['tema'] ?></td>
        <td style="border:1px solid #000"><?php echo $lampiran['tempat'] ?></td>
        <td class="align-center" style="border:1px solid #000"><?php echo $lampiran['panjang'].' x '.$lampiran['lebar'].($lampiran['2x'] ? ' (2 Muka)' : '') ?></td>
    </tr>
    <?php $i++; endforeach; ?>
    <tr><td class="empty" colspan="5" style="width:100%"></td></tr>
    <tr><td class="empty" colspan="5" style="width:100%"></td></tr>
    <tr class="align-center bold">
        <td colspan="3" style="width:55%"></td>
        <td colspan="2" style="width:45%"><p><?php echo $skpd_kab ?><?php print_blnthn_foot($surat_tanggal) ?></p></td>
    </tr>
    <tr><td class="empty" colspan="5" style="width:100%"></td></tr>
    <tr class="align-center bold">
        <td colspan="3" style="width:55%"></td>
        <td colspan="2" style="width:45%"><?php print_ttd_kadin() ?></td>
    </tr>
</table>
<?php endif; ?>
