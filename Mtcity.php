<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Mtcity extends CI_Controller {

    public function __construct(){
		parent:: __construct();
		$this->load->library('session');
		$this->load->library('form_validation');
    	$this->load->library('user_agent');
		$this->load->library('pagination');
	    $this->load->model('MeroTour_Static_Model');
	    $this->load->model('MeroTour_Query_Model');
		$this->load->model('MeroTour_peginatio_Model');
		$this->load->model('MeroTour_Message');
		$this->app_title = "Mero Tour";
		$this->page_title ="Country";
		$this->primary_table = 'mt_city';
        $this->seconday_table = 'mt_country';
		$this->permission_table = 'mero_tour_permission';
		$this->primary_redirect = 'mtcity';
		$this->primary_key = 'city_id';
		
	}
    
    function index(){
       // echo " Mero tour city list ";
//        die();
		$data['app_title'] = $this->app_title;
		$data['page_title'] = $this->page_title;
		$table = $this->primary_table;
	 	$segment =  $this->uri->segment(2); 
	 	$perpage = 10;
	 	$baseurl = base_url("mtcity/index");
	 	$orderby = $this->primary_key;
	 	$order =  "desc";
        $data['countrylist']  = $this->MeroTour_Query_Model->main_query($this->seconday_table,"","","","","");
	 	$data['citylist'] =  $this->MeroTour_peginatio_Model->pagination($table,$perpage,$baseurl,$orderby,$order,$segment);
        
	 
         
		$this->load->view('mainadmin/mt-city/city',$data);
	}

	function add(){

		if($this->input->post('addcity') == 'city'){

			$data['city_name']  = $this->input->post('city_name');
            $data['country_id']  = $this->input->post('country_id');
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
		}else {
		  
            $data['app_title'] = $this->app_title;
            $data['page_title'] = $this->page_title;
       	   
           	$data['countrylist']  = $this->MeroTour_Query_Model->main_query($this->seconday_table,"","","","","");
    		$this->load->view('mainadmin/mt-city/add',$data);
          
		}
	}

	function update(){
		if($this->input->post('updatecity') === 'city'){

			$city_id  = $this->input->post('city_id');
			$data['city_name']  = $this->input->post('city_name');
			$data['state_id']  = $this->input->post('state_id');
			$data['active'] 	 = 		$this->input->post('active');
			$data['modefied']  =  $this->MeroTour_Static_Model->getdate('datetime');
			$where = array($this->primary_key => $city_id);
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
            $where  = array($this->primary_key=>$this->uri->segment(3));
            
       	   	$data['countrylist']  = $this->MeroTour_Query_Model->main_query($this->seconday_table,"","","","","");
            $data['city']  = $this->MeroTour_Query_Model->main_query($this->primary_table,"",$where,"","","");
    		$this->load->view('mainadmin/mt-city/edit',$data);
          
		}
	}

	function delete(){
		if($this->uri->segment(4)!==""){
			$city_id = $this->uri->segment(3);
			$where = array($this->primary_key => $city_id);
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
?>