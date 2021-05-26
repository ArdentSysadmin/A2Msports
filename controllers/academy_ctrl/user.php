<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
	class User extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_user');
		}
		
		// viewing league page ...
		public function index()
		{
			
			//print_r($this->session->userdata);
			//exit;
			$admin = $this->session->userdata('admin');
			if($admin){
				$this->load->view('includes/header');
				$this->load->view('view_admin');
				$this->load->view('includes/view_right_column');
				$this->load->view('includes/footer');
			}
			else
			{
				echo "<h4>Unauthorized Access</h4>";
			}
		}
		
		
		public function new_profile()
		{
			$this->load->view('includes/header');
			$this->load->view('view_add_profile');
			$this->load->view('includes/footer');
		}
		
	}