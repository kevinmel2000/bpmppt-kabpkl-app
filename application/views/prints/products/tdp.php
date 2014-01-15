<tr><td colspan="6" style="width:100%">&nbsp;</td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
	<td colspan="6" style="width:100%; font-size: 30px; font-family: 'Arial'">TANDA DAFTAR PERUSAHAAN</td>
</tr>
<tr><td colspan="6" style="width:100%">&nbsp;</td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
	<td colspan="6" style="width:100%"><?php echo strtoupper($usaha_jenis) ?></td>
</tr>
<tr><td colspan="6" style="width:100%">&nbsp;</td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
	<td colspan="6" style="width:100%">
		<p style="font-family: 'Arial'">BERDASARKAN<br>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 3 TAHUN 1982<br>
TENTANG WAJIB DAFTAR PERUSAHAAN<br>
<?php if( strtolower($usaha_jenis) == 'koprasi' ) : ?>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 25 TAHUN 1992<br>
TENTANG PERKOPERASIAN</p>
<?php elseif( strtolower($usaha_jenis) == 'badan usaha milik negara (bumn)' ) : ?>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 3 TAHUN 1982<br>
TENTANG WAJIB DAFTAR PERUSAHAAN<br>
<?php elseif( strtolower($usaha_jenis) == 'Perorangan (PO)' ) : ?>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 3 TAHUN 1982<br>
TENTANG WAJIB DAFTAR PERUSAHAAN<br>
<?php elseif( strtolower($usaha_jenis) == 'Perseroan Komanditer (CV)' ) : ?>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 3 TAHUN 1982<br>
TENTANG WAJIB DAFTAR PERUSAHAAN<br>
<?php elseif( strtolower($usaha_jenis) == 'Perseroan Terbatas (PT)' ) : ?>
UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 40 TAHUN 2007<br>
TENTANG PERSEROAN TERBATAS<br>
<?php endif; ?>
	</td>
</tr>
<tr><td colspan="6" style="width:100%">&nbsp;</td></tr>
<tr class="bold" style="font-family: 'Arial'; border: 2px solid #000">
	<td style="width:20%; border-right: 1px solid #000;">NOMOR TDP<br><?php echo $no_agenda ?></td>
	<td colspan="3" style="width:55%; border-right: 1px solid #000;">BERLAKU S/D TANGGAL<br><?php echo bdate('d F Y', $created_on) ?></td>
	<td colspan="2" style="width:35%; border-right: 2px solid #000;">PENDAFTARAN / PEMBAHARUAN KE : <?php echo $pembaruan_ke ?></td>
</tr>
<tr><td colspan="6" style="width:100%; line-height: 5px">&nbsp;</td></tr>
<tr style="font-family: 'Arial'; border: 2px solid #000">
	<td colspan="4" style="width:65%"><span class="underline bold">AGENDA PENDAFTARAN</span><br>NOMOR: <?php echo $no_agenda ?></td>
	<td colspan="2" style="width:35%; border-right: 2px solid #000;">TANGGAL : <?php echo bdate('d F Y', $created_on) ?></td>
</tr>
<tr><td colspan="6" style="width:100%; line-height: 5px">&nbsp;</td></tr>
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

<?php if( strtolower($usaha_jenis) == 'koprasi' ) : ?>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
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
</tr>
<?php elseif( strtolower($usaha_jenis) == 'badan usaha milik negara (bumn)' ) : ?>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
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
</tr>
<?php elseif( strtolower($usaha_jenis) == 'Perorangan (PO)' ) : ?>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
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
</tr>
<?php elseif( strtolower($usaha_jenis) == 'Perseroan Komanditer (CV)' ) : ?>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
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
</tr>
<?php elseif( strtolower($usaha_jenis) == 'Perseroan Terbatas (PT)' ) : ?>
<tr style="font-family: 'Arial'; border: 2px solid #000; border-top-width: 0; border-bottom: 1px solid #ccc">
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
</tr>
<?php endif; ?>

<tr><td colspan="6" style="width:100%">&nbsp;</td></tr>
<tr style="font-family: 'Arial'">
	<td colspan="3">&nbsp;</td>
	<td colspan="3" style="border-bottom: 2px solid #000">Dikeluarkan di : KAJEN<br>Pada Tanggal : <?php echo bdate('d F Y', $approved_on) ?></td>
</tr>
<tr><td colspan="6" style="width:100%">&nbsp;</td></tr>
<tr style="font-family: 'Arial'" class="align-center bold">
	<td colspan="3">&nbsp;</td>
	<td colspan="3">
	A.n. BUPATI PEKALONGAN<br>
	KEPALA <?php echo strtoupper($skpd_name) ?><br>
	<?php echo strtoupper($skpd_city) ?><br><br><br>
	<span class="underline"><?php echo strtoupper($skpd_lead_name) ?></span><br>
	Pembina Tingkat I<br>
	NIP. <?php echo strtoupper($skpd_lead_nip) ?>
	</td>
</tr>
