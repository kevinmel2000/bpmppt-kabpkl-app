<table width="100%" class="bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nomor Permohonan</th>
			<th>Nama Pemohon</th>
			<th>Alamat Pemohon</th>
			<th>Jenis Reklame</th>
			<th>Jumlah Reklame</th>
			<th>Lokasi Pemasangan</th>
			<th>Tgl. Mulai Pemasangan</th>
			<th>Tgl. Selesai Pemasangan</th>
			<th>Tema</th>
			<th>Keterangan</th>
			<th>Tanggal</th>
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
			<th>10</th>
			<th>11</th>
			<th>12</th>
		</tr>
	</thead>
	<tbody>
	<?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>
		<tr id="baris-<?php echo $row->id ?>" style="text-transform: uppercase;">
			<td class="align-center"><?php echo $i ?></td>
			<td class="align-left"><?php echo $row->surat_nomor ?></td>
			<td class="align-left"><?php echo $row->pemohon_nama ?></td>
			<td class="align-left"><?php echo $row->pemohon_alamat ?></td>
			<td class="align-left"><?php echo $row->reklame_jenis ?></td>
			<td class="align-left"><?php echo $row->reklame_juml ?></td>
			<td class="align-left"><?php echo $row->reklame_lokasi ?></td>
			<td class="align-left"><?php echo format_date( $row->reklame_range_tgl_mulai ) ?></td>
			<td class="align-left"><?php echo format_date( $row->reklame_range_tgl_selesai ) ?></td>
			<td class="align-left"><?php echo $row->reklame_tema ?></td>
			<td class="align-left"><?php echo $row->reklame_ket ?></td>
			<td class="align-center"><?php echo format_date( $row->surat_tanggal ) ?></td>
		</tr>
	<?php $i++; endforeach; else : ?>
        <tr><td colspan="15"><h1 style="text-align: center;">NIHIL</h1></td></tr>
	<?php endif ?>
	</tbody>
</table>
