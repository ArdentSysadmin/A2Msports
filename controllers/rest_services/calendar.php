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
		$user_id		 = $this->input->get('user_id');
		$get_tournaments = $this->mcalendar->get_club_tournaments($user_id);

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
			$this->response($tourn_list);	

		}
		else{
			$tourn_list[] = null;
			//$tourn_list = json_encode(array());

			$this->response($tourn_list);	

		}

			//$this->response($tourn_list);	
	}	

}