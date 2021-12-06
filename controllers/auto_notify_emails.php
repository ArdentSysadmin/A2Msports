<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Event Reminder controller ..
class auto_notify_emails extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();

		$this->load->helper(array('form', 'url'));

		$this->load->model('model_auto_notify','auto_notify');
		$this->load->model('model_general', 'general');
		//$this->load->model('model_news');
	}

	public function index(){
		$get_tournaments = $this->auto_notify->get_tour_notifications();

		if(count($get_tournaments) > 0){
			
		//---------------------------------------------
			foreach($get_tournaments as $tour){

				if($tour->is_academy == 1){
					// if Academy
				}
				else{
					$get_tour_det    = $this->general->get_data('tournament', 'tournament_ID', $tour->rel_id);

					$data['country'] = $get_tour_det['TournamentCountry'];
					$data['state']	 = $get_tour_det['TournamentState'];
					$data['lat']	 = $get_tour_det['latitude'];
					$data['long']	 = $get_tour_det['longitude'];
					$data['sport']	 = $get_tour_det['SportsType'];

					$data['range']	 = 80;
					
					$get_rel_users  = $this->auto_notify->get_sport_users($data);
					$tour_id		= $get_tour_det['tournament_ID'];
                    
					foreach($get_rel_users as $user_id){
						$player			 = $user_id->Users_ID;
						$user_details	 = $this->general->get_user($player);
                        $notify_sports   = json_decode($user_details['NotifySports'], true);

						if(!in_array($sport_id, $notify_sports) || $sport_id < 0){
							//echo $player."<br>";
							$this->send_email_user($player, 'tournament', 'tournament_ID', $tour_id);
						}					
					}
				}

				$upd_notif = $this->auto_notify->update_notif_stat($tour->nid);
			}

		//---------------------------------------------
		}

		$get_news = $this->auto_notify->get_news_notifications();

		if(count($get_news) > 0){
			foreach($get_news as $news){

				$get_news_det  = $this->general->get_data('Sports_News', 'News_id', $news->rel_id);
       
				$news_id	   = $get_news_det['News_id'];
				$sport_id      = $get_news_det['SportsType_id'];

				if($news->is_academy == 1){
					// if Academy
					$get_aca_users = $this->auto_notify->get_aca_users($news->academy_id);
           
					foreach($get_aca_users as $user_id){	
						$player = $user_id->Users_id;
                        $user_details = $this->general->get_user($player);
                        //$notify_settings = json_decode($user_details['NotifySettings'], true);
                        $notify_sports   = json_decode($user_details['NotifySports'], true);
	                        if(!in_array($sport_id, $notify_sports) || $sport_id < 0){
                               $this->send_email_user($player, 'Sports_News', 'News_id', $news_id);
	                        }
					}
				}
				else{
					$get_rel_users = $this->auto_notify->get_rel_users($get_news_det['SportsType_id']);
                   
					foreach($get_rel_users as $user_id){	
						$player		   = $user_id->users_id;
						$user_details  = $this->general->get_user($player);
                        $notify_sports = json_decode($user_details['NotifySports'], true);

						if(!in_array($sport_id, $notify_sports) || $sport_id < 0){
						   $this->send_email_user($player, 'Sports_News', 'News_id', $news_id);
						}
					}
				}

				$upd_notif = $this->auto_notify->update_notif_stat($news->nid);

			}
		}

		 /* Start of Tournment Participants Notifications */

       $get_trn_prt_notify  = $this->auto_notify->Get_tournmnetpartcpnts_Notfy();
      //echo "<pre>"; print_r($get_trn_prt_notify); exit;
        if(count($get_trn_prt_notify) > 0){
			foreach($get_trn_prt_notify as $notify){
				$players_arr	= json_decode($notify->players);	
                $message     = html_entity_decode($notify->message);
                $subject		= $notify->subject;
				$exist_notified_players = array();
				//echo var_dump($notify->notified_to_players);
				//exit;
				if($notify->notified_to_players and $notify->notified_to_players != 'null')
				$exist_notified_players = json_decode($notify->notified_to_players, TRUE);
				
				$is_academy = 0;
				$academy_id = '';
				if($notify->is_academy){
				$is_academy = $notify->is_academy;
				$academy_id = $notify->academy_id;
				}

				$notified_players = $this->tm_send_email_user_attachments($players_arr, $subject, $message, $notify->attachments_file, $notify->tourn_id, $is_academy, $academy_id);
				
				$tobe_notified		 = array_diff($players_arr, $notified_players);
				$new_notified_plrs  = array_merge($exist_notified_players, $notified_players);

				if($tobe_notified){
					$tobe_notified_temp = array_values($tobe_notified);
					$upd_notif   = $this->auto_notify->update_tobe_notified_prtcpnts($notify->mid, $tobe_notified_temp, $new_notified_plrs);
				}
				else{
					$upd_notif   = $this->auto_notify->update_tm_prtcpnts_notif_stat($notify->mid, $new_notified_plrs);
				}
			}
		}
		 /* End of Tournment Participants Notifications */



		/* Start of Portal Admin Messages to Players */

	   $get_prtusers_notify  = $this->auto_notify->GetPortal_AdmUsersNotfy();

       if(count($get_prtusers_notify) > 0){
		   $notified_players		= array();
			foreach($get_prtusers_notify as $notify){
				$players_arr	    = json_decode($notify->players, true);
				$players_count  = count($players_arr);
				$limit = 30;
				//$limit = 15;
				if($notify->attachments_file){
				$limit = 10;
				}
				
 			  	$remaining_players = array_splice($players_arr, $limit);

                $message     = html_entity_decode($notify->message);
                $subject     = $notify->subject;
				$attch_file_path = '';
				if($notify->attachments_file){
				$attch_file_path = $notify->attachments_file;
				}

 				$failed_players = $this->send_email_user_attachments($players_arr, $subject, $message, $attch_file_path, '');

				if(!empty($failed_players)){
					$remaining_players  = array_merge($remaining_players, $failed_players);
					$players_arr			  = array_diff($players_arr, $failed_players);
				}

				if($notify->notified_to_players == NULL){
					$notified_players = json_encode($players_arr);
				}
				else{
					$players_buffer   = json_decode($notify->notified_to_players, true);
					$players_buffer   = array_merge($players_buffer, $players_arr);
 					$notified_players = json_encode($players_buffer);
				}

				if(count($remaining_players) == 0){
					$is_notified	   = 1;
					$remaining_players = NULL;
				}
				else{
					$is_notified	   = 0;
					$remaining_players = json_encode($remaining_players);
				}
			
			$data['players']					 = $remaining_players;
			$data['notified_to_players']  = $notified_players;
			$data['is_notified']				 = $is_notified;
			$data['notified_on']				 = date('Y-m-d H:i');
			
			/*echo "<pre>";
			print_r($data);
			exit;*/
			$upd_notif = $this->auto_notify->UpdatePortal_AdmUsers_NotifyStat($data, $notify->mid);
			}
	   }

		/* End of Portal Admin Messages to Players */
	 }


	public function send_email_user($player, $table, $field, $tab_id){

		$sql	= "SELECT * FROM users WHERE Users_ID = " .$player;
		$result = $this->db->query($sql);
		$row	= $result->row();

		if($row->EmailID != ""){
			$user_email = trim($row->EmailID);
		}
		else{
			$user_email = trim($row->AlternateEmailID);
		}

		/* ------------------------------------------------------ */

		$get_data = $this->general->get_data($table, $field, $tab_id);

		switch($table){
			
			case 'Sports_News':
					$title		= $get_data['News_title'];
					$details	= $get_data['News_content'];
					$page		= 'News Notification';

					$data = array(
						'firstname'		=> $row->Firstname,
						'lastname'		=> $row->Lastname,
						'unsubscribe'	=> 1,
						'user_id'		=> $row->Users_ID,
						'news_id'		=> $tab_id,
						'news_title'	=> $title,
						'news_details'	=> $details,
						'page'			=> $page
					);

					$ctype = 'News';
					break;

			case 'tournament':
					$title		= $get_data['tournament_title'];

					$start_date = date('m/d/Y',strtotime(substr($get_data['StartDate'], 0, 10))); 
					$close_date = date('m/d/Y',strtotime(substr($get_data['Registrationsclosedon'], 0, 10)));

					$venue		= $get_data['venue'];
					$address	= $get_data['TournamentAddress'];
					$city		= $get_data['TournamentCity'];
					$state		= $get_data['TournamentState'];
					$country	= $get_data['TournamentCountry'];

					$title		= $get_data['tournament_title'];
					$gen		= $get_data['Gender'];

					if($gen == "all"){ $gender = "Open to all"; } else if($gen == "1"){ $gender = "Male"; } else if($gen == "0"){ $gender = "Female"; }else { $gender = "Not provided"; }

					$location = "";
	
					if($venue != "" and $venue != '0') { $location .= $venue;}
					if($address != "" and $address != '0') { $location .=  ", " . $address ;} 
					if($city	!= "") { $location .=  ", " . $city;} 
					if($state	!= "") { $location .=  ", " . $state;} 
					if($country != "") { $location .=  ", " . $country . ".";} 

					$sport_id	= $get_data['SportsType'];
					$name		= $this->general->get_data('SportsType', 'SportsType_ID', $sport_id);
					$sport_title = $name['Sportname'];
					$sport_sc    = $name['ShortCode'];

					$organizer	= $get_data['OrganizerName'];
					$contact	= $get_data['ContactNumber'];


					if($get_data['is_mult_fee'] == 0 and $get_data['Tournamentfee'] == 1){				
						$is_mult	= 0;
						$fee		= $get_data['TournamentAmount'];
						$extrafee	= $get_data['extrafee'];
					}
					else if($get_data['is_mult_fee'] == 1 and $get_data['Tournamentfee'] == 1){
						$is_mult	= 1;
						$fee		= $get_data['mult_fee_collect'];
						$extrafee	= $get_data['addn_mult_fee_collect'];
					}

					$page  = 'New Tournament Creation';
					$ctype = 'Tournament';

					$data = array(
						 'fname'	=> $row->Firstname,
						 'lname'	=> $row->Lastname,
						 'sport'	=> $sport_title,
						 'sport_sc'	=> $sport_sc,
						 'gender'	=> $gender,
						 'age_groups'	=> $get_data['Age'],
						 'is_mult'		=> $is_mult,
						 'fee'		=> $fee,
						 'extrafee' => $extrafee,
						 'org'		=> $organizer,
						 'contact'	=> $contact,
						 'title'	=> $title,
						 'start_date' => $start_date,
						 'close_date' => $close_date,
						 'location' => $location,
						 'tourn_id' => $tab_id,
						 'unsubscribe' => 1,
						 'user_id' => $row->Users_ID,
						 'page'		=> $page
						 );

					break;

			default:
					$title		= "";
					$details	= "";
					$page		= '';
					break;
		}

	
		$this->load->library('email');
		$this->email->set_newline("\r\n");

		$this->email->from('admin@a2msports.com', 'A2M Sports');
		$this->email->to($user_email);
		$this->email->subject("A2M ".$ctype." - " . $title);

		$body = $this->load->view('view_email_template.php', $data, TRUE);

		$this->email->message($body);

		echo $body."<br>";
		echo $user_email."<br>";
		if(filter_var($user_email, FILTER_VALIDATE_EMAIL)){
		$s_email = $this->email->send();
		}
		if($s_email)
			{ echo "Success<br/>"; }
		else { 
			//echo $this->email->print_debugger();
			echo "Fail<br/>"; 
		}	

	}

	public function send_email_user_attachments($player_arr, $subject, $message, $file, $tourn_id){

		if($tourn_id){
		  $ctype	 = "Tournament";
          $tourn_det = $this->general->get_tour_info($tourn_id);
          $title	 = ucwords($tourn_det['tournament_title']);
          $tadmin	 = ucwords($tourn_det['OrganizerName']);
		  $get_user = $this->general->get_onerow('Users', 'Users_ID', $tourn_det['Usersid']);
			  if($get_user['EmailID'])
			    $reply_to = $get_user['EmailID'];
			  else if($get_user['AlternateEmailID'])
			    $reply_to = $get_user['AlternateEmailID'];
			  else
				$reply_to = "";
		}
		else{
		  $ctype  = "Portal";
		  $title  = "";
		  $tadmin = "";
		  $reply_to = '';
		}

        $this->load->library('email');
		$this->email->clear();

        $page = 'Admin Notification';
		$failed_players = array();

       foreach($player_arr as $key => $player){

          $sql	  = "SELECT * FROM Users WHERE Users_ID = '$player'";
		  $result = $this->db->query($sql);
		  $row	  = $result->row();

			if($subject == NULL || $subject == ""){
               $subj = "Message from ".$ctype." Admin - " . $title;
            }
			else{
          	   $subj = $subject;
            }

		    if($row->EmailID != ""){
			  $user_email = trim($row->EmailID);
		    }
		    else{
			  $user_email = trim($row->AlternateEmailID);
		    }
            
            $data = array(
						 'firstname'=> $row->Firstname,
						 'lastname'	=> $row->Lastname,
						 'title'	=> $title,
						 'tourn_id' => $tourn_id,
						 'mes'		=> $message,
						 'tadmin'	=> $tadmin,
						 'page'		=> $page
					);

            // echo "fiel = ". $file;
			if($file != '' and $file != NULL){
            $this->email->attach($file);
			}
		    $this->email->set_newline("\r\n");
		    $this->email->set_crlf("\r\n");
			$this->email->from(FROM_EMAIL, 'A2MSports');
			$this->email->to($user_email);
			if($reply_to)
				$this->email->reply_to($reply_to);

			$this->email->subject($subj);
			
			$body = $this->load->view('view_email_template', $data, TRUE);
			$this->email->message($body);
			if(filter_var($user_email, FILTER_VALIDATE_EMAIL)){
			$s_email = $this->email->send();
			}
			//$s_email = 1;

			if($s_email){ 
				echo "Success<br/>";
				$notified_players[] = $player;
			}
			else{ 
				//echo $this->email->print_debugger();
				echo "Fail<br/>";
				//$failed_players[] = $player;
			}
        }		// end of for

	return $failed_players;
	}


	public function tm_send_email_user_attachments($player_arr, $subject, $message, $file, $tourn_id, $is_academy, $academy_id){

		if($tourn_id){
		  $ctype	 = "Tournament";
          $tourn_det = $this->general->get_tour_info($tourn_id);
		  $get_user = $this->general->get_onerow('Users', 'Users_ID', $tourn_det['Usersid']);

          $title	 = ucwords($tourn_det['tournament_title']);
          //$tadmin	 = ucwords($tourn_det['OrganizerName']);
          $tadmin	 = ucwords($get_user['Firstname']." ".$get_user['Lastname']);
			  if($get_user['EmailID'])
			   $reply_to = $get_user['EmailID'];
			  else if($get_user['AlternateEmailID'])
			   $reply_to = $get_user['AlternateEmailID'];
			  else
			   $reply_to = "";
		}
		else{
		  $ctype  = "Portal";
		  $title  = "";
		  $tadmin = "";
		  $reply_to = '';
		}

        $this->load->library('email');
		$this->email->clear();

        $page = 'Admin Notification';
		$failed_players = array();
		$tobe_notified = array();
		$notified_players = array();
$i = 1;

       foreach($player_arr as $key => $player){

          $sql	  = "SELECT * FROM Users WHERE Users_ID = '$player'";
		  $result  = $this->db->query($sql);
		  $row	  = $result->row();

			if($subject == NULL || $subject == ""){
               $subj = "Message from ".$ctype." Admin - " . $title;
            }
			else{
          	   $subj = $subject;
            }

		    if($row->EmailID != "" and $row->EmailID != "null"){
			  $user_email = trim($row->EmailID);
		    }
		    else if($row->AlternateEmailID != "" and $row->AlternateEmailID != "null"){
			  $user_email = trim($row->AlternateEmailID);
		    }
			else{
			  $user_email = NULL;
			}
            
            $data = array(
						 'firstname'=> $row->Firstname,
						 'lastname'	=> $row->Lastname,
						 'title'	=> $title,
						 'tourn_id' => $tourn_id,
						 'mes'		=> $message,
						 'tadmin'	=> $tadmin,
						 'page'		=> $page
					);

            // echo "fiel = ". $file;
			if($file != '' and $file != NULL){
            $this->email->attach($file);
			}
		    $this->email->set_newline("\r\n");
		    $this->email->set_crlf("\r\n");
			$this->email->to($user_email);
			if($reply_to)
				$this->email->reply_to($reply_to);

			$this->email->subject($subj);

			if($is_academy){
				$aca_info  = $this->auto_notify->get_academy($academy_id);
				$data['aca_logo']	= $aca_info['Aca_logo'];
				$data['aca_name']	= $aca_name = $aca_info['Aca_name'];
				$data['aca_proxy_url']	= $aca_info['A2M_Proxy_URL'];

				$this->email->from(FROM_EMAIL, ucwords($aca_name));
				$body = $this->load->view('academy_views/view_email_template', $data, TRUE);
			}
			else{
				$this->email->from(FROM_EMAIL, 'A2MSports');
				$body = $this->load->view('view_email_template', $data, TRUE);
			}

			$this->email->message($body);
			//echo $body;exit;
			$s_email = 0;
			//if($i <= 4){
			if($i <= 20){
				//echo $player. "test <br>";
				if(filter_var($user_email, FILTER_VALIDATE_EMAIL)){
					$s_email = $this->email->send();
				}
			$notified_players[] = $player;
			}
			//$s_email = 1;

			if($s_email){ 
				echo $player." - Success<br/>";
				//$notified_players[] = $player;
			}
			else{ 
				//echo $this->email->print_debugger();
				echo $player." - Fail<br/>";
				//$failed_players[] = $player;
			}

			$i++;
        }		// end of for

	return $notified_players;
	}

	public function ReCaliculate_DOB(){
     	$sql      = "SELECT Users_ID,DOB,UserAgegroup FROM Users WHERE DOB is not null";
		$query    = $this->db->query($sql);
		$result   = $query->result();
		$updated_users = array();

		foreach ($result as $key => $value) 
		{
		  if($value->DOB != ""){
		    //$user_dob = $value->DOB;

            //$user_age = (date('Y') - date('Y',strtotime($user_dob)));
			$birthdate	= new DateTime($value->DOB);
			$today		= new DateTime('today');
			$user_age	= $birthdate->diff($today)->y;

            switch (true) {
                case $user_age <= 9:
                   $user_age_grp = "U9";
                   break;
                case $user_age == 10:
                   $user_age_grp = "U10";
                   break;
                case $user_age == 11:
                   $user_age_grp = "U11";
                   break;
                case $user_age == 12:
                   $user_age_grp = "U12";
                   break;
                case $user_age == 13:
                   $user_age_grp = "U13";
                   break;
                case $user_age == 14:
                   $user_age_grp = "U14";
                   break;
                case $user_age == 15:
                   $user_age_grp = "U15";
                   break;
                case $user_age == 16:
	               $user_age_grp = "U16";
	               break;
                case $user_age == 17:
                   $user_age_grp = "U17";
                   break;
                case $user_age == 18:
                   $user_age_grp = "U18";
                   break;
                case $user_age == 19:
                   $user_age_grp = "U19";
                   break;
                case $user_age > 19:
                   $user_age_grp = "Adults";
                   break;
			}
             
            if($user_age_grp != $value->UserAgegroup){
				//echo $value->Users_ID." - ".$user_age." - ".$value->UserAgegroup." - ".$user_age_grp."<br>";
			   $updated_users[] = $value->Users_ID;
               $upd_dob = $this->auto_notify->UpdateDOB($value->Users_ID, $user_age_grp);
			   //echo '$value->Users_ID '.$value->Users_ID.' $user_age_grp '.$user_age_grp.'<br>';
            }
		  }
		}
		
		/*echo 'Success';
		echo '<pre>';
		print_r($updated_users);*/
	}

	public function insertUsers(){
		  /*$user_array = array(
						array('UPASANA','KOTAKONDA','latha0904@gmail.com',NULL,0),
						array('DANIEL','LAIJ','asing_kwok@yahoo.com',6788628819,1),
						array('RAKSHA','GOVIND','vanigovind@gmail.com',4044352988,0),
						array('TANMAYA','MUVVA','rkmuvva@gmail.com',6788957620,0),
						array('MADHURA','GANGAL','madhuragangalans@gmail.com',4047294423,0),
						array('MITHUN','GOPINATH','gopinath.kannaiyan@ymail.com',7703099700,1),
						array('PRATEEK','HALLI','hdwarka@yahoo.com',4043684425,1),
						array('VIPUL','DHOTRE','santoshvdhotre@gmail.com',4047296566,1),
						array('CHAARVI','SATHEESH','divya.satheesh@gmail.com',4046423781,0),
						array('AMITH','PATIBANDLA','vanisreepatibandla@gmail.com',7706220492,1),
						array('MONISH','PATIL','jahnavidpatil@gmail.com',6784679822,1),
						array('MANASWI','NULL','chinni_nellore@yahoo.com',7708815825,0),
						array('MATTHEW','SUJANTO','alingkwok@yahoo.com',4049358126,1),
						array('SHARVI','SHARMA','s.vikas@yahoo.com',6462560653,0),
						array('MOURYA','MANJUNATH','manju26@gmail.com',8179079341,1),
						array('VEDANT','KALIPATNAPU','satish37@yahoo.com',6789070939,1),
						array('YASHVEER','MUMMIDI','mdugangadhar@gmail.com',4703382767,1),
						array('ANANYA','KOLLIPAKA','praveen.akki@gmail.com',6787632835,0),
						array('SOHAM','GADDAM','sunilgin@hotmail.com',2054275027,0),
						array('AHWAN','MISHRA','mishrashweta1980@gmail.com',4044229895,1),
						array('VIGNESH','SIVASANKAR','skandasamy23@gmail.com',4049033468,1),
						array('VERA','SKACHKOV','skachkov.vladimir@gmail.com',4043723300,1),
						array('SMIRTHI','JAYAPRAKASH','jp.mas.home@gmail.com',4043450108,0),
						array('NIKHIL','PAMPATWAR','manish241@gmail.com',6308005154,1),
						array('JAHNAVI','SINGH','gkher20@gmail.com',7035016028,0),
						array('HITANSH','SHAH','rupesh_shah@yahoo.com',2147628622,1)
						);*/

			/*$user_array = array(
						array('RUSHIL','NULL','ayaser@gmail.com',4046301225,1),
						array('ANA','DAFTARI','dpabhay@yahoo.com',7702893170,1),
						array('ADITI','GOKHALE','gosantosh@gmail.com',4049808097,0),
						array('VINAY','HONNE','honne.girish@gmail.com',6142094664,1),
						array('LUKE','MARK','iamputtnam@gmail.com',3133504888,1),
						array('SANIKA','KIRANGI','pkirangi@yahoo.com',6789979622,0),
						array('SHRUTHI','MADHAVAN','punitha.cm@gmail.com',6782966678,0),
						array('KAVIN','SHAH','shahvirajs@gmail.com',7322086495,1),
						array('RAM','CHAUDHARI','vikas.chaudhari.ibm@gmail.com',4049520921,1),
						array('PRISHA','BAGAD','yogesh.bagad@gmail.com',5109907773,0)
						);*/

			/*$user_array = array(
						array('RASHID','NULL','ayaser@gmail.com',4046301225,1,'rashid'),
						array('RIYAH','DAFTARI','dpabhay@yahoo.com',7702893170,0,'riyah.d'),
						array('ABHA','GOKHALE','gosantosh@gmail.com',4049808097,1,'a.gokhale'),
						array('SHARVYA','HONNE','honne.girish@gmail.com',6142094664,0,'sharvya.h'),
						array('ADIYA','MARK','iamputtnam@gmail.com',3133504888,0,'adiya.m'),
						array('SAHIL','KIRANGI','pkirangi@yahoo.com',6789979622,1,'sahil.k'),
						array('NAVEEN','MADHAVAN','punitha.cm@gmail.com',6782966678,1,'naveen.m'),
						array('NIRVI','SHAH','shahvirajs@gmail.com',7322086495,0,'nirvi.s'),
						array('KALYANI','CHAUDHARI','vikas.chaudhari.ibm@gmail.com',4049520921,0,'kalyani.c'),
						array('ANUSHKA','BAGAD','yogesh.bagad@gmail.com',5109907773,0,'anushka.b')
						);*/

			/*$user_array = array(
						array('ANA','DAFTARI','dpabhay@yahoo.com',7702893170,0,'a.daftari'), 
						array('DHVANI','SHANKAR','kripakrish@gmail.com',3136459370,1,'d.shankar'),
						array('VYASAN','PRAKASH','sendhil.prakash@gmail.com',6785178768,1,'v.prakash'),
						array('PRANAV','Vempati','pavan2@gmail.com',3312209550,1,'p.vempati')
						);*/




			$user_array = array(
						array(1036,981), 
						array(1037,1027), 
						array(1038,449), 
						array(1039,1026), 
						);

		 foreach ($user_array as $key => $value){
		 	
		    //$insert_users = $this->auto_notify->InsertChildParentInfo($value);	
		   
		 }
	}

}