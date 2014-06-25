<tr><td colspan="5" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="5" style="width:100%">
        <p>SURAT IZIN BUPATI PEKALONGAN</p>
        <p>NOMOR : <?php echo $surat_nomor?>/      <?php echo strtoupper('/BPM PPT/Rekl/'.format_roman(bdate('m', $created_on)).'/'.bdate('Y')) ?></p>
        <p>IZIN PEMASANGAN REKLAME</p>
    </td>
</tr>
<tr><td colspan="5" style="width:100%"></td></tr>
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
<tr><td colspan="5" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="5">M E N G I Z I N  K A N</td>
</tr>
<tr><td colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="5" style="width:100%"><p>Kepada :</p></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">1. Nama</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $pemohon_nama ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">2. Alamat</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $pemohon_alamat ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">3. Tempat/Lok. Pemasangan</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $reklame_lokasi ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">4. Tema Pemasangan</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $reklame_tema ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">5. Ukuran</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $reklame_ukuran_panjang.' m x '.$reklame_ukuran_lebar.' m' ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">6. Jumlah</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $reklame_juml.' Unit' ?></td>
</tr>
<tr>
    <td colspan="2" style="width:30%">7. Jangka Waktu Pemasangan</td>
    <td style="width:2%">:</td>
    <td colspan="2" style="width:30%"><?php echo $reklame_range_tgl_text.' '.bdate('d F Y', $reklame_range_tgl_mulai).' - '.bdate('d F Y', $reklame_range_tgl_selesai) ?></td>
</tr>
<tr><td colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="5" style="width:100%"><p>Dengan Ketentuan :</p></td>
</tr>
<tr>
    <td colspan="5" style="width:100%" class="align-justify">
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
<tr><td colspan="5" style="width:100%"></td></tr>
<tr>
    <td colspan="4" style="width:60%"></td>
    <td colspan="1" style="width:40%">
        <p>Ditetapkan di : Kajen</p>
        <p>Pada Tanggal :       <?php echo bdate('F', $created_on).' '.bdate('Y') ?></p>
    </td>
</tr>
<tr><td colspan="5" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="3" style="width:60%"></td>
    <td colspan="2" style="width:40%">
    A.n. BUPATI PEKALONGAN<br>
    KEPALA <?php echo strtoupper($skpd_name) ?><br>
    <?php echo strtoupper($skpd_city) ?><br><br><br>
    <span class="underline"><?php echo strtoupper($skpd_lead_name) ?></span><br>
    <?php echo strtoupper($skpd_lead_jabatan) ?><br>
    NIP. <?php echo strtoupper($skpd_lead_nip) ?>
    </td>
</tr>
<tr><td colspan="5" style="width:100%"></td></tr>
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
