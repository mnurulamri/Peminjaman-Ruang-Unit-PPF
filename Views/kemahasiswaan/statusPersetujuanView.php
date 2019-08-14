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
<!-- modal -->
<div class="modal fade verifikasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="verifikasi">
    <div class="modal-dialog modal-lg">
       <div class="modal-body">
       	<div id="verifikasi-view">
            </div>
		</div>
    </div>
</div>
<div class="modal fade tolak" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="tolak">
    <div class="modal-dialog modal-lg">
    	<div class="modal-content">
	    	<div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	          <h4 class="modal-title">Alasan Penolakan</h4>
	        </div>
	       <div class="modal-body">
	       	<div id="tolak-view">
	       		<div class="alasan">Alasan Penolakan</div>
	       		<textarea id="alasan_tolak" name="alasan_tolak" placeholder="Alasan Penolakan" class="form-control input-md" required="" rows="4"></textarea>
	            </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button class="simpan btn btn-info pull-right" id="simpan-alasan-tolak">Simpan</button>
        	</div>
		</div>
    </div>
</div>
<div class="modal fade tunda" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="tunda">
    <div class="modal-dialog modal-lg">
    	<div class="modal-content">
	    	<div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	          <h4 class="modal-title">Alasan Penundaan</h4>
	        </div>
	       <div class="modal-body">
	       	<div id="tunda-view">
	       		<div class="alasan"> Alasan Penundaan</div>
	       		<textarea id="alasan_tunda" name="alasan_tunda" placeholder="Alasan Penundaan" class="form-control input-md" required="" rows="4"></textarea>
	            </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
          	<button class="simpan btn btn-info pull-right" id="simpan-alasan-tunda">Simpan</button>
        	</div>
		</div>
    </div>
</div>
<div class="modal fade dokumen" id="modal-dokumen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Dokumen</h4>
            </div>
            <div class="modal-body">
                <div id="dok-view">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
            </div>            
        </div>
    </div>
</div>

<div class="container">
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
<script src="<?=base_url();?>assets/AdminLTE/plugins/ckeditor/ckeditor.js"></script>
<script>
function fetch_data()  
{  
    page_num = 0;
    var keywords = "";
    var sortBy = "desc";
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/kemahasiswaan/statusPersetujuan/ajaxRiwayatPinjam/'+page_num,
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
        url: '<?php echo base_url(); ?>index.php/kemahasiswaan/statusPersetujuan/ajaxRiwayatPinjam/'+page_num,
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

$(document).ready(function() 
{
    $("#example1").DataTable({
        scrollX:true
    });

CKEDITOR.replace('alasan_tolak')
CKEDITOR.replace('alasan_tunda')

    /*$(document).on('hidden.bs.modal', '.modal', function(){    
        fetch_data();
    });*/

    $(document).on('click', '.status', function(){ 
        var id = $(this).attr('id');
        id = id.split('_');
        var nomor = id[1];
        alert(nomor);
        $(".verifikasi").modal("show")
        //$('.modal-content').html(id);
        //
        //var url = "<?=base_url()?>" + peminjaman/statusPinjam/ruangRapat;
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>" + "kemahasiswaan/statusPersetujuan/getData",      
            data: {nomor:nomor},
            success: function(res) {
                //$(".modal-dialog").html(res);
                if (res){
                    $("#verifikasi-view").html(res);
                } else {
                    $("#event_name").html('ada error');
                }
            }
        });
        
    });

    $(document).on('click', '.view-dok', function(){
        var ext_file = $(this).data("ext")
        var nama_file = $(this).data("file")
        alert(ext_file+' '+nama_file)
        $.ajax({
            type: 'POST',
            url: "<?=base_url()?>" + "kemahasiswaan/riwayatPinjamMhs/viewDokumen",
            data:{ext_file:ext_file, nama_file:nama_file},
            success: function(data){
              $("#modal-dokumen").modal("show")
              $("#dok-view").html(data)
            }
        })        
    })

    $(document).on('click', '.view_final', function(){
        alert("test")
        //var event_id    = $(this).attr('id');
        //alert(event_id)
        //window.location.assign("<?=base_url()?>" + "penggunaan/formPdf/ruangRapat/" + event_id);
    })

    /*$(document).on('click', '.status', function(){
        $('#verifikasi').modal({
            show: true
        })
    })*/

    $(document).on("click", ".tolak_kegiatan", function(){
        $('#tolak').modal({
            show: true
        })
        //$("#tolak-view").html("tolak") 
    })
    
    $(document).on("click", ".tunda_kegiatan", function(){
        $('#tunda').modal({
            show: true
        })
        //$("#tunda-view").html("tunda") 
    })
    
    $(document).on("click", "#simpan-alasan-tolak", function(){
        var nomor = $("#nomor").val()
        var alasan = CKEDITOR.instances.alasan_tolak.getData()
        var nama_kegiatan = $("#nama_kegiatan").html()
        var r = confirm('Anda yakin akan melakukan penolakan untuk kegiatan '+ nama_kegiatan +'?');
	    if(r == true){
	        $.ajax({
	            type: "POST",
                dataType: "json",
	            url: "<?=base_url()?>" + "kemahasiswaan/statusPersetujuan/statusKonfirmasiPersetujuan",      
	            data: {nomor:nomor, alasan:alasan, jenis_persetujuan:"tolak"},
	            success: function(res) {            
	                if (res){
                        alert("Izin Kegiatan Telah di Tolak")
                        $("#tolak").modal("hide")
                        $("#verifikasi").modal("hide")
                        $("#status_"+nomor).html(res["keterangan"])
	                } else {
                        alert("ada error")
                    }
	            }
	        })
		}
    })
    
    $(document).on("click", "#simpan-alasan-tunda", function(){
    	var nomor = $("#nomor").val()
        var alasan = CKEDITOR.instances.alasan_tunda.getData()
        var nama_kegiatan = $("#nama_kegiatan").html()
        var r = confirm('Anda yakin akan melakukan penundaan untuk kegiatan '+ nama_kegiatan +'?');
        if(r == true){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url()?>" + "kemahasiswaan/statusPersetujuan/statusKonfirmasiPersetujuan",      
                data: {nomor:nomor, alasan:alasan, jenis_persetujuan:"tunda"},
                success: function(res) {
                    if (res){
                        alert("Izin Kegiatan Telah di Tunda")
                        $("#tunda").modal("hide")
                        $("#verifikasi").modal("hide")
                        $("#status_"+nomor).html(res["keterangan"])
                    } else {
                        alert("ada error")
                    }
                }
            })
        }
    })
    
    $(document).on("click", ".setujui", function(){
    	var nomor = $("#nomor").val()
    	var nama_kegiatan = $("#nama_kegiatan").html()
        var r = confirm('Anda yakin akan memberikan persetujuan untuk kegiatan '+ nama_kegiatan +'?');
	    if(r == true){
	        $.ajax({
	            type: "POST",
                dataType: "json",
	            url: "<?=base_url()?>" + "kemahasiswaan/statusPersetujuan/statusKonfirmasiPersetujuan",      
	            data: {nomor:nomor, jenis_persetujuan:"setuju"},
	            success: function(res) {            
	                if (res){
                        alert("Izin Kegiatan Telah di Setujui")
                        $("#status_"+nomor).html(res["keterangan"])
                    } else {
                        alert("ada error")
                    }
	            }
	        })
		}
    })

   $(document).on('click', '.testing', function(){
    var nomor = $(this).attr('id').split('_');
    var link_url = '<div style="text-align:center"><embed src=<?=base_url()?>assets/pdf_viewer/web/viewer.html?file=<?=base_url()?>kemahasiswaan/formPdf/test' + nomor + ' width="350" height="570"></div>'
    //alert(link_url)
    $("#modal-dokumen").modal("show")
    $("#dok-view").html('<div style="text-align:center"><embed src=<?=base_url()?>assets/pdf_viewer/web/viewer.html?file=<?=base_url()?>kemahasiswaan/formPdf/test/' + nomor + ' width="100%" height="570"></div>')
    //$("#dok-view").html('<div style="text-align:center"><embed src=<?=base_url()?>kemahasiswaan/formPdf/cek/' + nomor + ' width="350" height="570"></div>')                   
  })
    
    /*
    $(document).ready(function() {  //blm berfungsi
		$('.setujui').unbind('click').click(function(){
	    var nama_kegiatan = $('#nama_kegiatan').val();
	    var id_kegiatan = $('#id_kegiatan').val();
		var nomor = $('#nomor').val();
	    var status = $('#status').val();
	    var status_id = 'status_'+nomor;
	    var no_surat_tag = 'no_surat_'+nomor;
	    var no_surat = $('#no_surat').val();
	    //alert(status_id + ' ' + nama_kegiatan +' '+ id_kegiatan +' '+ no_surat)
	
	    //rubah status ke hak akses yang lebih tinggi
	    if(status == 1){
	        status = 2;
	    } else if(status == 2){
	        status = 3;
	    } else {
	        status = 1;
	    }
	
	    var pesan;
	    var r = confirm('Anda yakin akan memberikan persetujuan untuk kegiatan '+ nama_kegiatan +'?');
	    if(r == true){
	        //alert(status_id + ' ' + nama_kegiatan +' '+id_kegiatan)
	        $.ajax({
	            type: "POST",
	            url: "<?=base_url()?>" + "penggunaan/ruangRapat/statusKonfirmasiPersetujuan",      
	            data: {id_kegiatan:id_kegiatan, status:status, no_surat:no_surat},
	            success: function(res) {            
	                if (res){
	                	res_array = res.split("|");
	                    $('#'+status_id).html(res_array[1]);
	                    $('#'+no_surat_tag).html(res_array[0]);
	                } else {
	                    $(".pesan").html('ada error');
	                }
	            }
	        });
	    } 
	
	    //$('.pesan').html('testing');
    });*/
})

</script>
<style type="text/css">
.operator{
  cursor:pointer;
}
.day{padding-left:3px; width:150px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee}
.time{width:80px; vertical-align:top; padding-bottom:5px; border-bottom:1px solid #eee}
table tr td, th {font-size:11px; font-family:arial;}
table tr td div {border-bottom:1px solid #eee;}
</style>