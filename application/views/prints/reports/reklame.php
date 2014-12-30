<table width="100%" class="bordered">
	<thead>
		<tr>
			<th>NO</th>
			<th>PENANGGUNG JAWAB/ALAMAT</th>
			<th>LOKASI PEMASANGAN</th>
			<th>NOMOR/TANGGAL IZIN</th>
			<th>JENIS REKLAME</th>
			<th>TEMA</th>
			<th>JUMLAH</th>
			<th>UKURAN (M)</th>
			<th>MASA BERLAKU</th>
		</tr>
		<tr>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
		</tr>
	</thead>
	<tbody>
    <?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>
        <tr id="baris-<?php echo $row->id ?>">
        <?php if (isset($row->reklame_data)) $reklame_data = filter_reklamedata($row->reklame_data) ?>
			<td class="align-center"><?php echo $i ?></td>
			<td class="align-left"><?php echo ($row->pemohon_usaha ?: $row->pemohon_nama).($row->pemohon_usaha ? '<br>('.$row->pemohon_nama.')' : '').'<br>'.$row->pemohon_alamat ?></td>
            <td class="align-left"><ul><?php if (isset($reklame_data['tempat'])) foreach ($reklame_data['tempat'] as $tempat) echo '<li>'.$tempat.'</li>' ?></ul></td>
			<td class="align-center"><?php echo '510.8 / '.$row->surat_nomor.' / BPM PPT / Rekl'.($row->pengajuan_jenis == 'Perpanjangan' ? '.P' : '').' / '.print_blnthn_head($row->surat_tanggal).'<br>'.$row->surat_tanggal ?></td>
            <td class="align-left"><ul><?php if (isset($reklame_data['jenis'])) foreach ($reklame_data['jenis'] as $jenis) echo '<li>'.$jenis.'</li>' ?></ul></td>
            <td class="align-left"><ul><?php if (isset($reklame_data['tema'])) foreach ($reklame_data['tema'] as $tema) echo '<li>'.$tema.'</li>' ?></ul></td>
			<td class="align-center"><?php echo $row->reklame_juml_val ?></td>
            <td class="align-left"><ul><?php if (isset($reklame_data['ukuran'])) foreach ($reklame_data['ukuran'] as $ukuran) echo '<li>'.$ukuran.'</li>' ?></ul></td>
			<td class="align-left"><?php echo $row->reklame_range_tgl_text.'<br>'.format_date($row->reklame_range_tgl_mulai).' - '.format_date( $row->reklame_range_tgl_selesai ) ?></td>
		</tr>
	<?php $i++; endforeach; else : ?>
        <tr><td colspan="9"><h1 style="text-align: center;">NIHIL</h1></td></tr>
	<?php endif ?>
	</tbody>
</table>
