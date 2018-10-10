<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mastermenu extends CI_Controller {

    public function __construct(){
		parent::__construct();
		//$this->load->config('hotelconfig');
		$this->load->library('session');
		$this->load->library('form_validation');
    	$this->load->library('user_agent');
		$this->load->library('pagination');
		 $this->load->model('MeroTour_Static_Model');
		 $this->load->model('MeroTour_Query_Model');
		$this->load->model('MeroTour_peginatio_Model');
		$this->load->model('MeroTour_Message');
		$this->app_title = "Mero Tour";
		$this->page_title ="Master Menu Manager";
		$this->primary_table = 'mero_tour_master_menu';
	
		$this->permission_table = 'mero_tour_permission';
		$this->primary_redirect = 'mainadmin/Mastermenu';
		$this->primary_key = 'master_menu_id';
		//$this->MeroTour_Static_Model->check_admin_login();
    	if(! $this->session->userdata('AdMinLoginDash')){
			redirect('mainadmin/login');
		}
	}

	function index(){
	   
   
		$data['app_title'] = $this->app_title;
		$data['page_title'] = $this->page_title;
		$table = $this->primary_table;
	 	$segment =  $this->uri->segment(4); 
	 	$perpage = 10;
	 	$baseurl = base_url("mainadmin/mastermenu/index");
	 	$orderby = $this->primary_key;
	 	$order =  "desc";
	 	$data['menulist'] =  $this->MeroTour_peginatio_Model->pagination($table,$perpage,$baseurl,$orderby,$order,$segment);
		$this->load->view('mainadmin/master-menu/menu/mastermenu',$data);
	}

	function add(){

		if($this->input->post('addmenu') === 'menu'){

			$data['master_menu_name']  = $this->input->post('master_menu_name');
			$data['menu_icon_class']  = $this->input->post('menu_icon_class');
			$data['active'] 	 = 		$this->input->post('active');
			$data['created']   =  $this->MeroTour_Static_Model->getdate('datetime');
			$data['modefied']  =  $this->MeroTour_Static_Model->getdate('datetime');

			$result = $this->MeroTour_Query_Model->insert($this->primary_table,$data);
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
          	$this->load->view('mainadmin/master-menu/menu/add',$data);
          
		}
	}

	function update(){
	  
		if($this->input->post('updatemenu') === 'menu'){
		  // print_r($this->input->post());
//       die();

			$master_menu_id  = $this->input->post('id');
			$data['master_menu_name']  = $this->input->post('master_menu_name');
			$data['menu_icon_class']  = $this->input->post('menu_icon_class');
			$data['active'] 	 = 		$this->input->post('active');
			$data['modefied']  =  $this->MeroTour_Static_Model->getdate('datetime');
			$where = array($this->primary_key => $master_menu_id);
			$result = $this->MeroTour_Query_Model->update($this->primary_table,$data,$where);
			if($result==1){
				$this->session->set_userdata($this->MeroTour_Message->success());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->MeroTour_Message->error());
				redirect($this->primary_redirect);	
			}
		}else {
		  
            $data['app_title'] = $this->app_title;
            $data['page_title'] = $this->page_title;
            $where =  array($this->primary_key=>$this->uri->segment(4));
           	$data['menu'] = $this->MeroTour_Query_Model->main_query($this->primary_table,'',$where,'','','');
          	$this->load->view('mainadmin/master-menu/menu/edit',$data);
          
		}
	}
	 
	 
	function delete(){
		
			//$menu_id = $this->uri->segment(4);
			$result = $this->db->where('master_menu_id',$this->uri->segment(4));
			$result = $this->db->delete('mero_tour_master_menu');
			if($result==1){
				$this->session->set_userdata($this->MeroTour_Message->trashed());
				redirect($this->primary_redirect);
			}else{
				$this->session->set_userdata($this->MeroTour_Message->error());
				redirect($this->primary_redirect);
			}
		
	}

	

}