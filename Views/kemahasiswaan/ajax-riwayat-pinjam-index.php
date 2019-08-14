<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="modal fade verifikasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">test</div>
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
<?//=$script?>
<?php

function content_table($posts){
    foreach ($posts as $rows) {
        $tanggal = $rows['tgl'].' '.$rows['bulan'].' '.$rows['tahun'];
        echo '
        <tr>
            <td>'.$rows['id_kegiatan'].'</td>
            <td>'.$rows['event_name'].'</td>
            <td>'.$rows['prodi'].'</td>
            <td>'.$tanggal.'</td>
            <td>'.$rows['status'].'</td>
        </tr>';
    }
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
function fetch_data()  
{  
    page_num = 0;
    var keywords = "";
    var sortBy = "asc";
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

    $(document).on('click', '.status', function(){ 
        var id = $(this).attr('id');
        id = id.split('_');
        var nomor = id[1];
        
        $.ajax({
            type: "POST",
            //url: "<?=base_url()?>" + "peminjaman/statusPinjam/viewJadwalRapat",
            url: "<?=base_url()?>" + "penggunaan/ruangRapat/statusKonfirmasi",      
            data: {nomor:nomor},
            success: function(res) {
                //$(".modal-dialog").html(res);
                if (res){
                    $(".modal-content").html(res);
                } else {
                    $("#event_name").html('ada error');
                }
            }
        });
    });
});
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