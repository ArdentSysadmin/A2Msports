<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_clubs extends CI_Controller {

public function __construct(){
    parent::__construct();
	$this->load->helper(array('form', 'url'));
	$this->load->library('session');

    $this->load->model('model_csv_import');
}

public function index(){   
    //$this->load->view('view_CSVUpload');
}

public function csv_import(){
	$today	  = date('mdY');
	$fname	  = "clubs_{$today}.csv";
    $filename = "C:\inetpub\wwwroot\a2msportssite\csv_source\\".$fname;
      if(file_exists($filename)){
		  $count	 = 0;
		  $dot_count = 0;
          $file		 = fopen($filename, "r");

           while(($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
				$club_name = trim($importdata[0]);
				if($club_name != "" and $club_name != "Club Name") {
					
					$data['Aca_name'] = trim($importdata[0]);
					if(trim($importdata[1]) != '')
					$data['Aca_city'] = trim($importdata[1]);

					if(trim($importdata[2]) != '')
					$data['Aca_state'] = trim($importdata[2]);

					if(trim($importdata[3]) != '')
					$data['Aca_country'] = trim($importdata[3]);

					if(trim($importdata[4]) != '')
					$data['Aca_url'] = trim($importdata[4]);

					if(trim($importdata[5]) != '')
					$data['Aca_contact_name'] = trim($importdata[5]);

					if(trim($importdata[6]) != '')
					$data['Aca_contact_phone'] = trim($importdata[6]);

					if(trim($importdata[7]) != '')
					$data['Aca_contact_email'] = trim($importdata[7]);

					if(trim($importdata[8]) != '')
					$data['Aca_details'] = trim($importdata[8]);

					if(trim($importdata[9]) != '')
					$data['Aca_no_of_courts'] = trim($importdata[9]);

					if(trim($importdata[10]) != '')
					$data['Aca_sport'] = trim($importdata[10]);

					if(trim($importdata[11]) != '')
					$data['Aca_logo'] = trim($importdata[11]);

					if(trim($importdata[12]) != '')
					$data['Aca_User_id'] = trim($importdata[12]);

					if(trim($importdata[13]) != '')
					$data['Aca_AddressLine1'] = trim($importdata[13]);

					if(trim($importdata[14]) != '')
					$data['Aca_AddressLine2'] = trim($importdata[14]);

					if(trim($importdata[15]) != '')
					$data['Aca_Zip'] = trim($importdata[15]);

					$data = array(
					  'Aca_name'		  => $importdata[0],
					  'Aca_city'		  => $importdata[1],
					  'Aca_state'	      => $importdata[2],
					  'Aca_country'		  => $importdata[3],
					  'Aca_url'			  => $importdata[4],
					  'Aca_contact_name'  => $importdata[5],
					  'Aca_contact_phone' => $importdata[6],
					  'Aca_contact_email' => $importdata[7],
					  'Aca_details'		  => $importdata[8],
					  'Aca_no_of_courts'  => $importdata[9],
					  'Aca_sport'		  => $importdata[10],
					  'Aca_logo'		  => $importdata[11],
					  'Aca_User_id'		  => $importdata[12],
					  'Aca_addr1'		  => $importdata[13],
					  'Aca_addr2'		  => $importdata[14],
					  'Aca_zip'			  => $importdata[15]
					);

				 // $res = $this->model_csv_import->add_clubDetails($data);
				  //exit;
					  if($res)
					  $count++;
				}
		   }
			echo "<h3>Import completed.</h3><br />Total Imported Records = ".$count; 
			fclose($file);
			//exit;
        }
		else{
			echo "Source file is Not found! - <b>{$fname}</b>";
		}
 }

public function csv_users(){
//error_reporting(-1);
	/*if($short_code == ''){
		echo "Please mention the club short code after the csv_users/";
		exit;
	}*/

	$today	  = date('mdY');
	$now	  = date("Y-m-d H:i:s");
	$fname	  = "ans_users_0924.csv";
	$filename = "C:\inetpub\wwwroot\a2msportssite\csv_source\\".$fname;
	if(file_exists($filename)){
	  $count	 = 0;
	  $dot_count = 0;
	  $file		 = fopen($filename, "r");

	   while(($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
		   $res = '';
			$fname = trim($importdata[0]);
			$lname = trim($importdata[1]);
			$pwd = 'Am9Q63t$';
			$email = trim($importdata[2]);

			/*$dob = NULL;
			if($importdata[5] != NULL){
			$dob = date('Y-m-d', strtotime(trim($importdata[5])));
			}
			$gender = trim($importdata[6]);

			$address1 = trim($importdata[7]);
			$address2 = trim($importdata[8]);*/
			
			//$country = trim($importdata[3]);
			//$state = trim($importdata[10]);
			//$city = trim($importdata[11]);
			//$zipcode = trim($importdata[12]);

			//$phone = trim($importdata[13]);
			//$mobile = trim($importdata[14]);

			//$lat   = trim($importdata[37]);
			//$long = trim($importdata[38]);

			//$age_grp   = trim($importdata[39]);
			//$is_prf_upd = trim($importdata[40]);
			//$notif_set  = trim($importdata[41]);
			$notif_set  = '["1","2"]';

			$is_club_mem  = 1;



			if($email != "" and $email != 'Email' and $email != 'E-mail') {

//echo $email." ".$is_email_exist."<br>";

			$code	   = md5($lname . $email);
			$act_code = substr($code, 0, 16);
		
				$is_email_exist = $this->model_csv_import->check_user($email);
echo $email." ".$is_email_exist."<br>";

				//if(count($is_email_exist) == 0 and $is_email_exist){
				if(!$is_email_exist){
//echo $dob;
			/*echo "<br>".$dob;
			echo "<br>".$mem_start;
			echo "<br>".$mem_end;
			exit;*/
				$data = array(
						'Firstname' => $fname,
						'Lastname' => $lname,
						'Password' => md5($pwd),
						'EmailID' => $email,
						//'DOB' => $dob,
						//'Gender' => $gender,
						//'UserAddressline1' => $address1,
						//'UserAddressline2' => $address2,
						//'Country' => $country,
						//'State' => $state,
						//'City' => $city,
						//'Zipcode' => $zipcode,
						//'HomePhone' => $phone,
						//'Mobilephone' => $mobile,
						'Issociallogin' => 0,
						'RegistrationDtTm' => $now,
						'ActivationCode' => $act_code,
						'IsUserActivation' => 1,
						'ActivatedDtTm' => $now,
						//'Latitude' => $lat,
						//'Longitude' => $long,
						//'UserAgegroup' => $ag_group,
						//'UserAgegroup' =>$age_grp,
						//'IsProfileUpdated' =>$is_prf_upd,
						'NotifySettings' =>$notif_set,
						//'Username' => $user_name,
						'Req_business_page' => 0,
						'Is_org_admin' => 0,
						'Is_ClubMember' => $is_club_mem
						//'Is_coach' => $is_coach
						);

//echo "<pre>";
//print_r($data);

						$res = $this->model_csv_import->insert_user($data);
						echo "<br>User = ".$fname." ".$lname." ".$email."(".$res.")";
					}
				}
				/*else if($alt_email != '' and $alt_email != 'Alternate Email Address'){

						$is_email_exist = $this->model_csv_import->check_user($alt_email);		
						$parent_id = $is_email_exist['Users_ID'];

						if($parent_id){
						$data = array(
								'Firstname' => $fname,
								'Lastname' => $lname,
								'Password' => $pwd,
								'AlternateEmailID' => $alt_email,
								'DOB' => $dob,
								'Gender' => $gender,
								'UserAddressline1' => $address1,
								'UserAddressline2' => $address2,
								'Country' => 'United States of America',
								'State' => $state,
								'City' => $city,
								'Zipcode' => $zipcode,
								'HomePhone' => $mobile,
								'Mobilephone' => $phone,
								'Issociallogin' => 0,
								'RegistrationDtTm' => $now,
								//'ActivationCode' => $act_code,
								'IsUserActivation' => 1,
								'ActivatedDtTm' => $now,
								'Latitude' => $latt,
								'Longitude' => $long,
								//'UserAgegroup' => $ag_group,
								'NotifySettings' => '["1","2"]',
								'Username' => $user_name,
								'Req_business_page' => 0,
								'Is_org_admin' => 0,
								'Is_ClubMember' => 1,
								'Is_coach' => 0
								);

						$res = $this->model_csv_import->insert_user($data);
						$child_user = $res;
						
						$data = array(	
								'Users_ID' => $child_user,
								'Ref_ID'   => $parent_id
								);

						$res2 = $this->model_csv_import->insert_child_users($data);


						}
						echo "<br>Child = ".$fname.' '.$lname.' '.$email."(".$res.")".' '.$alt_email."(".$res2.")<br>";

					}		*/


			
			if($res){
				$data1 = array(	
					'Club_id'		=> 1187,
					'Users_id'		=> $res,
					//'Membership_ID' => $parent_id
					'Member_Status' => 1,
					'Related_Sport' => 6
					//'StartDate' => $mem_start,
					//'EndDate'   => $mem_end
					);
//print_r($data1);

				$res3 = $this->model_csv_import->insert_club_member($data1);

				$data2 = array(	
					'Sport_id'  => 6,
					'Level'		=> 17,
					'users_id'  => $res
					);
//print_r($data2);

				$res4 = $this->model_csv_import->insert_sports_intrests($data2);

				$data3 = array(	
					'Users_ID'			=> $res,
					'SportsType_ID'	=> 6,
					'A2MScore'			=> 100,
					'A2MScore_Doubles'	=> 100,
					'A2MScore_Mixed'		=> 100
					);
//print_r($data3);

				$res5 = $this->model_csv_import->insert_a2mscore($data3);
			}

//echo "<br> --------------------------------------------------";

			  //exit;
			  
				  if($res)
				  $count++;
			}
	 //  }
		echo "<h3>Import completed.</h3><br />Total Imported Records = ".$count; 
		fclose($file);
		//exit;
	}
	else{
		echo "Source file is Not found! - <b>{$fname}</b>";
	}
}



public function csv_users_registerLeague(){
	//error_reporting(-1);
	/*if($short_code == ''){
		echo "Please mention the club short code after the csv_users/";
		exit;
	}*/


	$today	  = date('mdY');
	$now	  = date("Y-m-d H:i:s");
	//$fname	  = "sreenidhi_new_users04042021.csv";
	$filename = "C:\inetpub\wwwroot\a2msportssite\csv_source\\".$fname;
	if(file_exists($filename)){
	  $count		 = 0;
	  $dot_count  = 0;
	  $file			 = fopen($filename, "r");
$sno = 1;
	   while(($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
		    $res = '';
			$fname = trim($importdata[0]);
			$lname = trim($importdata[1]);
			$pwd	= trim($importdata[9]);
			$email  = trim($importdata[2]);

			$dob = NULL;
			if($importdata[7] != NULL){
			$dob = date('Y-m-d', strtotime(trim($importdata[7])));
			}

			$gender = trim($importdata[3]);
			$address1 = NULL;
			$address2 = NULL;
			
			$country = "India";
			$state  =NULL;
			$city		= NULL;
			$zipcode = NULL;

			$mobile = trim($importdata[8]);
			$notif_set  = '["1","2"]';

			$is_club_mem  = 1;
			$is_coach		= 0;

			$mem_start	  = NULL;
			$mem_end	  = NULL;
			//if($importdata[58] != NULL and $importdata[58] != ""){
			//$mem_end		  = date('Y-m-d', strtotime(trim($importdata[58])));
			//}
			$is_email_exist = 0;
			if($email != "" and $email != 'Email' and $email != 'E-mail') {
				$code	   = md5($fname . $email);
				$act_code = substr($code, 0, 16);
				$is_email_exist = $this->model_csv_import->check_user($email);
			}
				//$is_name_exist = $this->model_csv_import->check_name($fname);
				echo $sno."-".$email." ".$is_email_exist."<br>";

				if($is_email_exist){
					$email		  = NULL;
					$pwd		  = NULL;
					$act_code = NULL;
				}

				$data = array(
						'Firstname' => $fname,
						//'Lastname' => $lname,
						'Password' => $pwd,
						'EmailID' => $email,
						'DOB' => $dob,
						'Gender' => $gender,
						'UserAddressline1' => $address1,
						'UserAddressline2' => $address2,
						'Country' => $country,
						'State' => $state,
						'City' => $city,
						'Zipcode' => $zipcode,
						//'HomePhone' => $phone,
						'Mobilephone' => $mobile,
						'Issociallogin' => 0,
						'RegistrationDtTm' => $now,
						'ActivationCode' => $act_code,
						'IsUserActivation' => 1,
						'ActivatedDtTm' => $now,
						//'Latitude' => $lat,
						//'Longitude' => $long,
						//'UserAgegroup' => $ag_group,
						'UserAgegroup' =>$age_grp,
						'IsProfileUpdated' =>$is_prf_upd,
						'NotifySettings' =>$notif_set,
						//'Username' => $user_name,
						'Req_business_page' => 0,
						'Is_org_admin' => 0,
						'Is_ClubMember' => $is_club_mem,
						'Is_coach' => $is_coach
						);

						//$res = $this->model_csv_import->insert_user($data);
						echo "<br>User = ".$fname." ".$lname." ".$email."(".$res.")";
					//}
				//}


			
			if($res){

			$reg_data = array(
								'Tournament_ID' => 3432,
								'Users_ID' => $res,
								'Reg_date' => $now,
								'Match_Type' => trim($importdata[10]),
								'Reg_Age_Group' => '[["U12"]]',
								'Reg_Sport_Level' => '[[["4"]]]',
								'Reg_Events' =>  trim($importdata[4])
								);
				$reg_query = $this->model_csv_import->insert_reg_league($reg_data);

				$data1 = array(	
					'Club_id'		=> 1172,
					'Users_id'		=> $res,
					'Membership_ID' => trim($importdata[5]),
					'Member_Status' => 1,
					'Related_Sport' => 1
					//'StartDate' => $mem_start,
					//'EndDate'   => $mem_end
					);

				$res3 = $this->model_csv_import->insert_club_member($data1);
				$data2 = array(	
					'Sport_id'  => 1,
					'Level'		=> 3,
					'users_id'  => $res
					);

				$res4 = $this->model_csv_import->insert_sports_intrests($data2);

				$data3 = array(	
					'Users_ID'			=> $res,
					'SportsType_ID'		=> 1,
					'A2MScore'			=> 100,
					'A2MScore_Doubles'  => 100,
					'A2MScore_Mixed'	=> 100
					);
				$res5 = $this->model_csv_import->insert_a2mscore($data3);
			}
			  
				  if($res)
				  $count++;

		$sno++;		 
			}
		echo "<h3>Import completed.</h3><br />Total Imported Records = ".$count; 
		fclose($file);
	}
	else{
		echo "Source file is Not found! - <b>{$fname}</b>";
	}
}


public function gpa_ratings_import(){
	$today	  = date('mdY');
	$fname	  = "gpa_ratings_{$today}.csv";
    $filename = "C:\inetpub\wwwroot\a2msportssite\csv_source\\".$fname;
      if(file_exists($filename)){
		  $count	 = 0;
		  $dot_count = 0;
          $file		 = fopen($filename, "r");

           while(($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
				$last_name = trim($importdata[0]);
				if($last_name != "" and $last_name != "Lastname") {
					$data = '';
					$data['Lastname'] = trim($importdata[0]);

					if(trim($importdata[1]) != '')
					$data['Firstname'] = trim($importdata[1]);

					if(trim($importdata[2]) != '')
					$data['Gender'] = trim($importdata[2]);

					if(trim($importdata[3]) != '')
					$data['Age'] = trim($importdata[3]);

					if(trim($importdata[4]) != '')
					$data['Email'] = trim($importdata[4]);

					if(trim($importdata[5]) != '')
					$data['Phone'] = trim($importdata[5]);

					if(trim($importdata[6]) != '')
					$data['Member_ID'] = trim($importdata[6]);

					if(trim($importdata[7]) != '')
					$data['Singles_Rating'] = floatval($importdata[7]);

					if(trim($importdata[8]) != '')
					$data['Doubles_Rating'] = floatval($importdata[8]);

					if(trim($importdata[9]) != '')
					$data['MixedDoubles_Rating'] = floatval($importdata[9]);

					if(trim($importdata[10]) != '')
					$data['SkinnySingles_Rating'] = floatval($importdata[10]);

					if(trim($importdata[11]) != '')
					$data['Expires_On'] = date('Y-m-d', strtotime(trim($importdata[11])));

					//echo "<pre>"; print_r($data); exit;
				 // $res = $this->model_csv_import->add_gpaRatings($data);
				  //exit;
					  if($res)
					  $count++;
				}
		   }
			echo "<h3>Import completed.</h3><br />Total Imported Records = ".$count; 
			fclose($file);
			//exit;
        }
		else{
			echo "Source file is Not found! - <b>{$fname}</b>";
		}
 }


public function csv_gpa_users_register(){

	$today	  = date('mdY');
	$now		  = date("Y-m-d H:i:s");
	$file_name	  = "gpa_ratings_04302021.csv";
	$filename = "C:\inetpub\wwwroot\a2msportssite\csv_source\\".$file_name;
	if(file_exists($filename)){
	  $count		 = 0;
	  $dot_count  = 0;
	  $file			 = fopen($filename, "r");
$sno = 1;
	   while(($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
		    $res = '';
			$fname = trim($importdata[1]);
			$lname = trim($importdata[0]);
			$pwd	= 'f1f33fe77568d04084f5631826aea577';
			$email  = trim($importdata[4]);

			$dob = NULL;
			if(trim($importdata[2]) == 'M')
			$gender = 1;
			else if(trim($importdata[2]) == 'F')
			$gender = 0;
			$age_grp = NULL;
			
			if($importdata[3] > 19){
				$age_grp = 'Adults';
			}
			else if($importdata[3] < 20){
				$age_grp = 'U'.$importdata[3];
			}

			$address1 = NULL;
			$address2 = NULL;
			
			$country = "United States of America";
			$state  =NULL;
			$city		= NULL;
			$zipcode = NULL;

			$mobile = trim($importdata[5]);
			$notif_set  = '["1","2"]';

			$is_club_mem  = 1;
			$is_coach		= 0;

			$mem_start	  = NULL;
			$mem_end	  = date('Y-m-d', strtotime(trim($importdata[11])));

			$is_email_exist = 0;
			if($email != "" and $email != 'Email' and $email != 'E-mail') {
				$code	   = md5($fname . $email);
				$act_code = substr($code, 0, 16);
				$is_email_exist = $this->model_csv_import->check_user($email);
			}
				//$is_name_exist = $this->model_csv_import->check_name($fname);
				echo $sno."-".$email." ".$is_email_exist."<br>";

				if($is_email_exist == 0){

				$data = array(
						'Firstname' => $fname,
						'Lastname' => $lname,
						'Password' => $pwd,
						'EmailID' => $email,
						'DOB' => $dob,
						'Gender' => $gender,
						'UserAddressline1' => $address1,
						'UserAddressline2' => $address2,
						'Country' => $country,
						'State' => $state,
						'City' => $city,
						'Zipcode' => $zipcode,
						//'HomePhone' => $phone,
						'Mobilephone' => $mobile,
						'Issociallogin' => 0,
						'RegistrationDtTm' => $now,
						'ActivationCode' => $act_code,
						'IsUserActivation' => 1,
						'ActivatedDtTm' => $now,
						//'Latitude' => $lat,
						//'Longitude' => $long,
						//'UserAgegroup' => $ag_group,
						'UserAgegroup' =>$age_grp,
						'IsProfileUpdated' =>$is_prf_upd,
						'NotifySettings' =>$notif_set,
						//'Username' => $user_name,
						'Req_business_page' => 0,
						'Is_org_admin' => 0,
						'Is_ClubMember' => $is_club_mem,
						'Is_coach' => $is_coach
						);
//echo "<pre>"; print_r($data); exit;
						//$res = $this->model_csv_import->insert_user($data);
						echo "<br>User = ".$fname." ".$lname." ".$email."(".$res.")";
					//}
				//}


			
			if($res){

				$data1 = array(	
					'Club_id'		=> 1176,
					'Users_id'		=> $res,
					'Membership_ID' => trim($importdata[6]),
					'Member_Status' => 1,
					'Related_Sport' => 7,
					//'StartDate' => $mem_start,
					'EndDate'   => $mem_end
					);

				$res3 = $this->model_csv_import->insert_club_member($data1);

				$data2 = array(	
					'Sport_id'  => 7,
					//'Level'		=> 3,
					'users_id'  => $res
					);

				$res4 = $this->model_csv_import->insert_sports_intrests($data2);

				$data3 = array(	
					'Users_ID'			=> $res,
					'SportsType_ID'		=> 1,
					'A2MScore'			=> floatval($importdata[7]),
					'A2MScore_Doubles'  => floatval($importdata[8]),
					'A2MScore_Mixed'	=> floatval($importdata[9])
					);
				$res5 = $this->model_csv_import->insert_a2mscore($data3);
			}
			  
				  if($res)
				  $count++;
				}
		$sno++;		 
			}
		echo "<h3>Import completed.</h3><br />Total Imported Records = ".$count; 
		fclose($file);
	}
	else{
		echo "Source file is Not found! - <b>{$file_name}</b>";
	}
}

public function gpa_existing_users_map(){

$exis_users = array('Richclean@bellsouth.net','
sandybishop@bellsouth.net','
kblagin@gmail.com','
bernadetteboas@balloffireinc.com','
pickleballcoachdavid@gmail.com','
Skcusa64@yahoo.com','
moladee42@gmail.com','
Hfletcher0404@gmail.com','
cindy.griffin@me.com','
Kellie14@bellsouth.net','
shazlett@bellsouth.net','
Holbertbei@gmail.com','
lillyhoop@hotmail.com','
ltumberlin@yahoo.com','
robbiejoines@yahoo.com','
kourajian@yahoo.com','
jkluu2@gmail.com','
lmkmahurin@hotmail.com','
Keven30319@gmail.com','
gerryhmeyer@hotmail.com','
rmircio@gmail.com','
feliss3366@yahoo.com','
bnoble23@gmail.com','
Susannorsworthy@bellsouth.net','
nikonsean@me.com','
mycabin1@gmail.com','
rpototsky@yahoo.com','
artie380@gmail.com','
mark@intensepickleball.com','
anhspinks@gmail.com','
tennistree@bellsouth.net','
shea12underwood@gmail.com','
Jbv4136@gmail.com','
vskris55@gmail.com','
Witcher4@comcast.net','
gintonic241@gmail.com','
hollandclay54@att.net');
$count = 0;
	foreach($exis_users as $uemail){
		//$is_email_exist = $this->model_csv_import->check_user(trim($uemail));
		$get_user = $this->model_csv_import->get_user(trim($uemail));
			
			$user_id = $get_user['Users_ID'];

		$check_gpa_membership = $this->model_csv_import->is_club_member($user_id, 1176);

		if($user_id and $check_gpa_membership == 0){

				$data1 = array(	
					'Club_id'		=> 1176,
					'Users_id'		=> $user_id,
					//'Membership_ID' => trim($importdata[6]),
					'Member_Status' => 1,
					'Related_Sport' => 7,
					//'StartDate' => $mem_start,
					'EndDate'   => "2021-12-31"
					);

				//$res3 = $this->model_csv_import->insert_club_member($data1);

				//if($res3) 
					$count++;
		}

		

	}
echo $count."<br>";

}


public function map_club_members(){

$exis_users = array(12188,
12304,
12306,
12316,
12337,
12344,
12354,
12355,
12356,
12422,
12426,
12443,
12450,
12456,
12476);
$count = 0;
	foreach($exis_users as $uemail){
		//$is_email_exist = $this->model_csv_import->check_user(trim($uemail));
		//$get_user = $this->model_csv_import->get_user(trim($uemail));
			
			//$user_id = $get_user['Users_ID'];
			$user_id = $uemail;

		$check_gpa_membership = $this->model_csv_import->is_club_member($user_id, 1182);

		if($user_id and $check_gpa_membership == 0){

				$data1 = array(	
					'Club_id'		=> 1182,
					'Users_id'		=> $user_id,
					//'Membership_ID' => trim($importdata[6]),
					'Member_Status' => 1,
					'Related_Sport' => 6,
					//'StartDate' => $mem_start,
					//'EndDate'   => "2021-12-31"
					);

				//$res3 = $this->model_csv_import->insert_club_member($data1);

				if($res3) 
					$count++;
		}

		

	}
echo $count."<br>";

}


}