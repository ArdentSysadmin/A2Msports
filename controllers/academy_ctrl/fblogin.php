
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	  session_start(); 
	//login controller ..
	class Fblogin extends CI_Controller {
		
		public $user = null;
	
		public function __construct()
		{
			
			parent:: __construct();

			parse_str($_SERVER['QUERY_STRING'] , $_REQUEST);
			$this->load->library('facebook' ,  array( "appId" => '792863394192570' , "secret" => '3af064a75201ceb1552db607d3d63fad' ));
			
			//$this->load->model('model_login');
			$this->user = $this->facebook->getUser();
			$this->load->model('model_fb');
			
			$this->load->library('session');  //Load the Session 
		}
		
		
		// login into the website ,, checking the user details w.r.to Database
		
		public function index()
		{
		   	
			if ($this->user) {
				try {

                    $public_profile = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
					
					echo "<pre>";
					print_r($public_profile);
	
				} catch (FacebookApiException $e) {
					print_r($e);
					$user = null;
				}
			}
			
		    if ($this->user) {
				
				$data['logout'] = $this->facebook->getLogoutUrl(array("next" => base_url().'Fblogin/logout'));
				echo "<a href='http://localhost/a2msports/login/logout'>LogOut</a>" ;
			//	echo  "$data['logout']" ;
			}else {
				$data['login'] = $this->facebook->getLoginUrl();
				//echo "<a href='$login'>Login</a>" ;
			}
			
			$this->load->view('includes/header');
			$this->load->view('view_login' , $data);
			$this->load->view('includes/footer');
			
			
	    }
		
		
		
		public function logout()    //for facebook log out 
		{
           
		   $this->load->library('session'); 
		   $base_url=$this->config->item('base_url'); //Read the baseurl from the config.php file
		   $this->session->sess_destroy();  //session destroy
		   
		   // Logs off session from website
            $this->facebook->destroySession();
			
		   redirect('/'); //redirect to the home page
		 
			
        }
		
		
	 	
	}
