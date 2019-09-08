<?php
//echo '<pre>';
//print_r($ruang_new);
//print_r($data_kegiatan_entitas);
//print_r($data_kegiatan_jenis);
//print_r($data_kegiatan_kategori);
//print_r(cetak_jadwal($ruang, $data_jadwal));
//print_r($data_jadwal);
//echo '</pre>';

foreach ($data_kegiatan as $k => $v) {
    $nomor          = $v['nomor'];
    $event_name     = $v['event_name'];
    $nama_peminjam  = $v['nama_peminjam'];
    $id_peminjam    = $v['id_peminjam'];
    $prodi          = $v['prodi'];
    $tgl_permohonan = $v['tgl_permohonan'];
    $tgl_proses 	= $v['tgl_proses'];
    $catatan        = $v['catatan'];
    $kebutuhan      = $v['details'];
    $jml_peserta    = $v['jml_peserta'];
    $no_telp        = $v['no_telp'];
    $email          = $v['email'];
    $tema           = $v['tema'];
    $deskripsi      = $v['deskripsi'];
    $tujuan         = $v['tujuan'];
    $pengisi_acara  = $v['pengisi_acara'];
    $file_tor       = $v['file_tor'];
    $file_rundown   = $v['file_rundown'];
    $file_undangan  = $v['file_undangan'];
    $file_lampiran  = $v['file_lampiran'];
    $file_lampiran  = $v['file_lampiran'];
    $kode_org_mhs 		= $v['kode_org_mhs'];
		$ketua_org_mhs 	= $v['ketua_org_mhs'];
		$pejabat_dep		= $v['pejabat_dep'];
		$nip		= $v['nip'];
}

//set enable browse file
$disabled_file_tor = (!empty($file_tor)) ? 'disabled' : '';
$disabled_file_rundown = (!empty($file_rundown)) ? 'disabled' : '';
$disabled_file_undangan = (!empty($file_undangan)) ? 'disabled' : '';
$disabled_file_lampiran = (!empty($file_lampiran)) ? 'disabled' : '';

foreach ($nama_dep as $v){
	$nama_dep = $v['departemen'];
}

$array_org = array(
			'bem' => 'Badan Eksekutif Mahasiswa',
			'bpm' => 'Badan Perwakilan Mahasiswa',
			'hm' => 'Himpunan Mahasiswa',
			'bo' => 'Badan Otonom Mahasiswa',
			'bso' => 'Badan Semi Otonom Mahasiswa'
		);
$nama_org_mhs = $array_org[$kode_org_mhs];

$nama_ketua = ($kode_org_mhs == 'hm') ? $nama_org_mhs.' '.$nama_dep : $nama_org_mhs;
?>
<input type="hidden" id="nomor" name="nomor" class="form-control" size="5" value="<?=$nomor?>"/>
<input type="hidden" id="v_kode_org_mhs" name="v_kode_org_mhs" class="form-control" size="5" value="<?=$kode_org_mhs?>"/>
<section class="content" >
    <!-- Bagian Untuk Diisi Petugas Infrastruktur -->
    <div class="box box-warning">        
        <div class="box-header with-border" style="text-align:center">
            <b class="box-title">Form Permohonan Peminjaman Ruang</b>
        </div>
        <div class="box-body">
            <div class="row">
                <div>Mahasiswa</div>
                <div class="col-md-12" style="color:red; text-align:center;">
                    <i>- <b>peminjaman ruang kelas tidak diperkenankan selama Ujian Akhir Semester berlangsung</b> -</i>
                </div>
                <div class="col-md-12" style="color:red; text-align:center;">
                    <i>- <b>dalam satu kegiatan, pengajuan jadwal tidak boleh lebih dari dua minggu</b> -</i>
                </div>
                <div class="col-md-12" style="color:red; text-align:center;">
                    <i>- <b>untuk mempermudah koordinasi, dimohon untuk mengisi nomor telepon dengan benar</b> - </i>
                </div>
                <div class="col-md-12" style="color:red; text-align:center;">
                    <i>- <b>untuk kegiatan yang memerlukan beberapa jadwal, cukup dengan 1 (satu) lembar form pengajuan</b> -</i>
                </div>
                <div class="col-md-12" style="color:red; text-align:center;">
                    <i>- <b>untuk penggunaan ruang Nurani, silahkan berkoordinasi dengan Sekretariat Pimpinan</b> -</i>
                </div>
                <input type="hidden" id="edit_tgl_proses" name="edit_tgl_proses" class="form-control" size="5" value="<?php echo $tgl_proses?>"/>
            </div>
        </div><!-- /.Bagian Untuk Diisi Petugas Infrastruktur -->
    </div>
    
    <!-- Bagian Untuk Diisi Pemohon -->
    <div class="box box-warning">        
        <div class="box-header with-border" style="text-align:center">
            <b class="box-title">Diajukan Oleh</b>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="entitas" class="col-sm-3 control-label" style="text-align:right">Identitas :  </label>
                    <div class="col-md-9 col-md-9">
                        <!-- checkbox --> 
                        <?=checkbox_entitas($data_kegiatan_entitas)?>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="tgl_permohonan" class="col-sm-3 control-label" style="text-align:right">Tanggal : </label>
                    <div class="col-sm-9">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input id="edit_tgl_permohonan" name="edit_tgl_permohonan" class="form-control" value="<?php echo dbToTanggal($tgl_permohonan)?>">
                        </div>
                    </div>
                </div>               
                <div class="form-group">
                    <label for="unit" class="col-sm-3 control-label" style="text-align:right">PAF/Dept/Prog/HM : </label>
                    <div class="col-sm-9">
                        <input type="text" id="edit_unit_kerja" name="edit_unit_kerja" value="<?=$prodi?>" placeholder="PAF/Dept/Prog/HM : " class="form-control input-md" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_peminjam" class="col-sm-3 control-label" style="text-align:right">Penanggung Jawab : </label>
                    <div class="col-sm-9">
                        <input type="text" id="edit_nama_peminjam" name="edit_nama_peminjam" value="<?=$nama_peminjam?>" placeholder="nama peminjam" class="form-control input-md" required="">
                    </div>
                </div> 
                <div class="form-group">
                    <label for="id_peminjam" class="col-sm-3 control-label" style="text-align:right">NPM/NIP/NUP : </label>
                    <div class="col-sm-9">
                        <input type="text" id="edit_id_peminjam" name="edit_id_peminjam" value="<?=$id_peminjam?>" placeholder="NPM/NIP/NUP" class="form-control input-md" required="">
                    </div>
                </div>   
                <div class="form-group">
                    <label for="no_telp" class="col-sm-3 control-label" style="text-align:right">No. Telepon : </label>
                     <div class="col-sm-9">
                         <input type="text" id="edit_no_telp" name="edit_no_telp" value="<?=$no_telp?>" placeholder="Nomor Telepon" class="form-control input-md" required="">
                     </div>                        
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label" style="text-align:right">E-mail :</label>
                    <div class="col-sm-9">
                        <input type="text" id="edit_email" name="edit_email" value="<?=$email?>" placeholder="e-mail" class="form-control input-md" required="">
                    </div>                        
                </div>          
            </div>
        </div>
    </div>
    
    <!-- Data Pengesahan -->
    <div class="box box-warning">
        <div class="box-header with-border" style="text-align:center">
            <b class="box-title">Diketahui Oleh</b>
        </div>
        <div class="row">
            <div class="col-md-12">
            	<!-- <label for="ketua_lembaga" class="col-sm-3 col-md-3 col-md-3 control-label" style="text-align:right">Nama Organisasi Mahasiswa :  </label> -->
            	<div class="col-sm-1 col-md-1 col-md-1"></div>
                <div class="col-sm-5 col-md-5 col-md-5">
                	<div style="font-weight:bold"> Nama Organisasi Mahasiswa :  </div>
    				<? data_pengesahan($kode_org_mhs);?>
    			</div>
			    <div class="col-sm-6 col-md-6 col-md-6">
			        <div style="font-weight:bold">Nama Ketua <span id="edit_nama_organisasi"><? echo $nama_ketua?></span></div>
			        <input type="text" name="edit_ketua_org_mhs" class="ketua_org_mhs form-control" id="edit_ketua_org_mhs" value="<?=$ketua_org_mhs?>">
			        	<br>
			        <div id="edit_label-pejabat" style="font-weight:bold">Nama Pejabat Departemen <span id="edit_nama_dep"></span></div>
			        <input type="text" name="edit_nip" class="nip form-control" id="edit_nip" value="<?=$nip?>">
			        <input type="text" name="edit_pejabat_dep" class="pejabat_dep form-control" id="edit_pejabat_dep" value="<?=$pejabat_dep?>">
			    </div>
			</div>
		</div>
	</div>
	
    <!-- Data Kegiatan -->
    <div class="box box-warning">        
        <div class="box-header with-border" style="text-align:center">
            <b class="box-title">Data Kegiatan</b>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="kategori" class="col-sm-3 control-label" style="text-align:right">Kategori :  </label>
                    <div class="col-md-9 col-md-9">
                        <!-- checkbox -->  
                        <?=checkbox_kategori($data_kegiatan_kategori)?>       
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="jenis" class="col-sm-3 control-label" style="text-align:right">Jenis :  </label>
                    <div class="col-md-9 col-md-9">
                        <!-- checkbox -->
                        <?=checkbox_jenis($data_kegiatan_jenis)?>                    
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="nama_kegiatan" class="col-sm-3 control-label" style="text-align:right">Nama Kegiatan :  </label>
                    <div class="col-sm-9">
                        <input type="text" id="edit_nama_kegiatan" name="edit_nama_kegiatan" placeholder="Nama Kegiatan" class="form-control input-md" value="<?=$event_name?>" required="">
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="tema" class="col-sm-3 control-label" style="text-align:right">Tema Kegiatan:  </label>
                    <div class="col-sm-9">
                        <textarea id="edit_tema" name="edit_tema" rows="5" cols="80"> <?=$tema?> </textarea>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="deskripsi" class="col-sm-3 control-label" style="text-align:right">Deskripsi Kegiatan:  </label>
                    <div class="col-sm-9">
                        <textarea id="edit_deskripsi" name="edit_deskripsi" rows="5" cols="80"> <?=$deskripsi?> </textarea>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="tujuan" class="col-sm-3 control-label" style="text-align:right">Tujuan Kegiatan:  </label>
                    <div class="col-sm-9">
                        <textarea id="edit_tujuan" name="edit_tujuan" rows="5" cols="80"> <?=$tujuan?> </textarea>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="pengisi_acara" class="col-sm-3 control-label" style="text-align:right">Pengisi Acara:  (Deskirpsikan background dan latar belakang pengisi acara) </label>
                    <div class="col-sm-9">
                        <textarea id="edit_pengisi_acara" name="edit_pengisi_acara" rows="10" cols="80"> <?=$pengisi_acara?> </textarea>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="peserta" class="col-sm-3 control-label" style="text-align:right">Peserta :  </label>
                    <div class="col-md-9 col-md-9">
                        <!-- checkbox -->
                        <?=checkbox_peserta($data_kegiatan_peserta)?>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="jml_peserta" class="col-sm-3 control-label" style="text-align:right">Jumlah Peserta :  </label>
                    <div class="col-sm-9">
                        <input type="text" id="edit_jml_peserta" name="edit_jml_peserta" placeholder="Jumlah Peserta" class="form-control input-md" value=" <?=$jml_peserta?> " required="">
                    </div>                        
                </div>
                <div>&nbsp;</div>
                <div class="form-group">
                    <label for="file" class="col-sm-3 control-label" style="text-align:right">Lampiran :<br>Wajib Melampirkan dokumen terkait<br><i style="color:red; font-size:12px;">Ekstensi file (.jpg, .png, .gif, .pdf) dan tidak lebih dari 1MB</i></label>
                    <div class="col-sm-9">
			          <form id="edit_upload_form" enctype="multipart/form-data" method="post">
				          <input type="hidden" name="action" id="action" value="test action">
				          <input type="hidden" name="post_foto" id="post_foto" value="test id foto">
                          <table class="table">
                            <tr>
                                <td>Formulir Permohonan Izin Kegiatan</td>
                                <td>
                                    <input type="file" name="file_tor" value="" <?=$disabled_file_tor?> >
                                </td>
                                <td id="file_tor" class="nama_file"><?=$file_tor?></td>
                                <td>
                                    <?php echo $retVal = (!empty($file_tor)) ? '<button type="button" class="btn btn-danger btn-xs hapus-dokumen" data-dokumen="file_tor" data-file="'.$file_tor.'">hapus</button>' : '' ;?>
                                </td>
                            </tr>
                            <tr>
                                <td>Rundown Acara/Kegiatan</td>
                                <td><input type="file" name="file_rundown" <?=$disabled_file_rundown?> ></td>
                                <td id="file_rundown" class="nama_file"><?=$file_rundown?></td>
                                <td>
                                    <?php echo $retVal = (!empty($file_rundown)) ? '<button type="button" class="btn btn-danger btn-xs hapus-dokumen" data-dokumen="file_rundown" data-file="'.$file_rundown.'">hapus</button>' : '' ;?>
                                    </td>
                            </tr>
                            <tr><td>Undangan Resmi</td>
                                <td><input type="file" name="file_undangan" <?=$disabled_file_undangan?> ></td>
                                <td id="file_undangan" class="nama_file"><?=$file_undangan?></td>
                                <td>
                                    <?php echo $retVal = (!empty($file_undangan)) ? '<button type="button" class="btn btn-danger btn-xs hapus-dokumen" data-dokumen="file_undangan" data-file="'.$file_undangan.'">hapus</button>' : '' ;?>
                                </td>
                            </tr>
                            <tr>
                                <td>Lampiran Penting Lainnya</td>
                                <td>
                                    <input type="file" name="file_lampiran" <?=$disabled_file_lampiran?> >
                                </td>
                                <td id="file_lampiran" class="nama_file"><?=$file_lampiran?></td>
                                <td>
                                    <?php echo $retVal = (!empty($file_lampiran)) ? '<button type="button" class="btn btn-danger btn-xs hapus-dokumen" data-dokumen="file_lampiran" data-file="'.$file_lampiran.'">hapus</button>' : '' ;?>
                                </td>
                            </tr>
                          </table>
			        </form>
                    </div>                        
                </div>
                <div>&nbsp;</div>
                <div class="form-group" id="tr_clone">
                    <label for="waktu" class="col-sm-3 control-label" style="text-align:right">Waktu Pemakaian :  </label>
                    <div class="col-sm-9 add-jadwal">
                        <table>
                            <tr>
                                <td width="25px" style="text-align:center"></td>
                                <td width="97px" style="text-align:center">Lokasi/Area/Ruangan</td>
                                <td width="175px" style="text-align:center">Tanggal</td>
                                <td width="10px">&nbsp;</td>
                                <td width="10px" style="text-align:center" colspan="2">Mulai</td>
                                <td width="25px">&nbsp;</td>
                                <td width="10px" style="text-align:center"colspan="2">Selesai</td>
                                <td></td>
                            </tr>
                            <?php print_r(cetak_jadwal($ruang, $data_jadwal)); ?>
                        </table>
                    </div>      
                </div>

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div id="edit_jadwal" class="col-sm-9"></div>
                </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-3 col-sm-3"></div>
                <div class="col-md-9 col-sm-9" style="padding-left:35px">
                    <button id="edit_add_row" class='btn-xs btn btn-success'>Tambah Jadwal</button>
                    <button id="edit_del_row" class='btn-xs btn btn-danger'>Hapus Jadwal</button>
                    <button id="edit_clear"class='btn-xs btn btn-warning'>Reset</button>
                </div>
            </div>                
        </div>    
            
            
                <div class="pesan-bentrok-edit"></div>
                <div>&nbsp;</div>
                <div class="form-group">
                    <label for="kebutuhan" class="col-sm-3 control-label" style="text-align:right">Kebutuhan Tambahan :  </label>
                    <div class="col-sm-9">
                        <input type="text" id="edit_kebutuhan" name="edit_kebutuhan" placeholder="Kebutuhan Tambahan" class="form-control input-md" value="<?=$kebutuhan?>" required="">
                    </div>                        
                </div>
                
                <div class="form-group">
                    <label for="catatan" class="col-sm-3 control-label" style="text-align:right">Catatan :  </label>
                    <div class="col-sm-9">
                        <textarea id="edit_catatan" name="edit_catatan" placeholder="Catatan" class="form-control input-md" required="" rows="4"><?=$catatan?></textarea>
                    </div>                        
                </div>
                <div id="tester"></div>
                <div id="tester2"></div>
            </div><!-- /.Bagian Untuk Diisi Pemohon -->
        </div> 
        <hr>            
          
    </div>
    <div class="pesan"></div>
    <div class="box-footer">
        <div class="alert-pesan alert alert-success" role="alert" style="display:none">Data sudah disimpan..</div>
        <div id="process-info" style="display:none; text-align:center"><img src="<?=base_url();?>assets/images/spinner.gif"/></div>
        <span id="alert-riwayat" class="alert alert-success" role="alert" role="alert" style="display:none">Data sudah disimpan..</span>
        <button type="button" class="btn btn-danger tutup" data-dismiss="modal">Tutup</button>
        <span><button class="update btn btn-info pull-right">Simpan</button></span> <!--   
        <span><button class="test btn btn-info pull-right">test</button></span> -->
    </div>    

</section>

<?=include(APPPATH.'views/kemahasiswaan/formBookingEditScript.php');?> 