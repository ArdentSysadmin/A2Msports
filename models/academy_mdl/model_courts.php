<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_courts extends CI_Model {
	
		public function __construct()
		{
			parent:: __construct();	
		}

		public function get_locations($org_id)
		{
			$data  = array('org_id' => $org_id);
			$query = $this->db->get_where('Academy_Court_Locations', $data);
			return $query->result();
		}
		
		public function get_locations_and_courts($org_id)
		{
			$data  = array('org_id' => $org_id);
			$query = $this->db->get_where('Academy_Court_Locations', $data);
			$locations = $query->result();
			foreach($locations as $location){
				$location->courts	 = $this->get_loc_courts($location->loc_id);
				$location->res_count = $this->get_loc_res_count($location->loc_id);
				
			}
			return $locations;
		}
		
		public function get_loc_courts($loc_id)
		{
			$data  = array('loc_id' => $loc_id,'status' => '1');
			$query = $this->db->get_where('Academy_Courts', $data);
			return $query->result();
		}

		public function get_loc_res_count($loc_id)
		{
			$date = date('Y-m-d');
			$time = date('H:i:s');

   		    $query = $this->db->query("SELECT SUM(num_players) AS res_count FROM Academy_Court_Reservations WHERE loc_id = {$loc_id} AND res_date = '{$date}' AND (from_time >= '{$time}' OR to_time >= '{$time}')");

			//echo $this->db->last_query();
			if($query->num_rows){
				$res = $query->row_array();
				return $res['res_count'];
			}
			else{
				return 0;
			}
		}

		public function get_loc_id($court_id)
		{
   		    $query = $this->db->query("SELECT loc_id FROM Academy_Courts WHERE court_id = {$court_id}");
			return $query->row_array();		
		}

		public function get_loc_courts_all($loc_id)
		{
			$data  = array('loc_id' => $loc_id);
			$query = $this->db->get_where('Academy_Courts', $data);
			return $query->result();
		}

		public function get_loc_info($loc_id)
		{
			$data  = array('loc_id' => $loc_id);
			$query = $this->db->get_where('Academy_Court_Locations', $data);
			return $query->row_array();
		}

		public function get_court_count($loc_id)
		{
			$data  = array('loc_id' => $loc_id);
			$query = $this->db->get_where('Academy_Courts', $data);
			return $query->num_rows();
		}

		public function get_clubMembers()
		{
			$org_id = $this->org_id;
			$query  = $this->db->query("select u.*,um.* from Users as u JOIN User_memberships as um ON u.Users_ID = um.Users_id and um.Club_id = {$org_id}");
			//echo $this->db->last_query(); exit;
			return $query->result();
		}

		public function get_court_reservations($loc_id,$court_id)
		{
			$data  = array('loc_id' => $loc_id, 'court_id' => $court_id,);
			$query = $this->db->get_where('Academy_Court_Reservations', $data);
			return $query->result();
		}
		
		public function get_court_durations($loc_id,$court_id)
		{
			$data  = array('loc_id' => $loc_id, 'court_id' => $court_id,);
			$query = $this->db->get_where('Academy_Courts', $data);
			return $query->row_array();
		}
		
		public function get_court_timings($org_id, $day)
		{
			$qry1 = $this->db->query("select * from Academy_Court_Locations where org_id = {$org_id}");
			$qry1_res = $qry1->result();

			foreach($qry1_res as $res1){
				$loc = $res1->loc_id;

				$qry2 = $this->db->query("select * from Academy_Courts where loc_id = {$loc}");
				$qry2_res = $qry2->result();

				foreach($qry2_res as $res2){
					$court = $res2->court_id;
					$court_info = json_decode($res2->court_info_json, true);
					$res_arr[$loc][$court] = array('timings' => $court_info['court_prices'][$day]['actual_timings'],
						'break' => $court_info['court_prices'][$day]['break']);
					//$res_arr[$loc][$court] = $court_info;
				}
			}

			return $res_arr;
		}
		
		public function get_court_reservations_by_date($org_id,$date)
		{
   		    $query = $this->db->query("select u.firstname,u.lastname ,res.* from Academy_Court_Reservations res inner join Academy_Court_Locations loc on loc.loc_id = res.loc_id inner join users u on res.reserved_by = u.users_id where loc.org_id = {$org_id} and res_date = '{$date}' and res_status != 'Canceled'");
			//echo $this->db->last_query();
			return $query->result();
		}

		public function add_court_test($data){

			$data['court_id']  = 8;
			$data['max_hours'] = $this->input->post('max_book_hours');
			$courts			 = $this->input->post('courts');

			foreach($courts as $i => $court){
				$data['court_name'] = $courts[$i];
				$data['stTime']   = $this->input->post('stTime_'.$i);
				$data['edTime']   = $this->input->post('edTime_'.$i);
				$data['sunPrice'] = $this->input->post('sunPrice_'.$i);
				$data['monPrice'] = $this->input->post('monPrice_'.$i);
				$data['tuePrice'] = $this->input->post('tuePrice_'.$i);
				$data['wedPrice'] = $this->input->post('wedPrice_'.$i);
				$data['thuPrice'] = $this->input->post('thuPrice_'.$i);
				$data['friPrice'] = $this->input->post('friPrice_'.$i);
				$data['satPrice'] = $this->input->post('satPrice_'.$i);

				$json = $this->convert_json($data);
				
				echo $json;
				echo "<br>-----------<br>";
			}
			exit;
		}

		public function convert_json($data){

			$court_id			= $data['court_id'];
			$court_name	= $data['court_name'];
			$max_hours		= $data['max_hours'];
			$max_players	= $data['max_players'];

			//foreach($courts as $i => $court){

				$stTime   = $data['stTime'];
				$edTime   = $data['edTime'];
				$sunPrice = $data['sunPrice'];
				$monPrice = $data['monPrice'];
				$tuePrice = $data['tuePrice'];
				$wedPrice = $data['wedPrice'];
				$thuPrice = $data['thuPrice'];
				$friPrice = $data['friPrice'];
				$satPrice = $data['satPrice'];

				
				$court_min_time = date("H:i", strtotime(min($stTime)));
				$court_max_time = date("H:i", strtotime(max($edTime)));

				$court_timings = array('start_time' => "{$court_min_time}", 'end_time' => "{$court_max_time}");

				foreach($stTime as $j => $st) {
					$st = date("H:i", strtotime($st));
					$ed = date("H:i", strtotime($edTime[$j]));
					for($k = $st; $k < $ed; ) {
						$k  = date("H:i", strtotime($k));
						$kk = date("H:i", strtotime($k."+1 hours"));
						$court_valid_times[] = $k.'-'.$kk;
						$k = $kk;
					}
				}
				/*echo "<pre>";
				print_r($court_valid_times);
				echo "<br>----vt----";*/
				for($m = $court_min_time; $m < $court_max_time; ) {
					$mmm_arr	= '';
					$m			= date("H:i", strtotime($m));
					$mm			= date("H:i", strtotime($m."+1 hours"));
					$mmm		= $m.'-'.$mm;
					$mmm_arr	= array('start_time' => $m, 'end_time' => $mm);
					$hour_arr[] = $mmm;

					if(!in_array($mmm, $court_valid_times)){
						//$break_times[$i][] = $mmm_arr;
						$break_times[0][] = $mmm_arr;
						$break_times[1][] = $mmm_arr;
						$break_times[2][] = $mmm_arr;
						$break_times[3][] = $mmm_arr;
						$break_times[4][] = $mmm_arr;
						$break_times[5][] = $mmm_arr;
						$break_times[6][] = $mmm_arr;
					}
					$m = $mm;
				}
				/*echo "<pre>";
				print_r($hour_arr);
				echo "<br>---hrs-----";*/
		
				$json_data['court_info'] = array('court_id' => $court_id, 'court_name' => $court_name, 'max_players'=> (int)$max_players);
				$json_data['court_timings'] = array('open_days' => array('sun','mon','tue','wed','thu','fri','sat'),
													'close_days' => null);
				
			$pr = array();
				foreach($stTime as $j => $val){
					$data = array(
					'Aca_ID'		=> $this->org_id,
					'Aca_Court_ID'  => $court_id,
					'Start_Time'	=> date('H:i:s', strtotime($stTime[$j])),
					'End_Time'		=> date('H:i:s', strtotime($edTime[$j])),
					'Sun_Price'		=> $sunPrice[$j],
					'Mon_Price'		=> $monPrice[$j],
					'Tue_Price'		=> $tuePrice[$j],
					'Wed_Price'		=> $wedPrice[$j],
					'Thu_Price'		=> $thuPrice[$j],
					'Fri_Price'		=> $friPrice[$j],
					'Sat_Price'		=> $satPrice[$j]
					);
					
					if($sunPrice[$j] != 'n/a'){
					$pr['sun'][] = array('price' => $sunPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[0][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[0][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($monPrice[$j] != 'n/a'){
					$pr['mon'][] = array('price' => $monPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[1][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[1][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}


					if($tuePrice[$j] != 'n/a'){
					$pr['tue'][] = array('price' => $tuePrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[2][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[2][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($wedPrice[$j] != 'n/a'){
					$pr['wed'][] = array('price' => $wedPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[3][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[3][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($thuPrice[$j] != 'n/a'){
					$pr['thu'][] = array('price' => $thuPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[4][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[4][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($friPrice[$j] != 'n/a'){
					$pr['fri'][] = array('price' => $friPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[5][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[5][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($satPrice[$j] != 'n/a'){
					$pr['sat'][] = array('price' => $satPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//break_times[6][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[6][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					//$ins_court_price = $this->db->insert('Academy_Courts_Price', $data);
				}


					$court_prices['sun'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[0], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sun']
						   );

					$court_prices['mon'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[1], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['mon']
						   );

					$court_prices['tue'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[2], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['tue']
						   );

					$court_prices['wed'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[3], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['wed']
						   );

					$court_prices['thu'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[4], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['thu']
						   );

					$court_prices['fri'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[5], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['fri']
						   );

					$court_prices['sat'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times[6], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sat']
						   );

			$json_data['court_prices'] = $court_prices;
			$json_format2 = json_encode($json_data);

			/*echo "<pre>";
			print_r($json_data);
			echo $json_format2;
			exit;*/

			return $json_format2;
		}
	
		public function add_court($data)
		{
			/*echo "<pre>";
			print_r($_POST);
			exit;*/

			$long_latt	= explode("@", $data['long_latt']);
			
			$location	= $this->input->post('location');
			$addr		= $this->input->post('address');
			$city			= $this->input->post('city');
			$state		= $this->input->post('state');
			$country   = $this->input->post('country');
			$zipcode   = $this->input->post('zip');
			$instr		 = $this->input->post('ins_comments');
			
			$mem_discount = 0;
			if($this->input->post('is_discount')){
			$mem_discount = $this->input->post('member_discount');
			}

			$nonmem_access = 0;
			if($this->input->post('is_nonmem_book')){
			$nonmem_access = $this->input->post('is_nonmem_book');
			}

			$latitude	= $long_latt[0];
			$longitude	= $long_latt[1];

			$cur_date	= date('Y-m-d H:i:s');
			$status		= 1;

	/* *******************  Payment gateway to book courts Starts here. ********************** */
			$payment_ref_id = '';
			$payment = $this->input->post('court_fee');
			if($payment){
				$payment_gateway = $this->input->post('court_fee_paytype');

				if($payment_gateway == 'paypal'){
					$payment_ref_id = $this->input->post('ppids');
					if($payment_ref_id == ''){
					
						$paypalID = $this->input->post('paypal_merchantid');
						$paypal_currency = $this->input->post('currency_code');

						$data = array(
							'users_id'        => $this->logged_user,
							'paypal_merch_id' => $paypalID,
							'currency_format' => $paypal_currency,
							'status'          => 1
						);

				$this->db->insert('Paypal_Business_Accounts', $data);
					$payment_ref_id = $this->db->insert_id();
					}
				}

				if($payment_gateway == 'paytm'){
					$payment_ref_id = $this->input->post('ptmids');
					if($payment_ref_id == ''){
						$paytm_merchant_id  = $this->input->post('paytm_merchantid');
						$paytm_merchant_key = $this->input->post('paytm_merchantKey');

						$data = array(
							'users_id'			=> $this->logged_user,
							'paytm_merch_id'	=> $paytm_merchant_id,
							'paytm_merchant_key'=> $paytm_merchant_key,
							'currency_format'	=> 'INR',
							'status'			=> 1
							);

						$this->db->insert('Paytm_Business_Accounts', $data);
						$payment_ref_id = $this->db->insert_id();
					}
				}


			}else{
					
			}

	/* *******************  Payment gateway to book courts ends here. ********************** */

			$data = array(
					'org_id'	=> $this->org_id,
					'Users_id'  => $this->logged_user,
					'location'	=> $location,
					'address'	=> $addr,
					'city'		=> $city,
					'state'		=> $state,
					'country'	=> $country,
					'zipcode'	=> $zipcode,
					'instructions_comments' => $instr,
					'longitude' => $longitude,
					'latitude'	=> $latitude,
					'member_discount' => $mem_discount,
					'access_to_nonmem' => $nonmem_access,
					'created_on'=> $cur_date,
					'status'	=> $status
					);

			$this->db->insert('Academy_Court_Locations', $data);

		    $loc_id = $this->db->insert_id();
		    //$loc_id = 66;

			$courts			 = $this->input->post('courts');
			$per_hour_charge = $this->input->post('fee_per_hour');
			$slot_duration		 = $this->input->post('slot_duration');
			$min_hours		 = $this->input->post('min_book_hours');
			$max_hours		 = $this->input->post('max_book_hours');
			$max_adv_booking_days	  = $this->input->post('max_adv_booking_days');
			$max_bookings_per_day	  = $this->input->post('max_bookings_per_day');
			$allow_sameday_booking  = $this->input->post('allow_sameday_booking');
			//$is_shared_resource		 = $this->input->post('is_shared_resource');
			$max_players		 = $this->input->post('max_num_players');

			foreach($courts as $i => $court){

				$stTime   = $this->input->post('stTime_'.$i);
				$edTime   = $this->input->post('edTime_'.$i);
				$sunPrice = $this->input->post('sunPrice_'.$i);
				$monPrice = $this->input->post('monPrice_'.$i);
				$tuePrice = $this->input->post('tuePrice_'.$i);
				$wedPrice = $this->input->post('wedPrice_'.$i);
				$thuPrice = $this->input->post('thuPrice_'.$i);
				$friPrice = $this->input->post('friPrice_'.$i);
				$satPrice = $this->input->post('satPrice_'.$i);
//addn_sunPrice
				$sunAddnPrice   = $this->input->post('addn_sunPrice_'.$i);
				$monAddnPrice = $this->input->post('addn_monPrice_'.$i);
				$tueAddnPrice	 = $this->input->post('addn_tuePrice_'.$i);
				$wedAddnPrice = $this->input->post('addn_wedPrice_'.$i);
				$thuAddnPrice   = $this->input->post('addn_thuPrice_'.$i);
				$friAddnPrice = $this->input->post('addn_friPrice_'.$i);
				$satAddnPrice = $this->input->post('addn_satPrice_'.$i);
					$is_sharable = 0;
				if($this->input->post('is_sharable_'.($i+1)))
					$is_sharable = $this->input->post('is_sharable_'.($i+1));

					$allow_multiple_bookings = 0;
				if($this->input->post('is_multi_bookings'.($i+1)))
					$allow_multiple_bookings = $this->input->post('is_multi_bookings'.($i+1));

					$allow_sameday_booking = 0;
				if($this->input->post('same_day_booking'.($i+1)))
					$allow_sameday_booking = $this->input->post('same_day_booking'.($i+1));

					$max_days_adv_bookings = 0;
				if($this->input->post('max_days_adv_bookings'.($i+1)))
					$max_days_adv_bookings = $this->input->post('max_days_adv_bookings'.($i+1));

				$data = array(
					'loc_id'				 => $loc_id,
					'court_name'		 => $courts[$i],
					'slot_duration'		 => $slot_duration[$i],
					'min_book_slots'	 => $min_hours[$i],
					'max_hours'		 => $max_hours[$i],
					'max_players'	 => $max_players[$i],
					'fee_per_hour'	 => $per_hour_charge[$i],
					'currency'			 => 'USD',
					'gateway_name'	 => $payment_gateway,
					'payment_ref_id'  => $payment_ref_id,
					'is_shared_resource' => $is_sharable,
					'allow_sameday_multi_booking' => $allow_multiple_bookings,
					'allow_sameday_booking' => $allow_sameday_booking,
					'max_adv_booking_days' => $max_days_adv_bookings,
					'status'		 => 1
					);

				$ins_court = $this->db->insert('Academy_Courts', $data);
				$court_id  = $this->db->insert_id();
				//$court_id = 77;

				/* court_info_json ------------  add code */
				$data = '';
				$data['court_id']  = $court_id;
				$data['min_hours'] = ($slot_duration[$i] * $min_hours[$i]);
				$data['max_hours'] = ($slot_duration[$i] * $max_hours[$i]);
				$data['max_players'] = $max_players[$i];
				$data['court_name'] = $courts[$i];
				$data['stTime']   = $this->input->post('stTime_'.$i);
				$data['edTime']   = $this->input->post('edTime_'.$i);
				$data['sunPrice'] = $this->input->post('sunPrice_'.$i);
				$data['monPrice'] = $this->input->post('monPrice_'.$i);
				$data['tuePrice'] = $this->input->post('tuePrice_'.$i);
				$data['wedPrice'] = $this->input->post('wedPrice_'.$i);
				$data['thuPrice'] = $this->input->post('thuPrice_'.$i);
				$data['friPrice'] = $this->input->post('friPrice_'.$i);
				$data['satPrice'] = $this->input->post('satPrice_'.$i);

				//if($this->org_id == 1123)
					$json = $this->convert_json_new2($data);
				//else
				//	$json = $this->convert_json($data);

				$qry = $this->db->query("UPDATE Academy_Courts SET court_info_json = '{$json}' WHERE court_id = {$court_id}");
				
				/* court_info_json ------------  add code */

				/*echo $this->db->last_query();	exit;*/
				

				foreach($stTime as $j => $val){

				$sunPr	= $sunPrice[$j];		$monPr  = $monPrice[$j];	$tuePr = $tuePrice[$j];		$wedPr   = $wedPrice[$j]; 
				$thuPr	= $thuPrice[$j];		$friPr		= $friPrice[$j];		$satPr	 = $satPrice[$j];

				$sunAddnPr	= $sunAddnPrice[$j];		$monAddnPr  = $monAddnPrice[$j];	$tueAddnPr = $tueAddnPrice[$j];		
				$wedAddnPr = $wedAddnPrice[$j]; 		$thuAddnPr	= $thuAddnPrice[$j];		$friAddnPr		= $friAddnPrice[$j];		
				$satAddnPr	= $satAddnPrice[$j];

				if($sunPr == 'n/a')				   $sunPr = null;
				if($monPr == 'n/a')			   $monPr = null;
				if($tuePr == 'n/a')				   $tuePr = null;
				if($wedPr == 'n/a')			   $wedPr = null;
				if($thuPr == 'n/a')				   $thuPr = null;
				if($friPr == 'n/a')				   $friPr = null;
				if($satPr == 'n/a')				   $satPr = null;

				if($sunAddnPr == 'n/a')	   $sunAddnPr	 = null;
				if($monAddnPr == 'n/a')		$monAddnPr = null;
				if($tueAddnPr == 'n/a')		$tueAddnPr	= null;
				if($wedAddnPr == 'n/a')		$wedAddnPr = null;
				if($thuAddnPr == 'n/a')		$thuAddnPr	= null;
				if($friAddnPr == 'n/a')			$friAddnPr		= null;
				if($satAddnPr == 'n/a')			$satAddnPr	= null;

					$data = array(
					'Aca_ID'		=> $this->org_id,
					'Aca_Court_ID'  => $court_id,
					'Start_Time'	=> date('H:i:s', strtotime($stTime[$j])),
					'End_Time'		=> date('H:i:s', strtotime($edTime[$j])),
					'Sun_Price'		=> $sunPr,
					'Mon_Price'		=> $monPr,
					'Tue_Price'		=> $tuePr,
					'Wed_Price'		=> $wedPr,
					'Thu_Price'		=> $thuPr,
					'Fri_Price'		=> $friPr,
					'Sat_Price'		=> $satPr,
					'Sun_Addn_Price'		=> $sunAddnPr,
					'Mon_Addn_Price'	=> $monAddnPr,
					'Tue_Addn_Price'		=> $tueAddnPr,
					'Wed_Addn_Price'	=> $wedAddnPr,
					'Thu_Addn_Price'		=> $thuAddnPr,
					'Fri_Addn_Price'		=> $friAddnPr,
					'Sat_Addn_Price'		=> $satAddnPr
					);
			
					$ins_court_price = $this->db->insert('Academy_Courts_Price', $data);
					//echo $this->db->last_query();
				}
			}
			//exit;
			return 1;
		}

		public function update_court($data)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$long_latt	= explode("@", $data['long_latt']);
			
			$location	= $this->input->post('location');
			$addr		= $this->input->post('address');
			$city			= $this->input->post('city');
			$state		= $this->input->post('state');
			$country	= $this->input->post('country');
			$zipcode	= $this->input->post('zip');
			$instr		= $this->input->post('ins_comments');

			$loc_id	  = $this->input->post('loc_id');

			$mem_discount = 0;
			if($this->input->post('edit_is_discount')){
			$mem_discount = $this->input->post('edit_member_discount');
			}

			$nonmem_access = 0;
			if($this->input->post('is_nonmem_book')){
			$nonmem_access = $this->input->post('is_nonmem_book');
			}

			$latitude		= $long_latt[0];
			$longitude	= $long_latt[1];

			$cur_date	= date('Y-m-d H:i:s');
			$status		= 1;

/* *******************  Payment gateway to book courts Starts here. ********************** */
			$payment_ref_id = '';
			$payment = $this->input->post('edit_court_fee');
			if($payment){
				$payment_gateway = $this->input->post('edit_court_fee_paytype');

				if($payment_gateway == 'paypal'){
					$payment_ref_id = $this->input->post('edit_ppids');
					if($payment_ref_id == ''){
					
						$paypalID		 = $this->input->post('edit_paypal_merchantid');
						$paypal_currency = $this->input->post('edit_currency_code');

						if($paypalID and $paypal_currency){
							$data = array(
								'users_id'				  => $this->logged_user,
								'paypal_merch_id' => $paypalID,
								'currency_format'  => $paypal_currency,
								'status'					 => 1
							);
	
							$this->db->insert('Paypal_Business_Accounts', $data);
							$payment_ref_id = $this->db->insert_id();
						}
					}
				}
				else if($payment_gateway == 'paytm'){
					$payment_ref_id = $this->input->post('edit_ptmids');
					if($payment_ref_id == ''){
						$paytm_merchant_id  = $this->input->post('edit_paytm_merchantid');
						$paytm_merchant_key = $this->input->post('edit_paytm_merchantKey');
						
							if($paytm_merchant_id and $paytm_merchant_key){
								$data = array(
									'users_id'			=> $this->logged_user,
									'paytm_merch_id'	=> $paytm_merchant_id,
									'paytm_merchant_key'=> $paytm_merchant_key,
									'currency_format'	=> 'INR',
									'status'			=> 1
									);
								$this->db->insert('Paytm_Business_Accounts', $data);
								$payment_ref_id = $this->db->insert_id();
							}
					}

				}


			}


				if($payment_ref_id == '' and $country == 'United States of America'){
					$payment_gateway = 'paypal';
					$payment_ref_id = 1;
				}
				else if($payment_ref_id == '' and $country == 'India'){
					$payment_gateway = 'paytm';
					$payment_ref_id = 4;
				}

	/* *******************  Payment gateway to book courts ends here. ********************** */

			$data = array(
					'location'	=> $location,
					'address'	=> $addr,
					'city'			=> $city,
					'state'		=> $state,
					'country'	=> $country,
					'zipcode'	=> $zipcode,
					'instructions_comments' => $instr,
					'longitude' => $longitude,
					'latitude'	=> $latitude,
					'member_discount'		=> $mem_discount,
					'access_to_nonmem'	=> $nonmem_access,
					'modified_on'				=> $cur_date,
					'status'							=> $status
					);

			//echo "<pre>"; print_r($data); exit;
			$this->db->where('loc_id', $loc_id);
			$this->db->update('Academy_Court_Locations', $data);


			$courts_id				= $this->input->post('courts_id');
			$courts						= $this->input->post('courts');
			$per_hour_charge	= $this->input->post('fee_per_hour');
			$slot_duration			= $this->input->post('slot_duration');
			$min_hours				= $this->input->post('min_book_hours');
			$max_hours				= $this->input->post('max_book_hours');
			$max_players			= $this->input->post('max_num_players');
			$court_status			= $this->input->post('status');

			foreach($courts as $i => $court){

					$is_sharable = 0;
				if($this->input->post('is_sharable_'.($i+1)))
					$is_sharable = $this->input->post('is_sharable_'.($i+1));

					$allow_multiple_bookings = 0;
				if($this->input->post('is_multi_bookings'.($i+1)))
					$allow_multiple_bookings = $this->input->post('is_multi_bookings'.($i+1));

					$allow_sameday_booking = 0;
				if($this->input->post('same_day_booking'.($i+1)))
					$allow_sameday_booking = $this->input->post('same_day_booking'.($i+1));

					$max_days_adv_bookings = 0;
				if($this->input->post('max_days_adv_bookings'.($i+1)))
					$max_days_adv_bookings = $this->input->post('max_days_adv_bookings'.($i+1));

				$data = array(
					'loc_id'				=> $loc_id,
					'court_name'		=> $courts[$i],
					'max_hours'		=> $max_hours[$i],
					'min_book_slots'	=> $min_hours[$i],
					'slot_duration'		=> $slot_duration[$i],
					'max_players'		=> $max_players[$i],
					//'fee_per_hour'	=> $per_hour_charge[$i],
					'currency'				=> 'USD',
					'gateway_name'   => $payment_gateway,
					'payment_ref_id'	=> $payment_ref_id,
					'is_shared_resource' => $is_sharable,
					'allow_sameday_multi_booking' => $allow_multiple_bookings,
					'allow_sameday_booking' => $allow_sameday_booking,
					'max_adv_booking_days' => $max_days_adv_bookings,
					'status'					=> $court_status[$i]
					);

				if($courts_id[$i]){
					$crt_id = $courts_id[$i];
					$this->db->where('court_id', $courts_id[$i]);
					$this->db->update('Academy_Courts', $data);
				}
				else{
					$ins_court = $this->db->insert('Academy_Courts', $data);
					$crt_id		= $this->db->insert_id();
				}

/* **************************** */
				$data = '';
				$data['court_id']  = $crt_id;
				$data['min_hours'] = ($slot_duration[$i] * $min_hours[$i]);
				$data['max_hours'] =  ($slot_duration[$i] * $max_hours[$i]);
				$data['max_players'] = $max_players[$i];
				$data['court_name'] = $courts[$i];
				$data['stTime']   = $this->input->post('stTime_'.$i);
				$data['edTime']   = $this->input->post('edTime_'.$i);
				$data['sunPrice'] = $this->input->post('sunPrice_'.$i);
				$data['monPrice'] = $this->input->post('monPrice_'.$i);
				$data['tuePrice'] = $this->input->post('tuePrice_'.$i);
				$data['wedPrice'] = $this->input->post('wedPrice_'.$i);
				$data['thuPrice'] = $this->input->post('thuPrice_'.$i);
				$data['friPrice'] = $this->input->post('friPrice_'.$i);
				$data['satPrice'] = $this->input->post('satPrice_'.$i);

				//if($this->org_id == 1123)
					$json = $this->convert_json_new2($data);
				//else
					//$json = $this->convert_json($data);

				$qry = $this->db->query("UPDATE Academy_Courts SET court_info_json = '{$json}' WHERE court_id = {$crt_id}");

				$data = '';
				
/* **************************** */

				$this->db->where('Aca_ID', $this->org_id);
				$this->db->where('Aca_Court_ID', $crt_id);
				$this->db->delete('Academy_Courts_Price');

				$stTime   = $this->input->post('stTime_'.$i);
				$edTime   = $this->input->post('edTime_'.$i);
				$sunPrice = $this->input->post('sunPrice_'.$i);
				$monPrice = $this->input->post('monPrice_'.$i);
				$tuePrice = $this->input->post('tuePrice_'.$i);
				$wedPrice = $this->input->post('wedPrice_'.$i);
				$thuPrice = $this->input->post('thuPrice_'.$i);
				$friPrice = $this->input->post('friPrice_'.$i);
				$satPrice = $this->input->post('satPrice_'.$i);

				$sunAddnPrice   = $this->input->post('sunAddnPrice_'.$i);
				$monAddnPrice = $this->input->post('monAddnPrice_'.$i);
				$tueAddnPrice	 = $this->input->post('tueAddnPrice_'.$i);
				$wedAddnPrice = $this->input->post('wedAddnPrice_'.$i);
				$thuAddnPrice   = $this->input->post('thuAddnPrice_'.$i);
				$friAddnPrice = $this->input->post('friAddnPrice_'.$i);
				$satAddnPrice = $this->input->post('satAddnPrice_'.$i);


				foreach($stTime as $j => $val){

				$sunPr = $sunPrice[$j]; $monPr = $monPrice[$j]; $tuePr = $tuePrice[$j]; $wedPr = $wedPrice[$j]; $thuPr = $thuPrice[$j];
				$friPr = $friPrice[$j]; $satPr = $satPrice[$j];

				$sunAddnPr	= $sunAddnPrice[$j];		$monAddnPr  = $monAddnPrice[$j];	$tueAddnPr = $tueAddnPrice[$j];		
				$wedAddnPr = $wedAddnPrice[$j]; 		$thuAddnPr	= $thuAddnPrice[$j];		$friAddnPr		= $friAddnPrice[$j];		
				$satAddnPr	= $satAddnPrice[$j];

				if($sunPr == 'n/a')				   $sunPr = null;
				if($monPr == 'n/a')			   $monPr = null;
				if($tuePr == 'n/a')				   $tuePr = null;
				if($wedPr == 'n/a')			   $wedPr = null;
				if($thuPr == 'n/a')				   $thuPr = null;
				if($friPr == 'n/a')				   $friPr = null;
				if($satPr == 'n/a')				   $satPr = null;

				if($sunAddnPr == 'n/a')	    $sunAddnPr	 = null;
				if($monAddnPr == 'n/a')	$monAddnPr = null;
				if($tueAddnPr == 'n/a')		$tueAddnPr	 = null;
				if($wedAddnPr == 'n/a')		$wedAddnPr  = null;
				if($thuAddnPr == 'n/a')		$thuAddnPr	= null;
				if($friAddnPr == 'n/a')		$friAddnPr	= null;
				if($satAddnPr == 'n/a')		$satAddnPr	= null;

					$data = array(
					'Aca_ID'			=> $this->org_id,
					'Aca_Court_ID'  => $crt_id,
					'Start_Time'		=> date('H:i:s', strtotime($stTime[$j])),
					'End_Time'		=> date('H:i:s', strtotime($edTime[$j])),
					'Sun_Price'		=> $sunPr,
					'Mon_Price'		=> $monPr,
					'Tue_Price'		=> $tuePr,
					'Wed_Price'		=> $wedPr,
					'Thu_Price'		=> $thuPr,
					'Fri_Price'			=> $friPr,
					'Sat_Price'		=> $satPr,
					'Sun_Addn_Price'		=> $sunAddnPr,
					'Mon_Addn_Price'		=> $monAddnPr,
					'Tue_Addn_Price'		=> $tueAddnPr,
					'Wed_Addn_Price'	=> $wedAddnPr,
					'Thu_Addn_Price'		=> $thuAddnPr,
					'Fri_Addn_Price'		=> $friAddnPr,
					'Sat_Addn_Price'		=> $satAddnPr
					);

				$ins_court_price = $this->db->insert('Academy_Courts_Price', $data);
				}

			}
			return 1;
		}

		public function get_loc_name($loc_id){
			$data  = array('loc_id' => $loc_id);
			$query = $this->db->get_where('Academy_Court_Locations', $data);
			$get_data = $query->row_array();

			return $get_data['location'];
		}

		public function get_court_name($court_id){
			$data  = array('court_id' => $court_id);
			$query = $this->db->get_where('Academy_Courts', $data);
			$get_data = $query->row_array();

			return $get_data['court_name'];
		}

		public function get_court_det($court_id){
			$data  = array('court_id' => $court_id);
			$query = $this->db->get_where('Academy_Courts', $data);
			$get_data = $query->row_array();

			return $get_data;
		}

		public function check_court_booking($data) {
			$loc_id = $data['loc_id'];
			$court_id = $data['court_id'];
			$res_date = $data['res_date'];
			$from_time = $data['from_time'];
			$to_time = $data['to_time'];

			$query = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE loc_id = {$loc_id} AND court_id = {$court_id} AND res_date = '{$res_date}' AND from_time = '{$from_time}' AND to_time = '{$to_time}' AND res_status = 'Active'");
			//echo $this->db->last_query();

			if($query->num_rows() > 0)
				return 0;
			else
				return 1;
		}

		public function is_nxt_avail($court, $nxt, $from_time, $to_time){
			if($court){
				$qry_check = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE court_id = $court AND res_date = '$nxt' AND ((from_time <= '$from_time' AND to_time > '$from_time') OR (from_time < '$to_time' AND to_time >= '$to_time')) AND res_status = 'Active'"); 
				//echo $this->db->last_query()."<br>";
				if($qry_check->num_rows())
					return 0;
				else
					return 1;
			}
			else
				return 0;
		}

		public function check_court_avail() {
			$return_val = '';
			
			$loc_id		= $this->input->post('loc_id');
			$court_id	= $this->input->post('court');
			$res_date = explode(" ", $this->input->post('res_date'));
			$res_time = $this->input->post('res_time');
			$hrs			= $this->input->post('book_hours');
			
			//if(!$res_date[1]){
			//$res_date = explode("T", $this->input->post('res_date'));
			//}

			$rdate			= date('Y-m-d', strtotime($res_date[0]));
			$from_time  = date('H:i', strtotime($res_time)); 

			$court_durations		= $this->get_court_durations($loc_id, $court_id);
			$sd		= $court_durations['slot_duration'];
			$mins	= ($hrs * 60) * $sd;
//echo $mins; exit;
			/*if($hrs > 19) {
				$to_time = date('H:i', strtotime('+'.$hrs.' minutes', strtotime($res_date[1])));
			}
			else {
				$to_time = date('H:i', strtotime('+'.$hrs.' hours', strtotime($res_date[1])));
			}*/

				$to_time = date('H:i', strtotime('+'.$mins.' minutes', strtotime($res_time)));


			$day			= strtolower(date('D', strtotime($res_date[0])));
			$qry_1		= $this->db->query("SELECT * FROM Academy_Courts WHERE court_id = {$court_id}");
			$rows1		= $qry_1->row_array();
			$court_info		 = $rows1['court_info_json'];
			$court_info_arr = json_decode($court_info, true);
		
			//echo "<pre>$day";
			//print_r($court_info_arr);
			//print_r($court_info_arr['court_prices'][$day]['break']);
			//exit;
			
			$break_arr   = $court_info_arr['court_prices'][$day]['break'];
			$timings_arr = $court_info_arr['court_prices'][$day]['actual_timings'];

			if(!empty($timings_arr)){
				if(
					$from_time < $timings_arr['start_time'] 
				or  $from_time > $timings_arr['end_time']
				or  $to_time   < $timings_arr['start_time']
				or  $to_time   > $timings_arr['end_time']
					) {
					$return_val = 3;
				}				
			}

			if(!empty($break_arr) and $return_val == ''){
				foreach($break_arr as $i => $arr){

					for($x = $from_time; $x <= $to_time; ){

						if($x > $arr['start_time'] and $x < $arr['end_time']) {
							$return_val = 3;
							break;
						}

						$x = date('H:i', strtotime('+'.($sd * 60).' minutes', strtotime($x)));
						//echo $x; exit;
					}

					if($return_val == 3) 
						break;
				}
			}

			
			//echo $return_val;

			if($return_val == '') {

				$qry_check = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE loc_id = $loc_id AND court_id = $court_id AND res_date = '$rdate' AND ((from_time <= '$from_time' AND to_time > '$from_time') OR (from_time < '$to_time' AND to_time >= '$to_time')) AND res_status = 'Active'"); 
				//if($this->logged_user == 240)
				//	echo $this->db->last_query();

				$rows = $qry_check->num_rows();

				if($rows == 0) {
				   if(strtotime($from_time) < strtotime($to_time)) {

						/*$data = array('court_id' => $court_id,
							'loc_id'		=> $loc_id,
							'reserved_by'	=> $this->logged_user,
							'res_date'		=> $rdate,
							'from_time'		=> $from_time,
							'to_time'		=> $to_time,
							'created_on'	=> date('Y-m-d'),
							'res_status'	=> 'Active',
							);

						$result  = $this->db->insert('Academy_Court_Reservations', $data);*/
						$return_val = 1;
					}
					else
					{ $return_val = 2; }
				}
				else { $return_val = 0; }
			}

			return $return_val;
		}

		public function get_court_price(){

			$loc_id   = $this->input->post('loc_id');
			$court_id = $this->input->post('court');
			$res_date = explode(" ",$this->input->post('res_date'));
			$res_time = $this->input->post('res_time');
			$hrs	  = $this->input->post('book_hours');

			$court_durations		= $this->get_court_durations($loc_id, $court_id);
			$sd		= $court_durations['slot_duration'];

			$rdate		= date('Y-m-d', strtotime($res_date[0]));
			$from_time  = date('H:i', strtotime($res_time)); 
			//$from_time  = date('H:i', strtotime($res_date[1])); 
			/*if($hrs > 19){
			$to_time	= date('H:i', strtotime('+'.$hrs.' minutes', strtotime($res_date[1])));
			}
			else{
			$to_time	= date('H:i', strtotime('+'.$hrs.' hours', strtotime($res_date[1])));
			}*/
			$get_loc  = $this->db->query("SELECT * FROM Academy_Court_Locations WHERE loc_id = $loc_id");
			$loc_data = $get_loc->row_array();
			$dis_percentage = $loc_data['member_discount'];

			$temp_from_time = $from_time;
			$tot_price = 0.00;
			for($h=1; $h<=($hrs*2); $h++) {
				
				//$to_time = date('H:i', strtotime('+1'.' hours', strtotime($temp_from_time)));
				$to_time = date('H:i', strtotime('+'.($sd * 60).' minutes', strtotime($temp_from_time)));
//echo $temp_from_time." ".$to_time; exit;
				$qry_check = $this->db->query("SELECT * FROM Academy_Courts_Price WHERE Aca_Court_ID = $court_id 
				AND Start_Time = '$temp_from_time' AND End_Time = '$to_time'"); 
				//echo $this->db->last_query();

				$row = $qry_check->row_array();

				$qry_check2 = $this->db->query("SELECT * FROM Academy_Courts_Price WHERE Aca_Court_ID = $court_id 
				AND Start_Time <= '$temp_from_time' AND End_Time >= '$to_time'"); 
				//echo $this->db->last_query();

				$row2 = $qry_check2->row_array();

				if($row){
					//echo "<pre>"; echo 'row'; print_r($row); 
					 $jd = cal_to_jd(CAL_GREGORIAN,
					 date('m', strtotime($res_date[0])),date('d', strtotime($res_date[0])),date('Y', strtotime($res_date[0])));
					 $day = jddayofweek($jd,2);

					 $tot_price += number_format(($row["{$day}_Price"]/2), 2);
					// echo "tot price 1".$tot_price."<br>";
				}
				else if($row2){
					//echo "<pre>"; echo 'row2'; print_r($row2); 
					 $jd = cal_to_jd(CAL_GREGORIAN,
					 date('m', strtotime($res_date[0])),date('d', strtotime($res_date[0])),date('Y', strtotime($res_date[0])));
					 $day = jddayofweek($jd,2);

					 $tot_price += number_format(($row2["{$day}_Price"]/2), 2);
					 //echo "tot price 2".$tot_price."<br>";
				}

			$temp_from_time = $to_time;
			}

			if($this->logged_user == $this->academy_admin)
			$tot_price = 0.00;

			if($this->is_club_member and $dis_percentage and $tot_price > 0){
			//if($dis_percentage and $tot_price > 0){
				$tot_price = $tot_price - ($dis_percentage / 100) * $tot_price;
			}

			return number_format($tot_price, 2);
		}

		public function check_payable($court_id){
			$data  = array('court_id' => $court_id);
			$query = $this->db->get_where('Academy_Courts', $data);
			return $query->row_array();
		}

		public function confirm_court($data){
			$result  = $this->db->insert('Academy_Court_Reservations', $data);
		}

		public function get_paypalIDs($uid){
			$data = array('users_id' => $uid);
			$query = $this->db->get_where('Paypal_Business_Accounts', $data);
			return $query->result();
		}

		public function get_paytmIDs($uid){
			$data = array('users_id' => $uid);
			$query = $this->db->get_where('Paytm_Business_Accounts', $data);
			return $query->result();
		}

		public function get_currency_codes(){
			 $this->db->select('code');
			 $this->db->from('Currency');
			 $query = $this->db->get();

			 return $query->result();
		}

		public function get_payment_info($loc_info){
			$data = array('loc_id' => $loc_info);
			$query = $this->db->get_where('Academy_Courts', $data);

			return $query->row_array();
		}

		public function get_selected_values($id,$gateway,$uid){
			if($gateway == 'paypal'){
				$data = array('pp_busi_id' => $id, 'users_id' => $uid);
				$query = $this->db->get_where('Paypal_Business_Accounts', $data);
			}else {
				$data = array('paytm_busi_id' => $id, 'users_id' => $uid);
				$query = $this->db->get_where('Paytm_Business_Accounts', $data);
			}
			return $query->row_array();
		}

		public function getCourtsTimesFees($courtID){
			$data = array('Aca_Court_ID' => $courtID);
			$query = $this->db->get_where('Academy_Courts_Price', $data);

			return $query->result();
		}

		public function get_paypal_info($pid){
			if($pid){
			$data = array('pp_busi_id' => $pid);
			$query = $this->db->get_where('Paypal_Business_Accounts', $data);

			     return $query->row_array();
			}
			else{
				return 0;
			}
		}

		public function get_paytm_info($pid){
			if($pid){
			$data = array('paytm_busi_id' => $pid);
			$query = $this->db->get_where('Paytm_Business_Accounts', $data);

			     return $query->row_array();
			}
			else{
				return 0;
			}
		}

		public function delete_booking($rec_id){
			$query = $this->db->query("UPDATE Academy_Court_Reservations SET res_status = 'Canceled', cancelled_by='club_admin', cancelled_user = '".$this->logged_user."' WHERE res_id = '".$rec_id."'");
		
				$data = array('res_id' => $rec_id);
				$query2 = $this->db->get_where('Academy_Court_Reservations', $data);

			     return $query2->row_array();
		}

		public function get_userToken($user_id)	{
			$data  = array('user_id' => $user_id, 'status' => 1);
			$query = $this->db->get_where('userPushTokens', $data);
			return $query->result();
		}

		public function insert_notif($data){
			$query = $this->db->insert('Mobile_Notifications', $data);
			return $query;
		}
		
		public function get_min_max_court_time($loc_id){
			$qry = $this->db->query("SELECT min(Start_Time) as min_time FROM Academy_Courts_Price WHERE Aca_Court_ID in (SELECT court_id FROM Academy_Courts WHERE loc_id = {$loc_id})");
			$res = $qry->row_array();

			$qry2 = $this->db->query("SELECT max(End_Time) as max_time FROM Academy_Courts_Price WHERE Aca_Court_ID in (SELECT court_id FROM Academy_Courts WHERE loc_id = {$loc_id})");
			$res2 = $qry2->row_array();

			return array('min' => $res['min_time'], 'max' => $res2['max_time']);
		}

		public function get_courtPrice($court_id){
			$qry = $this->db->query("SELECT * FROM Academy_Courts_Price WHERE Aca_Court_ID = {$court_id}");
			return $qry->row_array();
		}

		public function is_same_day_booking($court_id, $user_id, $book_date){
			$res_date = date('Y-m-d', strtotime($book_date));
			//echo $court_id." ".$res_date." ".$res_date;
			$qry = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE reserved_by = {$user_id} AND court_id = {$court_id} AND res_date = '{$res_date}' AND res_status = 'Active'");
			//if($user_id == 240)
			//echo $this->db->last_query();

			return $qry->num_rows();
		}

		public function is_same_day_othercourt_booking($loc_id, $court_id, $user_id, $book_date){
			$res_date = date('Y-m-d', strtotime($book_date));
			//echo $court_id." ".$res_date." ".$res_date;
			$qry1 = $this->db->query("SELECT * FROM Academy_Courts WHERE loc_id = {$loc_id} AND court_id != {$court_id} AND status = 1");

			$qry_res = $qry1->result();
			$count = 0;
			if($qry_res){
				foreach($qry_res as $res){
					$qry = $this->db->query("SELECT * FROM Academy_Court_Reservations WHERE reserved_by = {$user_id} AND court_id = {$res->court_id} AND res_date = '{$res_date}' AND res_status = 'Active'");
					if($qry->num_rows() > 0)
						$count++;
				}
			}

			return $count;
		}

	public function is_club_member($user_id, $club_id){

		if($user_id and $club_id){
			$query2 = $this->db->query("SELECT * FROM User_memberships WHERE Club_id = {$club_id} AND Users_id = {$user_id} AND Member_Status = 1");
			if($query2->num_rows() > 0)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
	}

	public function is_club_admin($user_id, $club_id){
		if($user_id == 240)
			return 1;
		else{
			if($user_id and $club_id){
				$query2 = $this->db->query("SELECT * FROM Academy_Info WHERE Aca_ID = {$club_id} AND Aca_User_id = {$user_id}");
				if($query2->num_rows() > 0)
					return 1;
				else
					return 0;
			}
			else{
				return 0;
			}
		}
	}

	public function is_club_coach($user_id, $club_id){

		if($user_id and $club_id){
			$query2 = $this->db->query("SELECT * FROM Users WHERE Users_ID = {$user_id} AND coach_academy = {$club_id} AND is_coach = 1");
			if($query2->num_rows() > 0)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
	}

		public function convert_json_new($data){

			$court_id			= $data['court_id'];
			$court_name	= $data['court_name'];
			$max_hours		= $data['max_hours'];
			$max_players	= $data['max_players'];

			//foreach($courts as $i => $court){

				$stTime		= $data['stTime'];
				$edTime		= $data['edTime'];
				$sunPrice		= $data['sunPrice'];
				$monPrice	= $data['monPrice'];
				$tuePrice		= $data['tuePrice'];
				$wedPrice	= $data['wedPrice'];
				$thuPrice		= $data['thuPrice'];
				$friPrice		= $data['friPrice'];
				$satPrice		= $data['satPrice'];

				
		
				$json_data['court_info'] = array('court_id' => $court_id, 'court_name' => $court_name, 'max_players'=> (int)$max_players);
				$json_data['court_timings'] = array('open_days' => array('sun','mon','tue','wed','thu','fri','sat'),
													'close_days' => null);
				
			$pr = array();
			$stdt = array();
				foreach($stTime as $j => $val){
			
					if($sunPrice[$j] != 'n/a' and $sunPrice[$j] != ""){
						$stdt['sun']['st'][] =  $stTime[$j];
						$stdt['sun']['ed'][] =  $edTime[$j];

					$pr['sun'][] = array('price' => $sunPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[0][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[0][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($monPrice[$j] != 'n/a' and $monPrice[$j] != ""){
						$stdt['mon']['st'][] =  $stTime[$j];
						$stdt['mon']['ed'][] =  $edTime[$j];

					$pr['mon'][] = array('price' => $monPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[1][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[1][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}


					if($tuePrice[$j] != 'n/a' and $tuePrice[$j] != ""){
						$stdt['tue']['st'][] =  $stTime[$j];
						$stdt['tue']['ed'][] =  $edTime[$j];

					$pr['tue'][] = array('price' => $tuePrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[2][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[2][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($wedPrice[$j] != 'n/a' and $wedPrice[$j] != ""){
						$stdt['wed']['st'][] =  $stTime[$j];
						$stdt['wed']['ed'][] =  $edTime[$j];

					$pr['wed'][] = array('price' => $wedPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[3][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[3][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($thuPrice[$j] != 'n/a' and $thuPrice[$j] != ""){
						$stdt['thu']['st'][] =  $stTime[$j];
						$stdt['thu']['ed'][] =  $edTime[$j];

					$pr['thu'][] = array('price' => $thuPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[4][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[4][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($friPrice[$j] != 'n/a' and $friPrice[$j] != ""){
						$stdt['fri']['st'][] =  $stTime[$j];
						$stdt['fri']['ed'][] =  $edTime[$j];

					$pr['fri'][] = array('price' => $friPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[5][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[5][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($satPrice[$j] != 'n/a' and $satPrice[$j] != ""){
						$stdt['sat']['st'][] =  $stTime[$j];
						$stdt['sat']['ed'][] =  $edTime[$j];

					$pr['sat'][] = array('price' => $satPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//break_times[6][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						$break_times[6][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					//$ins_court_price = $this->db->insert('Academy_Courts_Price', $data);
				}

/* ***************************************************************************** */
		//echo "<pre>"; print_r($stdt); exit;
		$court_min_time = array();
		$court_max_time = array();
		$court_timings = array();
		foreach($stdt as $day => $tms){

				$court_min_time[$day] = date("H:i", strtotime(min($tms['st'])));
				$court_max_time[$day] = date("H:i", strtotime(max($tms['ed'])));

				$court_timings[$day] = array('start_time' => "{$court_min_time[$day]}", 'end_time' => "{$court_max_time[$day]}");
				//if($loc_id == 30)
					//echo "<pre>"; print_r($stTime); exit;
					$court_valid_times = array();
				foreach($tms['st'] as $j => $st) {
					$st = date("H:i", strtotime($st));
					$ed = date("H:i", strtotime($tms['ed'][$j]));
					for($k = $st; $k < $ed; ) {
						$k  = date("H:i", strtotime($k));
						$kk = date("H:i", strtotime($k."+1 hours"));
						$court_valid_times[] = $k.'-'.$kk;
						$k = $kk;
					}
				}

				for($m = $court_min_time[$day]; $m < $court_max_time[$day]; ) {
					$mmm_arr	= '';
					$m				= date("H:i", strtotime($m));
					$mm			= date("H:i", strtotime($m."+1 hours"));
					$mmm		= $m.'-'.$mm;
					$mmm_arr	  = array('start_time' => $m, 'end_time' => $mm);
					$hour_arr[] = $mmm;

					if(!in_array($mmm, $court_valid_times)){
						//$break_times[$i][] = $mmm_arr;
						$break_times[$day][] = $mmm_arr;
					}
					$m = $mm;
				}
		}
/* ***************************************************************************** */


					$court_prices['sun'] = array(
							'actual_timings' => $court_timings['sun'], 
							'break'			 => $break_times['sun'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sun']
						   );

					$court_prices['mon'] = array(
							'actual_timings' => $court_timings['mon'], 
							'break'			 => $break_times['mon'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['mon']
						   );

					$court_prices['tue'] = array(
							'actual_timings' => $court_timings['tue'], 
							'break'			 => $break_times['tue'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['tue']
						   );

					$court_prices['wed'] = array(
							'actual_timings' => $court_timings['wed'], 
							'break'			 => $break_times['wed'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['wed']
						   );

					$court_prices['thu'] = array(
							'actual_timings' => $court_timings['thu'], 
							'break'			 => $break_times['thu'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['thu']
						   );

					$court_prices['fri'] = array(
							'actual_timings' => $court_timings['fri'], 
							'break'			 => $break_times['fri'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['fri']
						   );

					$court_prices['sat'] = array(
							'actual_timings' => $court_timings['sat'], 
							'break'			 => $break_times['sat'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sat']
						   );

			$json_data['court_prices'] = $court_prices;
			$json_format2 = json_encode($json_data);

			/*echo "<pre>";
			print_r($json_data);
			echo $json_format2;
			exit;*/

			return $json_format2;
		}

		public function convert_json_new2($data){

			$court_id			= $data['court_id'];
			$court_name	= $data['court_name'];
			$max_hours		= $data['max_hours'];
			$max_players	= $data['max_players'];

			//foreach($courts as $i => $court){

				$stTime   = $data['stTime'];
				$edTime   = $data['edTime'];
				$sunPrice = $data['sunPrice'];
				$monPrice = $data['monPrice'];
				$tuePrice = $data['tuePrice'];
				$wedPrice = $data['wedPrice'];
				$thuPrice = $data['thuPrice'];
				$friPrice = $data['friPrice'];
				$satPrice = $data['satPrice'];

				
				$court_min_time = date("H:i", strtotime(min($stTime)));
				$court_max_time = date("H:i", strtotime(max($edTime)));

				$court_timings = array('start_time' => "{$court_min_time}", 'end_time' => "{$court_max_time}");

				foreach($stTime as $j => $st) {
					$st = date("H:i", strtotime($st));
					$ed = date("H:i", strtotime($edTime[$j]));
					for($k = $st; $k < $ed; ) {
						$k  = date("H:i", strtotime($k));
						$kk = date("H:i", strtotime($k."+1 hours"));
						if(!in_array($k.'-'.$kk, $court_valid_times)){
						$court_valid_times[] = $k.'-'.$kk;
						}
						$k = $kk;
					}
				}
				/*echo "<pre>";
				print_r($court_valid_times);
				echo "<br>----vt----";*/
				/*for($m = $court_min_time; $m < $court_max_time; ) {
					$mmm_arr	= '';
					$m			= date("H:i", strtotime($m));
					$mm			= date("H:i", strtotime($m."+1 hours"));
					$mmm		= $m.'-'.$mm;
					$mmm_arr	= array('start_time' => $m, 'end_time' => $mm);
					$hour_arr[] = $mmm;

					if(!in_array($mmm, $court_valid_times)){
						//$break_times[$i][] = $mmm_arr;
						$break_times[0][] = $mmm_arr;
						$break_times[1][] = $mmm_arr;
						$break_times[2][] = $mmm_arr;
						$break_times[3][] = $mmm_arr;
						$break_times[4][] = $mmm_arr;
						$break_times[5][] = $mmm_arr;
						$break_times[6][] = $mmm_arr;
					}
					$m = $mm;
				}
				*/
				/*echo "<pre>";
				print_r($hour_arr);
				echo "<br>---hrs-----";*/
		
				$json_data['court_info'] = array('court_id' => $court_id, 'court_name' => $court_name, 'max_players'=> (int)$max_players);
				$json_data['court_timings'] = array('open_days' => array('sun','mon','tue','wed','thu','fri','sat'),
													'close_days' => null);
				
			$pr = array();
				foreach($stTime as $j => $val){
					/*$data = array(
					'Aca_ID'		=> $this->org_id,
					'Aca_Court_ID'  => $court_id,
					'Start_Time'	=> date('H:i:s', strtotime($stTime[$j])),
					'End_Time'		=> date('H:i:s', strtotime($edTime[$j])),
					'Sun_Price'		=> $sunPrice[$j],
					'Mon_Price'		=> $monPrice[$j],
					'Tue_Price'		=> $tuePrice[$j],
					'Wed_Price'		=> $wedPrice[$j],
					'Thu_Price'		=> $thuPrice[$j],
					'Fri_Price'		=> $friPrice[$j],
					'Sat_Price'		=> $satPrice[$j]
					);*/
					
					if($sunPrice[$j] != 'n/a' and $sunPrice[$j] != ''){
					$pr['sun'][] = array('price' => $sunPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[0][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						//$break_times[0][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($monPrice[$j] != 'n/a' and $monPrice[$j] != ''){
					$pr['mon'][] = array('price' => $monPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[1][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						//$break_times[1][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}


					if($tuePrice[$j] != 'n/a' and $tuePrice[$j] != ''){
					$pr['tue'][] = array('price' => $tuePrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[2][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						//$break_times[2][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($wedPrice[$j] != 'n/a' and $wedPrice[$j] != ''){
					$pr['wed'][] = array('price' => $wedPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[3][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						//$break_times[3][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($thuPrice[$j] != 'n/a' and $thuPrice[$j] != ''){
					$pr['thu'][] = array('price' => $thuPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[4][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						//$break_times[4][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($friPrice[$j] != 'n/a' and $friPrice[$j] != ''){
					$pr['fri'][] = array('price' => $friPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//$break_times[5][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						//$break_times[5][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					if($satPrice[$j] != 'n/a' and $satPrice[$j] != ''){
					$pr['sat'][] = array('price' => $satPrice[$j],
						'start_time' => date('H:i', strtotime($stTime[$j])),
						'end_time'   => date('H:i', strtotime($edTime[$j]))
						);
					}
					else{
						//break_times[6][] = array(date('H:i', strtotime($stTime[$j])), date('H:i', strtotime($edTime[$j])));
						//$break_times[6][] = array('start_time' => date('H:i', strtotime($stTime[$j])), 'end_time' => date('H:i', strtotime($edTime[$j])));
					}

					//$ins_court_price = $this->db->insert('Academy_Courts_Price', $data);
				}

	//$break_times[$day] = array();

/*foreach($court_valid_times as $tm){
	$x		= explode("-", $tm);
	$vt1 = strtotime($x[0]);
	$vt2 = strtotime($x[1]);

	foreach($pr as $day => $vt){
		foreach($vt as $i => $values){
			$st  = strtotime($values['start_time']);
			$ed = strtotime($values['end_time']);
			//if($day == 'sun')
				//echo $vt1." - ".$vt2." - ".$st." - ".$ed."<br>";
			if($st > $vt1 or $ed < $vt2){
				$break_times[$day][] = array('start_time' => $x[0], 'end_time' => $x[1]);
			}
		}
	}
}*/


	foreach($pr as $day => $vt){
		foreach($vt as $i => $values){
			$st  = strtotime($values['start_time']);
			$ed = strtotime($values['end_time']);
			foreach($court_valid_times as $tm){
			$x		= explode("-", $tm);
			$vt1 = strtotime($x[0]);
			$vt2 = strtotime($x[1]);
				if($st > $vt1 or $ed < $vt2){
					$break_times[$day][] = array('start_time' => $x[0], 'end_time' => $x[1]);
				}
			}
	}
}
/*echo "<pre>"; 
print_r($court_valid_times); 
echo "--------------------------";
print_r($break_times); 
exit;*/

					$court_prices['sun'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['sun'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sun']
						   );

					$court_prices['mon'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['mon'],
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['mon']
						   );

					$court_prices['tue'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['tue'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['tue']
						   );

					$court_prices['wed'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['wed'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['wed']
						   );

					$court_prices['thu'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['thu'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['thu']
						   );

					$court_prices['fri'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['fri'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['fri']
						   );

					$court_prices['sat'] = array(
							'actual_timings' => $court_timings, 
							'break'			 => $break_times['sat'], 
							'step'			 => "0.5", 
							'min_booking_hours' => "1", 
							'max_booking_hours'	=> "{$max_hours}",
							'prices'		 => $pr['sat']
						   );

			$json_data['court_prices'] = $court_prices;
			$json_format2 = json_encode($json_data);

			/*echo "<pre>";
			print_r($json_data);
			echo $json_format2;
			exit;*/

			return $json_format2;
		}

}