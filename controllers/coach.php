<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
session_start();
class Coach extends CI_Controller {

	public $logged_user;

	public function __construct() {
		parent:: __construct();

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->library('session');

			$this->load->model('model_coach', 'coach');
			$this->load->model('model_general', 'general');
			$this->load->model('model_news');

		if(!$this->session->userdata('users_id')) {
			redirect('login');
		}
		else{
			$this->logged_user = $this->session->userdata('users_id');
		}
	}

	// Coach default page...
	public function index() {
		//echo $this->logged_user;
			$check_is_coach = $this->coach->check_is_coach($this->logged_user);
			if($check_is_coach->num_rows() > 0){
			$data['coachTimings']	= $this->coach->get_coachTimings();
			$data['get_coach']		= $this->coach->get_user_details($this->logged_user);
			$data['results']				= $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_coach_calendar', $data);
			$this->load->view('includes/footer');
			}
			else{
				echo "You are not a coach!"; exit;
			}
	}

	public function update() {
		//echo "<pre>"; print_r($_POST); exit;
		$priv_mem_discount = $this->input->post('priv_mem_discount');
		$grp_mem_discount  = $this->input->post('grp_mem_discount');
		$time_price = $this->input->post('price');
		$is_grp		   = $this->input->post('c1');
		$this->coach->upd_coach_discounts($this->logged_user, $priv_mem_discount, $grp_mem_discount);
		$this->coach->del_coach_timings($this->logged_user);
//echo "<pre>"; print_r($time_price);
		foreach($time_price as $tp => $pr){
			//echo $tp." - ".$pr."<br>";
			$x = explode('-', $tp);
			if($x[1] == 0)
				$arr[$x[0]."-".($x[0]+1)]['mon']['pr'] = $pr;
			if($x[1] == 1)
				$arr[$x[0]."-".($x[0]+1)]['tue']['pr'] = $pr;
			if($x[1] == 2)
				$arr[$x[0]."-".($x[0]+1)]['wed']['pr'] = $pr;
			if($x[1] == 3)
				$arr[$x[0]."-".($x[0]+1)]['thu']['pr'] = $pr;
			if($x[1] == 4)
				$arr[$x[0]."-".($x[0]+1)]['fri']['pr'] = $pr;
			if($x[1] == 5)
				$arr[$x[0]."-".($x[0]+1)]['sat']['pr'] = $pr;
			if($x[1] == 6)
				$arr[$x[0]."-".($x[0]+1)]['sun']['pr'] = $pr;

		
			if($is_grp[$tp] and $x[1] == 0)
				$arr[$x[0]."-".($x[0]+1)]['mon']['grp'] = 1;
			else if($x[1] == 0)
				$arr[$x[0]."-".($x[0]+1)]['mon']['grp'] = 0;

			if($is_grp[$tp] and $x[1] == 1)
				$arr[$x[0]."-".($x[0]+1)]['tue']['grp'] = 1;
			else if($x[1] == 1)
				$arr[$x[0]."-".($x[0]+1)]['tue']['grp'] = 0;

			if($is_grp[$tp] and $x[1] == 2)
				$arr[$x[0]."-".($x[0]+1)]['wed']['grp'] = 1;
			else if($x[1] == 2)
				$arr[$x[0]."-".($x[0]+1)]['wed']['grp'] = 0;

			if($is_grp[$tp] and $x[1] == 3)
				$arr[$x[0]."-".($x[0]+1)]['thu']['grp'] = 1;
			else if($x[1] == 3)
				$arr[$x[0]."-".($x[0]+1)]['thu']['grp'] = 0;

			if($is_grp[$tp] and $x[1] == 4)
				$arr[$x[0]."-".($x[0]+1)]['fri']['grp'] = 1;
			else if($x[1] == 4)
				$arr[$x[0]."-".($x[0]+1)]['fri']['grp'] = 0;

			if($is_grp[$tp] and $x[1] == 5)
				$arr[$x[0]."-".($x[0]+1)]['sat']['grp'] = 1;
			else if($x[1] == 5)
				$arr[$x[0]."-".($x[0]+1)]['sat']['grp'] = 0;

			if($is_grp[$tp] and $x[1] == 6)
				$arr[$x[0]."-".($x[0]+1)]['sun']['grp'] = 1;
			else if($x[1] == 6)
				$arr[$x[0]."-".($x[0]+1)]['sun']['grp'] = 0;


		}

		//echo "<pre>"; print_r($arr);exit;
		foreach($arr as $tm => $days){
			$a = explode('-', $tm);
			$st_time  = date('H:i:s', strtotime($a[0].":00:00"));
			$ed_time = date('H:i:s', strtotime($a[1].":00:00"));

			$mon = ($days['mon']['pr']) ? $days['mon']['pr'] : NULL;
			$tue   = ($days['tue']['pr']) ? $days['tue']['pr'] : NULL;
			$wed = ($days['wed']['pr']) ? $days['wed']['pr'] : NULL;
			$thu	 = ($days['thu']['pr']) ? $days['thu']['pr'] : NULL;
			$fri	 = ($days['fri']['pr']) ? $days['fri']['pr'] : NULL;
			$sat  = ($days['sat']['pr']) ? $days['sat']['pr'] : NULL;
			$sun = ($days['sun']['pr']) ? $days['sun']['pr'] : NULL;

			$data = array(
			'Coach_ID' => $this->logged_user,
			'Start_Time' => $st_time,
			'End_Time' => $ed_time,
			'Sun_Price' => $sun,
			'Mon_Price' => $mon,
			'Tue_Price' => $tue,
			'Wed_Price' => $wed,
			'Thu_Price' => $thu,
			'Fri_Price' => $fri,
			'Sat_Price' => $sat,
			'Sun_Is_Group' => $days['sun']['grp'],
			'Mon_Is_Group' => $days['mon']['grp'],
			'Tue_Is_Group' => $days['tue']['grp'],
			'Wed_Is_Group' => $days['wed']['grp'],
			'Thu_Is_Group' => $days['thu']['grp'],
			'Fri_Is_Group' => $days['fri']['grp'],
			'Sat_Is_Group' => $days['sat']['grp'],
			'Is_Group_Class' => 1,
			'slot_duration' => 1
			);

			$this->coach->insert_coach_timings($data);
		}
		
		redirect(base_url()."coach");
	}

	public function reserve_coach($coach_id) {

			if($coach_id) {
				$check_is_coach = $this->coach->check_is_coach($coach_id);
				if($check_is_coach->num_rows() > 0) {

					$data['coachUser']		= $this->coach->get_user_details($coach_id) ;
					$data['coachTimings']	= $this->coach->get_coachTimings();
					$data['results']				= $this->model_news->get_news();

					$this->load->view('includes/header');
					$this->load->view('view_reserve_coach', $data);
					$this->load->view('includes/footer');
				}
				else {
					echo "<h4>User is not a coach!</h4>"; exit;
				}
			}
			else {
				echo "<h4>Coach ID required!</h4>"; exit;
			}
	}

	public function get_reserve_coach_popup(){
		$data = '';
						$this->load->view('view_reserve_coach_frm', $data);


	}

}