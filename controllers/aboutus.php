<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
	class Aboutus extends CI_Controller {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_news');
			$this->load->model('model_general', 'general');		
		}
			
		public function index()
		{
		  $data['results'] = $this->model_news->get_news();
		  $this->load->view('includes/header');
		  $this->load->view('view_about_us');
		  $this->load->view('includes/view_right_column',$data);
		  $this->load->view('includes/footer');		
		}

		public function v1(){
		  //$data['results'] = $this->model_news->get_news();
		  //$this->load->view('includes/header');
		  $this->load->view('view_about_us_v1');
		  //$this->load->view('includes/view_right_column',$data);
		  //$this->load->view('includes/footer');		
		}
	}
?>