<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Mediamanager extends CI_Controller {

	public function __construct(){
		Parent:: __construct();

		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('string');
		$this->load->helper('directory');
		$this->load->helper('url');
		$this->load->config('hotelconfig');
		$this->load->config('static');
	    $this->load->model('MeroTour_Static_Model');
	    $this->load->model('MeroTour_Query_Model');
		$this->load->model('MeroTour_peginatio_Model');
		$this->load->model('MeroTour_Message');
		$this->app_title = "Mero Tour";
		$this->page_title ="User Mnager";
		$this->user_id = $this->MeroTour_Static_Model->admin_id();
		//$this->MeroTour_Static_Model->check_user_login();
	}


	function index(){
		$data['page_title'] = "Media Manager";
		$data['app_title'] = $this->app_title;
		$data['user_id'] = $this->user_id;
		$data['images'] = directory_map($this->config->item('HM_IMAGE_DIR').$this->user_id);
		$this->load->view('mainadmin/mediamanager/mediamanager',$data);
	}

	function add(){
	  
		if($_FILES['userimage']['name'] !=""){
		$config['upload_path']          = $this->config->item('HM_IMAGE_DIR').$this->user_id;
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10240;

        $this->load->library('upload', $config);

       // $this->upload->initialize($config);
        if (!$this->upload->do_upload("userimage")){
            $data['error'] = $this->upload->display_errors().'Click on "Remove" and try again!';
            echo json_encode($data); 
        }else{
        	 echo json_encode('success'); 
        	/*
        	$config['image_library'] = 'gd2';
			$config['source_image'] = $this->config->item('HM_IMAGE_DIR').$this->user_id."/".$_FILES['userimage']['name'];
			$config['create_thumb'] 	= TRUE;
			$config['create_thumb'] 	= TRUE;
			$config['maintain_ratio'] 	= TRUE;
			$config['width']         	= 75;
			$config['height']       	= 50;
			$this->load->library('image_lib', $config);
			if ( ! $this->image_lib->resize())
			{
			$this->session->set_userdata('errormessage', $this->image_lib->display_errors("<p class='text-danger'>","</p>"));
			}	
			*/
        		//$data['success'] ="Successfully Uploaded !!";
           // echo json_encode($data); 
        }
      }            
    }



    function uploadfile(){

    	if($this->input->post('uploadfile')=='file'){
    		$userid  = $this->input->get('uid');
	  
				if($_FILES['userimage']['name'] !=""){
				$config['upload_path']          = $this->config->item('HM_IMAGE_DIR').$userid;
		        $config['allowed_types']        = 'gif|jpg|png';
		        $config['max_size']             = 10240;

		        $this->load->library('upload', $config);

		       // $this->upload->initialize($config);
		        if (!$this->upload->do_upload("userimage")){
		            $data['error'] = $this->upload->display_errors().'Click on "Remove" and try again!';
		            echo json_encode($data); 
		        }else{
		        	 echo json_encode('success'); 
		 
		        }
		      }            
		    } else{ 
		    		$this->load->view('mainadmin/uploader');

		    }

		}


    function hotelimage(){



	  	$userid   =   $this->input->get('ui');
		if($_FILES['userimage']['name'] !=""){
		$config['upload_path']          = $this->config->item('HM_IMAGE_DIR').$userid;
        $config['allowed_types']        = 'gif|jpg|png|gif';
        $config['max_size']             = 10240;

        $this->load->library('upload', $config);

       // $this->upload->initialize($config);
        if (!$this->upload->do_upload("userimage")){
            $data['error'] = $this->upload->display_errors().'Click on "Remove" and try again!';
            echo json_encode($data); 
        }else{
        	 echo json_encode('success'); 
        	
        }
      }            
    }

    function update(){
    	if($this->input->post('updateimage')=='Save Changes'){
	    	$oldname = $this->input->post('oldname');
	    	$newname = $this->input->post('newname');
	    	echo $path  = $this->config->item('HM_IMAGE_DIR').$this->user_id."/";
	    	if(file_exists($path.$oldname))
	    	{
	    		rename($path.$oldname, $path.$newname);
	    		redirect('mediamanager');
	    	}else{
	    		redirect('mediamanager');
	    	}
    	}

    }

    function delete(){
    	echo $imagename = $this->uri->segment(3);
    	echo $path  = $this->config->item('HM_IMAGE_DIR').$this->user_id."/";
    	if(file_exists($path.$imagename))
		{
			unlink($path.$imagename);
			redirect('mediamanager');
		}else{
			redirect('mediamanager');
		}

    }
	
}

?>