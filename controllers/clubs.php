<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//Clubs controller ..
class Clubs extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('session');

		$this->load->model('model_clubs');
		$this->load->model('model_general', 'general');
		$this->load->model('model_news', 'news');
	}

	public function index()
	{
		$url_seg	= $this->uri->segment(1); 
		$last_url	= array('redirect_to' => $url_seg);
		$this->session->set_userdata($last_url);

		$data['sports']	 = $this->general->get_sports();
		$data['clubs']	 = $this->model_clubs->get_clubs();
		$data['results'] = $this->news->get_news();

		$this->load->view('includes/header');
		$this->load->view('view_book_court',$data);			//view_addscore_newmatch.php
		$this->load->view('includes/view_right_column',$data);
		$this->load->view('includes/footer');
	}

	/*public function get_user_det($user_id){
		return $this->general->get_user($user_id);
	}

	public function add()
	{
		$data['intrests']	 = $this->model_event->get_intrests();
		$data['event_types'] = $this->model_event->get_event_types();
		$data['results']	 = $this->model_news->get_news();

		$this->load->view('includes/header');
		$this->load->view('view_event',$data);
		$this->load->view('includes/view_right_column',$data);
		$this->load->view('includes/footer');
	}*/
	public function subscribe($mem_code){
		$user_id = $this->session->userdata('users_id');
		
		if($user_id){
			$check_is_valid_sub = $this->model_clubs->is_valid_subscr($mem_code, $user_id);
			if(count($check_is_valid_sub) > 0){
					echo "Testing!<br>";
			}
			else{
				echo "Invalid Access!<br>";
			}
		}
		else{
			echo "Invalid Access!<br>";
		}

		echo $user_id." ".$mem_code; exit;
	}

	public function test2(){
		$this->load->view('Raj2');
	}

}