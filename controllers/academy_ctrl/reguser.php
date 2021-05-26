<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	session_start(); 
	//RegisterUser from external site controller ..
	class Reguser extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();

			$this->load->helper(array('form', 'url'));

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('image_lib');

			//$url_seg1 = $this->uri->segment(2);
			//$url_seg2 = $this->uri->segment(2);
			//$url_seg3 = $this->uri->segment(3);
			
					//$last_url = array('redirect_to'=>$url_seg1."/".$url_seg2."/".$url_seg3);
					//$this->session->set_userdata($last_url);

			//$this->load->library('rrobin');
			$this->load->helper('directory');
			//$this->load->model('model_league');
			$this->load->model('model_news');
			$this->load->model('model_general');
			$this->load->model('model_register','reg_model');
		}
		
		// viewing league page ...
		public function index()
		{

		echo "<h4>Unauthorized Access!</h4>";	
		/*	$url_seg = $this->uri->segment(1); 
			$last_url = array('redirect_to'=>$url_seg);
			$this->session->set_userdata($last_url);

			$data['intrests'] = $this->model_league->get_intrests();
			$data['results'] = $this->model_news->get_news();
			
			$this->load->view('includes/header');
			$this->load->view('view_league',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');*/
		}

		public function get_details()
		{
		
			$arr_fields = array('fname','lname','gender','email','dob','phone','address','city','state','country','zipcode');
			
			$p = $this->uri->segments;
			
			for($i=3;$i<=count($p);){
				if(in_array($p[$i], $arr_fields)){
					$key = $p[$i];
					$val = $p[++$i];

					(!in_array($val, $arr_fields)) ? $data[$key] = $val : $data[$key] = "";
				}
				else
				{
					$i++;
				}
			}
			if($data['fname'] == "" and $data['lname'] == ""){
			
				echo "<h4>Error: Name should not be empty!</h4>";
				exit;

			}
			$data['latt'] = $this->get_lang_latt($data);

			$res = $this->reg_model->insert_third_party_user($data);
			
			echo "<h4>Token: $res</h4>";
		}

		public function get_lang_latt($data)
		{
			
		  $data['third_party_details'] = $data;
		  $third_party_details = $data['third_party_details'];
		
		  $add = $third_party_details['address'];
		  $city = $third_party_details['city'];
		  $state = $third_party_details['state'];
		  $country = $third_party_details['country'];


		  $address =  $add . ' ' .  $country . ' ' .  $state . ' ' .  $city ;

				if(!empty($add)){

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
				} else {
					return false;
				}
		
		}

		
	}