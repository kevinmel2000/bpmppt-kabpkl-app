<table id="tabel-tdp" style="position: absolute; top: 0; left: 70%; min-width: 0; width: 30%; float: right; font-size: 9px; line-height: 1.2em; border: 1px solid #000;">
    <tbody><tr>
        <td width="45%">No. Agenda</td>
        <td width="10%">:</td>
        <td width="45%"><?php echo $no_agenda ?></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?php echo $surat_tanggal ?></td>
    </tr>
</tbody></table>

<?php if (in_array($usaha_jenis, array('Koperasi', 'Perseroan Terbatas (PT)'))) : ?>

<?php endif; ?>

<?php if (strlen($usaha_data_pengesahan) > 0): foreach (bi_flip_array(unserialize($usaha_data_pengesahan)) as $pengesahan) : if (strlen($pengesahan['uraian']) > 0) : ?>

<?php endif; endforeach; endif; ?>

<table>
    <tbody>
        <tr><td class="empty" colspan="6" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="6" style="width:100%; font-size: 30px; ">TANDA DAFTAR PERUSAHAAN</td>
</tr>
<tr><td class="empty" colspan="6" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="6" style="width:100%"><span style="font-size: 18px;"><?php echo strtoupper($usaha_jenis) ?></span></td>
</tr>
<tr><td class="empty" colspan="6" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="6" style="width:100%">
        <p style="">BERDASARKAN<br>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 3 TAHUN 1982<br>
TENTANG WAJIB DAFTAR PERUSAHAAN
<?php // koperasi ---------------------------------------------------------------
if( $usaha_jenis == 'Koperasi' ) : ?>DAN<br>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 25 TAHUN 1992<br>
TENTANG PERKOPERASIAN
<?php // Perseroan Terbatas (PT) -----------------------------------------------
elseif( $usaha_jenis == 'Perseroan Terbatas (PT)' ) : ?>DAN<br>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 40 TAHUN 2007<br>
TENTANG PERSEROAN TERBATAS
<?php else: ?>
<?php endif; ?></p>
    </td>
</tr>
<tr><td class="empty" colspan="6" style="width:100%"></td></tr>
<tr class="bold" style="border: 2px solid #000">
    <td style="width:20%; border-right: 1px solid #000;"><div style="text-align: center;"><span style="font-size: 14px; background-color: transparent;">NOMOR TDP</span></div><span style="font-size: 14px;"><div style="text-align: center;"><span style="font-size: 14px; background-color: transparent;"><?php echo $no_tdp ?></span></div></span></td>
    <td colspan="3" style="width:55%; border-right: 1px solid #000;"><div style="text-align: center;"><span style="font-size: 14px; background-color: transparent;">BERLAKU S/D TANGGAL</span></div><div style="text-align: center;"><span style="font-size: 14px; background-color: transparent;"><?php echo format_date($tgl_berlaku) ?></span></div></td>
    <td colspan="2" style="width:35%; border-right: 2px solid #000;"><span style="font-size: 14px;">PENDAFTARAN / PEMBAHARUAN KE : <?php echo $pembaruan_ke ?></span></td>
</tr><tr><td colspan="6" style="width:100%; line-height: 5px"></td></tr>
<tr style="border: 2px solid #000">
    <td colspan="4" style="width:65%"><span style="font-size: 14px;"><span class="underline bold">AGENDA PENDAFTARAN</span><br>NOMOR: <?php echo $daftar_no ?></span></td>
    <td colspan="2" style="width:35%; border-right: 2px solid #000;"><span style="font-size: 14px;">TANGGAL : <?php echo $daftar_tgl ? format_date($daftar_tgl) : '-' ?></span></td>
</tr><tr><td colspan="6" style="width:100%; line-height: 5px"></td></tr>
<tr class="bold" style="border: 2px solid #000; border-bottom-width: 1px;">
    <td style="width:20%"><span style="font-size: 14px;">NAMA PERUSAHAAN</span></td>
    <td style="width:5%"><span style="font-size: 14px;">:</span></td>
    <td colspan="3" style="width:55%"><span style="font-size: 14px;"><?php echo strtoupper($usaha_nama) ?></span></td>
    <td style="width:20%; border-left: 1px solid #000; border-right: 2px solid #000;"><span style="font-size: 14px;">STATUS <?php echo strtoupper($usaha_status) ?></span></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%"><span style="font-size: 14px;">NAMA PENGURUS / PENANGGUNG JAWAB</span></td>
    <td style="width:5%"><span style="font-size: 14px;">:</span></td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><span style="font-size: 14px;"><?php echo strtoupper($pemohon_nama) ?></span></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%"><span style="font-size: 14px;">ALAMAT PERUSAHAAN</span></td>
    <td style="width:5%"><span style="font-size: 14px;">:</span></td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><span style="font-size: 14px;"><?php echo strtoupper($usaha_alamat) ?></span></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%"><span style="font-size: 14px;">NPWP</span></td>
    <td style="width:5%"><span style="font-size: 14px;">:</span></td>
    <td colspan="4" style="width:75%; border-right: 2px solid #000;"><span style="font-size: 14px;"><?php echo strtoupper($usaha_npwp) ?></span></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px;">
    <td style="width:20%"><span style="font-size: 14px;">NOMOR TELEPON</span></td>
    <td style="width:5%"><span style="font-size: 14px;">:</span></td>
    <td colspan="2" style="width:45%;"><span style="font-size: 14px;"><?php echo strtoupper($usaha_no_telp) ?></span></td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;"><span style="font-size: 14px;"><?php echo strlen(trim($usaha_no_fax)) > 0 ? 'FAX : '.strtoupper($usaha_no_fax) : '' ?></span></td>
</tr>
<tr class="bold" style="border: 2px solid #000; border-top-width: 0; border-bottom-width: 1px; line-height: 1em;">
    <td style="width:20%"><span style="font-size: 14px;">KEGIATAN USAHA POKOK</span></td>
    <td style="width:5%"><span style="font-size: 14px;">:</span></td>
    <td colspan="3" style="width:55%;"><span style="font-size: 14px;"><?php echo strtoupper($usaha_pokok) ?></span></td>
    <td class="align-center" style="width:20%; border-left: 1px solid #000; border-right: 2px solid #000;"><span style="font-size: 14px;">KBLI :<br><?php echo strtoupper($usaha_kbli) ?></span></td>
</tr><tr style="border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
    <td colspan="6" style="width:100%; border-right: 2px solid #000;" class="bold underline"><span style="font-size: 14px;"><?php echo $pengesahan['uraian'] ?></span></td>
</tr>
<tr style="border: 2px solid #000; border-top-width: 0;">
    <td colspan="4" style="width:70%; border-right: 1px solid #ccc;"><span style="font-size: 14px;">NOMOR : <?php echo $pengesahan['no'] ?></span></td>
    <td colspan="2" style="width:30%; border-right: 2px solid #000;"><span style="font-size: 14px;">TANGGAL : <?php echo format_date($pengesahan['tgl']) ?></span></td>
</tr><tr><td class="empty" colspan="6" style="width:100%"></td></tr>
<tr style="">
    <td colspan="3"></td>
    <td colspan="3" style="border-bottom: 2px solid #000"><span style="font-size: 14px;">Dikeluarkan di : KAJEN<br>
    Pada Tanggal : <?php echo bdate('%d %F %Y', $surat_tanggal) ?></span></td>
</tr>
<tr><td class="empty" colspan="6" style="width:100%"></td></tr>
<tr class="align-center bold">
    <td colspan="3"></td>
    <td colspan="3"><span style="font-size: 14px;"><?php print_ttd_kadin() ?></span></td>
</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
    </tbody>
</table>
