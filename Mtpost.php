<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mtpost extends CI_Controller {

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
		$this->primary_table 	= 	'mt_post_content';
		$this->category_table 	= 	'mt_post_category';
		$this->primary_redirect = 	'mtpost';
		$this->primary_key 		= 	'post_id';
	}

	function index(){
		$data['app_title'] = $this->app_title;
		$data['page_title'] = $this->page_title;
		// $data['category']   =  $this->MeroTour_Query_Model->select_data($this->primary_table,'','','','','');
	  	$data['category']   =  $this->MeroTour_Query_Model->main_query($this->category_table,'','','','','');
	  	$data['post']   	=  $this->MeroTour_Query_Model->main_query($this->primary_table,'','','','','');
		$this->load->view('mainadmin/mt-contents/posts/posts',$data);
	}
 
	function add(){

		
		if($this->input->post('addpost')=='addpost'){
			// print_r($this->input->post());
			// die();
			
			$data['post_title']  	= 	$this->input->post('title');
			$data['content']  		= 	$this->input->post('detail');
			$data['user_id']		= 	$this->MeroTour_Static_Model->admin_id();
			$data['category_id']	= 	implode(',', $this->input->post('category'));
			$data['feature_image']	= 	$this->input->post('feature_image');
			$data['slug']			= 	$this->MeroTour_Static_Model->Urlformat($data['post_title']);
			$data['active'] 		= 	$this->input->post('active');
			$data['created']   		=  	$this->MeroTour_Static_Model->getdate('datetime');
			// print_r($data);
			// die();
			

			$result = $this->MeroTour_Query_Model->insert($this->primary_table,$data);
			if($result==1){
				$this->session->set_userdata($this->message->success());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->message->error());
				redirect($this->primary_redirect);	
			}
		}else{


			$data['app_title'] = $this->app_title;
			$data['page_title'] = $this->page_title;
			$data['category']   =  $this->MeroTour_Query_Model->main_query($this->category_table,'','','','','');
			$this->load->view('mainadmin/mt-contents/posts/add',$data);


		}
	}

	function update(){
		if($this->input->post('updatepost') === 'updatepost'){

			$data['post_title']  	= $this->input->post('title');
			$data['user_id']		= 	$this->MeroTour_Static_Model->admin_id();
			$data['category_id']	= 	implode(',', $this->input->post('category'));
			$data['feature_image']	= 	"";
			$data['contents']		= 	$this->input->post('detail');
			$data['slug']			= 	$this->MeroTour_Static_Model->Urlformat($data['post_title']);
			$data['active'] 	 	= 	$this->input->post('active');
			$data['created']  		=  $this->MeroTour_Static_Model->getdate('datetime');

			$where = array($this->primary_key => $property_type_id);
			$result = $this->MeroTour_Query_Model->update($this->primary_table,$data,$where);
			if($result==1){
				$this->session->set_userdata($this->message->success());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->message->error());
				redirect($this->primary_redirect);	
			}
		}else{


			$data['app_title'] = $this->app_title;
			$data['page_title'] = $this->page_title;
			$data['category']   =  $this->MeroTour_Query_Model->select_data($this->category_table,'','','','','');
			$this->load->view('mainadmin/mt-contents/posts/edit',$data);


		}
	}

	function delete(){
		if($this->input->post('category')=='del'){
			$property_type_id = $this->input->post('post_id');
			$where = array($this->primary_key => $property_type_id);
			$result = $this->MeroTour_Query_Model->delete($this->primary_table,$where);
			if($result==1){
				$this->session->set_userdata($this->message->trashed());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->message->error());
				redirect($this->primary_redirect);
			}
		}
	}


}
?>