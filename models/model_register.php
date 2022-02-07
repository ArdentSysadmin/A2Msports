<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_register extends CI_Model {
	
		public function __construct(){
			parent:: __construct();
		}
		
		private $email_code;  //has value set within set_session method
		
		//insert into database of registered user ..
		public function insert_user($data)
		{

			$is_club_register = 0;

			if($data['aca_id'] != ''){
			$is_club_register = 1;
			$aca_id = $data['aca_id'];
			}
			$lat_long	= $data['latt'];
			$pieces		= explode("@", $lat_long);
			
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];

			$user_image = $data['profile_pic_data'];
			$org_logo	= $data['org_logo_data'];

			$profile_pic = $user_image['file_name'];
			$logo		 = $org_logo['file_name'];

			
			$firstname	= ucfirst(strtolower($this->input->post('Firstname')));
			$lastname	= ucfirst(strtolower($this->input->post('Lastname')));

			$email = NULL;
			if($this->input->post('EmailID'))
			$email = $this->input->post('EmailID');

			$password = NULL;
			if($this->input->post('Password'))
			$password = md5($this->input->post('Password'));

			//$alteremail = $this->input->post('AlternateEmailID');
			if($this->input->post('Gender') == '')
				$gender = NULL;
			else
				$gender	= $this->input->post('Gender');

			/*
			$month = $this->input->post('db_month');
			$day = $this->input->post('db_day');
			$year = $this->input->post('db_year');

			$dob = $year . '-' . $month . '-' . $day;
			*/

			//$dob = $this->input->post('txt_dob');
			
			/*
			$birthdate	= new DateTime($dob);
			$today		= new DateTime('today');
			$age		= $birthdate->diff($today)->y;

			if($age <= 12){ 
				$age_group = "U12";
			}
			else if($age <= 14){
				$age_group = "U14";
			}
			else if($age <= 16){
				$age_group = "U16";
			}
			else if($age <= 18){
				$age_group = "U18";
			}
			else{
				$age_group = "Adults";
			}
			*/


			//$parentname = $this->input->post('Parentname');
			//$parentemail = $this->input->post('Parentemail');

			//$hphone = $this->input->post('HomePhone');
			$mphone = $this->input->post('Mobilephone');

			//$address1 = $this->input->post('UserAddressline1');
			//$address2 = $this->input->post('UserAddressline2');

			$country = $this->input->post('CountryName');

			/*if($country == 'United States of America') {
				$state = $this->input->post('StateName');
			} else {
				$state = $this->input->post('StateName1');
			}*/

			
			//$city = $this->input->post('CityName');
		
			$zip = $this->input->post('Zipcode');
			$reg_date = date("Y-m-d h:i:s");

			if($email)
			$code = md5($lastname . $email);
			else
			$code = md5($lastname . $mphone);

			$auth_code = substr($code, 0, 16);

			$issocial = 0 ;
			$is_user_activation = 0 ;
			$is_profile_updated = 1 ;

			$org_admin		= $this->input->post('organizer');
			$org_business	= $this->input->post('business_page');
			$org_name		= $this->input->post('org_name');
			$org_phone		= $this->input->post('org_phone');
			$org_address	= $this->input->post('org_address');
			$org_address2	= $this->input->post('org_address2');
			$org_city		= $this->input->post('org_city');
			$org_state		= $this->input->post('org_state');
			$org_country	= $this->input->post('org_country');
			$org_zip	= $this->input->post('org_zip');
			$url_shortcode	= strtolower($this->input->post('org_url'));
			$primary_sport	= $this->input->post('primary_sport_type');
			
			$addn_sports	= NULL;
			if($this->input->post('aca_addn_sports'))
			$addn_sports	= json_encode($this->input->post('aca_addn_sports'));
			
			$Is_club_member = $this->input->post('club_page');    
			
		/*
			$club_name = $this->input->post('club_name');
			$club_id = $this->input->post('club_id');

			$cn_result = "[";
			$cn_id_result = "[";

			for($i=0;$i<count($club_name); $i++)
			{

				if($club_name[$i] != ""){
				$cn_result .= '"'.$club_name[$i].'"';

					($club_id[$i]=="") ? $cn_id_result .= '"0"' : $cn_id_result .= '"'.$club_id[$i].'"';
				}	
				
				$j = $i;
				if(++$j != count($club_name) and $club_name[$i] != "") {
					
					$cn_result .= ",";
					$cn_id_result .= ",";
				}

				$j = $i;
				if(++$j == (count($club_name))){
					$cn_result .= "]";
					$cn_id_result .= "]";
				}
			}
			*/
			$Is_coach = 0;			$coach_profile = NULL;			$coach_website = NULL;			$coach_sport = NULL;

			if($this->input->post('coach_page')){
			$Is_coach		= $this->input->post('coach_page');  
			$coach_profile	= $this->input->post('coach_profile');
			$coach_website	= $this->input->post('coach_website');
			$coach_sport	= $this->input->post('coach_sport');
			}

			$tshirt = NULL;
			if($this->input->post('TShirtSize')){
			$tshirt	= $this->input->post('TShirtSize');
			}
			
			$notify_settings = '["1","2"]';

			$data = array(
					'Firstname' => $firstname ,
					'Lastname' => $lastname ,
					'EmailID' => $email ,
					'Password' => $password ,
					//'AlternateEmailID' => $alteremail ,
					'Gender' => $gender ,
					//'DOB' => $dob ,
					'Profilepic' => $profile_pic ,
					//'Parentname' => $parentname ,
					//'Parentemail' => $parentemail ,
					//'HomePhone' => $hphone ,
					'Mobilephone' => $mphone ,
					//'UserAddressline1' => $address1 ,
					//'UserAddressline2' => $address2 ,
					'Country' => $country ,
					//'State' => $state ,
					//'City' => $city ,
					'Zipcode' => $zip ,
					'Latitude' => $latitude ,
					'Longitude' => $longitude ,
					'ActivationCode' => $auth_code ,
					'IsUserActivation' => $is_user_activation,
					'Issociallogin' => $issocial,
					'RegistrationDtTm' => $reg_date ,
					'IsProfileUpdated' => $is_profile_updated,
					//'UserAgegroup' => $age_group,
					'Is_org_admin ' => $org_admin,
					'Req_business_page ' => $org_business,
					'Is_ClubMember' => $Is_club_member,
					'Is_coach' => $Is_coach,
					'coach_profile' => $coach_profile,
					'coach_website' => $coach_website,
					'coach_sport' => $coach_sport,
					'NotifySettings' => $notify_settings,
					'TShirt_Size'	 => $tshirt 
				);

			/*echo "<pre>";
			print_r($data);
			exit;*/

			$this->db->insert('Users', $data);
			//echo $this->db->last_query();
		    $insert_id = $this->db->insert_id();
			//echo "<br>".$insert_id;
			//exit;

			if(!$insert_id){
					echo "Something went wrong! Please contact admin.";
					exit;
			}

			$types = $this->input->post('Sportsintrests');

			if(sizeof($types) > 0 ){
				foreach($types as $type){
						 $data = array('Sport_id'=>$type,'users_id'=>$insert_id);
						 $this->db->insert('Sports_Interests', $data); 
				    }
			}

			$sports = array("1", "2", "3", "4","5","6","7","8","9","11","12","17","18","19","20"); // these numbers belongs to sport id in the SportType Table
			

			foreach($sports as $type){
				$def_score = 100;

				if($type == '2')
					$def_score = 800;
				if($type == '7' or $type == '19' or $type == '20')
					$def_score = 3.0;

				$data = array('SportsType_ID'	 => $type,
							  'Users_ID'		 => $insert_id,
							  'A2MScore'		 => $def_score,
							  'A2MScore_Doubles' => $def_score,
							  'A2MScore_Mixed'   => $def_score);

				$this->db->insert('A2MScore', $data); 
		    }

			$org_bussiness_id = 0;
			if($org_business == 1){
			
				if($org_name != ""){

					$fb_page	  = $this->input->post('org_fb');
					$insta_page = $this->input->post('org_insta');
					$twitter_handle = $this->input->post('org_twitter');

					$data = array(
						'Aca_name'	        => $org_name,
						'Aca_city'	        => $org_city,
						'Aca_state'         => $org_state,
						'Aca_country'       => $org_country,
						'Aca_sport'         => $addn_sports,
						'Aca_contact_phone' => $org_phone,
						'Aca_logo'          => $logo,
						'Aca_addr1'         => $org_address,
						'Aca_addr2'         => $org_address2,
						'Aca_zip'         => $org_zip,
						'Aca_URL_ShortCode' => $url_shortcode,
						'Aca_User_id'        => $insert_id,
						'Primary_Sport'     => $primary_sport,
						'Facebook_Page'    => $fb_page,
						'Instagram_Page'   => $insta_page,
						'Twitter_Handle'   => $twitter_handle,
						'Home_Layout'   => 'banner'
						);

				$result = $this->db->insert('Academy_Info', $data);
				$org_bussiness_id = $this->db->insert_id();
				}

				if($this->input->post('gpac')){
					$gpa_club = array('Assoc_Club' => 1176);

					$this->db->where('Aca_ID', $org_bussiness_id);
					$this->db->update('Academy_Info', $gpa_club);
				}

				if($this->input->post('coach_page') and $org_bussiness_id){
					$data_member = array('Club_id' => $org_bussiness_id, 'Users_id' => $insert_id, 'Member_Status' => 1, 'Related_Sport' => $primary_sport);
					$ins_membership = $this->db->insert('User_memberships', $data_member);

					$user_coach_academy = array('coach_academy' => $org_bussiness_id);

					$this->db->where('Users_ID', $insert_id);
					$this->db->update('Users', $user_coach_academy);
				}
			}

			if($Is_club_member == 1){

				$club_name		= $this->input->post('club_name');
				$org_id				= $this->input->post('org_id');
				$mem_id			= $this->input->post('club_id');
				$related_sport	= $this->input->post('club_sport');
			
				foreach($club_name as $i => $cb){

					if($org_id[$i] != ""){
						$data = array(
							'Club_id'				=> $org_id[$i],
							'Membership_ID' => $mem_id[$i],
							'Users_id'			=> $insert_id,
							'Related_Sport'	=> $related_sport[$i],
							'Member_Status' => 0
							);

						$this->db->insert('User_memberships', $data);
					}
				}
			}

					if($is_club_register == 1){
						$data = array(
							'Club_id'				=> $aca_id,
							'Users_id'			=> $insert_id,
							//'Related_Sport'	=> $related_sport[$i],
							'Member_Status' => 0
							);

						$this->db->insert('User_memberships', $data);
					}

			if($org_business == 1 and $org_bussiness_id){
				$this->rewrite_routes($url_shortcode, $org_bussiness_id);
			}

			$data = array('auth_code' => $auth_code, 'Users_ID' => $insert_id);
		
			return  $data;
		}

		public function insert_a2mscore(){

			$data = array('Users_ID'=> $this->session->userdata('users_id'));
			$result = $this->db->get_where('A2MScore',$data);
			$qry = 0;
				if (!$result->num_rows > 0)
				{
					for($i=1;$i<=9;$i++)
					{
						$def_score = 100;

						if($i == 2)
						$def_score = 800;
						if($i == 7)
							$def_score = 3.0;

						$data = array('Users_ID'=>$this->session->userdata('users_id'),'SportsType_ID'=>$i,'A2MScore'=>$def_score);
						$qry = $this->db->insert('A2MScore', $data);
					}

				}
			return $qry;
		}


		public function rewrite_routes($short_code, $club_id){

if($short_code and $club_id){
$data = './application/config/routes.php';	// it is the path of the text files 
//$show = file_get_contents($data);			// here $data is called for fetching the files message

$txt  = "\n".'$route["'.$short_code.'"] = "academy_ctrl/academy/details/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/admin"]	 = "academy_ctrl/admin/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/settings"]	 = "academy_ctrl/admin/menu_settings/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/memberships"] = "academy_ctrl/admin/memberships/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/add_memberships"] = "academy_ctrl/admin/add_memberships/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/upd_memberships"] = "academy_ctrl/admin/upd_memberships/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/update_menu"]	 = "academy_ctrl/admin/update_menu/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/player/(:num)"]	 = "academy_ctrl/player/player_details/$1/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/membership/paynow/(:num)"]	 = "academy_ctrl/membership/paynow/$1";';
$txt .= "\n".'$route["'.$short_code.'/membership/ot_success/(:num)"]	 = "academy_ctrl/membership/ot_success/'.$club_id.'/$1";';

$txt .= "\n".'$route["'.$short_code.'/courts/reserve"] = "academy_ctrl/courts/reserve/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/reserve/(:any)"] = "academy_ctrl/courts/reserve/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/list"] = "academy_ctrl/courts/courts_list/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/add"] = "academy_ctrl/courts/add_court/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/update"] = "academy_ctrl/courts/update_court/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_loc_courts"] = "academy_ctrl/courts/get_loc_courts";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_loc_info"]	  = "academy_ctrl/courts/get_loc_info";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_court_reservations"]   = "academy_ctrl/courts/get_court_reservations";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_reserve_popup"]   = "academy_ctrl/courts/get_reserve_popup";';
$txt .= "\n".'$route["'.$short_code.'/courts/get_court_durations"]   = "academy_ctrl/courts/get_court_durations";';
$txt .= "\n".'$route["'.$short_code.'/courts/check_court_availability"]	= "academy_ctrl/courts/check_court_availability";';
$txt .= "\n".'$route["'.$short_code.'/courts/block_court"]	  = "academy_ctrl/courts/block_court";';
$txt .= "\n".'$route["'.$short_code.'/courts/paypal_success"]	  = "academy_ctrl/courts/paypal_success";';
$txt .= "\n".'$route["'.$short_code.'/courts/paypal_cancel"]	  = "academy_ctrl/courts/paypal_cancel";';

$txt .= "\n".'$route["'.$short_code.'/league"]				  = "league/index";';
$txt .= "\n".'$route["'.$short_code.'/league/create_trnmt"]	  = "academy_ctrl/league/create_trnmt/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/register_match/(:num)"] = "academy_ctrl/league/register_match/$1/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/league/(:num)"]				= "academy_ctrl/league/viewtournament/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/(:num)/(:num)"] = "academy_ctrl/league/viewtournament/$1/'.$club_id.'/$1";';

$txt .= "\n".'$route["'.$short_code.'/league/edit/(:num)"]	= "academy_ctrl/league/edit/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/reg_players/(:num)"] = "academy_ctrl/league/reg_players/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/update_trnmt"]			= "academy_ctrl/league/update_trnmt/$1/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/league/view_matches"]	  = "academy_ctrl/league/view_matches/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/fixtures/(:num)"] = "academy_ctrl/league/fixtures/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/bracket/(:num)"]  = "academy_ctrl/league/bracket/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/bracket_save"]	  = "academy_ctrl/league/bracket_save/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/send_email_reg_players"] = "academy_ctrl/league/send_email_reg_players";';
$txt .= "\n".'$route["'.$short_code.'/league/upload_pics"]	  = "academy_ctrl/league/upload_pics";';
$txt .= "\n".'$route["'.$short_code.'/league/get_gallery"]	  = "academy_ctrl/league/get_gallery";';
$txt .= "\n".'$route["'.$short_code.'/league/buy/(:num)"]	  = "academy_ctrl/league/buy/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/uprofile"]		  = "academy_ctrl/league/uprofile/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/league/get_tour_fee/"]	  = "academy_ctrl/league/get_tour_fee/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/events/create"]					 = "academy_ctrl/events/create/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility"]		  					 = "academy_ctrl/facility/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/add_banner"]  = "academy_ctrl/facility/add_banner/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/update_facility"]		 = "academy_ctrl/facility/update_facility/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/update_lt_team"]	 = "academy_ctrl/facility/update_lt_team/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/update_ps_team"]	 = "academy_ctrl/facility/update_ps_team/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/add_glry_images"]	 = "academy_ctrl/facility/add_glry_images/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/facility/delete_glry"]			 = "academy_ctrl/facility/delete_glry/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/pricing"]							 = "academy_ctrl/pricing/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/pricing/update"]				 = "academy_ctrl/pricing/update_pricing/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/logout"]							 = "academy_ctrl/logout/index/'.$club_id.'";';


$txt .= "\n".'$route["'.$short_code.'/proshop"]		  				 = "academy_ctrl/proshop/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/proshop/add_proshop_items"]	 = "academy_ctrl/proshop/add_proshop_items/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/proshop/delete_product"]	 = "academy_ctrl/proshop/delete_product/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/teams/addnew"]					= "academy_ctrl/teams/addnew/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/teams/get_tour_reg_team"]	= "academy_ctrl/teams/get_tour_reg_team/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/paypal/success"]  = "academy_ctrl/paypal/success";';
$txt .= "\n".'$route["'.$short_code.'/paypal/cancel"]   = "academy_ctrl/paypal/cancel";';

$txt .= "\n".'$route["'.$short_code.'/viewbracket"]	   = "academy_ctrl/league/viewbracket/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/get_membership"]	   = "academy_ctrl/academy/get_membership/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/upd_membership"]	   = "academy_ctrl/academy/upd_membership/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/coaches"]				 = "academy_ctrl/academy/coaches_list/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/search_coaches"]		 = "academy_ctrl/academy/search_coaches";';
$txt .= "\n".'$route["'.$short_code.'/members"]				 = "academy_ctrl/academy/member_list/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/search_member"]		 = "academy_ctrl/academy/players";';
$txt .= "\n".'$route["'.$short_code.'/search_members"]		 = "academy_ctrl/academy/search_members";';
$txt .= "\n".'$route["'.$short_code.'/search/autocomplete"]	 = "academy_ctrl/search/autocomplete";';

$txt .= "\n".'$route["'.$short_code.'/show_res/(:any)"]	 = "academy_ctrl/academy/show_res/'.$club_id.'/$1";';

$txt .= "\n".'$route["'.$short_code.'/calendar"]					 = "academy_ctrl/calendar/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/calendar/process/(:num)"]	 = "academy_ctrl/calendar/process/$1";';

$txt .= "\n".'$route["'.$short_code.'/opponent"]			 = "academy_ctrl/opponent/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/opponent/create"]	 = "academy_ctrl/opponent/create/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/play/reg_players/(:num)"]	= "academy_ctrl/play/reg_players/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/play/invite/(:num)"]		= "academy_ctrl/play/invite/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/play/invite_email"]		= "academy_ctrl/play/invite_email/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/events/add"]			 = "academy_ctrl/events/add/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/view/(:num)/(:num)"] = "academy_ctrl/events/view/$1/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/view/(:num)"]	 = "academy_ctrl/events/view/$1/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events"]			  = "academy_ctrl/events/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events"]			  = "academy_ctrl/events/index/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/autocomplete"]	 = "academy_ctrl/events/autocomplete/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/add_fields"]		 = "academy_ctrl/events/add_fields/'.$club_id.'";';
$txt .= "\n".'$route["'.$short_code.'/events/add_fields_weekly"]	 = "academy_ctrl/events/add_fields_weekly/'.$club_id.'";';

$txt .= "\n".'$route["'.$short_code.'/news"]							 = "academy_ctrl/news/index";';
$txt .= "\n".'$route["'.$short_code.'/news/add"]					 = "academy_ctrl/news/add";';
$txt .= "\n".'$route["'.$short_code.'/news/add_news"]		 = "academy_ctrl/news/add_news";';
$txt .= "\n".'$route["'.$short_code.'/news/edit/(:num)"]			= "academy_ctrl/news/edit/$1";';
$txt .= "\n".'$route["'.$short_code.'/news/view/(:num)"]		= "academy_ctrl/news/get_news_detail/$1";';
$txt .= "\n".'$route["'.$short_code.'/news/update/(:num)"]	= "academy_ctrl/news/update_news/$1";';
$txt .= "\n".'$route["'.$short_code.'/send_notifications"]		= "academy_ctrl/academy/send_mob_notifications/'.$club_id.'";';

$txt .= "\n"."/**********************************************************************************/";

//echo $txt;
//exit;
			 //$urls = file_put_contents($data, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
			 $urls = true;
			 return $urls;
}
else{
return 0;
}
		}

		/*public function search_autocomplete($data){	
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('Academy');
			$this->db->like('Org_name', $key);
			
			$query = $this->db->get();
			return $query->result();
		}*/

		public function search_autocomplete($data){	
			$key = $data['key'];
			
			$this->db->select('*');
			$this->db->from('Academy_Info');
			$this->db->like('Aca_name', $key);
			
			$query = $this->db->get();
			return $query->result();
		}

		public function is_activated($code){
			$query = $this->db->query("SELECT IsUserActivation FROM Users WHERE ActivationCode = '$code'");
			$res = $query->row_array();
			return $res['IsUserActivation'];
		}

		public function insert_third_party_user($data)
		{
			$lat_long  = $data['latt'];
			$pieces	   = explode("@", $lat_long);
			
			$latitude = $pieces[0];
			$longitude = $pieces[1];

			$firstname = $data['fname'];
			$lastname  = $data['lname'];
			$email	   = $data['email'];

			if($data['gender'] == "M" or $data['gender'] == "Male" or $data['gender'] == "male" or $data['gender'] == "1"){
			$gender = 1;
			}
			else if($data['gender'] == "F" or $data['gender'] == "Female" or $data['gender'] == "female" or $data['gender'] == "0"){
			$gender = 0;
			}

			$dob = $data['dob'];
			
			$birthdate = date('Y-m-d',strtotime($dob));

			$birth = new DateTime($birthdate);
			$today = new DateTime('today');
			$age   = $birth->diff($today)->y;
			
			if ($age <= 12){ 
				$age_group = "U12";
			}
			else if ($age <= 14){
				$age_group = "U14";
			} 
			else if ($age <= 16){
				$age_group = "U16";
			}
			else if($age <= 18){
				$age_group = "U18";
			}
			else{
				$age_group = "Adults";
			}

			$mphone = $data['phone'];
			
			$add = $data['address'];
		    $city = $data['city'];
		    $state = $data['state'];
		    $country = $data['country'];
		
			$zip = $data['zipcode'];
			
			$reg_date = date("Y-m-d h:i:s");
			$code = md5($email);
			$token_code = substr($code, 0, 16);

			$issocial = 0 ;
			$is_user_activation = 1 ;
			$is_profile_updated = 1 ;
			
			$data = array(
					'Firstname' => $firstname,
					'Lastname'  => $lastname,
					'EmailID'	=> $email,
					'Gender'	=> $gender,
					'DOB'		=> $dob,
					'Mobilephone'		=> $mphone,
					'UserAddressline1'  => $add,
					'Country'	=> $country,
					'State'		=> $state,
					'City'		=> $city,
					'Zipcode'	=> $zip ,
					'Latitude'	=> $latitude ,
					'Longitude' => $longitude ,
					'Ext_token' => $token_code,
					'IsUserActivation'  => $is_user_activation,
					'Issociallogin'		=> $issocial,
					'RegistrationDtTm'  => $reg_date ,
					'IsProfileUpdated'  => $is_profile_updated,
					'UserAgegroup'		=> $age_group
				);

			$check_email = $this->check_email($email);

			if($check_email){			
				$exist = "A Player account with this EmailID ($email) is already exist!";
				return $exist;
			}
			else {
			$this->db->insert('Users', $data);
		    $insert_id = $this->db->insert_id();
			
			$sports = array("1", "2", "3", "4","5","6","7","8","9","19","20");           // these numbers belongs to sport id in the SportType Table
			foreach($sports as $type){
						$def_score = 100;

						if($type == '2')
						$def_score = 800;

					if($type == '7' or $type == '19' or $type == '20')
						$def_score = 3.0;

				$data = array('SportsType_ID' => $type, 
							  'Users_ID'	  => $insert_id, 
							  'A2MScore'	  => $def_score,
							  'A2MScore_Doubles' => $def_score,
							  'A2MScore_Mixed'	 => $def_score,
							 );

				$this->db->insert('A2MScore', $data);
		    }
     
			//$data = array('token'=>$token_code, 'Users_ID'=>$insert_id);
			return $token_code;
			}
		}

		public function check_email($email)
		{
			$data = array('EmailID'=> $email);
			$result = $this->db->get_where('Users',$data);

			if ($result->num_rows > 0){
				return true;
			}
			else{
				return false;
			}
		}

		public function get_intrests()
		{
			$query = $this->db->get('SportsType');
			return $query->result();
		}

		public function get_email($email)
		{
//echo "<alert>$email</alert>";
			$data = array('EmailID'=> $email);
			$result = $this->db->get_where('Users',$data);

			if ($result->num_rows > 0){
				return true;
			}
			else{
				return false;
			}
		}

		public function ajax_check_email($email)
		{
//echo "<alert>$email</alert>";
			$data = array('EmailID'=> $email);
			$result = $this->db->get_where('Users',$data);

			if ($result->num_rows > 0){
				return $result->row_array();
			}
			else{
				return false;
			}
		}
	
		public function get_org_url($org_url)
		{
			$data = array('Url_Shortcode'=> $org_url);
			$result = $this->db->get_where('Academy',$data);

			if ($result->num_rows > 0){
				return true;
			}
			else{
				return false;
			}
		}
	
		public function get_countries(){
			$query = $this->db->get('Country');
			return $query->result();
		}

		public function get_states($country_id){
			$data = array('countryID'=>$country_id,'StatusID'=>1);
			$query = $this->db->get_where('state',$data);
			//$query = $this->db->get_where('StatusID',$data);
			return $query->result();
		}
		
		public function get_cities($country_id){
			$data = array('countryID'=>$country_id);
			$query = $this->db->get_where('City',$data);
			return $query->result();
		}

		// registered user ,get the validation email link ... 
		private function send_validation_email(){
		
			$this->load->library('email');
			$this->email->set_newline("\r\n");
			
			$email = $this->session->userdata('EmailID');
		
			$sql = "SELECT Users_ID , RegistrationDtTm FROM users WHERE EmailID = '" .$email . "' LIMIT 1";
			$result = $this->db->query($sql);
			$row = $result->row();
		//	$this->email_code = md5((string)$row->reg_time);
		
		//	$email_code = $this->email_code ;

			$email_code = md5((string)$row->RegistrationDtTm);
			
			$this->email->set_mailtype('html');
			$this->email->from('rajkamal.kosaraju@gmail.com', 'A2mSports');
			$this->email->to($email);
			$this->email->subject('Please activate your account at our website');
			
			$message = '<!DOCTYPE HTML>
						<html>
						<head>
						<meta http-equiv = "Content-type" content="text/html" charset=utf-8" />
						</head><body>';
		    $message .= '<p>Dear ' . $this->session->userdata('username') . ',</p>';
			
			//link we will send look like  register/validate_email/johnson@.com/6778dfknjkfgldfjgg
			
			$message .= '<p> Thanks for registering on our website ! .Please <strong><a href="' . base_url() .'register/validate_email/' . $email . '/' . $email_code . '">click here</a></strong> to activate your account .After you have activated your account , you will be log into website and start doing  business| </p>'; 
			
			$message .= '<p> Thank You !</p>';
			$message .= '<p> The team at A2msports</p>';
			$message .= '</body></html>';
			
			$this->email->message($message) ;
			$this->email->send();
			
		}

		public function validate_code123($code) {
		
			$sql	= "SELECT EmailID  FROM Users WHERE ActivationCode = '" .$code . "' ";
			$result = $this->db->query($sql);
			$row	= $result->row();
			
			if($result->num_rows() === 1 && $row->EmailID) {
				if(md5((string)$row->reg_time) === $email_code ){
					$result = $this->activate_account($email_address);
				}
				else{
					$result = false;
				}

				if($result === true ){
					return true;
				}
				else{
				// this should never happen
				echo ' There was an error when activating your account .Please contact the admin at  ' . $this->config->item('admin_email');
				return false;
				}
			} else {
			// this should never happen
			echo ' There was an error validating your email .Please contact admin at  ' . $this->config->item('admin_email');
			}
		}
			
		// set the session variables ...
	/*	private function set_session($username , $email ) {
		
			$sql = "SELECT user_id , reg_time FROM users WHERE email = '" .$email . "' LIMIT 1";
			$result = $this->db->query($sql);
			$row = $result->row();
			
			$sess_data = array(
					'user_id' => $row->user_id ,
					'username' => $row->username ,
					'email' => $row->email ,
					'logged_in' => 0
					
					);
			$this->email_code = md5((string)$row->reg_time);
			$this->session->set_userdata($sess_data);
		}*/
		
		
		//checking  the registered user ,when email address is same in the validation email link and then  activated the account  ...
		public function validate_code($code){
			$act_dt = date("Y-m-d h:i:s");
			$data = array('IsUserActivation' => '1',
						'ActivatedDtTm' => $act_dt);

			$this->db->where('ActivationCode', $code);
			$this->db->update('Users', $data);

			return true;
		}

		public function get_user_actcode($act_code){
			$data = array('ActivationCode' => $act_code);
			$query = $this->db->get_where('Users',$data);
			return $query->row_array();
		}

		public function instant_register($data){
			$lat_long	= $data['latt'];
			$pieces		= explode("@", $lat_long);
			
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];

			$reg_date	= date("Y-m-d h:i:s");

			$firstname	= ucfirst(strtolower($this->input->post('fname')));
			$lastname	= ucfirst(strtolower($this->input->post('lname')));

			$email			= $this->input->post('email');
			$phone			= $this->input->post('phone');
			$gender		= $this->input->post('gender');
			$zipcode		= $this->input->post('Zipcode');
			$sportstype  = $this->input->post('sportstype');
			
			if(!$sportstype){
				$sportstype = 10;
			}

			if($email)
				$str	   = md5($lastname . $email);
			else
				$str	   = md5($lastname . $phone);

			$auth_code = substr($str, 0, 8);
			$sp_code   = substr(base64_encode('instant'), 0, 4);
			
			$code = $auth_code . '_' . $sp_code;

			$data = array(
					'Firstname'		    => $firstname,
					'Lastname'		    => $lastname,
					'EmailID'				=> $email,
					'Mobilephone'	    => $phone,
					'Gender'				=> $gender,
					'Zipcode'				=> $zipcode ,
					'Latitude'				=> $latitude ,
					'Longitude'			=> $longitude ,
					'IsUserActivation'		=> 0,
					'ActivationCode'		=> $code,
					'RegistrationDtTm'	=> $reg_date
					);

			$this->db->insert('Users', $data);
		    $insert_id = $this->db->insert_id();

			if($insert_id){
				$user_det = array(
					'firstname' => $firstname,
					'lastname'  => $lastname,
					'email'		=> $email,
					'phone'     => $phone,
					'act_code'  => $code,
					'users_id'  => $insert_id);

				$data = array('Sport_id' => $sportstype, 'users_id' => $insert_id);
				$this->db->insert('Sports_Interests', $data); 

				$sports = $this->get_intrests();

				foreach($sports as $type){
					if($type->SportsType_ID != '10'){
						$def_score = 100;
						if($type->SportsType_ID == '2')
							$def_score = 800;
						if($type->SportsType_ID == '7' or $type->SportsType_ID == '19' or $type->SportsType_ID == '20')
							$def_score = 3.0;

						$data = array(
								'SportsType_ID' => $type->SportsType_ID, 
								'Users_ID'		=> $insert_id, 
								'A2MScore'		=> $def_score,
								'A2MScore_Doubles' => $def_score,
								'A2MScore_Mixed'   => $def_score
								);
						$this->db->insert('A2MScore', $data);
					}
				}
			}
			else{
				$user_det = 0;
			}

			return $user_det;
		}

		public function instant_clubmember($data){
			$lat_long	= $data['latt'];
			$pieces	= explode("@", $lat_long);
			
			$latitude	= $pieces[0];
			$longitude	= $pieces[1];

			$reg_date	= date("Y-m-d H:i:s");
			$cur_date	= date("Y-m-d");

			$firstname	= $this->input->post('txt_fname');
			$lastname	= $this->input->post('txt_lname');

			$email			= $this->input->post('txt_email');
			$phone			= $this->input->post('txt_phone');
			$gender		= $this->input->post('gender');
			$zipcode		= $this->input->post('Zipcode');
			$aca_id		= $this->input->post('Aca_ID');
			$aca_sport	= $this->input->post('Aca_Sport');
			$start_date	= NULL;
			$end_date	= NULL;

			$member_id	= NULL;
			$member_type = NULL;
			$member_freq  = NULL;


			if($this->input->post('membership_sd'))
				$start_date = date('Y-m-d', strtotime($this->input->post('membership_sd')));

			if($this->input->post('membership_ed'))
				$end_date  = date('Y-m-d', strtotime($this->input->post('membership_ed')));

			if($this->input->post('membership_id'))
				$member_id  = trim($this->input->post('membership_id'));

			if($this->input->post('membership_sport'))
				$aca_sport  = trim($this->input->post('membership_sport'));

			if($this->input->post('membership_type'))
				$member_type  = trim($this->input->post('membership_type'));

			if($this->input->post('membership_freq'))
				$member_freq  = trim($this->input->post('membership_freq'));

				$mem_status = 1;
			if($cur_date > $end_date and $end_date != "")
				$mem_status = 0;
			
			if(!$aca_sport){
				$aca_sport = 10;
			}

			//if($start_date)
			$str	   = md5($lastname . $email);
			$auth_code = substr($str, 0, 8);
			$sp_code   = substr(base64_encode('instant'), 0, 4);
			
			$code = $auth_code . '_' . $sp_code;

				$is_coach = 0;
				$coach_academy = NULL;

			if($this->input->post('is_coach')){
				$is_coach = 1;
				$coach_academy = $aca_id;
			}

			$data = array(
					'Firstname'		    => $firstname,
					'Lastname'		    => $lastname,
					'EmailID'				=> $email,
					'Mobilephone'	=> $phone,
					'Gender'             => $gender,
					'Zipcode'            => $zipcode ,
					'Latitude'           => $latitude ,
					'Longitude'				=> $longitude ,
					'IsUserActivation'	=> 0,
					'ActivationCode'	=> $code,
					'Is_coach'				=> $is_coach,
					'coach_academy'	=> $coach_academy,
					'RegistrationDtTm'  => $reg_date
					);

			$this->db->insert('Users', $data);
		    $insert_id = $this->db->insert_id();

			if($insert_id){
				$user_det = array(
					'firstname' => $firstname,
					'lastname'  => $lastname,
					'email'		=> $email,
					'phone'     => $phone,
					'act_code'  => $code,
					'users_id'  => $insert_id);

				$data = array('Sport_id' => $aca_sport, 'users_id' => $insert_id);
				$this->db->insert('Sports_Interests', $data); 

				//$sports = $this->get_intrests();

				//foreach($sports as $type){
					//if($type->SportsType_ID == $aca_sport){
						$def_score = 100;
						if($aca_sport == '2')
							$def_score = 800;
						if($aca_sport == '7' or $aca_sport == '19' or $aca_sport == '20')
							$def_score = 3.0;

						$data = array(
								'SportsType_ID'		 => $aca_sport, 
								'Users_ID'				 => $insert_id, 
								'A2MScore'				 => $def_score,
								'A2MScore_Doubles' => $def_score,
								'A2MScore_Mixed'    => $def_score
								);
						$this->db->insert('A2MScore', $data);
					//}
				//}

				if(!$this->input->post('mem_code')){
				$club_det = array(
					'Club_id'				=> $aca_id,
					'Users_id'			=> $insert_id,
					'Membership_ID' => $member_id,
					'Member_Status' => $mem_status,
					'Member_type'	=> $member_type,
					'Member_freq'		=> $member_freq,
					'StartDate'			=> $start_date,
					'EndDate'			=> $end_date,
					'Related_Sport'	=> $aca_sport);
				}
				else{
				$club_det = array(
					'Club_id'				=> $aca_id,
					'Users_id'			=> $insert_id,
					'Membership_ID' => $member_id,
					'Member_Status' => $mem_status,
					//'Member_type'	=> $member_type,
					'Membership_Code'		=> $this->input->post('mem_code'),
					'StartDate'			=> $start_date,
					'EndDate'			=> $end_date,
					'Related_Sport'	=> $aca_sport);
				}

				$this->db->insert('User_memberships', $club_det); 
			}
			else{
				$user_det = 0;
			}

			return $user_det;
		}

		public function upd_instant_clubmember($data){
			$user_image = $data['profile_pic_data'];
			$users_id	= $data['users_id'];

			$data2 = array('Profilepic' => $user_image['file_name']);

			$this->db->where('Users_ID', $users_id);
			$this->db->update('Users', $data2);
		}

		public function profile_update($data)
		{
			$user_id    = $this->input->post('user');
			$act_code   = $this->input->post('act');
			
			$password   = $this->input->post('txt_pwd');
			$dob		= $this->input->post('txt_dob');

			$birthdate	= new DateTime($dob);
			$today		= new DateTime('today');
			$age		= $birthdate->diff($today)->y;

			echo $age."<br>";
			
			if($age <= 12){ 
				$age_group = "U12";
			}
			else if($age <= 14){
				$age_group = "U14";
			}
			else if($age <= 16){
				$age_group = "U16";
			}
			else if($age <= 18){
				$age_group = "U18";
			}
			else{
				$age_group = "Adults";
			}

			$address1 = $this->input->post('UserAddressline1');
			$address2 = $this->input->post('UserAddressline2');

			$country = $this->input->post('CountryName');

			if($country == 'United States of America'){
				$state = $this->input->post('StateName');
			}
			else{
				$state = $this->input->post('StateName1');
			}

			$city = $this->input->post('CityName');
			$zip  = $this->input->post('zipcode');

			$ref_address =  $address1 . ' ' .  $country . ' ' .  $state . ' ' .  $city ;

			//Formatted address
			$formattedAddr = str_replace(' ','+',$ref_address);

			//Send request and receive json data by address
			$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key='.GEO_LOC_KEY); 

			$output1 = json_decode($geocodeFromAddr);
			
			$latitude  = 0.00; 
			$longitude = 0.00;
		
			//Get latitude and longitute from json data
			$latitude  = $output1->results[0]->geometry->location->lat; 
			$longitude = $output1->results[0]->geometry->location->lng;

			//$prefer = json_encode($this->input->post('pref'));

			$data = array(
					'Password'			=> md5($password),
					'DOB'				=> $dob,
					'UserAddressline1'	=> $address1,
					'UserAddressline2'	=> $address2,
					'Country'			=> $country,
					'State'				=> $state,
					'City'				=> $city,
					'Zipcode'			=> $zip,
					'Latitude'			=> $latitude,
					'Longitude'			=> $longitude,
					'UserAgegroup'		=> $age_group);

			$this->db->where(array('Users_ID' => $user_id, 'ActivationCode' => $act_code));
			$result = $this->db->update('Users', $data);
		
			return $result;
		}

		public function Update_email_unsubscribe(){
            //$notifysettings = array();
			//$post_notify_settings = $this->input->post('notify_settings');
			$sports = $this->input->post('sports');
			$user_id = $this->input->post('user_id');

			/*if(array_key_exists('NT', $post_notify_settings)){
               $notifysettings['NT'] = 1;
			}else{
			   $notifysettings['NT'] = 0;
 
 			}
 			if(array_key_exists('Admin', $post_notify_settings)){
               $notifysettings['Admin'] = 1;
			}else{
			   $notifysettings['Admin'] = 0;
 
 			}
 			if(array_key_exists('News', $post_notify_settings)){
               $notifysettings['News'] = 1;
			}else{
			   $notifysettings['News'] = 0;
 
 			}

            $NotifySettings = json_encode($notifysettings);*/
            $NotifySports = json_encode($sports);

 			$data = array('NotifySports' => $NotifySports	
						);
           
            $this->db->where('Users_ID', $user_id);
            $result = $this->db->update('Users', $data);
            return $data;
		}
	

		public function get_missing_geo_users(){
			$data = array('Longitude' => NULL);
			$result = $this->db->get_where('Users', $data);

			return $result->result();
		}

		public function update_user_geo($uid, $latt, $longitude){
			
			$data = array('Latitude' => $latt ,
					'Longitude' => $longitude);

            $this->db->where('Users_ID', $uid);
            $result = $this->db->update('Users', $data);
		}

		public function update_tshirt_size($uid, $ts){
			$data = array('TShirt_Size' => $ts);

            $this->db->where('Users_ID', $uid);
            $result = $this->db->update('Users', $data);		
		}

		public function get_sports(){
			$users_id = $this->session->userdata('users_id');
			$data = array('users_id'=>$users_id);
			$get_name = $this->db->get_where('Sports_Interests',$data);
			return $get_name->result();
		}

		public function get_all($data){
			($data['lat']=="") ? $lat = 0 : $lat = $data['lat'];
			($data['long']=="") ? $long = 0 : $long = $data['long'];
			
			$range = $data['range'];

			$sports = array();
			$sports = $data['interests'];
			$items = count(array_filter($sports));

			$i = 0;
			if($items > 0)
			{
				$xyz = "";
				foreach($sports as $row){
					$xyz .= "'$row->Sport_id'";

						if(++$i != $items) {
							$xyz .= ",";
						}
				}

				$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
				* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < 10  AND  SportsType IN ($xyz) ORDER BY distance");
			} 
			else{
				$qry_check = $this->db->query("SELECT *, ACOS( SIN( RADIANS( Latitude ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) )
				* COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 AS distance FROM tournament WHERE ACOS( SIN( RADIANS( Latitude )) * SIN( RADIANS( $lat ) ) + COS( RADIANS( Latitude ) ) * COS( RADIANS( $lat )) * COS( RADIANS( Longitude ) - RADIANS( $long )) ) * 3964.3 < 10 ORDER BY distance , StartDate ASC");
			}

			return $qry_check->result();
		}

}