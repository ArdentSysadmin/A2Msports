<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Logout extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();

		$this->load->model('academy_mdl/model_academy');
		$this->load->library(array('session','form_validation'));
		$this->load->library('facebook');
		}
		
		public function index($org_id = '')
		{	
			$org_details			= $this->model_academy->get_academy_details($org_id); 
		//echo "before ".$this->session->userdata('user');
			$this->session->sess_destroy();
		//	echo "after ".$this->session->userdata('user');
		//	exit;
		$this->load->helper('cookie');
delete_cookie("ci_session");
				if($org_details['Aca_URL_ShortCode'])
				redirect($org_details['Aca_URL_ShortCode']);
				else
				redirect('login');
	    }

		public function fb_logout($data = '')
		{
			$this->session->sess_destroy();
			$this->facebook->destroySession();
			redirect('/');
	    }
	}