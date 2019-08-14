<?php 

class testUpload extends CI_Controller{

	function __construct(){
		parent::__construct();
		  $this->load->helper(array('form', 'url'));
	}

	public function index(){
		$this->load->view('test/testUploadView', array('error' => ' ' ));
	}

	public function aksi_upload(){
		$config['upload_path']          = './dokumen/kemahasiswaan/';
		$config['allowed_types']        = 'gif|jpg|jpeg|png|svg|pdf';
		$config['overwrite']			= true;
		#$config['max_size']             = 100;
		$config['max_width']            = 51200000;
		#$config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('berkas')){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('test/testUploadView', $error);
		}else{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('test/testUploadSuksesView', $data);
		}
	}
	
}