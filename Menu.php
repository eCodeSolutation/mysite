<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
    	$this->load->library('user_agent');
		$this->load->library('pagination');
		$this->load->model('MeroTour_Static_Model');
		$this->load->model('MeroTour_Query_Model');
		$this->load->model('MeroTour_peginatio_Model');
		$this->load->model('MeroTour_Message');
		$this->app_title = "Mero Tour";
		$this->page_title ="Menu Manager";
		$this->primary_table = 'merotour_menu_setup';
		$this->permission_table = 'mero_tour_permission';
		$this->primary_redirect = 'menu';
		$this->primary_key = 'menu_id';
		//$this->MeroTour_Static_Model->check_admin_login();
  //   	if(! $this->session->userdata('AdMinLoginDash')){
		// 	redirect('mainadmin/login');
		// }
	}

	function index(){
		$data['app_title'] = $this->app_title;
		$data['page_title'] = $this->page_title;
		$table = $this->primary_table;
	 	$segment =  $this->uri->segment(4); 
	 	$perpage = 50;
	 	$baseurl = base_url("menu/index");
	 	$orderby = $this->primary_key;
	 	$order =  "asc";
	 	$data['menulist'] =  $this->MeroTour_peginatio_Model->pagination($table,$perpage,$baseurl,$orderby,$order,$segment);
	 	$where = array('menu_parent_id'=>'0');
	 	$data['parentlist']  = $this->MeroTour_Query_Model->main_query($this->primary_table,"",$where,"","ASC","menu_id");
	 	$data['lastweight']  = $this->MeroTour_Query_Model->main_query($this->primary_table,"weigth","","1","DESC","menu_id");
		$this->load->view('mainadmin/menu/menu',$data);
	}

	function add(){

		if($this->input->post('addmenu') === 'menu'){

			$data['menu_name']  = $this->input->post('menu_name');
			$data['pseudo_name']  = $this->input->post('pseudo_name');
			$data['menu_parent_id']  = $this->input->post('menu_parent_id');
			$data['menu_icon_class']  = $this->input->post('menu_icon_class');
			$data['menu_custom_url']  = $this->input->post('menu_custom_url');
			$data['master_menu']  = $this->input->post('master_menu');
			$data['menu_for']  = $this->input->post('menu_for');
			$data['weigth']  = $this->input->post('weigth');
			$data['nav_menu_for']  = "tour";  
			$data['active'] 	 = 		$this->input->post('active');
			$data['created']   =  $this->MeroTour_Static_Model->getdate('datetime');
			$data['modefied']  =  $this->MeroTour_Static_Model->getdate('datetime');
            
			$result = $this->db->insert('merotour_menu_setup',$data);
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
		  	$this->load->view('mainadmin/menu/add',$data);
		}
	}

	function update(){
		if($this->input->post('updatemenu') === 'menu'){

			$menu_id  					= $this->input->post('menu_id');
			$data['menu_name']  		= $this->input->post('menu_name');
			$data['pseudo_name']  		= $this->input->post('pseudo_name');
			$data['menu_parent_id']  	= $this->input->post('menu_parent_id');
			$data['menu_icon_class']  	= $this->input->post('menu_icon_class');
			$data['menu_custom_url']  	= $this->input->post('menu_custom_url');
			$data['master_menu']  		= $this->input->post('master_menu');
			$data['menu_for']  			= $this->input->post('menu_for');
			$data['weigth']  			= $this->input->post('weigth');
			$data['nav_menu_for']  		= "tour"; 
			$data['active'] 	 		= 		$this->input->post('active');
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
