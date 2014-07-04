<table>
    <tbody>
        <tr><td colspan="6" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
    <td colspan="6" style="width:100%; font-size: 30px; font-family: 'Arial'">TANDA DAFTAR PERUSAHAAN</td>
</tr>
<tr><td colspan="6" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
    <td colspan="6" style="width:100%"><?php echo strtoupper($usaha_jenis) ?></td>
</tr>
<tr><td colspan="6" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
    <td colspan="6" style="width:100%">
        <p style="font-family: 'Arial'">BERDASARKAN<br>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 3 TAHUN 1982<br>
TENTANG WAJIB DAFTAR PERUSAHAAN<br>
<?php // koperasi ---------------------------------------------------------------
if( strtolower($usaha_jenis) == 'koperasi' ) : ?>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 25 TAHUN 1992<br>
TENTANG PERKOPERASIAN
<?php // Perseroan Terbatas (PT) -----------------------------------------------
elseif( strtolower($usaha_jenis) == 'Perseroan Terbatas (PT)' ) : ?>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 40 TAHUN 2007<br>
TENTANG PERSEROAN TERBATAS
<?php endif; ?></p>
    </td>
</tr>
<tr><td colspan="6" style="width:100%"></td></tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000">
    <td style="width:20%; border-right: 1px solid #000;">NOMOR TDP<br><?php echo $no_agenda ?></td>
    <td colspan="3" style="width:55%; border-right: 1px solid #000;">BERLAKU S/D TANGGAL<br><?php echo format_date( $created_on) ?></td>
    <td colspan="2" style="width:35%; border-right: 2px solid #000;">PENDAFTARAN / PEMBAHARUAN KE : <?php echo $pembaruan_ke ?></td>
</tr>
<tr><td colspan="6" style="width:100%; line-height: 5px"></td></tr>
<tr style="font-family: 'Arial'; border: 2px solid #000">
    <td colspan="4" style="width:65%"><span class="underline bold">AGENDA PENDAFTARAN</span><br>NOMOR: <?php echo $no_agenda ?></td>
    <td colspan="2" style="width:35%; border-right: 2px solid #000;">TANGGAL : <?php echo format_date( $created_on) ?></td>
</tr>
<tr><td colspan="6" style="width:100%; line-height: 5px"></td></tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-bottom-width: 1px;">
    <td style="width:20%">NAMA PERUSAHAAN</td>
    <td style="width:5%">:</td>
    <td colspan="3" style="width:55%"><?php echo strtoupper($usaha_nama) ?></td>
    <td style="width:20%; border-left: 1px solid #000; border-right: 2px solid #000;">STATUS TANGGAL</td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">NAMA PENGURUS / PENANGGUNG JAWAB</td>
    <td style="width:5%">:</td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><?php echo strtoupper($pemohon_nama) ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">ALAMAT PERUSAHAAN</td>
    <td style="width:5%">:</td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><?php echo strtoupper($usaha_alamat) ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">NPWP</td>
    <td style="width:5%">:</td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><?php echo strtoupper($usaha_npwp) ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">NOMOR TELEPON</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:45%;"><?php echo strtoupper($usaha_no_telp) ?></td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;">FAX : <?php echo strtoupper($usaha_no_telp) ?></td>
</tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">KEGIATAN USAHA POKOK</td>
    <td style="width:5%">:</td>
    <td colspan="3" style="width:55%;"><?php echo strtoupper($usaha_pokok) ?></td>
    <td class="align-center" style="width:20%; border-left: 1px solid #000; border-right: 2px solid #000;">KBLI :<br><?php echo strtoupper($usaha_kbli) ?></td>
</tr>

<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
<?php // koperasi ---------------------------------------------------------------
if( strtolower($usaha_jenis) == 'koperasi' ) : ?>
    <td colspan="6" style="width:100%; border-right: 2px solid #000;" class="bold underline">PENGESAHAN MENTERI NEGARA KOPERASI DAN USAHA KECIL DAN MENENGAH REPUBLIK INDONESIA ATAS AKTA PENDIRIAN KOPERASI</td>
</tr>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0;">
    <td colspan="4" style="width:70%; border-right: 1px solid #ccc;">NOMOR : 518/9436.a/BH/XI2006</td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;">TANGGAL : 23 NOVEMBER 2006</td>
<?php // Perseroan Terbatas (PT) -----------------------------------------------
elseif( strtolower($usaha_jenis) == 'Perseroan Terbatas (PT)' ) : ?>
    <td colspan="6" style="width:100%; border-right: 2px solid #000;" class="bold underline">PENGESAHAN MENTERI KEHAKIMAN</td>
</tr>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td colspan="4" style="width:70%; border-right: 1px solid #ccc;">NOMOR : C2-8679.HT 01 01 TH. 2001</td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;">TANGGAL : 8 AGUSTUS 2001</td>
</tr>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
    <td colspan="6" style="width:100%; border-right: 2px solid #000;" class="bold underline">PERSETUJUAN MENTERI KEHAKIMAN ATAS AKTA PERUBAHAN ANGGARAN DASAR</td>
</tr>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td colspan="4" style="width:70%; border-right: 1px solid #ccc;">NOMOR : C-22542. AH. 01. 04 TH. 2005</td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;">TANGGAL : 12 AGUSTUS 2005</td>
</tr>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
    <td colspan="6" style="width:100%; border-right: 2px solid #000;" class="bold underline">PERSETUJUAN METNERI HUKUM DAN HAM REPUBLIK INDONESIA ATAS AKTA PERUBAHAN ANGGARAN DASAR PERSEROAN</td>
</tr>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0;">
    <td colspan="4" style="width:70%; border-right: 1px solid #ccc;">NOMOR : AHU-50221. AH. O1. 02. TH. 2008</td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;">TANGGAL : 12 AGUSTUS 2008</td>
<?php endif; ?>
</tr>

<tr><td colspan="6" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'">
    <td colspan="3"></td>
    <td colspan="3" style="border-bottom: 2px solid #000">Dikeluarkan di : KAJEN<br>Pada Tanggal : <?php echo format_date( $approved_on) ?></td>
</tr>
<tr><td colspan="6" style="width:100%"></td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
    <td colspan="3"></td>
    <td colspan="3">
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
