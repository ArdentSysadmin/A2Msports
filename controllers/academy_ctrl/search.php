<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
	class Search extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_members');
			$this->load->model('model_general', 'general');
			$this->load->model('model_news');
			$this->load->library('pagination');
		}
		
		// viewing league page ...
		public function index()
		{

			$url_seg = $this->uri->segment(1); 
			$last_url = array('redirect_to'=>$url_seg);
			$this->session->set_userdata($last_url);
			
			$data['search_fname']  = "";
			$data['coach_name']  = "";
			$data['search_title'] = "";
			$data['created_by'] = "";
			$data['Sport']= "";
			$data['search_city'] = "";
			$data['search_state'] = "";

			$data['sport_levels'] =  $this->model_members->get_tennis_levels();
			
			$data['results'] = $this->model_news->get_news();
			$this->load->view('includes/header');
			$this->load->view('view_members_list',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		public function academy_users(){

			$q			= $_POST['name_startsWith'];
			$academy_id = $_POST['academy'];
	
			$data['key'] = trim($q);
			$data['academy'] = trim($academy_id);
			$result = $this->model_members->search_academy_users($data);

			if($result)
			{
				$data_new = array();
				foreach($result as $row)   
				{
					$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID;
					array_push($data_new, $name);	
				}

			}
			else
			{
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

			if($result)
			{
				$data_new = array();
				foreach($result as $row)   
				{
					$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID;
					array_push($data_new, $name);	
				}

			}
			else
			{
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

		public function search_user()
		{
			
			if($this->input->post('search_mem'))
			{

			$data['search_fname'] = $this->input->post('name');
			$data['sport'] = $this->input->post('user_sport');
			$data['level'] = $this->input->post('level');
			$data['range'] = $this->input->post('range');
			
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
		}

		public function search_coach()
		{
			if($this->input->post('coach_mem'))
			{
			$data['coach_name']	 = $this->input->post('coach_name');
			$data['coach_sport'] = $this->input->post('coach_sport');
			$data['coach_range'] = $this->input->post('coach_range');
			$data['lat']		 = $this->session->userdata('lat');
			$data['long']		 = $this->session->userdata('long');
			$data['coach_results'] = $this->model_members->search_coaches($data);
			$data['results']	 = $this->model_news->get_news();
			
			$this->load->view('includes/header');
			$this->load->view('view_members_list',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
			}
		}


		public function search_matches()
		{
			$data['search_title']	= $this->input->post('search_title');
			$data['created_by']		= $this->input->post('created_by');
			$data['Sport']			= $this->input->post('Sport');
			$data['range']			=	$this->input->post('range');
			$data['lat']			= $this->session->userdata('lat');
			$data['long']			= $this->session->userdata('long');
			$data['matches']		= $this->model_members->search_matches($data);
			$data['matches1']		= $this->model_members->search_matches1($data);
			$data['results']		= $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_members_list',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}


		public function search_tournaments()
		{
			$data['search_city']  = $this->input->post('search_city');
			$data['search_state'] = $this->input->post('search_state');
			$data['Sport'] = $this->input->post('Sport');
			$data['range'] = $this->input->post('range');
			$data['lat']   = $this->session->userdata('lat');
			$data['long']  = $this->session->userdata('long');

			//print_r($data['long']);
			//exit;
			
			$data['tournaments'] = $this->model_members->search_tournaments($data);
			$data['results'] = $this->model_news->get_news();
			$this->load->view('includes/header');
			$this->load->view('view_members_list',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

		public function get_details($user_id)
		{
			return $this->model_members->get_sport_id($user_id);
		}

		 public function autocomplete()
		 {
			$q = $_POST['name_startsWith'];
	
			$data['key'] = trim($q);
			$result = $this->model_members->search_autocomplete($data);

			if($result)
			{
				$data_new = array();
				foreach($result as $row)   
				{
					$name = $row->Firstname.' '.$row->Lastname.'|'.$row->Users_ID;
					array_push($data_new, $name);	
				}
			}
				echo json_encode($data_new);
		 }

		public function match($match_id)
		{
			$data['match_det'] = $this->model_members->get_match_det($match_id);
			$data['results'] = $this->model_news->get_news();
				$this->load->view('includes/header');
				$this->load->view('view_match_details', $data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
		}

		public function individual_play($match_id)
    	{
			$data['match_det'] = $this->model_members->get_individual_play($match_id);
			$data['results'] = $this->model_news->get_news();
				$this->load->view('includes/header');
				$this->load->view('view_individual_play_details', $data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
		}

		 public function get_user($user_id)
		 {
		   return $this->general->get_user($user_id);
		 }

		 public function get_sport($sport_id)
		 {
		   return $this->model_members->get_sport_title($sport_id);
		 }

		 public function get_sport_name($gen_match_id)
		 {
			return $this->model_members->get_sport_number($gen_match_id);
		 }

		public function player_details($user_id)
		{
			if(!$this->session->userdata('user')){
				redirect('login');
			}

			$data['user_details'] = $this->model_members->get_user_id($user_id);
			$data['user_matches'] = $this->model_members->get_user_matches($user_id);
			$data['user_tournment_matches'] = $this->model_members->get_user_tournment_matches($user_id);
			$data['num_matches']  = $this->model_members->get_num_matches($user_id);
			$data['results']	  = $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_player_details',$data);
			$this->load->view('includes/view_right_column');
			$this->load->view('includes/footer');
		}

		public function get_gen_mat_det($gen_match_id)
		{
			return $this->model_members->get_gen_mat_det($gen_match_id);
		}

		public function get_user_det($user_id)
		{
			return $this->general->get_user($user_id);
		}

		public function get_tourn_name($tourn_id)
		{
			return $this->model_members->get_tourn_name($tourn_id);
		}

		public function contact_player()
		{
			$mes	   = $this->input->post('mes');
			$from_name = $this->session->userdata('user');
			$from_id   = $this->session->userdata('users_id');

			if(empty($from_email)){
				$parent_id  = $this->session->userdata('child_parent_id');
				$details	= $this->model_members->get_user_id($parent_id);
				$from_email = $details['EmailID'];
			}

			$to_email = $this->input->post('contact_email');
			$fname    = $this->input->post('fname');
			$lname    = $this->input->post('lname');
			$id		  = $this->input->post('id');

			if(empty($to_email)){
				$to_email = $this->input->post('alter_contact_email');
			}

			$this->load->library('email');
			$this->email->set_newline("\r\n");
			$this->email->from('admin@a2msports.com', 'A2mSports');
			$this->email->to($to_email);
			$this->email->subject('New Contact Message - '.$from_name.'/A2MSports');

			$data = array(
				  'fname'	 => $fname,
				  'from_name'=> $from_name,
				  'from_id'	 => $from_id,
				  'lname'	 => $lname,
				  'message'	 => $mes,
				  'page'	 => 'Contact Player');

			$body = $this->load->view('view_email_template.php',$data,TRUE);

			$this->email->message($body);   
			$res = $this->email->send();
			
			if($res){
			  redirect("player/$id");
			}
		}
		
	}