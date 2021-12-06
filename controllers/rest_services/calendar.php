<?php defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
//class Scores extends REST_Controller {
class Calendar extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_calendar','mcalendar');
		$this->load->model('score/model_general','general');
		//$this->load->model('score/model_user','muser');
    }

	public function userLeagues_get(){
		$user_id  = $this->input->get('user_id');

		$user_details	 = $this->general->get_user($user_id);
		$get_tournaments = $this->mcalendar->get_user_tournaments($user_id, $user_details['Country']);

		//echo "<pre>"; print_r($get_tournaments); exit;
		if($get_tournaments){
			$tourn_list = '';

			//echo "test";
			foreach($get_tournaments as $tr) {
				if($tr->TournamentImage!="" and $tr->TournamentImage) { $img = $tr->TournamentImage; }
				else {
					switch($tr->SportsType) {
						case 1:
							$img = "default_tennis.jpg";
							break;
						case 2:
							$img = "default_table_tennis.jpg";
							break;
						case 3:
							$img = "default_badminton.jpg";
							break;
						case 4:
							$img = "default_golf.jpg";
							break;
						case 5:
							$img = "default_racquet_ball.jpg";
							break;
						case 6:
							$img = "default_squash.jpg";
							break;
						case 7:
							$img = "default_pickleball.jpg";
							break;
						case 8:
							$img = "default_chess.jpg";
							break;
						case 9:
							$img = "default_carroms.jpg";
							break;
						case 10:
							$img = "default_volleyball.jpg";
							break;
						case 11:
							$img = "default_fencing.jpg";
							break;
						case 12:
							$img = "default_bowling.jpg";
							break;
						case 16:
							$img = "default_cricket.jpg";
							break;
						default:
							//$img = "No Image";
					}
				}

				$temp = '';
				$temp = array(
				'Registered'		=> $tr->Registered,
				'tournament_ID'		=> $tr->tournament_ID,
				'tournament_title'  => $tr->tournament_title,
				'StartDate'			=> $tr->StartDate,
				'EndDate'			=> $tr->EndDate,
				'SportsType'		=> $tr->SportsType,
				'Sportname'			=> $tr->Sportname,
				'TournamentImage'	=> base_url()."tour_pictures/".$img,
				'Tournament_Format'	=> $tr->tournament_format,
				'TournamentCity'	=> $tr->TournamentCity,
				'TournamentState'	=> $tr->TournamentState,
				'TournamentCountry' => $tr->TournamentCountry,
				'latitude'			=> $tr->latitude,
				'longitude'			=> $tr->longitude
				);
				/*echo "<pre>";
				print_r($tourn_list);*/
				$tourn_list[] = $temp;
			}
			$this->response($tourn_list);	

		}
		else{
			$tourn_list[] = null;
			//$tourn_list = json_encode(array());

			$this->response($tourn_list);	

		}

			//$this->response($tourn_list);	
	}

	public function clubLeagues_get(){
		$user_id = $this->input->get('user_id');
		$club_id  = $this->input->get('club_id');

		$get_club_info = $this->mcalendar->get_club_info($club_id);
		$club_owner		= $get_club_info['Aca_User_id'];

		$get_tournaments	= $this->mcalendar->get_club_tournaments($club_owner);
		$get_events			= $this->mcalendar->get_club_events($club_owner);
		$now						= strtotime(date('Y-m-d H:i:s'));
		
		$tourn_list[] = null;

		//echo "<pre>"; print_r($get_tournaments); exit;
		if($get_tournaments){
			$tourn_list = '';

			foreach($get_tournaments as $tr) {
				if($tr->TournamentImage!="" and $tr->TournamentImage) { $img = $tr->TournamentImage; }
				else {
					switch($tr->SportsType) {
						case 1:
							$img = "default_tennis.jpg";
							break;
						case 2:
							$img = "default_table_tennis.jpg";
							break;
						case 3:
							$img = "default_badminton.jpg";
							break;
						case 4:
							$img = "default_golf.jpg";
							break;
						case 5:
							$img = "default_racquet_ball.jpg";
							break;
						case 6:
							$img = "default_squash.jpg";
							break;
						case 7:
							$img = "default_pickleball.jpg";
							break;
						case 8:
							$img = "default_chess.jpg";
							break;
						case 9:
							$img = "default_carroms.jpg";
							break;
						case 10:
							$img = "default_volleyball.jpg";
							break;
						case 11:
							$img = "default_fencing.jpg";
							break;
						case 12:
							$img = "default_bowling.jpg";
							break;
						case 16:
							$img = "default_cricket.jpg";
							break;
						default:
							//$img = "No Image";
					}
				}

				$reg_closedon = strtotime($tr->Registrationsclosedon);
				
				$is_reg_closed = 0;
				if($now > $reg_closedon)
					$is_reg_closed = 1;

				$temp = '';
				$temp = array(
							'tournament_ID'	=> $tr->tournament_ID,
							'tournament_title'  => $tr->tournament_title,
							'StartDate'			=> $tr->StartDate,
							'EndDate'				=> $tr->EndDate,
							'Registrationsclosedon' => $tr->Registrationsclosedon,
							'is_registration_closed' => $is_reg_closed,
							'TournamentImage'		 => base_url()."tour_pictures/".$img,
							'Tournament_Type'	 => $tr->tournament_type,
							'Tournament_Format'	 => $tr->tournament_format,
							'TournamentCity'		=> $tr->TournamentCity,
							'TournamentState'		=> $tr->TournamentState,
							'TournamentCountry' => $tr->TournamentCountry,
							'latitude'					=> $tr->latitude,
							'longitude'					=> $tr->longitude
							);

				/*echo "<pre>";
				print_r($tourn_list);*/
				$temp['is_register'] = $this->mcalendar->check_is_register($tr->tournament_ID, $user_id);
				$tourn_list[] = $temp;
			}

		if($get_events){
			foreach($get_events as $x => $event){

			$st = 0;	
			if($user_id)
			$st = $this->mcalendar->check_is_eventRegister($event['ID'], $user_id);
				
			$is_reg = 0;
			if($st > 0)
			$is_reg = 1;

			$event_end_date = strtotime($event['EndDate']);
			
			$is_ev_reg_closed = 0;
			if($now > $event_end_date)
			$is_ev_reg_closed = 1;

			$event['is_register']					= $is_reg;
			$event['is_registration_closed']	= $is_ev_reg_closed;
			$tourn_list[] = $event;
			}
		}
			//$this->response($tourn_list);	

		}


	$this->response($tourn_list);
	}


	public function clubLeaguesTemp_get(){
		$user_id					= $this->input->get('user_id');
		$get_tournaments	= $this->mcalendar->get_club_tournaments($user_id);
		$get_events				= $this->mcalendar->get_club_events($user_id);
			
		$tourn_list[] = null;

		//echo "<pre>"; print_r($get_tournaments); exit;
		if($get_tournaments){
			$tourn_list = '';

			foreach($get_tournaments as $tr) {
				if($tr->TournamentImage!="" and $tr->TournamentImage) { $img = $tr->TournamentImage; }
				else {
					switch($tr->SportsType) {
						case 1:
							$img = "default_tennis.jpg";
							break;
						case 2:
							$img = "default_table_tennis.jpg";
							break;
						case 3:
							$img = "default_badminton.jpg";
							break;
						case 4:
							$img = "default_golf.jpg";
							break;
						case 5:
							$img = "default_racquet_ball.jpg";
							break;
						case 6:
							$img = "default_squash.jpg";
							break;
						case 7:
							$img = "default_pickleball.jpg";
							break;
						case 8:
							$img = "default_chess.jpg";
							break;
						case 9:
							$img = "default_carroms.jpg";
							break;
						case 10:
							$img = "default_volleyball.jpg";
							break;
						case 11:
							$img = "default_fencing.jpg";
							break;
						case 12:
							$img = "default_bowling.jpg";
							break;
						case 16:
							$img = "default_cricket.jpg";
							break;
						default:
							//$img = "No Image";
					}
				}
				$temp = '';
				$temp = array(
				'tournament_ID'		=> $tr->tournament_ID,
				'tournament_title'  => $tr->tournament_title,
				'StartDate'			=> $tr->StartDate,
				'EndDate'			=> $tr->EndDate,
				'Registrationsclosedon' => $tr->Registrationsclosedon,
				'TournamentImage'	=> base_url()."tour_pictures/".$img,
				'Tournament_Format'	=> $tr->tournament_format,
				'TournamentCity'	=> $tr->TournamentCity,
				'TournamentState'	=> $tr->TournamentState,
				'TournamentCountry' => $tr->TournamentCountry,
				'latitude'			=> $tr->latitude,
				'longitude'			=> $tr->longitude
				);

				/*echo "<pre>";
				print_r($tourn_list);*/
				$tourn_list[] = $temp;
			}

		if($get_events){
			foreach($get_events as $x => $event){
			$tourn_list[] = $event;
			}
		}
			//$this->response($tourn_list);	

		}


	$this->response($tourn_list);

	}

}