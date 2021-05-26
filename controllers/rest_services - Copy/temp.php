<?php defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
//class Scores extends REST_Controller {
class Temp extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_league','mleague');
		$this->load->model('score/model_user','muser');
    }

	public function is_valid_league($tourn_id){
		$tourn_det = $this->mleague->getonerow($tourn_id);
		if(!$tourn_det){
			$this->response(array('Error: '."Invalid League!"));
			exit;
		}
		else{
			return $tourn_det;
		}
	}

	public function withdraw_post(){

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

			/*print_r($post_data);
			$this->response($post_data); 
			exit;*/

		if(!$post_data){
			$this->response(array('Error: '."Missing Input data")); 
			exit;
		}

		$tourn_id  = $post_data['tourn_id'];
		$user_id   = $post_data['user_id'];
		$wd_events = $post_data['withdraw_events'];

		$tourn_det = $this->is_valid_league($tourn_id);
		
		if($tourn_det){
			
			if($wd_events){
				
				$get_user_reg = $this->mleague->get_user_reg($tourn_id, $user_id);
				$reg_events   = json_decode($get_user_reg['Reg_Events'], true);

				if($reg_events){
					foreach($wd_events as $ev){				
						$pos = array_search($ev, $reg_events);
						unset($reg_events[$pos]);
					}
				}

				if(!empty($reg_events)){
				$data2['upd_events']	= json_encode($reg_events);
				$data2['Tournament_ID'] = $tourn_id;
				$data2['Users_ID']		= $user_id;

				$upd_events = $this->mleague->update_reg_tourn($data2);
				}
				else{
				$del_events = $this->mleague->del_tourn_reguser($user_id, $tourn_id);
				}

				if($upd_events)
					$this->response(array('Success: '."User is successfully withdrawn from the events")); 
				else if($upd_events)
					$this->response(array('Success: '."User is successfully withdrawn from the league")); 

				//$this->response($reg_events);
			}
			else{
				$this->response(array('Error: '."Withdraw Events are missing")); 
				exit;
			}
			//$this->response(array($data)); 

		}
	}

}