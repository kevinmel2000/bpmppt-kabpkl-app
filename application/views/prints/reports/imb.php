<table width="100%" class="bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Pemohon</th>
            <th>Alamat</th>
            <th>Maksud Permohonan</th>
            <th>Guna Bangunan</th>
            <th>Lokasi Bangunan</th>
            <th>Luas Tanah</th>
            <th>Keadaan Tanah</th>
            <th>Status Tanah</th>
            <th>No. Kepemilikan</th>
            <th>Atas Nama</th>
            <th>Tgl. Pengajuan</th>
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
            <td class="align-center"><?php echo $row->pemohon_nama ?></td>
            <td class="align-center"><?php echo $row->pemohon_alamat ?></td>
            <td class="align-center"><?php echo $row->bangunan_maksud ?></td>
            <td class="align-left"><?php $bangunan_area = unserialize($row->bangunan_area); if (isset($bangunan_area['guna'])) echo bi_imploder($bangunan_area['guna']) ?></td>
            <td class="align-left"><?php echo $row->bangunan_lokasi_kel.' '.$row->bangunan_lokasi_kec ?></td>
            <td class="align-left"><?php $bangunan_tanah = unserialize($row->bangunan_tanah); if (isset($bangunan_tanah['luas'])) echo bi_imploder($bangunan_tanah['luas']) ?></td>
            <td class="align-left"><?php echo $row->bangunan_tanah_keadaan ?></td>
            <td class="align-center"><?php echo $row->bangunan_tanah_status ?></td>
            <td class="align-center"><?php if (isset($bangunan_tanah['no'])) echo bi_imploder($bangunan_tanah['no']) ?></td>
            <td class="align-left"><?php if (isset($bangunan_tanah['an'])) echo bi_imploder($bangunan_tanah['an']) ?></td>
            <td class="align-center"><?php echo format_date( $row->created_on ) ?></td>
        </tr>
    <?php $i++; endforeach; else : ?>
        <tr><td colspan="15"><h1 style="text-align: center;">NIHIL</h1></td></tr>
    <?php endif ?>
    </tbody>
</table>
