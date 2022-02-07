<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");
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
|	$route["default_controller"] = "welcome";
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route["404_override"] = "errors/page_missing";
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$segment = explode('/', $_SERVER['REQUEST_URI']);

if($segment[1] != 'rest_services') {
// -----------------------------------------------Dynamic Routing Begin------------------------------------------
	require_once( BASEPATH .'database/DB'. EXT );
	$db =& DB();
	$query = $db->where('Aca_URL_ShortCode', $segment[1]);
	$query = $db->get('Academy_Info');

	$row = $query->row_array();

	if($row){
		//echo "<pre>"; print_r($row); exit;
$route["$segment[1]"] = "academy_ctrl/academy/details/{$row['Aca_ID']}";
$route["$segment[1]/admin"]	 = "academy_ctrl/admin/{$row['Aca_ID']}";
$route["$segment[1]/settings"]	 = "academy_ctrl/admin/menu_settings/{$row['Aca_ID']}";
$route["$segment[1]/memberships"] = "academy_ctrl/admin/memberships/{$row['Aca_ID']}";
$route["$segment[1]/add_memberships"] = "academy_ctrl/admin/add_memberships/{$row['Aca_ID']}";
$route["$segment[1]/upd_memberships"] = "academy_ctrl/admin/upd_memberships/{$row['Aca_ID']}";
$route["$segment[1]/update_menu"]	 = "academy_ctrl/admin/update_menu/{$row['Aca_ID']}";
$route["$segment[1]/player/(:num)"]	 = "academy_ctrl/player/player_details/$1/{$row['Aca_ID']}";
$route["$segment[1]/membership/paynow/(:num)"]	 = "academy_ctrl/membership/paynow/$1";
$route["$segment[1]/membership/ot_success/(:num)"]	 = "academy_ctrl/membership/ot_success/{$row['Aca_ID']}/$1";
$route["$segment[1]/courts/reserve"] = "academy_ctrl/courts/reserve/{$row['Aca_ID']}";
$route["$segment[1]/courts/reserve/(:any)"] = "academy_ctrl/courts/reserve/{$row['Aca_ID']}";
$route["$segment[1]/courts/list"] = "academy_ctrl/courts/courts_list/{$row['Aca_ID']}";
$route["$segment[1]/courts/add"] = "academy_ctrl/courts/add_court/{$row['Aca_ID']}";
$route["$segment[1]/courts/update"] = "academy_ctrl/courts/update_court/{$row['Aca_ID']}";
$route["$segment[1]/courts/get_loc_courts"] = "academy_ctrl/courts/get_loc_courts";
$route["$segment[1]/courts/get_loc_info"]	  = "academy_ctrl/courts/get_loc_info";
$route["$segment[1]/courts/get_court_reservations"]   = "academy_ctrl/courts/get_court_reservations";
$route["$segment[1]/courts/get_reserve_popup"]   = "academy_ctrl/courts/get_reserve_popup";
$route["$segment[1]/courts/get_court_durations"]   = "academy_ctrl/courts/get_court_durations";
$route["$segment[1]/courts/check_court_availability"]	= "academy_ctrl/courts/check_court_availability";
$route["$segment[1]/courts/block_court"]	  = "academy_ctrl/courts/block_court";
$route["$segment[1]/courts/paypal_success"]	  = "academy_ctrl/courts/paypal_success";
$route["$segment[1]/courts/paypal_cancel"]	  = "academy_ctrl/courts/paypal_cancel";
$route["$segment[1]/league"]				  = "league/index";
$route["$segment[1]/league/create_trnmt"]	  = "academy_ctrl/league/create_trnmt/{$row['Aca_ID']}";
$route["$segment[1]/league/register_match/(:num)"] = "academy_ctrl/league/register_match/$1/{$row['Aca_ID']}";
$route["$segment[1]/league/(:num)"]				= "academy_ctrl/league/viewtournament/$1/{$row['Aca_ID']}";
$route["$segment[1]/league/(:num)/(:num)"] = "academy_ctrl/league/viewtournament/$1/{$row['Aca_ID']}/$1";
$route["$segment[1]/league/edit/(:num)"]	= "academy_ctrl/league/edit/$1/{$row['Aca_ID']}";
$route["$segment[1]/league/reg_players/(:num)"] = "academy_ctrl/league/reg_players/$1/{$row['Aca_ID']}";
$route["$segment[1]/league/update_trnmt"]			= "academy_ctrl/league/update_trnmt/$1/{$row['Aca_ID']}";
$route["$segment[1]/league/view_matches"]	  = "academy_ctrl/league/view_matches/{$row['Aca_ID']}";
$route["$segment[1]/league/fixtures/(:num)"] = "academy_ctrl/league/fixtures/$1/{$row['Aca_ID']}";
$route["$segment[1]/league/bracket/(:num)"]  = "academy_ctrl/league/bracket/$1/{$row['Aca_ID']}";
$route["$segment[1]/league/bracket_save"]	  = "academy_ctrl/league/bracket_save/{$row['Aca_ID']}";
$route["$segment[1]/league/send_email_reg_players"] = "academy_ctrl/league/send_email_reg_players";
$route["$segment[1]/league/upload_pics"]	  = "academy_ctrl/league/upload_pics";
$route["$segment[1]/league/get_gallery"]	  = "academy_ctrl/league/get_gallery";
$route["$segment[1]/league/buy/(:num)"]	  = "academy_ctrl/league/buy/$1/{$row['Aca_ID']}";
$route["$segment[1]/league/uprofile"]		  = "academy_ctrl/league/uprofile/{$row['Aca_ID']}";
$route["$segment[1]/league/get_tour_fee/"]	  = "academy_ctrl/league/get_tour_fee/{$row['Aca_ID']}";
$route["$segment[1]/events/create"]					 = "academy_ctrl/events/create/{$row['Aca_ID']}";
$route["$segment[1]/facility"]		  					 = "academy_ctrl/facility/index/{$row['Aca_ID']}";
$route["$segment[1]/facility/add_banner"]  = "academy_ctrl/facility/add_banner/{$row['Aca_ID']}";
$route["$segment[1]/facility/update_facility"]		 = "academy_ctrl/facility/update_facility/{$row['Aca_ID']}";
$route["$segment[1]/facility/update_lt_team"]	 = "academy_ctrl/facility/update_lt_team/{$row['Aca_ID']}";
$route["$segment[1]/facility/update_ps_team"]	 = "academy_ctrl/facility/update_ps_team/{$row['Aca_ID']}";
$route["$segment[1]/facility/add_glry_images"]	 = "academy_ctrl/facility/add_glry_images/{$row['Aca_ID']}";
$route["$segment[1]/facility/delete_glry"]			 = "academy_ctrl/facility/delete_glry/{$row['Aca_ID']}";
$route["$segment[1]/pricing"]							 = "academy_ctrl/pricing/index/{$row['Aca_ID']}";
$route["$segment[1]/pricing/update"]				 = "academy_ctrl/pricing/update_pricing/{$row['Aca_ID']}";
$route["$segment[1]/logout"]							 = "academy_ctrl/logout/index/{$row['Aca_ID']}";
$route["$segment[1]/proshop"]		  				 = "academy_ctrl/proshop/index/{$row['Aca_ID']}";
$route["$segment[1]/proshop/add_proshop_items"]	 = "academy_ctrl/proshop/add_proshop_items/{$row['Aca_ID']}";
$route["$segment[1]/proshop/delete_product"]	 = "academy_ctrl/proshop/delete_product/{$row['Aca_ID']}";
$route["$segment[1]/teams/addnew"]					= "academy_ctrl/teams/addnew/{$row['Aca_ID']}";
$route["$segment[1]/teams/get_tour_reg_team"]	= "academy_ctrl/teams/get_tour_reg_team/{$row['Aca_ID']}";
$route["$segment[1]/paypal/success"]  = "academy_ctrl/paypal/success";
$route["$segment[1]/paypal/cancel"]   = "academy_ctrl/paypal/cancel";
$route["$segment[1]/viewbracket"]	   = "academy_ctrl/league/viewbracket/{$row['Aca_ID']}";
$route["$segment[1]/get_membership"]	   = "academy_ctrl/academy/get_membership/{$row['Aca_ID']}";
$route["$segment[1]/upd_membership"]	   = "academy_ctrl/academy/upd_membership/{$row['Aca_ID']}";
$route["$segment[1]/coaches"]				 = "academy_ctrl/academy/coaches_list/{$row['Aca_ID']}";
$route["$segment[1]/search_coaches"]		 = "academy_ctrl/academy/search_coaches";
$route["$segment[1]/members"]				 = "academy_ctrl/academy/member_list/{$row['Aca_ID']}";
$route["$segment[1]/search_member"]		 = "academy_ctrl/academy/players";
$route["$segment[1]/search_members"]		 = "academy_ctrl/academy/search_members";
$route["$segment[1]/search/autocomplete"]	 = "academy_ctrl/search/autocomplete";
$route["$segment[1]/show_res/(:any)"]	 = "academy_ctrl/academy/show_res/{$row['Aca_ID']}/$1";
$route["$segment[1]/calendar"]					 = "academy_ctrl/calendar/index/{$row['Aca_ID']}";
$route["$segment[1]/calendar/process/(:num)"]	 = "academy_ctrl/calendar/process/$1";
$route["$segment[1]/opponent"]			 = "academy_ctrl/opponent/index/{$row['Aca_ID']}";
$route["$segment[1]/opponent/create"]	 = "academy_ctrl/opponent/create/{$row['Aca_ID']}";
$route["$segment[1]/play/reg_players/(:num)"]	= "academy_ctrl/play/reg_players/$1/{$row['Aca_ID']}";
$route["$segment[1]/play/invite/(:num)"]		= "academy_ctrl/play/invite/$1/{$row['Aca_ID']}";
$route["$segment[1]/play/invite_email"]		= "academy_ctrl/play/invite_email/{$row['Aca_ID']}";
$route["$segment[1]/events/add"]			 = "academy_ctrl/events/add/{$row['Aca_ID']}";
$route["$segment[1]/events/view/(:num)/(:num)"] = "academy_ctrl/events/view/$1/$1/{$row['Aca_ID']}";
$route["$segment[1]/events/view/(:num)"]	 = "academy_ctrl/events/view/$1/{$row['Aca_ID']}";
$route["$segment[1]/events"]			  = "academy_ctrl/events/index/{$row['Aca_ID']}";
$route["$segment[1]/events/autocomplete"]	 = "academy_ctrl/events/autocomplete/{$row['Aca_ID']}";
$route["$segment[1]/events/add_fields"]		 = "academy_ctrl/events/add_fields/{$row['Aca_ID']}";
$route["$segment[1]/events/add_fields_weekly"]	 = "academy_ctrl/events/add_fields_weekly/{$row['Aca_ID']}";
$route["$segment[1]/news"]							 = "academy_ctrl/news/index";
$route["$segment[1]/news/add"]					 = "academy_ctrl/news/add";
$route["$segment[1]/news/add_news"]		 = "academy_ctrl/news/add_news";
$route["$segment[1]/news/edit/(:num)"]			= "academy_ctrl/news/edit/$1";
$route["$segment[1]/news/view/(:num)"]		= "academy_ctrl/news/get_news_detail/$1";
$route["$segment[1]/news/update/(:num)"]	= "academy_ctrl/news/update_news/$1";
$route["$segment[1]/send_notifications"]		= "academy_ctrl/academy/send_mob_notifications/{$row['Aca_ID']}";
	}

// ----------------------------------------------End of Dynamic Routing-------------------------------------------



$route["default_controller"]				= "home/a2m_new";

$route["tournament"]		= "league/index";
$route["league"]			= "league/new_league";
$route["contact/submit"]	=  "home/contact_submit";

$route["login"]									= "login/index";
$route["logintest"]								= "logintest/index";
$route["logintest/check_phone"]			= "logintest/check_phone";
$route["search"]									= "search/index";
$route["(:any)/login/verify_user"]			= "login/verify_user";
$route["(:any)/login/send_activation"]	= "academy_ctrl/login/send_activation";
$route["(:any)/login/reset/(:any)"]			= "academy_ctrl/login/reset_password_form/$1/$2";
$route["(:any)/login/update_password"] = "academy_ctrl/login/update_password/$1";

$route["Table-Tennis/(:num)"]		  = "league/viewtournament/$1";
$route["calendar/process/(:num)"] = "calendar/process/$1";

$route["academy"]			 = "academy";
$route["a2mteams"]		 = "teams/view/";
$route["teams"]				 = "teams/view/";


$route["register/save_user_data"]	= "register/save_user_data";
$route["help/content"]						= "help/help_content";

$route["m/league/(:num)"]				= "help/mob_share/$1";

$route["test/rewrite_routes/(:any)/(:num)"]	 = "test/rewrite_routes/$1/$1";

$route["help/demo"]			 = "help/req_demo";
$route["news/(:num)"]			 = "news/get_news_detail/$1";
$route["News/(:num)"]		 = "news/get_news_detail/$1";
$route["terms_conditions"]	 = "league/terms_conditions";
$route["league/get_tour_fee/"]				= "league/get_tour_fee/";
$route["league/drop_line_matchscore"]	= "league/drop_line_matchscore";
$route["league/age_group_users/"]		= "league/age_group_users/";
$route["medical_form"]						= "league/medical_form";
$route["Contact-Us"]							= "help/contactus";
$route["Forgot-password"]					= "login/forgot_password";
$route["Reset-password"]					= "login/reset_password";
$route["reset/password/(:any)"]	= "login/reset_password_form/$1";
$route["player/(:num)"]				= "search/player_details/$1";
$route["coach/(:num)"]				= "search/player_details/$1";
$route["league/(:num)"]				= "league/viewtournament/$1";
$route["league2/(:num)"]				= "league/viewtournament2/$1";
$route["league/(:num)/(:num)"]	= "league/viewtournament/$1";
$route["league/view/(:num)"]		= "league/viewtournament/$1";
$route["league/view/(:any)"]		= "league/viewtournament/$1";
$route["league/view/(:num)/(:num)"]	= "league/viewtournament/$1";
$route["unsubscribe/(:any)"]			= "register/unsubscribe/$1";
$route["league/update_payment"]	= "league/update_team_player_payment";
$route["ratings/import"]  = "usatt_ratings/csv_import";
$route["clubs/import"]    = "import_clubs/csv_import";

$route["events/(:num)"]			= "events/view/$1";
$route["events/(:num)/(:any)"]	= "events/view/$1";

$route["sponsor/(:num)"]	= "donate/sponsor/$1";
$route["sponsor"]			= "donate/sponsor_now";
$route["sponsor/success"]	= "donate/sponsor_success";
$route["sponsor/sp_success"]= "donate/sp_success";
$route["sponsor/cancel"]	= "donate/cancel";

$route["404_override"]				= "Error404/error_page";
$route["league/UpdateLevels/"]	= "league/UpdateLevels/";
$route["translate_uri_dashes"]	= TRUE;

$route["scores/add"]	= "rest_services/scores/add";
$route["brackets"]		= "league/bracket_generator";
$route["ladder"]			= "league/ladder";
$route["privacy"]		= "home/priv_policy";
$route["sports"]			= "league/view_more_sports";


$route["badminton1"]			= "league/sport_page/3";

$route["pickleball1"]			= "league/sport_page/7";
$route["pickleball1/(:any)"]			= "league/sport_page_tab/7/$1";

$route["tt1"]							= "league/sport_page/2";
$route["tennis1"]					= "league/sport_page/1";

$route["badminton2"]			= "league/sport_page2/3";

$route["badminton"]			= "league/league_list/3";
$route["badminton#(:any)"] = "league/league_list/$1";
$route["badminton/(:num)"] = "league/viewtournament/$1";

$route["tennis"]			  = "league/league_list/1";
$route["tennis#(:any)"] = "league/league_list/$1";
$route["tennis/(:num)"] = "league/viewtournament/$1";

$route["tt"]				= "league/league_list/2";
$route["tt#(:any)"]	= "league/league_list/$1";
$route["tt/(:num)"]	= "league/viewtournament/$1";

$route["pickleball"]			= "league/league_list/7";
$route["pickleball#(:any)"]	= "league/league_list/$1";
$route["pickleball/(:num)"]	= "league/viewtournament/$1";

$route["basketball"]			= "league/league_list/18";
$route["basketball#(:any)"] = "league/league_list/$1";
$route["basketball/(:num)"] = "league/viewtournament/$1";

$route["bracket/(:num)"]		= "league/shareBracket/$1";

$route["(:any)/login"]								= "academy_ctrl/login";
$route["(:any)/login/(:num)"]					= "academy_ctrl/login";
$route["(:any)/login/phone_login"]					= "academy_ctrl/login/phone_login";
//$route["(:any)/login/(:num)"]					= "academy_ctrl/login2/$1/$2";
$route["(:any)/academy/get_mem_dets"] = "academy_ctrl/academy/get_mem_dets";
$route["(:any)/academy/get_subscr_list"] = "academy_ctrl/academy/get_subscr_list";
$route["(:any)/contact_us"]						 = "academy_ctrl/academy/club_contact_us";
$route["(:any)/league/apply_gc"]				 = "academy_ctrl/league/apply_gc";
$route["(:any)/league/get_event_fee"]		 = "academy_ctrl/league/get_event_fee";
$route["(:any)/login/ajax_validate_login"]	 = "academy_ctrl/login/ajax_validate_login";
$route["(:any)/league/edit_user_a2m"]		 = "academy_ctrl/league/edit_user_a2m";
$route["(:any)/league/get_ocr_players"]	 = "academy_ctrl/league/get_ocr_players";
$route["(:any)/league/getusers"]				 = "academy_ctrl/league/getusers";
$route["(:any)/league/getusers_occr"]		 = "academy_ctrl/league/getusers_occr";
$route["(:any)/league/auto_reg_players"]		 = "academy_ctrl/league/auto_reg_players";
$route["(:any)/league/remove_group_players"]	 = "academy_ctrl/league/remove_group_players";
$route["(:any)/league/get_cl_standings/(:num)"] = "academy_ctrl/league/get_cl_standings/$1/$2";
$route["(:any)/academy/send_epf"]			 = "academy_ctrl/academy/send_epf/$1/$2";

$route["(:any)/export/court_reservations"]			= "academy_ctrl/export/court_reservations";
$route["(:any)/export/club_members"]					= "academy_ctrl/export/club_members";
$route["(:any)/register/save"]								= "academy_ctrl/register/save_user_data";
$route["(:any)/register/activate/(:any)"]				= "academy_ctrl/register/activate/$1/$2";
$route["(:any)/admin/check_membership_type"]	= "academy_ctrl/admin/check_membership_type";
$route["(:any)/courts/cancel_booking"]					= "academy_ctrl/courts/cancel_booking";
$route["(:any)/courts/check_is_repeat"]					= "academy_ctrl/courts/check_is_repeat";
$route["(:any)/courts/get_next_dates"]					= "academy_ctrl/courts/get_next_dates";

$route["(:any)/admin/check_membership_id"] = "academy_ctrl/admin/check_membership_id";
$route["(:any)/admin/get_membership_det"]   = "academy_ctrl/admin/get_membership_det";
$route["testclub9/membership/paynow/(:num)"]		= "academy_ctrl/membership/paynow/$1";
$route["testclub9/membership/ot_success/(:num)"]  = "academy_ctrl/membership/ot_success/1123/$1";
$route["(:any)/membership/success"]						= "academy_ctrl/membership/success";
//$route["(:any)/membership/success"]  = "academy_ctrl/membership/success";

$route["(:any)/test/sess_test"]	  = "academy_ctrl/test/sess_test";


$route["(:any)/paypal/success"]	  = "academy_ctrl/paypal/success";
$route["(:any)/paypal/msuccess"]  = "academy_ctrl/paypal/msuccess";
$route["(:any)/paypal/cancel"]		  = "academy_ctrl/paypal/cancel";

$route["(:any)/paypal/testEmail"]		  = "academy_ctrl/paypal/testEmail";

$route["(:any)/paypal/ipn"]						= "academy_ctrl/paypal/ipn/$1";
$route["(:any)/paypal/ipn_more"]				= "academy_ctrl/paypal/ipn_more/$1";
$route["(:any)/paypal/subscr_success"]   = "academy_ctrl/paypal/subscr_success/$1";

$route["(:any)/paypal/subscr_cancel"]		= "academy_ctrl/paypal/subscr_cancel";
$route["(:any)/paypal/subscr_ipn"]			= "academy_ctrl/paypal/subscr_ipn";

$route["(:any)/paypal/ot_success"]  = "academy_ctrl/paypal/ot_success/$1";
$route["(:any)/paypal/ot_cancel"]		= "academy_ctrl/paypal/ot_cancel";
$route["(:any)/paypal/ot_ipn"]			= "academy_ctrl/paypal/ot_ipn";

$route["(:any)/paypal/ot_user"]			= "academy_ctrl/paypal/ot_user/$1";
$route["(:any)/paypal/subscr_user"]		= "academy_ctrl/paypal/subscr_user";
$route["(:any)/paypal/ot_ipn"]				= "academy_ctrl/paypal/ot_ipn";

$route["(:any)/subscribe"]						= "academy_ctrl/academy/subscribe/$1";
$route["(:any)/subscribe_buy"]				= "academy_ctrl/academy/subscribe_buy/$1";
$route["(:any)/subscription/cancel"]		= "academy_ctrl/academy/subscribe_cancel";
$route["(:any)/forms"]							= "academy_ctrl/admin/show_forms";
$route["(:any)/update_forms"]				= "academy_ctrl/admin/update_forms";
$route["(:any)/update_message"]		= "academy_ctrl/admin/update_message";
$route["(:any)/add_testimonial"]			= "academy_ctrl/admin/add_testimonial";
$route["(:any)/delete_testim"]				= "academy_ctrl/admin/delete_testim";
$route["(:any)/get_testim"]					= "academy_ctrl/admin/get_testim";
$route["(:any)/upd_testimonial"]			= "academy_ctrl/admin/update_testim";
$route["(:any)/swtich_layout"]				= "academy_ctrl/admin/swtich_layout";
$route["(:any)/facility/add_hv"]				= "academy_ctrl/facility/add_hv";
$route["(:any)/test"]							= "academy_ctrl/test";
$route["(:any)/test/server_vars"]			= "academy_ctrl/test/server_vars";
$route["(:any)/test/custom_page"]		= "academy_ctrl/test/custom_page";

$route["(:any)/facility/add_videoLinks"]	 = "academy_ctrl/facility/add_videoLinks";
$route["(:any)/facility/delete_vids"]		 = "academy_ctrl/facility/delete_vids";

$route["(:any)/logintest/check_phone"]	 = "logintest/check_phone";
$route["(:any)/test/test_form"]	 = "academy_ctrl/test/test_form";
$route["(:any)/test/sess_store"]	 = "academy_ctrl/test/sess_store";
$route["(:any)/league/check_sess"]	 = "academy_ctrl/league/check_sess";
$route["(:any)/test/check_sess"]	 = "academy_ctrl/test/check_sess";

$route["(:any)/logintest/check_phone"]				= "logintest/check_phone";
$route["(:any)/league/get_tour_fee"]				= "academy_ctrl/league/get_tour_fee";
$route["(:any)/league/drawresults_filter"]				= "academy_ctrl/league/drawresults_filter";
$route["(:any)/league/upd_rr_players"]				= "academy_ctrl/league/upd_rr_players";
$route["(:any)/league/get_tour_details"]			= "academy_ctrl/league/get_tour_details";
$route["(:any)/league/register_more/(:num)"]	= "academy_ctrl/league/register_more/$1/$2";
$route["(:any)/league/buy_more/(:num)"]			= "academy_ctrl/league/buy_more/$1/$2";
$route["(:any)/league/fixtures/(:num)"]				= "academy_ctrl/league/fixtures/$1/$2";
$route["(:any)/league/bracket/(:num)"]				= "academy_ctrl/league/bracket/$1/$2";
$route["(:any)/league/ShowMatches/(:num)"]	= "academy_ctrl/league/ShowMatches/$1/$2";
$route["(:any)/league/bracket_save"]				= "academy_ctrl/league/bracket_save/$1";
$route["(:any)/league/load_adm_addscore"]		= "academy_ctrl/league/load_adm_addscore/$1";
$route["(:any)/league/load_gallery"]					= "academy_ctrl/league/load_gallery/$1";
$route["(:any)/league/upload_pics"]					= "academy_ctrl/league/upload_pics/$1";
$route["(:any)/league/load_draws_results"]		= "academy_ctrl/league/load_draws_results/$1";
$route["(:any)/league/load_mymatches_results"] = "academy_ctrl/league/load_mymatches_results/$1";
$route["(:any)/league/printScoreSheet"]	= "academy_ctrl/league/printScoreSheet/$1";
$route["(:any)/league/AddRating"]			= "academy_ctrl/league/AddRating/$1";
$route["(:any)/league/EditRating"]			= "academy_ctrl/league/EditRating/$1";
$route["(:any)/search/contact_player"]		= "academy_ctrl/search/contact_player/$1";
$route["(:any)/page/testpage"]				= "academy_ctrl/page/testpage/$1";
$route["(:any)/page/post_page"]		= "academy_ctrl/page/post_page/$1";
$route["(:any)/ratings"]					= "academy_ctrl/academy/ratings/$1";
$route["(:any)/get_sp_levels"]			= "academy_ctrl/academy/get_sp_levels/$1";
$route["(:any)/coach/(:num)"]			= "academy_ctrl/academy/coach_profile/$1/$2";
$route["(:any)/league/publish_draws"]					= "academy_ctrl/league/publish_draws/$1";
$route["(:any)/league/unpublish_draws"]				= "academy_ctrl/league/unpublish_draws/$1";
$route["(:any)/league/load_adm_edit_withdraw"]  = "academy_ctrl/league/load_adm_edit_withdraw/$1";
$route["(:any)/league/load_adm_participants"]		= "academy_ctrl/league/load_adm_participants/$1";
$route["(:any)/league/swap_group_players"]		= "academy_ctrl/league/swap_group_players/$1";
$route["(:any)/register/instant_clubmember"]		= "academy_ctrl/register/instant_clubmember/$1";
$route["(:any)/league/check_in"]							= "academy_ctrl/league/check_in/$1";
$route["(:any)/league/sendmail_tm_participants"]	= "academy_ctrl/league/sendmail_tm_participants/$1";

$route["(:any)/league/publish/(:num)"]		= "academy_ctrl/league/publish/$1/$2";
$route["(:any)/league/unpublish/(:num)"]	= "academy_ctrl/league/unpublish/$1/$2";

$route["(:any)/facility/add_lt_team"]	 = "academy_ctrl/facility/add_lt_team/$1";
$route["(:any)/facility/delete_lt"]		 = "academy_ctrl/facility/delete_lt/$1";


$route["(:any)/events/(:num)"]				= "academy_ctrl/events/view/$1/$2";
$route["(:any)/events/(:num)/(:num)"]	= "academy_ctrl/events/view/$1/$2/$3";
$route["(:any)/events/reg_user2"]					= "academy_ctrl/events/reg_user2/$1";
$route["(:any)/events/add_comment"]	= "academy_ctrl/events/add_comment/$1";
$route["(:any)/events/send_email_reg_players"]	= "academy_ctrl/events/send_email_reg_players/$1";
$route["(:any)/events/invite_players"]	= "academy_ctrl/events/invite_players/$1";
$route["(:any)/events/send_event"]		= "academy_ctrl/events/send_event/$1";

$route["testclub9/gpaleagues"]			= "academy_ctrl/events/gpaevents/1123";

$route["gpa/tournaments"]				= "academy_ctrl/events/gpaevents/1176";
$route["gpa/clubs"]							= "academy_ctrl/academy/clubs/1176";
$route["gpa/member_benefits"]			= "academy_ctrl/academy/benefits/1176";
$route["gpa/club_benefits"]				= "academy_ctrl/academy/club_benefits/1176";
$route["gpa/rankings"]						= "academy_ctrl/academy/rankings/1176";
$route["gpa/rankings2"]						= "academy_ctrl/academy/rankings2/1176";
$route["gpa/places2play"]					= "academy_ctrl/academy/places2play/1176";
$route["gpa/register"]						= "academy_ctrl/register/index/1176";

$route["sreenidhi/page1"]								= "academy_ctrl/academy/page1/1166";
$route["sreenidhi/etz-plus"]							= "academy_ctrl/academy/page2/1166";
$route["sreenidhi/page3"]								= "academy_ctrl/academy/page3/1166";
$route["sreenidhi/etz-school"]						= "academy_ctrl/academy/page4/1166";
$route["sreenidhi/page5"]								= "academy_ctrl/academy/page5/1166";
$route["sreenidhi/page6"]								= "academy_ctrl/academy/page6/1166";
$route["sreenidhi/elite-program"]					= "academy_ctrl/academy/elite_prog/1166";
$route["sreenidhi/mha"]								= "academy_ctrl/academy/mha/1166";
$route["sreenidhi/mhv"]									= "academy_ctrl/academy/mhv/1166";
$route["sreenidhi/pabel-city"]						= "academy_ctrl/academy/pbl/1166";
$route["sreenidhi/etz-primary"]						= "academy_ctrl/academy/etz_primary/1166";
$route["sreenidhi/etz-secondary"]					= "academy_ctrl/academy/etz_secondary/1166";
$route["sreenidhi/virtual-training"]					= "academy_ctrl/academy/virtual_training/1166";
$route["sreenidhi/vt-basketball"]					= "academy_ctrl/academy/vt_basketball/1166";
$route["sreenidhi/vt-squash"]						= "academy_ctrl/academy/vt_squash/1166";
$route["sreenidhi/vt-tennis"]							= "academy_ctrl/academy/vt_tennis/1166";
$route["sreenidhi/vt-martialarts"]					= "academy_ctrl/academy/vt_martialarts/1166";
$route["sreenidhi/vt-chess"]							= "academy_ctrl/academy/vt_chess/1166";
$route["sreenidhi/vt-fitness"]							= "academy_ctrl/academy/vt_fitness/1166";
$route["sreenidhi/about-us"]							= "academy_ctrl/academy/sn_about_us/1166";

$route["testclub9/events/add_league"]		= "academy_ctrl/events/add_league/1123";

}
