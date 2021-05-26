<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Event Reminder controller ..
class league_remainder extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();

		$this->load->helper(array('form', 'url'));

		$this->load->model('model_reminder','reminder');
		$this->load->model('model_general', 'general');
		//$this->load->model('model_news');
	}

	public function index()
	{
		$get_tourn_matches = $this->reminder->get_tourn_matches();

		if(count($get_tourn_matches) < 1){
			echo "No Tournament matches are due to add score!";
			exit;
		}

		$get_users		  = array();
		$email_sent_users = array();


		foreach($get_tourn_matches as $tour){
		
			$tour_id	  = $tour->Tourn_ID;

			$get_tour_det = $this->reminder->get_tour_det($tour_id);
			$tour_creator = $get_tour_det['Usersid'];
			$player1	  = $tour->Player1;
			$player2	  = $tour->Player2;

			if(!in_array($tour_creator, $email_sent_users)){
				$this->send_email_user($tour_creator, $tour_id);
				$email_sent_users[] = $tour_creator;
			}
			if(!in_array($player1, $email_sent_users)){
				$this->send_email_user($player1, $tour_id);
				$email_sent_users[] = $player1;
			}
			if(!in_array($player2, $email_sent_users)){
				$this->send_email_user($player2, $tour_id);
				$email_sent_users[] = $player2;
			}

		}
	 }

	public function send_email_user($user, $tour_id){

		//echo $user." - ".$tour_id."<br>";

		$tour_det   = $this->reminder->get_tour_det($tour_id);
		$tour_title = $tour_det['tournament_title'];

		$sql	= "SELECT * FROM users WHERE Users_ID = " .$user;
		$result = $this->db->query($sql);
		$row	= $result->row();

		if($row->EmailID != ""){
			$user_email = trim($row->EmailID);
		} 
		else{
			$user_email = trim($row->AlternateEmailID);
		}
	
		$this->load->library('email');
		$this->email->set_newline("\r\n");

		$this->email->from(FROM_EMAIL, 'A2mSports');
		$this->email->to($user_email);
		$this->email->subject("Reminder for " . $tour_title);

		$data = array(
		'firstname'=> $row->Firstname,
		'lastname'=> $row->Lastname,
		'tour_id' => $tour_id,
		'tour_title' => $tour_title,
		'page'=> 'AddScore Reminder to Players'
		);

		$body = $this->load->view('view_email_template.php',$data,TRUE);

		$this->email->message($body);
		
		$s_email = $this->email->send();

		if($s_email)
			{ echo "Success<br/>"; }
		else 
			{ echo "Fail<br/>"; }	

	}

}