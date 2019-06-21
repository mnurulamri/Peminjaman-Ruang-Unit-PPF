<?=$vruang?>
<script type="text/javascript">

$(document).ready(function() {
	//datepicker
	$.fn.datepicker.defaults.autoclose = 'TRUE';
    $.fn.datepicker.defaults.language = 'id';
    $.fn.datepicker.defaults.format = "dd MM yyyy";

	$("#tgl_permohonan").focus(function(){
		$("#tgl_permohonan").datepicker()
	})

	//editor
    CKEDITOR.replace('tema')
    CKEDITOR.replace('tujuan')
    CKEDITOR.replace('pengisi_acara')

    //add table row
    var i = 1;
    $('#add_row').click(function(){
    	
    	//set tanggal sekarang
        var now = new Date()
        months = ['01','02','03','04','05','06','07','08','09','10','11','12']
        var formattedDate = months[now.getMonth()]+"/"+now.getDate()+"/"+now.getFullYear()

		//set ruang
		var ruang = "<?=$vruang?>";
		alert("test")
    })
})
</script>