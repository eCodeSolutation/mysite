<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class FeaturePackage extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('upload');
    	$this->load->library('user_agent');
		$this->load->library('pagination');
		$this->load->model('MeroTour_Static_Model');
		$this->load->model('MeroTour_Query_Model');
		$this->load->model('MeroTour_peginatio_Model');
		$this->load->model('MeroTour_Message');
		$this->app_title = "Mero Tour";
		$this->page_title ="Menu Manager";
		$this->primary_table = 'MT_Featur_Package';
		$this->travel_package_table = 'mt_travel_itinerary_package';
		$this->permission_table = 'mero_tour_permission';
		$this->primary_redirect = 'FeaturePackage';
		$this->primary_key = 'feature_id';
		//$this->MeroTour_Static_Model->check_admin_login();
  //   	if(! $this->session->userdata('AdMinLoginDash')){
		// 	redirect('mainadmin/login');
		// }
	}

	function index(){
		$data['app_title'] = $this->app_title;
		$data['page_title'] = $this->page_title;
		$table 	 = $this->primary_table;
	 	$segment =  $this->uri->segment(4); 
	 	$perpage = 50;
	 	$baseurl = base_url("menu/index");
	 	$orderby = $this->primary_key;
	 	$order 	 =  "asc";
	 	$data['menulist'] 	 =  $this->MeroTour_peginatio_Model->pagination($table,$perpage,$baseurl,$orderby,$order,$segment);
	 	// $where 				 = array('menu_parent_id'=>'0');
	 	// $data['feature']  = $this->MeroTour_Query_Model->main_query($this->primary_table,"",$where,"","ASC","menu_id");
	 	$data['feature']  = $this->MeroTour_Query_Model->main_query($this->primary_table,"","","","","");
	 	$data['package']  	 = $this->MeroTour_Query_Model->main_query($this->travel_package_table,"","","","","");
		$this->load->view('mainadmin/mt-feature/list',$data);
	}

	function add(){

		if($this->input->post('feature') === 'feature'){

			if($this->input->post('custom_url')!=""){
				$url    =  $this->input->post('custom_url');
			} else { 
				$url    = "";

			}

			$data['package_id']  = $this->input->post('package');
			$data['duration_start']  = $this->input->post('start');
			$data['duration_end']  = $this->input->post('end');
			$data['created_by']  = $this->input->post('user');
			$data['custom_link']  = $url;
			$data['active'] 	 = 		$this->input->post('active');
			$data['created']   =  $this->MeroTour_Static_Model->getdate('datetime');
			$data['modefied']  =  $this->MeroTour_Static_Model->getdate('datetime');

			// print_r($_FILES['feature_image']);
			// die();

			if($_FILES['feature_image']['name']!=""){

            
		            $config['upload_path']          = './uploads/package-cat/';
		            $config['allowed_types']        = 'gif|jpg|png|bmp|jpeg';
		            $config['max_size']             = 1000;
		            // $config['min_width']            = 1324;
		            // $config['min_height']           = 450;

		            $this->load->library('upload',$config);
		            if ( ! $this->upload->do_upload('feature_image')) {
		               $this->session->set_userdata('fileupload',$this->upload->display_errors());
		               redirect($this->primary_redirect);
		            } else {
		                $filedetails = $this->upload->data();
		            }
		            $data['feature_image'] = $filedetails['file_name'];
		           }else{
		            $data['feature_image'] = ""; 
		           }


            
			$result = $this->db->insert($this->primary_table,$data);
			if($result==1){
				$this->session->set_userdata($this->MeroTour_Message->success());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->MeroTour_Message->error());
				redirect($this->primary_redirect);	
			}
		} else {
		  
          	$data['app_title'] = $this->app_title;
            $data['page_title'] = $this->page_title;
            $data['package']  	 = $this->MeroTour_Query_Model->main_query($this->travel_package_table,"","","","","");
		  	$this->load->view('mainadmin/mt-feature/add',$data);
		}
	}

	function update(){
		if($this->input->post('updatemenu') === 'menu'){

			$feature_id  		 	= $this->input->post('feature_id');
			$data['package_id']  	= $this->input->post('package');
			$data['duration_start'] = $this->input->post('start');
			$data['duration_end']  = $this->input->post('end');
			$data['created_by']  = $this->input->post('user');
			$data['active'] 	 = 		$this->input->post('active');
			$data['created']   =  $this->MeroTour_Static_Model->getdate('datetime');
			$data['modefied']  =  $this->MeroTour_Static_Model->getdate('datetime');

			
			$data['modefied']  			=  $this->MeroTour_Static_Model->getdate('datetime');
			$where = array($this->primary_key => $menu_id);
			$result = $this->MeroTour_Query_Model->update($this->primary_table,$data,$where);
			if($result==1){
				$this->session->set_userdata($this->MeroTour_Message->success());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->MeroTour_Message->error());
				redirect($this->primary_redirect);	
			}
		} else {
		 
          	$data['app_title'] = $this->app_title;
            $data['page_title'] = $this->page_title;
            $where =  array($this->primary_key=>$this->uri->segment(3));
           	$data['list'] = $this->MeroTour_Query_Model->main_query($this->primary_table,'',$where,'','','');
          	$this->load->view('mainadmin/menu/edit',$data);
		}
	}

	function delete(){
		
			$menu_id = $this->uri->segment(3);
			$where = array($this->primary_key => $menu_id);
			$result = $this->MeroTour_Query_Model->delete($this->primary_table,$where);
			if($result==1){
				$this->session->set_userdata($this->MeroTour_Message->trashed());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->MeroTour_Message->error());
				redirect($this->primary_redirect);
			}
		
	}


}
?>
