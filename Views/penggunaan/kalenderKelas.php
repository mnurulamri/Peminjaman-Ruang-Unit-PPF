<!doctype html>

<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" title="no title" charset="utf-8">
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/sources/locale/locale_id.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>/assets/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>    <!-- untuk crud otomatis -->
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

*,*:before, *:after{
	box-sizing:content-box;
	-webkit-box-sizing:content-box;
	-moz-box-sizing:content-box;
}

.jumbotron {
	line-height:normal;
}

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

#my_form label {
	width: 200px;
}

/*event in day or week view*/
.dhx_cal_event.event_1 div{
	background-color: #ED4337 !important;
	color: white !important;
}

.dhx_cal_event.event_2 div{
	background-color: #808000 !important;
	color: white !important;
}

.dhx_cal_event.event_3 div{
	background-color: #009966 !important;
	color: white !important;
}

.dhx_cal_event.event_kp div{
	background-color: #C85EC7 !important;
	color: white !important;
}

.dhx_cal_header {
	height:100px;
}
</style>

	<script type="text/javascript" charset="utf-8">
		function init() {

		var sections=[
			{key:"AJS" ,label:"AJS<br>150"},
			{key:"E.103A" ,label:"E.103A<br>35"},
			{key:"E.103B" ,label:"E.103B<br>35"},
			{key:"E.201" ,label:"E.201<br>35"},
			{key:"E.202" ,label:"E.202<br>10"},
			{key:"E.203A" ,label:"E.203A<br>35"},
			{key:"E.203B" ,label:"E.203B<br>35"},
			{key:"E.204" ,label:"E.204<br>20"},
			{key:"E.301" ,label:"E.301<br>40"},
			{key:"E.302" ,label:"E.302<br>40"},
			{key:"E.303" ,label:"E.303<br>40"},
			{key:"E.304" ,label:"E.304<br>40"},
			{key:"F.201" ,label:"F.201<br>10"},
			{key:"F.202" ,label:"F.202<br>60"},
			{key:"G.106" ,label:"G.106"},
			{key:"G.201" ,label:"G.201<br>35"},
			{key:"G.202" ,label:"G.202<br>35"},
			{key:"G.203" ,label:"G.203<br>35"},
			{key:"G.203A" ,label:"G.203A"},
			{key:"G.203B" ,label:"G.203B"},
			{key:"G.204" ,label:"G.204<br>35"},
			{key:"G.205" ,label:"G.205<br>35"},
			{key:"G.205A" ,label:"G.205A"},
			{key:"G.205B" ,label:"G.205B"},
			{key:"G.301" ,label:"G.301"},
			{key:"G.302" ,label:"G.302"},
			{key:"G.303" ,label:"G.303"},
			{key:"G.304" ,label:"G.304"},
			{key:"G.401" ,label:"G.401<br>40"},
			{key:"G.402" ,label:"G.402<br>40"},
			{key:"G.403" ,label:"G.403<br>40"},
			{key:"G.404" ,label:"G.404<br>40"},
			{key:"G.405" ,label:"G.405<br>40"},
			{key:"H.101" ,label:"H.101<br>35"},
			{key:"H.102" ,label:"H.102<br>40"},
			{key:"H.103" ,label:"H.103<br>40"},
			{key:"H.201" ,label:"H.201<br>30"},
			{key:"H.202" ,label:"H.202<br>30"},
			{key:"H.203" ,label:"H.203<br>30"},
			{key:"H.204" ,label:"H.204<br>40"},
			{key:"H.205" ,label:"H.205<br>40"},
			{key:"H.301" ,label:"H.301<br>30"},
			{key:"H.302" ,label:"H.302<br>30"},
			{key:"H.303" ,label:"H.303<br>30"},
			{key:"H.304" ,label:"H.304<br>40"},
			{key:"H.305" ,label:"H.305<br>40"},
			{key:"H.401" ,label:"H.401<br>30"},
			{key:"H.402" ,label:"H.402<br>30"},
			{key:"H.403" ,label:"H.403<br>30"},
			{key:"H.404" ,label:"H.404<br>40"},
			{key:"H.405" ,label:"H.405<br>40"},
			{key:"H.501" ,label:"H.501<br>40"},
			{key:"H.502" ,label:"H.502<br>40"},
			{key:"H.503" ,label:"H.503<br>40"},
			{key:"H.504" ,label:"H.504<br>40"},
			{key:"M.101" ,label:"M.101<br>40"},
			{key:"M.102" ,label:"M.102<br>40"},
			{key:"M.103" ,label:"M.103<br>40"},
			{key:"M.104" ,label:"M.104<br>35"},
			{key:"M.301" ,label:"M.301<br>35"},
			{key:"M.302" ,label:"M.302<br>30"},
			{key:"M.303" ,label:"M.303<br>40"},
			{key:"M.304" ,label:"M.304<br>40"},
			{key:"N1.301A" ,label:"N1.301A<br>25"},
			{key:"N1.301B" ,label:"N1.301B<br>35"},
			{key:"N1.301C" ,label:"N1.301C<br>35"},
			{key:"N1.302" ,label:"N1.302<br>-"},
			{key:"N1.303" ,label:"N1.303<br>10"},
			{key:"N1.304" ,label:"N1.304<br>35"},
			{key:"N1.305" ,label:"N1.305<br>20"},
			{key:"N1.306" ,label:"N1.306<br>20"},
			{key:"N2.101" ,label:"N2.101<br>-"},
			{key:"N2.102" ,label:"N2.102<br>40"},
			{key:"N2.301" ,label:"N2.301<br>10"},
			{key:"N2.302" ,label:"N2.302<br>35"},
			{key:"N2.303" ,label:"N2.303<br>35"},
			{key:"N2.304" ,label:"N2.304<br>35"},
			{key:"N2.305" ,label:"N2.305<br>35"},
			{key:"N2.306" ,label:"N2.306<br>30"},
			{key:"Gd. Kom Lt 1" ,label:"Gd. Kom Lt 1"},
			{key:"Gd. Kom Lt 3" ,label:"Gd. Kom Lt 3"},
			{key:"Gd. Kom. 303" ,label:"Gd. Kom. 303"},
			{key:"Kom-Cocacola" ,label:"Kom-Cocacola<br>30"},
			{key:"Kom-Fanta" ,label:"Kom-Fanta<br>35"},
			{key:"Kom-Fresty" ,label:"Kom-Fresty<br>30"},
			{key:"Kom-Sprite" ,label:"Kom-Sprite<br>20"},
			{key:"Lab. AV" ,label:"Lab. AV"},
			{key:"B.301" ,label:"B.301"},
			{key:"Lab. MM" ,label:"Lab. MM"},
			{key:"Audito.Kom.", label:"Audito.Kom."},
			{key:"X" ,label:"X"}
		];

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

		scheduler.xy.scale_height = 35;
		scheduler.config.details_on_create=true;
		scheduler.config.details_on_dblclick=true;
		scheduler.config.icons_select = false;
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.config.first_hour = 8;
		scheduler.config.multi_day = true;
		scheduler.locale.labels.unit_tab = "Ruang";
		scheduler.config.fix_tab_position = false;

		/*
		scheduler.locale.labels.section_event_name="Nama Kegiatan";
		scheduler.locale.labels.section_id_petugas = "ID Petugas";
		scheduler.locale.labels.section_id_peminjam = "ID Peminjam";
		scheduler.locale.labels.section_nama_peminjam = "Nama PJ";
		scheduler.locale.labels.section_prodi = "Unit Kerja";
		scheduler.locale.labels.section_no_telp = "Nomor Telepon";
		scheduler.locale.labels.section_email = "Email";
		scheduler.locale.labels.section_time = "Waktu";
		scheduler.locale.labels.section_ruang = "Ruang";
		scheduler.locale.labels.section_event_id = "ID";
		*/

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
					{name:"ruang", height:25, type:"textarea", map_to:"section_id"},
					{name:"event_id", height:25, type:"textarea", map_to:"event_id"}
				];
		*/

		scheduler.createUnitsView({
			name:"unit",
			property:"section_id",
			list:sections,
			size:10,
			step:10
		});

		//set tanggal hari ini
		var date = new Date();
		var tahun = date.getFullYear();
		var bulan = date.getMonth();
		var hari = date.getDate();

		scheduler.init('scheduler_here',new Date(tahun, bulan, hari),"unit");
		scheduler.load("<?=base_url()?>peminjaman/schedulerRuangKelas/dataSiak");

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
				url: "http://localhost:8080/backend/peminjaman/test/testingDelete",
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
			//var start_date 	= scheduler.formSection('start_date');  //not work
			//var end_date 		= scheduler.formSection('end_date');  //not work
			var event_id 		= scheduler.formSection('event_id');
			var event_name 		= scheduler.formSection('event_name');
			var id_petugas 		= scheduler.formSection('id_petugas');
			var id_peminjam 	= scheduler.formSection('id_peminjam');
			var nama_peminjam 	= scheduler.formSection('nama_peminjam');
			var prodi 			= scheduler.formSection('prodi');
			var no_telp 		= scheduler.formSection('no_telp');
			var email 			= scheduler.formSection('email');

			//deklarasikan object
			var res = {};
			scheduler.formSection('time').getValue(res);  //time didefinisikan dulu supaya get value time bisa bekerja
			var ev 				= scheduler.getEvent(id);  //supaya fungsi getValue() bisa bekerja

			//set variabel
			var event_id 		= event_id.getValue();
			var start_date 		= scheduler.date.date_to_str(scheduler.config.api_date)(res.start_date);
			var end_date 		= scheduler.date.date_to_str(scheduler.config.api_date)(res.end_date);
			var event_name 		= event_name.getValue();
			var id_petugas 		= id_petugas.getValue();
			var id_peminjam 	= id_peminjam.getValue();
			var nama_peminjam 	= nama_peminjam.getValue();
			var prodi 			= prodi.getValue();
			var no_telp 		= no_telp.getValue();
			var email 			= email.getValue();
			var ruang 			= ev.section_id;
			//alert('start='+start_date + ' end=' + end_date + ' ' + event_name + ' ' + id_petugas + ' ' + id_peminjam + ' ' + nama_peminjam + ' ' + prodi + ' ' + email + ' ' + no_telp + ' ' + ruang);

			if(event_name == 'New event'){
				//add event
				$.ajax({
					type: "POST",
					url: "http://localhost:8080/backend/peminjaman/test/testing",
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
				//update event
				$.ajax({
					type: "POST",
					url: "http://localhost:8080/backend/peminjaman/test/testingUpdate",
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
		});*/

/*

scheduler.getEvent(eventId).text = "Conference"; //changes event's data
scheduler.updateEvent(eventId); // renders the updated event

		scheduler.attachEvent("onLightbox", function(id, ev, is_new){
			var ev = scheduler.getEvent(id);
			//var ev 				= scheduler.getEvent(id);
			//var start_date 		= scheduler.date.date_to_str(scheduler.config.api_date)(res.start_date);
			//var end_date 		= scheduler.date.date_to_str(scheduler.config.api_date)(res.end_date);
			var event_name 		= ev.event_name;
			var id_petugas 		= ev.id_petugas;
			var id_peminjam 	= ev.id_peminjam;
			var nama_peminjam 	= ev.nama_peminjam;
			var prodi 			= ev.prodi;
			var no_telp 		= ev.no_telp;
			var email 			= ev.email;
			var ruang 			= ev.section_id;
			//alert(start_date +' '+ end_date + ' ' + kegiatan);
			return true;
		});

		var html = function(id) { return document.getElementById(id); }; //just a helper

		scheduler.showLightbox = function(id) {
			var ev = scheduler.getEvent(id);
			//var date = scheduler.getEvent(id).start_date;
			scheduler.startLightbox(id, html("my_form"));

			html("hari").focus();
			//html("description").value = ev.text;

			html("hari").value			= ev.hari || "";
			//html("tgl_kegiatan").value	= ev.start_date || "";
			html("tgl_kegiatan").value	= scheduler.date.date_to_str(scheduler.config.api_date)(ev.start_date) || "";
			html("ruang").value			= ev.section_id || "";
			html("nama_kegiatan").value	= ev.nama_kegiatan || "";
			html("prodi").value			= ev.section_id || "";
			html("jam_mulai").value		= ev.jam_mulai || "";
			html("menit_mulai").value	= ev.menit_mulai || "";
			html("jam_selesai").value	= ev.jam_selesai || "";
			html("menit_selesai").value	= ev.menit_selesai || "";
		};

		function save_form() {
			var ev = scheduler.getEvent(scheduler.getState().lightbox_id);
			//var date = scheduler.getEvent(scheduler.getState().date);
			ev.hari			= html("hari").value;
			ev.tgl_kegiatan	= html("tgl_kegiatan").value;
			ev.ruang		= html("ruang").value;
			ev.nama_kegiatan= html("nama_kegiatan").value;
			ev.prodi		= html("prodi").value;
			ev.jam_mulai	= html("jam_mulai").value;
			ev.menit_mulai	= html("menit_mulai").value;
			ev.jam_selesai	= html("jam_selesai").value;
			ev.menit_selesai= html("menit_selesai").value;

			scheduler.endLightbox(true, html("my_form"));

			$.ajax({
				type: "POST",
				url: "http://localhost:8080/backend/peminjaman/test/update",
				data: {hari:ev.hari, tgl_kegiatan:ev.tgl_kegiatan, ruang:ev.ruang, nama_kegiatan:ev.nama_kegiatan, prodi:ev.prodi, jam_mulai:ev.jam_mulai, menit_mulai:ev.menit_mulai, jam_selesai:ev.jam_selesai, menit_selesai:ev.menit_selesai, crud:1},
				success: function(res) {
					//$("div.pesan").html(res);
					if (res)
					{
						//$("#process-info").hide();
						//$("#alert-riwayat").fadeIn();
						//$("#alert-riwayat").fadeOut(2300);
						//$('.pesan').html(res);
						//$(".pesan").fadeIn();
						//$(".pesan").fadeOut(2300);
						alert('ok');
					} else {
						alert('ada error');
					}
				}
			});
		}
		function close_form() {
			scheduler.endLightbox(false, html("my_form"));
		}

		function delete_event() {
			var event_id = scheduler.getState().lightbox_id;
			scheduler.endLightbox(false, html("my_form"));
			scheduler.deleteEvent(event_id);
		}
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
</head>
<body onload="init();">

<div style="width:100%; height:600px; overflow-x:scroll; overflow-y:hidden; position: relative;">
	<div id="scheduler_here" class="dhx_cal_container">
		<div class="dhx_cal_navline">
			<div class="dhx_cal_tab dhx_cal_tab_first" name="unit_tab" style="left: 50px;"></div>
			<div class="dhx_cal_tab dhx_cal_tab_last" name="month_tab" style="left: 111px;"></div>

			<div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>					
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>
	</div>	
</div>



<div id="my_form">
		<div class="box-body">
			<div class="form-group">
				<label class="col-sm-2 control-label">Hari</label>
				<div class="col-sm-2">
					<select name="hari" id="hari" class="form-control pull-right">
					<option style="color:magenta;" value="Senin">Senin</option>
					<option style="color:blue;" value="Selasa">Selasa</option>
					<option style="color:green;" value="Rabu">Rabu</option>
					<option style="color:purple;" value="Kamis">Kamis</option>
					<option style="color:red;" value="Jumat">Jumat</option>
					<option style="color:magenta;" value="Sabtu">Sabtu</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Tanggal Kegiatan :</label>
				<div class="col-sm-2">
					<input id="tgl_kegiatan" name="tgl_kegiatan" class="form-control pull-right" data-provide="datepicker"></input>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Ruang :</label>
				<div class="col-sm-2">
					<select class="form-control pull-right" name="ruang" id="ruang">
					<?php
					foreach ($ruang as $key => $value) {
					echo '<option value="'.$value->kd_ruang.'">'.$value->nm_ruang.'</option>';
					}
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama Kuliah/Kegiatan :</label>
				<div class="col-sm-10">
					<input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control pull-right"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Program Studi/Unit :</label>
				<div class="col-sm-10">
					<input type="text" name="prodi" id="prodi" class="form-control pull-right"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Jam Mulai:</label>
					<div class="col-sm-1">
						<select name="jam_mulai" id="jam_mulai" class="form-control">
						<option value="16" selected >16</option>
						<option value="17"  >17</option>
						<option value="18"  >18</option>
						<option value="19"  >19</option>
						<option value="20"  >20</option>
						<option value="21"  >21</option>
						</select>
					</div>
					<div class="col-sm-1">
						<select name="menit_mulai" id="menit_mulai" class="form-control pull-right">
							<option value="00"  >00</option>
							<option value="05"  >05</option>
							<option value="10"  >10</option>
							<option value="15"  >15</option>
							<option value="20"  >20</option>
							<option value="25"  >25</option>
							<option value="30"  selected  >30</option>
							<option value="35"  >35</option>
							<option value="40"  >40</option>
							<option value="45"  >45</option>
							<option value="50"  >50</option>
							<option value="55"  >55</option>
						</select>
					</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Jam Selesai:</label>
					<div class="col-sm-1">
						<select name="jam_selesai" id="jam_selesai" class="form-control pull-right">
							<option value="17"  >17</option>
							<option value="18"  >18</option>
							<option value="19"  >19</option>
							<option value="20"  >20</option>
							<option value="21"  >21</option>
						</select>
					</div>
				<div class="col-sm-1">
					<select name="menit_selesai" id="menit_selesai" class="form-control">
						<option value="00"  >00</option>
						<option value="05"  >05</option>
						<option value="10"  >10</option>
						<option value="15"  >15</option>
						<option value="20"  >20</option>
						<option value="25"  >25</option>
						<option value="30"  selected  >30</option>
						<option value="35"  >35</option>
						<option value="40"  >40</option>
						<option value="45"  >45</option>
						<option value="50"  >50</option>
						<option value="55"  >55</option>
					</select>
				</div>
			</div>
		</div>

	<input type="button" name="save" value="Save" id="save" style='width:100px;' onclick="save_form()">
	<input type="button" name="close" value="Close" id="close" style='width:100px;' onclick="close_form()">
	<input type="button" name="delete" value="Delete" id="delete" style='width:100px;' onclick="delete_event()">
</div>

<script src="<?=base_url();?>assets/js/jquery-1.11.2.min.js"></script>
</body>
