<?php
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

<div class="modal fade form-booking-add" id="modal-form-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="form-add">
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
                                                <input type="hidden" id="tgl_proses" name="tgl_proses" class="form-control" size="5" value="<?php echo date('m/d/Y')?>"/>
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
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="entitas" class="entitas" id="individu" value="Individu" checked>
                                              Individu
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="entitas" class="entitas" id="lembaga" value="Lembaga">
                                              Lembaga
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="entitas" class="entitas" id="instansi" value="Instansi/Lembaga Eksternal">
                                              Instansi/Lembaga Eksternal
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="entitas" class="entitas"value="lainnya">lainnya
                                            </label>
                                            <input type="text" id="entitas-lainnya" name="entitas-lainnya" placeholder="Lainnya" class="form-control input-md" required=""><button id="test">test</button>
                                        </div>                       
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="tgl_permohonan" class="col-sm-3 control-label" style="text-align:right">Tanggal : </label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?php echo $tanggal?>">
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
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="kategori" class="kategori" value="Penalaran" checked>
                                              Penalaran
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="kategori" class="kategori" value="Seni dan Budaya">
                                              Seni dan Budaya
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="kategori" class="kategori" value="Olahraga">
                                              Olahraga
                                            </label>
                                        </div>               
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="jenis" class="col-sm-3 control-label" style="text-align:right">Jenis :  </label>
                                    <div class="col-md-9 col-md-9">
                                        <!-- checkbox -->                           
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="jenis" class="jenis" value="Rapat" checked>
                                              Rapat
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="jenis" class="jenis" value="Seminar">
                                              Seminar
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="jenis" class="jenis" value="Pementasan Seni">
                                              Pementasan Seni
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="jenis" class="jenis" value="Pertandingan Olahraga">
                                              Pertandingan Olahraga
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="jenis" class="jenis" value="Instalasi/Pemasangan Alat Peraga">
                                              Instalasi/Pemasangan Alat Peraga
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="jenis" class="jenis" value="lainnya">
                                              Lainnya <input type="text" id="jenis-lainnya" name="jenis-lainnya" placeholder="Lainnya" class="form-control input-md" required="">
                                            </label>
                                        </div>                       
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="nama_kegiatan" class="col-sm-3 control-label" style="text-align:right">Nama Kegiatan :  </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="nama_kegiatan" name="nama_kegiatan" placeholder="Nama Kegiatan" class="form-control input-md" required="">
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="tema" class="col-sm-3 control-label" style="text-align:right">Tema Kegiatan:  </label>
                                    <div class="col-sm-9">
                                        <textarea id="tema" name="tema" rows="5" cols="80"></textarea>
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi" class="col-sm-3 control-label" style="text-align:right">Deskripsi Kegiatan:  </label>
                                    <div class="col-sm-9">
                                        <textarea id="deskripsi" name="deskripsi" rows="5" cols="80"></textarea>
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="tujuan" class="col-sm-3 control-label" style="text-align:right">Tujuan Kegiatan:  </label>
                                    <div class="col-sm-9">
                                        <textarea id="tujuan" name="tujuan" rows="5" cols="80"></textarea>
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="pengisi_acara" class="col-sm-3 control-label" style="text-align:right">Pengisi Acara:  (Deskirpsikan background dan latar belakang pengisi acara) </label>
                                    <div class="col-sm-9">
                                        <textarea id="pengisi_acara" name="pengisi_acara" rows="10" cols="80"></textarea>
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="peserta" class="col-sm-3 control-label" style="text-align:right">Peserta :  </label>
                                    <div class="col-md-9 col-md-9">
                                        <!-- checkbox -->                           
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="peserta" class="peserta" value="Internal FISIP UI" checked>
                                              Internal FISIP UI
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="peserta" class="peserta" value="Internal FISIP UI dan Universitas Indonesia">
                                              Internal FISIP UI dan Universitas Indonesia
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" name="peserta" class="peserta" value="Umum">
                                              Umum
                                            </label>
                                        </div>               
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <label for="jml_peserta" class="col-sm-3 control-label" style="text-align:right">Jumlah Peserta :  </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="jml_peserta" name="jml_peserta" placeholder="Jumlah Peserta" class="form-control input-md" required="">
                                    </div>                        
                                </div>
                                <div>&nbsp;</div>
                                <div class="form-group">
                                    <label for="file" class="col-sm-3 control-label" style="text-align:right">Lampiran :<br>Wajib Melampirkan dokumen terkait</label>
                                    <div class="col-sm-9">
                                      <form id="upload_form" enctype="multipart/form-data" method="post">
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
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-8" style="text-align:center">
        <button class="btn btn-success btn-sm" data-toggle="modal" data-target=".form-booking-add" id="form-booking"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<b style="font-size:14px">Booking</b></button> 
    </div> 
    <div class="col-sm-8" style="text-align:center">
        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-form-edit" id="form-booking-edit"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<b style="font-size:14px">Edit</b></button> 
    </div>  
</div>

<div class="container">
    <h1>Ajax Pagination with Search in CodeIgniter</h1>
    <div class="row">
        <div class="post-search-panel">
            <input type="text" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/>
            <select id="sortBy" onchange="searchFilter()">
                <option value="">Sort By</option>
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
        <div class="loading-overlay"><div class="overlay-content">Loading.....</div></div>
        <div class="post-list" id="postList"></div>
        <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/spinner.gif'; ?>"/></div></div>
    </div>
</div>

<?=$script?>
<script src="<?=base_url();?>assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?=base_url();?>assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.id.js"></script>
<?=$form_script?>


<!--form edit-->
<div class="modal fade form-booking-edit" id="modal-form-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="form-edit">
                <?//=include(APPPATH.'views/kemahasiswaan/formBookingEdit.php');?> 
            </div>           
        </div>
    </div>
</div>


<script>
function fetch_data()  
{  
    page_num = 0;
    var keywords = "";
    var sortBy = "desc";
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/kemahasiswaan/riwayatPinjamMhs/ajaxRiwayatPinjam/'+page_num,
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
        beforeSend: function () {
            $('.loading-overlay').show();
        },
        success: function (html) {
            $('#postList').html(html);
            $('.loading-overlay').fadeOut("slow");
        }
    });
}
fetch_data();
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/kemahasiswaan/riwayatPinjamMhs/ajaxRiwayatPinjam/'+page_num,
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (html) {
            $('#postList').html(html);
            $('.loading').fadeOut("slow");
        }
    });
}

$(function () {

    $(document).on('click', '#form-booking', function(){  
        //$(".modal-content").html('test');
    });

    $(document).on('hidden.bs.modal', '.modal', function(){    
        fetch_data();
        //$(".modal-content").html('');
    });

    $(document).on('click', '.edit-kegiatan', function(){
        var nomor =  $(this).attr('id');
        
        //$(".modal-content").remove();
        //$('.modal-dialog').html('<div class="modal-content"></div>');
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>" + "kemahasiswaan/formBookingEdit/getData",      
            data: {nomor:nomor},
            success: function(res) {
                $("#form-edit").html(res);
                /*if (res){
                    $("#form-edit").html('').html(res);
                } else {
                    $("#event_name").html('ada error');
                }*/
            }
        });
    });
})
</script>
<style type="text/css">
.day{padding-left:3px; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee}
.time{width:80px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee}
table tr td, th {font-size:11px; font-family:arial;}
table tr td div {border-bottom:1px solid #eee;}
/* status progress */
.containerx{
  width: 220px; /*100%;*/
  position: absolute;
  z-index: 1;
}
.progressbar li{
  float: left;
  width: 20%;
  position: relative;
  text-align: center;
  list-style: none;
}

.progressbar li:before{
  content:counter(step);
  counter-increment: step;
  width: 20px;
  height: 20px;
  border: 1px solid #bebebe;
  display: block;
  border-radius: 50%;
  background: white;
  color: #bebebe;
  text-align: center;
  /*font-weight: bold;    
  margin: 0 auto 10px auto;
    line-height: 27px;
  */
}
.progressbar{
  counter-reset: step;
}
.progressbar li:after{
  content: '';
  position: absolute;
  width:100%;
  height: 1px;
  background: #bebebe;
  top: 11px;
  left: -50%;
  z-index: -1;
}

.progressbar li.active:before {
  border-color: #3aac5d;
  /*background: #3aac5d;*/
  color: #3aac5d;
}
 .progressbar li.active:after {
  border-color: #3aac5d;
  background: #3aac5d;
  color: #3aac5d;
}
.progressbar li:first-child:after{
    content: none;
}
.progressbar li.kemahasiswaan.active:before{
  border-color: #3aac5d; /* circle */
}
.progressbar li.kemahasiswaan.active:after{
  border-color: #3aac5d;  /* line */
}
.progressbar li.koordinator.active:before{
  border-color: #fa0; /* circle */
}
.progressbar li.koordinator.active:after{
  background: #fa0;  /* line */
}
.progressbar li.manajer_ppf.active:before{
  border-color: purple;
}
.progressbar li.manajer_ppf.active:after{
  background: purple;
}
</style>