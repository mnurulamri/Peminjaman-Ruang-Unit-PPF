<script>

//editor
CKEDITOR.replace('edit_tema')
CKEDITOR.replace('edit_deskripsi')
CKEDITOR.replace('edit_tujuan')
CKEDITOR.replace('edit_pengisi_acara')

$("#edit_del_row").click(function()
{
    if(!$.trim($('#edit_jadwal').html()).length)
    {
        alert ("Now table is empty")
    }else{
        $('#test').children('tr').find('input[type=checkbox]:checked').each(function () 
        {
            $(this).closest('tr').remove()
        })

        $('#edit_jadwal').children('tr').find('input[type=checkbox]:checked').each(function () 
        {
            $(this).closest('tr').remove()
        })
    }
})

$("#edit_clear").click(function()
{
    $('#test tr').empty();
    $('#edit_jadwal').empty();
})

$("#edit_jam_selesai").change(function(){
    var tgl_kegiatan= $(this).parent().find('#edit_tgl_kegiatan').val()
    var jam_selesai = $(this).parent().find('#edit_jam_selesai').val()
    var nama_hari  = namaHari(tgl_kegiatan)
    
    //peminjaman ruang pada hari sabtu hanya diperkenankan sampai dengan jam 14.00
    if (nama_hari == 'Sabtu'){
        if (jam_selesai > 14){
            alert('Kegiatan pada hari sabtu hanya diizinkan sampai dengan pukul 14.00 WIB')
            $(this).parent().find('#edit_jam_selesai').val('14')
        }
    }
})

$(".edit_ruang").change(function(){
    var nama_ruang = $(this).val()
    if(nama_ruang == 201 || nama_ruang == 202){
        alert("Penggunaan ruang ini hanya dikhususkan untuk kegiatan rapat, selanjutnya silahkan berkoordinasi dengan staf sekretariat pimpinan")   
   }
   
})

$(document).ready(function() 
{
    $(".update").click(function()
    {
    	//alert("test")
        nomor           = $('#nomor').val()
        tgl_proses      = $('#edit_tgl_proses').val()
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
        jenis_lainnya = $('#edit_jenis-lainnya').val();

        var entitas = $('.edit_entitas:checked').map(function(_, el) {
            return $(el).val()
        }).get()

        var kategori = $('.edit_kategori:checked').map(function(_, el) {
            return $(el).val()
        }).get()

        var jenis = $('.edit_jenis:checked').map(function(_, el) {
            return $(el).val()
        }).get()

        var peserta = $('.edit_peserta:checked').map(function(_, el) {
            return $(el).val()
        }).get()

        var tema            = CKEDITOR.instances.edit_tema.getData()
        var deskripsi       = CKEDITOR.instances.edit_deskripsi.getData()
        var tujuan          = CKEDITOR.instances.edit_tujuan.getData()
        var pengisi_acara   = CKEDITOR.instances.edit_pengisi_acara.getData()

        //masukkan tanggal dan waktu kegiatan ke dalam array
        var event_id = [];
        $('.edit_event_id').each(function () { 
            event_id.push($(this).val());
        });

        var ruang = [];
        $('.edit_ruang').each(function () { 
            ruang.push($(this).val());
        });

        var tgl_kegiatan = [];
        $('.edit_tgl_kegiatan').each(function () { 
            tgl_kegiatan.push($(this).val());
        });

        var jam_mulai = [];
        $('.edit_jam_mulai').each(function () { 
            jam_mulai.push($(this).val());
        });

        var menit_mulai = [];
        $('.edit_menit_mulai').each(function () { 
            menit_mulai.push($(this).val());
        });

        var jam_selesai = [];
        $('.edit_jam_selesai').each(function () { 
            jam_selesai.push($(this).val());
        });

        var menit_selesai = [];
        $('.edit_menit_selesai').each(function () { 
            menit_selesai.push($(this).val());
        });

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
console.log(ruang)
        //update data dan jadwal kegiatan
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>kemahasiswaan/formBookingEdit/simpan",
            data: formData,
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data) {
                console.log(data)
                $(".alert-pesan").fadeIn();
                $(".alert-pesan").html(data);
                $(".alert-pesan").fadeOut(2300); 
                refresh_view_dokumen()
            },
                error: function (jqXHR, exception) {
                    var msg = '';
			        if (jqXHR.status === 0) {
			            msg = 'Not connect.\n Verify Network.';
			        } else if (jqXHR.status == 404) {
			            msg = 'Requested page not found. [404]';
			        } else if (jqXHR.status == 500) {
			            msg = 'Internal Server Error [500].';
			        } else if (exception === 'parsererror') {
			            msg = 'Requested JSON parse failed.';
			        } else if (exception === 'timeout') {
			            msg = 'Time out error.';
			        } else if (exception === 'abort') {
			            msg = 'Ajax request aborted.';
			        } else {
			            msg = 'Uncaught Error.\n' + jqXHR.responseText;
			        }
			        $('.alert-pesan').html(msg);
			    },
            complete: function(data) {
                //$("#modal-form").hie("hide");    
            }           
        })
    })

    $(document).on("click", ".hapus-dokumen", function()
    {
        var nomor       = $('#nomor').val()
        var field       = $(this).data("dokumen")
        var nama_file   = $(this).data("file")
        var id = $(this).parent().parent().find(".nama_file").attr("id")

        var r = confirm("Anda yakin akan menghapus dokumen ini!");
        if (r == true) {
            $(this).parent().html("")
            $("#"+id).html("")
            $("input[name='"+field+"']").prop("disabled", false)

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>kemahasiswaan/formBookingEdit/hapusDokumen",
                data: {
                    nomor:nomor,  
                    field:field,
                    nama_file:nama_file
                },
                success: function(data) {
                                 
                    $(".alert-pesan").fadeIn();
                    $(".alert-pesan").html("dokumen sudah dihapus");
                    $(".alert-pesan").fadeOut(2300);
                    console.log(data)
                }
            })     
        }
    })

    $(document).on('focus', '.edit_tgl_kegiatan, #edit_tgl_proses, #edit_tgl_permohonan', function()
    {
        $(".edit_tgl_kegiatan, #edit_tgl_proses, #edit_tgl_permohonan").datepicker({
            autoclose: true,
            language: "id"
        })
    })
    /*
    $(".edit_tgl_kegiatan").datepicker({
            autoclose: true,
            language: "id"
    })*/

    //cek jadwal bentrok
    $(document).on('change', ".cek-bentrok", function(){
        var event_id    = $(this).attr("id")
        var ruang       = $(this).find(".edit_ruang").val();
        var tgl_kegiatan= $(this).find(".edit_tgl_kegiatan").val();
        var jam_mulai   = $(this).find('.edit_jam_mulai').val();
        var jam_selesai = $(this).find('.edit_jam_selesai').val();
        var menit_mulai = $(this).find('.edit_menit_mulai').val();
        var menit_selesai = $(this).find('.edit_menit_selesai').val();
        /*alert(event_id + ' ' + ruang + ' ' + tgl_kegiatan + ' ' + jam_mulai + ' ' + menit_mulai + ' ' + jam_selesai + ' ' + menit_selesai); return;*/

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>kemahasiswaan/formBookingEdit/cekJadwalBentrok",
            data: {
                event_id:event_id,
                ruang:ruang,  
                tgl_kegiatan:tgl_kegiatan,
                jam_mulai:jam_mulai,
                jam_selesai:jam_selesai,
                menit_mulai:menit_mulai,
                menit_selesai:menit_selesai
            },
            success: function(data) {
            	
                $('.pesan-bentrok-edit').html(data);
                if (data != '') {
                    //Check to see if there is any text
                    // If there is no text within the input ten disable the button
                    $('.save').prop('disabled', true);
                } else {
                    //If there is text in the input, then enable the button
                    $('.save').prop('disabled', false);
                }
            }
        });  
    })
    
    //cek jadwal bentrok untuk tambah data 
    $(document).on('change', ".cek-bentrok-2", function(){
        var i = $(this).parent('td').attr('id');
        //var event_id    = $(this).parent().find('#edit_event_id-'+i).val();
        var event_id = 0
        var ruang       = $(this).parent().find('#edit_ruang-'+i).val();
        var tgl_kegiatan= $(this).parent().find('#edit_tgl_kegiatan-'+i).val();
        var jam_mulai   = $(this).parent().find('#edit_jam_mulai-'+i).val();
        var jam_selesai = $(this).parent().find('#edit_jam_selesai-'+i).val();
        var menit_mulai = $(this).parent().find('#edit_menit_mulai-'+i).val();
        var menit_selesai = $(this).parent().find('#edit_menit_selesai-'+i).val();
        //alert('id='+i);
        //alert('event_id=' + event_id + ' ruang=' + ruang + ' tgl_kegiatan=' + tgl_kegiatan + ' jam_mulai=' + jam_mulai + ' menit_mulai=' + menit_mulai + ' jam_selesai=' + jam_selesai + ' menit_selesai=' + menit_selesai);
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "kemahasiswaan/formBookingEdit/cekJadwalBentrok",
            data: {
                event_id:event_id,
                ruang:ruang,  
                tgl_kegiatan:tgl_kegiatan,
                jam_mulai:jam_mulai,
                jam_selesai:jam_selesai,
                menit_mulai:menit_mulai,
                menit_selesai:menit_selesai
            },
            success: function(data) {
                $('.pesan-bentrok-edit').html(data);
                if (data != '') {
                    //Check to see if there is any text
                    // If there is no text within the input ten disable the button
                    $('.save').prop('disabled', true);
                } else {
                    //If there is text in the input, then enable the button
                    $('.save').prop('disabled', false);
                }
                console.log(data);
            }
        });  
        
    });

    var i = 1;
    var ruang_new = '<?=$ruang_new?>';
    $("#edit_add_row").click(function(){
        var formattedDate = "<?=today()?>";
        var ruang = '<?=$ruang_new?>'; 
            var text ='<tr>'+
                    '<td class="form-inline" id="'+i+'">'+
                        '<input type="checkbox" class="check_box"/>&nbsp;&nbsp;'+
                        '<input type="hidden" id="edit_event_id-'+i+'" name="edit_event_id" class="edit_event_id" value="0">'+
                         '<select id="edit_ruang-'+i+'" name="edit_ruang" class="cek-bentrok-2 edit_ruang form-control" style="width: 100px">' + 
                        ruang_new + 
                        '<select/>&nbsp;&nbsp;' +
                        '<input type="text" id="edit_tgl_kegiatan-'+i+'" class="cek-bentrok-2 edit_tgl_kegiatan form-control" name="edit_tgl_kegiatan" size="10" value="'+formattedDate+'" />&nbsp;&nbsp;'+
                            '<select name="edit_jam_mulai" id="edit_jam_mulai-'+i+'" class="cek-bentrok-2 edit_jam_mulai form-control">'+
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
                            '<select name="edit_menit_mulai" id="edit_menit_mulai-'+i+'" class="cek-bentrok-2 edit_menit_mulai form-control">'+
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
                            '<select name="edit_jam_selesai" id="edit_jam_selesai-'+i+'" class="cek-bentrok-2 edit_jam_selesai form-control">'+
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
                            '<select name="edit_menit_selesai" id="edit_menit_selesai-'+i+'" class="cek-bentrok-2 edit_menit_selesai form-control">'+
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

    $(document).on('click', '.del', function(){
        var vid = $(this).attr('id');
        var id = vid.split('_');
        var event_id = id[1];

        var txt;
        var r = confirm("Anda yakin akan menghapus jadwal ini!");
        if (r == true) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>penggunaan/ruangRapat/delWaktu",
                data: {
                    event_id:event_id
                },

                success: function(res) {
                   $('#row_'+event_id).remove();
                }               
            });
            
        } else {
            txt = "You pressed Cancel!";
        }   
        
    });

    $(document).on("change", "input[name='file_tor']", function(){
        //alert("test")
    })

    function refresh_view_dokumen(){
        //file tor
        var file_tor = $("input[name='file_tor']").val()
        var file_tor = file_tor.substr(12)
        if($("#file_tor").text()==""){
            $("#file_tor").text(file_tor)
        }        
        $("input[name='file_tor']").val("")
        if(file_tor != ""){
            $("#file_tor").next().html('<button type="button" class="btn btn-danger btn-xs hapus-dokumen" data-dokumen="file_tor" data-file="'+file_tor+'">hapus</button>')
            $("input[name='file_tor']").prop("disabled", true)
        } 
        
        //file rundown
        var file_rundown = $("input[name='file_rundown']").val()
        var file_rundown = file_rundown.substr(12)
        if($("#file_rundown").text()==""){
            $("#file_rundown").text(file_rundown)
        }        
        $("input[name='file_rundown']").val("")
        if(file_rundown != ""){
            $("#file_rundown").next().html('<button type="button" class="btn btn-danger btn-xs hapus-dokumen" data-dokumen="file_rundown" data-file="'+file_rundown+'">hapus</button>')
            $("input[name='file_rundown']").prop("disabled", true)
        }

        //file undangan
        var file_undangan = $("input[name='file_undangan']").val()
        var file_undangan = file_undangan.substr(12)
        if($("#file_undangan").text()==""){
            $("#file_undangan").text(file_undangan)
        }        
        $("input[name='file_undangan']").val("")
        if(file_undangan != ""){
            $("#file_undangan").next().html('<button type="button" class="btn btn-danger btn-xs hapus-dokumen" data-dokumen="file_undangan" data-file="'+file_undangan+'">hapus</button>')
            $("input[name='file_undangan']").prop("disabled", true)
        }

        //file lampiran
        var file_lampiran = $("input[name='file_lampiran']").val()
        var file_lampiran = file_lampiran.substr(12)
        if($("#file_lampiran").text()==""){
            $("#file_lampiran").text(file_lampiran)
        }        
        $("input[name='file_lampiran']").val("")
        if(file_lampiran != ""){
            $("#file_lampiran").next().html('<button type="button" class="btn btn-danger btn-xs hapus-dokumen" data-dokumen="file_lampiran" data-file="'+file_lampiran+'">hapus</button>')
            $("input[name='file_lampiran']").prop("disabled", true)
        } 
    }

})

</script>