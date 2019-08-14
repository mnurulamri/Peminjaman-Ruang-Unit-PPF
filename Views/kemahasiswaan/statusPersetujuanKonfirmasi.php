<?php
//echo '<pre>';
//print_r($data_kegiatan);
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
}

//set enable browse file
$disabled_file_tor = (!empty($file_tor)) ? 'disabled' : '';
$disabled_file_rundown = (!empty($file_rundown)) ? 'disabled' : '';
$disabled_file_undangan = (!empty($file_undangan)) ? 'disabled' : '';
$disabled_file_lampiran = (!empty($file_lampiran)) ? 'disabled' : ''; 
?>

<input type="hidden" id="nomor" name="nomor" class="form-control" size="5" value="<?=$nomor?>"/>
<section class="content" style="background: #ededed">
    <!-- Bagian Untuk Diisi Pemohon -->
    <div class="box box-warning" style="font-size:12px">        
        <div class="box-header with-border" style="text-align:center">
            <b class="box-title">Bagian Untuk Diisi Pemohon</b>
        </div>

        <div class="row line">
            <label class="col-sm-3 control-label" style="text-align:right">Identitas :  </label>
            <div class="col-md-9 col-md-9">
                <?=checkbox_entitas($data_kegiatan_entitas)?>      
            </div> 
        </div>
        <div class="row line">
            <label class="col-sm-3 control-label" style="text-align:right">Tanggal :  </label>
            <div class="col-md-9 col-md-9">
                <?=dbToTanggal($tgl_permohonan)?>      
            </div> 
        </div>
        <div class="row line">
            <label class="col-sm-3 control-label" style="text-align:right">Identitas :  </label>
            <div class="col-md-9 col-md-9">
                <?=checkbox_entitas($data_kegiatan_entitas)?>      
            </div> 
        </div>
        <div class="row line">
            <label class="col-sm-3 control-label" style="text-align:right">PAF/Dept/Prog/HM :  </label>
            <div class="col-md-9 col-md-9">
                <?=$prodi?>      
            </div> 
        </div>
        <div class="row line">
            <label class="col-sm-3 control-label" style="text-align:right">Penanggung Jawab :  </label>
            <div class="col-md-9 col-md-9">
                <?=$nama_peminjam?>  
            </div> 
        </div>
        <div class="row line">
            <label class="col-sm-3 control-label" style="text-align:right">No. Telepon :  </label>
            <div class="col-md-9 col-md-9">
                <?=$no_telp?>
            </div> 
        </div>
        <div class="row line">
            <label class="col-sm-3 control-label" style="text-align:right">e-Mail :  </label>
            <div class="col-md-9 col-md-9">
                <?=$email?>
            </div> 
        </div>
    </div>          
    <!-- Data Kegiatan -->

	<div class="box box-warning" style="font-size:12px">        
        <div class="box-header with-border" style="text-align:center">
            <b class="box-title">Data Kegiatan</b>
        </div>
        <div class="row line">
            <label for="kategori" class="col-sm-3 control-label" style="text-align:right">Kategori :  </label>
            <div class="col-md-9 col-md-9">
                <!-- checkbox -->  
                <?=checkbox_kategori($data_kegiatan_kategori)?>       
            </div> 
		</div>
		<div class="row line">
            <label for="jenis" class="col-sm-3 control-label" style="text-align:right">Jenis :  </label>
            <div class="col-md-9 col-md-9">
                <!-- checkbox -->
                <?=checkbox_jenis($data_kegiatan_jenis)?>                    
            </div>    			
		</div>
        <div class="row line">
            <label for="nama_kegiatan" class="col-sm-3 control-label" style="text-align:right">Nama Kegiatan :  </label>
            <div class="col-sm-9" id="nama_kegiatan">
                <?=$event_name?>
            </div>                        
        </div>
        <div class="row line">
            <label for="tema" class="col-sm-3 control-label" style="text-align:right">Tema Kegiatan:  </label>
            <div class="col-sm-9">
                <?=$tema?>
            </div>                        
        </div>
        <div class="row line">
            <label for="deskripsi" class="col-sm-3 control-label" style="text-align:right">Deskripsi Kegiatan:  </label>
            <div class="col-sm-9">
                <?=$deskripsi?>
            </div>                        
        </div>
        <div class="row line">
            <label for="tujuan" class="col-sm-3 control-label" style="text-align:right">Tujuan Kegiatan:  </label>
            <div class="col-sm-9">
                <?=$tujuan?>
            </div>                        
        </div>
        <div class="row line">
            <label for="pengisi_acara" class="col-sm-3 control-label" style="text-align:right">Pengisi Acara:  </label>
            <div class="col-sm-9">
                <?=$pengisi_acara?>
            </div>                        
        </div>
        <div class="row line">
            <label for="peserta" class="col-sm-3 control-label" style="text-align:right">Peserta :  </label>
            <div class="col-md-9 col-md-9">
                <!-- checkbox -->
                <?=checkbox_peserta($data_kegiatan_peserta)?>
            </div>                        
        </div>
        <div class="row line">
            <label for="jml_peserta" class="col-sm-3 control-label" style="text-align:right">Jumlah Peserta :  </label>
            <div class="col-sm-9">
                <?=$jml_peserta?>
            </div>                        
        </div>
	    <div class="row line">
	        <label for="file" class="col-sm-3 control-label" style="text-align:right">Lampiran :<br>Wajib Melampirkan dokumen terkait</label>
	        <div class="col-sm-9">
	          <form id="edit_upload_form" enctype="multipart/form-data" method="post">
	              <table class="table">
	                <tr>
	                    <td>TOR Acara/Kegiatan</td>
                        <?php
                        if ($file_tor!='') {
                            echo '<td id="file_tor" class="nama_file view-dok" data-file="'.$file_tor.'" data-ext="'.ekstensi_file($file_tor).'">'.$file_tor.'</td>';
                        } else {
                            echo '<td></td>';
                        }
                        
                        ?>
	                    <!--<td id="file_tor" class="nama_file view-dok" data-file="<?=$file_tor?>" data-ext="<?=ekstensi_file($file_tor)?>"><?=$file_tor?></td>-->
	                </tr>
	                <tr>
	                    <td>Rundown Acara/Kegiatan</td>
                        <?php
                        if ($file_rundown!='') {
                            echo '<td id="file_rundown" class="nama_file view-dok" data-file="'.$file_rundown.'" data-ext="'.ekstensi_file($file_rundown).'">'.$file_rundown.'</td>';
                        } else {
                            echo '<td></td>';
                        }
                        ?>
	                    <!--<td id="file_rundown" class="nama_file view-dok" data-file="<?=$file_rundown?>" data-ext="<?=ekstensi_file($file_rundown)?>"><?=$file_rundown?></td>-->
	                </tr>
	                <tr>
	                	<td>Undangan Resmi</td>
                        <?php
                        if ($file_undangan!='') {
                            echo '<td id="file_undangan" class="nama_file view-dok" data-file="'.$file_undangan.'" data-ext="'.ekstensi_file($file_undangan).'">'.$file_undangan.'</td>';
                        } else {
                            echo '<td></td>';
                        }
                        ?>
	                    <!--<td id="file_undangan" class="nama_file view-dok" data-file="<?=$file_undangan?>" data-ext="<?=ekstensi_file($file_undangan)?>"><?=$file_undangan?></td>-->
	                </tr>
	                <tr>
	                    <td>Lampiran Penting Lainnya</td>
                        <?php
                        if ($file_lampiran!='') {
                            echo '<td id="file_lampiran" class="nama_file view-dok" data-file="'.$file_lampiran.'" data-ext="'.ekstensi_file($file_lampiran).'">'.$file_lampiran.'</td>';
                        } else {
                            echo '<td></td>';
                        }
                        ?>
	                    <!--<td id="file_lampiran" class="nama_file view-dok" data-file="<?=$file_lampiran?>" data-ext="<?=ekstensi_file($file_lampiran)?>"><?=$file_lampiran?></td>-->
	                </tr>
	              </table>
	        </form>
	        </div>                        
	    </div>
        <div class="row line" id="tr_clone">
            <label for="waktu" class="col-sm-3 control-label" style="text-align:right">Waktu Pemakaian :  </label>
            <div class="col-sm-9 add-jadwal">
                <table class="table">
                    <tr>
                        <th width="97px" style="text-align:center">Lokasi/Area/Ruangan</th>
                        <th width="175px" style="text-align:center">Tanggal</th>
                        <th width="25px" style="text-align:center">Waktu</th>
                    </tr>
                    <?php print_r(cetak_jadwal_konfirmasi($ruang, $data_jadwal)); ?>
                </table>
            </div>      
        </div> 
        <div class="row line">
            <label for="kebutuhan" class="col-sm-3 control-label" style="text-align:right">Kebutuhan Tambahan :  </label>
            <div class="col-sm-9">
               <?=$kebutuhan?>
            </div>                        
        </div>
        
        <div class="row line">
            <label for="catatan" class="col-sm-3 control-label" style="text-align:right">Catatan :  </label>
            <div class="col-sm-9">
               <?=$catatan?>
            </div>                        
        </div>              
    </div>
    <div class="pesan"></div>
    <div class="box-footer">
        <div class="pesan" class="alert alert-success" role="alert"></div>
        <div id="process-info" style="display:none; text-align:center"><img src="<?=base_url();?>assets/images/spinner.gif"/></div>
        <span id="alert-riwayat" class="alert alert-success" role="alert" role="alert" style="display:none">Data sudah disimpan..</span>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <span><button class="setujui btn btn-info pull-right">Setujui</button></span>
        <span><button class="tolak_kegiatan btn btn-info pull-right" data-toggle="modal" >Tolak</button></span>
        <span><button class="tunda_kegiatan btn btn-info pull-right" data-toggle="modal" >Tunda</button></span>
    </div>   

</section>

<style type="text/css">
.line{
    border-bottom: 1px solid #ededed;
}
</style>