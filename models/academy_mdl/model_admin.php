<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_admin extends CI_Model{
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->database();
		}

		public function get_user_data()
		{
			$this->db->select('*');
			$this->db->order_by("RegistrationDtTm","asc");
			$this->db->from('users');
			$query=$this->db->get();
			return $query->result();
		}

		public function get_name($user_id){
			
			$data = array('Users_ID'=>$user_id);
			$get_sp_num = $this->db->get_where('Users',$data);
			return $get_sp_num->row_array();
		}

		public function get_ajax_users($data)
		{
			$sport = $data['sport'];
			$country = $data['country'];
			$state = $data['state'];

			//print_r($data);
			//exit;

			if($sport!='' and $country == ''){

				$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname ,u.UserAgegroup FROM Users u inner join Sports_Interests t on u.Users_ID = t.users_id WHERE t.sport_id = $sport  order by u.RegistrationDtTm desc");
			}
			else if($country!='' and $sport == '' and $state == ''){
			
			$qry_check = $this->db->query("SELECT Users_ID,Firstname,Lastname ,UserAgegroup FROM Users  WHERE Country = '$country' order by RegistrationDtTm desc");
			}
			else if($sport != '' and $country != '' and $state == ''){

			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname ,u.UserAgegroup FROM Users u inner join Sports_Interests t on u.Users_ID = t.users_id WHERE t.sport_id = $sport AND u.Country = '$country' order by u.RegistrationDtTm desc");
			}
			else if($sport!='' and $country!= '' and $state!= ''){

			$qry_check = $this->db->query("SELECT u.Users_ID,u.Firstname,u.Lastname ,u.UserAgegroup FROM Users u inner join Sports_Interests t on u.Users_ID = t.users_id WHERE t.sport_id = $sport AND u.Country = '$country' AND u.State = '$state' order by u.RegistrationDtTm desc");
			}
			else if($sport =='' and $country!= '' and $state!= ''){

			$qry_check = $this->db->query("SELECT Users_ID,Firstname,Lastname ,UserAgegroup FROM Users  WHERE Country = '$country' AND State = '$state' order by RegistrationDtTm desc");
			}

			//print_r($this->db->last_query());
			//exit;

			return $qry_check->result();
		}
		
		public function update_pom($data){
			$pom = $data['user'];
			$qry_update = $this->db->query("UPDATE Site_Info SET POM = $pom");
		}

		public function get_club_memberships($org_id){
			$data = array('Club_ID' => $org_id);
			$get_sp_num = $this->db->get_where('Membership_Types', $data);
			return $get_sp_num->result();
		}

		public function check_membership_type($mem_type, $org_id=''){
			$org_cond = "";
			if($org_id){
			$org_cond = " AND Club_ID = {$org_id}";
			}
			$qry = $this->db->query("SELECT * FROM Membership_Types WHERE Membership_Type = '{$mem_type}'{$org_cond}");

			if($qry->num_rows() > 0)
				return 1;
			else
				return 0;
		}

		public function check_membership_id($mem_id, $org_id=''){
			$org_cond = "";
			if($org_id){
			$org_cond = " AND Club_ID = {$org_id}";
			}
			$qry = $this->db->query("SELECT * FROM Membership_Types WHERE Membership_ID = '{$mem_id}'{$org_cond}");

			if($qry->num_rows() > 0)
				return 1;
			else
				return 0;
		}

		public function add_memberships($data) {
			$result = $this->db->insert('Membership_Types', $data);
			//echo $this->db->last_query();
			return $result;
		}

		public function upd_memberships($data, $tab_id) {
			$this->db->where('tab_id', $tab_id);
			$result = $this->db->update('Membership_Types', $data);
			//echo $this->db->last_query();
			return $result;
		}

		public function get_membership_det($tab_id){
			$data = array('tab_id' => $tab_id);
			$this->db->select('Membership_ID,Membership_Type,Sport_Type,
			Frequency_Code,Fee,ActivationFee,Status,Expire_Date');
			$get_det = $this->db->get_where('Membership_Types', $data);

			return $get_det->row_array();
		}

		public function insert_testimonial($data){
			$get_det = $this->db->insert('Academy_Testimonials', $data);
			return $get_det;
		}
		public function del_testim($tab_id){
			$qry = $this->db->query("DELETE FROM Academy_Testimonials WHERE tab_id = {$tab_id}");
			return $qry;
		}
		public function get_testim($tab_id){
			$qry = $this->db->query("SELECT * FROM Academy_Testimonials WHERE tab_id = {$tab_id}");
			return $qry->row_array();
		}
		public function upd_testim($tab_id, $data){
						 $this->db->where('tab_id', $tab_id);
			$res  = $this->db->update('Academy_Testimonials', $data);
			return $res;
		}
		public function upd_club_layout($club_id, $data){
						 $this->db->where('Aca_ID', $club_id);
			$res  = $this->db->update('Academy_Info', $data);
			return $res;
		}
}