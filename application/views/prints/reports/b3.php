<table width="100%" class="bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Pemohon</th>
			<th>Alamat Pemohon</th>
			<th>Lokasi</th>
			<th>Nomor Izin</th>
			<th>Tanggal Terbit</th>
			<th>Tanggal Berlaku</th>
			<th>Keterangan</th>
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
		</tr>
	</thead>
	<tbody>
	<?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>
		<tr id="baris-<?php echo $row->id ?>" style="text-transform: uppercase;">
			<td class="align-center"><?php echo $i ?></td>
			<td class="align-left"><?php echo $row->pemohon_nama ?></td>
			<td class="align-left"><?php echo $row->pemohon_alamat ?></td>
			<td class="align-center"><?php echo $row->usaha_lokasi ?></td>
			<td class="align-center"><?php echo $row->no_agenda ?></td>
			<td class="align-center"><?php echo bdate( 'd F Y', $row->created_on ) ?></td>
			<td class="align-center"><?php echo bdate( 'd F Y', $row->created_on ) ?></td>
			<td class="align-left"><?php echo '-' ?></td>
		</tr>
	<?php $i++; endforeach; else : ?>
		<tr>
			<td colspan="15"><h1 style="text-align: center;">NIHIL</h1></td>
		</tr>
	<?php endif ?>
	</tbody>
</table>
