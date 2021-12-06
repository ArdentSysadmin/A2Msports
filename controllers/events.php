<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Events controller ..
class events extends CI_Controller {

	public function __construct() {
		parent:: __construct();

		$this->load->helper(array('form', 'url'));
		
		// Load session library
		$this->load->library('session');
		/*if(!$this->session->userdata('user')){
			redirect('login');
		}*/

		$this->load->model('model_event');
		$this->load->model('model_general', 'general');
		$this->load->model('model_news');
	}

	public function index()
	{
		$url_seg = $this->uri->segment(1); 
		$last_url = array('redirect_to'=>$url_seg);
		$this->session->set_userdata($last_url);

		$data['event_types'] = $this->model_event->get_event_types();
		$data['results']	 = $this->model_news->get_news();
		$this->load->view('includes/header');
		$this->load->view('view_event',$data);
		$this->load->view('includes/view_right_column',$data);
		$this->load->view('includes/footer');
	}

	public function get_user_det($user_id){
		return $this->general->get_user($user_id);
	}

	public function add()
	{
		$data['intrests']	 = $this->model_event->get_intrests();
		$data['event_types'] = $this->model_event->get_event_types();
		$data['results'] = $this->model_news->get_news();

		$this->load->view('includes/header');
		$this->load->view('view_event',$data);
		$this->load->view('includes/view_right_column',$data);
		$this->load->view('includes/footer');
	}
	
	public function get_sport($sport_id)
	{
		return $this->model_event->get_sport_title($sport_id);
	}

	public function upd_status(){
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		$user_id  = $this->session->userdata('users_id');
		$event_id = $this->input->post('event_id');
		$ev_det   = $this->model_event->getonerow($event_id);
		
		if($ev_det['Fee'] != '' and $ev_det['Fee'] != NULL and $ev_det['Fee'] > 0 and $user_id != $ev_det['Ev_Created_by']){
			$is_paid = $this->model_event->check_user_paid($ev_id, $user_id);
			$count = 0;
			if(count($is_paid) == 0){
				$rep_id = $this->input->post('ev_rep_ids');
				$stat	= $this->input->post('upd_avail_list');
				$user	= $this->input->post('user_ids');
				foreach($rep_id as $i=>$rp){
					//echo $stat[$i];
					if($stat[$i] == '1'){
						$count++;
					}
				}
			}

			if($count > 0){
				echo "Payment Pending";
				exit;
			}
		}

		$res = $this->model_event->upd_status();

		$event_id = $this->input->post('event_id');
		$ev_det   = $this->model_event->getonerow($event_id);
		$creator  = $ev_det['Ev_Created_by'];
		$title	  = $ev_det['Ev_Title'];

		$this->load->library('email');
		$this->email->set_newline("\r\n");

		$sql = "SELECT Firstname,Lastname,EmailID, AlternateEmailID FROM users WHERE Users_ID = " .$creator;
		$result = $this->db->query($sql);
		$row = $result->row();

		$this->email->from(FROM_EMAIL, 'A2MSports');

		if($row->EmailID != ""){
			$this->email->to($row->EmailID);
		}
		else{
			$this->email->to($row->AlternateEmailID);
		}
		
		$this->email->subject($title. '(Status Update) - A2MSports');

		$data = array(
			 'event_id'	=> $event_id,
			 'title'	=> $title,
			 'firstname'=> $row->Firstname,
			 'lastname'	=> $row->Lastname,
			 'page'		=> 'Event Availability Status'
			);

		$body = $this->load->view('view_email_template.php',$data,TRUE);

		$this->email->message($body);   
		$this->email->send();


		$get_rep_ev = $this->model_event->get_rep_events($this->input->post('event_id'));

		$op = "<td width='187' style='padding-left:5px'><b>Available Players</b></td>";

		foreach($get_rep_ev as $rep_sch){
			$get_accpted_count = $this->model_event->get_res_count($rep_sch->Ev_Tab_ID);
			$op .= "<td width='147' align='center'><b>$get_accpted_count</b></td>";
		}

		echo $op;
	}

	public function get_user_details($player)
	{
		return $this->general->get_user($player);
	}

	public function get_event_name($ev_id)
	{
		return $this->model_event->get_event_name($ev_id);
	}

	public function create()
	{
		//echo "<pre>"; print_r($_POST); exit;

		 $filename = 'EventImage';  

		 $config = array(
			'upload_path' => "./events_pictures/",
			'allowed_types' => "gif|jpg|png|jpeg|pdf",
			'overwrite' => FALSE,
			'max_size' => "10000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'max_height' => "5000",
			'max_width' => "8000"
		 );
		
		$this->load->library('upload',$config);
		$data = $this->upload->data();
		$this->upload->initialize($config);

		if($this->upload->do_upload($filename)) 
		{

		    $data = $this->upload->data();
		    $ins_match = $this->model_event->create_event($data);
		    redirect("events/view/$ins_match/1");
		}
		else
		{
			 $ins_match = $this->model_event->create_event();
		     redirect("events/view/$ins_match/1");
		}
	}

	public function send_event(){

		if($this->input->post('btn_event_match')){

		$event_id	 = $this->input->post('ev_id');
		$sel_players = $this->input->post('sel_user');
		$ev_message  = $this->input->post('ev_message');
		$rep_events  = $this->model_event->get_rep_events($event_id);

		$ev_det		= $this->model_event->getonerow($event_id);
		$ev_title	= $ev_det['Ev_Title'];
		$creator	= $ev_det['Ev_Created_by'];
		$name		= $this->general->get_user($creator);
		$full_name  = ucfirst($name['Firstname'])." ".ucfirst($name['Lastname']);

		$this->load->library('email');
		$this->email->set_newline("\r\n");

		foreach($sel_players as $user_id){
			$data['user']	  = $user_id;
			$data['event_id'] = $event_id;
			$stat = 0;

			$is_ev_invite_user = $this->model_event->check_is_invited_user($data);
			if(!$is_ev_invite_user){
				foreach($rep_events as $obj){           
					$data['ev_rep_id'] = $obj->Ev_Tab_ID;
					$create_inv = $this->model_event->ins_ev_invite($data);
				}
			$stat = 1;
			}
				
			if($stat){
				$sql    = "SELECT Firstname,Lastname,EmailID,AlternateEmailID FROM users WHERE Users_ID = " .$user_id;
				$result = $this->db->query($sql);
				$row	= $result->row();

				$this->email->from(FROM_EMAIL, 'A2MSports');

				if($row->EmailID != ""){
					$this->email->to($row->EmailID);
				} 
				else{
					$this->email->to($row->AlternateEmailID);
				}

				$subject = "Invitation for ". $ev_title ." from ".$full_name;
				$this->email->subject($subject);

				$data = array(
					 'event_id'	=> $event_id,
					 'ev_title'	=> $ev_title,
					 'firstname'=> $row->Firstname,
					 'lastname'	=> $row->Lastname,
					 'message'	=> $ev_message,
					 'page'		=> 'New Event Invitation'
					);

				$body = $this->load->view('view_email_template.php', $data, TRUE);
				$this->email->message($body);   
				$this->email->send();
			}
		}
		redirect("events/$event_id/2");
		}
		else{
		echo "Invalid Access!";
		}
	}

	public function send_email_reg_players() {
	 
		if($this->input->post('send_invite_email')){

			$event_id = $this->input->post('ev_id');

			$ev_det	  = $this->model_event->getonerow($event_id);
			$ev_title = $ev_det['Ev_Title'];
			
			$sub	  = $this->input->post('subject');
			if($sub){
				$subject = $sub;
			}
			else{
				$subject = "Message from Event -". $ev_title;
			}

			$des = $this->input->post('mes');
			
			$this->load->library('email');
			$this->email->set_newline("\r\n");

			$sel_players = $this->input->post('sel_players');

		//	print_r($_POST);
		//	exit;

			foreach($sel_players as $user_id) {

			$sql = "SELECT * FROM users WHERE Users_ID = " .$user_id;
			$result = $this->db->query($sql);
			$row = $result->row();

			$this->email->from(FROM_EMAIL, 'A2MSports');

			if($row->EmailID != ""){
				$this->email->to($row->EmailID);
			}
			else {
				$this->email->to($row->AlternateEmailID);
			}

			$this->email->subject($subject." ");

			$data = array(
					'firstname' => $row->Firstname,
					'lastname'	=> $row->Lastname,
					'ev_title'  => $ev_title,
					'ev_id'		=> $event_id,
					'des'		=> $des,
					'page'		=> 'Send Email Event Players'
					);

			$body = $this->load->view('view_email_template.php',$data,TRUE);

			$this->email->message($body);   
			$this->email->send();
			}
			redirect("events/view/$event_id/3");

		}
	 }

	 public function add_comment()
	 {
		if($this->input->post('message'))
		{
			$res = $this->model_event->insert_comment();
			$event_id = $this->input->post('event_id');
			$get_ev_comments = $this->model_event->get_ev_comments($event_id);

		foreach($get_ev_comments as $comment){

			$name = $this->general->get_user($comment->Users_id);
			$full_name = ucfirst($name['Firstname'])." ".ucfirst($name['Lastname']);

			if($name['Profilepic'] != ''){
			$prof_pic = base_url()."profile_pictures/{$name['Profilepic']}";
			}
			else{
			$prof_pic = base_url()."profile_pictures/default-profile.png";
			}


			$op .= "<div class='pull-left' style='margin-right:20px'><img class='img-circle' src='{$prof_pic}' width='50px' height='50px' /></div><div style='margin-top:5px'><span style='font-weight:bold;color:#464646'>".$full_name."</span>
				<span style='font-size:11px; color:#959595'>".date("m/d/Y H:i", strtotime($comment->Comment_date))."</span>
				<div style='margin-top:5px;'>$comment->Comments</div>
			</div>
			<div style='clear:both; height:20px'></div>";
		}

		echo $op;

			//redirect("events/view/$ev_id/4");
		}
	 }

	public function location_add()
	{
		///data:{title:Title,add:Add,city:City,state:State,country:Country,zip:Zip},

		$title = $this->input->post('title');
		$add = $this->input->post('add');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$country = $this->input->post('country');
		$zip = $this->input->post('zip');

		$data['title'] = $title;
		$data['add']   =   $add;
		$data['city']  =  $city;
		$data['state'] = $state;
		$data['country'] = $country;
		$data['zip']   = $zip;

		//print_r($data);
		//exit;

		$event_location = $add . " " .$city . " " . $state . " " . $country;
		
		//$data['latt'] = $this->get_lang_latt($event_location);
		$data['latt'] = '0'.'@'.'0';

		$ins_location = $this->model_event->create_location($data);
		 
		echo $ins_location;
	}

	
	public function add_fields()
	{
		$count = $this->input->post('count');
		$sd = $this->input->post('sd');
		$ed = $this->input->post('ed');
		$st = $this->input->post('st');
		$et = $this->input->post('et');
		$loc_stat = $this->input->post('loc_stat');
		$loc_id = $this->input->post('ev_loc_id');
		$loc_title = $this->input->post('ev_loc_title');

		$sch_type = $this->input->post('sch_type');

		$op = "";

		$ev_date = ($sd=="") ? date('m/d/Y') : date('m/d/Y', strtotime($sd));

		for($x = 1; $x <= $count+1; $x++){

			$options1 = ""; $options2 = "";
			for($i = 0; $i < 24; $i++){
				$sel1 = ""; $sel2 = "";
				$sel_st1 = ($i % 12) ? ($i % 12).":00" : '12:00'; 
				$sel_st1 .= ($i >= 12) ? ' pm' : ' am';

				if($sel_st1 == $st) { $sel1 = "selected"; }
				if($sel_st1 == $et) { $sel2 = "selected"; }

				$options1 .= "<option value='".$sel_st1."' ".$sel1.">".$sel_st1."</option>";
				$options2 .= "<option value='".$sel_st1."' ".$sel2.">".$sel_st1."</option>";
			}
			
			$show_loc = "";
			if($loc_stat)
				{ $show_loc = "<td><input class='ui-autocomplete-input form-control evloc_class' type='text' style='width:80%' id='ev_rploc".$x."' name='ev_rploc".$x."' value='".$loc_title."'>
			<input type='hidden' style='width:80%' class='form-control' id='ev_rploc_id".$x."' name='ev_rploc_id[]' value='".$loc_id."'>
			</td>"; }

			$op .= "<script>
					$(document).ready(function(){					
					var baseurl = '".base_url()."';
					var fid = '".$x."';
							
						$('#ev_rploc'+fid).autocomplete({
						source: function( request, response ) {

							$.ajax({
								url: baseurl+'events/autocomplete',
								dataType: 'json',
								method: 'post',
								data: {
								   name_startsWith: request.term,
								   type: 'users',
								   row_num : 1
								},
								 success: function( data ) {
									 response( $.map( data, function( item ) {
										var code = item.split('|');
										return {
											label: code[0],
											value: code[0],
											data : item
										}
									}));
								}
							});
						},
						autoFocus: true,	      	
						minLength: 1,
						select: function( event, ui ) {
							var names = ui.item.data.split('|');						

							$('#ev_rploc_id'+fid).val(names[1]);
						}		      	
						});


						$('#ev_rploc'+fid).bind('blur', function(){

						var loc_title = $(this).val();
						var loc_id = $('#ev_rploc_id'+fid).val();

						if(loc_title == ''){
							$('#ev_rploc_id'+fid).val('');
						}

						});
					});
					</script>";

			/*$op .= "<div class='form-group' align='center'>
					<label class='control-label col-md-2' for='id_accomodation' align='right'></label>
					<div class='col-md-10 form-group internal'>
					<table><tr>
					<!-- <td>".$x."&nbsp;&nbsp;</td> -->
					<td><input type='text' style='width:80%' class='form-control datepicker' name='ev_dt[]' value = '".$ev_date."'></td>
					<td><select class='form-control' name='ev_st[]' id='ev_st'>".$options1."</select></td>
					<td><select class='form-control' name='ev_et[]' id='ev_et'>".$options2."</select></td>
					{$show_loc}
					</tr></table>
					</div></div><br>";*/
			$op .= "<div class='form-group' align='center'>
					<label class='control-label col-md-2' for='id_accomodation' align='right'></label>
					<div class='col-md-10 form-group internal'>
					<table><tr>
					<!-- <td>".$x."&nbsp;&nbsp;</td> -->
					<td><input type='text' style='width:80%' class='form-control datepicker' name='ev_dt[]' value = '".$ev_date."'></td>
					<td><input type='time' class='form-control' name='ev_st[]' id='ev_st' value='{$st}' /></td>
					<td><input type='time' class='form-control' name='ev_et[]' id='ev_et' value='{$et}' /></td>
					 {$show_loc}
					</tr></table>
					</div></div><br>";

			$ev_date = date('m/d/Y', strtotime('+1 day', strtotime($ev_date)));

		}
		echo $op;
	}

	public function add_fields_weekly()
	{
		$count = $this->input->post('count');
		$sd = $this->input->post('sd');
		$ed = $this->input->post('ed');
		$st = $this->input->post('st');
		$et = $this->input->post('et');
		$loc_stat = $this->input->post('loc_stat');

		$sch_type = $this->input->post('sch_type');
		$sel_weeks = $this->input->post('sel_weeks');

		$loc_id = $this->input->post('ev_loc_id');
		$loc_title = $this->input->post('ev_loc_title');

		$op = "";

		$ev_date = date('m/d/Y', strtotime($sd));

		for($x = 1; $x <= $count+1; $x++){

			$day_ev_date = strtotime($ev_date);

			$day = date('N',$day_ev_date);
			
			if(in_array($day, $sel_weeks)){
			
			$options1 = ""; $options2 = "";
			for($i = 0; $i < 24; $i++){
				$sel1 = ""; $sel2 = "";
				$sel_st1 = ($i % 12) ? ($i % 12).":00" : '12:00'; 
				$sel_st1 .= ($i >= 12) ? ' pm' : ' am';

				if($sel_st1 == $st) { $sel1 = "selected"; }
				if($sel_st1 == $et) { $sel2 = "selected"; }

				$options1 .= "<option value='".$sel_st1."' ".$sel1.">".$sel_st1."</option>";
				$options2 .= "<option value='".$sel_st1."' ".$sel2.">".$sel_st1."</option>";
			}
	
			$show_loc = "";

			if($loc_stat)
				{ $show_loc = "<td><input type='text' style='width:80%' class='ui-autocomplete-input form-control evloc_class' id='ev_rploc".$x."' name='ev_rploc".$x."' value='".$loc_title."'>
					<input type='hidden' style='width:80%' class='form-control' id='ev_rploc_id".$x."' name='ev_rploc_id[]' value='".$loc_id."'>
			</td>"; }


			$op .= "<script>
					$(document).ready(function(){					
					var baseurl = '".base_url()."';
					var fid = '".$x."';
							
						$('#ev_rploc'+fid).autocomplete({
						source: function( request, response ) {

							$.ajax({
								url: baseurl+'events/autocomplete',
								dataType: 'json',
								method: 'post',
								data: {
								   name_startsWith: request.term,
								   type: 'users',
								   row_num : 1
								},
								 success: function( data ) {
									 response( $.map( data, function( item ) {
										var code = item.split('|');
										return {
											label: code[0],
											value: code[0],
											data : item
										}
									}));
								}
							});
						},
						autoFocus: true,	      	
						minLength: 1,
						select: function( event, ui ) {
							var names = ui.item.data.split('|');						

							$('#ev_rploc_id'+fid).val(names[1]);
						}		      	
						});


						$('#ev_rploc'+fid).bind('blur', function(){

						var loc_title = $(this).val();
						var loc_id = $('#ev_rploc_id'+fid).val();

						if(loc_title == ''){
							$('#ev_rploc_id'+fid).val('');
						}

						});
					});
					</script>";

			
			/*$op .= "<div class='form-group' align='center'>
					<label class='control-label col-md-2' for='id_accomodation' align='right'></label>
					<div class='col-md-10 form-group internal'>
					<table><tr>
					<!-- <td>".$x."&nbsp;&nbsp;</td> -->
					<td><input type='text' style='width:80%' class='form-control datepicker' name='ev_dt[]' value = '".$ev_date."'></td>
					<td><select class='form-control' name='ev_st[]' id='ev_st'>".$options1."</select></td>
					<td><select class='form-control' name='ev_st[]' id='ev_et'>".$options2."</select></td>
					{$show_loc}
					</tr></table>
					</div></div><br>";*/
			$op .= "<div class='form-group' align='center'>
					<label class='control-label col-md-2' for='id_accomodation' align='right'></label>
					<div class='col-md-10 form-group internal'>
					<table><tr>
					<!-- <td>".$x."&nbsp;&nbsp;</td> -->
					<td><input type='text' style='width:80%' class='form-control datepicker' name='ev_dt[]' value = '".$ev_date."'></td>
					<td><input type='time' class='form-control' name='ev_st[]' id='ev_st' value='{$st}' /></td>
					<td><input type='time' class='form-control' name='ev_et[]' id='ev_et' value='{$et}' /></td>
					{$show_loc}
					</tr></table>
					</div></div><br>";

			}
			$ev_date = date('m/d/Y', strtotime('+1 day', strtotime($ev_date)));

		}
		echo $op;
	}

	public function get_user_schedule($ev_id, $ev_userid){

		$get_user_sch = $this->model_event->get_user_sch($ev_id, $ev_userid);
		return $get_user_sch;
	}

	public function get_rep_sch_det($ev_rep_id){

		return $this->model_event->get_rep_sch_det($ev_rep_id);
	}


	public function register($act_code)
	{
		echo "invalid url";
	}

	public function register_user($ev_id,$act_code)
	{
		
		$user_id = $this->session->userdata('users_id');

		$child_accounts = $this->model_event->get_child_accounts($user_id);
		if($child_accounts){
				
			$data['child_accounts'] = $child_accounts;
			$data['results'] = $this->model_news->get_news();
			$data['ev_id'] = $ev_id;
			$data['act_code'] = $act_code;

			$this->load->view('includes/header');
			$this->load->view('events/view_ev_nonreg',$data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');

		}
		else
		{
			$is_ev_user = $this->model_event->check_is_invited($ev_id);
			
			if(!$is_ev_user){
			
			$rep_events = $this->model_event->get_rep_events($ev_id);
			   foreach($rep_events as $obj){           

					$data['user'] = $user_id;
					$data['event_id'] = $ev_id;
					$data['ev_rep_id'] = $obj->Ev_Tab_ID;
					
					//echo $data['ev_rep_id'];echo $data['user'];echo "<br />";

					$create_inv = $this->model_event->ins_ev_invite($data);
			   }

			   $user_stat = $this->model_event->update_non_reg_user_status($ev_id,$act_code);

			 redirect("events/view/$ev_id/6");
			
		   }
		   else {
			 redirect("events/view/$ev_id/5");
		   }
		}
	}

	public function activate_users(){
		$event_id = $this->input->post('ev_id');
		$child_id = $this->input->post('child_user_id');
		$act_code = $this->input->post('act_code');

		$data['user'] = $child_id;
		$data['event_id'] = $event_id;

		$is_ev_user = $this->model_event->check_is_invited_user($data);
		
		if(!$is_ev_user){
			
			$rep_events = $this->model_event->get_rep_events($event_id);
			   foreach($rep_events as $obj){           

					$data['user'] = $child_id;
					$data['event_id'] = $event_id;
					$data['ev_rep_id'] = $obj->Ev_Tab_ID;
					
					//echo $data['ev_rep_id'];echo $data['user'];echo "<br />";

					$create_inv = $this->model_event->ins_ev_invite($data);
					
			   }

			   $user_stat = $this->model_event->update_non_reg_user_status($event_id,$act_code);

			 redirect("events/view/$event_id/6");
		}
		else{
			redirect("events/view/$event_id/5");
		}
	
	}

	/*public function view($ev_id, $act_code = "")
	{
		$data['actcode_det'] = "";

		if($act_code == ""){
		  $this->session->sess_destroy();
		  $this->activate_inv_user($act_code);
		}
		else{
		//print_r($data);
		$is_ev_user = $this->model_event->check_is_invited($ev_id);

		$data['is_ev_user'] = $is_ev_user;
		
		$is_have_players = $this->model_event->is_have_players($ev_id);

		$ev_det = $this->model_event->getonerow($ev_id);

		$data['ev_det'] = $ev_det;
		//print_r($data);
		$data['results'] = $this->model_news->get_news();
		$data['num_players'] = $is_have_players;

			if(count($is_ev_user) > 0){
				$get_ev_reps = $this->model_event->get_ev_reps($ev_id);
				$get_ev_users = $this->model_event->get_ev_users($ev_id);
				$get_ev_comments = $this->model_event->get_ev_comments($ev_id);

				$data['ev_rep_schedule'] = $get_ev_reps;
				$data['get_ev_users']	 = $get_ev_users;
				$data['get_ev_comments'] = $get_ev_comments;
			}
			else{
				$get_ev_reps	 = $this->model_event->get_ev_reps($ev_id);
				$get_ev_users	 = $this->model_event->get_ev_users($ev_id);
				$get_ev_comments = $this->model_event->get_ev_comments($ev_id);

				$data['ev_rep_schedule'] = $get_ev_reps;
				$data['get_ev_users']	 = $get_ev_users;
				$data['get_ev_comments'] = $get_ev_comments;

				$data['users']			= "";
				$data['sport_intrests'] = $this->general->get_user_sport_intrests();
				$data['sport_levels']	=  $this->model_event->get_sport_levels();

				$data['range'] = 50;
				$srch_res = $this->model_event->get_optimum_users($data);
				$data['users'] = $srch_res;
			}

			$this->load->view('includes/header', $data);
			$this->load->view('view_event_details', $data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
		}

	}*/

	public function activate_inv_user($act_code){

		  $get_actcode_det = $this->model_event->check_is_valid_actcode($act_code);    //check the status of non registered user
		  $data['actcode_det'] = $get_actcode_det;
			/*
			Array
			(
				[Ev_Tab_ID] => 24
				[Ev_ID] => 114
				[Ev_Email] => k_raj_kamal@yahoo.com
				[Act_Code] => 3db70c93129cac9e
				[Act_Status] => 1
			)
			*/
	}

	public function reg_user2(){
		$users_id = $this->session->userdata('users_id');
		if(!$users_id){ echo "Invalid Request!"; exit; }
		
		$reg_stat = $this->input->post('reg_stat');
		$event_id = $this->input->post('ev_id');

		switch($reg_stat){
			case "Attending":
				$status = 'Accept';
			break;
			case "Not Attending":
				$status = 'Decline';
			break;
			case "Tentative":
				$status = 'Tentative';
			break;
			default:
				$status = 'Pending';
			break;
		}

		$data['user']	  = $users_id;
		$data['event_id'] = $event_id;
//echo "<pre>"; print_r($_POST); print_r($data); exit;
		$is_ev_user = $this->model_event->check_is_invited_user($data);
		
		if(!$is_ev_user){

			$ev_det = $this->model_event->getonerow($event_id);

			if($ev_det['Fee'] != '' and $ev_det['Fee'] != NULL and $ev_det['Fee'] > 0 and $status == 'Accept'){

				$this->event_payment_process($ev_det);
				exit;
			}
			else{
				//echo "testing";
				//exit;
			$rep_events = $this->model_event->get_rep_events($event_id);
			//echo "<pre>"; print_r($rep_events); exit;

			   foreach($rep_events as $obj){
					$data['user']	   = $users_id;
					$data['event_id']  = $event_id;
					$data['ev_rep_id'] = $obj->Ev_Tab_ID;
					$data['ev_status'] = $status;
					$create_inv = $this->model_event->ins_ev_invite($data);
			   }
			   $user_stat = $this->model_event->update_non_reg_user_status($event_id,$act_code);

			redirect("events/view/$event_id/6#comments");
			}
		}
		else{
		 redirect("events/view/$event_id/5");
		}
	}


	public function reg_user(){
		$users_id = $this->session->userdata('users_id');
		if(!$users_id){ echo "Invalid Request!"; exit; }
		
		$reg_stat = $this->input->post('reg_stat');
		$event_id = $this->input->post('ev_id');

		switch($reg_stat){
			case "Attending":
				$status = 'Accept';
			break;
			case "NOT ATTENDING":
				$status = 'Decline';
			break;
			case "TENTATIVE":
				$status = 'Tentative';
			break;
			default:
				$status = 'Pending';
			break;
		}

		$data['event_id'] = $event_id;
//echo "<pre>"; print_r($_POST); print_r($data); exit;
		$is_ev_user = $this->model_event->check_is_invited_user($data);
		
		if(!$is_ev_user){

			//$ev_det = $this->model_event->getonerow($event_id);

			/*if($ev_det['Fee'] != '' and $ev_det['Fee'] != NULL and $status == 'Accept'){

				$this->event_payment_process($ev_det);
				exit;
			}*/
			
			$rep_events = $this->model_event->get_rep_events($event_id);
			   foreach($rep_events as $obj){
					$data['user']	   = $users_id;
					$data['event_id']  = $event_id;
					$data['ev_rep_id'] = $obj->Ev_Tab_ID;
					$data['ev_status'] = $status;

					$create_inv = $this->model_event->ins_ev_invite($data);
			   }
			   //$user_stat = $this->model_event->update_non_reg_user_status($event_id,$act_code);

			echo "Your Response is sent successfully.";
		}
		else{
			echo "You were already registered for this Event!";
		}
	}

	public function view($ev_id, $act_code="")
	{
		/*if(!$this->session->userdata('user')){
			$return_to = array('return_to' => base_url(uri_string()));
				$this->session->set_userdata($return_to);

			redirect('login');
		}*/

		//echo $act_code; exit;
		$data['actcode_det'] = "";

		if($act_code != ""){
		  $get_actcode_det	   = $this->model_event->check_is_valid_actcode($act_code);
		  //check the status of non registered user
		  $data['actcode_det'] = $get_actcode_det;
		}

		$data['is_ev_user'] = 0;

		//print_r($data);
		if($this->session->userdata('users_id')){
			$is_ev_user			= $this->model_event->check_is_invited($ev_id);
			$data['is_ev_user'] = $is_ev_user;
		}
		
		$is_have_players = $this->model_event->is_have_players($ev_id);
		$ev_det			 = $this->model_event->getonerow($ev_id);
		$data['ev_det']	 = $ev_det;
		$data['results'] = $this->model_news->get_news();
		$data['num_players'] = $is_have_players;

		if(count($is_ev_user) > 0){
			$get_ev_reps = $this->model_event->get_ev_reps($ev_id);
			$get_ev_users = $this->model_event->get_ev_users($ev_id);
			$get_ev_comments = $this->model_event->get_ev_comments($ev_id);

			$data['ev_rep_schedule'] = $get_ev_reps;
			$data['get_ev_users']	 = $get_ev_users;
			$data['get_ev_comments'] = $get_ev_comments;
		}
		else{	
			$get_ev_reps	 = $this->model_event->get_ev_reps($ev_id);
			$get_ev_users	 = $this->model_event->get_ev_users($ev_id);
			$get_ev_comments = $this->model_event->get_ev_comments($ev_id);

			$data['ev_rep_schedule'] = $get_ev_reps;
			$data['get_ev_users']	 = $get_ev_users;
			$data['get_ev_comments'] = $get_ev_comments;
		}

			$data['users']			= "";
			$data['sport_intrests'] = $this->general->get_user_sport_intrests();
			$data['tshirt_sizes']   = $this->general->get_tshirt_sizes();
			$data['sport_levels']	= $this->model_event->get_sport_levels();

			$data['range'] = 50;
			$srch_res = $this->model_event->get_optimum_users($data);
			$data['users'] = $srch_res;

			$data['pay_status'] = "";
			$data['is_tshirt']  = 1;

			if($ev_det['Fee'] != '' and $ev_det['Fee'] != NULL and $ev_det['Fee'] > 0){
				$uid = $this->session->userdata('users_id');
				$is_paid = $this->model_event->get_pay_status($ev_id, $uid);
	
				$data['pay_status'] = "Due";

				if(count($is_paid) > 0)
				$data['pay_status'] = "Paid";
			}
			$get_user_info = $this->general->get_user($uid);
			if($get_user_info['TShirt_Size'] == '' or $get_user_info['TShirt_Size'] == NULL){
				$data['is_tshirt'] = 0;
			}

			//print_r($data['sport_intrests']); exit;
			$this->load->library('facebook' ,  array("appId" => FB_APPID, "secret" => FB_KEY, "redirect_url" => FB_REDIRECT));
			$data['login']   = $this->facebook->getLoginUrl();


/* *************************************************************************** */

// Store values in variables from project created in Google Developer Console
$clientId = '170374605326-p02hhgiia6fqncck0982i401madv6n72.apps.googleusercontent.com';
$clientSecret = 'XyOwkQkScXXca0wG4paTUx6A';
$redirectUrl = 'https://a2msports.com/login/auth_check';
$simple_api_key = 'AIzaSyC0JNMWyyW6t1fSNyrprBJC2bWKG4btytc';

	include_once APPPATH."libraries/google_login_api_HRWNdR/src/Google_Client.php";
    include_once APPPATH."libraries/google_login_api_HRWNdR/src/contrib/Google_Oauth2Service.php";
        
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('A2MSports');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);

		$google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
			$this->session->unset_userdata('menu_items');
            $this->session->set_userdata('token', $gClient->getAccessToken());

            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');

        if ($token != "") {
            $gClient->setAccessToken($token);
        }

		$data['authUrl'] = $gClient->createAuthUrl();

/* *************************************************************************** */

			$this->load->view('includes/header', $data);
			$this->load->view('view_event_details', $data);
			$this->load->view('includes/view_right_column',$data);
			$this->load->view('includes/footer');
	}
	

	public function invite_players(){
		if($this->input->post('event_send')){
			$mes	  = $this->input->post('mes');
			$event_id = $this->input->post('event_id');
			$ev_det	  = $this->model_event->getonerow($event_id);

			$ev_title = $ev_det['Ev_Title'];
			$ev_type  = $this->model_event->get_event_name($ev_det['Ev_Type_ID']);
			$ev_type_name = $ev_type['Ev_Type'];

		if($ev_det['Ev_Start_Date'] != "1900-01-01 00:00:00.000"){ $ev_sd =  date("m-d-Y", strtotime($ev_det['Ev_Start_Date'])); } 
		else { $ev_sd = "&lt;Not Available&gt;"; }
	    if($ev_det['Ev_End_Date'] != "1900-01-01 00:00:00.000"){ $ev_ed =  date("m-d-Y", strtotime($ev_det['Ev_End_Date']));  } 
		else { $ev_ed = "&lt;Not Available&gt;"; }

		if($ev_det['Ev_Location']) { $loc = $this->model_event->get_location_name($ev_det['Ev_Location']); 
			$loc_title = $loc['loc_title'];
		} else { $loc_title = "&lt;Not Available&gt;"; }
		
		$location = "";
		if($loc['loc_add'] != "") { $location .= $loc['loc_add'];}
		if($loc['loc_city'] != "") { $location .= ", " . $loc['loc_city'] ;} 
		if($loc['loc_state'] != "") { $location .=  ", " . $loc['loc_state'];} 
		if($loc['loc_country'] != "") { $location .= ", " . $loc['loc_country'] . ".";} 

		$event_init = $this->get_user_details($ev_det['Ev_Created_by']);
		$organizer =  $event_init['Firstname']." ".$event_init['Lastname'];

		$contact_num = $ev_det['Ev_Contact_Num'];

		$emails = $this->input->post('emails');
		
		//$explode = explode(',', $emails);

		$explode = preg_split('/[,;]/', $emails);
		
		//print_r($explode);
		//exit;

		foreach($explode as $to_email){

			$data['email'] = $to_email;
			$data['ev_id'] = $event_id;

			$random = rand(1, 10000);
			$code = md5($to_email . $event_id . $random);
			$act_code = substr($code, 16, 32);

			$data['act_code'] = $act_code;

			$create_inv = $this->model_event->insert_non_reg_users($data);    /// non registered users send invitation 

			$this->load->library('email');
			$this->email->set_newline("\r\n");

			$this->email->from(FROM_EMAIL, 'A2MSports');
			$this->email->to($to_email);
				
			$this->email->subject( "$organizer invites you for $ev_title");

			$data = array(
			 'message'=> $mes,
			 'ev_title'=> $ev_title,
			 'ev_id'=> $event_id,
			 'ev_type_name'=> $ev_type_name,
			 'ev_sd'=> $ev_sd,
			 'ev_ed'=> $ev_ed,
			 'loc_title' => $loc_title,
			 'location' => $location,
			 'organizer' => $organizer,
			 'contact_num' => $contact_num,
			 'act_code' => $act_code,
			 'page'=> 'New Event Details'
			);

			$body = $this->load->view('view_email_template.php',$data,TRUE);

			$this->email->message($body);   
			$res = $this->email->send();

		}
		
		 redirect("events/$event_id/2");
		}
		else{
			echo "Invalid Access!";
		}
	}


	public function get_lang_latt($event_location)
	{
		$location = $event_location;
		$address =  $location;

		if(!empty($address)){

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
		} 
		else 
		{
			return false;
		}
	}

		public function LoadUsers()
		{
			$sport_id = $this->input->post('sport_id');
			$level =  $this->input->post('level');
			$age_group = $this->input->post('age_group');
			$gender = $this->input->post('gender');
			$range = $this->input->post('range');
			$org_id = $this->input->post('org_id');
			$academy = $this->input->post('academy');
				
			//if($sport_id != ""){
					$data['users'] = "";

					$points = $this->model_event->get_lat_lang();
					$data['latitude'] = $points->Latitude;
					$data['longitude'] = $points->Longitude;

					$data['sport_id'] = $sport_id;
					$data['level'] = $level;
					$data['age_group'] = $age_group;
					$data['gender'] = $gender;
					$data['range'] = $range;
					$data['org_id'] = $org_id;
					$data['academy'] = $academy;
					
					$data['users'] = $this->model_event->search_sport_users($data);

					$this->load->view('events_load_users' ,$data);
				
			//}
			
		}

		public function autocomplete()
		{
			
			$q = $_POST['name_startsWith'];
	
			$data['key'] = trim($q);
			$result = $this->model_event->search_autocomplete($data);

			if($result)
			{
				$data_new = array();
				foreach($result as $row)   
				{
					$name = $row->loc_title.'|'.$row->loc_id;
					array_push($data_new, $name);	
				}

			}
				echo json_encode($data_new);
				exit;
		 }

		 public function Sport_levels($sport_id = '')
		 {
			  $sport_id = $this->input->post('sport_id');
			  $sport_levels = $this->model_event->get_specific_levels($sport_id);
			  $sp_level = array();

			  echo "<script>
			  $(document).ready(function(){

			   $('.ajax_click').click(FilterPlayers)

			   $('.ajax_blur').blur(FilterPlayers)

			   $('.ajax_change').change(Change_FilterPlayers)
			  
			   $('.ajax_mile_change').change(FilterPlayers)
			   
			  });
			  </script>";

			  foreach($sport_levels as $row){ 
			  if(in_array($row->SportsLevel_ID, $sp_level)){ $checked_stat = 'checked = checked'; }
			   echo "<input type='checkbox' class='ajax_click' name='level[]' value='$row->SportsLevel_ID'>$row->SportsLevel";
			   echo "&nbsp";
			  }

		 }

		 public function upload_pics()
		 {
		 
			if($this->input->post('upload_image')){

				$this->load->library('upload');
				$ev_id = $this->input->post('ev_id');

				$event_folder = 'C:\inetpub\wwwroot\a2msports\events_pictures\\'.$ev_id.'';

				if (!file_exists($event_folder)) {
					mkdir($event_folder, 0777, true);
				}

				$files = $_FILES;
				$cpt = count($_FILES['userfile']['name']);
				for($i=0; $i<$cpt; $i++)
				{
				 $rand = md5(uniqid(rand(), true));

				$format=explode('.',$files['userfile']['name'][$i]);
                $format=end($format);
				//echo $format;

					$_FILES['userfile']['name']= time().md5($files['userfile']['name'][$i]).'.'.$format;
					$_FILES['userfile']['type']= $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error']= $files['userfile']['error'][$i];
					$_FILES['userfile']['size']= $files['userfile']['size'][$i];

					$fileName = 'userfile';

					$config = array(
				    'upload_path' => "./events_pictures/$ev_id/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => TRUE,
					'max_size' => "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
					'max_height' => "5000",
					'max_width' => "8000");

				$this->load->library('upload',$config);  
				$this->upload->initialize($config);

				//	$this->upload->initialize($this->set_upload_options($tourn_id));
				$this->upload->do_upload($fileName);
				$fileName = $_FILES['userfile']['name'];

				//print_r($fileName);
				//exit;

				$this->model_event->insert_event_images($fileName);
				}
			
				 redirect("events/$ev_id/7");
			}
		 }


		 public function rotate_image()
		 {

		   if($_POST){

				foreach($_POST as $name => $content) { // Most people refer to $key => $value
				   if($content=="rotate")
					{
					   $row_id = $name;
					   $row_id = substr($row_id,-1);
				    }
				 }
		  
				 $filename = $this->input->post("filename$row_id");
				 $angle = $this->input->post("angle$row_id");
				 $ev_id = $this->input->post("ev_id$row_id");
				 $dir = $this->input->post("dir$row_id");
				 $out = "";

				 $dir_angle = $dir.$angle;

				// echo $filename ."". $angle ."  " .$ev_id ."   ". $dir_angle ;
				// exit;
				
				if($filename != ""){
			
					$data['ev_det'] = $this->model_event->getonerow($event_id);
				    $data['results'] = $this->model_news->get_news();
					//$data['images'] = $this->model_league->get_individual_tourn_images($ev_id); 
					$data['get_images'] = $this->model_event->get_individual_event_images($ev_id);

					$image_name = substr(strrchr($filename, "/"), 1);
					//$saveto = $_SERVER['DOCUMENT_ROOT'].'\a2msports\tour_pictures\'.$tourn_id.'"\'.$image_name;    

					$saveto =  'C:/inetpub/wwwroot/a2msports/events_pictures/'.$ev_id.'/'.$image_name;     

					$this->RotateJpg($filename,$dir_angle,$saveto,$ev_id);    
				   
				}
			}
		}


		 // Rotate Manipulation.
		public function RotateJpg($filename = '',$angle = 0,$savename = false,$ev_id = '') {   

				
				//echo $ev_id;echo $angle;exit;

				$size = getimagesize($filename); 

				switch ($size['mime']){ 
				case "image/gif": 
				 
						header('Content-Type: image/gif');
						// Load
						$source = imagecreatefromgif($filename);

						// Rotate
						$rotate = imagerotate($source, $angle, 0);
						//print_r($rotate);

						// Output
						if($savename == false) {
						imagegif($rotate);
						}
						else
						imagegif($rotate,$savename);
						// Free the memory
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("events/$ev_id","refresh");

				break;
				case "image/jpeg": 
						
						header('Content-type: image/jpeg');
						 
						// Load
						$source = imagecreatefromjpeg($filename);

						// Rotate
						$rotate = imagerotate($source, $angle, 0);
						
						// Output
						if($savename == false) {
						imagejpeg($rotate);
						}
						else
						imagejpeg($rotate,$savename);
						// Free the memory
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("events/$ev_id","refresh");

				break; 


				case "image/png": 
				//echo "Image is a png"; 

						header('Content-Type: image/png');
						
						// Your original file
						$source = imagecreatefrompng($filename);
						// Rotate
						$rotate  = imagerotate($source, $angle, 0);
						// If you have no destination, save to browser
						if($savename == false) {
						imagepng($rotate);
						}
						else
						// Save to a directory with a new filename
						imagepng($rotate,$savename);

						// Standard destroy command
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("events/$ev_id","refresh");
						

				break; 
				case "image/bmp": 
				//echo "Image is a bmp"; 
						
						header('Content-Type: image/bmp');
						// Your original file
						$source = imagecreatefrombmp($filename);
						// Rotate
						$rotate  = imagerotate($source, $angle, 0);
						// If you have no destination, save to browser
						if($savename == false) {
						
						imagebmp($rotate);
						}
						else
						// Save to a directory with a new filename
						imagebmp($rotate,$savename);

						// Standard destroy command
						imagedestroy($source);
						imagedestroy($rotate);

						redirect("events/$ev_id","refresh");
						
				 break;
				default:
				 echo "Invalid Image file";
				 break;

				}
		 }
		
		 public function get_gallery($ev_id = '')
	     {
			$ev_id = $this->input->post("ev_id");

			$data['results'] = $this->model_news->get_news();
		    $data['get_images'] = $this->model_event->get_individual_event_images($ev_id);

			$this->load->view('events/view_gallery_event',$data);
			
		 }

		public function compareDates($a, $b){
		  return strtotime($a->Ev_Date) - strtotime($b->Ev_Date);
		}

		public function logout_user(){
			$this->session->sess_destroy();
		}

		public function event_payment_process($ev_det){
			$users_id = $this->session->userdata('users_id');
			$this->load->library('paypal_lib');
			$ev_id	  = $ev_det['Ev_ID'];
			$ev_title = $ev_det['Ev_Title'];
			$ev_fee	  = $ev_det['Fee'];

			if(!$users_id){
				echo "Your Logged Session Timeout! Please <a href='".base_url()."login'>Login</a> and Register again. Thanks you.";
				exit;
			}		

			$currency_code = 'USD';

			//Set variables for paypal form
			$paypalURL = PAYPAL_URL;  //PayPal api url
			$paypalID  = PAYPAL_ID;  //business email

			$returnURL = base_url().'paypal/ev_success?ev_id='.$ev_id.'&reg_user='.$users_id; 
			//payment success url

			$cancelURL = base_url().'paypal/cancel'; //payment cancel url
			$notifyURL = base_url().'paypal/ipn';	 //ipn url

			$logo = base_url().'images/logo.png';
			
			$this->paypal_lib->add_field('business', $paypalID);
			$this->paypal_lib->add_field('return', $returnURL);
			$this->paypal_lib->add_field('cancel_return', $cancelURL);
			$this->paypal_lib->add_field('notify_url', $notifyURL);
			$this->paypal_lib->add_field('event_id', $ev_id);
			//$this->paypal_lib->add_field('player', $this->logged_user);
			$this->paypal_lib->add_field('on0', $users_id);
			$this->paypal_lib->add_field('item_number',  $ev_id);
			$this->paypal_lib->add_field('item_name',  $ev_title);
			$this->paypal_lib->add_field('amount', $ev_fee);        
			$this->paypal_lib->image($logo);
			
			$this->paypal_lib->paypal_auto_form();
		}

		public function pay_now($ev_id){
			$users_id = $this->session->userdata('users_id');
			$this->load->library('paypal_lib');
			$ev_det   = $this->model_event->getonerow($ev_id);
			$ev_id	  = $ev_det['Ev_ID'];
			$ev_title = $ev_det['Ev_Title'];
			$ev_fee	  = $ev_det['Fee'];

			if(!$users_id){
				echo "Your Logged Session Timeout! Please <a href='".base_url()."login'>Login</a> and Register again. Thanks you.";
				exit;
			}

			$currency_code = 'USD';

			//Set variables for paypal form
			$paypalURL = PAYPAL_URL;  //PayPal api url
			$paypalID  = PAYPAL_ID;  //business email

			$returnURL = base_url().'paypal/ev_success?ev_id='.$ev_id.'&reg_user='.$users_id; 
			//payment success url

			$cancelURL = base_url().'paypal/cancel'; //payment cancel url
			$notifyURL = base_url().'paypal/ipn';	 //ipn url

			$logo = base_url().'images/logo.png';
			
			$this->paypal_lib->add_field('business', $paypalID);
			$this->paypal_lib->add_field('return', $returnURL);
			$this->paypal_lib->add_field('cancel_return', $cancelURL);
			$this->paypal_lib->add_field('notify_url', $notifyURL);
			$this->paypal_lib->add_field('event_id', $ev_id);
			//$this->paypal_lib->add_field('player', $this->logged_user);
			$this->paypal_lib->add_field('on0', $users_id);
			$this->paypal_lib->add_field('item_number',  $ev_id);
			$this->paypal_lib->add_field('item_name',  $ev_title);
			$this->paypal_lib->add_field('amount', $ev_fee);        
			$this->paypal_lib->image($logo);
			
			$this->paypal_lib->paypal_auto_form();
		}

		public function get_tshirt_count($tid, $ev_id){
			$get_count = $this->model_event->get_ts_count($tid, $ev_id);
			return $get_count['ts_count'];
		}
}	