<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_academy extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();
			
		}

		public function get_list()
		{
			$limit = 3;
			$user_id = $this->session->userdata('users_id');
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->where('Org_Id !=', 0);
			$this->db->order_by("Modified_on", "desc");
			$this->db->limit($limit);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_academy_list()
		{
			$this->db->select('*');
			$this->db->from('Academy');
			$this->db->order_by('Org_name','ASC');
			$query=$this->db->get();
			return $query->result();
		}

		public function get_menu_list()
		{
			$this->db->select('*');
			$this->db->from('Academy_Menu_List');
			$query=$this->db->get();
			return $query->result();
		}

		public function get_act_menu_list($org_id)
		{
			$this->db->select('*');
			$this->db->from('Academy_Menu_Settings');
			$this->db->where('Academy_Id =', $org_id);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_coaches_list($org_id)
		{
			
			$org_cond = "AND Users_ID IN (SELECT Users_id FROM Academy_users WHERE Org_ID = $org_id)";
			$query = $this->db->query("SELECT * FROM users WHERE Is_coach = 1 {$org_cond}");
			return $query->result();
		}

		public function get_members_list($org_id)
		{
			
			$org_cond = " Users_ID IN (SELECT Users_id FROM Academy_users WHERE Org_ID = $org_id)";
			$query = $this->db->query("SELECT * FROM users WHERE  {$org_cond}");
			return $query->result();
		}
		
		public function get_menu_name($id)
		{
			$data  = array('Menu_ID' => $id);
			$query = $this->db->get_where('Academy_Menu_List', $data);
			return $query->row_array();
		}

		public function get_user($id)
		{
			$data  = array('Users_ID' => $id);
			$query = $this->db->get_where('Users', $data);
			return $query->row_array();
		}

		public function update_act_menu($org_id){
			
			$data  = array('Academy_Id' => $org_id);
			$query = $this->db->get_where('Academy_Menu_Settings', $data);

			$menu_list = json_encode($this->input->post('active_menu'));

			
			 if($query->num_rows() > 0){

				$data = array('Active_Menu_Ids' => $menu_list);

				$this->db->where('Academy_Id', $org_id);
				$result = $this->db->update('Academy_Menu_Settings', $data); 

			 } else {

				$data = array(
				'Academy_Id' => $org_id,
				'Active_Menu_Ids' => $menu_list
				);

			   $result = $this->db->insert('Academy_Menu_Settings', $data);

			 }

			return $result;
		}

		public function get_academy_list_news()
		{
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->where('Org_Id !=', 0);
			$this->db->order_by("Modified_on", "desc");
			$query=$this->db->get();
			return $query->result();
		}

		public function get_specific_news($org_id)
		{
			$data = array('Org_Id'=> $org_id);
			$query = $this->db->get_where('Sports_News',$data);
			return $query->result();
		}

		public function get_academy_details($org_id)
		{
			$data = array('Org_ID'=>strtolower($org_id));
			$query = $this->db->get_where('Academy',$data);
			return $query->row_array();
		}

		public function get_tennis_levels()
		{
			$data = array('SportsType_ID'=> '1');
			$query = $this->db->get_where('SportsLevels',$data);
			return $query->result();
		}

		public function get_sport_levels($sport_id)
		{
			$data = array('SportsType_ID'=> $sport_id);
			$query = $this->db->get_where('SportsLevels',$data);
			return $query->result();
		}

		public function get_sport_id($user_id){
			
			$data = array('users_id'=>$user_id);
			$get_sp_name = $this->db->get_where('Sports_Interests',$data);
			return $get_sp_name->result();
		}

		public function get_a2msocre($sport,$user_id)
		{
			$data = array('SportsType_ID'=>$sport , 'Users_ID'=>$user_id);
			$get_level = $this->db->get_where('A2MScore',$data);
			return $get_level->row_array();
		}


		public function search_details($data)
		{

			//print_r($_POST);
			//exit;
			
			$name =  $data['search_fname']; 
			$range = $data['range'];
			$sport = $data['sport'];
			$level = $data['level'];

			if($this->input->post('academy_status') == '1'){
				$org_id = $this->input->post('org_id');
			} else {
				 $org_id = "";
			}

			//$org_id = $data['org_id'];

		    ($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		    ($data['long']=="") ? $long = 0 : $long = $data['long'];


			$name_cond = "";
			if($name != "")
			{
				$name_cond = "(Firstname like '%{$name}%' OR Lastname like '%{$name}%')";
			}else
			{
				$name_cond = "";
			}

			$Sport_cond = "";
			if($sport != "")
			{
				
				if($name !=""){
				$Sport_cond = "AND Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})"; 
				}
				else
				{
				$Sport_cond = "Users_ID IN (select users_id from Sports_Interests where Sport_id ={$sport})";
				}
			}else
			{
				$Sport_cond = "";
			}

			$level_cond = "";
			if($level != "")
			{
				if($name!="" OR  $sport != "")
				{
				$level_cond = "AND users_id IN (SELECT users_id FROM Sports_Interests WHERE Level IN ($level) AND Sport_id = {$sport})";
				}
				else
				{
				$level_cond = "users_id IN (SELECT users_id FROM Sports_Interests WHERE Level IN ($level) AND Sport_id = {$sport})";
				}
			}else
			{
				$level_cond = "";
			}

			$org_cond = "";

			if(!empty($org_id)){
				if($name!= "" OR $sport != "" OR  $level != "")
				{
				$org_cond = " AND Users_ID IN (SELECT Users_id FROM Academy_users WHERE Org_ID = $org_id)";
				}else
				{
					$org_cond = "Users_ID IN (SELECT Users_id FROM Academy_users WHERE Org_ID = $org_id)";
				}
			}
			else{
				$org_cond .= "";
			}

			if($range != "")
			{
				
				if($name != "" OR $sport != "" OR $level != "" OR $org_id != ""){
				$range_cond = " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
					
				$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
				* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond} {$level_cond}  {$org_cond} {$range_cond}");			
			
				}
				else
				{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";

				$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
				* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond} {$level_cond}  {$org_cond} {$range_cond}");	

				}
			}
			else
			{
				if($name != "" OR $sport != "" OR $level != "" OR $org_id != ""){
				$query = $this->db->query(" SELECT * FROM users WHERE {$name_cond} {$Sport_cond} {$level_cond} {$org_cond}");
				}
				else
				{
				  $query = $this->db->query("SELECT * FROM users");
				}
			}
			
			//print_r($this->db->last_query());
			//exit;

			return $query->result();
		}

		public function search_coaches($data)
		{	
			$name  = $data['coach_name'];
			$range = $data['coach_range'];
			$sport = $data['coach_sport'];

			$org_id = $data['org_id'];

		    ($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
		    ($data['long']=="") ? $long = 0 : $long = $data['long'];

			$name_cond = "";
			if($name != "")
			{
				$name_cond = "(Firstname like '%{$name}%' OR Lastname like '%{$name}%')";
			}
			else
			{
				$name_cond = "";
			}

			$Sport_cond = "";
			if($sport != ""){	
				if($name !=""){
					$Sport_cond = "AND coach_sport = $sport "; 
				}
				else{
					$Sport_cond = "coach_sport = $sport";
				}
			}
			else{
				$Sport_cond = "";
			}

			if(!empty($org_id)){
				$org_cond = " AND Users_ID IN (SELECT Users_id FROM User_memberships WHERE Club_id = $org_id)";
			}
			else{
				$org_cond .= "";
			}
			
			if($range != ""){

				if($name != "" OR $sport != "" ){
				$range_cond = " AND ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";
					
				$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) )
				* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond}  {$range_cond} AND Is_coach = 1 {$org_cond}");			
				}
				else{
				$range_cond = "ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat )) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) *  COS( RADIANS( Longitude ) - RADIANS( $long)) ) * 3964.3 < {$range}";

				$query = $this->db->query(" SELECT * , ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
				* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM users WHERE  {$name_cond}  {$Sport_cond}  {$range_cond} AND Is_coach = 1 {$org_cond} ");	
				}
			}
			else{
				if($name != "" OR $sport != "" ){
				  $query = $this->db->query(" SELECT * FROM users WHERE {$name_cond} {$Sport_cond} AND Is_coach = 1 {$org_cond}");
				}
				else{
				  $query = $this->db->query(" SELECT * FROM users WHERE Is_coach = 1 {$org_cond}");
				}
			}
			
			//print_r($this->db->last_query());
			//exit;

			return $query->result();
		}

		public function get_user_create_tournments($creator){
			$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = $creator AND StartDate > cast(GETDATE() as DATE) ORDER BY StartDate DESC");
			return $qry_check->result();
		}

		public function get_user_past_tournments($creator)
		{
			$qry_check = $this->db->query("SELECT * FROM tournament WHERE Usersid = $creator AND StartDate < cast(GETDATE() as DATE) ORDER BY StartDate DESC");
			return $qry_check->result();
		}

		public function get_sport_title($sport_id){
			$data = array('SportsType_ID'=>$sport_id);
			$get_sp_name = $this->db->get_where('SportsType',$data);
			return $get_sp_name->row_array();
		}

		public function get_news($org_id){
			$limit = 3;
			$user_id = $this->session->userdata('users_id');
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->where('Org_Id =', $org_id);
			$this->db->order_by("Modified_on", "desc");
			$this->db->limit($limit);
			$query=$this->db->get();
			return $query->result();
		}

		public function get_news_detail($news_id){
			$data = array('News_id'=>$news_id);
			$get_name = $this->db->get_where('Sports_News',$data);
			return $get_name->row_array();
		}

		public function insert_news(){
		   $title = $this->input->post('title');
		   $sport = $this->input->post('Sport');
		   $des = addslashes($this->input->post('description'));
		   // $created = date("Y-m-d h:i:s");
		   $created_user  = $this->session->userdata('users_id');
		   $org_id  = $this->input->post('org_id');

			$data = array(
					'News_title' => $title,
					'News_content' => $des,
				    'SportsType_id' => $sport,
					'Created_by' => $created_user,
					'Org_Id' => $org_id
					);

		  $result = $this->db->insert('Sports_News', $data);
		  return $result;
		}

		public function update_news($news_id){
			$message = addslashes($this->input->post('description'));
			$title = $this->input->post('title');
			$sport = $this->input->post('sport');
			$modified = date('Y-m-d H:i:s');

			$data = array('News_content' => $message ,'News_title' => $title,'Modified_on'=>$modified,'SportsType_id'=>$sport);

			$this->db->where('News_id', $news_id);
			$result = $this->db->update('Sports_News', $data); 
		
			return $result;
		}

		public function update_pom($data){
			$pom		= $data['user'];
			$academy	= $data['academy'];
			
			$data = array('POM' => $pom);

						$this->db->where('Org_ID', $academy);
			$result =	$this->db->update('Academy', $data); 
		}
}