<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Logout extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();
		
		$this->load->library(array('session','form_validation'));
		$this->load->library('facebook');
		}
		
		public function index($data = '')
		{
			$this->session->sess_destroy();
			redirect('login');
	    }

		public function fb_logout($data = '')
		{
			$this->session->sess_destroy();
			$this->facebook->destroySession();
			redirect('/');
	    }
	}