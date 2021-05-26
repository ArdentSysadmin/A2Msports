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
			$this->db->order_by("Firstname","asc");
			$this->db->from('users');
			$query=$this->db->get();
			return $query->result();
		}

		public function get_name($user_id)
		{			
			$data = array('Users_ID'=>$user_id);
			$get_sp_num = $this->db->get_where('Users',$data);
			return $get_sp_num->row_array();
		}

		public function get_ajax_users($data)
		{
			$sport		 = $data['sport'];
			$country	 = $data['country'];
			$state		 = $data['state'];
			$age_group   = $data['age_group'];
			$user_status = $data['user_status'];
			$gender		 = $data['gender'];

			$sport_cond		= "";
			$country_cond	= "";
			$state_cond		= "";
			$age_group_cond = "";
			$active_users_cond = "";
			$gender_users_cond = "";

			if($sport != ""){
				$sport_cond = "Users_ID IN (SELECT users_id FROM Sports_Interests WHERE sport_id = $sport)";
			}
			else { $sport_cond = "1=1"; }

			if($country != ""){
				$country_cond = " AND Country = '$country'";
			}

			if($state != ""){
				$state_cond = " AND State = '$state'";
			}

			if($age_group != ""){
				if($age_group == "kids"){
					$age_group_cond = " AND UserAgegroup != 'Adults'";
				}
				else if($age_group == "adults"){
					$age_group_cond = " AND UserAgegroup = 'Adults'"; 
				}
			}

			if($user_status != ""){
				if($user_status == "1"){
					$active_users_cond = " AND IsUserActivation = 1";
				}
				else{
					$active_users_cond = " AND IsUserActivation = 0";
				}
			}

			if($gender != ""){
				if($gender == "1"){
					$gender_users_cond = " AND Gender = 1";
				}
				else{
					$gender_users_cond = " AND Gender = 0";
				}
			}

			$qry_get = $this->db->query("SELECT * FROM Users WHERE {$sport_cond}{$country_cond}{$state_cond}{$age_group_cond}{$active_users_cond}{$gender_users_cond} ORDER BY Firstname");

			return $qry_get->result();
		}
		
		public function update_pom($data){
			$pom = $data['user'];
			$qry_update = $this->db->query("UPDATE Site_Info SET POM = $pom");
		}

		public function insert_sendmail_players($data){
			
	    	     $admin = $this->session->userdata('admin');
	    	     if($admin){
                   $admin_id = $this->session->userdata('users_id');
	    	     }
                 $subject      = $data['subject'];
                 $message      = $data['msg'];
                 $attached_file= $data['attachment'];    
			     $players      = $data['players'];
			     $created_date = date("Y-m-d h:i:s");

                 $array = array(
					 'users_id' => $admin_id, 
					 'message'  => $message, 
					 'subject'  => $subject, 
					 'players'  => $players, 
					 'attachments_file' => $attached_file, 
					 'is_notified' => 0, 
					 'created_on' => $created_date);
             
            $result = $this->db->insert('Portal_Admin_Messages', $array);
           
         return $result;
	    }

		public function get_a2mscore($sport,$userid){
			$data = array('Users_ID'=>$userid, 'SportsType_ID'=>$sport);
			$get_score = $this->db->get_where('A2MScore',$data);
			return $get_score->row_array();
		}
}