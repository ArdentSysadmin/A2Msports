<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Classes controller ..
class classes extends CI_Controller {

	public function __construct() {
		parent:: __construct();

		$this->load->helper(array('form', 'url'));
		
		// Load session library
		$this->load->library('session');
		/*if(!$this->session->userdata('user')){
			redirect('login');
		}*/

		$this->load->model('model_classes');
		$this->load->model('model_general', 'general');
		$this->load->model('model_news');
	}

	public function index()
	{
		$url_seg = $this->uri->segment(1); 
		$last_url = array('redirect_to'=>$url_seg);
		$this->session->set_userdata($last_url);

		$data['event_types'] = $this->model_classes->get_event_types();
		$data['results']	 = $this->model_news->get_news();
		$this->load->view('includes/header');
		$this->load->view('view_classes',$data);
		$this->load->view('includes/view_right_column',$data);
		$this->load->view('includes/footer');
	}


}