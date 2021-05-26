<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Event Reminder controller ..
class event_reminder extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();

		$this->load->helper(array('form', 'url'));

		$this->load->model('model_reminder','reminder');
		$this->load->model('model_general', 'general');
		$this->load->model('model_news');
	}

	public function index()
	{
		$rep_events = $this->reminder->get_rep_events();

		if(count($rep_events) < 1){
			echo "No events has to send reminders for today!";
			exit;
		}

		foreach($rep_events as $rep){

			$ev_id = $rep->Ev_ID;
			$ev_rep_id = $rep->Ev_Tab_ID;
			
			$get_users = $this->reminder->get_rep_event_users($ev_id, $ev_rep_id);
					
			$get_ev_creator = $this->reminder->getonerow($ev_id);
			$ev_creator = $get_ev_creator['Ev_Created_by'];

			$this->send_email_user($ev_creator, $ev_id);

			$filter_rep_users = array();
			$filter_rep_users[0] = $ev_creator;

			$i=1;

			if(count($get_users) < 1){
				echo "No Users are invited yet for the event $ev_id<br/>";
			}
		
			foreach($get_users as $us){
				
				if(!in_array($us->Users_Id, $filter_rep_users)){
				
					$user = $us->Users_Id;
					$this->send_email_user($user, $ev_id);
				}

				$filter_rep_users[$i] = $us->Users_Id;
				$i++;
			}
			
		}
	}

	public function send_email_user($user, $ev_id){

		$ev_det = $this->reminder->getonerow($ev_id);
		$ev_title = $ev_det['Ev_Title'];

		$sql = "SELECT * FROM users WHERE Users_ID = " .$user;
		$result = $this->db->query($sql);
		$row = $result->row();

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
		$this->email->subject("Reminder for " . $ev_title . " - A2MSports");

		$data = array(
		'firstname'=> $row->Firstname,
		'lastname'=> $row->Lastname,
		'ev_id' => $ev_id,
		'ev_title' => $ev_title,
		'ev_rep_id' => $ev_rep_id,
		'page'=> 'Events Reminder to Players'
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