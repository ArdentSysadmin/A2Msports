<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_message extends CI_Model {

	public function __construct(){
		parent:: __construct();
		$this->load->database();
	}

	public function get_messages($data){
		$user_id	= $data['user_id'];
		$type		= $data['type'];
		$type_id	= $data['type_id'];
		$data2['msg'] = null;

		if($type == 'team'){
			$team_id = $type_id;
			$conv_qry = $this->db->query( "SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type = 'Team' AND type_ref = $team_id)" );
			if($conv_qry->num_rows){
				$conversations = $conv_qry->result();
				foreach($conversations as $conv){
					$mid = $conv->mid;
					$msg_qry = $this->db->query("SELECT * FROM Messages WHERE mid = {$mid}");
					//echo $this->db->last_query(); exit;
					$msg = $msg_qry->row_array();
					$msg['sender'] = $conv->sender;

				if($conv->sender){
				$qry_tmp   = $this->db->query("SELECT * FROM Users WHERE Users_ID = {$conv->sender}");
				$get_user = $qry_tmp->row_array();
				$grp_title = $get_user['Firstname']." ".$get_user['Lastname'];
				if($get_user['Profilepic'])
					$grp_img = base_url()."profile_pictures/".$get_user['Profilepic'];
				else
					$grp_img = base_url()."profile_pictures/default-profile.png";
				}

					$msg['title'] = $grp_title;
					$msg['img'] = $grp_img;

					$data2['msg'][] = $msg;
				}
			}
		}
		else if($type == 'tournament'){
			$tourn_id = $type_id;
			$conv_qry = $this->db->query( "SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type = 'Tournament' AND type_ref = $tourn_id)" );
			if($conv_qry->num_rows){
				$conversations = $conv_qry->result();
				foreach($conversations as $conv){
					$mid = $conv->mid;
					$msg_qry = $this->db->query("SELECT * FROM Messages WHERE mid = {$mid}");
					$msg = $msg_qry->row_array();
					$msg['sender'] = $conv->sender;

				if($conv->sender){
				$qry_tmp   = $this->db->query("SELECT * FROM Users WHERE Users_ID = {$conv->sender}");
				$get_user = $qry_tmp->row_array();
				$grp_title = $get_user['Firstname']." ".$get_user['Lastname'];
				if($get_user['Profilepic'])
					$grp_img = base_url()."profile_pictures/".$get_user['Profilepic'];
				else
					$grp_img = base_url()."profile_pictures/default-profile.png";
				}

					$msg['title'] = $grp_title;
					$msg['img'] = $grp_img;

					$data2['msg'][] = $msg;
				}
			}
		}
		else if($type == 'one2one'){
			
			$conv_qry = $this->db->query( "SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type_ref = (SELECT id FROM One2One WHERE (userid1 = {$user_id} AND userid2 = {$type_id}) OR (userid2 = {$user_id} AND userid1 = {$type_id})))" );

			if($conv_qry->num_rows){
				$conversations = $conv_qry->result();
				foreach($conversations as $conv){
					$mid = $conv->mid;
					$msg_qry = $this->db->query("SELECT * FROM Messages WHERE mid = {$mid}");
					$msg = $msg_qry->row_array();
					$msg['sender'] = $conv->sender;

				/*$qry_o2o   = $this->db->query("SELECT * FROM One2One WHERE id = {$conv->sender}");
				$get_o2o = $qry_o2o->row_array();

				if($get_o2o['userid1'] == $user_id)
					$chat_partner = $get_o2o['userid2'];
				else if($get_o2o['userid2'] == $user_id)
					$chat_partner = $get_o2o['userid1'];*/
				
				if($conv->sender){
				$qry_tmp   = $this->db->query("SELECT * FROM Users WHERE Users_ID = {$conv->sender}");
				$get_user = $qry_tmp->row_array();
				$grp_title = $get_user['Firstname']." ".$get_user['Lastname'];
				if($get_user['Profilepic'])
					$grp_img = base_url()."profile_pictures/".$get_user['Profilepic'];
				else
					$grp_img = base_url()."profile_pictures/default-profile.png";
				}

					$msg['title'] = $grp_title;
					$msg['img'] = $grp_img;

					$data2['msg'][] = $msg;
				}
			}
		}

		return $data2;		
	}

	public function insert_message($data){
		$sender	= $data['sender'];
		$type		= $data['type'];
		$recipient	= $data['recipient'];
		$reply_to	= $data['reply_to'];
		$content	= $data['content'];

		$data2['msg'] = null;

		if($type == 'team'){
			$team_id = $recipient;
			$grp_qry = $this->db->query( "SELECT gid FROM Groups WHERE type = 'Team' AND type_ref = $team_id)" );

			if($grp_qry->num_rows){
				$grp_row  = $grp_qry->row_array();
				$gid			= $grp_row['gid'];
			}
			else{
				$data3 = array(
							'type'		=> 'Team',
							'type_ref'  => $team_id
							);

				$ins  = $this->db->insert('Groups', $data3);	
				$gid = $this->db->insert_id();
			}
		}
		else if($type == 'tournament'){
			$tourn_id = $recipient;
			$grp_qry = $this->db->query( "SELECT gid FROM Groups WHERE type = 'Tournament' AND type_ref = $tourn_id" );

			if($grp_qry->num_rows){
				$grp_row  = $grp_qry->row_array();
				$gid			= $grp_row['gid'];
			}
			else{
				$data3 = array(
							'type'		=> 'Tournament',
							'type_ref'  => $tourn_id
							);

				$ins  = $this->db->insert('Groups', $data3);	
				$gid = $this->db->insert_id();
			}
		}
		else if($type == 'one2one'){
			$grp_qry = $this->db->query( "SELECT * FROM Groups WHERE type = 'One2One' AND type_ref = (SELECT id FROM One2One WHERE (userid1 = {$sender} AND userid2 = {$recipient}) OR (userid2 = {$sender} AND userid1 = {$recipient}))" );

			if($grp_qry->num_rows){
				$grp_row  = $grp_qry->row_array();
				$gid			= $grp_row['gid'];
			}
			else{
				$data4 = array(
							'userid1'	=> $sender,
							'userid2'	=> $recipient
							);

				$ins  = $this->db->insert('One2One', $data4);	
				$oid = $this->db->insert_id();

				$data3 = array(
							'type'		=> 'One2One',
							'type_ref'  => $oid
							);

				$ins  = $this->db->insert('Groups', $data3);	
				$gid = $this->db->insert_id();
			}
		}

				$now = strtotime(date('Y-m-d H:i:s'));
				$data3 = array('content'		=> $content,
										'created_on' => $now);

				$ins  = $this->db->insert('Messages', $data3);	
				$mid = $this->db->insert_id();

				$data3 = array(
							'mid'				=> $mid,
							'reply_to'		=> $reply_to,
							'recipient'		=> $gid,
							'sender'		=> $sender
							);

				$ins  = $this->db->insert('Conversations', $data3);	
				$cid = $this->db->insert_id();

		//return $mid;	

		return array("mid"				 => $mid,
							"content"		 => $content,
							"image"			 => null,
							"created_on" => $now,
							"sender"		 => $sender);
	}

	public function get_all_messages($user_id){
		$data = "";

		$get_convs = $this->db->query("SELECT recipient FROM Conversations WHERE recipient in (
		SELECT recipient FROM Conversations WHERE recipient IN (
		SELECT gid FROM Groups WHERE type_ref IN (SELECT Team_ID FROM Teams WHERE Players LIKE '%".'"'.$user_id.'"'."%') OR type_ref IN (SELECT Tournament_ID FROM RegisterTournament WHERE Users_ID = {$user_id}) OR type_ref IN (SELECT id FROM One2One WHERE (userid1 = {$user_id} OR userid2 = {$user_id}))
		) OR sender = {$user_id}
		) GROUP BY recipient ");
//echo $this->db->last_query(); exit;
//echo $get_convs->num_rows; exit;
		if($get_convs->num_rows){
		$convs = $get_convs->result();

		foreach($convs as $cn){
			$data2 = '';
			$qry_grp = $this->db->query("SELECT * FROM Groups WHERE gid = {$cn->recipient}");
			$get_grp = $qry_grp->row_array();

			if($get_grp['type'] == 'Team'){
				$qry_tmp   = $this->db->query("SELECT * FROM Teams WHERE Team_ID = {$get_grp['type_ref']}");
				$get_team = $qry_tmp->row_array();
				$grp_title	 = $get_team['Team_name'];
				$ref_id		 = $get_team['Team_ID'];

				if($get_team['Team_Logo'])
					$grp_img = base_url()."team_logos/".$get_team['Team_Logo'];
				else
					$grp_img = base_url()."team_logos/default_team_logo.png";
			}
			if($get_grp['type'] == 'Tournament'){
				$qry_tmp   = $this->db->query("SELECT * FROM tournament WHERE tournament_ID = {$get_grp['type_ref']}");
				$get_tour = $qry_tmp->row_array();
				$grp_title	= $get_tour['tournament_title'];
				$ref_id		= $get_tour['tournament_ID'];

				if($get_tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$get_tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/default_image.jpg";

			}
			if($get_grp['type'] == 'One2One'){

				$qry_o2o   = $this->db->query("SELECT * FROM One2One WHERE id = {$get_grp['type_ref']}");
				$get_o2o = $qry_o2o->row_array();

				if($get_o2o['userid1'] == $user_id)
					$chat_partner = $get_o2o['userid2'];
				else if($get_o2o['userid2'] == $user_id)
					$chat_partner = $get_o2o['userid1'];
				
				if($chat_partner){
				$qry_tmp   = $this->db->query("SELECT * FROM Users WHERE Users_ID = {$chat_partner}");
				$get_user = $qry_tmp->row_array();
				$grp_title	 = $get_user['Firstname']." ".$get_user['Lastname'];
				$ref_id		 = $get_user['Users_ID'];

				if($get_user['Profilepic'])
					$grp_img = base_url()."profile_pictures/".$get_user['Profilepic'];
				else
					$grp_img = base_url()."profile_pictures/default-profile.png";
				}
			}

				$qry_con   = $this->db->query("SELECT * FROM Messages WHERE mid IN (SELECT mid FROM Conversations WHERE recipient = {$cn->recipient}) ORDER BY created_on DESC");
				$get_msg = $qry_con->row_array();
				
				$data2['title'] = $grp_title;
				$data2['img'] = $grp_img;
				$data2['type'] = $get_grp['type'];
				$data2['id']	  = $ref_id;


				$qry_con2   = $this->db->query("SELECT * FROM Conversations WHERE mid = {$get_msg['mid']}");
				$get_con2 = $qry_con2->row_array();

				$get_msg['sender'] = $get_con2['sender'];
				$data2['lastSentMessage'] =$get_msg;

			$data[] = $data2;
		}
	}

		return $data;
	}

	public function get_search_recom($user_id){
		$data = "";

		$get_convs = $this->db->query("SELECT recipient FROM Conversations WHERE recipient in (
		SELECT recipient FROM Conversations WHERE recipient IN (
		SELECT gid FROM Groups WHERE type_ref IN (SELECT Team_ID FROM Teams WHERE Players LIKE '%".'"'.$user_id.'"'."%') OR type_ref IN (SELECT Tournament_ID FROM RegisterTournament WHERE Users_ID = {$user_id}) OR type_ref IN (SELECT id FROM One2One WHERE (userid1 = {$user_id} OR userid2 = {$user_id}))
		) OR sender = {$user_id}
		) GROUP BY recipient ");
//echo $this->db->last_query(); exit;
//echo $get_convs->num_rows; exit;
		if($get_convs->num_rows){
		$convs = $get_convs->result();

		foreach($convs as $cn){
			$data2 = '';
			$qry_grp = $this->db->query("SELECT * FROM Groups WHERE gid = {$cn->recipient}");
			$get_grp = $qry_grp->row_array();

			if($get_grp['type'] == 'Team'){
				$qry_tmp   = $this->db->query("SELECT * FROM Teams WHERE Team_ID = {$get_grp['type_ref']}");
				$get_team = $qry_tmp->row_array();
				$grp_title = $get_team['Team_name'];
				if($get_team['Team_Logo'])
					$grp_img = base_url()."team_logos/".$get_team['Team_Logo'];
				else
					$grp_img = base_url()."team_logos/default_team_logo.png";
			}
			if($get_grp['type'] == 'Tournament'){
				$qry_tmp   = $this->db->query("SELECT * FROM tournament WHERE tournament_ID = {$get_grp['type_ref']}");
				$get_tour = $qry_tmp->row_array();
				$grp_title = $get_tour['tournament_title'];

				if($get_tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$get_tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/default_image.jpg";

			}
			if($get_grp['type'] == 'One2One'){

				$qry_o2o = $this->db->query("SELECT * FROM One2One WHERE id = {$get_grp['type_ref']}");
				$get_o2o = $qry_o2o->row_array();

				if($get_o2o['userid1'] == $user_id)
					$chat_partner = $get_o2o['userid2'];
				else if($get_o2o['userid2'] == $user_id)
					$chat_partner = $get_o2o['userid1'];
				
				if($chat_partner){
				$qry_tmp   = $this->db->query("SELECT * FROM Users WHERE Users_ID = {$chat_partner}");
				$get_user = $qry_tmp->row_array();
				$grp_title = $get_user['Firstname']." ".$get_user['Lastname'];
				if($get_user['Profilepic'])
					$grp_img = base_url()."profile_pictures/".$get_user['Profilepic'];
				else
					$grp_img = base_url()."profile_pictures/default-profile.png";
				}
			}
	
				$data2['group_id'] = $cn->recipient;
				$data2['title'] = $grp_title;
				$data2['img'] = $grp_img;
				$data2['type'] =$get_grp['type'];



			$data[] = $data2;
		}

// ---------------- Teams -----------------------------------------------------
				$qry_tmp   = $this->db->query("SELECT * FROM Teams WHERE Players LIKE '%".'"'.$user_id.'"'."%'");
				$get_teams = $qry_tmp->result_array();
				foreach($get_teams as $tm){
				$grp_title = $tm['Team_name'];
				if($tm['Team_Logo'])
					$grp_img = base_url()."team_logos/".$tm['Team_Logo'];
				else
					$grp_img = base_url()."team_logos/default_team_logo.png";

				$data2['group_id'] = null;
				$data2['title'] = $grp_title;
				$data2['img'] = $grp_img;
				$data2['type'] = "Team";

			$data[] = $data2;
				}
// -------------------------- Team ---------------------------------------


// -------------------------- Tournament ---------------------------------------

				$qry_tmp   = $this->db->query("SELECT * FROM tournament WHERE tournament_ID IN (SELECT Tournament_ID FROM RegisterTournament WHERE Users_ID = {$user_id})");
				$get_tours = $qry_tmp->result_array();

				foreach($get_tours as $tour){
				$grp_title = $tour['tournament_title'];

				if($tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/default_image.jpg";

				$data2['group_id'] = null;
				$data2['title'] = $grp_title;
				$data2['img'] = $grp_img;
				$data2['type'] = "Tournament";

			$data[] = $data2;

				}

// -------------------------- Tournament ---------------------------------------

	}

		return $data;
	}

	public function get_search_recom2($q){
		$data = "";

// ---------------- Teams -----------------------------------------------------
				$qry_tmp   = $this->db->query("SELECT * FROM Teams WHERE Team_name LIKE '%".$q."%'");
				//echo $this->db->last_query(); exit;
				$get_teams = $qry_tmp->result_array();
				foreach($get_teams as $tm){
				$grp_title = $tm['Team_name'];
				if($tm['Team_Logo'])
					$grp_img = base_url()."team_logos/".$tm['Team_Logo'];
				else
					$grp_img = base_url()."team_logos/default_team_logo.png";

				$data2['group_id'] = null;
				$data2['title'] = $grp_title;
				$data2['img'] = $grp_img;
				$data2['type'] = "Team";

			$data[] = $data2;
				}
// -------------------------- Team ---------------------------------------


// -------------------------- Tournament ---------------------------------------

				$qry_tmp   = $this->db->query("SELECT * FROM tournament WHERE tournament_title LIKE '%".$q."%'");
				$get_tours = $qry_tmp->result_array();

				foreach($get_tours as $tour){
				$grp_title = $tour['tournament_title'];

				if($tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/default_image.jpg";

				$data2['group_id'] = null;
				$data2['title'] = $grp_title;
				$data2['img'] = $grp_img;
				$data2['type'] = "Tournament";

			$data[] = $data2;

				}

// -------------------------- Tournament ---------------------------------------

		return $data;
	}

}