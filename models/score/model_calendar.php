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
	
	public function get_club_info($club_id){
		$query = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID = {$club_id}");
		return $query->row_array();
	}

	public function check_is_register($tid, $user_id){
		$query = $this->db->query("SELECT * FROM RegisterTournament WHERE Users_ID = {$user_id} AND Tournament_ID = {$tid}");
		return $query->num_rows();
	}

	public function check_is_eventRegister($evID, $user_id){
		$query = $this->db->query("SELECT * FROM Ev_Inv_Status WHERE Ev_ID = {$evID} AND Users_Id = {$user_id}");
		return $query->num_rows();
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

	public function get_club_events($user_id = ''){
		if($user_id) {
			$query = $this->db->query("SELECT 
			ev.Ev_ID AS ID, et.Ev_Type AS Type, ev.Ev_Title AS Title, ev.Ev_Location AS Location,el.loc_title AS Location_Title, el.loc_address AS Location_Address, el.loc_city AS Location_City, el.loc_state AS Location_State, el.loc_country AS Location_Country, el.loc_zipcode AS Location_ZipCode, ev.Ev_Organizer AS Organizer, ev.Ev_Contact_Num AS Organizer_ContactNum, ev.Ev_Schedule AS Schedule, ev.Ev_Start_Date AS StartDate, ev.Ev_End_Date AS EndDate, ev.Ev_Created_by AS Created_by, ev.Ev_Created_Date AS Created_Date, ev.Ev_Desc AS Description, CONCAT('".base_url()."events_pictures/', ev.EventImage) AS Image,ev.Ev_Sport AS Sport_ID,st.Sportname AS SportTitle,ev.Is_Private, ev.Fee,ev.Fee_Type,ev.Ev_Reg_Limit as Reg_Limit,ev.Show_Guests FROM Events ev JOIN Events_Type et ON ev.Ev_Type_ID = et.Ev_Type_ID 
			JOIN SportsType st ON ev.Ev_Sport = st.SportsType_ID 
			LEFT JOIN Events_Locations el ON ev.Ev_Location = el.loc_id WHERE Ev_Created_by = {$user_id} ORDER BY Ev_Start_Date DESC");
		}
		else {
			$query = $this->db->query("SELECT 
			ev.Ev_ID AS ID, et.Ev_Type AS Type, ev.Ev_Title AS Title, ev.Ev_Location AS Location,el.loc_title AS Location_Title, ev.Ev_Organizer AS Organizer, ev.Ev_Contact_Num AS Organizer_ContactNum, ev.Ev_Schedule AS Schedule, ev.Ev_Start_Date AS StartDate, ev.Ev_End_Date AS EndDate, ev.Ev_Created_by AS Created_by, ev.Ev_Created_Date AS Created_Date, ev.Ev_Desc AS Description, CONCAT('".base_url()."events_pictures/', ev.EventImage) AS Image,ev.Ev_Sport AS Sport_ID,st.Sportname AS SportTitle,ev.Is_Private, ev.Fee,ev.Fee_Type,ev.Ev_Reg_Limit as Reg_Limit,ev.Show_Guests FROM Events ev JOIN Events_Type et ON ev.Ev_Type_ID = et.Ev_Type_ID 
			JOIN SportsType st ON ev.Ev_Sport = st.SportsType_ID 
			LEFT JOIN Events_Locations el ON ev.Ev_Location = el.loc_id ORDER BY Ev_Start_Date DESC");
		}

		if($query->num_rows() > 0){
			return $query->result_array();
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
		SELECT 1 as Registered, st.Sportname , t.* FROM tournament t INNER JOIN dbo.SportsType st ON st.SportsType_ID = t.SportsType WHERE tournament_ID IN (select b.tournament_ID from RegisterTournament b where b.users_id = '".$user_id."' or b.Team_Players like '%".$user_id."%') $country_cond ORDER BY t.StartDate DESC");

		//echo $this->db->last_query();
		//exit;
		return $query->result();
	}
}