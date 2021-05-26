<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//League controller ..
session_start();
class Help extends CI_Controller {
	
		public function __construct()
		{
			parent:: __construct();
			$this->load->model('model_help');
			$this->load->model('model_news');
			$this->load->helper('url'); $this->load->helper('email');
			$this->load->helper('captcha');
			$this->load->model('model_general', 'general');
		}
		
		// viewing league page ...
		public function index()
		{
			$data['results'] = $this->model_news->get_news();
			$this->load->view('includes/header');
			$this->load->view('view_help');
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}
		
		public function help_content()  
		{
			$data['results'] = $this->model_news->get_news();

			$this->load->view('includes/header');
		    $this->load->view('view_help_content');
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}


		public function contactus()
		{
			$random_alpha = md5(rand());
			$captcha_code = substr($random_alpha, 0, 6);

			$values = array(
						'word' => $captcha_code,
						'word_length' => 6,
						'img_path' => './captcha/',
						'img_url' => base_url() .'captcha/',
						'font_path' => base_url() . 'system/fonts/texb.ttf',
						'img_width' => '150',
						'img_height' => '30',
						'expiration' => 30
						);

			$data = create_captcha($values);
			
			$captcha = array('contact_captcha' => $data['word']);

			$this->session->set_userdata($captcha);

			//$_SESSION['captchaWord'] = $data['word'];

			// image will store in "$data['image']" index and its send on view page

			$data['results'] = $this->model_news->get_news();

			$this->load->view('includes/header');
		    $this->load->view('view_contact',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');	
		}

		// For new image on click refresh button.
		public function captcha_refresh()
		{
			$random_alpha = md5(rand());
			$captcha_code = substr($random_alpha, 0, 6);

			$values = array(
			'word' => $captcha_code,
			'word_length' => 6,
			'img_path' => './captcha/',
			'img_url' => base_url() .'captcha/',
			'font_path' => base_url() . 'system/fonts/texb.ttf',
			'img_width' => '150',
			'img_height' => '30',
			'expiration' => 30
			);

			$this->session->unset_userdata('contact_captcha');
			$data = create_captcha($values);

			$captcha = array('contact_captcha' => $data['word']);
			$this->session->set_userdata($captcha);

			echo $data['image'];
		}

		public function send_email()
		{
			$sess_cap  = $this->session->userdata('contact_captcha');
			$enter_cap = $this->input->post('enter_captcha');

			if($sess_cap == $enter_cap){
				
					if($this->session->userdata('user') == ""){
							
						$name = $this->input->post('name');
						$user_email = $this->input->post('user_email');
						$phone = $this->input->post('phone');
						$topic = $this->input->post('topic');
						$des = $this->input->post('des');
						
						$this->load->library('email');
						$this->email->set_newline("\r\n");
					
						$this->email->from($user_email);
						$this->email->to('admin@a2msports.com', 'A2MSports'); 
						$this->email->subject('A2msports Enquiry - '. $topic);

						$data = array(
								'name'=> $name,
								'email'=> $user_email,
								'phone'=> $phone,
								'topic' => $topic,
								'des' => $des,
								'page'=> 'Contact-US'
								);

								$body = $this->load->view('view_email_template.php',$data,TRUE);

								$this->email->message($body);   
								$stat = $this->email->send();
								//$stat = true;
							
							if($stat)
							{
								echo "Equal";
							}
						}
						else {
							
							$user = $this->session->userdata('user');
							$email = $this->session->userdata('email');
							$user_id = $this->session->userdata('users_id');
							$user_details = $this->model_help->get_details($user_id);
							$phone = $user_details['Mobilephone'];
							
							$topic = $this->input->post('topic');
							$des = $this->input->post('des');
							
							$this->load->library('email');
							$this->email->set_newline("\r\n");
						
							$this->email->from($email);
							$this->email->to('admin@a2msports.com', 'A2MSports'); 
							$this->email->subject('A2msports Enquiry - '. $topic);

							$data = array(
									'name'=> $user,
									'email'=> $email,
									'phone'=> $phone,
									'topic' => $topic,
									'des' => $des,
									'page'=> 'Contact-US'
									);

							$body = $this->load->view('view_email_template.php',$data,TRUE);

							$this->email->message($body);   

							$stat = $this->email->send();

							//$stat = true;

							if($stat)
							{
								echo "Equal";	
							}

				        }

					}
					else
					{
						echo "UnEqual"; 
					}
		}

	 public function req_demo()
	 {
		$name  = $this->input->post("txt_req_name");
		$email = $this->input->post("txt_req_email");

		if($email != "")
		{
			$this->load->library("email");
			$this->email->set_newline("\r\n");
		
			$this->email->from($email);
			//$this->email->to('admin@a2msports.com', 'A2MSports'); 
			$this->email->to("npradkumar@gmail.com", "A2MSports"); 
			$this->email->subject("A2msports Request Demo");

			$data = array(
					'name' => $name,
					'email'=> $user_email,
					'page' => 'Request-Demo'
					);

			$body = $this->load->view('view_email_template.php',$data,TRUE);

			$this->email->message($body);   
			$stat = $this->email->send();
			if($stat){
				redirect('help/thanks');
			}
		}
	 }

	 public function thanks()
	 {
		$data['results'] = $this->model_news->get_news();

		$data['msg']  = "Thanks for contacting us. We will get back to you soon.";

		$this->load->view('includes/header');
		$this->load->view('view_thanks',$data);
		$this->load->view('includes/view_right_column',$data);
		$this->load->view('includes/footer');
	 }

}