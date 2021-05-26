<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Calendar extends CI_Controller {
		
		public $header_tpl	   = "academy_views/includes/academy_header";
		public $calendar_tpl   = "academy_views/includes/academy_calendar";
		public $right_col_tpl  = "academy_views/includes/academy_right_column";
		public $footer_tpl	   = "academy_views/includes/academy_footer";
		public $short_code;
		public $academy_admin;
		public $logged_user;

		public function __construct()
		{
			parent:: __construct();
			$this->load->model('academy_mdl/model_calendar', 'model_calendar');
			$this->load->model('academy_mdl/model_news', 'model_news');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_academy', 'model_academy');

			$this->short_code		= $this->uri->segment(1);
			$this->academy_admin	= $this->general->get_org_admin($this->short_code);
			$this->logged_user		= $this->session->userdata('users_id');

			$this->admin_menu_items = array('0'=>'');
			if($this->logged_user != $this->academy_admin)
			$this->admin_menu_items = array('0'=>'8');
		}
	
		public function index($org_id = '')
		{
			$data			 = $this->get_org_details($org_id);
		    $data['results'] = $this->model_news->get_news($org_id);
			$data['org_id']  = $org_id;

		    $this->load->model('academy_mdl/model_calendar');
		    // $this->load->view('academy_views/view_calendar', $data);
			//echo "<pre>"; print_r($data); exit;
			$this->load->view($this->header_tpl, $data);
			$this->load->view($this->calendar_tpl, $data);
			$this->load->view('academy_views/view_calendar', $data);
			$this->load->view($this->right_col_tpl,$data);
			$this->load->view($this->footer_tpl);
		}
			
		public function process($org_id = '')
		{
			$events = array();
			$query = $this->model_calendar->get_tournaments($org_id);

			foreach($query as $fetch)
			{
				$e = array();

				$e['id']	= $fetch->tournament_ID;
				$e['title'] = $fetch->tournament_title;
				$e['start'] = $fetch->StartDate;
				$e['end']	= $fetch->EndDate;

				$allday		 = ($fetch->Visibility == "public") ? "true" : "false";
				$e['allDay'] = $allday;
				$e['type'] = "tournament";

				array_push($events, $e);
			}
			
			
			$query = $this->model_calendar->get_events($org_id);
			
			foreach($query as $fetch)
			{
				$e = array();

				$e['id']	= $fetch->ev_id;
				$e['title'] = $fetch->Ev_Title;
				$e['start'] = $fetch->Ev_Date."T".$fetch->Ev_Start_Time;
				$e['end']	= $fetch->Ev_Date."T".$fetch->Ev_End_Time;

				$allday		 = "false";
				$e['allday'] = $allday;
				$e['type'] = "event";

				array_push($events, $e);
			}
			
			echo json_encode($events);
		}

		public function get_org_details($org_id)
		{
			$org_details			= $this->model_academy->get_academy_details($org_id); 
			$data['org_details']	= $org_details; 

			$data['creator']		= $org_details['Aca_User_id'];

			$data['menu_list']		= $this->model_academy->get_menu_list();
			$data['act_menu_list']	= $this->model_academy->get_act_menu_list($org_id);
			$data['results']		= $this->model_academy->get_news($org_id);
			$data['sport_levels']	= $this->model_academy->get_tennis_levels();

			return $data;
		}

		public function get_menu_name($id)
		{
			return $this->model_academy->get_menu_name($id);
		}

	}

?>