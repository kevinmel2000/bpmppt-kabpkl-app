<table>
    <tbody>
        <tr><td colspan="6" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="6" style="width:100%; font-size: 30px; ">TANDA DAFTAR PERUSAHAAN</td>
</tr>
<tr><td colspan="6" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="6" style="width:100%"><?php echo strtoupper($usaha_jenis) ?></td>
</tr>
<tr><td colspan="6" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="6" style="width:100%">
        <p style="">BERDASARKAN<br>
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
<tr class="bold" style="border: 2px solid #000">
    <td style="width:20%; border-right: 1px solid #000;">NOMOR TDP<br><?php echo $no_tdp ?></td>
    <td colspan="3" style="width:55%; border-right: 1px solid #000;">BERLAKU S/D TANGGAL<br><?php echo format_date($tgl_berlaku) ?></td>
    <td colspan="2" style="width:35%; border-right: 2px solid #000;">PENDAFTARAN / PEMBAHARUAN KE : <?php echo $pembaruan_ke ?></td>
</tr>
<?php if ($usaha_jenis == 'Perseroan Terbatas (PT)') : ?>
<tr><td colspan="6" style="width:100%; line-height: 5px"></td></tr>
<tr style="border: 2px solid #000">
    <td colspan="4" style="width:65%"><span class="underline bold">AGENDA PENDAFTARAN</span><br>NOMOR: <?php echo $daftar_no ?></td>
    <td colspan="2" style="width:35%; border-right: 2px solid #000;">TANGGAL : <?php echo format_date($daftar_tgl) ?></td>
</tr>
<?php endif; ?>
<tr><td colspan="6" style="width:100%; line-height: 5px"></td></tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px;">
    <td style="width:20%">NAMA PERUSAHAAN</td>
    <td style="width:5%">:</td>
    <td colspan="3" style="width:55%"><?php echo strtoupper($usaha_nama) ?></td>
    <td style="width:20%; border-left: 1px solid #000; border-right: 2px solid #000;">STATUS <?php echo strtoupper($usaha_status) ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">NAMA PENGURUS / PENANGGUNG JAWAB</td>
    <td style="width:5%">:</td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><?php echo strtoupper($pemohon_nama) ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">ALAMAT PERUSAHAAN</td>
    <td style="width:5%">:</td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><?php echo strtoupper($usaha_alamat) ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">NPWP</td>
    <td style="width:5%">:</td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><?php echo strtoupper($usaha_npwp) ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">NOMOR TELEPON</td>
    <td style="width:5%">:</td>
    <td colspan="2" style="width:45%;"><?php echo strtoupper($usaha_no_telp) ?></td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;"><?php echo strlen(trim($usaha_no_fax)) > 0 ? 'FAX : '.strtoupper($usaha_no_fax) : '' ?></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%">KEGIATAN USAHA POKOK</td>
    <td style="width:5%">:</td>
    <td colspan="3" style="width:55%;"><?php echo strtoupper($usaha_pokok) ?></td>
    <td class="align-center" style="width:20%; border-left: 1px solid #000; border-right: 2px solid #000;">KBLI :<br><?php echo strtoupper($usaha_kbli) ?></td>
</tr>
<?php if (strlen($usaha_data_pengesahan) > 0): foreach (unserialize($usaha_data_pengesahan) as $pengesahan) : if (strlen($pengesahan['uraian']) > 0) : ?>
<tr style="border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
    <td colspan="6" style="width:100%; border-right: 2px solid #000;" class="bold underline"><?php echo $pengesahan['uraian'] ?></td>
</tr>
<tr style="border: 2px solid #000; border-top-width: 0;">
    <td colspan="4" style="width:70%; border-right: 1px solid #ccc;">NOMOR : <?php echo $pengesahan['no'] ?></td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;">TANGGAL : <?php echo format_date($pengesahan['tgl']) ?></td>
</tr>
<?php endif; endforeach; endif; ?>

<tr><td colspan="6" style="width:100%"></td></tr>
<tr style="">
    <td colspan="3"></td>
    <td colspan="3" style="border-bottom: 2px solid #000">Dikeluarkan di : KAJEN<br>
    Pada Tanggal : <?php echo bdate('%d %F', $surat_tanggal).' '.bdate('%Y') ?></td>
</tr>
<tr><td colspan="6" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="3"></td>
    <td colspan="3"><?php print_ttd_kadin() ?></td>
</tr>
    </tbody>
</table>
