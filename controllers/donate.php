<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Donate extends CI_Controller 
{
	 public $logged_user;
     public function  __construct(){
        parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('image_lib');
		$this->load->helper('directory');

        $this->load->library('paypal_lib');
        $this->load->model('model_league');
		$this->load->model('model_general','general');
		$this->load->model('model_news');

		if($this->session->userdata('users_id')){
			$this->logged_user = $this->session->userdata('users_id');
		}
		else{
			$this->logged_user = "";
		}
     }
     
	 public function index(){
		 
		$data['intrests'] = $this->model_league->get_intrests();
		$data['results'] = $this->model_news->get_news();

		$this->load->view('includes/header');
		$this->load->view('view_donate');
		$this->load->view('includes/view_right_column', $data);
		$this->load->view('includes/footer');

	 }

	 public function sponsor($tid){
		$data['tid']   = $tid;
		$data['title'] = $this->model_league->get_tourn_title($tid);

		$this->load->view('includes/header');
		$this->load->view('view_sponsor', $data);

		$data['intrests'] = $this->model_league->get_intrests();
		$data['results']  = $this->model_news->get_news();

		$this->load->view('includes/view_right_column', $data);
		$this->load->view('includes/footer');
	 }

	 public function sponsor_now(){
		
		$tid	  = $this->input->post('tid');
		$sp_name  = $this->input->post('sponsor_name');
		$sp_url	  = $this->input->post('sponsor_url');
		$tour_det = $this->model_league->getonerow($tid);
		$amount   = $this->input->post('sponsor_amount');

		if($amount > 0){
			$sp_ins_id = '';
			if(!empty($_FILES['sponsor_image']['name'])){
				$filename = 'sponsor_image';  
				$config = array(
					'upload_path'	=> "./tour_pictures/ext_sponsors/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite'		=> FALSE,
					'max_size'		=> "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height'	=> "5000",
					'max_width'		=> "8000"
					);
				
				$this->load->library('upload', $config);
				//$data = $this->upload->data();
				//$this->upload->initialize($config);
				
				if($this->upload->do_upload($filename)){	
					$up_data = $this->upload->data();
					
					$data = array(
						'Tourn_ID'		=> $tid,
						'Users_ID'		=> $this->logged_user,
						'Sponsor_Name'	=> $sp_name,
						'Sponsor_Image' => $up_data['file_name'],
						'Sponsor_URL'	=> $sp_url
						);

					$sp_ins_id = $this->model_league->insert_ext_sponsor($data);
				}
				else{
					echo "Oops, Something went wrong! Please write to us at <a href='mailto:admin@a2msports.com'>admin@a2msports.com</a>";
					//print_r($this->upload->display_errors());
					exit;
				}
			}

			$sp_userid = $this->logged_user;

			//Set variables for paypal form
			$paypalURL = PAYPAL_URL; //PayPal api url
			$paypalID  = PAYPAL_ID;  //business email

			$returnURL = base_url().'sponsor/sp_success?tid='.$tid.'&reg_user='.$sp_userid.'&sp_ins='.$sp_ins_id; 
			//payment success url

			$cancelURL = base_url().'sponsor/cancel'; //payment cancel url
			$notifyURL = base_url().'sponsor/ipn';	 //ipn url


			$logo = base_url().'images/logo.png';
			
			$this->paypal_lib->add_field('business', $paypalID);
			$this->paypal_lib->add_field('return', $returnURL);
			$this->paypal_lib->add_field('cancel_return', $cancelURL);
			$this->paypal_lib->add_field('notify_url', $notifyURL);
			$this->paypal_lib->add_field('on0', $this->logged_user);
			$this->paypal_lib->add_field('item_number',  $tid);
			$this->paypal_lib->add_field('item_name',  $tour_det->tournament_title);
			$this->paypal_lib->add_field('amount', $amount);        
			$this->paypal_lib->image($logo);
			
			$this->paypal_lib->paypal_auto_form();
		 }
		 else{
			echo "Invalid Requestt!";
		 }
	 }


	 public function sp_success(){

		$spInfo = $this->input->get();
		$prev_ins_sp	     = $spInfo['sp_ins'];

		$data['sponsored_on']= date('Y-m-d h:i:s');
		$data['Tourn_ID']    = $spInfo['tid'];
		$data['Users_ID']    = $spInfo['reg_user'];
		$data['Trans_id']    = $spInfo['tx'];
		$data['Amount']      =  $spInfo['amt'];
		$data['Currency_Code'] = $spInfo['cc'];
		$data['Status']	  	 = $spInfo['st'];

		if($prev_ins_sp){
		$this->model_league->update_sponsorships($prev_ins_sp, $data);
		}
		else{
		$this->model_league->insert_ext_sponsor($data);
		}

		$data['intrests'] = $this->model_league->get_intrests();
		$data['results']  = $this->model_news->get_news();
		$data['status']   = $spInfo['st'];
		$data['league']   = $spInfo['item_name'];

		$this->load->view('includes/header');
		$this->load->view('view_sponsor', $data);
		$this->load->view('includes/view_right_column', $data);
		$this->load->view('includes/footer');
	 }

	 public function success(){
		$donateInfo = $this->input->get();

		$data['donated_on']	 = date('Y-m-d h:i:s');
		$data['Trans_id']    = $donateInfo['tx'];
		$data['Amount']      =  $donateInfo['amt'];
		$data['Currency_Code'] = $donateInfo['cc'];
		$data['Status']	  	 = $donateInfo['st'];
		$data['Users_ID']    = $this->session->userdata('users_id');

		$this->model_league->update_donations($data);

		$data['intrests'] = $this->model_league->get_intrests();
		$data['results']  = $this->model_news->get_news();
		$data['status']   = $donateInfo['st'];

		$this->load->view('includes/header');
		$this->load->view('view_donate', $data);
		$this->load->view('includes/view_right_column', $data);
		$this->load->view('includes/footer');
	 }

	 public function cancel(){
		echo "Sorry, your last transaction is cancelled!";
		exit;
	 }

	 public function testview(){
		$this->load->view('includes/header');
		$this->load->view('view_thanks');
		$this->load->view('includes/view_right_column');
		$this->load->view('includes/footer');
	 }
}