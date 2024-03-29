<?php defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
error_reporting(0);
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

class Errorlogs extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_log','mlog');
		//$this->load->model('score/model_user','muser');
		//$this->load->model('score/model_general','general');
    }

	public function list_get(){
		$user_id   = $this->input->get('user_id');

		$get_logs = $this->mlog->get_logs($user_id);
		$data['errorLogs'] = $get_logs;

		$this->response($data);
	}


	public function capture_post(){

		$post_data = json_decode(trim(file_get_contents('php://input')), true);

		//if($post_data['userId']){ echo "Invalid Request!"; exit; }

		$data['User_ID']			= $post_data['userId'];
		$data['Device_Info']	= $post_data['deviceInfo'];
		$data['Error_Log']		= $post_data['errorLog'];
		$data['APP_Time']	= $post_data['time'];
		$data['Server_Time']  = date('Y-m-d H:i:s');

		$create_log = $this->mlog->ins_log($data);	

		if($create_log)
			$this->response("Success", 200);
		else
			$this->response("Fail", 400);

	}

}