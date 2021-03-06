<table width="100%" class="bordered">
    <thead>
        <tr>
            <th>NO.</th>
            <th>NOMOR IZIN USAHA</th>
            <th>NAMA PEMOHON</th>
            <th>TANGGAL MOHON</th>
            <th>JENIS IZIN USAHA</th>
            <th>AKANAT OENIGIB</th>
            <th>ALAMAT USAHA</th>
            <th>NAMA USAHA</th>
            <th>TANGGAL SAH</th>
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
        <tr id="baris-<?php echo $row->id ?>" style="text-transform: uppercase;">
            <td class="align-center"><?php echo $i ?></td>
            <td class="align-center"><?php echo $row->surat_nomor ?></td>
            <td class="align-left"><?php echo $row->pemohon_nama ?></td>
            <td class="align-center"><?php echo $row->surat_tanggal ?></td>
            <td class="align-left"><?php echo $row->usaha_jenis ?></td>
            <td class="align-left"><?php echo $row->pemohon_alamat ?></td>
            <td class="align-left"><?php echo $row->usaha_alamat ?></td>
            <td class="align-left"><?php echo $row->usaha_nama ?></td>
            <td class="align-center"><?php echo format_date( $row->approved_on ) ?></td>
        </tr>
    <?php $i++; endforeach; else : ?>
        <tr><td colspan="15"><h1 style="text-align: center;">NIHIL</h1></td></tr>
    <?php endif ?>
    </tbody>
</table>
