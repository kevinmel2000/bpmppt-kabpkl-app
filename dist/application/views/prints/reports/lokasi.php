<table width="100%" class="bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nomor Permohonan</th>
            <th>Nama Pemohon</th>
            <th>Alamat Pemohon</th>
            <th>Nama Perusahaan</th>
            <th>Alamat Perusahaan</th>
            <th>Tujuan Permohonan</th>
            <th>Luas Lokasi</th>
            <th>Area Hijau</th>
            <th>Tanggal Permohonan</th>
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
        </tr>
    </thead>
    <tbody>
    <?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>
        <tr id="baris-<?php echo $row->id ?>" style="text-transform: uppercase;">
            <td class="align-center"><?php echo $i ?></td>
            <td class="align-center"><?php echo $row->surat_nomor ?></td>
            <td class="align-left"><?php echo $row->pemohon_nama ?></td>
            <td class="align-left"><?php echo $row->pemohon_alamat ?></td>
            <td class="align-left"><?php echo $row->pemohon_usaha ?></td>
            <td class="align-left"><?php echo $row->lokasi_alamat ?></td>
            <td class="align-left"><?php echo $row->lokasi_tujuan ?></td>
            <td class="align-left"><?php echo $row->lokasi_luas ?></td>
            <td class="align-center"><?php echo $row->lokasi_area_hijau ?></td>
            <td class="align-center"><?php echo format_date( $row->surat_tanggal ) ?></td>
        </tr>
    <?php $i++; endforeach; else : ?>
        <tr><td colspan="10"><h1 style="text-align: center;">NIHIL</h1></td></tr>
    <?php endif ?>
    </tbody>
</table>
