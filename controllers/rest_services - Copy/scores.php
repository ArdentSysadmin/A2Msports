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
class Scores extends REST_Controller {

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

		//$this->load->helper(array('form', 'url'));
		$this->load->model('score/model_score','mscore');

    }

	public function add_post(){
		$match_id   = $this->input->post('match_id');
		$win_type   = $this->input->post('win_type');
		$match_date = $this->input->post('match_date');

		$match_info = $this->mscore->get_match_info($match_id);

		if($win_type == 'ADDSCORE' and $match_info){
		$p1_score = $this->input->post('p1_score');
		$p2_score = $this->input->post('p2_score');
		$add_score  = $this->mscore->add_score($match_id, $p1_score, $p2_score, $match_date, $match_info);
		}
		
		if($win_type == 'WFF' and $match_info){
		$winner = $this->input->post('winner');
		$add_score  = $this->mscore->add_wff($match_id, $winner, $match_date, $match_info);
		}
		
		if($add_score){
			$this->response('Success', 200);
		}
		else{
			$this->response('Invalid Details', 404);
		}
	}

}