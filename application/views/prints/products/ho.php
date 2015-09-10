<?php if ($ho_lama_no) : ?><table style="position: absolute; top: 0; right: 0; min-width: 0; width: auto; float: right; font-size: 9px; line-height: 1.2em; border: 1px solid #000;">

    <tbody>

<tr>

        <td width="45%"><?php echo $surat_jenis_pengajuan ?> HO Nomor</td>

        <td width="10%">:</td>

        <td width="45%"><?php echo $ho_lama_no ?></td>

    </tr>

    <tr>

        <td>Tanggal</td>

        <td>:</td>

        <td><?php echo $ho_lama_tgl ?></td>

    </tr>

    <tr>

        <td>Izin Gangguan (HO)</td>

        <td>:</td>

        <td><?php echo $ho_lama_ho ?></td>

    </tr>

</tbody>

</table>

<?php endif; ?><table>

    <tbody>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td colspan="7" style="width:100% font-size: 14px;" class="align-center bold"><span style="font-size: 14px;">KEPUTUSAN BUPATI PEKALONGAN</span></td>

</tr>

<tr>

    <td colspan="7" style="width: 100%;" class="align-center bold"><p style="font-size: 14px;">NOMOR : <?php echo '510.8 /'.nbs(8).'/ BPMPPT / '.$surat_kode.' / '.print_blnthn_head($surat_tanggal) ?></p>

<p style="font-size: 14px;"><br></p>

<p style="font-size: 14px;">TENTANG</p>

<p style="font-size: 14px;"><br></p>

<p style="font-size: 14px;">IZIN GANGGUAN (HO) JENIS USAHA / KEGIATAN</p>

<p><span style="font-family: Arial, sans-serif; line-height: 20px; text-align: start; font-size: 14px;"><?php echo ''.$usaha_jenis.' * '.$usaha_nama.'' ?> *</span></p>

<p><span style="font-size: 14px;"><span style="font-family: Arial, sans-serif; line-height: 20px; text-align: start;">ATAS NAMA </span><span style="font-family: Arial, sans-serif; line-height: 20px; text-align: start;"><?php echo strtoupper($pemohon_nama) ?></span></span><span style="font-size: 12px; font-family: Arial, sans-serif; line-height: 20px; text-align: start;"><br></span><br></p>

</td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td colspan="7" style="width:100%" class="align-center bold"><span style="font-size: 14px;">BUPATI PEKALONGAN,</span></td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td style="width:20%"><p><span style="font-size: 14px;">Membaca</span></p>

</td>

    <td style="width:2%"><span style="font-size: 14px;">:</span></td>

    <td colspan="5" style="width:78%" class="align-justify"><p><span style="font-size: 14px;">Surat Permohonan Saudara <?php echo $pemohon_nama ?> <?php echo (strtolower($pemohon_jabatan) == 'atas nama' ? 'atas nama '.$usaha_nama.'' : ''.$pemohon_jabatan)?>, Alamat di <?php echo $pemohon_alamat ?>, tanggal <?php echo format_date($pemohon_tanggal) ?> untuk Izin tempat usaha <?php echo $usaha_jenis ?>, yang terletak di <?php echo $usaha_alamat ?>.</span></p>

</td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td style="width:20%"><p><span style="font-size: 14px;">Menimbang</span></p>

</td>

    <td style="width:2%"><span style="font-size: 14px;">:</span></td>

    <td colspan="5" style="width:78%" class="align-justify">        <ol>

            <li><span style="font-size: 14px;">Bahwa permohonan tersebut telah diumumkan menurut cara-cara tersebut dalam pasal 5 Undang-undang Gangguan ( HO )</span></li>

            <li><span style="font-size: 14px;">Bahwa dalam satu bulan tidak diterima keberatan dari pemilik, pengusaha atau persil-persil yang berbatasan dengan persil tersebut.</span></li>

            <li><span style="font-size: 14px;">Bahwa tidak ada hal-hal yang mungkin menimbulkan bahaya kerugian atau gangguan atas tanah sekitarnya.</span></li>

        </ol>

    </td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td style="width:20%"><p><span style="font-size: 14px;">Mengingat</span></p>

</td>

    <td style="width:2%"><span style="font-size: 14px;">:</span></td>

    <td colspan="5" style="width:78%" class="align-justify">        <ol>

            <li><span style="font-size: 14px;">Undang-undang Gangguan (HO) Stbl Tahun 1926 yang telah beberapa kali diubah dan terakhir ditambah dengan Ordinantie Stbl Tahun 1940 Nomor 450;</span></li>

            <li><span style="font-size: 14px;">Undang-undang Nomor 13 Tahun 1950 tentang Pembentukan Daerah-daerah  Kabupaten dalam lingkungan Propinsi Jawa Tengah;</span></li>

            <li><span style="font-size: 14px;">Undang-undang Nomor 9 tahun 1965 tentang Pembentukan Daerah Tingkat II Batang dengan mengubah Undang-undang Nomor 13 Tahun 1950 tentang Pembentukan Daerah-daerah Kabupaten dalam lingkungan Propinsi Jawa Tengah;</span></li>

            <li><span style="font-size: 14px;">Undang-Undang Nomor 28 Tahun 2009 tentang Pajak Daerah dan Retribusi Daerah;</span></li>

            <li><span style="font-size: 14px;">Undang-Undang Nomor 32 Tahun 2009 tentang Perlindungan dan Pengelolaan Lingkungan Hidup;</span></li>

            <li><span style="font-size: 14px;">Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 244, Tambahan Lembaran Negara Republik Indonesia Nomor 5587) sebagaimana telah beberapa kali diubah terakhir dengan Undang-Undang Nomor 9 Tahun 2015 tentang Perubahan Kedua Atas Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah ( Lembaran Negara Republik Indonesia Tahun 2015 Nomor 58, Tambahan Lembaran Negara Repubik Indonesia Nomor 5679);</span></li>

            <li><span style="font-size: 14px;">Peraturan Pemerintah Nomor 21 Tahun 1988 tentang Perubahan Batas Wilayah Kotamadya Daerah Tingkat II Pekalongan dan Kabupaten Daerah Tingkat II Batang;</span></li>

            <li><span style="font-size: 14px;">Peraturan Menteri Dalam Negeri Nomor 27 Tahun 2009 tentang Pedoman Penetapan Izin Gangguan Di Daerah;</span></li>

            <li><span style="font-size: 14px;">Peraturan Daerah Kabupaten Pekalongan Nomor 3 tahun 2014 tentang Izin Gangguan;</span></li>

            <li><span style="font-size: 14px;">Peraturan Bupati Pekalongan Nomor 47 Tahun 2013 tentang Perubahan Atas Peraturan Bupati Pekalongan Nomor 12 Tahun 2012 tentang Pendelegasian Kewenangan Penandatanganan Perizinan Kepada Kepala Badan Penanaman Modal dan Pelayanan Perizinan Terpadu.</span></li>

        </ol>

    </td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td colspan="7" style="width:100%" class="align-center bold"><span style="font-size: 14px;">M E M U T U S K A N :</span></td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td style="width:20%"><p><span style="font-size: 14px;">Menetapkan</span></p>

</td>

    <td style="width:2%"><span style="font-size: 14px;">:</span></td>

    <td colspan="5" style="width:78%" class="align-justify"></td>

</tr>

<tr>

    <td style="width:20%"><p><span style="font-size: 14px;">KESATU</span></p>

</td>

    <td style="width:2%"><span style="font-size: 14px;">:</span></td>

    <td colspan="5" style="width:78%" class="align-justify"><p><span style="font-size: 14px;">Memberi Izin Gangguan ( HO ) kepada Saudara <?php echo $pemohon_nama ?> <?php echo (strtolower($pemohon_jabatan) == 'atas nama' ? 'atas nama '.$usaha_nama.'' : ''.$pemohon_jabatan)?>, Alamat Kantor di <?php echo $pemohon_alamat ?>, untuk Izin tempat usaha <?php echo $usaha_jenis ?> yang terletak <?php echo $usaha_alamat ?> di atas tanah milik <?php echo $usaha_tanah_milik ?> di <?php echo $usaha_lokasi ?> dengan luas tempat usaha ± <?php echo $usaha_luas ?> M<sup>2</sup>.<br>Adapun persil tersebut berbatasan :</span></p>

</td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td colspan="2" style="width:22%"></td>

    <td class="empty" colspan="5">        <table style="min-width: 0;">

            <tbody>

<tr>

                <td style="20%"><span style="font-size: 14px;">Sebelah Utara</span></td>

                <td style="width:2%"><span style="font-size: 14px;">:</span></td>

                <td colspan="3" style="78%"><span style="font-size: 14px;"><?php echo $usaha_tetangga_utara ?></span></td>

            </tr>

            <tr>

                <td style="20%"><span style="font-size: 14px;">Sebelah Timur</span></td>

                <td style="width:2%"><span style="font-size: 14px;">:</span></td>

                <td colspan="3" style="78%"><span style="font-size: 14px;"><?php echo $usaha_tetangga_timur ?></span></td>

            </tr>

            <tr>

                <td style="20%"><span style="font-size: 14px;">Sebelah Selatan</span></td>

                <td style="width:2%"><span style="font-size: 14px;">:</span></td>

                <td colspan="3" style="78%"><span style="font-size: 14px;"><?php echo $usaha_tetangga_selatan ?></span></td>

            </tr>

            <tr>

                <td style="20%"><span style="font-size: 14px;">Sebelah Barat</span></td>

                <td style="width:2%"><span style="font-size: 14px;">:</span></td>

                <td colspan="3" style="78%"><span style="font-size: 14px;"><?php echo $usaha_tetangga_barat ?></span></td>

            </tr>

        </tbody>

</table>

    </td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td colspan="2"></td>

    <td colspan="5" style="width:78%" class="align-justify">        <p><span style="font-size: 14px;">Dengan ketentuan bahwa selambat-lambatnya dalam waktu 3 (tiga) bulan sesudah tanggal Keputusan ini, pendirian perusahaan yang dimaksudkan harus sudah selesai dikerjakan dan mulai dijalankan dengan syarat-syarat sebagai berikut :</span></p>

        <ol>

            <li><span style="font-size: 14px;">Perusahaan harus diatur sedemikian rupa sehingga tidak mengganggu tetangga.</span></li>

            <li><span style="font-size: 14px;">Peredaran udara didalam ruangan harus cukup.</span></li>

            <li><span style="font-size: 14px;">Penempatan peralatan / mesin maupun bahan-bahan harus dijaga agar tidak menimbulkan gangguan pencemaran udara/debu uap/getaran maupun air limbah cair dilingkungan sekitarnya.</span></li>

            <li><span style="font-size: 14px;">Apabila proses kegiatan perusahaan menimbulkan gejolak negatif baik yang bersifat ekologis maupun sosiologis, maka pemohon yang tercantum dalam izin harus bersedia menyelesaikan dan sanggup menerima sanksi sesuai dengan peraturan yang berlaku.</span></li>

            <li><span style="font-size: 14px;">Harus menyediakan alat pemadam kebakaran yang memenuhi syarat.</span></li>

        </ol>

        <span style="font-size: 14px;"><br>        </span><p><span style="font-size: 14px;">UNTUK DIPERHATIKAN :</span></p>

        <ol>

            <li><span style="font-size: 14px;">Supaya disediakan kotak obat-obatan selengkap-lengkapnya untuk PPPK.</span></li>

            <li><span style="font-size: 14px;">Dimuka perusahaan ditempat yang mudah dibaca supaya dipasang sebuah papan nama perusahaan, tanggal dan nomor izin ini ditulis dalam huruf cetak (balok) nama perusahaan, yang berukuran paling kecil 5 (lima) Cm.</span></li>

            <li><span style="font-size: 14px;">Supaya melengkapi persyaratan / ketentuan–ketentuan izin lainnya yang berhubungan dengan perusahaan ini.</span></li>

        </ol>

    </td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td style="width:20%"><p><span style="font-size: 14px;">KEDUA</span></p>

</td>

    <td style="width:2%"><span style="font-size: 14px;">:</span></td>

    <td colspan="5" style="width:78%" class="align-justify">        <p><span style="font-size: 14px;">Surat Keputusan ini berlaku sejak ditetapkan dengan ketentuan :</span></p>

        <ol class="lower-alpha">

            <li><span style="font-size: 14px;">Izin sewaktu-waktu dapat dicabut apabila dikemudian hari ternyata menurut situasi perkembangan perusahaan maupun lingkungan masyarakat ternyata izin tersebut sudah tidak memenuhi ketentuan lagi.</span></li>

            <li><span style="font-size: 14px;">Surat Keputusan ini berlaku selama perusahaan melakukan usahanya.</span></li>

            <li><span style="font-size: 14px;">Dalam rangka pengawasan dan pengendalian wajib dievaluasi setiap 3 (tiga) tahun.</span></li>

            <li><span style="font-size: 14px;">Bahwa apabila persyaratan yang diwajibkan untuk perusahaan tersebut tidak dipenuhi, maka izin tersebut akan dicabut.</span></li>

            <li><span style="font-size: 14px;">Bahwa izin yang ditetapkan / dikeluarkan ini merupakan persyaratan pendirian suatu usaha/perusahaan yang harus dipenuhi sesuai dengan peraturan yang berlaku.</span></li>

            <li><span style="font-size: 14px;">Apabila ada perselisihan atau sengketa didalam perusahaan yang diberikan izin ini maka Pemerintah Daerah dapat menutup perusahaan tersebut dan akan dibuka kembali setelah masalahnya dapat diselesaikan dengan musyawarah.</span></li>

            <li><span style="font-size: 14px;">Bahwa segala sesuatu akan diadakan perubahan sebagaimana mestinya, apabila dikemudian hari ternyata terdapat kekeliruan dalam penetapan ini.</span></li>

        </ol>

    </td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td style="width:20%"><p><span style="font-size: 14px;">KETIGA</span></p>

</td>

    <td style="width:2%"><span style="font-size: 14px;">:</span></td>

    <td colspan="5" style="width:78%" class="align-justify"><span style="font-size: 14px;">Keputusan ini mulai berlaku pada tanggal ditetapkan.</span></td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr>

    <td colspan="6" style="width:60%"></td>

    <td style="width:40%">        <p><span style="font-size: 14px;">Ditetapkan di <?php echo $skpd_kab ?></span></p>

        <p><span style="font-size: 14px;">Pada Tanggal <?php print_blnthn_foot($surat_tanggal) ?></span></p>

    </td>

</tr>

<tr>

<td class="empty" colspan="7" style="width:100%"></td>

</tr>

<tr class="align-center bold">

    <td colspan="5" style="width:60%"></td>

    <td colspan="2" style="width:40%"><span style="font-size: 14px;"><?php print_ttd_kadin() ?></span></td>

</tr>

<tr>

<td colspan="7" style="width:100%"><span style="font-size: 14px;"><?php print_tembusan($data_tembusan) ?></span></td>

</tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>
<tr><td class="empty" colspan="7" style="width:100%"></td></tr>

    </tbody>

</table>
