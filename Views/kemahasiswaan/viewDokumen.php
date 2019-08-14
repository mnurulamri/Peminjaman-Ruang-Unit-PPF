<?php
if ($ext_file == '.jpg' or $ext_file == '.jpeg' or $ext_file == '.png' or $ext_file == '.gif' or $ext_file == '.bmp') {
	echo '<img src="'.base_url().'dokumen/kemahasiswaan/'.$nama_file.'" height="100%" width="100%">';
} else if($ext_file == '.pdf'){	
	echo '
	<div style="text-align:center">
		<embed src="'.base_url().'assets/pdf_viewer/web/viewer.html?file='.base_url().'dokumen/kemahasiswaan/'.$nama_file.'" width="898" height="800">
	</div>';
	echo base_url().'assets/pdf_viewer/web/viewer.html?file='.base_url().'dokumen/kemahasiswaan/'.$nama_file;
} else {
	echo 'not supported file';
}
?>