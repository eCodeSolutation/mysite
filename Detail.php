<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
    	$this->load->library('user_agent');
		$this->load->library('pagination');
        $this->load->library('form_validation');
	    $this->load->model('MeroTour_Static_Model');
	    $this->load->model('MeroTour_Query_Model');
		$this->load->model('MeroTour_peginatio_Model');
		$this->load->model('MeroTour_Message');
		$this->app_title 		= "Mero Tour";
		$this->page_title 		= "All detail";
		$this->primary_table 	= 'mt_hotel_detail';
        $this->hotels_table     = 'mt_register_property';
	 	$this->user_table 		= 'mero_touruser_login';
		$this->primary_redirect = 'mainadmin/detail';
		$this->primary_key 		= 'mt_detail_id';
    	if(!$this->session->userdata('AdMinLoginDash')){
			redirect('mainadmin/login');
         }
	}



	function index(){


		$data['page_title']= $this->page_title;
		$data['app_title'] = $this->app_title;
		$data['alldetail'] = $this->MeroTour_Query_Model->main_query($this->primary_table,"","","","","");
		$this->load->view('mainadmin/mt-all-detail/detail');

	}


	function alldetail(){


		$data['page_title']= $this->page_title;
		$data['app_title'] = $this->app_title;
		
		$this->load->view('mainadmin/mt-all-detail/add');

	}

	function add(){

		
		if($this->input->post('mt-about') or $this->input->post('mt-term') or $this->input->post('mt-policy') or $this->input->post('mt-feature')){

				$data['modefied']	    =	$this->MeroTour_Static_Model->getdate('datetime');
                $data['created']        =   $this->MeroTour_Static_Model->getdate('datetime');
                $data['active']			=   "Y";
                $data['user_id']		=  	"";  
                $data['googlemap']		=  	"";
                $data['feature_image']	=  	"";


				if($this->input->post('mt-about')){
				  	$data['about_us']  =  $this->input->post('aboutus');
				} else if($this->input->post('mt-term')){
					$data['terms_condition']  =  $this->input->post('terms');
				} else if($this->input->post('mt-policy')){
					$data['property_privacy_policy']  =  $this->input->post('priacy');
				} else if($this->input->post('mt-feature')){
					$data['property_feature']  =  $this->input->post('feature');
				}
				 
                $result   =  $this->MeroTour_Query_Model->insert($this->primary_table,$data);




		} else {

				$data['page_title']= $this->page_title;
				$data['app_title'] = $this->app_title;
				
				$this->load->view('mainadmin/mt-all-detail/add');

		}

	}



	function update(){

		
		if($this->input->post('mt-about') or $this->input->post('mt-term') or $this->input->post('mt-policy') or $this->input->post('mt-feature')){

				$data['modefied']	    =	$this->MeroTour_Static_Model->getdate('datetime');
                $data['created']        =   $this->MeroTour_Static_Model->getdate('datetime');
                $data['active']			=   "Y";
                $data['user_id']		=  	"";  
                $data['googlemap']		=  	"";
                $data['feature_image']	=  	"";


				if($this->input->post('mt-about')){
				  	$data['about_us']  =  $this->input->post('aboutus');
				} else if($this->input->post('mt-term')){
					$data['terms_condition']  =  $this->input->post('terms');
				} else if($this->input->post('mt-policy')){
					$data['property_privacy_policy']  =  $this->input->post('priacy');
				} else if($this->input->post('mt-feature')){
					$data['property_feature']  =  $this->input->post('feature');
				}
				$where =  array($this->primary_key=>$this->input->post('uid'));
                $result   =  $this->MeroTour_Query_Model->update($this->primary_table,$data,$where);




		} else {

				$data['page_title']= $this->page_title;
				$data['app_title'] = $this->app_title;
				$wh    				=	array($this->primary_key=>$this->uri->segment(4));
				$data['alldetail'] = $this->MeroTour_Query_Model->main_query($this->primary_table,"",$wh,"","","");
				
				$this->load->view('mainadmin/mt-all-detail/editdetail');

		}

	}


	function delete(){
		
		$where = array($this->primary_key=>$this->uri->segment(4));
		$baseurl =  base_url().'mainadmin/detail';
		$this->MeroTour_Query_Model->trash($this->primary_table,$where,$baseurl);
	}



}

?>