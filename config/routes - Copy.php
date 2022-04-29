<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

	require_once( BASEPATH .'database/DB'. EXT );
	$db =& DB();
	$query = $db->get('Academy_Info');
	$result = $query->result();
	foreach( $result as $row )
	{
		if($row->Aca_URL_ShortCode){

		$short_code_upper = strtoupper($row->Aca_URL_ShortCode);
		$short_code_lower = strtolower($row->Aca_URL_ShortCode);

/* ********************************************************************************************************************** */

		$route[$short_code_upper]  = "academy_ctrl/academy/details/$row->Aca_ID";

		$route[$short_code_upper.'/admin']		  = "academy_ctrl/admin/$row->Aca_ID";

		$route[$short_code_upper.'/courts/reserve']		  = "academy_ctrl/courts/reserve/$row->Aca_ID";
		$route[$short_code_upper.'/courts/reserve/(:any)'] = "academy_ctrl/courts/reserve/$row->Aca_ID";
		$route[$short_code_upper.'/courts/list']			  = "academy_ctrl/courts/courts_list/$row->Aca_ID";
		$route[$short_code_upper.'/courts/add']			  = "academy_ctrl/courts/add_court/$row->Aca_ID";
		$route[$short_code_upper.'/courts/update']		  = "academy_ctrl/courts/update_court/$row->Aca_ID";
		$route[$short_code_upper.'/courts/get_loc_courts'] = "academy_ctrl/courts/get_loc_courts";
		$route[$short_code_upper.'/courts/get_loc_info']	  = "academy_ctrl/courts/get_loc_info";
		$route[$short_code_upper.'/courts/get_court_reservations']   = "academy_ctrl/courts/get_court_reservations";
		$route[$short_code_upper.'/courts/get_reserve_popup']   = "academy_ctrl/courts/get_reserve_popup";
		$route[$short_code_upper.'/courts/get_court_durations']   = "academy_ctrl/courts/get_court_durations";
		$route[$short_code_upper.'/courts/check_court_availability']	= "academy_ctrl/courts/check_court_availability";
		$route[$short_code_upper.'/courts/block_court']	  = "academy_ctrl/courts/block_court";
		$route[$short_code_upper.'/courts/paypal_success']	  = "academy_ctrl/courts/paypal_success";
		$route[$short_code_upper.'/courts/paypal_cancel']	  = "academy_ctrl/courts/paypal_cancel";

		//$route[$short_code_upper.'/league']				  = "academy_ctrl/league/index/$row->Aca_ID";
		$route[$short_code_upper.'/league']				  = "league/index";
		$route[$short_code_upper.'/league/(:num)']		  = "academy_ctrl/league/$row->Aca_ID";
		$route[$short_code_upper.'/league/create_trnmt']	  = "academy_ctrl/league/create_trnmt/$row->Aca_ID";
		//$route[$short_code_upper.'/league/view/(:num)']	  = "academy_ctrl/league/view/$1/$row->Aca_ID";
		//$route[$short_code_upper.'/league/view/(:num)/(:num)'] = "academy_ctrl/league/view/$1/$row->Aca_ID/$1";
		$route[$short_code_upper.'/league/view/(:num)']		 = "league/viewtournament/$1";
		$route[$short_code_upper.'/league/view/(:num)/(:num)'] = "league/viewtournament/$1";
		$route[$short_code_upper.'/league/view_matches']	  = "academy_ctrl/league/view_matches/$row->Aca_ID";
		$route[$short_code_upper.'/league/fixtures/(:num)'] = "academy_ctrl/league/fixtures/$1/$row->Aca_ID";
		$route[$short_code_upper.'/league/bracket/(:num)']  = "academy_ctrl/league/bracket/$1/$row->Aca_ID";
		$route[$short_code_upper.'/league/bracket_save']	  = "academy_ctrl/league/bracket_save/$row->Aca_ID";
		$route[$short_code_upper.'/league/send_email_reg_players'] = "academy_ctrl/league/send_email_reg_players";
		$route[$short_code_upper.'/league/upload_pics']	  = "academy_ctrl/league/upload_pics";
		$route[$short_code_upper.'/league/get_gallery']	  = "academy_ctrl/league/get_gallery";
		$route[$short_code_upper.'/league/register_match/(:num)'] = "academy_ctrl/league/register_match/$1/$row->Aca_ID";
		$route[$short_code_upper.'/league/buy/(:num)']	  = "academy_ctrl/league/buy/$1/$row->Aca_ID";
		$route[$short_code_upper.'/league/uprofile/']		  = "academy_ctrl/league/buy/$row->Aca_ID";
		$route[$short_code_upper.'/league/get_tour_fee/']	  = "academy_ctrl/league/get_tour_fee/$row->Aca_ID";

		$route[$short_code_upper.'/events/create']		  = "academy_ctrl/events/create/$row->Aca_ID";
		$route[$short_code_upper.'/facility']		  	  = "academy_ctrl/facility/index/$row->Aca_ID";
		$route[$short_code_upper.'/facility/update_facility']	 = "academy_ctrl/facility/update_facility/$row->Aca_ID";
		$route[$short_code_upper.'/facility/update_lt_team']	 = "academy_ctrl/facility/update_lt_team/$row->Aca_ID";
		$route[$short_code_upper.'/facility/update_ps_team']	 = "academy_ctrl/facility/update_ps_team/$row->Aca_ID";
		$route[$short_code_upper.'/facility/add_glry_images']	 = "academy_ctrl/facility/add_glry_images/$row->Aca_ID";
		$route[$short_code_upper.'/facility/delete_glry']	 = "academy_ctrl/facility/delete_glry/$row->Aca_ID";

		$route[$short_code_upper.'/teams/addnew']				= "academy_ctrl/teams/addnew/$row->Aca_ID";
		$route[$short_code_upper.'/teams/get_tour_reg_team']  = "academy_ctrl/teams/get_tour_reg_team/$row->Aca_ID";

		$route[$short_code_upper.'/paypal/success']  = "academy_ctrl/paypal/success";
		$route[$short_code_upper.'/paypal/cancel']   = "academy_ctrl/paypal/cancel";

		$route[$short_code_upper.'/viewbracket']	   = "academy_ctrl/league/viewbracket/$row->Aca_ID";

		//$route[$short_code_upper.'/view_matches/(:any)']	 = "academy/view_matches/$row->Aca_ID";

		//$route[$short_code_upper.'/league/(:num)/create_trnmt'] = "academy/create_trnmt/$row->Aca_ID";
		$route[$short_code_upper.'/coaches']				 = "academy_ctrl/academy/coaches_list/$row->Aca_ID";
		$route[$short_code_upper.'/search_coaches']		 = "academy_ctrl/academy/search_coaches";
		$route[$short_code_upper.'/members']				 = "academy_ctrl/academy/member_list/$row->Aca_ID";
		$route[$short_code_upper.'/search_member']		 = "academy_ctrl/academy/players";
		$route[$short_code_upper.'/search_members']		 = "academy_ctrl/academy/search_members";
		$route[$short_code_upper.'/search/autocomplete']	 = "academy_ctrl/search/autocomplete";

		$route[$short_code_upper.'/show_res/(:any)']	 = "academy_ctrl/academy/show_res/$row->Aca_ID/$1";

		$route[$short_code_upper.'/calendar']					 = "academy_ctrl/calendar/index/$row->Aca_ID";
		$route[$short_code_upper.'/calendar/process/(:num)']	 = "academy_ctrl/calendar/process/$1";
		
		$route[$short_code_upper.'/opponent']			 = "academy_ctrl/opponent/index/$row->Aca_ID";
		$route[$short_code_upper.'/opponent/create']	 = "academy_ctrl/opponent/create/$row->Aca_ID";

		$route[$short_code_upper.'/play/reg_players/(:num)']	= "academy_ctrl/play/reg_players/$1/$row->Aca_ID";
		$route[$short_code_upper.'/play/invite/(:num)']		= "academy_ctrl/play/invite/$1/$row->Aca_ID";
		$route[$short_code_upper.'/play/invite_email']		= "academy_ctrl/play/invite_email/$row->Aca_ID";

		$route[$short_code_upper.'/events/add']			 = "academy_ctrl/events/add/$row->Aca_ID";
		$route[$short_code_upper.'/events/view/(:num)/(:num)'] = "academy_ctrl/events/view/$1/$1/$row->Aca_ID";
		$route[$short_code_upper.'/events/view/(:num)']	 = "academy_ctrl/events/view/$1/$row->Aca_ID";
		$route[$short_code_upper.'/events/autocomplete']	 = "academy_ctrl/events/autocomplete/$row->Aca_ID";
		$route[$short_code_upper.'/events/add_fields']		 = "academy_ctrl/events/add_fields/$row->Aca_ID";
		$route[$short_code_upper.'/events/add_fields_weekly']	 = "academy_ctrl/events/add_fields_weekly/$row->Aca_ID";

		$route[$short_code_upper.'/news']				 = "academy_ctrl/news/index";
		$route[$short_code_upper.'/news/add']			 = "academy_ctrl/news/add";
		$route[$short_code_upper.'/news/add_news']		 = "academy_ctrl/news/add_news";
		$route[$short_code_upper.'/news/edit/(:num)']	 = "academy_ctrl/news/edit/$1";
		$route[$short_code_upper.'/news/view/(:num)']	 = "academy_ctrl/news/get_news_detail/$1";
		$route[$short_code_upper.'/news/update/(:num)']= "academy_ctrl/news/update_news/$1";

		$route[$short_code_upper.'/update_menu']		 = "academy_ctrl/academy/update_act_menu/$row->Aca_ID";

/* ********************************************************************************************************************** */

		$route[$short_code_lower]  = "academy_ctrl/academy/details/$row->Aca_ID";

		$route[$short_code_lower.'/admin']		  = "academy_ctrl/admin/index/$row->Aca_ID";

		$route[$short_code_lower.'/courts/reserve']		  = "academy_ctrl/courts/reserve/$row->Aca_ID";
		$route[$short_code_lower.'/courts/reserve/(:any)'] = "academy_ctrl/courts/reserve/$row->Aca_ID";
		$route[$short_code_lower.'/courts/list']			  = "academy_ctrl/courts/courts_list/$row->Aca_ID";
		$route[$short_code_lower.'/courts/add']			  = "academy_ctrl/courts/add_court/$row->Aca_ID";
		$route[$short_code_lower.'/courts/update']		  = "academy_ctrl/courts/update_court/$row->Aca_ID";
		$route[$short_code_lower.'/courts/get_loc_courts'] = "academy_ctrl/courts/get_loc_courts";
		$route[$short_code_lower.'/courts/get_loc_info']	  = "academy_ctrl/courts/get_loc_info";
		$route[$short_code_lower.'/courts/get_court_reservations']   = "academy_ctrl/courts/get_court_reservations";
		$route[$short_code_lower.'/courts/get_reserve_popup']   = "academy_ctrl/courts/get_reserve_popup";
		$route[$short_code_lower.'/courts/get_court_durations']   = "academy_ctrl/courts/get_court_durations";
		$route[$short_code_lower.'/courts/check_court_availability']	= "academy_ctrl/courts/check_court_availability";
		$route[$short_code_lower.'/courts/block_court']	  = "academy_ctrl/courts/block_court";
		$route[$short_code_lower.'/courts/paypal_success']	  = "academy_ctrl/courts/paypal_success";
		$route[$short_code_lower.'/courts/paypal_cancel']	  = "academy_ctrl/courts/paypal_cancel";

		//$route[$short_code_lower.'/league']				  = "academy_ctrl/league/index/$row->Aca_ID";
		$route[$short_code_lower.'/league']				  = "league/index";
		$route[$short_code_lower.'/league/(:num)']		  = "academy_ctrl/league/$row->Aca_ID";
		$route[$short_code_lower.'/league/create_trnmt']	  = "academy_ctrl/league/create_trnmt/$row->Aca_ID";
		//$route[$short_code_lower.'/league/view/(:num)']	  = "academy_ctrl/league/view/$1/$row->Aca_ID";
		//$route[$short_code_lower.'/league/view/(:num)/(:num)'] = "academy_ctrl/league/view/$1/$row->Aca_ID/$1";
		$route[$short_code_lower.'/league/view/(:num)']		 = "league/viewtournament/$1";
		$route[$short_code_lower.'/league/view/(:num)/(:num)'] = "league/viewtournament/$1";
		$route[$short_code_lower.'/league/view_matches']	  = "academy_ctrl/league/view_matches/$row->Aca_ID";
		$route[$short_code_lower.'/league/fixtures/(:num)'] = "academy_ctrl/league/fixtures/$1/$row->Aca_ID";
		$route[$short_code_lower.'/league/bracket/(:num)']  = "academy_ctrl/league/bracket/$1/$row->Aca_ID";
		$route[$short_code_lower.'/league/bracket_save']	  = "academy_ctrl/league/bracket_save/$row->Aca_ID";
		$route[$short_code_lower.'/league/send_email_reg_players'] = "academy_ctrl/league/send_email_reg_players";
		$route[$short_code_lower.'/league/upload_pics']	  = "academy_ctrl/league/upload_pics";
		$route[$short_code_lower.'/league/get_gallery']	  = "academy_ctrl/league/get_gallery";
		$route[$short_code_lower.'/league/register_match/(:num)'] = "academy_ctrl/league/register_match/$1/$row->Aca_ID";
		$route[$short_code_lower.'/league/buy/(:num)']	  = "academy_ctrl/league/buy/$1/$row->Aca_ID";
		$route[$short_code_lower.'/league/uprofile/']		  = "academy_ctrl/league/buy/$row->Aca_ID";
		$route[$short_code_lower.'/league/get_tour_fee/']	  = "academy_ctrl/league/get_tour_fee/$row->Aca_ID";

		$route[$short_code_lower.'/events/create']		  = "academy_ctrl/events/create/$row->Aca_ID";
		$route[$short_code_lower.'/events']			  = "academy_ctrl/events/index/$row->Aca_ID";
		$route[$short_code_lower.'/facility']		  	  = "academy_ctrl/facility/index/$row->Aca_ID";
		$route[$short_code_lower.'/facility/update_facility']	 = "academy_ctrl/facility/update_facility/$row->Aca_ID";
		$route[$short_code_lower.'/facility/update_lt_team']	 = "academy_ctrl/facility/update_lt_team/$row->Aca_ID";
		$route[$short_code_lower.'/facility/update_ps_team']	 = "academy_ctrl/facility/update_ps_team/$row->Aca_ID";
		$route[$short_code_lower.'/facility/add_glry_images']	 = "academy_ctrl/facility/add_glry_images/$row->Aca_ID";
		$route[$short_code_lower.'/facility/delete_glry']			 = "academy_ctrl/facility/delete_glry/$row->Aca_ID";

		$route[$short_code_lower.'/teams/addnew']				= "academy_ctrl/teams/addnew/$row->Aca_ID";
		$route[$short_code_lower.'/teams/get_tour_reg_team']  = "academy_ctrl/teams/get_tour_reg_team/$row->Aca_ID";

		$route[$short_code_lower.'/paypal/success']  = "academy_ctrl/paypal/success";
		$route[$short_code_lower.'/paypal/cancel']   = "academy_ctrl/paypal/cancel";

		$route[$short_code_lower.'/viewbracket']	   = "academy_ctrl/league/viewbracket/$row->Aca_ID";

		//$route[$short_code_lower.'/view_matches/(:any)']	 = "academy/view_matches/$row->Aca_ID";

		//$route[$short_code_lower.'/league/(:num)/create_trnmt'] = "academy/create_trnmt/$row->Aca_ID";
		$route[$short_code_lower.'/coaches']				 = "academy_ctrl/academy/coaches_list/$row->Aca_ID";
		$route[$short_code_lower.'/search_coaches']		 = "academy_ctrl/academy/search_coaches";
		$route[$short_code_lower.'/members']				 = "academy_ctrl/academy/member_list/$row->Aca_ID";
		$route[$short_code_lower.'/search_member']		 = "academy_ctrl/academy/players";
		$route[$short_code_lower.'/search_members']		 = "academy_ctrl/academy/search_members";
		$route[$short_code_lower.'/search/autocomplete']	 = "academy_ctrl/search/autocomplete";

		$route[$short_code_lower.'/show_res/(:any)']	 = "academy_ctrl/academy/show_res/$row->Aca_ID/$1";

		$route[$short_code_lower.'/calendar']					 = "academy_ctrl/calendar/index/$row->Aca_ID";
		$route[$short_code_lower.'/calendar/process/(:num)']	 = "academy_ctrl/calendar/process/$1";
		
		$route[$short_code_lower.'/opponent']			 = "academy_ctrl/opponent/index/$row->Aca_ID";
		$route[$short_code_lower.'/opponent/create']	 = "academy_ctrl/opponent/create/$row->Aca_ID";

		$route[$short_code_lower.'/play/reg_players/(:num)']	= "academy_ctrl/play/reg_players/$1/$row->Aca_ID";
		$route[$short_code_lower.'/play/invite/(:num)']		= "academy_ctrl/play/invite/$1/$row->Aca_ID";
		$route[$short_code_lower.'/play/invite_email']		= "academy_ctrl/play/invite_email/$row->Aca_ID";

		$route[$short_code_lower.'/events/add']			 = "academy_ctrl/events/add/$row->Aca_ID";
		$route[$short_code_lower.'/events/view/(:num)/(:num)'] = "academy_ctrl/events/view/$1/$1/$row->Aca_ID";
		$route[$short_code_lower.'/events/view/(:num)']	 = "academy_ctrl/events/view/$1/$row->Aca_ID";
		$route[$short_code_lower.'/events/autocomplete']	 = "academy_ctrl/events/autocomplete/$row->Aca_ID";
		$route[$short_code_lower.'/events/add_fields']		 = "academy_ctrl/events/add_fields/$row->Aca_ID";
		$route[$short_code_lower.'/events/add_fields_weekly']	 = "academy_ctrl/events/add_fields_weekly/$row->Aca_ID";

		$route[$short_code_lower.'/news']				 = "academy_ctrl/news/index";
		$route[$short_code_lower.'/news/add']			 = "academy_ctrl/news/add";
		$route[$short_code_lower.'/news/add_news']		 = "academy_ctrl/news/add_news";
		$route[$short_code_lower.'/news/edit/(:num)']	 = "academy_ctrl/news/edit/$1";
		$route[$short_code_lower.'/news/view/(:num)']	 = "academy_ctrl/news/get_news_detail/$1";
		$route[$short_code_lower.'/news/update/(:num)']= "academy_ctrl/news/update_news/$1";

		$route[$short_code_lower.'/update_menu']		 = "academy_ctrl/academy/update_act_menu/$row->Aca_ID";
/* ********************************************************************************************************************** */
	}
	}

	/* Tournament Landing Pages with shortcode*/
	$tourn = $db->get('tournament');
	$res = $tourn->result();
	foreach($res as $row){
		if($row->Short_Code != NULL){
			$route[ strtoupper($row->Short_Code) ]  = "league/tourn_land/".$row->tournament_ID;
			$route[ strtolower($row->Short_Code) ]  = "league/tourn_land/".$row->tournament_ID;
			$route[ $row->Short_Code ]				= "league/tourn_land/".$row->tournament_ID;
		}
	}
$route['3tleague']				= "league/tourn_land/1137";
//$route[ $row->Short_Code ]				= "league/tourn_land/".$row->tournament_ID;

	/* Tournament Landing Pages with shortcode*/

/* Sport Specific Pages */
	$sports		= $db->get('SportsType');
	$sports_res = $sports->result();

	foreach($sports_res as $row){
		if($row->ShortCode != NULL){
			//$route[ strtoupper($row->ShortCode) ]  = "league/league_list/".$row->SportsType_ID;
			$route[ strtolower($row->ShortCode) ]  = "league/league_list/".$row->SportsType_ID;
			//$route[ $row->ShortCode ]				= "league/league_list/".$row->SportsType_ID;
			$sp = ucfirst($row->ShortCode);
			$route["{$row->ShortCode}#(:any)"] = 'league/league_list/1';
			$route["{$row->ShortCode}/(:num)"] = 'league/viewtournament/$1';
			$route["{$sp}/(:num)"] = 'league/viewtournament/$1';

		}
	}

	$route["Table-Tennis/(:num)"] = 'league/viewtournament/$1';

/* Sport Specific Pages */

	$route['calendar/process/(:num)'] = "calendar/process/$1";

	$route['academy']			 = 'academy';

	$route['a2mteams']			 = 'teams/view/';
	$route['teams']				 = 'teams/view/';

	$route['default_controller'] = 'home';
	$route['help/content']		 = 'help/help_content';
	$route['help/demo']			 = 'help/req_demo';
	$route['news/(:num)']		 = 'news/get_news_detail/$1';
	$route['News/(:num)']		 = 'news/get_news_detail/$1';
	$route['terms_conditions']	 = 'league/terms_conditions';
	$route['league/get_tour_fee/']		    = 'league/get_tour_fee/';
	$route['league/drop_line_matchscore']	= 'league/drop_line_matchscore';
	$route['league/age_group_users/']= 'league/age_group_users/';
	$route['medical_form']		 = 'league/medical_form';
	$route['Contact-Us']		 = 'help/contactus';
	$route['Forgot-password']	 = 'login/forgot_password';
	$route['Reset-password']	 = 'login/reset_password';
	$route['reset/password/(:any)']	 = 'login/reset_password_form/$1';
	$route['player/(:num)']		 = 'search/player_details/$1';
	$route['coach/(:num)']		 = 'search/player_details/$1';
	//$route['league/Getteamplayers']	= 'league/Getteamplayers';
	$route['league/(:num)']		 = 'league/viewtournament/$1';
	$route['league/(:num)/(:num)'] = 'league/viewtournament/$1';
	$route['league/view/(:num)'] = 'league/viewtournament/$1';
	$route['league/view/(:any)'] = 'league/viewtournament/$1';
	$route['league/view/(:num)/(:num)'] = 'league/viewtournament/$1';
	$route['unsubscribe/(:any)'] = 'register/unsubscribe/$1';
	$route['league/update_payment'] = 'league/update_team_player_payment';
	$route['ratings/import'] = 'usatt_ratings/csv_import';
	$route['clubs/import']   = 'import_clubs/csv_import';

	$route['events/(:num)']		   = 'events/view/$1';
	$route['events/(:num)/(:any)'] = 'events/view/$1';

	$route['sponsor/(:num)']	= 'donate/sponsor/$1';
	$route['sponsor']			= 'donate/sponsor_now';
	$route['sponsor/success']	= 'donate/sponsor_success';
	$route['sponsor/sp_success']= 'donate/sp_success';
	$route['sponsor/cancel']	= 'donate/cancel';

  	$route['404_override']		 = 'Error404/error_page';
  	$route['league/UpdateLevels/'] = 'league/UpdateLevels/';
	$route['translate_uri_dashes'] = TRUE;

  	$route['scores/add'] = 'rest_services/scores/add';
  	$route['brackets']   = 'league/bracket_generator';
  	$route['ladder']	 = 'league/ladder';
  	$route['privacy']	 = 'home/priv_policy';
	$route['sports']	 = 'league/view_more_sports';

  	//$route['scores/add'] = 'rest_services/scores/user_get';

/* --------------------------- */

	//$route['default_controller'] = 'Error404/offline';


/* End of file routes.php */
/* Location: ./application/config/routes.php */