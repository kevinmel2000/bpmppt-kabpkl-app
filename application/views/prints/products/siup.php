<table>
    <tbody>
        <tr><td class="empty" colspan="4" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
    <td colspan="4">
        <span style="font-size: 24px">SURAT IZIN USAHA PERDAGANGAN</span><br>
        <span >NOMOR : <?php echo strtoupper($no_agenda.'/11.19/'.$usaha_skala.'/'.format_roman(bdate('%m', $surat_tanggal)).'/'.bdate('%Y')).($pengajuan_jenis == 'ulang' ? '/P-'.$pembaruan_ke : '') ?></span>
    </td>
</tr>
<tr><td class="empty" colspan="4" style="width:100%"></td></tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px">
    <td style="width:25%">NAMA PERUSAHAAN</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_nama ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">NAMA PENANGGUNG JAWAB DAN JABATAN</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $pemohon_nama ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">ALAMAT PERUSAHAAN</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_alamat ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">NOMOR TELEPON</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_no_telp ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">MODAL DAN KEKAYAAN BERSIH PERUSAHAAN (TIDAK TERMASUK TANAH DAN BANGUNAN)</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;">Rp. <?php echo format_number($usaha_modal_awal) ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">KELEMBAGAAN</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php
$e = '';
foreach ( ($lembs = unserialize($usaha_lembaga)) as $i => $lembaga ) {
    $e .= ', '.($lembaga != 'Lainnya' ? $lembaga : $usaha_lembaga_lain);
}
echo ltrim($e, ', ');
?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">KEGIATAN USAHA (KBLI)</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_kegiatan ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">BARANG/JASA DAGANGAN UTAMA</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_komoditi ?></td>
</tr>
<?php if ($pengajuan_jenis != 'baru' and strlen($siup_lama) > 0) : ?>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">SIUP LAMA NOMOR</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;">
    <?php foreach (unserialize($siup_lama) as $siuplama) : ?>
        <p><?php echo strtoupper($siuplama['no'] .' TANGGAL : '. $siuplama['tgl']) ?></p>
    <?php endforeach ?>
    </td>
</tr>
<?php endif ?>
<tr class="bold" style="border: 2px solid #000; border-top-width: 1px">
    <td colspan="4" style="width:70%; border-right: 2px solid #000;">
IZIN INI BERLAKU UNTUK MELAKUKAN KEGIATAN USAHA PERDAGANGAN DISELURUH WILAYAH REPUBLIK INDONESIA, SELAMA PERUSAHAAN MASUK MENJALANKAN USAHANYA, DAN WAJIB DIDAFTAR ULANG SETIAP 5 (LIMA) TAHUN SEKALI<br>
PERUSAHAAN WAJIB MENDAFTARKAN ULANG SIUP PADA TANGGAL : <?php echo bdate('%d %F %Y', $surat_tanggal.'+5 years') ?>
    </td>
</tr>
<tr><td class="empty" colspan="4" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'">
    <td colspan="3" style="width: 70%"></td>
    <td style="width: 40%; border-bottom: 2px solid #000">
        <p>Ditetapkan di : <?php echo $skpd_kab ?></p>
        <p class="underline">Pada Tanggal : <?php echo bdate('%d %F', $surat_tanggal).' '.bdate('%Y') ?></p>
    </td>
</tr>
<tr><td class="empty" colspan="4" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
    <td colspan="3"></td>
    <td><?php print_ttd_kadin() ?></td>
</tr>
    </tbody>
</table>
