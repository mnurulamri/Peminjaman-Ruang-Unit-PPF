<script type="text/javascript">
//$.noConflict();
var ruang = ""; 
$(document).ready(function() {
    
    //rubah ke format indonesia
    $.fn.datepicker.defaults.autoclose = 'TRUE';
    $.fn.datepicker.defaults.language = 'id';
    $.fn.datepicker.defaults.format = "DD, dd MM yyyy";

    //editor
    CKEDITOR.replace('tema')
    CKEDITOR.replace('deskripsi')
    CKEDITOR.replace('tujuan')
    CKEDITOR.replace('pengisi_acara')

    //set tanggal hari ini
    $("#tgl_permohonan").datepicker({ dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
    $("#tgl_proses").datepicker({ dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());

    $('.simpan').unbind('click').click(function(){
        //nomor           = $('#nomor').val();
        tgl_proses      = $('#tgl_proses').val();
        tgl_permohonan  = $('#tgl_permohonan').val(); 
        //ruang           = $('#ruang').val();
        nama_kegiatan   = $('#nama_kegiatan').val();
        jml_peserta     = $('#jml_peserta').val();
        nama_peminjam   = $('#nama_peminjam').val();
        id_peminjam      = $('#id_peminjam').val();
        unit_kerja      = $('#unit_kerja').val();
        no_telp         = $('#no_telp').val();
        email           = $('#email').val();
        kebutuhan       = $('#kebutuhan').val();
        catatan         = $('#catatan').val();
        
        //tambahan
        entitas_lainnya = $('#entitas-lainnya').val();
        jenis_lainnya = $('#jenis-lainnya').val();
        var entitas = $('.entitas:checked').map(function(_, el) {
            return $(el).val()
        }).get()
        if(entitas == "lainnya"){
            entitas = $("#txtlainnya").val()
        }
        var entitas = $('.entitas:checked').map(function(_, el) {
            return $(el).val()
        }).get()
        var kategori = $('.kategori:checked').map(function(_, el) {
            return $(el).val()
        }).get()
        var jenis = $('.jenis:checked').map(function(_, el) {
            return $(el).val()
        }).get()
        var peserta = $('.peserta:checked').map(function(_, el) {
            return $(el).val()
        }).get()

        var tema            = CKEDITOR.instances.tema.getData()
        var deskripsi       = CKEDITOR.instances.deskripsi.getData()
        var tujuan          = CKEDITOR.instances.tujuan.getData()
        var pengisi_acara   = CKEDITOR.instances.pengisi_acara.getData()

        //masukkan tanggal dan waktu kegiatan ke dalam array
        var event_id = [];
        $('.event_id').each(function () { 
            event_id.push($(this).val());
        });

        var ruang = [];
        $('.ruang').each(function () { 
            ruang.push($(this).val());
        });

        var tgl_kegiatan = [];
        $('.tgl_kegiatan').each(function () { 
            tgl_kegiatan.push($(this).val());
        });

        var jam_mulai = [];
        $('.jam_mulai').each(function () { 
            jam_mulai.push($(this).val());
        });

        var menit_mulai = [];
        $('.menit_mulai').each(function () { 
            menit_mulai.push($(this).val());
        });

        var jam_selesai = [];
        $('.jam_selesai').each(function () { 
            jam_selesai.push($(this).val());
        });

        var menit_selesai = [];
        $('.menit_selesai').each(function () { 
            menit_selesai.push($(this).val());
        });

        var file = $("#upload_form")[0] 
        var formData = new FormData(file)

        formData.append("tgl_proses", tgl_proses);
        formData.append("tgl_permohonan", tgl_permohonan);
        formData.append("nama_kegiatan", nama_kegiatan);
        formData.append("nama_peminjam", nama_peminjam);
        formData.append("unit_kerja", unit_kerja);
        formData.append("id_peminjam", id_peminjam);
        formData.append("no_telp", no_telp);
        formData.append("email", email);
        formData.append("jml_peserta", jml_peserta);
        formData.append("kebutuhan", kebutuhan);
        formData.append("catatan", catatan);
        formData.append("entitas", entitas);
        formData.append("entitas_lainnya", entitas_lainnya);
        formData.append("kategori", kategori);
        formData.append("jenis", jenis);
        formData.append("jenis_lainnya", jenis_lainnya);
        formData.append("tema", tema);
        formData.append("deskripsi", deskripsi);
        formData.append("tujuan", tujuan);
        formData.append("pengisi_acara", pengisi_acara);
        formData.append("peserta", peserta);
        formData.append("event_id", event_id);
        formData.append("ruang", ruang);  
        formData.append("tgl_kegiatan", tgl_kegiatan);
        formData.append("jam_mulai", jam_mulai);
        formData.append("jam_selesai", jam_selesai);
        formData.append("menit_mulai", menit_mulai);
        formData.append("menit_selesai", menit_selesai);

        //insert data dan jadwal kegiatan
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "kemahasiswaan/formBooking/simpan",
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

    //Datepicker
    $(document).on('focus', '.tgl_kegiatan, #tgl_proses, #tgl_permohonan', function(){
        $('.tgl_kegiatan, #tgl_proses, #tgl_permohonan').datepicker({
            autoclose: true,
            language: "id"
        });
    });

    $(document).on('click', '#clear', function(){
        $('#test tr').empty();
        $('#jadwal').empty();
    });

    $(document).on('change', "#jam_selesai", function(){
        var tgl_kegiatan= $(this).parent().find('#tgl_kegiatan').val()
        var jam_selesai = $(this).parent().find('#jam_selesai').val()
        var nama_hari  = namaHari(tgl_kegiatan)
        
        //peminjaman ruang pada hari sabtu hanya diperkenankan sampai dengan jam 14.00
        if (nama_hari == 'Sabtu'){
            if (jam_selesai > 14){
                alert('Kegiatan pada hari sabtu hanya diizinkan sampai dengan pukul 14.00 WIB')
                $(this).parent().find('#jam_selesai').val('14')
            }
        }
    });
    var i = 1;
    $('#add_row').unbind('click').click(function(){
    //$(document).on('click', '#add_row', function(){
        $('#jadwal').unbind('click');  //gak jalan

        var now = new Date()
        months = ['01','02','03','04','05','06','07','08','09','10','11','12']
        //var formattedDate = months[now.getMonth()]+"/"+now.getDate()+"/"+now.getFullYear()   
        var formattedDate = "<?=$today?>"  

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

            $('#jadwal').append(text);
            i++;
            $(document).off('click', '#add_row', function(){

            });
    });

    $(document).on('click', '#del_row', function(){
        if(!$.trim($('#jadwal').html()).length){
            alert ("Now table is empty")
        }else{
            $('#test').children('tr').find('input[type=checkbox]:checked').each(function () {
                $(this).closest('tr').remove();
            });

            $('#jadwal').children('tr').find('input[type=checkbox]:checked').each(function () {
                $(this).closest('tr').remove();
            });
        }
    });
});
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '#tgl_permohonan', function(){
        $("#tgl_permohonan").datepicker()
    })
    
    
    $(document).on('change', ".ruang",function(){
        var nama_ruang = $(this).val()
        if(nama_ruang == 201 || nama_ruang == 202){
            alert("Penggunaan ruang ini hanya dikhususkan untuk kegiatan rapat, selanjutnya silahkan berkoordinasi dengan staf sekretariat pimpinan")   
       }
       
    });
    
    //cek jadwal bentrok
    $(document).on('change', ".ruang, .tgl_kegiatan, .jam_mulai, .jam_selesai, .menit_mulai, .menit_selesai",function(){
        var ruang       = $(this).parent().find('#ruang').val();
        var tgl_kegiatan= $(this).parent().find('#tgl_kegiatan').val();
        var jam_mulai   = $(this).parent().find('#jam_mulai').val();
        var jam_selesai = $(this).parent().find('#jam_selesai').val();
        var menit_mulai = $(this).parent().find('#menit_mulai').val();
        var menit_selesai = $(this).parent().find('#menit_selesai').val();
        //alert(ruang + ' ' + tgl_kegiatan + ' ' + jam_mulai + ' ' + menit_mulai + ' ' + jam_selesai + ' ' + menit_selesai); return;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "kemahasiswaan/formBooking/cekJadwalBentrok",
            data: {
                ruang:ruang,  
                tgl_kegiatan:tgl_kegiatan,
                jam_mulai:jam_mulai,
                jam_selesai:jam_selesai,
                menit_mulai:menit_mulai,
                menit_selesai:menit_selesai
            },
            success: function(data) {
                $('.pesan-bentrok').html(data);
                if (data != '') {
                    //Check to see if there is any text
                    // If there is no text within the input ten disable the button
                    $('.simpan').prop('disabled', true);
                } else {
                    //If there is text in the input, then enable the button
                    $('.simpan').prop('disabled', false);
                }
            }
        });  
    })

});

function tanggalan(v_tgl){
    var array_bln = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
    var array_hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var array_tgl = v_tgl.split('/');
    var tgl = v_tgl;
    var tanggal = new Date(tgl);
    var yy = tanggal.getYear();
    var tahun = (yy < 1000) ? yy + 1900 : yy;
    var kd_bulan = tanggal.getMonth();
    var d = array_tgl[1];
    var kd_hari = tanggal.getDay();
    var hari = array_hari[kd_hari];
    var bulan = array_bln[kd_bulan];
    var tanggalan = hari + ', ' + d + ' ' + bulan + ' ' + tahun;
    return tanggalan;
}

function namaHari(v_tgl){
    var array_hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var array_tgl = v_tgl.split('/');
    var tgl = v_tgl;
    var tanggal = new Date(tgl);
    var d = array_tgl[1];
    var kd_hari = tanggal.getDay();
    var hari = array_hari[kd_hari];
    return hari;
}

/*modul upload dokumen */
        function _(el) {
          return document.getElementById(el);
        }

        function uploadFile() {
          var file = _("file_upload").files[0];
          var action = _("action").value;
          var post_foto = _("post_foto").value;
          //alert(file.name+" | "+file.size+" | "+file.type);
          var formdata = new FormData();
          formdata.append("action", action);
          formdata.append("file_upload", file);
          formdata.append("post_foto", post_foto);
          var ajax = new XMLHttpRequest();
          ajax.upload.addEventListener("progress", progressHandler, false);
          ajax.addEventListener("load", completeHandler, false);
          ajax.addEventListener("error", errorHandler, false);
          ajax.addEventListener("abort", abortHandler, false);
          ajax.open("POST", "<?=site_url('penggunaan/ruangList/upload')?>"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
          
          //use file_upload_parser.php from above url
          ajax.send(formdata);
        }

        function progressHandler(event) {
          _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
          var percent = (event.loaded / event.total) * 100;
          _("progressBar").value = Math.round(percent);
          _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandler(event) {
          _("status").innerHTML = event.target.responseText;
          _("progressBar").value = 0; //wil clear progress bar after successful upload;
        }

        function errorHandler(event) {
          _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
          _("status").innerHTML = "Upload Aborted";
        }
</script>