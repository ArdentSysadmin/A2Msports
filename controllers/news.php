<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
	class News extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_news');
			$this->load->model('model_general', 'general');
		}
		
		// viewing league page ...
		public function index()
		{
			$data['results'] = $this->model_news->get_news();
			$data['news_list'] = $this->model_news->get_all_news();

			$this->load->view('includes/header');
			$this->load->view('view_list_news' ,$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
	    }

		public function get_news_detail($news_id)
		{
			$data['news_id_det'] = $this->model_news->get_news_detail($news_id);

			$data['results'] = $this->model_news->get_news();

			$this->load->view('includes/header');
			$this->load->view('view_latest_news' ,$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		
		}

		public function add()
		{
			
		  // $admin_users = array(214,215);
		   $user_id = $this->session->userdata('users_id'); 
		
		   //if(in_array($user_id, $admin_users)){
			$admin_sess_user = $this->session->userdata('role');
			if(strtoupper($admin_sess_user)=='ADMIN'){

			$data['results'] = $this->model_news->get_news();

			$path = '../js/ckfinder';
			$width = '780px';
			$this->editor($path, $width);

			$data['sports'] = $this->model_news->get_all_aports();

			$this->load->view('includes/header');
			$this->load->view('view_add_news',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');

		   }
		   else
		   {
				echo "<h4>Unauthorized Access</h4>";
		   }

		}

		public function editor($path,$width){
			
			//Loading Library For Ckeditor
			$this->load->library('ckeditor');
			$this->load->library('ckFinder');
			//configure base path of ckeditor folder 
			$this->ckeditor->basePath = base_url().'js/ckeditor/';
			$this->ckeditor->config['toolbar'] = 'Full';
			$this->ckeditor->config['language'] = 'en';
			$this->ckeditor->config['width'] = $width;
			//configure ckfinder with ckeditor config 
			$this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
		}

		public function add_news()
		{
			if($this->input->post('add_news'))
			{
				
			//	print_r($_POST);
			//	exit;
				$res = $this->model_news->insert_news();
				if($res)
				{
					//$admin_users = array(214,215);
					$user_id = $this->session->userdata('users_id'); 
					
					$admin_sess_user = $this->session->userdata('role');
					if(strtoupper($admin_sess_user)=='ADMIN'){

						$data['results'] = $this->model_news->get_news();

						$path = '../js/ckfinder';
						$width = '780px';
						$this->editor($path, $width);

						$data['add_news'] = "News Successfully added.";
						$data['sports'] = $this->model_news->get_all_aports();

						$this->load->view('includes/header');
						$this->load->view('view_add_news',$data);
						$this->load->view('includes/view_right_column',$data);
						$this->load->view('includes/footer');	
						
					 }else
					  {
						 echo "<h4>Unauthorized Access</h4>";
					  }
				}
			}
			else
			{
					 echo "<h4>Invalid Access</h4>";

			}
		}

		
		public function edit($news_id)
		{
			
			//$admin_users = array(214,215);
		    $user_id = $this->session->userdata('users_id'); 
				
			$admin_sess_user = $this->session->userdata('role');
			if(strtoupper($admin_sess_user)=='ADMIN'){

				$path = '../js/ckfinder';
				$width = '780px';
				$this->editor($path, $width);
			
				$data['news_id_edit'] = $this->model_news->edit_news_detail($news_id);

				$data['results'] = $this->model_news->get_news();
				$data['sports'] = $this->model_news->get_all_aports();

				$this->load->view('includes/header');
				$this->load->view('view_news_edit' ,$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');

			}
			else
			 {
				 echo "Unauthorized Access";
			 }
		
		}


		public function update_news($news_id)
		{

			$res = $this->model_news->update_news($news_id);
			if($res)
			{
				
				$data['news_id_det'] = $this->model_news->get_news_detail($news_id);
				$data['results'] = $this->model_news->get_news();

				$this->load->view('includes/header');
				$this->load->view('view_latest_news' ,$data);
				$this->load->view('includes/view_right_column',$data);
				$this->load->view('includes/footer');
					
			}
		}
	}