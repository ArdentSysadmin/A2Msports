<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_league extends CI_Model {

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

	public function get_tournaments($user_id, $country=''){

		$country_cond = "";

		if($country){
			$country_cond = "AND t.TournamentCountry = '{$country}'";
		}

		$today = date('Y-m-d');

		$query = $this->db->query("SELECT 0 as Registered, st.Sportname ,t.* FROM tournament t INNER JOIN SportsType st ON t.SportsType = st.SportsType_ID WHERE t.tournament_ID NOT IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' OR b.Team_Players LIKE '%".$user_id."%') $country_cond
		UNION all
		SELECT 1 as Registered, st.Sportname , t.* FROM tournament t INNER JOIN dbo.SportsType st ON st.SportsType_ID = t.SportsType WHERE tournament_ID IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%') $country_cond ORDER BY t.EndDate DESC");

/*$query = $this->db->query("select 0 as Registered, st.Sportname , t.* from tournament t inner join dbo.SportsType st on st.SportsType_ID = t.SportsType where StartDate > '".$today."'$country_cond and t.tournament_ID not in (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%')
UNION all
select 1 as Registered, st.Sportname , t.* from tournament t inner join dbo.SportsType st on st.SportsType_ID = t.SportsType where tournament_ID in (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%')$country_cond");*/

	//echo $this->db->last_query();
//exit;
		return $query->result();
	}

	public function getonerow($tourn_id){				   
		$data = array('tournament_ID'=>$tourn_id);
		$query = $this->db->get_where('tournament',$data);
		return $query->row_array();
	}

	public function get_league_details($tid){
		$query = $this->db->query("SELECT * FROM tournament WHERE tournament_ID = '".$tid."'");
		return $query->row_array();
	}
	
	public function get_user_reg($tid, $uid){
		$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '".$tid."' AND Users_ID = '".$uid."'");
		return $query->row_array();
	}
	
	public function update_reg_tourn($data){
		$tid = $data['Tournament_ID'];
		$uid = $data['Users_ID'];
		$upd_events = $data['upd_events'];

		$query = $this->db->query("UPDATE RegisterTournament SET Reg_Events = '".$upd_events."' WHERE 
		Tournament_ID = '".$tid."' AND Users_ID = '".$uid."'");

		return true;
	}
	
	public function inset_reg_tourn($data){
		$res = $this->db->insert('RegisterTournament', $data);
		return $this->db->last_query();
	}

	public function insert_pay_transaction($data2){
		$res = $this->db->insert('PayTransactions', $data2);
		return $this->db->last_query();
	}

	public function ins_temp($data){
		$res = $this->db->insert('Temp', $data);
		//return $this->db->last_query();
	}

	public function is_registered($id, $tourn_id, $type) {
		if($type == 'Team'){
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '".$tourn_id."' AND Team_id = '".$id."'");
             return $query->row_array();
		}
		else{
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '".$tourn_id."' AND Users_ID = '".$id."'");
             return $query->row_array();
		}
	}

	public function is_user_team_registered($id, $tourn_id) {
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Tournament_ID = '".$tourn_id."' AND Team_Players LIKE '%".'"'.$id.'"'."%'");
             return $query->row_array();
	}

	public function get_level_name($level_id) {
			$query = $this->db->query("SELECT * FROM SportsLevels WHERE SportsLevel_ID = {$level_id}");
             return $query->row_array();
	}

	public function get_reg_events($user_id, $tourn_id) {
			$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Users_ID = {$user_id} AND Tournament_ID = $tourn_id");
             return $query->row_array();
	}

	public function del_tourn_reguser($user_id, $tourn_id){
			$query = $this->db->query("DELETE FROM RegisterTournament WHERE Users_ID = {$user_id} AND Tournament_ID = $tourn_id");
	}

}