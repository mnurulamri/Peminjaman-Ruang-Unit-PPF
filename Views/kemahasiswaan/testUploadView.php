<section class="content" >
    <div class="box box-warning">        
        <div class="box-header with-border" style="text-align:center">
            <b class="box-title">Bagian Untuk Diisi Pemohon</b>
        </div>
        <div class="row">
            <div class="col-md-12">

        <h3>Multiple Upload File Codeigniter</h3>
        <?php echo form_open_multipart('penggunaan/testUpload/multiple_upload'); ?>
        <table border="1">
            <tr><td>File 1</td><td><?php echo form_upload('file1'); ?></td></tr>
            <tr><td>File 2</td><td><?php echo form_upload('file2'); ?></td></tr>
            <tr><td></td><td><?php echo form_submit('upload', 'upload file'); ?></td></tr>
        </table>
        <?php echo form_close() ?>

                <div class="form-group">
                    <label for="file" class="col-sm-3 control-label" style="text-align:right">Lampiran : Wajib Melampirkan dokumen terkait</label>
                    <div class="col-sm-9">
			          <form id="upload_form" enctype="multipart/form-data" method="post">
				          <input type="file" name="file_upload_1"><br>
                          <input type="file" name="file_upload_2"><br><!---->
				          <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
				          <h3 id="status"></h3>
				          <p id="loaded_n_total"></p>
				          <p id="result"></p>
			        </form>

                    </div>                        
                </div>
            </div>
        </div>
    </div>
    <div id="tester"></div>
    <div class="box-footer">
        <span><button class="test-upload btn btn-info pull-right">Test Upload</button></span> <!--   -->
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
                              <input type="checkbox" name="entitas" class="entitas" id="individu" value="individu" checked>
                              Individu
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                              <input type="checkbox" name="entitas" class="entitas" id="lembaga" value="lembaga">
                              Lembaga
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                              <input type="checkbox" name="entitas" class="entitas" id="instansi" value="instansi">
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
            </div>
        </div>
    </div>
</section>

<?=$script?>

<script type="text/javascript">
$(document).ready(function() {
    $(".test-upload").click(function(){

        entitas_lainnya = $('#entitas-lainnya').val();
        var entitas = $('.entitas:checked').map(function(_, el) {
            return $(el).val()
        }).get()   
        var file = $("#upload_form")[0] 
        var formData = new FormData(file)
        var action = $("#jml_peserta").val()
        formData.append("entitas", entitas);
        formData.append("entitas_lainnya", entitas_lainnya);
        
        $.ajax({
            url: "<?=site_url('penggunaan/testUpload/upload')?>", // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: formData, //  -> Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data)   // A function to be called if request succeeds
            {                           
                console.log(data)
            }
        }); 
            return false;
    })
})
</script>