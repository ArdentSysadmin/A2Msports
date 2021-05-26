<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('M2KM_FACTOR', 1.609344);

	//Friendly Match controller ..
class Opponent extends CI_Controller {

	var $units;
	var $decimals;

	public $header_tpl	   = "academy_views/includes/academy_header";
	public $right_col_tpl  = "academy_views/includes/academy_right_column";
	public $footer_tpl	   = "academy_views/includes/academy_footer";
	public $short_code;
	public $academy_admin;
	public $logged_user;


	public function __construct()
	{
		parent:: __construct();

		$this->load->helper(array('form', 'url'));

		$this->load->model('academy_mdl/model_opponent', 'opponent');
		$this->load->model('academy_mdl/model_general', 'general');
		$this->load->model('academy_mdl/model_news', 'model_news');
		$this->load->model('academy_mdl/model_academy', 'model_academy');
		$this->load->library('session');

		$this->short_code	 = $this->uri->segment(1);
		$this->academy_admin = $this->general->get_org_admin($this->short_code);
		$this->logged_user	 = $this->session->userdata('users_id');

		$this->admin_menu_items = array('0'=>'');
		 if($this->logged_user != $this->academy_admin)
		$this->admin_menu_items = array('0'=>'8');
	}

	public function index($org_id = '')
	{
	$url_seg = $this->uri->segment(1); 
	$last_url = array('redirect_to'=>$url_seg);
	$this->session->set_userdata($last_url);

	$data = $this->get_org_details($org_id);

	$data['users'] = "";
		if($this->session->userdata('user')!="") {

		$points					= $this->opponent->get_lat_lang();
		$data['sport_intrests'] = $this->general->get_user_sport_intrests();
		$data['sport_levels']	=  $this->opponent->get_sport_levels();

		//echo "<pre>";
		//print_r($data['sport_levels']);
		//exit;

		$data['latitude']	= $points->Latitude;
		$data['longitude']	= $points->Longitude;
		
		$data['range']	= 50;
		$srch_res		= $this->opponent->get_optimum_users($data);
		$data['users']	= $srch_res;
		
		}

	$data['results'] = $this->model_news->get_news();
	$this->load->view($this->header_tpl, $data);
	$this->load->view('academy_views/view_opponent', $data);
	$this->load->view($this->right_col_tpl, $data);
	$this->load->view($this->footer_tpl);
	}

	public function get_org_details($org_id)
	{
		$org_details			= $this->model_academy->get_academy_details($org_id); 
		$data['org_details']	= $org_details; 

		$data['creator']		= $org_details['Users_ID'];

		$data['menu_list']		= $this->model_academy->get_menu_list();
		$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
		$data['results']		= $this->model_academy->get_news($org_id);
		$data['sport_levels']	= $this->model_academy->get_tennis_levels();

		return $data;
	}
	
	public function Sport_levels($sport_id = '')
	{
		$sport_id = $this->input->post('sport_id');
		$sport_levels = $this->opponent->get_specific_levels($sport_id);
		$sp_level = array();

		echo "<script>
		$(document).ready(function(){

			$('.ajax_click').click(FilterPlayers)

			$('.ajax_blur').blur(FilterPlayers)

			$('.ajax_change').change(Change_FilterPlayers)
		
			$('.ajax_mile_change').change(FilterPlayers)
			
		});
		</script>";

		foreach($sport_levels as $row){ 
		if(in_array($row->SportsLevel_ID, $sp_level)){ $checked_stat = 'checked = checked'; }
			echo "<input type='checkbox' class='ajax_click' name='level[]' value='$row->SportsLevel_ID'>$row->SportsLevel";
			echo "&nbsp";
		}

	}

	public function get_sport($sport_id)
	{
		return $this->opponent->get_sport_title($sport_id);
	}

	public function search_players()
	{

	if($_POST) 
	{
	$intrests = $this->input->post('Sportsintrests');
	$sp_intrests = ($intrests != FALSE) ? $intrests : array();

	$data['Sportsintrests'] = $sp_intrests;    
	$data['age_group'] = $this->input->post('age_group');

	$gend = $this->input->post('gend');

	$data['gend'] = $gend;
	if($this->input->post('range')==""){
		$data['range'] = 25;
	}
	else{
		$data['range'] = $this->input->post('range');
	}
	$user_id = $this->session->userdata('users_id');
	$points = $this->opponent->get_lat_lang();

	$data['latitude'] = $points->Latitude;
	$data['longitude'] = $points->Longitude;

	$srch_res = $this->opponent->search_users($data);

	$data['users'] = $srch_res;
	$data['results'] = $this->model_news->get_news();
	$this->load->view($this->header_tpl, $data);
	$this->load->view('academy_views/view_opponent',$data);
	$this->load->view($this->right_col_tpl, $data);
	$this->load->view($this->footer_tpl);
	}
	else
	{
	echo "Invalid Access!";
	}

	}

	public function match()
	{
		$data['selected_players'] = $this->input->post('sel_player');
		$data['venue'] = $this->general->get_venue();
		$data['log_user_addr'] = $this->general->get_addr();
		$data['results'] = $this->model_news->get_news();

		$this->load->view($this->header_tpl, $data);
		$this->load->view('academy_views/view_opponent',$data);
		$this->load->view($this->right_col_tpl, $data);
		$this->load->view($this->footer_tpl);
	}

	public function get_user_details($player)
	{
		return $this->general->get_user($player);
	}

	public function create()
	{
		if($this->input->post('btn_create_match'))
		{
		$ins_match = $this->opponent->create_match();

		$this->load->library('email');
		$this->email->set_newline("\r\n");

		$email = $this->session->userdata('EmailID');

		foreach($this->input->post('sel_player') as $user_id)
		{

		$sql	= "SELECT * FROM users WHERE Users_ID = " .$user_id;
		$result = $this->db->query($sql);
		$row	= $result->row();

		$this->email->from('admin@a2msports.com', ' A2mSports');
		$this->email->to($row->EmailID);
		
		$this->email->subject('New Match Invitation - A2MSports');

		$data = array(
             'firstname'=> $row->Firstname,
			 'lastname'	=> $row->Lastname,
			 'match_id' => $ins_match,
			 'page'		=> 'New Match Invitation');


		$body = $this->load->view('academy_views/view_email_template.php',$data,TRUE);

		$this->email->message($body);   
		$this->email->send();
		}

		redirect($this->short_code);
		}
		else
		{
		echo "Invalid Access!";
		}
	}

	public function get_lang_latt()
	{
	// $address1 = $this->input->post('UserAddressline1');
		if($this->input->post('venue_address2')==""){
			$address2 = $this->input->post('venue_address1');
		}
		else{
			$address2 = $this->input->post('venue_address2');
		}

		$country = $this->input->post('venue_country');

		if($country == "United States of America") {
		$state = $this->input->post('venue_state');
		} else {
		$state = $this->input->post('venue_state1');
		}

		$city = $this->input->post('venue_city');
		$address =  $address2 . ' ' .  $country . ' ' .  $state . ' ' .  $city ;

		if(!empty($address)){

		//Formatted address
		$formattedAddr = str_replace(' ','+',$address);

		//Send request and receive json data by address
		$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false'); 

		$output1 = json_decode($geocodeFromAddr);

		$latitude  = 0.00; 
		$longitude = 0.00;

		//Get latitude and longitute from json data
		$latitude  = $output1->results[0]->geometry->location->lat; 
		$longitude = $output1->results[0]->geometry->location->lng;

			return  $latitude  . '@' . $longitude ;
		} 
		else 
		{
			return false;
		}
	}

		public function LoadUsers()
		{
			$sport_id	= $this->input->post('sport_id');
			$level		= $this->input->post('level');
			$age_group	= $this->input->post('age_group');
			$gender		= $this->input->post('gender');
			$range		= $this->input->post('range');
			$org_id		= $this->input->post('org_id');
			$academy	= $this->input->post('academy');

			if($range == ""){ $range = 50; }

			//if($sport_id != ""){
					$data['users'] = "";

					$points				= $this->opponent->get_lat_lang();
					$data['latitude']	= $points->Latitude;
					$data['longitude']	= $points->Longitude;

					$data['sport_id']	= $sport_id;
					$data['level']		= $level;
					$data['age_group']	= $age_group;
					$data['gender']		= $gender;
					$data['range']		= $range;
					$data['org_id']		= $org_id;
					$data['academy']	= $academy;
					
					$data['users'] = $this->opponent->search_sport_users($data);

					$this->load->view('academy_views/view_more' ,$data);
				
			//}
			
		}

		public function autocomplete()
		{
			$q = $_POST['name_startsWith'];
	
			$data['key'] = trim($q);
			$result = $this->opponent->search_autocomplete($data);

			if($result)
			{
				$data_new = array();
				foreach($result as $row)   
				{
					$name = $row->Org_name.'|'.$row->Org_ID;
					array_push($data_new, $name);	
				}
			}
				echo json_encode($data_new);
		 }

}