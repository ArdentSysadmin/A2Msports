<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class model_news extends CI_Model {
		
		public function __construct()
		{
			parent:: __construct();
			
		}

		public function get_news($limit = '')
		{
			if($limit == '') { $limit = 3; }
			$user_id = $this->session->userdata('users_id');
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->where('Org_Id =',0);
			$this->db->order_by("Modified_on", "desc");
			$this->db->limit($limit);
			$query=$this->db->get();

			//print_r($this->db->last_query());
			//exit;
			return $query->result();
		}

		public function get_all_aports()
		{
			$this->db->select('*');
			$this->db->from('SportsType');
			$query=$this->db->get();
			return $query->result();
		}

		public function get_all_news()
		{
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->order_by("Modified_on", "desc");
			$query=$this->db->get();
			return $query->result();
		}

		public function get_news_detail($news_id)
		{
			$data = array('News_id'=>$news_id);
			$get_name = $this->db->get_where('Sports_News',$data);
			return $get_name->row_array();
		}

		public function edit_news_detail($news_id)
		{
			$data = array('News_id'=>$news_id);
			$get_name = $this->db->get_where('Sports_News',$data);
			return $get_name->row_array();
		}


		public function update_news($news_id)
		{
			$message = addslashes($this->input->post('description'));
			$title = $this->input->post('title');
			$sport = $this->input->post('sport');
			$modified = date('Y-m-d H:i:s');

			$data = array('News_content' => $message ,'News_title' => $title,'Modified_on'=>$modified,'SportsType_id'=>$sport);

			$this->db->where('News_id', $news_id);
			$result = $this->db->update('Sports_News', $data); 
		
			return $result;
		}

		public function insert_news()
		{
		   $title = $this->input->post('title');
		   $sport = $this->input->post('Sport');
		   $des = addslashes($this->input->post('description'));
		   // $created = date("Y-m-d h:i:s");

		   $created_user  = $this->session->userdata('users_id');
		   $org_id = 0;

		   $notifiy_users = 0;
		   
		   if($this->input->post('send_email_flag') == 1){
			  $notifiy_users = 1;
		   }

			$data = array(
			'News_title'	=> $title,
			'News_content'	=> $des,
			'SportsType_id' => $sport,
			'Created_by'	=> $created_user,
			'Org_Id'		=> $org_id
			);

		   $result  = $this->db->insert('Sports_News', $data);
		   $news_id = $this->db->insert_id();      

			if($notifiy_users == 1)
			{
				$data = array(
					'mtype'		  => 'News',
					'rel_id'	  => $news_id,
				    'is_academy'  => 0,
					'is_notified' => 0,
					'created_on'  => date('Y-m-d H:i'),
					'notified_on' => NULL
					);

		     $this->db->insert('Notification_Alerts', $data);
			}
		  return $result;
		}

		public function getNews_By_SportsType($sportsType, $limit = '')
		{
			if($limit == '') { $limit = 3; }
			$user_id = $this->session->userdata('users_id');
			$this->db->select('*');
			$this->db->from('Sports_News');
			$this->db->where('Org_Id','0');
			$this->db->where('SportsType_id',$sportsType);
			$this->db->order_by("Modified_on", "desc");
			$this->db->limit($limit);
			$query=$this->db->get();

			//print_r($this->db->last_query());
			//exit;
			return $query->result();
		}

	}