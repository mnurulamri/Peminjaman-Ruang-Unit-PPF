<?php
//echo '<pre>';
//print_r($data_kegiatan);
//print_r($data_kegiatan_entitas);
//print_r($data_kegiatan_jenis);
//print_r($data_kegiatan_kategori);
//print_r($data_kegiatan_peserta);
//print_r($data_jadwal);
//echo '</pre>';

foreach ($data_kegiatan as $k => $v) {
    $nomor          = $v['nomor'];
    $nama_peminjam  = $v['nama_peminjam'];
    $id_peminjam    = $v['id_peminjam'];
    $prodi          = $v['prodi'];
    $tgl_permohonan = $v['tgl_permohonan'];
    $tgl_proses 	= $v['tgl_proses'];
    $catatan        = $v['catatan'];
    $details        = $v['details'];
    $jml_peserta    = $v['jml_peserta'];
    $no_telp        = $v['no_telp'];
    $email          = $v['email'];
}

//print_r(checkbox_entitas($data_kegiatan_entitas)) ;
?>
<input type="text" id="nomor" name="nomor" class="form-control" size="5" value="<?=$nomor?>"/>
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
            <b class="box-title">Bagian Untuk Diisi Pemohon</b>
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
                        <input type="text" id="edit_nama_kegiatan" name="edit_nama_kegiatan" placeholder="Nama Kegiatan" class="form-control input-md" required="">
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="tema" class="col-sm-3 control-label" style="text-align:right">Tema Kegiatan:  </label>
                    <div class="col-sm-9">
                        <textarea id="edit_tema" name="edit_tema" rows="5" cols="80"></textarea>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="deskripsi" class="col-sm-3 control-label" style="text-align:right">Deskripsi Kegiatan:  </label>
                    <div class="col-sm-9">
                        <textarea id="edit_deskripsi" name="edit_deskripsi" rows="5" cols="80"></textarea>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="tujuan" class="col-sm-3 control-label" style="text-align:right">Tujuan Kegiatan:  </label>
                    <div class="col-sm-9">
                        <textarea id="edit_tujuan" name="edit_tujuan" rows="5" cols="80"></textarea>
                    </div>                        
                </div>
                <div class="form-group">
                    <label for="pengisi_acara" class="col-sm-3 control-label" style="text-align:right">Pengisi Acara:  (Deskirpsikan background dan latar belakang pengisi acara) </label>
                    <div class="col-sm-9">
                        <textarea id="edit_pengisi_acara" name="edit_pengisi_acara" rows="10" cols="80"></textarea>
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
                        <input type="text" id="edit_jml_peserta" name="edit_jml_peserta" placeholder="Jumlah Peserta" class="form-control input-md" required="">
                    </div>                        
                </div>
                <div>&nbsp;</div>
                <div class="form-group">
                    <label for="file" class="col-sm-3 control-label" style="text-align:right">Lampiran :<br>Wajib Melampirkan dokumen terkait</label>
                    <div class="col-sm-9">
			          <form id="edit_upload_form" enctype="multipart/form-data" method="post">
				          <input type="hidden" name="action" id="action" value="test action">
				          <input type="hidden" name="post_foto" id="post_foto" value="test id foto">
                          <table>
                            <tr><td>TOR Acara/Kegiatan</td><td><input type="file" name="file_tor"></td></tr>
                            <tr><td>Rundown Acara/Kegiatan</td><td><input type="file" name="file_rundown"></td></tr>
                            <tr><td>Undangan Resmi</td><td><input type="file" name="file_undangan"></td></tr>
                            <tr><td>Lampiran Penting Lainnya</td><td><input type="file" name="file_lampiran"></td></tr>
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
                                <td width="150px" style="text-align:center">Tanggal</td>
                                <td width="10px">&nbsp;</td>
                                <td width="120px" style="text-align:center">Mulai</td>
                                <td width="25px">&nbsp;</td>
                                <td width="150px" style="text-align:center">Selesai</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div id="edit_jadwal" class="col-sm-9"></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <button id="edit_add_row" class='btn-xs btn btn-success'>Tambah Jadwal</button>
                        <button id="edit_del_row" class='btn-xs btn btn-danger'>Hapus Jadwal</button>
                        <button id="edit_clear"class='btn-xs btn btn-warning'>Reset</button>
                    </div>
                </div>
                <div class="pesan-bentrok"></div>
                <div>&nbsp;</div>
                <div class="form-group">
                    <label for="kebutuhan" class="col-sm-3 control-label" style="text-align:right">Kebutuhan Tambahan :  </label>
                    <div class="col-sm-9">
                        <input type="text" id="edit_kebutuhan" name="edit_kebutuhan" placeholder="Kebutuhan Tambahan" class="form-control input-md" required="">
                    </div>                        
                </div>
                
                <div class="form-group">
                    <label for="catatan" class="col-sm-3 control-label" style="text-align:right">Catatan :  </label>
                    <div class="col-sm-9">
                        <textarea id="edit_catatan" name="edit_catatan" placeholder="Catatan" class="form-control input-md" required="" rows="4"></textarea>
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
        <span><button class="simpan btn btn-info pull-right">Simpan</button></span> <!--   -->
    </div>        

	
</section>

<script>
//editor
CKEDITOR.replace('edit_tema')
CKEDITOR.replace('edit_deskripsi')
CKEDITOR.replace('edit_tujuan')
CKEDITOR.replace('edit_pengisi_acara')

$(".simpan").click(function()
{
    nomor      = $('#nomor').val()
    tgl_proses      = $('#tgl_proses').val()
    tgl_permohonan  = $('#edit_tgl_permohonan').val()
    //ruang           = $('#ruang').val();
    nama_kegiatan   = $('#edit_nama_kegiatan').val()
    jml_peserta     = $('#edit_jml_peserta').val()
    nama_peminjam   = $('#edit_nama_peminjam').val()
    id_peminjam      = $('#edit_id_peminjam').val()
    unit_kerja      = $('#edit_unit_kerja').val()
    no_telp         = $('#edit_no_telp').val()
    email           = $('#edit_email').val()
    kebutuhan       = $('#edit_kebutuhan').val()
    catatan         = $('#edit_catatan').val()

    entitas_lainnya = $('#edit_entitas-lainnya').val();
    jenis_lainnya = $('#jenis-lainnya').val();
    var entitas = $('.entitas:checked').map(function(_, el) {
        return $(el).val()
    }).get()

    var file = $("#edit_upload_form")[0] 
    var formData = new FormData(file)
    formData.append("nomor", nomor)
    formData.append("tgl_proses", tgl_proses)
    formData.append("tgl_permohonan", tgl_permohonan)
    formData.append("nama_kegiatan", nama_kegiatan)
    formData.append("nama_peminjam", nama_peminjam)
    formData.append("unit_kerja", unit_kerja)
    formData.append("id_peminjam", id_peminjam)
    formData.append("no_telp", no_telp)
    formData.append("email", email)
    formData.append("jml_peserta", jml_peserta)
    formData.append("kebutuhan", kebutuhan)
    formData.append("catatan", catatan)
        formData.append("entitas", entitas);
        formData.append("entitas_lainnya", entitas_lainnya);

    //update data dan jadwal kegiatan
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>" + "kemahasiswaan/formBookingEdit/simpan",
        data: formData,
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
            console.log(data)
            $(".alert-pesan").fadeIn();
            $(".alert-pesan").html(data);
            $(".alert-pesan").fadeOut(2300); 
        },
        complete: function(data) {
            //$("#modal-form").hie("hide");    
        }           
    })
})

var i = 1;
$("#edit_add_row").click(function()
{
    var formattedDate = "<?=today()?>"
    var ruang = '<?=$vruang?>'; 
        var text ='<tr>'+
                '<td class="form-inline">'+
                    '<input type="checkbox" class="check_box"/>&nbsp;&nbsp;'+
                    '<input type="hidden" id="event_id" name="event_id" class="event_id" value="">'+
                     ruang + '&nbsp;&nbsp;' +
                    '<input type="text" id="tgl_kegiatan" class="tgl_kegiatan form-control" name="tgl_kegiatan" size="10" value="'+formattedDate+'" placeholder="mm/dd/yyyy"/>&nbsp;&nbsp;'+
                        '<select name="jam_mulai" id="jam_mulai" class="jam_mulai form-control">'+
                            '<option value="08">08</option>'+
                            '<option value="09">09</option>'+
                            '<option value="10">10</option>'+
                            '<option value="11">11</option>'+
                            '<option value="12">12</option>'+
                            '<option value="13">13</option>'+                                 
                            '<option value="14">14</option>'+
                            '<option value="15">15</option>'+
                            '<option value="16">16</option>'+
                            '<option value="17">17</option>'+
                            '<option value="18">18</option>'+
                            '<option value="19">19</option>'+
                        '</select>'+
                        '<select name="menit_mulai" id="menit_mulai" class="menit_mulai form-control">'+
                            '<option value="00" selected >00</option>'+
                            '<option value="05">05</option>'+
                            '<option value="10">10</option>'+
                            '<option value="15">15</option>'+
                            '<option value="20">20</option>'+
                            '<option value="25">25</option>'+
                            '<option value="30">30</option>'+
                            '<option value="35">35</option>'+
                            '<option value="40">40</option>'+
                            '<option value="45">45</option>'+
                            '<option value="50">50</option>'+
                            '<option value="55">55</option>'+
                        '</select>&nbsp;-&nbsp;'+
                        '<select name="jam_selesai" id="jam_selesai" class="jam_selesai form-control">'+
                              '<option value="08">08</option>'+
                              '<option value="09">09</option>'+
                              '<option value="10">10</option>'+
                              '<option value="11">11</option>'+
                              '<option value="12">12</option>'+
                              '<option value="13">13</option>'+                                  
                              '<option value="14">14</option>'+
                              '<option value="15">15</option>'+
                              '<option value="16">16</option>'+
                              '<option value="17">17</option>'+
                              '<option value="18">18</option>'+
                              '<option value="19">19</option>'+
                              '<option value="20">20</option>'+
                              '<option value="21">21</option>'+
                        '</select>'+
                        '<select name="menit_selesai" id="menit_selesai" class="menit_selesai form-control">'+
                          '<option value="00" selected >00</option>'+
                          '<option value="05">05</option>'+
                          '<option value="10">10</option>'+
                          '<option value="15">15</option>'+
                          '<option value="20">20</option>'+
                          '<option value="25">25</option>'+
                          '<option value="30">30</option>'+
                          '<option value="35">35</option>'+
                          '<option value="40">40</option>'+
                          '<option value="45">45</option>'+
                          '<option value="50">50</option>'+
                          '<option value="55">55</option>'+
                        '</select>'+
                    '</td>'+
                '</tr>'; 

            $('#edit_jadwal').append(text);
            i++;
})

$("#edit_del_row").click(function()
{
    if(!$.trim($('#edit_jadwal').html()).length){
        alert ("Now table is empty")
    }else{
        $('#test').children('tr').find('input[type=checkbox]:checked').each(function () {
            $(this).closest('tr').remove()
        })

        $('#edit_jadwal').children('tr').find('input[type=checkbox]:checked').each(function () {
            $(this).closest('tr').remove()
        })
    }
})

$("#edit_clear").click(function()
{
    $('#test tr').empty();
    $('#edit_jadwal').empty();
})
</script>