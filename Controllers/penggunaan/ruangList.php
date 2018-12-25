<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RuangList extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('service');
		$this->load->model('penggunaan/ruangrapatmodel');
		$this->load->model('penggunaan/ruang_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('Ajax_pagination');
		$this->perPage = 10;
	}

	public function index(){
        //load the view
		$this->layout();
        $this->load->view('ruang/ajax-ruang-index');
	}

    function ajaxRuangData(){
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
        $totalRec = count($this->ruang_model->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php/penggunaan/ruangList/ajaxRuangData';
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
        $data['posts'] = $this->ruang_model->getRows($conditions);
        
        //load the view
        $this->load->view('ruang/ajax-ruang-data', $data, false);
    }

	public function layout(){
		/*$userlogin = 'x';
		$this->session->userdata['logged_in']['username'] = 'x';
		$this->service->getFoto($userlogin);
		$this->service->getNama($userlogin);*/

		$userlogin = $this->session->userdata['logged_in']['username'];
		$data_header['foto'] = $this->service->getFoto($userlogin);
		$data_header['nama'] = $this->service->getNama($userlogin);
		$data['ruang'] 		= $this->ruangrapatmodel->getRuang();
		$data['menu'] 		= $this->load->view('layout/3_menu', $data, true);		
		$data['script'] = $this->load->view('layout/template-2', null, true);
		$this->load->view('layout/1-head-title');
		$this->load->view('layout/2-header', $data_header);		
		$this->load->view('layout/3-menu', $data);
	}
	
	public function edit(){
		// Proses ke database
		$i = $this->input;
		$id = $i->post('id');
		$field = $i->post('field');
		$value = $i->post('value');
		
		$data = array(
			'id' => $id,
			'field' => $field,
			'value' => $value
		);
		
		$this->ruang_model->edit($data);
		$this->session->set_flashdata('sukses','Data telah diedit');
	}
	
	public function upload(){
		if(!empty($_FILES['file_upload']['name'])) {
			
			//define key file name
			$array_type = array(
				'application/msword'=>'doc', 
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document'=>'docx',
				'image/png'=>'.png',
				'image/jpg'=>'.jpg',
				'image/jpeg'=>'.jpeg',
				'image/bmg'=>'.bmg',
				'application/pdf' => '.pdf'
			);
			$file_type = $_FILES['file_upload']['type'];
			$file_ext = $array_type[$file_type];
			$file_name = $this->input->post('post_foto').$file_ext;
				
			//Define folder
			$path = './dokumen/ruang/';
			$path_thumbs = './dokumen/ruang/thumbs/';

			//Define file rules
			$config['upload_path'] 		= $path;
			$config['file_name'] 		= $file_name;
			$config['allowed_types'] 	= 'gif|jpg|jpeg|png|bmp';
			$config['max_size']			= '550000'; // KB	
			$this->load->library('upload', $config);

        	//hapus file yg sudah ada
        	$file_hapus = $path.$file_name;
        	$file_thumbs_hapus = $path_thumbs.$file_name;
			if(file_exists($file_hapus)){unlink($file_hapus);}
			if(file_exists($file_thumbs_hapus)){unlink($file_thumbs_hapus);}	

			if (!$this->upload->do_upload('file_upload')) {
                $error = array('error' => $this->upload->display_errors());
                echo $this->upload->display_errors();
            } else {
            	//update database -> field file_ext
            	$data_foto = array(
            		'kd_ruang' => $this->input->post('post_foto'),
            		'file_ext' => str_replace('.', '', $file_ext)  //buang tanda titik didepannya
            	);
            	$this->ruang_model->edit_foto($data_foto);

                //upload file
                $data = $this->upload->data();
                
                // create Thumbnail
	            $upload_data = array('uploads' =>$this->upload->data());
	            $config = array(
					'image_library' => 'gd2',
					'source_image'  => $path.$upload_data['uploads']['file_name'], 
					'new_image'  => $path_thumbs,
					'create_thumb' => TRUE,
					'quality' => "100%",
					'maintain_ratio' => TRUE,
					'width' => 360, // Pixel
					'height' => 200, // Pixel
					'x_axis' => 0,
					'y_axis' => 0,
					'thumb_marker' => ''
	            );
	            
	            $this->load->library('image_lib', $config);
				$this->image_lib->resize();
            } 

            echo '
            <div style="margin:auto;align:center"><img src="'.base_url().'dokumen/ruang/'.$file_name.'"></div>';
            
			print_r( $_FILES );
			print_r( $this->upload->data() );
/*
            <script>
			var id = $("#foto-'.$this->input->post('post_foto').'")
            alert(id)
            </script>            
            getElementByID("#foto-'.$this->input->post('post_foto').'")
            $("#foto-'.$this->input->post('post_foto').'").html("test")
			*/
		}
		
	}
}