<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
	class User extends CI_Controller {
	
		public function __construct(){
			parent:: __construct();
			$this->load->model('model_user');
		}
		
		// viewing league page ...
		public function index(){
			
			//print_r($this->session->userdata);
			//exit;
			$admin = $this->session->userdata('admin');
			if($admin){
				$this->load->view('includes/header');
				$this->load->view('view_admin');
				$this->load->view('includes/view_right_column');
				$this->load->view('includes/footer');
			}
			else{
				echo "<h4>Unauthorized Access</h4>";
			}
		}
		
		public function update_a2m(){
			$get_users	= $this->model_user->get_users_no_a2m();
			$sports		= $this->model_user->get_sports();

			foreach($get_users as $i => $user){
				foreach($sports as $type){
					$data = array('SportsType_ID'=>$type->SportsType_ID,'Users_ID'=>$user->Users_ID ,'A2MScore'=>100);
					$this->db->insert('A2MScore', $data); 
				}
			}
		}

		/*public function update_lat_long(){
			$get_users	= $this->model_user->get_users_no_lat_long();
			foreach($get_users as $i => $user){
					$user->Users_ID;
					$user->Addressline1;
					$user->Addressline2;
					$user->City;
					$user->State;
					$user->Country;

					
					$data = array('SportsType_ID'=>$type->SportsType_ID,'Users_ID'=>$user->Users_ID ,'A2MScore'=>100);
					$this->db->insert('A2MScore', $data); 
				
			}

		}*/
		
	}