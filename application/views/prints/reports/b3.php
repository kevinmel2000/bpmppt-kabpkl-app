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
    <!-- start loop -->
        <tr id="baris-{% echo #id %}" style="text-transform: uppercase;">
            <td class="align-center">{% echo $i %}</td>
            <td class="align-left">{% echo #pemohon_nama %}</td>
            <td class="align-left">{% echo #pemohon_alamat %}</td>
            <td class="align-center">{% echo #usaha_lokasi %}</td>
            <td class="align-center">{% echo #no_agenda %}</td>
            <td class="align-center">{% echo bdate( 'd F Y', #created_on ) %}</td>
            <td class="align-center">{% echo bdate( 'd F Y', #created_on ) %}</td>
            <td class="align-left">{% echo '-' %}</td>
        </tr>
    <!-- conditional loop -->
        <tr><td colspan="15"><h1 style="text-align: center;">NIHIL</h1></td></tr>
    <!-- end loop -->
    </tbody>
</table>
