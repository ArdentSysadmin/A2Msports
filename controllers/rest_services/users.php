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
class Users extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();


		//$this->load->model('score/model_team','mteam');
		$this->load->model('score/model_user','muser');
		$this->load->model('score/model_general','general');

		//error_reporting(-1);
    }

	public function testing_get() {
				$user_id = $this->input->get('user_id');

		$get_users = array("user" => $user_id);
		$this->response($get_users);
	}

	public function list_get() {

		$user_id = '';

		if($this->input->get('user_id')){
		$user_id = $this->input->get('user_id');
		}

		$get_users = array("");

		$get_users = $this->muser->get_users($user_id);
		
		//foreach($get_users as $user){
			//$revised_team = array();

			/*$revised_team['Team_name']  = $team->Team_name;
			$revised_team['Sport']		= $team->Sport;
			$revised_team['Created_by'] = $team->Created_by;
			$revised_team['Captain']	= $team->Captain;
			$revised_team['Status']		= $team->Status;
			$revised_team['Team_Logo']	= $team->Team_Logo;

			$players = json_decode($team->Players, TRUE);
			
			$team_players = array();
			foreach($players as $p){
				$get_player = $this->muser->get_user_details(intval($p));
				$team_players[$p]['FirstName']  = $get_player['Firstname'];
				$team_players[$p]['LastName']   = $get_player['Lastname'];
			}

			$revised_team['Team_Players']	= $team_players;

			$get_hl = $this->mteam->get_home_loc($team->Home_loc_id);

			$revised_team['Home_Loc_Title']		= $get_hl['hcl_title'];
			$revised_team['Home_Loc_City']		= $get_hl['hcl_city'];
			$revised_team['Home_Loc_State']		= $get_hl['hcl_state'];
			$revised_team['Home_Loc_Country']	= $get_hl['hcl_country'];
			
			$final_team[$team->Team_ID] = $revised_team;*/
		//}

		$this->response($get_users);
	}

	public function listNew_get() {

		$user_id = '';
		$page	 = '';
		$club_id	 = '';

//echo "test"; exit;
		if($this->input->get('page'))
		$page = $this->input->get('page');

		if($this->input->get('is_coach'))
		$is_coach = $this->input->get('is_coach');

		$limit  = 25;

		if($this->input->get('user_id')){
		$user_id = $this->input->get('user_id');
		}
		elseif($this->input->get('club_id')){
		$club_id = $this->input->get('club_id');
		}

		$is_sort = false;
		$sport   = "";
		if($this->input->get('sortByRank') and $this->input->get('sport')){
		$is_sort = $this->input->get('sortByRank');
		$sport   = $this->input->get('sport');
		}

		$search = '';

		if($this->input->get('act') == 'search'){

			if($this->input->get('name')){
			$search['name'] = $this->input->get('name');
			}
		
			if($this->input->get('sport')){
			$search['sport'] = $this->input->get('sport');
			}
		
			if($this->input->get('level')){
			$search['sp_level'] = $this->input->get('level');
			}
		
			if($this->input->get('distance')){
			$search['distance'] = $this->input->get('distance');
			}

			if($this->input->get('city')){
			$search['city'] = $this->input->get('city');
			}

			if($this->input->get('state')){
			$search['state'] = $this->input->get('state');
			}

			if($this->input->get('lat')){
			$search['latitude'] = $this->input->get('lat');
			}

			if($this->input->get('long')){
			$search['longitude'] = $this->input->get('long');
			}

		}

		$get_users = array("");

		if($page and !$club_id and $is_coach )
			$get_users = $this->muser->get_limit_coachUsers($user_id, $page, $limit, $search, $is_sort, $sport);
		else if($page and $user_id)
			$get_users = $this->muser->get_limit_users($user_id, $page, $limit, $search, $is_sort, $sport);
		//else if($page and $club_id and !$is_coach)
		else if($club_id and !$is_coach)
			$get_users = $this->muser->get_club_members($club_id, $page, $limit, $search, $is_sort, $sport);
		else if($page and $club_id and $is_coach)
			$get_users = $this->muser->get_club_coaches($club_id, $page, $limit, $search, $is_sort, $sport);
		else if($user_id)
			$get_users = $this->muser->get_users($user_id, $is_sort, $sport);
		else
			$get_users = array("Error: Something went wrong!", 400);
		
		$this->benchmark->mark('code_end');
		$response_time = $this->benchmark->elapsed_time('code_start', 'code_end');
		$get_users['response_time'] = $response_time;

		$this->response($get_users);
	}

	public function usersList_test_get(){
		echo "Testing";
		exit;
		$this->output->enable_profiler(TRUE);
		$user_id = $this->input->get('user_id');
	$get_users = $this->muser->get_users_temp($user_id);

// Some code happens here

	$this->response($get_users);
	}
	
	public function stats_get(){
		if($this->input->get('user_id')){
			$user_id = $this->input->get('user_id');

			$sp_intrests .= "(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16)";

			$sports = array(
				'1' => 'Tennis',
'2' => 'Table Tennis',
'3' => 'Badminton',
'4' => 'Golf',
'5' => 'Racquetball',
'6' => 'Squash',
'7' => 'Pickleball',
'8' => 'Chess',
'9' => 'Carroms',
'10' => 'Volleyball',
'11' => 'Fencing',
'12' => 'Bowling',
'13' => 'Soccer',
'14' => 'Lacrosse',
'15' => 'Throwball',
'16' => 'Cricket',
'17' => 'General Fitness');


			$get_ranks  = $this->muser->get_user_a2m_ranks($user_id);
			$get_ranks_city  = $this->muser->get_user_a2m_ranks_city($user_id);

			$get_stats1  = $this->muser->get_user_single_stats($user_id, $sp_intrests);
			$get_stats2  = $this->muser->get_user_line_stats($user_id, $sp_intrests);
			$get_stats = array_merge($get_stats1, $get_stats2);

	//echo "<pre>"; print_r($data['user_tournment_matches']); exit;
	//echo "<pre>"; print_r($get_ranks); exit;
			$played = 0;
			$won    = 0;
			$lost   = 0;
			$points_for     = 0;
			$points_against = 0;
			$stats			= array();
			foreach($get_stats as $utm){
				if($utm->Winner != 0 and $utm->Winner != NULL){

				if($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner 
				or $user_id == $utm->Player2 or $user_id == $utm->Player2_Partner){
				($stats[$utm->SportsType]['played']) ? 
					$stats[$utm->SportsType]['played']++ : $stats[$utm->SportsType]['played'] = 1;
					//echo "<br>".$utm->Tourn_ID." ".$utm->Tourn_match_id;
				}
				if(
					$user_id == $utm->Winner or 
					($user_id == $utm->Player1_Partner and $utm->Winner == $utm->Player1) or 
					($user_id == $utm->Player2_Partner and $utm->Winner == $utm->Player2)
				  )
				{
				($stats[$utm->SportsType]['won']) ? 
					$stats[$utm->SportsType]['won']++ : $stats[$utm->SportsType]['won'] = 1;
					//echo "<br>1 ".$utm->Tourn_ID." ".$utm->Tourn_match_id;

				}
				else if($user_id != $utm->Winner and $utm->Winner != NULL){
				($stats[$utm->SportsType]['lost']) ? 
					$stats[$utm->SportsType]['lost']++ : $stats[$utm->SportsType]['lost'] = 1;
				}

				$for_score	   = ($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner) ?
								 $utm->Player1_Score : $utm->Player2_Score;

				$against_score = ($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner) ?
									 $utm->Player2_Score : $utm->Player1_Score;
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						($stats[$utm->SportsType]['points_for']) ? 
							$stats[$utm->SportsType]['points_for'] += $tot : $stats[$utm->SportsType]['points_for'] = $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						($stats[$utm->SportsType]['points_against']) ? 
							$stats[$utm->SportsType]['points_against'] += $tot : $stats[$utm->SportsType]['points_against'] = $tot;
					}
				}
			}
			foreach($stats as $sp=>$res){
				$ind = $this->searchForId($user_id, $sp, $get_ranks);
				//$ind = array_search($user_id, $sp, array_column($get_ranks, 'Users_ID'),array_column($get_ranks, 'SportsType_ID'));
				$rank = null;
				$a2m			 = null;
				$a2m_dbl	 = null;
				$a2m_mxd = null;
				if($ind > -1){
					$rank			= $get_ranks[$ind]['Rank'];
					$a2m			= $get_ranks[$ind]['A2MScore'];
					$a2m_dbl  = $get_ranks[$ind]['A2MScore_Doubles'];
					$a2m_mxd = $get_ranks[$ind]['A2MScore_Mixed'];
				}

				$ind2 = $this->searchForId($user_id, $sp, $get_ranks_city);
				//$ind = array_search($user_id, $sp, array_column($get_ranks, 'Users_ID'),array_column($get_ranks, 'SportsType_ID'));
				$city_rank = null;
				if($ind2 > -1){
					$city_rank			= $get_ranks_city[$ind2]['Rank'];
				}
				$match_win_per  = ($res['won'] / $res['played']) * 100;
				$score_diff				= ($res['points_for'] - $res['points_against']);
				$pd							= $score_diff / $res['played'];
			//	echo $get_winper['Win_Per']; 
				$get_winper = $this->muser->get_winper($sp, $user_id);
 
				$pd_win_per = $pd + $match_win_per;

				$temp_arr[] = array('sport_id'		 => $sp, 
													'sport_name' => $sports[$sp], 
													'played'			 => $res['played'], 
													'won'				 => $res['won'], 
													'lost'				 => $res['lost'],
													'points_for'	 => $res['points_for'],
													'points_against' => $res['points_against'],
													'a2mscore'					=> $a2m,
													'a2mscore_doubles' => $a2m_dbl,
													'a2mscore_mixed'	=> $a2m_mxd,
													'state_rank' => $rank,
													'city_rank' => $city_rank,
													'matches_win_percent' => number_format($match_win_per, 2),
													'score_diff' => ($res['points_for'] - $res['points_against']),
													'win_percent' => $get_winper['Win_Per'],
													'sd_mp' => number_format($pd, 2),
													'sd_mp_win%' => number_format($pd_win_per, 2),

													);
			}

			/*echo "<pre>";
			print_r($temp_arr);
			exit;*/

			$data['user_stats'] = $temp_arr;
						$this->response($data, 200);

		}
		else{
			$this->response(array("User ID is mandatory!"), 400);
		}
	}

			public function searchForId($user_id, $sport, $array) {
				foreach ($array as $key => $val) {
					//echo $key;
					if ($val['Users_ID'] == $user_id and $val['SportsType_ID'] == $sport) {
					   return $key;
					}
				}
				return null;
			}

			public function newSignup_post() {
				$post_data = json_decode(trim(file_get_contents('php://input')), true);

				$fname		= $data['fname'] 		= trim($post_data['firstname'], '"');
				$lname		= $data['lname'] 		= trim($post_data['lastname'], '"');
				//$mphone	= $data['mphone']  = trim($post_data['mobile'], '"');

				//--------------------------
				$token			= trim($post_data['token']);
				$exp			= explode('.', $token);
				$arr				= json_decode(base64_decode($exp[1]), true);
				$exp_time	= $arr['exp'];
				$cur_time	= strtotime(date('Y-m-d H:i:s'));

				if($cur_time < $exp_time) {
				$phone	 = $arr['phone_number'];
				$mphone = $data['mphone']  = substr($phone, -10);
				}
				else {
				$this->response("Token Expired!");
				exit;
				}
				//--------------------------

				$gender		= $data['gender'] 	= trim($post_data['gender'], '"');
				$email			= $data['email'] 		= trim($post_data['email'], '"');
				$club_id		= $data['club_id'] 	= trim($post_data['club_id'], '"');

				if($post_data['sp_interests']) {
					//$sp_int			= $post_data['sp_interests'];
					$data['sp_int'] = $post_data['sp_interests'];
					//$data['sp_int'] = json_encode($sp_int, true);
				}
				else {
					$data['sp_int'] = array();
				}

				if($mphone) {
					$check_user_exists = 0;
					if($email)
					$check_user_exists = $this->general->get_email($email);
					
					if(!$check_user_exists) {		
						$ins_user = $this->muser->instant_register($data);

						if(!empty($ins_user)) {
							/*$users_id			= $ins_user['users_id'];							
							$res[$users_id]  = $fname.' '.$lname;*/

							$user_det = array(
											'user_id'   => $ins_user['users_id'],
											'firstname'  => $ins_user['firstname'],
											'lastname'  => $ins_user['lastname'],
											'email'		   => $ins_user['email']
											);

							$this->response($user_det);
						}
						else {
							$this->response("Something went wrong!");
						}
					}
					else {
						$this->response("User with this email id already exists! Email ID should be Unique");
						exit;
					}
				}
				else {
					$this->response("Invalid Token!");
					exit;
				}

			}

			public function matches_get(){
				$user_id = $this->input->get('user_id');		
				$user_matches = $this->muser->get_user_matches($user_id);

				if($user_matches){
					$this->response($user_matches);
				}
				else{
					$user_matches = array("No Matches Found!");
					$this->response($user_matches);
				}
			}
}