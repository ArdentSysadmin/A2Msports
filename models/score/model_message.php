<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_message extends CI_Model {

	public function __construct(){
		parent:: __construct();
		$this->load->database();
	}

	public function get_username($uid){
		$user_qry = $this->db->get_where('Users', array('Users_ID' => $uid));
		$user_det = $user_qry->row_array();
		return ucfirst($user_det['Firstname']) . " " . ucfirst($user_det['Lastname']);
	}

	public function get_messages($data){
		$user_id	= $data['user_id'];
		$type		= $data['type'];
		$type_id	= $data['type_id'];
		$page		= $data['page'];
		$nxt_page = ($data['page'] + 1);
		$limit		= $data['limit'];

		$data2 = null;
		$data3 = null;
		$offset = ($page * $limit) - $limit;
		$nxt_offset = ($nxt_page * $limit) - $limit;
		$sort_order = 'DESC';

		if($type == 'team'){
			$team_id = $type_id;

				$qry_tmp   = $this->db->query("SELECT * FROM Teams WHERE Team_ID = {$team_id}");
				$get_team = $qry_tmp->row_array();
				$grp_title = $get_team['Team_name'];
				if($get_team['Team_Logo'])
					$grp_img = base_url()."team_logos/".$get_team['Team_Logo'];
				else
					$grp_img = base_url()."team_logos/default_team_logo.png";
			
					$data2['id']    = $team_id;
					$data2['title'] = $grp_title;
					$data2['img'] = $grp_img;

			$conv_qry = $this->db->query("SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type = 'Team' AND type_ref = $team_id) ORDER BY cid {$sort_order} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$nxt_conv_qry = $this->db->query("SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type = 'Team' AND type_ref = $team_id) ORDER BY cid {$sort_order} OFFSET {$nxt_offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$data2['hasNextPage'] = false;
			if($nxt_conv_qry->num_rows)
			$data2['hasNextPage'] = true;

			if($conv_qry->num_rows){
				$conversations = $conv_qry->result();
				foreach($conversations as $conv){
					$mid = $conv->mid;
					$msg_qry = $this->db->query("SELECT * FROM Messages WHERE mid = {$mid}");
					//echo $this->db->last_query(); exit;
					$msg_res = $msg_qry->row_array();
					$msg['mid'] = $msg_res['mid'];
					$msg['content'] = $msg_res['content'];
					//$msg['image'] = $msg_res['image'];

					if($msg_res['image'])
						$msg['image'] = base_url()."messages_imgs/".$msg_res['image'];
					else
						$msg['image'] =NULL;

					$msg['created_on'] = intval($msg_res['created_on']);
					$msg['sender'] = $conv->sender;
					$msg['username'] = $this->get_username($conv->sender);

					if($conv->reply_to){
					$msg_qry2 = $this->db->query("SELECT * FROM Messages WHERE mid = {$conv->reply_to}");
					$msg2 = $msg_qry2->row_array();
					$msg2['sender'] = $conv->sender;
					$msg2['username'] = $this->get_username($conv->sender);

					$msg['repliedTo'] = $msg2;
					}

					//$msg['title'] = $grp_title;
					//$msg['img'] = $grp_img;

					//$data2['msg'][] = $msg;
					$data2['messages'][] = $msg;
				}
			}
				$data3[] = $data2;
		}
		else if($type == 'tournament'){
			$tourn_id = $type_id;

				$qry_tmp   = $this->db->query("SELECT * FROM tournament WHERE tournament_ID = {$tourn_id}");
				$get_tour = $qry_tmp->row_array();
				$grp_title	= $get_tour['tournament_title'];
				$sport		 = $get_tour['SportsType'];

				if($get_tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$get_tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/".$this->tourn_def_imgs[$sport];
				
					$data2['id']    = $tourn_id;
					$data2['title'] = $grp_title;
					$data2['img'] = $grp_img;

			//$conv_qry = $this->db->query( "SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type = 'Tournament' AND type_ref = $tourn_id) ORDER BY cid {$sort_order} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
			$conv_qry = $this->db->query( "SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type = 'Tournament' AND type_ref = $tourn_id) ORDER BY cid {$sort_order} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
					//echo $this->db->last_query(); exit;

			$nxt_conv_qry = $this->db->query( "SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type = 'Tournament' AND type_ref = $tourn_id) ORDER BY cid {$sort_order} OFFSET {$nxt_offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$data2['hasNextPage'] = false;
			if($nxt_conv_qry->num_rows)
			$data2['hasNextPage'] = true;

			if($conv_qry->num_rows){
				$conversations = $conv_qry->result();
				foreach($conversations as $conv){
					$mid = $conv->mid;
					$msg_qry = $this->db->query("SELECT * FROM Messages WHERE mid = {$mid}");


				if($msg_qry){
					$msg_res = $msg_qry->row_array();
					$msg['mid'] = $msg_res['mid'];
					$msg['content'] = $msg_res['content'];
					//$msg['image'] = $msg_res['image'];

					if($msg_res['image'])
						$msg['image'] = base_url()."messages_imgs/".$msg_res['image'];
					else
						$msg['image'] =NULL;

					$msg['created_on'] = intval($msg_res['created_on']);
					$msg['sender'] = $conv->sender;
					$msg['username'] = $this->get_username($conv->sender);

					if($conv->reply_to){
					$msg_qry2 = $this->db->query("SELECT * FROM Messages WHERE mid = {$conv->reply_to}");
					$msg2 = $msg_qry2->row_array();
					$msg2['sender'] = $conv->sender;
					$msg2['username'] = $this->get_username($conv->sender);

					$msg['repliedTo'] = $msg2;
					}
			  }

					//$msg['title'] = $grp_title;
					//$msg['img'] = $grp_img;

					//$data2['msg'][] = $msg;

					$data2['messages'][] = $msg;
				}
			}
				$data3[] = $data2;
		}
		else if($type == 'one2one'){
			
			$conv_qry = $this->db->query("SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type= 'One2One' AND type_ref = (SELECT id FROM One2One WHERE (userid1 = {$user_id} AND userid2 = {$type_id}) OR (userid2 = {$user_id} AND userid1 = {$type_id}))) ORDER BY cid {$sort_order} OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY");
//echo $this->db->last_query(); exit;


				$qry_tmp   = $this->db->query("SELECT * FROM Users WHERE Users_ID = '".$data['type_id']."'");
				$get_user = $qry_tmp->row_array();
				$grp_title = $get_user['Firstname']." ".$get_user['Lastname'];
				if($get_user['Profilepic'])
					$grp_img = base_url()."profile_pictures/".$get_user['Profilepic'];
				else
					$grp_img = base_url()."profile_pictures/default-profile.png";
				


					$data2['id']    = $data['type_id'];
					$data2['title'] = $grp_title;
					$data2['img'] = $grp_img;

			$nxt_conv_qry = $this->db->query("SELECT * FROM Conversations WHERE recipient = (SELECT gid FROM Groups WHERE type= 'One2One' AND type_ref = (SELECT id FROM One2One WHERE (userid1 = {$user_id} AND userid2 = {$type_id}) OR (userid2 = {$user_id} AND userid1 = {$type_id}))) ORDER BY cid {$sort_order} OFFSET {$nxt_offset} ROWS FETCH NEXT {$limit} ROWS ONLY");

			$data2['hasNextPage'] = false;
			if($nxt_conv_qry->num_rows)
			$data2['hasNextPage'] = true;

			if($conv_qry->num_rows){
				$conversations = $conv_qry->result();
				foreach($conversations as $conv){
					$mid = $conv->mid;
					$msg_qry = $this->db->query("SELECT * FROM Messages WHERE mid = {$mid}");
					//var_dump($msg_qry->row_array());
					$msg_res = $msg_qry->row_array();
					$msg['mid'] = $msg_res['mid'];
					$msg['content'] = $msg_res['content'];

					if($msg_res['image'])
						$msg['image'] = base_url()."messages_imgs/".$msg_res['image'];
					else
						$msg['image'] =NULL;

					$msg['created_on'] = intval($msg_res['created_on']);
					$msg['sender'] = $conv->sender;
					$msg['username'] = $this->get_username($conv->sender);

				$qry_o2o		= $this->db->query("SELECT * FROM One2One WHERE id = {$conv->sender}");
				$get_o2o		= $qry_o2o->row_array();

				if($get_o2o['userid1'] == $user_id)
					$chat_partner = $get_o2o['userid2'];
				else if($get_o2o['userid2'] == $user_id)
					$chat_partner = $get_o2o['userid1'];
				
					if($conv->reply_to){
					$msg_qry2 = $this->db->query("SELECT * FROM Messages WHERE mid = {$conv->reply_to}");
					$msg2 = $msg_qry2->row_array();
					$msg2['sender'] = $conv->sender;
					$msg2['username'] = $this->get_username($conv->sender);

					$msg['repliedTo'] = $msg2;
					}

					//$msg['title'] = $grp_title;
					//$msg['img'] = $grp_img;

					//$data2['msg'][] = $msg;

					$data2['messages'][] = $msg;
				}
			}
					$data3[] = $data2;
		}

		$temp = $data3[0]['messages'];
		$rev_arr = array_reverse($temp);
		$data3[0]['messages'] = $rev_arr;

		return $data3;		
	}

	public function insert_message($data){
		$sender		= $data['sender'];
		$type			= $data['type'];
		$recipient	= $data['recipient'];
		$reply_to	= $data['reply_to'];
		$content		= $data['content'];
		$image		= $data['image'];

		$data2['msg'] = null;

		if($type == 'team' or $type == 'Team'){
			$team_id = $recipient;
			$grp_qry = $this->db->query( "SELECT gid FROM Groups WHERE type = 'Team' AND type_ref = $team_id" );
		//echo $this->db->last_query(); exit;
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
		else if($type == 'tournament' or $type == 'Tournament'){
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
		else if($type == 'one2one' or $type == 'One2One'){
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

		//echo $gid; exit;
				$now = strtotime(date('Y-m-d H:i:s'));
				//$data3 = array('content' => $content, 'created_on' => $now);
				///$ins  = $this->db->insert('Messages', $data3);	
				$content = str_replace("'","''", $content);

				if($image != ''){
				$this->db->query("INSERT INTO Messages (image, created_on) VALUES ('$image', $now)");
				}
				else{
				$this->db->query("INSERT INTO Messages (content, created_on) VALUES (N'$content', $now)");
				}

				$mid = $this->db->insert_id();

				$data3 = array(
							'mid'			=> $mid,
							'reply_to'	=> $reply_to,
							'recipient'	=> $gid,
							'sender'		=> $sender
							);

				if($mid){  // Some of the rows is missing mid values in conversation table. 
					$ins  = $this->db->insert('Conversations', $data3);	
					$cid = $this->db->insert_id();
				}

		//print_r($data3); exit;
		//return $mid;	
		
		if($image)
			$image = base_url()."messages_imgs/".$image;
		return array("mid"				 => intval($mid),
							"content"		 => $content,
							"image"			 => $image,
							"created_on" => $now,
							"sender"		 => $sender);
	}

	public function insert_message2($data){
		$sender	= $data['sender'];
		$type		= $data['type'];
		$recipient	= $data['recipient'];
		$reply_to	= $data['reply_to'];
		$content	= $data['content'];

		$data2['msg'] = null;

		if($type == 'team' or $type == 'Team'){
			$team_id = $recipient;
			$grp_qry = $this->db->query( "SELECT gid FROM Groups WHERE type = 'Team' AND type_ref = $team_id" );
		//echo $this->db->last_query(); exit;
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
		else if($type == 'tournament' or $type == 'Tournament'){
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
		else if($type == 'one2one' or $type == 'One2One'){
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

		//echo $gid; exit;
				$now = strtotime(date('Y-m-d H:i:s'));
				$data3 = array('content'		=> $content,
										'created_on' => $now);

				$ins  = $this->db->insert('Messages2', $data3);	
				$mid = $this->db->insert_id();

				$data3 = array(
							'mid'				=> $mid,
							'reply_to'		=> $reply_to,
							'recipient'		=> $gid,
							'sender'		=> $sender
							);

				$ins  = $this->db->insert('Conversations2', $data3);	
				$cid = $this->db->insert_id();
		//print_r($data3); exit;
		//return $mid;	

		return array("mid"				 => intval($mid),
							"content"		 => $content,
							"image"			 => null,
							"created_on" => $now,
							"sender"		 => $sender);
	}

	public function get_all_messages($user_id, $type, $page){
		$data = "";

		$limit	= 25;
		$offset = ($page * $limit) - $limit;

		if($type == 'all'){
			$get_convs = $this->db->query("SELECT recipient FROM Conversations WHERE recipient in (
			SELECT recipient FROM Conversations WHERE recipient IN (
			SELECT gid FROM Groups WHERE (type = 'Team' AND type_ref IN (SELECT Team_ID FROM Teams WHERE (Players LIKE '%".'"'.$user_id.'"'."%' OR Created_by = {$user_id} OR Captain = {$user_id}))) OR (type = 'Tournament' AND (type_ref IN (SELECT Tournament_ID FROM RegisterTournament WHERE Users_ID = {$user_id}) OR type_ref IN (SELECT tournament_ID FROM tournament WHERE Usersid = {$user_id}))) OR (type = 'One2One' AND type_ref IN (SELECT id FROM One2One WHERE (userid1 = {$user_id} OR userid2 = {$user_id})))
			)
			) GROUP BY recipient ");
								//echo $this->db->last_query(); exit;

		}
		else if($type == 'one2one'){
			$get_convs = $this->db->query("SELECT recipient FROM Conversations WHERE recipient in (
			SELECT recipient FROM Conversations WHERE recipient IN (
			SELECT gid FROM Groups WHERE (type = 'One2One' AND type_ref IN (SELECT id FROM One2One WHERE (userid1 = {$user_id} OR userid2 = {$user_id}))))
			) GROUP BY recipient ");
		}
		else if($type == 'team'){
			$get_convs = $this->db->query("SELECT recipient FROM Conversations WHERE recipient in (
			SELECT recipient FROM Conversations WHERE recipient IN (
			SELECT gid FROM Groups WHERE (type = 'Team' AND type_ref IN (SELECT Team_ID FROM Teams WHERE (Players LIKE '%".'"'.$user_id.'"'."%' OR Created_by = {$user_id} OR Captain = {$user_id}))))) GROUP BY recipient ");
		}
		else if($type == 'tournament'){
			$get_convs = $this->db->query("SELECT recipient FROM Conversations WHERE recipient in (
			SELECT recipient FROM Conversations WHERE recipient IN (
			SELECT gid FROM Groups WHERE type = 'Tournament' AND (type_ref IN (SELECT Tournament_ID FROM RegisterTournament WHERE Users_ID = {$user_id}) OR type_ref IN (SELECT tournament_ID FROM tournament WHERE Usersid = {$user_id})))) GROUP BY recipient ");
		}

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
				$sport		= $get_tour['SportsType'];

				if($get_tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$get_tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/".$this->tourn_def_imgs[$sport];

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
				$get_msg['username'] = $this->get_username($get_con2['sender']);

				$data2['lastSentMessage'] =$get_msg;
			$data[] = $data2;
		}
	}
//echo "<pre>"; print_r($data); exit;

usort($data, array($this,'sortByOrder'));
		return $data;
	}

public function sortByOrder($a, $b) {
   // return $a['lastSentMessage']['created_on'] - $b['lastSentMessage']['created_on']; // ASC
    return $b['lastSentMessage']['created_on'] - $a['lastSentMessage']['created_on']; // DESC
}

	public function get_search_recom($user_id){
		$data = "";

		$get_convs = $this->db->query("SELECT recipient FROM Conversations WHERE recipient in (
		SELECT recipient FROM Conversations WHERE recipient IN (
		SELECT gid FROM Groups WHERE type_ref IN (SELECT Team_ID FROM Teams WHERE (Players LIKE '%".'"'.$user_id.'"'."%' OR Created_by = {$user_id} OR Captain = {$user_id})) OR type_ref IN (SELECT Tournament_ID FROM RegisterTournament WHERE Users_ID = {$user_id}) OR type_ref IN (SELECT tournament_ID FROM tournament WHERE Usersid = {$user_id}) OR type_ref IN (SELECT id FROM One2One WHERE (userid1 = {$user_id} OR userid2 = {$user_id}))
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
				$sport = $get_tour['SportsType'];

				if($get_tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$get_tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/".$this->tourn_def_imgs[$sport];

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
				$sport = $tour['SportsType'];

				if($tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/".$this->tourn_def_imgs[$sport];

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

	public function get_search_recom2($q, $user_id = '', $page){
		$data = "";

// ---------------- Users -----------------------------------------------------

				$qry_tmp   = $this->db->query("SELECT * FROM Users WHERE (Firstname LIKE '%".$q."%' OR Lastname LIKE '%".$q."%')");
				//echo $this->db->last_query(); exit;
				$get_users = $qry_tmp->result_array();
				foreach($get_users as $usr){
				$grp_title = $usr['Firstname']. " ". $usr['Lastname'];
				if($usr['Profilepic'])
					$grp_img = base_url()."profile_pictures/".$usr['Profilepic'];
				else
					$grp_img = base_url()."profile_pictures/default-profile.png";

				$data2['group_id'] = null;
				$data2['title'] = $grp_title;
				$data2['img'] = $grp_img;
				$data2['type'] = "One2One";
				$data2['id'] = $usr['Users_ID'];

			$data[] = $data2;
				}
// -------------------------- Users ---------------------------------------

// ---------------- Teams -----------------------------------------------------
				if($user_id)
				$qry_tmp   = $this->db->query("SELECT * FROM Teams WHERE Team_name LIKE '%".$q."%' AND (Players LIKE '%".'"'.$user_id.'"'."%' OR Created_by = {$user_id} OR Captain = {$user_id})");
				else
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
				$data2['id'] = $tm['Team_ID'];

			$data[] = $data2;
				}
// -------------------------- Team ---------------------------------------


// -------------------------- Tournament ---------------------------------------

				if($user_id)
				$qry_tmp   = $this->db->query("SELECT * FROM tournament WHERE tournament_title LIKE '%".$q."%' AND (tournament_ID IN (SELECT Tournament_ID FROM RegisterTournament WHERE Users_ID = {$user_id}) OR tournament_ID IN (SELECT tournament_ID FROM tournament WHERE UsersID = {$user_id}))");
				else
				$qry_tmp   = $this->db->query("SELECT * FROM tournament WHERE tournament_title LIKE '%".$q."%'");

				$get_tours = $qry_tmp->result_array();

				foreach($get_tours as $tour){
				$grp_title = $tour['tournament_title'];
				$sport	   = $tour['SportsType'];

				if($tour['TournamentImage'])
					$grp_img = base_url()."tour_pictures/".$tour['TournamentImage'];
				else
					$grp_img = base_url()."tour_pictures/".$this->tourn_def_imgs[$sport];

				$data2['group_id'] = null;
				$data2['title'] = $grp_title;
				$data2['img'] = $grp_img;
				$data2['type'] = "Tournament";
				$data2['id']	= $tour['tournament_ID'];

			$data[] = $data2;

				}

// -------------------------- Tournament ---------------------------------------

		return $data;
	}

	public function insert_test2($msg){
				//$ins  = $this->db->insert('tab2', $data3);
				$this->db->query("INSERT INTO tab3 (col) VALUES (N'$msg')");
				//echo $this->db->last_query();
	}

}