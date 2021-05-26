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
class General extends REST_Controller {

    public function __construct() {
        // Construct the parent class
        parent::__construct();

		$this->load->model('score/model_general','mgeneral');
    }

	public function sports_get() {

		$get_sports = $this->mgeneral->get_sports();
		
		$this->response($get_sports);
	}

	public function sport_levels_get() {

		$get_sport_levels = $this->mgeneral->get_sport_levels();
		
		foreach($get_sport_levels as $sport_det){
			$sport_levels[$sport_det->sport_id][$sport_det->sport_level_id] = $sport_det->sport_level;
		}
		$this->response($sport_levels);
	}

}