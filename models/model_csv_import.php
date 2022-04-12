<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class model_csv_import extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertCSV($data)
            {
                $this->db->insert('USATTMembership', $data);
                return TRUE;
            }

	public function view_data(){
			$query = $this->db->query("SELECT * FROM USATTMembership");
            return $query->result();
    }

	public function get_membersDetails($memberID){
		 $query = $this->db->query("SELECT * FROM USATTMembership where Member_ID='".$memberID."'");
  		return $query->row_array();
	}

	public function check_user($email){
		
		$query = $this->db->query("SELECT * FROM Users where EmailID ='".trim($email)."'");

		//echo "<pre>";
if ($query !== FALSE)
{
    // Run your code
	//return $query->row_array();
	if($query->num_rows() > 0)
		return $query->row_array();
	else
		return 0;
}
else
{
	/*var_dump($email);
	echo rtrim($email, ' '); exit;
			echo $this->db->last_query();*/

    // Check error
    //echo 'Database Error(' . $this->db->_error_number() . ') - ' . $this->db->_error_message();
	return 0;
}

	}

	public function check_user_mobile($mobile){
		
		$query = $this->db->query("SELECT * FROM Users where Mobilephone LIKE '".trim($mobile)."' OR  Mobilephone LIKE '%".trim($mobile)."'");

		if ($query !== FALSE){
			if($query->num_rows() > 0){
				//echo "<br>".$this->db->last_query();
				return $query->row_array();
			}
			else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}

	public function get_user($email){
		
		$query = $this->db->query("SELECT * FROM Users where EmailID ='".trim($email)."'");
		$get_res = $query->row_array();
		return $get_res;
	}

	public function check_name($name){
		
		$query = $this->db->query("SELECT * FROM Users where Firstname ='".trim($name)."'");

		//echo "<pre>";
if ($query !== FALSE)
{
    // Run your code
	//return $query->row_array();
	if($query->num_rows() > 0)
		return 1;
	else
		return 0;
}
else
{
	/*var_dump($email);
	echo rtrim($email, ' '); exit;
			echo $this->db->last_query();*/

    // Check error
    //echo 'Database Error(' . $this->db->_error_number() . ') - ' . $this->db->_error_message();
	return 0;
}

	}

	public function is_club_member($user_id, $club_id){
		$query = $this->db->query("SELECT * FROM User_memberships where Users_id ='".trim($user_id)."' AND Club_id = $club_id");

	if($query->num_rows() > 0)
		return 1;
	else
		return 0;


	}

	public function update_memberDetails($member_id, $data){
		$this->db->where('Member_ID', $member_id);
		$res = $this->db->update('USATTMembership', $data);
	}

	public function add_memberDetails($data){
		$res = $this->db->insert('USATTMembership', $data);
	}

	public function add_gpaRatings($data){
		$res = $this->db->insert('GPA_Ratings', $data);
		//echo $this->db->_error_message()."<br>";
		//echo $this->db->last_query()."<br>";//exit;
		return $res;
	}

	public function add_clubDetails($data){
		$res = $this->db->insert('Academy_Info', $data);
		return $res;
	}

	public function insert_user($data){
		$res = $this->db->insert('Users', $data);
		return $this->db->insert_id();
	}

	public function insert_child_users($data){
		$res = $this->db->insert('Users_ref', $data);
		return $res;
	}

	public function insert_club_member($data){
		$res = $this->db->insert('User_memberships', $data);
	}

	public function insert_reg_league($data){
		$res = $this->db->insert('RegisterTournament', $data);
	}

	public function insert_sports_intrests($data){
		$res = $this->db->insert('Sports_Interests', $data);
	}

	public function insert_a2mscore($data){
		$res = $this->db->insert('A2MScore', $data);
	}


	public function truncate_usatt_ratings(){
		 $query = $this->db->query("TRUNCATE TABLE USATTMembership");
	}

}

?>