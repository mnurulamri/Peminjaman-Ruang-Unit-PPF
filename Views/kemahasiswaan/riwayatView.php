<?php
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $hak_akses = ($this->session->userdata['logged_in']['hak_akses']);
    
    $kode_org = ($this->session->userdata['logged_in']['kode_org']);
} else {
    $hak_akses = 0;
}

if (count($data_user)==0) {
        $nama_peminjam  = '';
        $id_peminjam    = '';
        $prodi          = '';
        $no_telp        = '';
        $email          = '';
} elseif(count($data_user)>0 ) {
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

foreach ($data_org as $v){
	$nip = $v['nip'];
	$pejabat_dep = $v['nama'];
}

foreach ($nama_dep as $v){
	$nama_dep = $v['departemen'];
}
print_r($nama_dep);
?>

<input type="hidden" id="v_nip" value="<?=$nip?>" />
<input type="hidden" id="v_pejabat_dep" value="<?=$pejabat_dep?>" />
<input type="hidden" id="v_nama_dep" value="<?=$nama_dep?>" />

<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url();?>assets/AdminLTE/plugins/datepicker/datepicker3.css">
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
<div class="modal fade form-booking-add" id="modal-form-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="form-add">
            <?=include(APPPATH.'views/kemahasiswaan/formBookingAddView.php');?> 
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
            <div id="dok-view">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-8" style="text-align:center">
        <button class="btn btn-success btn-sm" data-toggle="modal" data-target=".form-booking-add" id="form-booking"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<b style="font-size:14px">Booking</b></button> 
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
<?=$form_script?>
<script src="<?=base_url();?>assets/AdminLTE/plugins/ckeditor/ckeditor.js"></script>
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

$(document).ready(function() 
{
	$('#nip').hide();
    	$('#pejabat_dep').hide();
    	$('#label-pejabat').hide();
	
    $("#example1").DataTable({
        scrollX:true
    });

    $(document).on('hidden.bs.modal', '.modal', function(){    
        fetch_data();
    });

    $(document).on("click", ".edit-kegiatan", function(){
        var nomor =  $(this).attr('id')

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>kemahasiswaan/formBookingEdit/getData",      
            data: {nomor:nomor},
            success: function(res) {
                if (res){
                    $("#form-edit").html('').html(res);
                } else {
                    $("#event_name").html('ada error');
                }
            }
        })
    })

    $(document).on('click', '.del_kegiatan', function(){
        var event_name = $(this).attr('rel')
        var r = confirm('Anda Yakin akan menghapus data kegiatan ' + event_name )
        if(r == true){
            var nomor = $(this).attr('id')
            $.ajax({
                type: 'POST',
                url: "<?=base_url()?>kemahasiswaan/formBooking/deleteKegiatan",
                data:{nomor:nomor},
                success: function(data){
                    alert('data sudah didelete')
                    
                    console.log(data)
                }
            })
            fetch_data();
        }        
    })

    $(document).on('click', '.view-dok', function(){
        var ext_file = $(this).data("ext")
        var nama_file = $(this).data("file")
        
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
        //
        var event_id    = $(this).attr('id');
        var link_url = '<div style="text-align:center"><embed src=<?=base_url()?>assets/pdf_viewer/web/viewer.html?file=<?=base_url()?>kemahasiswaan/formPdf/' + nomor + ' width="350" height="570"></div>'
        alert(link_url)
        //window.location.assign("<?=base_url()?>" + "penggunaan/formPdf/ruangRapat/" + event_id);
    });

    $(document).on('click', '.view_confirm', function(){
        var array = $(this).attr('id').split('|');
        var nomor = array[0];
        var username    =array[1];
        
        $("#modal-dokumen").modal("show")

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>" + "kemahasiswaan/formPdf/konfirmasiCetak",  
    		//url: "<?=base_url()?>" + "kemahasiswaan/riwayatPinjamMhs/getDataKonfirmasi",  
            data: {nomor:nomor, username:username},
            success: function(res) {
                //$(".modal-dialog").html(res);
                if (res){                  
                  $("#dok-view").html(res)
                  //$(".modal-content").html(res);
                } else {
                    $("#event_name").html('ada error');
                }
            }
        });
    });
  
    $(document).on('click', '.cetak', function(){
        var array = $(this).attr('id').split('_');
        var nomor = array[0];
        var username    =array[1];

        var r = confirm('Apakah data yang diinput sudah benar? Mencetak form akan menghilangkan fungsi udpate data!');
        if(r==true){
            $.ajax({
                type: 'POST',
                url: "<?=base_url()?>" + "administrasi/ruang/disableCrud",
                data:{event_id:nomor , username:username},
                success: function(data){
                  //$("#dok-view").html(window.location.assign("<?=base_url()?>" + "kemahasiswaan/formPdf/ruangRapat/" + nomor))
                  //$("#modal-dokumen").modal("hide")
					$('#crud_view_'+nomor).html('<span><i id='+nomor+' class="view_final '+nomor+' fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red; cursor:pointer; width:20px"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;'); 
       		 /*
       			$.ajax({
       				type: 'POST',
       				data: {nomor:nomor},
                		url: "<?=base_url()?>" + "assets/pdf_viewer/web/viewer.html?file="+"<?=base_url()?>" + "kemahasiswaan/formPdf/test",
                		success: function(res){
                			$("#modal-dokumen").modal("show")
      					$("#dok-view").html(res)
                		}
       			})
       		*/
       			//$("#modal-dokumen").modal("show")
					$("#dok-view").html('<div style="text-align:center"><embed src=<?=base_url()?>assets/pdf_viewer/web/viewer.html?file=<?=base_url()?>kemahasiswaan/formPdf/test/' + nomor + ' width="100%" height="570"></div>')
   			
					
      
                    //window.location.assign("<?=base_url()?>" + "kemahasiswaan/formPdf/ruangRapat/" + nomor);
                    
          			//window.open("<?=base_url()?>" + "penggunaan/formPdf/ruangRapat/" + nomor,'_blank');
                }
            });
        }
        //setelah pdf didownload tutup modal
        //$('.tutup-konfirm-cetak').trigger('click');
   });
   
   $(document).on('click', '.testing', function(){
    var nomor = $(this).attr('id').split('_');
    var link_url = '<div style="text-align:center"><embed src=<?=base_url()?>assets/pdf_viewer/web/viewer.html?file=<?=base_url()?>kemahasiswaan/formPdf/' + nomor + ' width="350" height="570"></div>'
    //alert(link_url)
    //$("#modal-dokumen").modal("show")
    //$("#dok-view").html('<div style="text-align:center"><embed src=<?=base_url()?>kemahasiswaan/formPdf/cek/' + nomor + ' width="350" height="570"></div>')
    //$("#dok-view").html('<div style="text-align:center"><embed src=<?=base_url()?>assets/pdf_viewer/web/viewer.html?file=<?=base_url()?>kemahasiswaan/formPdf/cetakIzinKegiatan/' + nomor + ' width="100%" height="850"></div>')
   	window.open("<?=base_url()?>" + "kemahasiswaan/formPdf/cetakIzinKegiatan/" + nomor, '_blank');
  })

	//update tgl 6 sept
  //pengesahan organisasi mahasiswa
  $(document).on('click', '.organisasi_mhs', function(){
    var kode_org_mhs = $(this).val()
    var nama_org_mhs = $(this).data("nama-org")
	var nip = $("#v_nip").val()
	var pejabat_dep = $("#v_pejabat_dep").val()
	var nama_dep = $("#v_nama_dep").val()
    $("#nama_organisasi").text(nama_org_mhs)
    if(kode_org_mhs == 'hm'){
    	$("#nip").val(nip)
    	$("#pejabat_dep").val(pejabat_dep)
    	$("#nama_dep").val(nama_dep)
    	$("#nama_organisasi").text(nama_org_mhs + ' Departemen ' + nama_dep)
    	$('#nip').show();
    	$('#pejabat_dep').show();
    	$('#label-pejabat').show();
	} else {
		$("#nip").val("")
    	$("#pejabat_dep").val("")
    	$("#nama_dep").val("")
    	$("#nama_organisasi").text(nama_org_mhs)
    	$('#nip').hide();
    	$('#pejabat_dep').hide();
    	$('#label-pejabat').hide();
	}
  });
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