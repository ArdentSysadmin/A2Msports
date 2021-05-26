<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//League controller ..
class Error404 extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		$this->load->model('model_news');
		$this->load->model('model_general', 'general');
		$this->load->helper(array('form', 'url'));
	}
	
	public function error_page()
	{
		$data['results'] = $this->model_news->get_news();
		$this->load->view('includes/header');
		$this->load->view('404_Page');
		$this->load->view('includes/view_right_column', $data);
		$this->load->view('includes/footer');
	}

	public function offline()
	{
		$data['results'] = $this->model_news->get_news();
		//$this->load->view('includes/header');
		$this->load->view('Offline_Page');
		//$this->load->view('includes/view_right_column', $data);
		//$this->load->view('includes/footer');
	}

}