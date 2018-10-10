<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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
		$this->page_title ="User Login";
		$this->primary_table = 'mero_touruser_login';
		$this->primary_key = 'user_id';
        $this->primary_redirect = "adminlogin";
        if(!$this->session->userdata('UsErLoGIn')){
			redirect('adminlogin');
		}
	}

	public function index()
	{
		$this->load->view('dashboard');
	}
}
