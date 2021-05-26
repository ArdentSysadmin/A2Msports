<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usatt_ratings extends CI_Controller {

public function __construct(){
    parent::__construct();
	$this->load->helper(array('form', 'url'));
	$this->load->library('session');

    $this->load->model('model_csv_import');
}

public function index(){   
    $this->load->view('view_CSVUpload');
}

public function csv_import(){
	$today	  = date('mdY');
	$fname	  = "usatt_{$today}.csv";
    $filename = "C:\inetpub\wwwroot\a2msportssite\csv_source\\".$fname;
      if(file_exists($filename)){
		  echo "<br><div id='plswait'><h3>Please wait, don't close/refresh the window.........</h3></div>";
		  $count	 = 0;
		  $dot_count = 0;
          $file		 = fopen($filename, "r");
		  $truncate  = $this->model_csv_import->truncate_usatt_ratings();

           while(($importdata = fgetcsv($file, 10000, ",")) !== FALSE){
				$mem_id = (int) $importdata[0];
				if($mem_id > 0){					
					$data = array(
					  'Member_ID'		=> $importdata[0],
					  '[Last Name]'		=> $importdata[1],
					  '[First Name]'	=> $importdata[2],
					  'Rating'			=> $importdata[3],
					  'State'			=> $importdata[4],
					  'Zip'				=> $importdata[5],
					  'Gender'			=> $importdata[6],
					  '[Date of Birth]' => $importdata[7],
					  '[Expiration Date]'  => $importdata[8],
					  '[Last Played Date]' => $importdata[9]
					);

				  $res = $this->model_csv_import->add_memberDetails($data);
				  $count++;
				}
		   }
		   ?>
		    <script>document.getElementById("plswait").innerHTML = "";</script>
			<?php
			echo "<h3>Import completed.</h3><br />Total Imported Records = ".$count; 
			fclose($file);
			exit;
        }
		else{
			echo "Source file is Not found! - <b>{$fname}</b>";
		}
 }

	public function rating_eligibility_check(){
		$today = date('Y-m-d');
		$get_rating_eligible_leagues = $this->model_general->get_today_rating_elig_leagues($today);

		if(count($get_rating_eligible_leagues) > 0){
			foreach($get_rating_eligible_leagues as $tourny){
				$get_registers = $this->model_general->get_league_registrations($tourny['tournament_ID']);

				$tourny_events = json_decode($tourny['Multi_Events'], true);
				/*echo "<pre>";
				print_r($get_registers);*/

				foreach($get_registers as $player){
					$user_id = $player['Users_ID'];
					//$get_player = $this->model_general->get_user($user_id);
					foreach($tourny_events as $event){
						$sp = explode('-', $event);
						$level = end($sp);
						$level_arr   = $this->model_general->get_level_name('2', $level);
						$level_title = substr($level_arr['SportsLevel'], 1);
								
						if(is_numeric($level_title)){
							$elig_rating = $level_title;
							$user_rating = $this->model_general->get_player_usatt_rating($user_id);
							 //echo $user_id." = ".$elig_rating." - ".$user_rating['Rating']."<br>";
							 if($user_rating['Rating'] > 0){
								 $upd = $this->model_general->update_eligible_rating($tourny['tournament_ID'], $user_id, $user_rating['Rating']);
								 echo $user_id." ".$upd."<br>";
							 }
						}
					}
				}
			}
		}
		else{
			echo "Nothing found to update!";
		}
	}

}