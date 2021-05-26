<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Home extends CI_Controller {
		
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('home_model', 'home');
			$this->load->model('model_general','general');
			$this->load->model('model_news');
			$this->load->helper('captcha');
		}
		
		public function index()
		{
			$sport = $this->general->get_sports();
			
			$games = array();
			$i = 1;
			foreach($sport as $row){
				if($i <= count($sport)) {  // Added this condition to avoid disturbing in home page layout with 7 tournaments
				$game = $row->SportsType_ID;
				$data['games'][$i] = $this->home->get_specific_sport($game);
				}
			$i++;
			}

			/*$get_sponsors = $this->general->get_sponsors();

			foreach($get_sponsors as $sponsor){
				$sp = json_decode($sponsor->Sponsors, true);

				$sp_list[$sponsor->tournament_ID] = $sp; 
			}*/

			$limit = 6;
			$data['results']					= $this->model_news->get_news($limit);
			$data['members']				=  $this->home->get_count_members();
			$data['tourns']					=  $this->home->get_count_tourns();
			$data['gen_matches']		=  $this->home->get_count_matches();
			$data['tourn_matches']	=  $this->home->get_count_tourn_matches();
			//$data['sp_list']					=  $sp_list;
			$this->load->view('view_home', $data);
		}

		public function test_home()
		{
			$sport = $this->general->get_sports();
			
			$games = array();
			$i = 1;
			foreach($sport as $row)
			{
				if($i <= count($sport))   // Added this condition to avoid disturbing in home page layout with 7 tournaments
				{
				$game =  $row->SportsType_ID;
				
				$data['games'][$i] = $this->home->get_specific_sport($game);
				}
			$i++;
			}

			$get_sponsors = $this->general->get_sponsors();
			
			foreach($get_sponsors as $sponsor){
				$sp = json_decode($sponsor->Sponsors, true);

				$sp_list[$sponsor->tournament_ID] = $sp; 
			}
			//echo "<pre>";print_r($sp_list); exit;

			$limit = 6;
			$data['results']		=  $this->model_news->get_news($limit);
			$data['members']		=  $this->home->get_count_members();
			$data['tourns']			=  $this->home->get_count_tourns();
			$data['gen_matches']	=  $this->home->get_count_matches();
			$data['tourn_matches']	=  $this->home->get_count_tourn_matches();
			$data['sp_list']	=  $sp_list;
			$this->load->view('view_home_test',$data);
		}

		public function priv_policy(){
			$this->load->view('view_privacy_policy');
		}

		public function test(){
			$this->load->library('twitterfetcher');

			$tweets = $this->twitterfetcher->getTweets(array(
					'consumerKey'       => 'a00L23JvXtnWt3Hmrq2jy8wAJ',
					'consumerSecret'    => 'zwdrrj2OF2B85usDbJty0rZ82m4hmfXoaOuBn0jqMYxi7Q0NJL',
					'accessToken'       => '928473536875892741-3rKmpOqG8JRxggUmI36fmGhws2O7WbR',
					'accessTokenSecret' => 'gSu0ErteB7JJIJQ0mqQM8fmPtz4srjgDgL2oWib7YGDPI',
					'usecache'          => false,
					'count'             => 2,  //this how many tweets to fectch
					'numdays'           => 30
				));
			$data['twiites'] = $tweets  ; 
			$this->load->view('view_test2', $data);
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
	
		public function captcha_refresh()
		{
			$random_alpha = md5(rand());
			$captcha_code = substr($random_alpha, 0, 6);

			$values = array(
			'word' => $captcha_code,
			'word_length'=> 6,
			'img_path'	 => './captcha/',
			'img_url'	 => base_url() .'captcha/',
			'font_path'	 => base_url() . 'system/fonts/texb.ttf',
			'img_width'	 => '150',
			'img_height' => '30',
			'expiration' => 30
			);

			$this->session->unset_userdata('contact_captcha');
			$data['captcha'] = create_captcha($values);

			$captcha = array('contact_captcha' => $data['captcha']['word']);
			$this->session->set_userdata($captcha);

			echo $data['captcha']['image'];
		}

		public function init_captcha()
		{
			$random_alpha = md5(rand());
			$captcha_code  = substr($random_alpha, 0, 6);

			$values = array(
						'word' => $captcha_code,
						'word_length' => 6,
						'img_path' => './captcha/',
						'img_url' => base_url() .'captcha/',
						'font_path' => base_url() . 'system/fonts/texb.ttf',
						'img_width' => '150',
						'img_height' => '30',
						'expiration' => 120
						);

			$data = create_captcha($values);

			$captcha = array('req_captcha' => $data['word']);

			$this->session->set_userdata($captcha);
			return $data;
		}

		public function watch_intro()
		{
			$this->load->view('view_introvideo');
		}
	}
?>