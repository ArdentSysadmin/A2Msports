<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_calendar extends CI_Model {

	public $req_method;

	public function __construct(){
		parent:: __construct();
		$this->load->database();

		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$this->req_method = 'get';
		}
		else if($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->req_method = 'post';
		}
	}
	
	public function get_club_tournaments($user_id = ''){
		if($user_id){
		$query = $this->db->query("SELECT * FROM tournament WHERE Usersid = {$user_id} ORDER BY EndDate DESC");
		}
		else{
		$query = $this->db->query("SELECT * FROM tournament ORDER BY EndDate DESC");
		}

		if($query->num_rows() > 0){
			return $query->result();
		}
		else{
			return 0;
		}
	}

	public function get_user_tournaments($user_id, $country=''){

		$country_cond = "";

		if($country){
			$country_cond = "AND t.TournamentCountry = '{$country}'";
		}

		$today = date('Y-m-d');

		$query = $this->db->query("SELECT 0 as Registered, st.Sportname ,t.* FROM tournament t INNER JOIN SportsType st ON t.SportsType = st.SportsType_ID WHERE t.tournament_ID NOT IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' OR b.Team_Players LIKE '%".$user_id."%') $country_cond
		UNION all
		SELECT 1 as Registered, st.Sportname , t.* FROM tournament t INNER JOIN dbo.SportsType st ON st.SportsType_ID = t.SportsType WHERE tournament_ID IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%') $country_cond ORDER BY t.EndDate DESC");

		//echo $this->db->last_query();
		//exit;
		return $query->result();
	}
}