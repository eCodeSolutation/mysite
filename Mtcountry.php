<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Mtcountry extends CI_Controller {

    public function __construct(){
		parent:: __construct();
	//	$this->load->config('hotelconfig');
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
		$this->primary_table = 'mt_country';
	
		$this->permission_table = 'mero_tour_permission';
		$this->primary_redirect = 'mtcountry';
		$this->primary_key = 'country_id';
		
	}

		function index(){
		  
		  
        $data['app_title'] = $this->app_title;
		$data['page_title'] = $this->page_title;
		$table        = $this->primary_table;
	 	$segment      =  $this->uri->segment(3); 
	 	$perpage      = 10;
	 	$baseurl = base_url("mtcountry/index");
	 	$orderby = $this->primary_key;
	 	$order =  "desc";
       
	 	$data['countrylist'] =  $this->MeroTour_peginatio_Model->pagination($table,$perpage,$baseurl,$orderby,$order,$segment);
        
		$this->load->view('mainadmin/mt-country/country',$data);
	}
    
    function add(){

		if($this->input->post('addcountry') === 'country'){

			$data['country_name']  = $this->input->post('country_name');
			$data['country_code']  = $this->input->post('country_code');
			$data['dialing_code']  = $this->input->post('dialing_code');
			$data['active']  = $this->input->post('active');
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
		  	 $this->load->view('mainadmin/mt-country/add',$data);
		}
	}

	function update(){
		if($this->input->post('updatecountry') == 'country'){

			$country_id  = $this->input->post('country_id');
            
			$data['country_name']  = $this->input->post('country_name');
			$data['country_code']  = $this->input->post('country_code');
			$data['dialing_code']  = $this->input->post('dialing_code');
			$data['active']  = $this->input->post('active');
			$data['modefied']  =  $this->MeroTour_Static_Model->getdate('datetime');
			$where = array($this->primary_key => $country_id);
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
             $where = array($this->primary_key=>$this->uri->segment(3));
             $data['country'] = $this->MeroTour_Query_Model->main_query($this->primary_table,"",$where,"","","");
		  	 $this->load->view('mainadmin/mt-country/edit',$data);
		}
	}

	

	function delete(){
	
		    $type_id = $this->uri->segment(3);
			$where = array($this->primary_key=>$type_id);
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