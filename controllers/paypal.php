<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller {

     function  __construct(){
        parent::__construct();
        $this->load->library('paypal_lib');
		$this->load->library('session');

        $this->load->model('model_league');
        $this->load->model('model_event');
		$this->load->model('model_general');
		$this->load->model('model_news');
     }
     
	 function get_username($user_id){
		return $this->model_general->get_user($user_id);
	 }

	 function msuccess(){
        $this->session->unset_userdata('tour_reg_fee');
		$this->session->unset_userdata('reg_tour_id');

        //get the transaction data
        $paypalInfo = $this->input->get();
		//echo "<pre>"; print_r($paypalInfo); exit;
        $data['item_number']	= $paypalInfo['item_number']; 
        $data['txn_id']			= $paypalInfo["tx"];
        $data['payment_amt']		= $paypalInfo["amt"];
        $data['currency_code']	= $paypalInfo["cc"];
        $data['status']				= $paypalInfo["st"];

        if($this->input->get('ttype') == 'Indv') {		
			$data['player']		= $user_id			= $this->input->get('player');
			$data['tourn_id']	= $tourn_id			= $this->input->get('tourn_id');
			$data['age_group']	= $age_group	= $this->input->get('age_group');
			$data['mtypes']		= $match_types	= $this->input->get('mtypes');
			//$data['partner1']	= $partner1		= $this->input->get('partner1');
			//$data['partner2']	= $partner2		= $this->input->get('partner2');
			$data['level']			= $level				= $this->input->get('level');
			$data['events']		= $reg_events   = $this->input->get('events');

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

     public function test_success(){
		 $paypalInfo = $this->input->get();
		 echo "<pre>"; print_r($paypalInfo); exit;
	 }

     public function test_cancel(){
		 $this->load->view('view_cancel');
	 }

     public function test_ipn(){
		         $paypalInfo    = $this->input->post();

			 	$dev_email	 = "pradeepkumar.namala@gmail.com";
		$dev_subject = "A2M PP Subscr - Sandbox";
		$data		 = array(
						'firstname'	   => "Developer",
						'paypal_vals'  => print_r($paypalInfo, true),
						'page'	       => 'A2M Paypal values - Developer');

		$this->email_to_player($dev_email, $dev_subject, $data);
	 }

     public function success(){

		$this->session->unset_userdata('tour_reg_fee');
		$this->session->unset_userdata('reg_tour_id');

        //get the transaction data
        $paypalInfo = $this->input->get();
		//echo "<pre>";
		//print_r($paypalInfo);
		//exit;
		$data = array();

			$data['item_number']	= $this->input->get('item_number');

			if($this->input->get('tx')){
			$data['txn_id']			= $this->input->get('tx');
			}
			else{
			$data['txn_id']			= $this->input->get('token');
			}

			$data['payment_amt']		= $this->input->get('amt');
			$data['currency_code']		= $this->input->get('cc');
			$data['status']					= $this->input->get('st');

			$data['coup_code']	= $this->input->get('coup_code');
			$data['coup_disc']	= $this->input->get('coup_disc');

		 if($this->input->get('ttype') == 'Teams'){
			$data['team']					= $team_id			= $this->input->get('team');
			$data['player']				= $user_id			= $this->input->get('reg_user');
			$data['team_players']	= $team_players	= $this->input->get('team_players');
			$data['tourn_id']			= $tourn_id			= $this->input->get('tourn_id');
			$data['age_group']		= $age_group		= $this->input->get('age_group');
			$data['level']					= $level				= $this->input->get('level');
			$data['hc_loc_id']			= $hc_loc				= $this->input->get('hc_loc');
			$data['tsize']					= $tsize				= $this->input->get('tsize');
			$data['note_to_admin'] = $note_to_admin	= $this->input->get('nte_to_admin');

			$res = $this->model_league->team_reg_tourn_with_fee($data);
		 }
		 else if($this->input->get('ttype') == 'Indv'){		
			$data['player']			= $user_id		= $this->input->get('player');
			$data['tourn_id']		= $tourn_id		= $this->input->get('tourn_id');
			$data['age_group']	= $age_group	= $this->input->get('age_group');
			$data['mtypes']			= $match_types	= $this->input->get('mtypes');
			$data['partners']		= $partners		= $this->input->get('partners');
			//$data['partner2']	= $partner2		= $this->input->get('partner2');
			$data['level']				= $level		= $this->input->get('level');
			$data['hc_loc_id']		= $hc_loc		= $this->input->get('hc_loc');
			$data['tsize']				= $tsize		= $this->input->get('tsize');
			$data['events']			= $reg_events   = $this->input->get('events');
			$data['note_to_admin'] = $note_to_admin	= $this->input->get('nte_to_admin');
			$data['school_info']		= $school_info			= $this->input->get('school_info');

			$data['occr'] = $occr	= "";
			if($this->input->get('occr')){
			$data['occr'] = $occr	= $this->input->get('occr');
			}
			else if($this->input->get('option_name3')){
				$a = json_decode(trim($this->input->get('option_name3')));

				if(is_array($a)){
				$data['occr'] = $occr	= $this->input->get('option_name3');
				}
			}

			$data['est_usatt_rating'] = '';
			if($this->input->get('est_usatt_rating')){
			$data['est_usatt_rating'] = $est_rating	= $this->input->get('est_usatt_rating');
			}
			else if($this->input->get('option_name3')){
				$a = json_decode(trim($this->input->get('option_name3')));

				if(is_numeric($a)){
					$data['est_usatt_rating']	= $est_rating	= $this->input->get('option_name3');
				}
			}

			$res = $this->model_league->reg_tourn_with_fee($data);

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
		$dev_subject = "A2M Paypal Vals - Developer";
		$data		 = array(
						'firstname'			=> "Developer",
						'player_teamleague'	=> $this->input->get('reg_user'),
						'player_indv'		=> $this->input->get('player'),
						'tourn_id'			=> $this->input->get('tourn_id'),
						'team'				=> $this->input->get('team'),
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

			if($tour_det->Event_Reg_Limit){

			$tourn_events_limit = json_decode($tour_det->Event_Reg_Limit, TRUE);

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
		}
			//	print_r($categories);
//exit;
				$tourn_det	= $this->model_league->getonerow($tourn_id);   //tournament details
				$title				= $tourn_det->tournament_title;               
				$subject		= "Tournament Registration {$title} - A2MSports";

				$user_reg_date = $user_categories['Reg_date'];
                //$reg_date = date('m-d-Y', strtotime($user_reg_date));
                $reg_date	   = date('m-d-Y H:i:s');

				$data = array(
				'firstname'	=> $row->Firstname,
				'lastname'	=> $row->Lastname,
				'tourn_id'	=> $tourn_id,
				'title'		=> $title,
				'date'      => $reg_date,
				'categories' => $categories,
				'page'		=> 'Registration-Singles'
				);

				$this->email_to_player($row->EmailID, $subject, $data);
				
                $userdat			   = $this->get_username($tourn_det->Usersid);
                $tourn_admin_email	   = $userdat['EmailID'];
                $tourn_admin_firstname = $userdat['Firstname'];
                $tourn_admin_lastname  = $userdat['Lastname'];

                $reg_date = date('m-d-Y H:i:s');
				$data	= array(
								'firstname'	=> $row->Firstname,
								'lastname'	=> $row->Lastname,
								'admin_firstname'	=> $tourn_admin_firstname,
								'admin_lastname'	=> $tourn_admin_lastname,
								'date'      => $reg_date,
								'tourn_id'	=> $tourn_id,
								'title'		=> $title,
								'categories' => $categories,
								'note_to_admin' => $note_to_admin,
								'page'		=> 'Send mail to tournament admin once user registration'
							);

                $this->email_to_player($tourn_admin_email, $subject, $data);
                $this->email_to_player("npradkumar@gmail.com", $subject, $data);
				
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
					redirect("league/$tourn_id/1");
			}
			else{
				echo 'Something went wrong, Please write to admin@a2msports.com.<br>';
			}
     }


		 function cancel(){
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

        $data['users_id']			= trim($paypalInfo['option_name1']);
        $data['reg_events']		= trim($paypalInfo['option_name2']);

		if($paypalInfo['option_name3']){
			$a = json_decode(trim($paypalInfo['option_name3']));

			if(is_array($a)){
				$data['reg_occrs']				= trim($paypalInfo['option_name3']);
			}
			else if(is_numeric($a)){
				$data['est_usatt_rating']	= trim($paypalInfo['option_name3']);
			}
		}

        $data['tourn_id']			= trim($paypalInfo["item_number"]);
        $data['txn_id']				= $paypalInfo["txn_id"];
        $data['payment_gross']	= $paypalInfo["payment_gross"];
        //$data['currency_code']	= $paypalInfo["mc_currency"];
        $data['payer_email']			= $paypalInfo["payer_email"];
        $data['payment_status']	= $paypalInfo["payment_status"];
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
		$dev_subject  = "A2M Paypal Vals - Production";
		$data		 = array(
									'firstname'	     => "Developer",
									'paypal_vals'   => print_r($paypalInfo, true),
									'page'	         => 'A2M Paypal values - Developer');

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

        $data['tourn_id']			= trim($paypalInfo["item_number"]);
        $data['txn_id']					= $paypalInfo["txn_id"];
        $data['payment_gross']	= $paypalInfo["payment_gross"];
        //$data['currency_code']	= $paypalInfo["mc_currency"];
        $data['payer_email']			= $paypalInfo["payer_email"];
        $data['payment_status']	= $paypalInfo["payment_status"];
        $data['payment_date']	= $paypalInfo["payment_date"];
        $data['currency']			= $paypalInfo["mc_currency"];
        $data['pp_charges']		= $paypalInfo["mc_fee"];

		//$paypalInfo["abc"] = $x;

			$tour_det = $this->model_league->getonerow($data['tourn_id']);

		$paypalInfo["tformat"] = $tour_det->tournament_format;

        $paypalURL = $this->paypal_lib->paypal_url;        
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
		if(trim($tour_det->tournament_format) == 'Individual'){
			$upd = $this->model_league->upd_paypal_ipn_more($data);
			$paypalInfo["upd"] = $upd;
		}

	 	$dev_email	 = "pradeepkumar.namala@gmail.com";
		$dev_subject = "A2M Paypal Vals - Production More";
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

	public function email_to_player($to_email, $subject, $data){	
		$this->load->library('email');
		$this->email->set_newline("\r\n"); 
		$this->email->from(FROM_EMAIL, 'A2MSports');
		$this->email->to($to_email);
		$this->email->subject($subject);

		$body = $this->load->view('view_email_template.php', $data, TRUE);

		$this->email->message($body);   
		$this->email->send();
	}

	public function get_reg_tourn_participants($tourn_id){
			$res = $this->model_league->get_reg_tourn_participants($tourn_id);
			//print_r($res);exit();
				$reg_users = array();
		   foreach($res as $r){
				$formats    = json_decode($r->Match_Type);
				$ag_group  = json_decode($r->Reg_Age_Group);
				$sp_levels = json_decode($r->Reg_Sport_Level);

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

		public function regenerate_events($mult_events){
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

		 public function get_level_name($sport_id,$level)
		 {
			return $this->model_league->get_level_name($sport_id, (int)$level);
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
}