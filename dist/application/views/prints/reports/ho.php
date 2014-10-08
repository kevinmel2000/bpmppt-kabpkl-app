<table width="100%" class="bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Pemohon</th>
            <th>Alamat Pemohon</th>
            <th>Nama Perusahaan</th>
            <th>Alamat Perusahaan</th>
            <th>Jenis Usaha</th>
            <th>Lokasi Usaha</th>
            <th>Luas Perusahaan</th>
            <th>Jumlah Pekerja</th>
            <th>Jenis Pengajuan</th>
            <th>Tanggal Pengajuan</th>
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
        </tr>
    </thead>
    <tbody>
    <?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>
        <tr id="baris-<?php echo $row->id ?>" style="text-transform: uppercase;">
            <td class="align-center"><?php echo $i ?></td>
            <td class="align-center"><?php echo $row->pemohon_nama ?></td>
            <td class="align-left"><?php echo $row->pemohon_alamat ?></td>
            <td class="align-left"><?php echo $row->usaha_nama ?></td>
            <td class="align-left"><?php echo $row->usaha_alamat ?></td>
            <td class="align-left"><?php echo $row->usaha_jenis ?></td>
            <td class="align-left"><?php echo $row->usaha_lokasi ?></td>
            <td class="align-left"><?php echo $row->usaha_luas ?></td>
            <td class="align-center"><?php echo $row->usaha_pekerja ?></td>
            <td class="align-left"><?php echo $row->surat_jenis_pengajuan ?></td>
            <td class="align-center"><?php echo format_date( $row->created_on ) ?></td>
        </tr>
    <?php $i++; endforeach; else : ?>
        <tr><td colspan="15"><h1 style="text-align: center;">NIHIL</h1></td></tr>
    <?php endif ?>
    </tbody>
</table>
