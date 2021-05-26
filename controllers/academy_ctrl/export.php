<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      // session_start(); 

	class Export extends CI_Controller {
	
	 	public $header_tpl	   = "academy_views/includes/academy_header";
		public $reserve_tpl    = "academy_views/includes/academy_reserve";
	 	public $right_col_tpl  = "academy_views/includes/academy_right_column";
	 	public $footer_tpl	   = "academy_views/includes/academy_footer";

		public $logged_user;
		public $is_club_member;
		public $short_code;
		public $org_id;
		public $academy_admin;

		public function __construct()
		{
			parent:: __construct();
			$this->load->helper('form', 'url');
			$this->load->library('form_validation');
			$this->load->library('session');

			/*if(!$this->session->userdata('user')){

				$url_seg1 = $this->uri->segment(1);
				$url_seg2 = $this->uri->segment(2);
				$url_seg3 = $this->uri->segment(3);
				$url_seg4 = $this->uri->segment(4);
				
				$last_url = array('redirect_to' => $url_seg1."/".$url_seg2."/".$url_seg3."/".$url_seg4);
				$this->session->set_userdata($last_url);

				redirect('login');
			}*/

			// Load database			
			$this->load->model('academy_mdl/model_courts',  'model_courts');
			$this->load->model('academy_mdl/model_news',	'model_news');
			$this->load->model('academy_mdl/model_general', 'general');
			$this->load->model('academy_mdl/model_academy', 'model_academy');
			$this->load->library('paypal_lib');

			$this->short_code    = $this->uri->segment(1);
			$this->logged_user   = $this->session->userdata('users_id');
			$this->org_id	     = $this->general->get_orgid($this->short_code);
			$this->academy_admin = $this->general->get_org_admin($this->short_code);
			$det = $this->general->check_is_member($this->org_id, $this->logged_user);
			$this->is_club_member = ($det['tab_id']) ? 1 : 0;
			
			$this->admin_menu_items = array('0'=>'');
			if($this->logged_user != $this->academy_admin)
			$this->admin_menu_items = array('0'=>'8');
		}

	public function court_reservations()
	{
		//error_reporting(-1);
		//echo "<pre>";		print_r($_POST);		exit;
		$sel_loc = json_decode($this->input->post('sel_locations'), true);

		if(empty($sel_loc)){
			echo "Invalid access!"; exit;
		}
		$this->load->model("academy_mdl/model_export");
		$this->load->library("excel");
		$object = new PHPExcel();

		$object->setActiveSheetIndex(0);
		$table_columns = array("Court", "Location", "Reserved By", "Reservation Date", "From", "To", "Fee Paid ", "Status", "Players", "Match Format", "Reservation Made on");

		$column = 0;

		foreach($table_columns as $field){
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$excel_row = 2;

		foreach($sel_loc as $loc){
			$loc_courts = $this->model_courts->get_loc_courts_all($loc);
					foreach($loc_courts as $court){
							$court_res = $this->model_courts->get_court_reservations($loc, $court->court_id);
							if(!empty($court_res)){
							//echo "<pre>";		print_r($court_res);exit;
								foreach($court_res as $res){
									$court_name = $this->model_export->get_court_name($res->court_id);
									$get_loc		= $this->model_export->get_loc_info($res->loc_id);
									$username	= $this->model_export->get_user($res->reserved_by);

									$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $court_name);
									$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $get_loc['location']);
									$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $username);
									$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, date('m-d-Y', strtotime($res->res_date)));
									$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, date('H:i:s', strtotime($res->from_time)));
									$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, date('H:i:s', strtotime($res->$res->to_time)));
									$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $res->fee_paid);
									$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $res->res_status);
									$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $res->players);
									$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $res->match_format);
									$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, date('m-d-Y', strtotime($res->created_on)));
									$excel_row++;

								}
							}
					}
					//echo "-------</br>";
		}
		//exit;
		//error_reporting(-1);	

		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Employee Data.xls"');
		$object_writer->save('php://output');
	}

	}