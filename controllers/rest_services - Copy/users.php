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
    }

	public function list_get() {

		$user_id = '';
		$page	 = '';

//echo "test"; exit;
		if($this->input->get('page'))
		$page = $this->input->get('page');

		$limit  = 25;

		if($this->input->get('user_id')){
		$user_id = $this->input->get('user_id');
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

			if($this->input->get('lat')){
			$search['latitude'] = $this->input->get('lat');
			}

			if($this->input->get('long')){
			$search['longitude'] = $this->input->get('long');
			}

		}

		$get_users = array("");

		if($page)
			$get_users = $this->muser->get_limit_users($user_id, $page, $limit, $search);
		else
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

}