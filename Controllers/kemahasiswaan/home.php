<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
		parent::__construct();
		$this->load->database();
		$this->load->library('service');
		$this->load->model('penggunaan/ruangrapatmodel');
		date_default_timezone_set('Asia/Jakarta');

	}
	public function index()
	{		
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$data['foto'] = $this->service->getFoto($userlogin);
		$data['nama'] = $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);
		$data['content'] 	= $this->load->view('home/halamanUtama', null, true);
		$this->load->view('layout/template', $data);
		//$this->load->view('layout/script');
	}
}
