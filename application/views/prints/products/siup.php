<table>
    <tbody>
        <tr><td colspan="4"></td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
    <td colspan="4">
        <span style="font-size: 24px">SURAT IZIN USAHA PERDAGANGAN</span><br>
        <span >NOMOR : <?php echo strtoupper($no_agenda.'/11.19/'.$usaha_skala.'/'.format_roman(bdate('m', $susrat_tanggal)).'/'.bdate('Y')) ?></span>
    </td>
</tr>
<tr><td colspan="4" style="width:100%"></td></tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px">
    <td style="width:25%">NAMA PERUSAHAAN</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_nama ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">NAMA PENANGGUNG JAWAB DAN JABATAN</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $pemohon_nama ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">ALAMAT PERUSAHAAN</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_alamat ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">NOMOR TELEPON</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_no_telp ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">MODAL DAN KEKAYAAN BERSIH PERUSAHAAN (TIDAK TERMASUK TANAH DAN BANGUNAN)</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_modal_awal ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">KELEMBAGAAN</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php
$e = '';
foreach ( ($lembs = unserialize($usaha_lembaga)) as $i => $lembaga ) {
    $e .= $lembaga;
    if ( $i != count($lembs)-1 ) $e .= ', ';
}
echo $e;
?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">KEGIATAN USAHA (KBLI)</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_kegiatan ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px; border-top-width: 1px">
    <td style="width:25%">BARANG/JASA DAGANGAN UTAMA</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:70%; border-right: 2px solid #000;"><?php echo $usaha_komoditi ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 1px">
    <td colspan="4" style="width:70%; border-right: 2px solid #000;">
<?php if ($status == 'approved')

?>
IZIN INI BERLAKU UNTUK MELAKUKAN KEGIATAN USAHA PERDAGANGAN DISELURUH WILAYAH REPUBLIK INDONESIA, SELAMA PERUSAHAAN MASUK MENJALANKAN USAHANYA, DAN WAJIB DIDAFTAR ULANG SETIAP 5 (LIMA) TAHUN SEKALI<br>
PERUSAHAAN WAJIB MENDAFTARKAN ULANG SIUP PADA TANGGAL : <?php echo date('d F Y', strtotime('+5 years')) ?>
    </td>
</tr>

<tr><td colspan="4" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'">
    <td colspan="3" style="width: 70%"></td>
    <td style="width: 40%; border-bottom: 2px solid #000">
        <p>Ditetapkan di : Kajen</p>
        <p class="underline">Pada Tanggal : <?php echo nbs(6).bdate('F', $susrat_tanggal).' '.bdate('Y') ?></p>
    </td>
</tr>
<tr><td colspan="4" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
    <td colspan="3"></td>
    <td>
A.n. BUPATI PEKALONGAN<br>
KEPALA <?php echo strtoupper($skpd_name) ?><br>
<?php echo strtoupper($skpd_city) ?><br><br><br>
<span class="underline"><?php echo strtoupper($skpd_lead_name) ?></span><br>
<?php echo strtoupper($skpd_lead_jabatan) ?><br>
NIP. <?php echo strtoupper($skpd_lead_nip) ?>
    </td>
</tr>
<?php if (strlen($data_tembusan) > 0): ?>
<tr>
    <td colspan="7">
        <p>Tembusan :</p>
        <ol>
        <?php foreach (unserialize($data_tembusan) as $tembusan) : ?>
            <li><?php echo $tembusan ?>;</li>
        <?php endforeach ?>
        </ol>
    </td>
</tr>
<?php endif ?>

    </tbody>
</table>
