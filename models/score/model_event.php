<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_event extends CI_Model {

	public $req_method;
	public $country_arr;
	public $country_str;

	public function __construct(){
		parent:: __construct();
		$this->load->database();

		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$this->req_method = 'get';
		}
		else if($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->req_method = 'post';
		}

		$this->country_arr = array('United States of America', 'USA', 'US', 'United States');
		$this->country_str = "('United States of America', 'USA', 'US', 'United States')";
	}

	public function get_events($club_id = ''){
		if($club_id){
			$get_club = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID = {$club_id}");
			$club_det = $get_club->row_array();

				if($club_det['Aca_User_id']){
					$query = $this->db->query("SELECT ev.Ev_ID AS ID, et.Ev_Type AS Type, ev.Ev_Title AS Title, ev.Ev_Location AS Location,el.loc_title AS Location_Title, el.loc_address AS Location_Address, el.loc_city AS Location_City, el.loc_state AS Location_State, el.loc_country AS Location_Country, el.loc_zipcode AS Location_ZipCode, ev.Ev_Organizer AS Organizer, ev.Ev_Contact_Num AS Organizer_ContactNum, ev.Ev_Schedule AS Schedule, ev.Ev_Start_Date AS StartDate, ev.Ev_End_Date AS EndDate, ev.Ev_Created_by AS Created_by, ev.Ev_Created_Date AS Created_Date, ev.Ev_Desc AS Description, CONCAT('".base_url()."events_pictures/', ev.EventImage) AS Image,ev.Ev_Sport AS Sport_ID,st.Sportname AS SportTitle,ev.Is_Private, ev.Fee,ev.Fee_Type,ev.Ev_Reg_Limit as Reg_Limit,ev.Show_Guests FROM Events ev JOIN Events_Type et ON ev.Ev_Type_ID = et.Ev_Type_ID 
					JOIN SportsType st ON ev.Ev_Sport = st.SportsType_ID 
					LEFT JOIN Events_Locations el ON ev.Ev_Location = el.loc_id WHERE Ev_Created_by = {$club_det['Aca_User_id']}");
					$res = $query->result();
				}
				else{
					$res = null;
				}
		}
		else{
			$query = $this->db->query("SELECT ev.Ev_ID AS ID, et.Ev_Type AS Type, ev.Ev_Title AS Title, ev.Ev_Location AS Location,el.loc_title AS Location_Title, el.loc_address AS Location_Address, el.loc_city AS Location_City, el.loc_state AS Location_State, el.loc_country AS Location_Country, el.loc_zipcode AS Location_ZipCode, ev.Ev_Organizer AS Organizer, ev.Ev_Contact_Num AS Organizer_ContactNum, ev.Ev_Schedule AS Schedule, ev.Ev_Start_Date AS StartDate, ev.Ev_End_Date AS EndDate, ev.Ev_Created_by AS Created_by, ev.Ev_Created_Date AS Created_Date, ev.Ev_Desc AS Description, CONCAT('".base_url()."events_pictures/', ev.EventImage) AS Image,ev.Ev_Sport AS Sport_ID,st.Sportname AS SportTitle,ev.Is_Private, ev.Fee,ev.Fee_Type,ev.Ev_Reg_Limit as Reg_Limit,ev.Show_Guests 
			FROM Events ev JOIN Events_Type et ON ev.Ev_Type_ID = et.Ev_Type_ID 
			JOIN SportsType st ON ev.Ev_Sport = st.SportsType_ID 
			LEFT JOIN Events_Locations el ON ev.Ev_Location = el.loc_id");
			$res = $query->result();
		}
		return $res;
	}

	public function event_details($event_id = ''){
		$event_det = '';

		if($event_id){
			$get_event	= $this->db->query("SELECT 
			ev.Ev_ID AS ID, et.Ev_Type AS Type, ev.Ev_Title AS Title, ev.Ev_Location AS Location,el.loc_title AS Location_Title, el.loc_address AS Location_Address, el.loc_city AS Location_City, el.loc_state AS Location_State, el.loc_country AS Location_Country, el.loc_zipcode AS Location_ZipCode, ev.Ev_Organizer AS Organizer, ev.Ev_Contact_Num AS Organizer_ContactNum, ev.Ev_Schedule AS Schedule, ev.Ev_Start_Date AS StartDate, ev.Ev_End_Date AS EndDate, ev.Ev_Created_by AS Created_by, ev.Ev_Created_Date AS Created_Date, ev.Ev_Desc AS Description, CONCAT('".base_url()."events_pictures/', ev.EventImage) AS Image,ev.Ev_Sport AS Sport_ID,st.Sportname AS SportTitle,ev.Is_Private, CONVERT(float, ev.Fee) AS Fee,ev.Fee_Type,ev.Ev_Reg_Limit as Reg_Limit,ev.Show_Guests
			FROM Events ev JOIN Events_Type et ON ev.Ev_Type_ID = et.Ev_Type_ID 
			JOIN SportsType st ON ev.Ev_Sport = st.SportsType_ID 
			LEFT JOIN Events_Locations el ON ev.Ev_Location = el.loc_id
			WHERE Ev_ID = {$event_id}");

			$event_det	= $get_event->row_array();
		}
		
		return $event_det;		
	}

	public function event_dates($event_id = ''){
		$event_det = '';

		if($event_id){
			$get_event	= $this->db->query("SELECT evr.*,el.loc_title AS Location_Title FROM Ev_Repeat_Schedule evr LEFT JOIN Events_Locations el ON evr.Ev_Location = el.loc_id 
			WHERE Ev_ID = {$event_id}");
			$event_det	= $get_event->result();
		}
		
		return $event_det;		
	}

	public function get_event_info($ev_id) {				   
		$data = array('Ev_ID' => $ev_id);
		$query = $this->db->get_where('Events', $data);
		return $query->row_array();
	}

	public function check_event_rep($ev_id, $rep_id) {				   
		$data = array('Ev_ID' => $ev_id, 'Ev_Tab_ID' => $rep_id);
		$query = $this->db->get_where('Ev_Repeat_Schedule', $data);
		return $query->num_rows();
	}

	public function get_event_inv($data) {				   
		$query = $this->db->get_where('Ev_Inv_Status', $data);
		//echo $this->db->last_query(); exit;
		return $query->row_array();
	}

	public function ins_ev_invite($data)	{
		$user_id		= $data['user'];
		$event_id		= $data['event_id'];
		$ev_rep_id	= $data['ev_rep_id'];
		$status			= $data['ev_status'];

		$data = array(
				'Ev_ID'		=> $event_id,
				'Ev_Rep_ID' => $ev_rep_id,
				'Users_Id'  => $user_id,
				'Ev_status' => $status
				);

		$result = $this->db->insert('Ev_Inv_Status', $data);
		return  $result; 
	}

	public function upd_ev_invite($data, $data2){

			$this->db->where($data);
			$result = $this->db->update('Ev_Inv_Status', $data2); 
//echo $this->db->last_query(); exit;
		return  $result; 
	}

	public function ins_pay_trans($data){
		$result = $this->db->insert('PayTransactions', $data);
		return $result;
	}

	public function get_participants($event_id){
		$event_det = '';
		if($event_id){
			$get_rep	= $this->db->query("SELECT evr.*,el.loc_title AS Location_Title FROM Ev_Repeat_Schedule evr LEFT JOIN Events_Locations el ON evr.Ev_Location = el.loc_id 
			WHERE Ev_ID = {$event_id}");
			$event_reps = $get_rep->result();
			
			foreach($event_reps as $rep){
			$get_parts	= $this->db->query("SELECT eis.Ev_Inv_ID, eis.Users_Id, u.Firstname, u.Lastname, eis.EV_Comments, eis.Ev_status FROM Ev_Inv_Status eis LEFT JOIN Users u ON eis.Users_Id = u.Users_ID WHERE Ev_Rep_ID = {$rep->Ev_Tab_ID}");
			//echo $this->db->last_query(); exit;
			$parts_list = $get_parts->result();
				$result['Ev_Tab_ID'] = $rep->Ev_Tab_ID;
				$result['Ev_Date']		= $rep->Ev_Date;
				$result['Ev_Start_Time']	= $rep->Ev_Start_Time;
				$result['Ev_End_Time']		= $rep->Ev_End_Time;
				$result['Ev_Location']		= $rep->Ev_Location;
				$result['Location_Title']		= $rep->Location_Title;
				$result['Participants']		= $parts_list;
			}
			$output[] = $result;

		return $output;
		}
	}

	public function get_event_userStatus($event_id, $user_id){
		$qry = $this->db->query("SELECT eis.Ev_Rep_ID, eis.Ev_status FROM Ev_Inv_Status eis WHERE eis.Ev_ID = {$event_id} AND eis.Users_Id = {$user_id}");

		$res = null;
		if($qry->num_rows > 0)
		$res = $qry->result();

			return $res;
	}

	public function search_autocomplete_users($data)
		{			
			$key = $data['key'];
			$club_id = $data['club_id'];
			
			/*$this->db->select('*');
			$this->db->from('users');
			$this->db->like('Firstname', $key); 
			$this->db->or_like('Lastname', $key);
			$this->db->or_like(CONCAT('Firstname' + ' ' + 'Lastname') AS fullname, $key);
			
			$query = $this->db->get();*/
			if($club_id){
			$query = $this->db->query("SELECT * FROM Users u WHERE u.Firstname+' '+u.Lastname LIKE '%{$key}%' AND Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = {$club_id} AND Member_Status = 1)");
			}
			else{
			$query = $this->db->query("SELECT * FROM Users u WHERE u.Firstname+' '+u.Lastname LIKE '%{$key}%'");
			}
			return $query->result();
		}
		
		public function search_autocomplete_event_locations($data)
		{			
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('Events_Locations');
			$this->db->like('loc_title', $key); 
			
			$query = $this->db->get();
			return $query->result();
		}

		public function create_event_location($data)
		{	
			$points = $data['latt'];

			//$values = explode('@',$points);
			$loc_lat  = $points['latitude'];
			$loc_long = $points['longitude'];
			
			$title	 = $data['title'];
		    $add	 = $data['add'];
			$city	 = $data['city'];
			$state	 = $data['state'];
			$country = $data['country'];
		    $zip	 = $data['zip'];
			$user_id = $data['user_id'];

			$data = array(
					'loc_title'   => $title,
					'loc_address' => $add,
					'loc_city' 	  => $city,
					'loc_state'   => $state,
					'loc_country' => $country,
					'loc_zipcode' => $zip,
					'loc_created_by' => $user_id,
					'loc_lat' 		 => $loc_lat,
					'loc_long' 		 => $loc_long
				);

			$result = $this->db->insert('Events_Locations', $data);
		    return  $this->db->insert_id(); 	
	    }

		public function get_event_types(){
			$query = $this->db->query("SELECT Ev_Type_ID, Ev_Type FROM Events_Type WHERE Ev_Type_Status = 1");
		
			return $query->result();
		}

		public function create_event($data) {
			//echo "<pre>"; print_r($data); exit;

			$filename				= $data['ev_img'];
			
			$event_title			= $data['ev_title'];
			$event_type			= $data['ev_type'];

			$event_location		= $data['ev_loc'];

			$created_by			= $data['ev_created_by'];
			$event_org				= $data['ev_organizer'];
			$event_contact		= $data['ev_org_contact'];

			$is_private				= $data['is_private'];

			$start_date			=  date('Y-m-d H:i:s', $data['ev_st_time']);
			$end_date				=  date('Y-m-d H:i:s', $data['ev_ed_time']);
			
			$event_created_date	= date("Y-m-d H:i:s");
			$event_schedule			= $data['ev_schedule'];
			$message						= $data['ev_desc'];
			$sport_type					= NULL;
			
			$fee_oc							= "Single";
			$fee_amount					= $data['ev_fee'];

			$ev_reps							= $data['ev_reps'];
			$ev_invitees					= $data['ev_invitees_users'];

			$ev_invitees_clubs		 = $data['ev_invitees_clubs'];
			$ev_invitees_teams		 = $data['ev_invitees_teams'];
			$ev_invitees_leagues	 = $data['ev_invitees_leagues'];

			$ev_notes						= $data['ev_notes'];

//echo "<pre>"; print_r($ev_reps); exit;
			$show_guest = 1;

			$data = array(
					'Ev_Type_ID'			 => $event_type,
					'EventImage'			 => $filename,
				    'Ev_Title'					 => $event_title,
					'Ev_Location'			 => NULL,
					'Ev_Organizer'		 => $event_org,
					'Ev_Contact_Num' => $event_contact,
					'Ev_Schedule'			 => $event_schedule,
					'Ev_Start_Date'		=> $start_date,
					'Ev_End_Date'		=> $end_date,
					'Ev_Created_by'		=> $created_by,
					'Ev_Created_Date' => $event_created_date,
					'Is_Private'				=> $is_private,
					'Ev_Desc'				=> $message,
					'Ev_Sport'				=> $sport_type,
					'Fee_Type'				=> $fee_oc,
					'Fee'						=> number_format($fee_amount, 2),
					'Show_Guests'		=> 1,
					'Ev_Geo_Location'	 => $event_location,
					'Notes'					=> $ev_notes,
					'Allowed_Teams'		=> $ev_invitees_teams,
					'Allowed_Clubs'			=> $ev_invitees_clubs,
					'Allowed_Leagues'		=> $ev_invitees_leagues
					);
				//echo "<pre>"; print_r($data); exit;
			 $result = $this->db->insert('Events', $data);
			 
			 //echo $this->db->last_query(); exit;

			$ev_id  = $this->db->insert_id();
	
			//$ev_id = 999;


			foreach($ev_reps as $i => $rep){
				$data2 = array(
									'Ev_ID'					=> $ev_id,
									'Ev_Date'			=> date('Y-m-d', $rep['startTime']),
									'Ev_Start_Time' => date('H:i', $rep['startTime']),
									'Ev_End_Time'	=> date('H:i', $rep['endTime']),
									'Ev_Location'		=> NULL,
									'Ev_Geo_Location'	=> $event_location
									);
				//echo "<pre>"; print_r($data2); 
				 $ins_event_repeat = $this->db->insert('Ev_Repeat_Schedule', $data2);
				 $ev_rep_id  = $this->db->insert_id();


				if($ev_invitees){
					foreach($ev_invitees as $i => $user_id){

						$status    = 'Pending';
						$data3 = array(
								'Ev_ID'				=> $ev_id,
								'Ev_Rep_ID'	=> $ev_rep_id,
								'Users_Id'		=> $user_id,
								'Ev_status'		=> $status
								);

						$result = $this->db->insert('Ev_Inv_Status', $data3);
					}
				}

			}


//exit;
		     return  $ev_id; 
		}

}