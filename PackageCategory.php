 <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PackageCategory extends CI_Controller {

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
		$this->app_title            = "Mero Tour";
		$this->page_title           = "Room Category";
        $this->primary_table        = 'mt_travel_package_category';
		$this->permission_table     = 'mero_tour_permission'; 
        $this->country_table        = 'mt_country';
        $this->city_table           = 'mt_city';
       
		$this->primary_redirect     = 'packagecategory';
		$this->primary_key          = 'package_category_id';
		$this->image_url   			= 'http://localhost:81/package/uploads/package-cat/';
    	if(! $this->session->userdata('UsErLoGIn')){
			redirect('admin');
		}
	}

	function index(){

			$feat['app_title']       = $this->app_title;
			$feat['page_title']   = $this->page_title;
            $feat['cat']   =  $this->MeroTour_Query_Model->main_query($this->primary_table,'','','','','');
            $feat['image_url']	=	$this->image_url;
			$this->load->view('travel-admin/package-category/category',$feat);
	}

	function add(){
            $feat['app_title']       = $this->app_title;
			$feat['page_title']   = $this->page_title;
			$this->load->view('travel-admin/package-category/newcat',$feat);
	}

	function update(){
            $feat['app_title']      = 	$this->app_title;
			$feat['page_title']   	= 	$this->page_title;
            $where  				= 	array($this->primary_key=>$this->uri->segment(3));
            $feat['image_url']		=	$this->image_url;
            $feat['cat']   			=  	$this->MeroTour_Query_Model->main_query($this->primary_table,'',$where,'','','');

			$this->load->view('travel-admin/package-category/editcat',$feat);
	}

	function actions(){
		if($this->input->post('addRcat') or $this->input->post('updateRcat')){
			$this->form_validation->set_rules('title','Category Title','trim|required');
			if($this->form_validation->run() == FALSE){

					$feat['cat']   =  $this->MeroTour_Query_Model->main_query($this->primary_table,'','','','','');
					$feat['image_url']	=	$this->image_url;
					$this->load->view('travel-admin/package-category/category',$feat);

			}else{
				 
				 
				$data 				= 	array(); 
				$data['package_category_title']	=	$this->input->post('title'); 
				$data['active']	                		=	$this->input->post('is_active');
				

				 if($_FILES['feature_image']['name']!=""){
            
		            $config['upload_path']          = './uploads/package-cat/';
		            $config['allowed_types']        = 'gif|jpg|png|bmp|jpeg';
		            $config['min_size']             = 6000;
		            $config['min_width']            = 1024;
		            $config['min_height']           = 768;

		            $this->load->library('upload',$config);

		            if ( ! $this->upload->do_upload('feature_image'))
		            {
		               $this->session->set_userdata('fileupload',$this->upload->display_errors());
		               redirect($this->primary_redirect);

		            }
		            else
		            {
		                $filedetails = $this->upload->data();
		            }
		            $data['package_category_feature_image'] = $filedetails['file_name'];
		           }else{
		            $data['package_category_feature_image'] = ""; 
		           }


				if($this->input->post('addRcat')=="Submit"){

				$data['created']  = $this->MeroTour_Static_Model->getdate('datetime');
				$result = $this->db->insert($this->primary_table,$data);


			     }else if($this->input->post('updateRcat')=="Submit"){
			         
			     	$data['created']  = $this->input->post('created');
			     	$this->db->where($this->primary_key,$this->input->post('id'));
			     	$result = $this->db->update($this->primary_table,$data);
			     	
			     }else{

			     		$feat['cat']   =  $this->MeroTour_Query_Model->main_query($this->primary_table,'','','','','');
			     		$feat['image_url']	=	$this->image_url;
						$this->load->view('travel-admin/package-category/category',$feat);
			     }
				if($result){
					$this->session->set_userdata($this->MeroTour_Message->success());
					redirect($this->primary_redirect);
				}else{
					$this->session->set_userdata($this->MeroTour_Message->error());
					redirect($this->primary_redirect);
				}
			}	
		
		}else {

			$feat['cat']   =  $this->MeroTour_Query_Model->main_query($this->primary_table,'','','','','');
			$feat['image_url']	=	$this->image_url;
			$this->load->view('travel-admin/package-category/category',$feat);

		}
	}

	function delete(){
	
		$where = array($this->primary_key=>$this->uri->segment(3));
		$baseurl =  $this->primary_redirect;
		$this->MeroTour_Query_Model->trash($this->primary_table,$where,$baseurl);
	}
}