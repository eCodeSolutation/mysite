<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mtpages extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
    	$this->load->library('user_agent');
		$this->load->library('pagination');
        $this->load->library('form_validation');
	    $this->load->model('MeroTour_Static_Model');
	    $this->load->model('MeroTour_Query_Model');
		$this->load->model('MeroTour_peginatio_Model');
		$this->load->model('MeroTour_Message');
		$this->app_title 		= 	"Mero Tour Posts";
		$this->page_title 		=	"Property Type";
		$this->primary_table 	= 	'mt_pages';
		$this->primary_redirect = 	'mtpages';
		$this->primary_key 		= 	'page_id';
	}

	function index(){
		$data['app_title'] = $this->app_title;
		$data['page_title'] = $this->page_title;
		$table = $this->primary_table;
	 	$segment =  $this->uri->segment(3); 
	 	$perpage = 10;
	 	$baseurl = base_url("mtpages/index");
	 	$orderby = $this->primary_key;
	 	$order =  "desc";
		$data['page'] =  $this->MeroTour_peginatio_Model->pagination($table,$perpage,$baseurl,$orderby,$order,$segment);
		$this->load->view('mainadmin/mt-contents/pages/page',$data);
	}

	function add(){

		if($this->input->post('page') =='addpage'){
			
			// print_r($this->input->post());
			// die();
			$data['page_title']  	= 	$this->input->post('title');
			$data['contents']  		= 	$this->input->post('detail');
			$data['user_id']		= 	$this->MeroTour_Static_Model->admin_id();
			$data['slug']			= 	$this->MeroTour_Static_Model->Urlformat($data['page_title']);
			$data['feature_image']	= 	"";
			$data['active'] 	 	= 	$this->input->post('active');
			$data['created']   		=  	$this->MeroTour_Static_Model->getdate('datetime');
			

			$result = $this->MeroTour_Query_Model->insert($this->primary_table,$data);
			if($result==1){
				$this->session->set_userdata($this->MeroTour_Message->success());
				redirect('mainadmin/'.$this->primary_redirect);
			}else{
				$this->session->set_userdata($this->MeroTour_Message->error());
				redirect('mainadmin/'.$this->primary_redirect);	
			}
		}else{

			$data['app_title'] = $this->app_title;
			$data['page_title'] = $this->page_title;
			$this->load->view('mainadmin/mt-contents/pages/add',$data);


		}


	}

	function update(){
		if($this->input->post('category') === 'updateCat'){

			$data['page_title']  = $this->input->post('title');
			$data['user_id']		= 	$this->MeroTour_Static_Model->admin_id();
			$data['slug']			= 	$this->MeroTour_Static_Model->Urlformat($data['page_title']);
			$data['feature_image']	= 	"";
			$data['detail']	= 	$this->input->post('detail');
			$data['active'] 	 = 		$this->input->post('active');
			$data['created']   =  $this->MeroTour_Static_Model->getdate('datetime');

			$where = array($this->primary_key => $property_type_id);
			$result = $this->MeroTour_Query_Model->update($this->primary_table,$data,$where);
			if($result==1){
				$this->session->set_userdata($this->MeroTour_Message->success());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->MeroTour_Message->error());
				redirect($this->primary_redirect);	
			}
		}
	}

	function delete(){
		if($this->input->post('category')=='del'){
			$property_type_id = $this->input->post('category_id');
			$where = array($this->primary_key => $property_type_id);
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


}
