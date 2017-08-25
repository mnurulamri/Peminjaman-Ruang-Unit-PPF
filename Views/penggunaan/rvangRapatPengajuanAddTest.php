<?
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $hak_akses = ($this->session->userdata['logged_in']['hak_akses']);
} else {
    $hak_akses = 0;
}

if (count($data_user)==0) {
        $nama_peminjam  = '';
        $id_peminjam    = '';
        $prodi          = '';
        $no_telp        = '';
        $email          = '';
} elseif(count($data_user)>0 && $hak_akses==0) {
    foreach ($data_user as $k => $v) {
        $nama_peminjam  = $v->nama_peminjam;
        $id_peminjam    = $v->id_peminjam;
        $prodi          = $v->prodi;
        $no_telp        = $v->no_telp;
        $email          = $v->user_email;
    }
} else {
    $nama_peminjam  = '';
    $id_peminjam    = '';
    $prodi          = '';
    $no_telp        = '';
    $email          = '';
}
?>

<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url();?>assets/AdminLTE/plugins/datepicker/datepicker3.css">

<section class="content" >
    <div class="box box-warning">
        <!-- Bagian Untuk Diisi Petugas Infrastruktur -->
        <div class="box-header with-border" style="text-align:center">
            <b class="box-title">Form Permohonan Peminjaman Ruang</b>
        </div>
        <div class="box-body">
            <div class="row">
				<!--
                <div class="col-md-12">
                    <input type="hidden" id="event_id" name="event_id"/>
                    <div class="form-group">
                        <label for="nomor" class="col-sm-3 control-label" style="text-align:right">Nomor</label>
                        <div class="col-sm-3">-->
                            <input type="hidden" id="nomor" name="nomor" value="<?php echo $nomor?>" placeholder="Nomor" class="form-control" required="">
                       <!-- </div>  
                        <div class="col-sm-6">
                            <?
                            $m = date('n');
                            $y = date('Y');
                            echo 'G.05/1/UN2.F9.D4.2/RTK.00/'.$m.'/'.$y;
                            ?>                        
                        </div>                         
                    </div><br>
                    <div class="form-group">
                        <label for="tgl_proses" class="col-sm-3 control-label" style="text-align:right">Tanggal</label>
                        <div class="col-sm-9">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>-->
                                <input type="hidden" id="tgl_proses" name="tgl_proses" class="form-control" size="5" value="<?php echo date('m/d/Y')?>"/>
                            <!--</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="nomor" class="col-sm-3 control-label" style="text-align:right">Lokasi/Area/Ruangan :</label>
                        <div class="col-sm-4">
                            <?php print_r($ruang) ?>
                        </div>
                    </div>  
                    -->                    
                </div>
            </div><!-- /.Bagian Untuk Diisi Petugas Infrastruktur -->

            <!-- Bagian Untuk Diisi Pemohon 
            <div class="box-header with-border" style="text-align:center">
                <b class="box-title">Bagian Untuk Diisi Pemohon</b>
            </div>-->

            <div class="well well-sm">
                <b>Data Kegiatan</b>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nama_kegiatan" class="col-sm-3 control-label" style="text-align:right">Nama Kegiatan :  </label>
                        <div class="col-sm-9">
                            <input type="text" id="nama_kegiatan" name="nama_kegiatan" placeholder="Nama Kegiatan" class="form-control input-md" required="">
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label for="jml_peserta" class="col-sm-3 control-label" style="text-align:right">Jumlah Peserta :  </label>
                        <div class="col-sm-9">
                            <input type="text" id="jml_peserta" name="jml_peserta" placeholder="Jumlah Peserta" class="form-control input-md" required="">
                        </div>                        
                    </div>
                    <!--
                    <div class="form-group">
                        <label for="tgl_kegiatan" class="col-sm-3 control-label" style="text-align:right">Tanggal Kegiatan :</label>
                        <div class="col-sm-9">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>                            
                                <input id="tgl_kegiatan" name="tgl_kegiatan" class="form-control">                                   
                            </div>
                        </div> 
                    </div>
                    -->
                    <div>&nbsp;</div>
                    <div class="form-group" id="tr_clone">
                        <label for="waktu" class="col-sm-3 control-label" style="text-align:right">Waktu Pemakaian :  </label>
                        <div class="col-sm-9 add-jadwal">
                            <table>
                                <tr>
                                    <td width="25px" style="text-align:center"></td>
                                    <td width="97px" style="text-align:center">Lokasi/Area/Ruangan</td>
                                    <td width="97px" style="text-align:center">Tanggal</td>
                                    <td width="10px">&nbsp;</td>
                                    <td width="82px" style="text-align:center">Mulai</td>
                                    <td width="25px">&nbsp;</td>
                                    <td width="82px" style="text-align:center">Selesai</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div id="jadwal" class="col-sm-9"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <button id="add_row" class='btn-xs btn btn-success'>Tambah Jadwal</button>
                            <button id="del_row" class='btn-xs btn btn-danger'>Hapus Jadwal</button>
                            <button id="clear"class='btn-xs btn btn-warning'>Reset</button>
                        </div>
                    </div>
                    <div class="pesan-bentrok"></div>
                    <div>&nbsp;</div>
                    <div class="form-group">
                        <label for="kebutuhan" class="col-sm-3 control-label" style="text-align:right">Kebutuhan Tambahan :  </label>
                        <div class="col-sm-9">
                            <input type="text" id="kebutuhan" name="kebutuhan" placeholder="Kebutuhan Tambahan" class="form-control input-md" required="">
                        </div>                        
                    </div>
                    
                    <div class="form-group">
                        <label for="catatan" class="col-sm-3 control-label" style="text-align:right">Catatan :  </label>
                        <div class="col-sm-9">
                            <textarea id="catatan" name="catatan" placeholder="Catatan" class="form-control input-md" required="" rows="4"></textarea>
                        </div>                        
                    </div>

                    <div id="tester"></div>
                    <div id="tester2"></div>
                </div><!-- /.Bagian Untuk Diisi Pemohon -->
            </div> 
            <hr>            
            <div class="well well-sm">
				<b>Data Pemohon</b>
            </div>
            <div class="row">
                <div class="col-md-12">
                     <div class="form-group">
                        <label for="tgl_permohonan" class="col-sm-3 control-label" style="text-align:right">Tanggal : </label>
                        <div class="col-sm-9">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?php echo date('m/d/Y')?>">
                            </div>
                        </div>
                    </div>               
                    <div class="form-group">
                        <label for="unit" class="col-sm-3 control-label" style="text-align:right">PAF/Dept/Prog/HM : </label>
                        <div class="col-sm-9">
                            <input type="text" id="unit_kerja" name="unit_kerja" value="<?=$prodi?>" placeholder="PAF/Dept/Prog/HM : " class="form-control input-md" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_peminjam" class="col-sm-3 control-label" style="text-align:right">Penanggung Jawab : </label>
                        <div class="col-sm-9">
                            <input type="text" id="nama_peminjam" name="nama_peminjam" value="<?=$nama_peminjam?>" placeholder="nama peminjam" class="form-control input-md" required="">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="id_peminjam" class="col-sm-3 control-label" style="text-align:right">NPM/NIP/NUP : </label>
                        <div class="col-sm-9">
                            <input type="text" id="id_peminjam" name="id_peminjam" value="<?=$id_peminjam?>" placeholder="NPM/NIP/NUP" class="form-control input-md" required="">
                        </div>
                    </div>   
                    <div class="form-group">
                        <label for="no_telp" class="col-sm-3 control-label" style="text-align:right">No. Telepon : </label>
                         <div class="col-sm-9">
                             <input type="text" id="no_telp" name="no_telp" value="<?=$no_telp?>" placeholder="Nomor Telepon" class="form-control input-md" required="">
                         </div>                        
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label" style="text-align:right">E-mail :</label>
                        <div class="col-sm-9">
                            <input type="text" id="email" name="email" value="<?=$email?>" placeholder="e-mail" class="form-control input-md" required="">
                        </div>                        
                    </div>          
                </div>
            </div>              
        </div>
       
        <div class="box-footer">
            <div class="alert-pesan alert alert-success" role="alert" style="display:none">Data sudah disimpan..</div>
            <div id="process-info" style="display:none; text-align:center"><img src="<?=base_url();?>assets/images/spinner.gif"/></div>
            <span id="alert-riwayat" class="alert alert-success" role="alert" role="alert" style="display:none">Data sudah disimpan..</span>
            <button type="button" class="btn btn-danger tutup" data-dismiss="modal">Tutup</button>
            <span><
