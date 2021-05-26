<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Home extends CI_Controller {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('home_model', 'home');
			$this->load->model('model_general','general');
			$this->load->model('model_news');
		}
		
		public function index()
		{
			$sport = $this->general->get_sports();
			
			$games = array();
			$i = 1;
			foreach($sport as $row)
			{
				if($i < 7)   // Added this condition to avoid disturbing in home page layout with 7 tournaments
				{
				$game =  $row->SportsType_ID;
				
				$data['games'][$i] = $this->home->get_specific_sport($game);
				}
			$i++;
			}

				// $teams = $data['games'];

			//	echo '<pre>';
			//	print_r($data['games']);
			//	exit;

			$limit = 6;
			$data['results'] = $this->model_news->get_news($limit);
			$data['members'] =  $this->home->get_count_members();
			$data['tourns'] =  $this->home->get_count_tourns();
			$data['gen_matches'] =  $this->home->get_count_matches();
			$data['tourn_matches'] =  $this->home->get_count_tourn_matches();
			$this->load->view('view_home',$data);
		}
		
		public function get_news()
		{
			$user_id = $this->session->userdata('users_id');
			$this->db->select('*');
			$this->db->from('Sports_News');
			$query=$this->db->get();
			return $query->result();
		}

		public function flyer()
		{
			//$this->load->view('includes/header');
			$this->load->view('flyer',$data);
			//$this->load->view('includes/footer');
		}
	
	} 
?>