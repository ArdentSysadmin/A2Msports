<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
	class api extends CI_Controller {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_news');
			$this->load->model('model_general');
			
		}
		
		
		public function index()
		{
		  $data['results'] = $this->model_news->get_news();
		  $this->load->view('includes/header');
		  $this->load->view('view_about_us');
		  $this->load->view('includes/view_right_column',$data);
		  $this->load->view('includes/footer');
		  
			
		}
		public function login()
		{
			$username = $_GET["username"];
			$arr = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
			echo json_encode($username);
			
		}

			
	} 
	
?>