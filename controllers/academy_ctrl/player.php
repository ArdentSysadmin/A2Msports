<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
	class Player extends CI_Controller {
	
		public $api_access_key;

		public $logged_user;
		public $is_super_admin;
		public $short_code;
		public $academy_admin;
		public $org_id;

		public function __construct()
		{
			parent:: __construct();
			$this->load->model('academy_mdl/model_academy');
			$this->load->model('academy_mdl/model_members');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_news');
			$this->load->model('academy_mdl/model_league');
			$this->load->library('pagination');
			if($this->session->userdata('users_id')){
				$this->logged_user = $this->session->userdata('users_id');
			}
			else{
				$this->logged_user = "";
			}
				$this->is_super_admin = 0;
			if($this->session->userdata('email') == 'rajkamal.kosaraju@gmail.com'){
				$this->is_super_admin = 1;
			}

			$this->short_code   = $this->config->item('club_short_code');
			$this->org_id	    = $this->general->get_orgid($this->short_code);

			$this->academy_admin = $this->general->get_org_admin($this->short_code);

			$url_seg = $this->uri->uri_string(); 
			$last_url = array('redirect_to'=>$url_seg);
			$this->session->set_userdata($last_url);

			// (Android)API access key from Google API's Console.
			$this->api_access_key = "AAAA-Vtr0cE:APA91bGa3Xoh5vcEbSRmmMqLE9MuNwhCqUeMSR8vZSwyMinus3Bexdjg5HTt864bjqyLHoqG6tA9Tbx5eap3GsGBnWvNXdR_8gp4_GBDYHRtutdxHUY0sOuFDn93KW3Wc4bnv2LiGZy0";

			// (iOS) Private key's passphrase.
				//private static $passphrase = 'a2m';
			// (Windows Phone 8) The name of our push channel.
				//private static $channelName = "a2m";

			// Change the above three vriables as per your app.
						if(!$this->logged_user){
			$this->load->library('facebook' ,  array("appId" => FB_APPID, "secret" => FB_KEY, "redirect_url" => FB_REDIRECT ));
			//$this->load->library('facebook');
			}
		}

			public function get_fb_login(){
			//$returnURI = array('redirect' => $_SERVER['HTTP_X_FORWARDED_HOST']."/login/verify_user");
			//$login  = $this->facebook->getLoginUrl($returnURI);
			$login  = $this->facebook->getLoginUrl();
			//echo $login; exit;
			return $login;
		}

		public function get_google_login(){

		// Store values in variables from project created in Google Developer Console
		$client_id			= '170374605326-p02hhgiia6fqncck0982i401madv6n72.apps.googleusercontent.com';
		$client_secret		= 'XyOwkQkScXXca0wG4paTUx6A';
		$redirect_uri		= 'https://a2msports.com/login/auth_check';
		$simple_api_key = 'AIzaSyC0JNMWyyW6t1fSNyrprBJC2bWKG4btytc';

		include_once APPPATH."libraries/google_login_api_HRWNdR/src/Google_Client.php";
		include_once APPPATH."libraries/google_login_api_HRWNdR/src/contrib/Google_Oauth2Service.php";
        
        // Google Project API Credentials
        $clientId	   = $client_id;
        $clientSecret = $client_secret;
        $redirectUrl   = $redirect_uri;
        
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('A2MSports');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);

		//$gclient->setDefaultOption('verify', false); // Can be removed
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        $token				 = $this->session->userdata('token');

       // if (!empty($token)) {
        if ($token != "") {
            $gClient->setAccessToken($token);
        }

        $data['authUrl'] = $gClient->createAuthUrl();
      
			return $data['authUrl'];
		}

		public function get_onerow($table, $column, $val){
			return $this->general->get_onerow($table, $column, $val);
		}
		// viewing league page ...
		public function index(){
			//exit;
			$data['search_fname'] = "";
			$data['coach_name']	  = "";
			$data['search_title'] = "";
			$data['created_by']	  = "";
			$data['Sport']		  = "";
			$data['search_city']  = "";
			$data['search_state'] = "";

			$data['sport_levels'] =  $this->model_members->get_tennis_levels();
			
			$data['results'] = $this->model_news->get_news();
			$this->load->view('includes/header');
			$this->load->view('view_members_list', $data);
			$this->load->view('includes/view_right_column', $data);
			$this->load->view('includes/footer');
		}

		public function get_club_menu($org_id){
			$get_menu = $this->general->get_club_menu($org_id);
			$club_menu = array();

			if($get_menu)
				$club_menu = json_decode($get_menu['Active_Menu_Ids'], TRUE);
			return $club_menu;
		}

		public function academy_users(){

			$q			= $_POST['name_startsWith'];
			$academy_id = $_POST['academy'];
	
			$data['key'] = trim($q);
			$data['academy'] = trim($academy_id);
			$result = $this->model_members->search_academy_users($data);

			if($result){
				$data_new = array();
				foreach($result as $row){
					$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID;
					array_push($data_new, $name);	
				}
			}
			else{
				$data_new = array();
				$name = "No players found! ".'|'."";
					array_push($data_new, $name);	
			}
				echo json_encode($data_new);
		}

		public function users(){
			$q			= $_POST['name_startsWith'];
			//$academy_id = $_POST['academy'];
	
			$data['key'] = trim($q);
			//$data['academy'] = trim($academy_id);
			$result = $this->model_members->search_autocomplete($data);

			if($result){
				$data_new = array();
				foreach($result as $row){
					$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID;
					array_push($data_new, $name);	
				}
			}
			else{
				$data_new = array();
				$name = "No players found! ".'|'."";
				array_push($data_new, $name);	
			}
			
			echo json_encode($data_new);

		}

		public function Sport_levels($sport_id = '')
		{
			$sport_id = $this->input->post('sport_id');
			$sport_levels = $this->model_members->get_sport_levels($sport_id);
			
			echo "<select name='level' id='level' class='form-control'>";
			echo "<option value=''>Level</option>";
			//$sp_level = $this->input->post("level");
			foreach($sport_levels as $row){ 
				// if($sp_level == $row->SportsLevel_ID){ $checked_stat = 'selected = selected'; } 
				echo "<option value='$row->SportsLevel_ID' $checked_stat>$row->SportsLevel</option>";
			}
			echo "</select>";
		}

		public function search_user(){

			if($this->input->post('search_mem')){
				$data['search_fname'] = $this->input->post('name');
				$data['sport'] = $this->input->post('user_sport');
				$data['level'] = $this->input->post('level');
				$data['range'] = $this->input->post('range');

				//if($data['range'] == "") { $data['range'] = 50; }
				
				$data['lat'] = $this->session->userdata('lat');
				$data['long'] = $this->session->userdata('long');
				
				$data['query'] = $this->model_members->search_details($data);
				$data['results'] = $this->model_news->get_news();
				$sport = $data['sport'];
				$data['sport_levels'] = $this->model_members->get_sport_levels($sport);
				
				$this->load->view('includes/header');
				$this->load->view('view_members_list',$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
			
			}
			else if($this->input->post('search_mem_loc')){

				$data['search_uname'] = $this->input->post('name');
				$data['loc_city']	= $this->input->post('loc_city');
				$data['loc_state']	= $this->input->post('loc_state');
				$data['sport']		= $this->input->post('user_sport');
				
				$data['lat']		= $this->session->userdata('lat');
				$data['long']		= $this->session->userdata('long');
				
				$data['loc_query']	= $this->model_members->search_loc_details($data);
				$data['results']	= $this->model_news->get_news();
				$sport				= $data['sport'];

				$data['sport_levels'] = $this->model_members->get_sport_levels($sport);

				$this->load->view('includes/header');
				$this->load->view('view_members_list',$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
			}
		}

		public function search_coach(){
			
			if($this->input->post('coach_mem')){
				$data['coach_name'] = $this->input->post('coach_name');
				$data['coach_sport'] = $this->input->post('coach_sport');
				$data['coach_range'] = $this->input->post('coach_range');

				if($data['coach_range'] == "") { $data['coach_range'] = 50000; }
				
				$data['lat'] = $this->session->userdata('lat');
				$data['long'] = $this->session->userdata('long');
				
				$data['coach_results'] = $this->model_members->search_coaches($data);
				$data['results'] = $this->model_news->get_news();
				
					$this->load->view('includes/header');
					$this->load->view('view_members_list',$data);
					$this->load->view('includes/view_right_column',$data);
					$this->load->view('includes/footer');
			}
		}

		public function search_matches(){			
			$data['ch_loc_city']	= $this->input->post('ch_loc_city');
			$data['ch_loc_state']	= $this->input->post('ch_loc_state');
			$data['Sport']		= $this->input->post('Sport');
			$data['range']		= $this->input->post('range');

				if($data['range'] == "") { $data['range'] = 50; }

			$lat_long = $this->get_lang_latt();

			$split = explode("@", $lat_long);

			$data['lat']  = $split[0];
			$data['long'] = $split[1];
			
			$data['matches']  = $this->model_members->search_matches($data);
			$data['matches1'] = $this->model_members->search_matches1($data);
			
			$data['results']  = $this->model_news->get_news();
				$this->load->view('includes/header');
				$this->load->view('view_members_list',$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
		}

		public function get_lang_latt(){
			if($this->input->post('ch_loc_city') != ""){
				$city	 = $this->input->post('ch_loc_city');
				$state	 = $this->input->post('ch_loc_state');
				$address = $city . '/' . $state;
			}
			else{
				$city	 = "";
				$state	 = $this->input->post('ch_loc_state');
				$address = $state;
			}

		if(!empty($address)){

		//Send request and receive json data by address
		$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.GEO_LOC_KEY); 

		$output1 = json_decode($geocodeFromAddr);

		$latitude  = 0.00; 
		$longitude = 0.00;

		//Get latitude and longitute from json data
		$latitude  = $output1->results[0]->geometry->location->lat; 
		$longitude = $output1->results[0]->geometry->location->lng;

		return  $latitude  . '@' . $longitude ;
		}
		else{
		return false;
		}
		}


		public function search_tournaments(){
			$data['search_city']  = $this->input->post('search_city');
			$data['search_state'] = $this->input->post('search_state');
			$data['Sport'] = $this->input->post('Sport');
			$data['range'] = $this->input->post('range');
	
					//if($data['range'] == "") { $data['range'] = 50; }
		
			$data['lat']  = $this->session->userdata('lat');
			$data['long'] = $this->session->userdata('long');
			
			$data['tournaments'] = $this->model_members->search_tournaments($data);
			$data['results']	 = $this->model_news->get_news();
				$this->load->view('includes/header');
				$this->load->view('view_members_list',$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
		}

		public function get_details($user_id){
			return $this->model_members->get_sport_id($user_id);
		}

		 public function autocomplete($param = ''){
			$q = $_POST['name_startsWith'];
			$sp_type = $_POST['sp_type'];

			$data['key'] = trim($q);

			if($param == 'city'){
				$result = $this->model_members->city_autocomplete($data);

				if($result){
					$data_new = array();
					foreach($result as $row){
						$name = $row->city . '|' . $row->short_code;
						array_push($data_new, $name);	
					}
				}
			}
			else if($param == 'state'){
				$result = $this->model_members->state_autocomplete($data);

				if($result){
					$data_new = array();
					foreach($result as $row){
						$name = $row->state . '|' . $row->short_code;
						array_push($data_new, $name);	
					}
				}
			 }
			 else{
				$result = $this->model_members->search_autocomplete($data);

				if($result){
					$data_new = array();
					foreach($result as $row){
						$get_a2m = $this->model_members->get_a2msocre($sp_type, $row->Users_ID);
						$name	 = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID.'|'.$row->City.'|'.$row->State
						.'|'.$get_a2m['A2MScore'].'|'.$row->Gender;
						array_push($data_new, $name);	
					}
				}
			 }
			 echo json_encode($data_new);
			 exit;
		 }

		 public function autocomplete_team($param = ''){
			$q  = $_POST['name_startsWith'];
			$sp = $_POST['sport'];

			$data['key']   = trim($q);
			$data['sport'] = $sp;

				$result = $this->model_members->search_team_autocomplete($data);

				if($result){
					$data_new = array();
					foreach($result as $row){
						$name = $row->Team_name.'|'.$row->Team_ID;
						array_push($data_new, $name);	
					}
				}
			 echo json_encode($data_new);
			 exit;
		 }

		public function match($match_id){
			$data['match_det'] = $this->model_members->get_match_det($match_id);
			$data['results'] = $this->model_news->get_news();
				$this->load->view('includes/header');
				$this->load->view('view_match_details', $data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
		}

		public function individual_play($match_id){
			$data['match_det'] = $this->model_members->get_individual_play($match_id);
			$data['results'] = $this->model_news->get_news();
				$this->load->view('includes/header');
				$this->load->view('view_individual_play_details', $data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
		}


		 public function get_user($user_id){
		   return $this->general->get_user($user_id);
		 }

		 public function get_sport_name($gen_match_id){
			return $this->model_members->get_sport_number($gen_match_id);
		 }

		public function player_details($user_id, $org_id)
		{
			//error_reporting(-1);
		/*	if(!$this->session->userdata('user')){
				redirect('login');
			}*/
			$org_details				= $this->model_academy->get_academy_details($org_id); 
			$data2['org_details']	= $org_details; 
			$data2['creator']			= $org_details['Users_ID'];

			$data['user_details'] = $this->model_members->get_user_id($user_id);
			 if($data['user_details']['Is_coach'] == 1){ 
			   $get_coachratings  = $this->model_league->getCoachRatings($user_id);
			   $data['get_coachratings']  =  $get_coachratings;
			   $s5=0;
			   $s4=0;
			   $s3=0;
			   $s2=0;
			   $s1=0;
			   foreach ($get_coachratings as $key => $value) {
                if($value->Ratings==5){
                  $s5+=1;
                } 
                if($value->Ratings==4){
                  $s4+=1;
                }
                if($value->Ratings==3){
                  $s3+=1;
                }
                if($value->Ratings==2){
                  $s2+=1;
                }
                if($value->Ratings==1){
                  $s1+=1;
                }
			   }
			   
			   $avg_star_rating = ($s5*5 + $s4*4 + $s3*3 + $s2*2 + $s1*1) / ($s5 + $s4 + $s3 + $s2 + $s1);
			   $data['avg_star_rating'] = $avg_star_rating;

			   $get_userratings   = $this->model_league->getUserRatings($user_id);
			   $data['get_userratings']  =  $get_userratings;
		     }
	    
			$data['user_matches']			= $this->model_members->get_user_matches($user_id);
			$data['user_tournment_matches'] = $this->model_members->get_user_tournment_matches($user_id);
			$data['user_tournment_team_matches'] = $this->model_members->get_user_tournment_team_matches($user_id);
			$data['membership_details']		= $this->model_members->get_membership_details($user_id);
			
			$data['num_matches'] = $this->model_members->get_num_matches($user_id);
			$data['results']	 = $this->model_news->get_news($org_id);
			
			
			$user_sports_intrests = $this->model_members->get_user_sport_intrests($user_id);
			
			/*$sp_intrests = "(";

			if(count($user_sports_intrests) > 0){
				foreach($user_sports_intrests as $i => $usi){
					$sp_intrests .= $usi->Sport_id;
					if(count($user_sports_intrests) != ++$i){
						$sp_intrests .= ", ";
					}
				}
			}
			else{
			$sp_intrests .= "1, 2, 3, 4, 5, 6, 7, 8, 9, 10";
			}

			$sp_intrests .= ")";*/

			$sp_intrests .= "(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 20)";


			//$get_stats  = $this->model_members->get_user_single_stats($user_id, $sp_intrests);
			$get_stats1  = $this->model_members->get_user_single_stats($user_id, $sp_intrests);
			$get_stats2  = $this->model_members->get_user_line_stats($user_id, $sp_intrests);
			$get_stats = array_merge($get_stats1, $get_stats2);

	//echo "<pre>"; print_r($data['user_tournment_matches']); exit;
	//echo "<pre>"; print_r($get_stats1); exit;
			$played	= 0;
			$won		= 0;
			$lost			= 0;
			$points_for			= 0;
			$points_against	= 0;
			$stats					= array();

			foreach($get_stats as $utm){
				if($utm->Winner != 0 and $utm->Winner != NULL){

				if($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner 
				or $user_id == $utm->Player2 or $user_id == $utm->Player2_Partner){
				($stats[$utm->SportsType]['played']) ? 
					$stats[$utm->SportsType]['played']++ : $stats[$utm->SportsType]['played'] = 1;
					//echo "<br>".$utm->Tourn_ID." ".$utm->Tourn_match_id;
				}
				if(
					$user_id == $utm->Winner or 
					($user_id == $utm->Player1_Partner and $utm->Winner == $utm->Player1) or 
					($user_id == $utm->Player2_Partner and $utm->Winner == $utm->Player2)
				  )
				{
				($stats[$utm->SportsType]['won']) ? 
					$stats[$utm->SportsType]['won']++ : $stats[$utm->SportsType]['won'] = 1;
					//echo "<br>1 ".$utm->Tourn_ID." ".$utm->Tourn_match_id;

				}
				else if($user_id != $utm->Winner and $utm->Winner != NULL){
				($stats[$utm->SportsType]['lost']) ? 
					$stats[$utm->SportsType]['lost']++ : $stats[$utm->SportsType]['lost'] = 1;
				}

				$for_score	   = ($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner) ?
								 $utm->Player1_Score : $utm->Player2_Score;

				$against_score = ($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner) ?
									 $utm->Player2_Score : $utm->Player1_Score;
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						($stats[$utm->SportsType]['points_for']) ? 
							$stats[$utm->SportsType]['points_for'] += $tot : $stats[$utm->SportsType]['points_for'] = $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						($stats[$utm->SportsType]['points_against']) ? 
							$stats[$utm->SportsType]['points_against'] += $tot : $stats[$utm->SportsType]['points_against'] = $tot;
					}
				}
			}
			/*echo "<pre>";
			print_r($stats[2]);
			exit;*/

			$get_gen  = $this->model_members->get_user_gen_stats($user_id);
			$get_indv  = $this->model_members->get_user_indv_stats($user_id);

			$get_stats2 = array_merge($get_gen, $get_indv);
//echo "<pre>"; print_r($get_stats2); 			exit;
			foreach($get_stats2 as $gen_match){

				if($gen_match->Sports){
				$get_match  = $this->model_members->get_user_indvMatch($gen_match->GeneralMatch_id);
			
				foreach($get_match as $utm){


				if($utm->Winner != 0 and $utm->Winner != NULL){

				if($user_id == $gen_match->users_id or $user_id == $gen_match->Player1_Partner 
				or $user_id == $utm->Opponent or $user_id == $utm->Player2_Partner){
				($stats[$gen_match->Sports]['played']) ? 
					$stats[$gen_match->Sports]['played']++ : $stats[$gen_match->Sports]['played'] = 1;
					//echo "<br>".$utm->Tourn_ID." ".$utm->Tourn_match_id;
				}
				if(
					$user_id == $utm->Winner or 
					($user_id == $gen_match->Player1_Partner and $utm->Winner == $gen_match->users_id) or 
					($user_id == $utm->Player2_Partner and $utm->Winner == $utm->Opponent)
				  )
				{
				($stats[$gen_match->Sports]['won']) ? 
					$stats[$gen_match->Sports]['won']++ : $stats[$gen_match->Sports]['won'] = 1;
					//echo "<br>1 ".$utm->Tourn_ID." ".$utm->Tourn_match_id;

				}
				else if($user_id != $utm->Winner and $utm->Winner != NULL){
				($stats[$gen_match->Sports]['lost']) ? 
					$stats[$gen_match->Sports]['lost']++ : $stats[$gen_match->Sports]['lost'] = 1;
				}

				$for_score	   = ($user_id == $gen_match->users_id or $user_id == $gen_match->Player1_Partner) ?
								 $utm->Player1_Score : $utm->Opponent_Score;

				$against_score = ($user_id == $gen_match->users_id or $user_id == $gen_match->Player1_Partner) ?
									 $utm->Opponent_Score : $utm->Player1_Score;
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						($stats[$gen_match->Sports]['points_for']) ? 
							$stats[$gen_match->Sports]['points_for'] += $tot : $stats[$gen_match->Sports]['points_for'] = $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						($stats[$gen_match->Sports]['points_against']) ? 
							$stats[$gen_match->Sports]['points_against'] += $tot : $stats[$gen_match->Sports]['points_against'] = $tot;
					}
				}
				}
			}
			}



			$data['user_stats']	 = $stats;
			$data['user_id']	 = $user_id;

			$data2['noIndex'] = 1;
			//exit;
			$this->load->view('academy_views/includes/academy_header', $data2);
			$this->load->view('academy_views/includes/a2m_header_inc');
			$this->load->view('academy_views/view_player_details', $data);
			$this->load->view('academy_views/includes/academy_right_column');
			$this->load->view('academy_views/includes/academy_footer');
			$this->load->view('academy_views/includes/a2m_footer_inc');

		}

		public function get_gen_mat_det($gen_match_id){
			return $this->model_members->get_gen_mat_det($gen_match_id);
		}

		public function get_user_det($user_id){
			return $this->general->get_user($user_id);
		}

		public function get_tourn_name($tourn_id){
			return $this->model_members->get_tourn_name($tourn_id);
		}

		public function get_sport($sport_id){
			return $this->general->get_sport_title($sport_id);
		}

		public function get_club($org_id){
			return $this->model_members->get_club($org_id);
		}

		public function contact_player(){
			$mes = $this->input->post('mes');

			if($this->input->post('send_email') && $mes != ''){
				$from_email = "admin@a2msports.com";
				//$from_email = "test@a2msports.com";
				$from_name  = $this->session->userdata('user');
				$from_id	= $this->session->userdata('users_id');
				$to_email = $this->input->post('contact_email');
				$fname	  = $this->input->post('fname');
				$lname	  = $this->input->post('lname');
				$id		  = $this->input->post('id');

				if(empty($to_email)){
					$to_email = $this->input->post('alter_contact_email');
				}

				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from($from_email, $from_name);
				$this->email->to($to_email);				
				$this->email->subject('New Contact Message - '.$from_name.'/A2MSports');

				$data = array(
				  'fname'	 => $fname,
				  'from_name'=> $from_name,
				  'from_id'	 => $from_id,
				  'lname'	 => $lname,
				  'message'	 => $mes,
				  'page'	 => 'Contact Player'
				);

				$body = $this->load->view('view_email_template.php', $data, TRUE);
				//$body = "Test Message from A2MSports";
				$this->email->message($body);   
				$res = $this->email->send();
				
				/*if($res){ echo "sucess"; exit; }
				else{ echo $this->email->print_debugger(); exit; }*/
				
				$get_user_token = $this->model_members->get_userToken($id);

				if($get_user_token){
					$msg_payload = array (
						'title' => 'Contact Message from '.$from_name,
						'body'  => $mes
						);

					foreach($get_user_token as $i => $ut){
						$regId		  = $ut->token;
						$mobile_notif = $this->android($msg_payload, $regId);
						//echo "<pre>";
						$r = json_decode($mobile_notif);
						//print_r($r);
					}
				}


				// Message payload
				/*$msg_payload = array (
				'mtitle' => 'Notif From Web API',
				'mdesc'  => 'Test Notification by Pradeep',
				);

				// For Android
				//$regId = 'ExponentPushToken[vCUj0sJgKhzzQW7DWhDxjL]';
				$regId = 'f7p-GdcxH-k:APA91bFn91XqeQ2sb8Vc1VONyGSv74BjXsXCr5mPUsgXPc57Kz6N7O3MUGpKF-34Y9m-0ea2bT0tMRUWqd5XrFz94VgKGY4ESzR04qtCpbKaLazq_8pAO_fuzjuKf8UXw5sARIumxEhh';				
				$this->android($msg_payload, $regId);*/


				//if($res){
				  redirect("player/$id");
				//}
			}
		}

		        // Sends Push notification for Android users
		public function android($data, $reg_id) {
	        $url = 'https://fcm.googleapis.com/fcm/send';
	        /*$message = array(
	            'body'	 => $data['mdesc'],
	            'title'		 => $data['mtitle']
	        );*/
	        
	        $headers = array(
	        	'Content-Type : application/json',
	        	'Authorization: key='.$this->api_access_key
	        );
	
	        $fields = array(
	            'registration_ids'  => array($reg_id),
				'notification'		=> $data
	          //  'data' => $message,
	        );
			//echo json_encode($fields);exit;
	    	return $this->useCurl($url, $headers, json_encode($fields));
    	}

	// Curl 
//	private function useCurl(&$model, $url, $headers, $fields = null) {
	public function useCurl($url, $headers, $fields = null) {
	        // Open connection
	        $ch = curl_init();
	        if ($url) {
	            // Set the url, number of POST vars, POST data
	            curl_setopt($ch, CURLOPT_URL, $url);
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	     
	            // Disabling SSL Certificate support temporarly
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	            if ($fields) {
	                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	            }
	     
	            // Execute post
	            $result = curl_exec($ch);
	            if ($result === FALSE) {
	                die('Curl failed: ' . curl_error($ch));
	            }
				// echo $result;
	            // Close connection
	            curl_close($ch);
	
	            return $result;
        }
    }

		public function get_a2msocre($sport, $user_id){
		return $this->model_members->get_a2msocre($sport, $user_id);
		}
		public function get_winper($sport, $user_id){
		return $this->model_members->get_winper($sport, $user_id);
		}

	public function get_user_opponent_stats(){
		$opp_user = $this->input->post('opp');
		$user_id  = $this->input->post('user_id');

		if($opp_user == -1){
			$opp_user = $user_id;
		}
		if($user_id){
			$user_sports_intrests = $this->model_members->get_user_sport_intrests($user_id);
			$sp_intrests = "(";
			foreach($user_sports_intrests as $i => $usi){
				$sp_intrests .= $usi->Sport_id;
				if(count($user_sports_intrests) != ++$i){
				$sp_intrests .= ", ";
				}
			}
			$sp_intrests .= ")";


			$get_stats = $this->model_members->get_user_single_stats($user_id, $sp_intrests);
			$played = 0;
			$won    = 0;
			$lost   = 0;
			$points_for     = 0;
			$points_against = 0;
			$user_stats			= array();

			foreach($get_stats as $utm){

				if(!$user_stats[$utm->SportsType]['won'])
					$user_stats[$utm->SportsType]['won'] = 0;

				if(!$user_stats[$utm->SportsType]['lost']) 
					$user_stats[$utm->SportsType]['lost'] = 0;

				if($utm->Winner != 0 and $utm->Winner != NULL 
					and ($opp_user == $utm->Player1 or $opp_user == $utm->Player1_Partner 
				or $opp_user == $utm->Player2 or $opp_user == $utm->Player2_Partner)){

				if($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner 
				or $user_id == $utm->Player2 or $user_id == $utm->Player2_Partner){
				($user_stats[$utm->SportsType]['played']) ? 
					$user_stats[$utm->SportsType]['played']++ : $user_stats[$utm->SportsType]['played'] = 1;
				}
				if($user_id == $utm->Winner){
				($user_stats[$utm->SportsType]['won']) ? 
					$user_stats[$utm->SportsType]['won']++ : $user_stats[$utm->SportsType]['won'] = 1;
				}
				else if($user_id != $utm->Winner and $utm->Winner != NULL){
				($user_stats[$utm->SportsType]['lost']) ? 
					$user_stats[$utm->SportsType]['lost']++ : $user_stats[$utm->SportsType]['lost'] = 1;
				}

				$for_score	   = ($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner) ?
								 $utm->Player1_Score : $utm->Player2_Score;

				$against_score = ($user_id == $utm->Player1 or $user_id == $utm->Player1_Partner) ?
									 $utm->Player2_Score : $utm->Player1_Score;
					
					if($for_score){
						$for = json_decode($for_score, true);
						$tot = 0;
						foreach($for as $sc)
							$tot += $sc;
						($user_stats[$utm->SportsType]['points_for']) ? 
							$user_stats[$utm->SportsType]['points_for'] += $tot : $user_stats[$utm->SportsType]['points_for'] = $tot;
					}

					if($against_score){
						$against = json_decode($against_score, true);
						$tot = 0;
						foreach($against as $sc)
							$tot += $sc;
						($user_stats[$utm->SportsType]['points_against']) ? 
							$user_stats[$utm->SportsType]['points_against'] += $tot : $user_stats[$utm->SportsType]['points_against'] = $tot;
					}
				}
			}
			
			/* Output in Table format */
			$opt = "<thead>
					<tr class='top-scrore-table' style='background-color: #f68b1c; color:#fff; font-size:14px; padding:3px'>
					<th class='text-center'>Sport</th>
					<th class='text-center'>A2M (S)</th>
					<th class='text-center'>A2M (D)</th>
					<th class='text-center'>A2M (M)</th>
					<th class='text-center'>Matches<br>Played</th>
					<th class='text-center'>Win - Loss</th>
					<th class='text-center'>Matches<br>Win%</th>
					<th class='text-center'>Scores</th>
					<th class='text-center'>Score<br>Differential</th>
					<th class='text-center'>Win%</th>
					<th class='text-center'>SD/MP</th>
					<th class='text-center'>SD/MP<br>+Win%</th>
					</tr>
					</thead>";

if(count($user_stats) > 0){
	foreach($user_stats as $sport => $stats){
	$get_sport   = search::get_sport($sport);
	$get_a2m	 = search::get_a2msocre($sport, $opp_user);
	$get_winper  = search::get_winper($sport, $opp_user);
	$win_per	= ($stats['won'] / $stats['played']) * 100;
	$diff		= ($stats['points_for'] - $stats['points_against']);
	$pd			= $diff / $stats['played'];
	$pd_win_per = $pd + $win_per;

$opt .= "<tr>
<td>&nbsp;<b>{$get_sport['Sportname']}</b></td>
<td align='center'>{$get_a2m['A2MScore']}</td>
<td align='center'>{$get_a2m['A2MScore_Doubles']}</td>
<td align='center'>{$get_a2m['A2MScore_Mixed']}</td>
<td align='center'>{$stats['played']}</td>
<td align='center'>{$stats['won']}-{$stats['lost']}</td>
<td align='center'>".number_format($win_per, 2)."</td>
<td align='center'>{$stats['points_for']}-{$stats['points_against']}</td>
<td align='center'>{$diff}</td>
<td align='center'>{$get_winper[Win_Per]}</td>
<td align='center'>".number_format($pd, 2)."</td>
<td align='center' style='font-weight:400;'>".number_format($pd_win_per, 2)."</td>
</tr>";

	}
}
else{
$opt .= "<tr>
<td align='right'>No</td>
<td>Standings</td>
<td>Available</td>
<td>yet!</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>";
}
			/* Output in Table format */

echo $opt;
		}
		else{
			echo "Invalid Request!";
		}
	}
	
}