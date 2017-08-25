<link rel="stylesheet" href="<?=base_url()?>/assets/bootstrap-iso/bootstrap-iso.css">
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" title="no title" charset="utf-8">
<!--<link rel="stylesheet" href="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler_glossy.css" type="text/css"  title="no title" charset="utf-8">-->
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/sources/locale/locale_id.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script> <!-- untuk crud otomatis -->  
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor_debug.js"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxscheduler_recurring.js"></script>


<style type="text/css" media="screen">
  #scheduler_here{
    position:absolute;
    margin: 0px;
    padding: 0px;
    height: 100%;
	width:100%;
  }
  /*html, body {
    
    margin: 0px;
    padding: 0px;
    height: 100%;
    overflow: hidden;
  }*/

  #my_form {
    position: absolute;
    top: 100px;
    left: 200px;
    z-index: 10001;
    display: none;
    background-color: white;
    border: 2px outset gray;
    padding: 20px;
    font-family: Tahoma;
    font-size: 10pt;
  }
*,*:before, *:after{
	box-sizing:content-box;
	-webkit-box-sizing:content-box;
	-moz-box-sizing:content-box;
}
	.jumbotron {
		line-height:normal;
	}
  #my_form label {
    width: 200px;
  }
</style>

<script type="text/javascript" charset="utf-8">
  function init() {
  
    //color event
    scheduler.templates.event_class = function(start_date, end_date, event) {
      if(event.flag == "1" && event.level == "0") // if event has subject property then special class should be assigned
                return "event_kp";
      if(event.flag == "1" && event.level == "1") // if event has subject property then special class should be assigned
                return "event_1";
      if(event.flag == "1" && event.level == "2") // if event has subject property then special class should be assigned
                return "event_2";
      if(event.flag == "1" && event.level == "3") // if event has subject property then special class should be assigned
                return "event_3";
      return ""; // default return
    };    

  var date = new Date();
  var tahun = date.getFullYear();
  var bulan = date.getMonth();
  var hari = date.getDate();
  
  scheduler.config.xml_date = "%Y-%m-%d %H:%i";
  scheduler.config.prevent_cache = true;

    /*scheduler.locale.labels.section_event_name="Nama Kegiatan"; 
    scheduler.locale.labels.section_id_petugas = "ID Petugas";
    scheduler.locale.labels.section_id_peminjam = "ID Peminjam";
    scheduler.locale.labels.section_nama_peminjam = "Nama PJ";
    scheduler.locale.labels.section_prodi = "Unit Kerja";
    scheduler.locale.labels.section_no_telp = "Nomor Telepon";
    scheduler.locale.labels.section_email = "Email";
    scheduler.locale.labels.section_time = "Waktu";
    scheduler.locale.labels.section_ruang = "Ruang";
    scheduler.locale.labels.section_event_id = "ID";*/
    scheduler.config.details_on_create=false;
    scheduler.config.details_on_dblclick=false;
    scheduler.config.icons_select = false;
    //scheduler.config.xml_date="%Y-%m-%d %H:%i";
    scheduler.config.first_hour = 8;

    /*
    scheduler.config.lightbox.sections = [
          {name:"event_name", height:25, map_to:"text", type:"textarea" , focus:true},      
          {name:"id_petugas", height:25, type:"textarea", map_to:"id_petugas" },
          {name:"id_peminjam", height:25, type:"textarea", map_to:"id_peminjam" },
          {name:"nama_peminjam", height:25, type:"textarea", map_to:"nama_peminjam" },
          {name:"prodi", height:25, type:"textarea", map_to:"prodi" },
          {name:"no_telp", height:25, type:"textarea", map_to:"no_telp" },
          {name:"email", height:25, type:"textarea", map_to:"email" },
          {name:"time", height:25, type:"calendar_time", map_to:"auto"},
          {name:"event_id", height:25, type:"textarea", map_to:"event_id"}
        ];
        */

    scheduler.config.multi_day = true;
    scheduler.xy.editor_width = 35; 
    scheduler.init('scheduler_here', new Date(tahun, bulan, hari), "week"); 
    //scheduler.load("jadwal_units.xml");
    //scheduler.load("./schedulerRuangRapat/data/1");  http://localhost:8080/backend/peminjaman/schedulerRuangRapat/data/1
    scheduler.load("<?=base_url()?>peminjaman/schedulerRuangKelas/dataPerKelas/<?=$ruang?>");

    scheduler.addEventNow = function(){
      return null;
    };
  }

  //fungsi untuk disable double click pada kotak scheduler
  var createEvent = scheduler.addEventNow;
  scheduler.addEventNow = function(){
    return null;
  };

  /*
  scheduler.attachEvent("onEventDeleted", function(id){
    //scheduler.deleteEvent(id);
    var event_id = scheduler.formSection('event_id');
    var event_id = event_id.getValue();

    $.ajax({
      type: "POST",
      url: "<?=base_url()?>" + "peminjaman/test/deleteSchedulerRuangRapat",
      data: { 
          event_id:event_id
        },
      success: function(res) {          
        //$("div.pesan").html(res);
        if (res)
        {
          alert(res);
        } else {
          alert('ada error');
        }
      }
    });       
  });

  scheduler.attachEvent("onEventSave", function(id, ev, is_new){
    //prepare field from formSection in lightbox supaya fungsi getValue() dapat bekerja
    //var start_date  = scheduler.formSection('start_date');  //not work
    //var end_date    = scheduler.formSection('end_date');  //not work
    var event_id    = scheduler.formSection('event_id');
    var event_name    = scheduler.formSection('event_name');
    var id_petugas    = scheduler.formSection('id_petugas');
    var id_peminjam   = scheduler.formSection('id_peminjam');
    var nama_peminjam   = scheduler.formSection('nama_peminjam');
    var prodi       = scheduler.formSection('prodi');
    var no_telp     = scheduler.formSection('no_telp');
    var email       = scheduler.formSection('email');

    //deklarasikan object
    var res = {};
    scheduler.formSection('time').getValue(res);  //time didefinisikan dulu supaya get value time bisa bekerja
    var ev        = scheduler.getEvent(id);  //supaya fungsi getValue() bisa bekerja

    //set variabel
    var event_id    = event_id.getValue();  
    var start_date    = scheduler.date.date_to_str(scheduler.config.api_date)(res.start_date);
    var end_date    = scheduler.date.date_to_str(scheduler.config.api_date)(res.end_date);      
    var event_name    = event_name.getValue();
    var id_petugas    = id_petugas.getValue();
    var id_peminjam   = id_peminjam.getValue();
    var nama_peminjam   = nama_peminjam.getValue();
    var prodi       = prodi.getValue();
    var no_telp     = no_telp.getValue();
    var email       = email.getValue();
    var ruang       = "<?=$ruang?>";
    //alert('start='+start_date + ' end=' + end_date + ' ' + event_name + ' ' + id_petugas + ' ' + id_peminjam + ' ' + nama_peminjam + ' ' + prodi + ' ' + email + ' ' + no_telp + ' ' + ruang);
    
    if(event_id == ''){
      //add event
      $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>" + "peminjaman/test/insertSchedulerRuangRapat",
        data: { 
            event_id:event_id,
            start_date:start_date, 
            end_date:end_date, 
            event_name:event_name, 
            id_petugas:id_petugas,
            id_peminjam:id_peminjam,
            nama_peminjam:nama_peminjam,
            prodi:prodi,
            no_telp:no_telp,
            email:email,
            ruang:ruang,
            crud:1
          },
        success: function(res) {        
          //$("div.pesan").html(res);
          if (res)
          {
            alert(res);
          } else {
            alert('ada error');
          }
        }
      }); 
    } else {
      alert('edit')
      //update event
      $.ajax({
        type: "POST",
        url: "<?=base_url()?>" + "peminjaman/test/updateSchedulerRuangRapat",
        data: { 
            event_id:event_id,
            start_date:start_date, 
            end_date:end_date, 
            event_name:event_name, 
            id_petugas:id_petugas,
            id_peminjam:id_peminjam,
            nama_peminjam:nama_peminjam,
            prodi:prodi,
            no_telp:no_telp,
            email:email,
            ruang:ruang,
            crud:1
          },
        success: function(res) {          
          //$("div.pesan").html(res);
          if (res)
          {
            alert(res);
          } else {
            alert('ada error');
          }
        }
      }); 
    }     
    return true;
  });
  */

function show_minical(){
  if (scheduler.isCalendarVisible())
    scheduler.destroyCalendar();
  else
    scheduler.renderCalendar({
      position:"dhx_minical_icon",
      date:scheduler._date,
      navigation:true,
      handler:function(date,calendar){
        scheduler.setCurrentView(date);
        scheduler.destroyCalendar()
      }
    });
}
</script>


<body onload="init();" style="background:#eee; ">

<div class="" style="background:#d2d6de; color:#3c8dbc; text-align:center; font-family:arial; font-weight:bold"><?='- '.$nama_ruang.' -'?></div>
	
<div style="width:100%; height:600px; overflow-x:scroll; overflow-y:hidden; position: relative;">
	<div id="scheduler_here" class="dhx_cal_container"> <!--82 75%-->
		<div class="dhx_cal_navline">
			<div class="dhx_cal_tab" name="day_tab"></div>
			<div class="dhx_cal_tab" name="week_tab"></div>
			<div class="dhx_cal_tab" name="month_tab"></div>			
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>

			<div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>
		</div>
		<div class="dhx_cal_header"></div>
		<div class="dhx_cal_data"></div>
	</div>
</div>
<script src="<?=base_url();?>assets/js/jquery-1.11.2.min.js"></script>
</body>
<?//=$script?>
