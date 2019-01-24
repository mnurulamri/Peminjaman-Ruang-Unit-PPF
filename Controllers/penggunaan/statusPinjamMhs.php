<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StatusPinjamMhs extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('penggunaan/statuspinjammodel');
		$this->load->library('service');
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('Ajax_pagination');
		$this->load->library('session');
    	$this->perPage = 10;
		//buat test aja
		$this->session->userdata['logged_in']['username'] = 'mnurulamri';
		$this->session->userdata['logged_in']['hak_akses'] = 1;
	}

	public function status()
	{
		$userlogin = ($this->session->userdata['logged_in']['username']);
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);
		$data['ruang'] 		= $this->statuspinjammodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);
		$this->load->view('layout/3-menu', $data);		
		$data['script'] 	= $this->load->view('layout/template-2', null, true);
		$data['data'] 		= $this->statuspinjammodel->getListStatusPinjam();		
		$this->load->view('status_pinjam/status-pinjam-list', $data);  //ruangRapatStatus
	}

	public function statusPinjam(){
        $data = array();
        
        //total rows count
        $totalRec = count($this->statuspinjammodel->getRows());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php/penggunaan/StatusPinjamMhs/ajaxStatusPinjam';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
         $config['uri_segment']   = 4;

		// Bootstrap Stylings
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '<i class="glyphicon glyphicon-step-backward"></i>';
		$config['last_link'] = '<i class="glyphicon glyphicon-step-forward"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="glyphicon glyphicon-triangle-left"></i>';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="glyphicon glyphicon-triangle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

        $this->ajax_pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        //get the posts data
        $data['posts'] = $this->statuspinjammodel->getRows(array('limit'=>$this->perPage));
        
        //load the view
        $userlogin = ($this->session->userdata['logged_in']['username']);
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->statuspinjammodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);		
		$data['script'] 	= $this->load->view('layout/template-2', null, true);
		$data['data'] 		= $this->statuspinjammodel->getRows();
		//$data['data_jadwal'] 		= $this->statuspinjammodel->getJadwal();
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);		
		$this->load->view('layout/3-menu', $data);
        $this->load->view('status_pinjam/ajax-status-pinjam-index', $data);
	}

    function ajaxStatusPinjam(){
    	//$data['data_jadwal'] = $this->statuspinjammodel->getJadwal();
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $sortBy = $this->input->post('sortBy');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        
        //total rows count
        $totalRec = count($this->statuspinjammodel->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php/penggunaan/StatusPinjamMhs/ajaxStatusPinjam';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['uri_segment']   = 4;

		// Bootstrap Stylings
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '<i class="glyphicon glyphicon-step-backward"></i>';
		$config['last_link'] = '<i class="glyphicon glyphicon-step-forward"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="glyphicon glyphicon-triangle-left"></i>';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="glyphicon glyphicon-triangle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->statuspinjammodel->getRows($conditions);
        
        //load the view
        $this->load->view('status_pinjam/ajax-status-pinjam-data', $data, false);
    }
}