<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paypal extends CI_Controller 
{
	public $short_code;
	//public $academy_admin;
	public $academy_id;

     function  __construct(){
        parent::__construct();
        $this->load->library('paypal_lib');
		$this->load->library('session');

        $this->load->model('model_league');
        $this->load->model('model_event');
		//$this->load->model('model_general');
		$this->load->model('academy_mdl/model_general', 'general');
		$this->load->model('model_news');
		$this->load->model('academy_mdl/model_paypal', 'model_paypal');

		$this->short_code		= $this->uri->segment(1);
		//$this->academy_admin	= $this->general->get_org_admin($this->short_code);
		$this->academy_id		= $this->general->get_orgid($this->short_code);
     }
     
	 function get_username($user_id) {
		return $this->general->get_user($user_id);
	 }

	 function msuccess(){
       $this->session->unset_userdata('tour_reg_fee');
		$this->session->unset_userdata('reg_tour_id');

        //get the transaction data
        $paypalInfo = $this->input->get();

        $data['item_number']	= $paypalInfo['item_number']; 
        $data['txn_id']			= $paypalInfo["tx"];
        $data['payment_amt']	= $paypalInfo["amt"];
        $data['currency_code']	= $paypalInfo["cc"];
        $data['status']			= $paypalInfo["st"];
        if($this->input->get('ttype') == 'Indv'){		
			$data['player']		= $user_id		= $this->input->get('player');
			$data['tourn_id']	= $tourn_id		= $this->input->get('tourn_id');
			$data['age_group']	= $age_group	= $this->input->get('age_group');
			$data['mtypes']		= $match_types	= $this->input->get('mtypes');
			//$data['partner1']	= $partner1		= $this->input->get('partner1');
			//$data['partner2']	= $partner2		= $this->input->get('partner2');
			$data['level']		= $level		= $this->input->get('level');
			$data['events']     = $reg_events   = $this->input->get('events');

			$res = $this->model_league->reg_more_tourn_with_fee($data);

			$data['reg_suc'] = "You have successfully registered for more events.";
			redirect("league/$tourn_id/1");
		 }

	 }

/*function success(){

echo "Transaction complete!";

}*/

	public function ev_success(){

        $paypalInfo = $this->input->get();
		
		/*echo "<pre>";
		print_r($paypalInfo);
		exit;*/
		

        //get the transaction data
        //$paypalInfo = $this->input->get();

		$data = array();
		$data['item_number']	= $this->input->get('item_number');

		if($this->input->get('tx')){
		$data['txn_id']	= $this->input->get('tx');
		}
		else{
		$data['txn_id']	= $this->input->get('token');
		}

		$data['payment_amt']	= $this->input->get('amt');
		$data['currency_code']	= $this->input->get('cc');
		$data['status']			= $this->input->get('st');

		$data['ev_id']	 = $ev_id	= $this->input->get('ev_id');
		$data['user_id'] = $user_id	= $this->input->get('reg_user');

		$data2['event_id'] = $this->input->get('ev_id');
		$data2['user']	   = $this->input->get('reg_user');
		/*echo "<pre>";
		print_r($data2);
		exit;*/
		$is_ev_user = $this->model_event->check_is_invited_user($data2);
		$res		= $this->model_league->event_fee_paymet($data);
		
		if(!$is_ev_user){
			
			$rep_events = $this->model_event->get_rep_events($ev_id);
			   foreach($rep_events as $obj){
					$data['user']	   = $user_id;
					$data['event_id']  = $ev_id;
					$data['ev_rep_id'] = $obj->Ev_Tab_ID;
					$data['ev_status'] = 'Accept';

					$create_inv = $this->model_event->ins_ev_invite($data);
			   }
		}
		else{
			$rep_events = $this->model_event->get_rep_events($ev_id);
			   foreach($rep_events as $obj){
					$data['user']	   = $user_id;
					$data['ev_rep_id'] = $obj->Ev_Tab_ID;

					$update_inv = $this->model_event->upd_ev_invite($data);
			   }
		}
		$dev_email	 = "pradeep@ardent-india.com";
		$dev_subject = "A2M Event Paypal Vals - Developer";
		$data		 = array(
						'firstname'			=> "Developer",
						'player'			=> $this->input->get('reg_user'),
						'event_id'			=> $this->input->get('ev_id'),
						'paypal_vals'		=> print_r($paypalInfo, true),
						'paypal_vals2'		=> print_r($_GET, true),
						'page'				=> 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);

			if($res)
			{
				$sql	= "SELECT * FROM users WHERE Users_ID = " .$user_id;
				$result = $this->db->query($sql);
				$row	= $result->row();

				$ev_det = $this->model_league->get_event_dets($ev_id);   //tournament details

				$title = $ev_det->Ev_Title;
	
				$this->load->library('email');
				$this->email->set_newline("\r\n");			 
				$this->email->from(FROM_EMAIL, 'A2MSports');
				$this->email->to($row->EmailID);
				$this->email->subject('Event Registration ('.$title.') - A2MSports');

				$data = array(
				'firstname'	=> $row->Firstname,
				'lastname'	=> $row->Lastname,
				'ev_id'		=> $ev_id,
				'title'		=> $title,
				'page'		=> 'Event Registration-Singles');

				$body = $this->load->view('view_email_template.php',$data,TRUE);

				$this->email->message($body);   
				$this->email->send();

					$data['reg_suc'] = "You have successfully registered for this Event. Thankyou";
					redirect("events/view/$ev_id/6");
			}
	  }

     public function success(){

		$this->session->unset_userdata('tour_reg_fee');
		$this->session->unset_userdata('reg_tour_id');

        //get the transaction data
        $paypalInfo = $this->input->get();
		
		$data = array();

			$data['item_number']	= $this->input->get('item_number');

			if($this->input->get('tx')){
			$data['txn_id']			= $this->input->get('tx');
			}
			else{
			$data['txn_id']			= $this->input->get('token');
			}

			$data['payment_amt']	= $this->input->get('amt');
			$data['currency_code']	= $this->input->get('cc');
			$data['status']				= $this->input->get('st');

			$data['coup_code']		= $this->input->get('coup_code');
			$data['coup_disc']		= $this->input->get('coup_disc');

		 if($this->input->get('ttype') == 'Teams'){
			$data['team']		= $team_id		= $this->input->get('team');
			$data['player']		= $user_id		= $this->input->get('reg_user');
			$data['team_players']= $team_players= $this->input->get('team_players');
			$data['tourn_id']	= $tourn_id		= $this->input->get('tourn_id');
			$data['age_group']	= $age_group	= $this->input->get('age_group');
			$data['level']		= $level		= $this->input->get('level');
			$data['hc_loc_id']	= $hc_loc		= $this->input->get('hc_loc');
			$data['tsize']		= $tsize		= $this->input->get('tsize');
			$data['note_to_admin'] = $note_to_admin	= $this->input->get('nte_to_admin');

			$res = $this->model_league->team_reg_tourn_with_fee($data);
		 }
		 else if($this->input->get('ttype') == 'Indv'){		
			$data['player']		= $user_id		= $this->input->get('player');
			$data['tourn_id']	= $tourn_id		= $this->input->get('tourn_id');
			$data['age_group']	= $age_group	= $this->input->get('age_group');
			$data['mtypes']		= $match_types	= $this->input->get('mtypes');
			$data['partners']	= $partners		= $this->input->get('partners');
			//$data['partner2']	= $partner2		= $this->input->get('partner2');
			$data['level']		= $level		= $this->input->get('level');
			$data['hc_loc_id']	= $hc_loc		= $this->input->get('hc_loc');
			$data['tsize']		= $tsize		= $this->input->get('tsize');
			$data['events']     = $reg_events   = $this->input->get('events');
			$data['note_to_admin'] = $note_to_admin	= $this->input->get('nte_to_admin');
			$data['school_info'] = $school_info	= $this->input->get('school_info');

			$data['occr'] = $occr	= "";
			if($this->input->get('occr')){
			$data['occr'] = $occr	= $this->input->get('occr');
			}
			else if($this->input->get('option_name3')){
			$data['occr'] = $occr	= $this->input->get('option_name3');
			}

			$res = $this->model_league->reg_tourn_with_fee($data);

				$occr_arr = json_decode($occr, TRUE);
				$game_days = '';
				foreach($occr_arr as $occr_id){
					$get_game_day = $this->model_league->get_game_day($occr_id);
					$game_days[] = date('m/d/Y H:i', strtotime($get_game_day));
				}

						/*$this->session->unset_userdata('json_ag');
						$this->session->unset_userdata('json_formats');
						$this->session->unset_userdata('json_levels');
						$this->session->unset_userdata('json_partners');
						$this->session->unset_userdata('hc_loc_id');
						$this->session->unset_userdata('events');
						$this->session->unset_userdata('tshirt_size');
						$this->session->unset_userdata('coup_code');
						$this->session->unset_userdata('coup_disc');*/
		 }


		$dev_email	 = "pradeep.namala@fintinc.com";
		$dev_subject = "A2M Paypal Vals - Developer - Club Success";
		$data		 = array(
						'firstname'			=> "Developer",
						'player_teamleague'	=> $this->input->get('reg_user'),
						'player_indv'		=> $this->input->get('player'),
						'tourn_id'			=> $this->input->get('tourn_id'),
						'team'				=> $this->input->get('team'),
						'game_days'		=> $game_days,
						'paypal_vals'		=> print_r($paypalInfo, true),
						'paypal_vals2'	=> print_r($_GET, true),
						'page'				=> 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);
		/* Code to send the paypal return values to developer for debugging */

		//$res = 1;

			if($res)
			{
				//$user_id = 237;
				//$tourn_id = 1153;

				$sql	= "SELECT * FROM users WHERE Users_ID = " .$user_id;
				$result = $this->db->query($sql);
				$row	= $result->row();
				$user_categories = $this->model_league->get_reg_tourn_participants_levels($tourn_id,$user_id);

				$regevents		 = json_decode($user_categories['Reg_Events']);
				$event_format	 = $this->regenerate_events($regevents);
		        $categories		 = array();
		        $selected_events = array();	        
				foreach($event_format as $k => $val){
					$arr = explode('-', $k);
					if($arr[1] == 'Mixed'){
					$fr = $arr[1];
					}
					else{
					$fr = $arr[2];
					}
					$categories[$fr][] = $val;
					$selected_events[] = $k;
				}

              // Get WaitList Number //

			//echo "<pre>";print_r($selected_events);exit();

		if($tour_det->tournament_format != 'Teams'){

			$tour_det = $this->model_league->getonerow($tourn_id);
			$reg_users = $this->get_reg_tourn_participants_new($tourn_id);

			foreach($selected_events as $evnt){
               $users = $this->in_array_r($evnt, $reg_users[0]);
               $users_cnt[$evnt] = count($users);
			}

			$tourn_events_limit = json_decode($tour_det->Event_Reg_Limit,true);

			foreach ($tourn_events_limit as $event => $limit) {
				//$limits[]=array_key_exists($event, $users_cnt);
				if(array_key_exists($event, $users_cnt)) {
					if($limit !== "" || $limit != NULL) {
					 	if($users_cnt[$event] > $limit) {
					 		$waitlistres = $this->model_league->GetWaitlistCount($tourn_id,$event);
					 		$waitlist	 = $waitlistres+1;
	                        $insert_res  = $this->model_league->InsertWaitlistUsers($res,$tourn_id,$event,$waitlist);
					 	}
					}
                }
			}
		}
			//	print_r($categories);
//exit;
				$tourn_det  = $this->model_league->getonerow($tourn_id);   //tournament details
				$title			  = $tourn_det->tournament_title;               
				$subject		  = "Tournament Registration {$title} - A2MSports";

				$user_reg_date = $user_categories['Reg_date'];
                //$reg_date = date('m-d-Y', strtotime($user_reg_date));
                $reg_date	   = date('m-d-Y h:i:s');

				$data = array(
							'firstname'	=> $row->Firstname,
							'lastname'	=> $row->Lastname,
							'tourn_id'	=> $tourn_id,
							'title'			=> $title,
							'game_days'	 => $game_days,
							'date'			 => $reg_date,
							'categories'   => $categories,
							'page'			 => 'Registration-Singles'
							);

				$this->email_to_player($row->EmailID, $subject, $data);
				$this->email_to_player("pradeepkumar.namala@gmail.com", $subject, $data);
				
                $userdat			   = $this->get_username($tourn_det->Usersid);

                $tourn_admin_email			= $userdat['EmailID'];
                $tourn_admin_firstname	= $userdat['Firstname'];
                $tourn_admin_lastname	= $userdat['Lastname'];

                $reg_date = date('m-d-Y h:i:s');
				$data	= array(
								'firstname'	=> $row->Firstname,
								'lastname'	=> $row->Lastname,
								'admin_firstname'	=> $tourn_admin_firstname,
								'admin_lastname'	=> $tourn_admin_lastname,
								'date'		=> $reg_date,
								'tourn_id'	=> $tourn_id,
								'title'			=> $title,
								'game_days'		 => $game_days,
								'categories'		 => $categories,
								'note_to_admin' => $note_to_admin,
								'page'		=> 'Send mail to tournament admin once user registration'
							);

                $this->email_to_player($tourn_admin_email, $subject, $data);
                $this->email_to_player("pradeepkumar.namala@gmail.com", $subject, $data);
				
				/*if(preg_match('[Doubles|Mixed]', $match_types)) { 
					
					$partner1_email="";
					$partner2_email="";
					$sess_user		= $this->session->userdata('user');
					
					if($partner1){
						$get_partner1_details = $this->get_username($partner1);
						$partner1_email = $get_partner1_details['EmailID'];      //doubles partner
						$partner1_name  = $get_partner1_details['Firstname'] . " " . $get_partner1_details['Lastname'];  

						$data = array(
						'tourn_id' => $tourn_id,
						'partner1' => $partner1_name,
						'user'	   => $sess_user,
						'title'	   => $title,
						'page'	   => 'Tourn-Reg-Doubles'	
						);

						$this->email_to_player($partner1_email, $subject, $data);
					}

					if($partner2){
						$get_partner2_details = $this->get_username($partner2);
						$partner2_email = $get_partner2_details['EmailID'];      //Mixed partner
						$partner2_name  = $get_partner2_details['Firstname'] . " " . $get_partner2_details['Lastname'];

						$data = array(
						'tourn_id' => $tourn_id,
						'partner1' => $partner2_name,
						'user'	   => $sess_user,
						'title'	   => $title,
						'page'	   => 'Tourn-Reg-Mixed'
						);
						
						$this->email_to_player($partner2_email, $subject, $data);
					}
				}*/
					$data['reg_suc'] = "You have successfully registered for this tournament.";


					if($this->config->item('club_form_url') == ''){
						$ret_site = $_SERVER['HTTP_X_REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_X_FORWARDED_HOST'].'/';
					}
					else{
						$ret_site = $this->config->item('club_form_url').'/';
					}
//echo $ret_site; exit;
						redirect($ret_site."league/{$tourn_id}/1");

			}
			else{
				echo 'Something went wrong, Please write to admin@a2msports.com.<br>';
			}
     }


		 function cancel($org_id = ''){
			$this->session->unset_userdata('tour_reg_fee');
			$this->session->unset_userdata('reg_tour_id');

			$this->load->view('view_cancel');
		 }
 
        function pay_success(){						//	Team League Pay success from individual player

		$this->session->unset_userdata('tour_per_player_fee');
		$this->session->unset_userdata('tourn_id_fee_pay');
		$this->session->unset_userdata('tour_reg_team_id');

        //get the transaction data
        $paypalInfo = $this->input->get();

		/*print_r($paypalInfo);
		print_r($this->session->userdata);
		exit;*/

		/* Code to send the paypal return values to developer for debugging */
		/*foreach($_GET as $key => $value)
		{
		$paypal_return_vals .= $key . " - " . $value . "<br />";
		}*/


		/* Code to send the paypal return values to developer for debugging */

		$data = array();

		$data['item_number']	= $this->input->get('item_number');

		if($this->input->get('tx')){
		$data['txn_id']			= $this->input->get('tx');
		}
		else{
		$data['txn_id']			= $this->input->get('token');
		}

		$data['payment_amt']	= $this->input->get('amt');
		$data['currency_code']	= $this->input->get('cc');
		$data['status']			= $this->input->get('st');

		$data['player']		= $user_id		= $this->input->get('player');
		$data['league']		= $tourn_id		= $this->input->get('league');
		$data['team']		= $team			= $this->input->get('team');

			$res = $this->model_league->team_player_fee_paymet($data);

		$dev_email	 = "pradeep@ardent-india.com";
		$dev_subject = "A2M Paypal Vals - Developer";
		$data		 = array(
						'firstname'			=> "Developer",
						'player_teamleague'	=> $this->input->get('player'),
						'player_indv'		=> '',
						'tourn_id'			=> $this->input->get('league'),
						'team'				=> $this->input->get('team'),
						'paypal_vals'		=> print_r($paypalInfo, true),
						'paypal_vals2'		=> print_r($_GET, true),
						'page'				=> 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);

			if($res)
			{
				$sql	= "SELECT * FROM users WHERE Users_ID = " .$user_id;
				$result = $this->db->query($sql);
				$row	= $result->row();

				$tourn_det = $this->model_league->getonerow($tourn_id);   //tournament details

				$title = $tourn_det->tournament_title;
	
				$this->load->library('email');
				$this->email->set_newline("\r\n");			 
				$this->email->from(FROM_EMAIL, 'A2MSports');
				$this->email->to($row->EmailID);
				$this->email->subject('Tournament Registration ('.$title.') - A2MSports');

				$data = array(
				'firstname'	=> $row->Firstname,
				'lastname'	=> $row->Lastname,
				'tourn_id'	=> $tourn_id,
				'title'		=> $title,
				'page'		=> 'Registration-Singles');

						
				$body = $this->load->view('view_email_template.php',$data,TRUE);

				$this->email->message($body);   
				$this->email->send();
					
					$data['reg_suc'] = "You have successfully registered for this tournament. Thankyou";
					redirect("league/view/$tourn_id/1");
			}

        //pass the transaction data to view
      //  $this->load->view('view_success', $data);
     }
     
     function pay_cancel(){
		$this->session->unset_userdata('tour_per_player_fee');
		$this->session->unset_userdata('tourn_id_fee_pay');
		$this->session->unset_userdata('tour_reg_team_id');

        $this->load->view('view_cancel');
     }

     function ipn(){
        //paypal return transaction details array

		//$x = 0;
		//if(!class_exists("model_league")){
		//	$this->load->model('model_league');
		//	$x = 1;
		//}

        $paypalInfo    = $this->input->post();

        $data['users_id']		= trim($paypalInfo['option_name1']);

        $data['reg_events']	= trim($paypalInfo['option_name2']);

		if($paypalInfo['option_name3'])
        $data['reg_occrs']		= trim($paypalInfo['option_name3']);


        $data['tourn_id']			= trim($paypalInfo["item_number"]);
        $data['txn_id']			= $paypalInfo["txn_id"];
        $data['payment_gross']	= $paypalInfo["payment_gross"];
        //$data['currency_code']	= $paypalInfo["mc_currency"];
        $data['payer_email']		= $paypalInfo["payer_email"];
        $data['payment_status'] = $paypalInfo["payment_status"];
        $data['payment_date']	= $paypalInfo["payment_date"];
        $data['currency']			= $paypalInfo["mc_currency"];
        $data['pp_charges']		= $paypalInfo["mc_fee"];

		//$paypalInfo["abc"] = $x;

			$tour_det = $this->model_league->getonerow($data['tourn_id']);

		$paypalInfo["tformat"] = $tour_det->tournament_format;

        $paypalURL = $this->paypal_lib->paypal_url;        
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
		if(trim($tour_det->tournament_format) == 'Individual'){
			$upd = $this->model_league->upd_paypal_ipn($data);
			$paypalInfo["upd"] = $upd;
		}

	 	$dev_email	 = "pradeepkumar.namala@gmail.com";
		$dev_subject = "A2M Paypal Vals - Production(club ipn)";
		$data		 = array(
						'firstname'	   => "Developer",
						'paypal_vals'  => print_r($paypalInfo, true),
						'page'	       => 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);

        //check whether the payment is verified
        if(eregi("VERIFIED",$result)){
            //insert the transaction data into the database
           // $this->product->insertTransaction($data);
        }
    }

     function ipn_more(){
        $paypalInfo    = $this->input->post();

        $data['users_id']		= trim($paypalInfo['option_name1']);
        $data['reg_events']		= trim($paypalInfo['option_name2']);
        $data['tourn_id']		= trim($paypalInfo["item_number"]);
        $data['txn_id']			= $paypalInfo["txn_id"];
        $data['payment_gross']	= $paypalInfo["payment_gross"];
        //$data['currency_code']	= $paypalInfo["mc_currency"];
        $data['payer_email']	= $paypalInfo["payer_email"];
        $data['payment_status'] = $paypalInfo["payment_status"];
        $data['payment_date']	= $paypalInfo["payment_date"];
        $data['currency']		= $paypalInfo["mc_currency"];
        $data['pp_charges']		= $paypalInfo["mc_fee"];

		//$paypalInfo["abc"] = $x;

		$tour_det = $this->model_league->getonerow($data['tourn_id']);
		$paypalInfo["tformat"] = $tour_det->tournament_format;

        $paypalURL = $this->paypal_lib->paypal_url;        
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
		if(trim($tour_det->tournament_format) == 'Individual') {
			$upd = $this->model_league->upd_paypal_ipn_more($data);
			$paypalInfo["upd"] = $upd;
		}

	 	$dev_email	 = "pradeepkumar.namala@gmail.com";
		$dev_subject = "A2M Paypal Vals - Production More (club ipn more)";
		$data		 = array(
						'firstname'	   => "Developer",
						'paypal_vals'  => print_r($paypalInfo, true),
						'page'	       => 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);

        //check whether the payment is verified
        if(eregi("VERIFIED",$result)){
            //insert the transaction data into the database
           // $this->product->insertTransaction($data);
        }
    }

     public function subscr_success($short_code){
			$paypalInfo = $this->input->get();
//echo "<pre>"; print_r($paypalInfo); exit;

			if($paypalInfo['tx']){
			$data['Transaction_ID'] = $paypalInfo['tx'];
			}
			else if($paypalInfo['token']){
			$data['Transaction_ID'] = $paypalInfo['token'];
			}
			else{
				echo "Transaction id is missing! Something went wrong, please contact admin!";
				exit;
			}

			$data['Amount']				= $paypalInfo['amt'];
			$data['Currency']				= $paypalInfo['cc'];
			$data['Pay_Status']			= $paypalInfo['st'];
			$data['Payment_Method']		= 'Paypal';
			$data['Paid_On']						= date('Y-m-d H:i:s');

			$data2['User_ID']						 = $paypalInfo['reg_user'];
			$data2['Membership_Code']	 = $paypalInfo['item_number'];
			$data2['Type']							 = 'SUBSCR';

			$upd = $this->model_paypal->upd_mem_payment_subscr($data, $data2);

			$get_user = $this->general->get_onerow('Users', 'Users_ID', $paypalInfo['reg_user']);
			$get_club = $this->general->get_onerow('Academy_Info', 'Aca_URL_ShortCode', $this->short_code);
			$get_mem_type = $this->general->get_onerow('Membership_Types', 'Membership_ID', $paypalInfo['item_number']);

			$get_clubadm_user = $this->general->get_onerow('Users', 'Users_ID', $get_club['Aca_User_id']);

			$upd_membership = 
				$this->general->upd_user_membership($this->academy_id, $data2['User_ID'], $get_mem_type['tab_id']);

			$user_activation =  $this->general->user_activation($data2['User_ID']);


			if($paypalInfo['st'] == 'Completed'){
			//$get_club = $this->general->get_onerow('Academy_Info', 'Aca_URL_ShortCode', $short_code);
			/*$upd_membership = 
				$this->general->upd_user_membership($get_club['Aca_ID'], $data2['User_ID']);

			$user_activation =  $this->general->user_activation($data2['User_ID']);*/
			}

			if($upd) {
				//echo "Transaction Completed!";

				$get_membership_type = $this->general->get_onerow('Membership_Types', 'Membership_ID', $data2['Membership_Code']);
				// Club Member Email
				if($get_user['EmailID'])
					$cm_email	 = $get_user['EmailID'];
				else
					$cm_email	 = $get_user['AlternateEmailID'];

				$club_adm_email = $get_clubadm_user['EmailID'];

					$cm_subject = "User Membership Subscription Payment - ".$get_club['Aca_name'];
					$data3 = array(
										'name'			  => $get_user['Firstname']." ".$get_user['Lastname'],
										'tx_id'				  => $data['Transaction_ID'],
										'amount'		  => $data['Amount'],
										'subscription'		=> $get_membership_type['Membership_Type'],
										'sub_code'		  => $data2['Membership_Code'],
										'club_name'	  => $get_club['Aca_name'],
										'club_adm_mail'	  => $club_adm_email,
										'aca_name'	  => $get_club['Aca_name'],
										'aca_logo'		  => $get_club['Aca_logo'],
										'page'				  => 'Club Member Notif - Membership SubScr');
										//echo "test ".$cm_email; exit;

				$this->email_to_playerUser($cm_email, $cm_subject, $data3);

				// Club Admin Email
				$get_user2 = $this->general->get_onerow('Users', 'Users_ID', $get_club['Aca_User_id']);

				if($get_user2['EmailID'])
					$ca_email	 = $get_user2['EmailID'];
				else
					$ca_email	 = $get_user2['AlternateEmailID'];

					$ca_subject = "User Membership Subscription Payment - ".
						$get_user['Firstname']." ".$get_user['Lastname'];

					$data3 = array(
										'name'			  => $get_user2['Firstname']." ".$get_user2['Lastname'],
										'tx_id'				  => $data['Transaction_ID'],
										'amount'		  => $data['Amount'],
										'subscription'  => $get_membership_type['Membership_Type'],
										'sub_code'		  => $data2['Membership_Code'],
										'club_name'	  => $get_club['Aca_name'],
										'member'		  => $get_user['Firstname']." ".$get_user['Lastname'],
										'member_email'		 => $get_user['EmailID'],
										'member_contact'	 => $get_user['Mobilephone'],
										'page'				  => 'Club Admin Notif - Membership SubScr');
					//echo "<pre>"; print_r($data3);exit;
					$this->email_to_player($ca_email, $ca_subject, $data3);

					if($this->config->club_form_url == '')
						$uri = base_url().$this->uri->segment(1).'/';
					else
						$uri = $this->config->club_form_url;

					redirect($uri.'membership/success');
			}
			else{
				echo "Transaction completed. Couldn't update the details. please contact admin!"; 
				exit;
			}

		 //echo "<pre>"; print_r($paypalInfo); exit;
	 }


     public function subscr_cancel(){
		 $this->load->view('view_cancel');
	 }

     public function subscr_ipn(){
		 $paypalInfo    = $this->input->post();

		if($paypalInfo){
			$cu = explode('-', $paypalInfo['custom']);

			if($paypalInfo['mc_gross']){
				$amount = $paypalInfo['mc_gross'];
				$gateway_chrges = $paypalInfo['mc_fee'];
			}
			else if($paypalInfo['mc_amount3']){
				$amount = $paypalInfo['mc_amount3'];
				$gateway_chrges = $paypalInfo['mc_fee'];
			}

			if($paypalInfo['subscr_date']){
				$trans_date = date('Y-m-d H:i:s', strtotime($paypalInfo['subscr_date']));
			}
			else if($paypalInfo['payment_date']){
				$trans_date = date('Y-m-d H:i:s', strtotime($paypalInfo['payment_date']));
			}


			$period = NULL;
			if($paypalInfo['period3']){
				$period = $paypalInfo['period3'];
			}

			
			$data =  array(
							'PP_Payer_ID' => $paypalInfo['payer_id'],
							'Payment_Date' => $trans_date,
							'Payment_Status' => $paypalInfo['payment_status'],
							'SUBSCR_ID' => $paypalInfo['subscr_id'],
							'Txn_ID' => $paypalInfo['txn_id'],
							'Payment_Type' => $paypalInfo['payment_type'],
							'Gateway_Charges' => $gateway_chrges,
							'Txn_Type' => $paypalInfo['txn_type'],
							'Membership_Type' => $paypalInfo['item_name'],
							'Membership_Code' => $paypalInfo['item_number'],
							'Users_ID' => $cu[0],
							'Aca_ID' => $cu[1],
							'Amount' => $amount,
							'Period' => $period
						);

			$ins = $this->general->insert_table_data('Membership_Recurring_Payments', $data);
			//$paypalInfo['ins_qry'] = $this->db->last_query();
		}
		if($ins)	$paypalInfo['is_ins'] = 'Insert Done';
		else			$paypalInfo['is_ins'] = 'Insert Failed';

		$dev_email	 = "pradeepkumar.namala@gmail.com";
		$dev_subject = "A2M PP New Subscr - Sandbox";
		$data = array(
						'firstname'	   => "Developer",
						'paypal_vals'  => print_r($paypalInfo, true),
						'page'	       => 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);

	 }

     public function ot_success($short_code){
			$paypalInfo = $this->input->get();
			//echo "<pre>"; print_r($paypalInfo); exit;
			if($paypalInfo['tx']){
				$data['Transaction_ID'] = $paypalInfo['tx'];
			}
			else if($paypalInfo['token']){
				$data['Transaction_ID'] = $paypalInfo['token'];
			}
			else{
				echo "Transaction id is missing! Something went wrong, please contact admin!";
				exit;
			}

			$data['Amount']				= $paypalInfo['amt'];
			$data['Currency']				= $paypalInfo['cc'];
			$data['Pay_Status']			= $paypalInfo['st'];
			$data['Payment_Method']		= 'Paypal';
			$data['Paid_On']						= date('Y-m-d H:i:s');

			$data2['User_ID']						 = $paypalInfo['reg_user'];
			$data2['Membership_Code']	 = $paypalInfo['item_number'];
			$data2['Type']							 = 'OT';

			$upd = $this->model_paypal->upd_mem_payment_ot($data, $data2);

			if($paypalInfo['st'] == 'Completed'){
			$user_activation =  $this->general->user_activation($data2['User_ID']);
			}
			if($upd) {
				//echo "Transaction Completed!";
				$get_user = $this->general->get_onerow('Users', 'Users_ID', $paypalInfo['reg_user']);
				$get_club = $this->general->get_onerow('Academy_Info', 'Aca_URL_ShortCode', $short_code);

				// Club Member Email
				if($get_user['EmailID'])
					$cm_email	 = $get_user['EmailID'];
				else
					$cm_email	 = $get_user['AlternateEmailID'];

					$cm_subject = "User Membership OneTime Payment - ".$get_club['Aca_name'];
					$data3 = array(
										'name'			  => $get_user['Firstname']." ".$get_user['Lastname'],
										'tx_id'				  => $data['Transaction_ID'],
										'amount'		  => $data['Amount'],
										'subscription'  => $paypalInfo['item_name'],
										'sub_code'		  => $data2['Membership_Code'],
										'club_name'	  => $get_club['Aca_name'],
										'page'				  => 'Club Member Notif - Membership OT');
										//echo "test ".$cm_email; exit;

				$this->email_to_player($cm_email, $cm_subject, $data3);

				// Club Admin Email
				$get_user2 = $this->general->get_onerow('Users', 'Users_ID', $get_club['Aca_User_id']);

				if($get_user2['EmailID'])
					$ca_email	 = $get_user2['EmailID'];
				else
					$ca_email	 = $get_user2['AlternateEmailID'];

					$ca_subject = "User Membership OneTime Payment - ".
						$get_user['Firstname']." ".$get_user['Lastname'];

					$data3 = array(
										'name'			  => $get_user2['Firstname']." ".$get_user2['Lastname'],
										'tx_id'				  => $data['Transaction_ID'],
										'amount'		  => $data['Amount'],
										'subscription'  => $paypalInfo['item_name'],
										'sub_code'		  => $data2['Membership_Code'],
										'club_name'	  => $get_club['Aca_name'],
										'member'		  => $get_user['Firstname']." ".$get_user['Lastname'],
										'page'				  => 'Club Admin Notif - Membership OT');
					//echo "<pre>"; print_r($data3);exit;
					$this->email_to_player($ca_email, $ca_subject, $data3);

					if($this->config->club_form_url == '')
						$uri = base_url().$this->uri->segment(1).'/';
					else
						$uri = $this->config->club_form_url;

					redirect($uri.'membership/success');
			}
			else{
				echo "Transaction completed. Couldn't update the details. please contact admin!"; 
				exit;
			}

		 //echo "<pre>"; print_r($paypalInfo); exit;
	 }

     public function ot_user($short_code){
			$paypalInfo = $this->input->get();
			//echo "<pre>"; echo $short_code; print_r($paypalInfo); exit;
			if($paypalInfo['tx']){
			$data['Transaction_ID'] = $paypalInfo['tx'];
			}
			else if($paypalInfo['token']){
			$data['Transaction_ID'] = $paypalInfo['token'];
			}
			else{
				echo "Transaction id is missing! Something went wrong, please contact admin!";
				exit;
			}

			$data['Amount']				= $paypalInfo['amt'];
			$data['Currency']				= $paypalInfo['cc'];
			$data['Pay_Status']			= $paypalInfo['st'];
			$data['Payment_Method']		= 'Paypal';
			$data['Paid_On']						= date('Y-m-d H:i:s');

			$data2['User_ID']						 = $paypalInfo['reg_user'];
			$data2['Membership_Code']	 = $paypalInfo['item_number'];
			$data2['Type']							 = 'OT';

			$upd = $this->model_paypal->upd_mem_payment_ot($data, $data2);

			if($paypalInfo['st'] == 'Completed'){
			$user_activation =  $this->general->user_activation($data2['User_ID']);
			}
			if($upd) {
				//echo "Transaction Completed!";
				$get_user = $this->general->get_onerow('Users', 'Users_ID', $paypalInfo['reg_user']);
				$get_club = $this->general->get_onerow('Academy_Info', 'Aca_URL_ShortCode', $short_code);

				// Club Member Email
				if($get_user['EmailID'])
					$cm_email	 = $get_user['EmailID'];
				else
					$cm_email	 = $get_user['AlternateEmailID'];

					$cm_subject = "User Membership OneTime Payment - ".$get_club['Aca_name'];
					$data3 = array(
										'name'			  => $get_user['Firstname']." ".$get_user['Lastname'],
										'tx_id'				  => $data['Transaction_ID'],
										'amount'		  => $data['Amount'],
										'subscription'  => $paypalInfo['item_name'],
										'sub_code'		  => $data2['Membership_Code'],
										'club_name'	  => $get_club['Aca_name'],
										'page'				  => 'Club Member Notif - Membership OT');
										//echo "test ".$cm_email; exit;

				$this->email_to_player($cm_email, $cm_subject, $data3);

				// Club Admin Email
				$get_user2 = $this->general->get_onerow('Users', 'Users_ID', $get_club['Aca_User_id']);

				if($get_user2['EmailID'])
					$ca_email	 = $get_user2['EmailID'];
				else
					$ca_email	 = $get_user2['AlternateEmailID'];

					$ca_subject = "User Membership OneTime Payment - ".
						$get_user['Firstname']." ".$get_user['Lastname'];

					$data3 = array(
										'name'			  => $get_user2['Firstname']." ".$get_user2['Lastname'],
										'tx_id'				  => $data['Transaction_ID'],
										'amount'		  => $data['Amount'],
										'subscription'  => $paypalInfo['item_name'],
										'sub_code'		  => $data2['Membership_Code'],
										'club_name'	  => $get_club['Aca_name'],
										'member'		  => $get_user['Firstname']." ".$get_user['Lastname'],
										'page'				  => 'Club Admin Notif - Membership OT');
					//echo "<pre>"; print_r($data3);exit;
					$this->email_to_player($ca_email, $ca_subject, $data3);

					if($this->config->club_form_url == '')
						$uri = base_url().$this->uri->segment(1).'/';
					else
						$uri = $this->config->club_form_url;



$this->session->set_flashdata('user_temp_id', $paypalInfo['reg_user']);

					redirect($uri."membership/ot_success/".$paypalInfo['reg_user']);
			}
			else{
				echo "Transaction completed. Couldn't update the details. please contact admin!"; 
				exit;
			}

		 //echo "<pre>"; print_r($paypalInfo); exit;
	 }

     public function ot_cancel(){
		 $this->load->view('view_cancel');
	 }

     public function ot_ipn(){
		 $paypalInfo    = $this->input->post();

		$dev_email	 = "pradeepkumar.namala@gmail.com";
		$dev_subject = "A2M PP New Subscr OT - Sandbox";
		$data		 = array(
						'firstname'	   => "Developer",
						'paypal_vals'  => print_r($paypalInfo, true),
						'page'	       => 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);
	 }


	public function email_to_player($to_email, $subject, $data){	
		$this->load->library('email');
		$this->email->set_newline("\r\n"); 
		$this->email->from(FROM_EMAIL, 'A2MSports');
		$this->email->to($to_email);
		$this->email->subject($subject);

		$body = $this->load->view('view_email_template.php', $data, TRUE);

		$this->email->message($body);  
		$x = $this->email->send();
	}

	public function email_to_playerUser($to_email, $subject, $data){	
		$this->load->library('email');
		$this->email->set_newline("\r\n"); 
		$this->email->from(FROM_EMAIL, $data['aca_name']);
		$this->email->to($to_email);
		$this->email->reply_to($data['club_adm_mail']);
		$this->email->subject($subject);

		$body = $this->load->view('academy_views/view_email_template.php', $data, TRUE);

		$this->email->message($body);  
		$x = $this->email->send();
	}

	public function get_reg_tourn_participants($tourn_id){
			$res = $this->model_league->get_reg_tourn_participants($tourn_id);
			//print_r($res);exit();
				$reg_users = array();
		   foreach($res as $r){
				$formats     = json_decode($r->Match_Type);
				$ag_group  = json_decode($r->Reg_Age_Group);
				$sp_levels   = json_decode($r->Reg_Sport_Level);

				foreach($formats as $i => $fr){
					foreach($ag_group[$i] as $j => $ag){
						foreach($sp_levels[$i][$j] as $lv){
						   
      						$reg_users[$r->Users_ID][] = $fr."-".$ag."-".$lv;
						}
					}
				}
			}
			return $reg_users;
    }

    public function in_array_r($find, $source){
			$u = array();
			foreach($source as $i => $item){
				foreach($item as $j => $str){
					if($find == $str)
					{
						$u[] = $i;
					}				
				}
			}
		return $u;
	}

		/*public function regenerate_events($mult_events){
			$revised_array = array();

			foreach($mult_events as $key => $val){
				if(is_numeric($key)){
				   $arr = explode('-', $val);
				   $ag		= $arr[0];
				   $gen		= $arr[1];
				   $format	= $arr[2];
				   $level	= $arr[3];
					
				   $gen = $this->config->item($arr[0].'-'.$arr[1], 'age_gender_values');
				   $get_level_label = paypal::get_level_name('', $level);

				   $revised_array[$val] = $gen.' '.$arr[2].' '.$get_level_label['SportsLevel'];
				   ksort($revised_array);
				}
				else{
				   $arr = explode('-', $key);
				   $ag		= $arr[0];
				   $gen		= $arr[1];
				   $format	= $arr[2];
				   $level	= $arr[3];
					
				   $gen = $this->config->item($arr[0].'-'.$arr[1], 'age_gender_values');
				   $get_level_label = paypal::get_level_name('', $level);

				   $revised_array[$gen.' '.$arr[2].' '.$get_level_label['SportsLevel']] = $val;
				   ksort($revised_array);
				}
			}
			
			
			return $revised_array;
		}*/

/*		public function regenerate_events($mult_events){
			$revised_array = array();

			foreach($mult_events as $key => $val){
				if(is_numeric($key)){
				   $arr = explode('-', $val);
				   $ag		= $arr[0];
				   if($arr[1] != 'Mixed'){
					   if(in_array($arr[1], array('Singles','Doubles'))){
						   $gen		= '';
						   $format	= $arr[1];
						   $level	= $arr[2];
					   }
					   else{
						   $gen		= $arr[1];
						   $format	= $arr[2];
						   $level	= $arr[3];
					   }
				   }
				   else{
					   $gen		= $arr[1];
					   $format	= '';
					   $level	= $arr[2];
				   }
					
				   $gen = $this->config->item($arr[0].'-'.$gen, 'age_gender_values');

				   if( $arr[1] != 'Open')
				   $get_level_label = $this->get_level_name('', $level);

				   $revised_array[$val] = $gen.' '.$format.' '.$get_level_label['SportsLevel'];
				  // ksort($revised_array);
				}
				else{
				   $arr = explode('-', $key);
				   $ag		= $arr[0];
				   if($arr[1] != 'Mixed'){
					   if(in_array($arr[1], array('Singles','Doubles'))){
						   $gen		= '';
						   $format	= $arr[1];
						   $level	= $arr[2];
					   }
					   else{
						   $gen		= $arr[1];
						   $format	= $arr[2];
						   $level	= $arr[3];
					   }
				   }
				   else{
					   $gen		= $arr[1];
					   $format	= '';
					   $level	= $arr[2];
				   }
				   
				   $gen = $this->config->item($arr[0].'-'.$gen, 'age_gender_values');

				   if( $arr[1] != 'Open')
				   $get_level_label = $this->get_level_name('', $level);
					
					if(is_numeric($val)){
					$revised_array[$gen.' '.$format.' '.$get_level_label['SportsLevel']] = number_format($val, 2);
					}
					else{
					$revised_array[$gen.' '.$format.' '.$get_level_label['SportsLevel']] = $val."+".$arr[1];
					}
				   //ksort($revised_array);
				}
			}
			
			return $revised_array;
		}
*/

			public function regenerate_events($mult_events){
			$revised_array = array();
/*echo "<pre>";
print_r($mult_events);*/

			foreach($mult_events as $key => $val){
				if(is_numeric($key)){
				   $arr = explode('-', $val);
				   $ag		= $arr[0];
				   if($arr[1] != 'Mixed'){
					   if(in_array($arr[1], array('Singles','Doubles'))){
						   $gen		= '';
						   $format	= $arr[1];
						   $level	= $arr[2];
					   }
					   else{
						   $gen		= $arr[1];
						   $format	= $arr[2];
						   $level	= $arr[3];
					   }
				   }
				   else{
					   $gen		= $arr[1];
					   $format	= '';
					   $level	= $arr[2];
				   }
					
				   $gen = $this->config->item($arr[0].'-'.$gen, 'age_gender_values');

				   if($arr[1] != 'Open')
				   $get_level_label = $this->get_level_name('', $level);

					$lbl = '';
					//if($get_level_label['SportsLevel'] != 'Open') // uncomment this if wants to hide the Open label in level section

						$lbl = ' '.$get_level_label['SportsLevel'];
				   $revised_array[$val] = $gen.' '.$format.$lbl;
				  // ksort($revised_array);
				}
				else{
				   $arr = explode('-', $key);
				   $ag		= $arr[0];
				   if($arr[1] != 'Mixed'){
					   if(in_array($arr[1], array('Singles','Doubles'))){
						   $gen		= '';
						   $format	= $arr[1];
						   $level	= $arr[2];
					   }
					   else{
						   $gen		= $arr[1];
						   $format	= $arr[2];
						   $level	= $arr[3];
					   }
				   }
				   else{
					   $gen		= $arr[1];
					   $format	= '';
					   $level	= $arr[2];
				   }
				   
				   $gen = $this->config->item($arr[0].'-'.$gen, 'age_gender_values');

				   if( $arr[1] != 'Open')
				   $get_level_label = $this->get_level_name('', $level);

						$lbl = '';

					//if($get_level_label['SportsLevel'] != 'Open')
						$lbl = ' '.$get_level_label['SportsLevel'];


					if(is_numeric($val)){
					$revised_array[$gen.' '.$format.$lbl] = number_format($val, 2);
					}
					else{
					$revised_array[$gen.' '.$format.$lbl] = $val."+".$arr[1];
					}
				   //ksort($revised_array);
				}
			}
			
			//print_r($revised_array);
			return $revised_array;
		}

	    public function get_reg_tourn_participants_new($tourn_id){
			$res = $this->model_league->get_reg_tourn_participants($tourn_id);
			//print_r($res);exit();
				$reg_users  = array();
				$user_tsize = array();
			foreach($res as $r){	
			    if($r->Reg_Events != NULL){
	               $reg_events = json_decode($r->Reg_Events);
	                foreach ($reg_events as $key => $value){
	               	    $reg_users[$r->Users_ID][] = $value;
	                }
			    }
				else{
				    $formats   = json_decode($r->Match_Type);
					$ag_group  = json_decode($r->Reg_Age_Group);
					$sp_levels = json_decode($r->Reg_Sport_Level);

					foreach($formats as $i => $fr){
						foreach($ag_group[$i] as $j => $ag){
							foreach($sp_levels[$i][$j] as $lv){

								$player=$this->general->get_user($r->Users_ID);

								if($fr == 'Singles' || $fr == 'Doubles'){
	                               $gender = $player['Gender'];
								}else
								{
								   $gender = 2;
								}
	      						$reg_users[$r->Users_ID][] = $ag."-".$gender."-".$fr."-".$lv;
							}
						}
					}

			    }

				$user_tsize[$r->Users_ID] = $r->TShirt_Size;
			}

			$res = array($reg_users, $user_tsize);
			return $res;
		}

		public function get_level_name($sport_id, $level)
		 {
			return $this->model_league->get_level_name($sport_id, (int)$level);
		 }

		 public function testEmail(){

					//$cm_email	 = 'rajkamal.kosaraju@gmail.com';
					$cm_email	 = 'pradeepkumar.namala@gmail.com';

					$cm_subject = "User Membership Subscription Payment - TestClub9";
					$data3 = array(
										'name'			  => 'Rajkamal Kosaraju',
										'tx_id'				  => 'FSD3432SDFSD',
										'amount'		  => '10',
										'subscription'		=> 'Annual',
										'sub_code'		  => 'DFDSF',
										'club_name'	  => 'TestClub9',
										'club_adm_mail'	  => 'npradkumar@gmail.com',
										'aca_name'	  => 'TestClub9',
										'aca_logo'		  => 'tana.jpeg',
										'page'				  => 'Club Member Notif - Membership SubScr');
										//echo "test ".$cm_email; exit;

				$this->email_to_playerUser($cm_email, $cm_subject, $data3);
echo "Mail Sent!";
		 }
}