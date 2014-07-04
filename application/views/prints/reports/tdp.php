<table width="100%" class="bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nomor Seri</th>
            <th>Jenis Perusahaan</th>
            <th>Nomor TDP</th>
            <th>Nama Perusahaan</th>
            <th>Alamat Perusahaan</th>
            <th>Penanggung Jawab</th>
            <th>Status</th>
            <th>Keg. Pokok Usaha</th>
            <th>KBLI</th>
            <th>Pembaruan Ke</th>
            <th>Baru/Daftar Ulang</th>
            <th>Tanggal Dikeluarkan</th>
            <th>Berlaku s.d. Tanggal</th>
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
            <th>13</th>
            <th>14</th>
        </tr>
    </thead>
    <tbody>
    <?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>
        <tr id="baris-<?php echo $row->id ?>" style="text-transform: uppercase;">
            <td class="align-center"><?php echo $i ?></td>
            <td class="align-center"><?php echo $row->no_agenda ?></td>
            <td class="align-left"><?php echo $row->usaha_jenis ?></td>
            <td class="align-center"><?php echo $row->no_agenda ?></td>
            <td class="align-left"><?php echo $row->usaha_nama ?></td>
            <td class="align-left"><?php echo $row->usaha_alamat ?></td>
            <td class="align-left"><?php echo $row->pemohon_nama ?></td>
            <td class="align-left"><?php echo $row->usaha_status ?></td>
            <td class="align-left"><?php echo $row->usaha_pokok ?></td>
            <td class="align-center"><?php echo $row->usaha_kbli ?></td>
            <td class="align-center"><?php echo $row->pembaruan_ke ?></td>
            <td class="align-left"><?php echo $row->pengajuan_jenis ?></td>
            <td class="align-center"><?php echo format_date( $row->surat_tanggal ) ?></td>
            <td class="align-center"><?php echo format_date( $row->tgl_berlaku ) ?></td>
        </tr>
    <?php $i++; endforeach; else : ?>
        <tr><td colspan="15"><h1 style="text-align: center;">NIHIL</h1></td></tr>
    <?php endif ?>
    </tbody>
</table>
