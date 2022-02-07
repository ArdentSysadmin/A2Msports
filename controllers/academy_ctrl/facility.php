<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Facility extends CI_Controller {

public $short_code;
public $academy_admin;
public $logged_user;
public $is_club_admin;

public function __construct()
{
parent:: __construct();
$this->load->helper('form', 'url');
$this->load->library('form_validation');
$this->load->library('session');		
$this->load->model('academy_mdl/model_news');
$this->load->model('academy_mdl/model_general', 'general');
$this->load->model('academy_mdl/model_academy', 'model_academy');

$this->short_code		= $this->uri->segment(1);
$this->academy_admin	= $this->general->get_org_admin($this->short_code);
$this->academy_id		= $this->general->get_orgid($this->short_code);

$this->logged_user		= $this->session->userdata('users_id');

$this->is_club_admin = 0;
if($this->logged_user == $this->academy_admin){
$this->is_club_admin = 1;
}
//error_reporting(-1);
if(!$this->logged_user){
$this->load->library('facebook' ,  array("appId" => FB_APPID, "secret" => FB_KEY, "redirect_url" => FB_REDIRECT));
}
}

public function get_fb_login(){
$login  = $this->facebook->getLoginUrl();
return $login;
}

public function get_google_login(){

// Store values in variables from project created in Google Developer Console
$client_id			= '170374605326-p02hhgiia6fqncck0982i401madv6n72.apps.googleusercontent.com';
$client_secret		= 'XyOwkQkScXXca0wG4paTUx6A';
$redirect_uri		= 'https://a2msports.com/login/auth_check';
$simple_api_key = 'AIzaSyC0JNMWyyW6t1fSNyrprBJC2bWKG4btytc';

include_once APPPATH."libraries/google_login_api_HRWNdR/src/Google_Client.php";
include_once APPPATH."libraries/google_login_api_HRWNdR/src/contrib/Google_Oauth2Service.php";

// Google Project API Credentials
$clientId	   = $client_id;
$clientSecret = $client_secret;
$redirectUrl   = $redirect_uri;

// Google Client Configuration
$gClient = new Google_Client();
$gClient->setApplicationName('A2MSports');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);

//$gclient->setDefaultOption('verify', false); // Can be removed
$google_oauthV2 = new Google_Oauth2Service($gClient);
$token				 = $this->session->userdata('token');

// if (!empty($token)) {
if ($token != "") {
$gClient->setAccessToken($token);
}

$data['authUrl'] = $gClient->createAuthUrl();

return $data['authUrl'];
}

		public function get_club_menu($org_id){
			$get_menu = $this->general->get_club_menu($org_id);
			$club_menu = array();

			if($get_menu)
				$club_menu = json_decode($get_menu['Active_Menu_Ids'], TRUE);
			return $club_menu;
		}

		public function get_onerow($table, $column, $val){
			return $this->general->get_onerow($table, $column, $val);
		}

public function index($org_id)
{
	//echo "<pre>"; print_r($_SERVER); exit;
//echo $org_id;
$org_details				= $this->model_academy->get_academy_details($org_id); 
$facility_details		= $this->model_academy->get_club_facility($org_id); 
$data['org_id']			= $org_id;
$data['org_details']	= $org_details;
$data['facility_details']	= $facility_details;
//echo "<pre>"; print_r($data); 
//$data['results'] = $this->model_news->get_news();

$this->load->view('academy_views/includes/academy_header', $data);
$this->load->view('academy_views/view_facility');
//$this->load->view('includes/view_right_column',$data);
$this->load->view('academy_views/includes/academy_footer', $data);	 	
}

public function update_facility($org_id){
	//echo 'test'.$this->session->userdata('users_id');exit;
	//error_reporting(-1);
if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }

//echo $org_id; exit;
//echo "<pre>"; print_r($_POST);print_r($_FILES);exit;
$data['fac_text'] = $this->input->post('facility_desc');

$data['fac_img'] = "";

if($_FILES['facility_image']['name']){

$filename = 'facility_image';
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$club_fac_dir = $doc_root.'\assets\club_facility\\'.$org_id;

if (!file_exists($club_fac_dir)){
mkdir($club_fac_dir, 0777, true);
}
/* ***************** Code to upload Tournment Image Form Starts Here. *********************** */
$config = array(
'upload_path'	=> $club_fac_dir,
'allowed_types' => "gif|jpg|png|jpeg|mp4",
'overwrite'		=> FALSE,
'max_size'		=> "100000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
'max_height'	=> "5000",
'max_width'	=> "8000"
);

$this->load->library('upload');
$this->upload->initialize($config);

if($this->upload->do_upload($filename)){
$upd_info		    = $this->upload->data();
$data['fac_img'] = $upd_info['file_name'];
}
}

$data['aca_id']	= $org_id;
//echo "<pre>"; print_r($data); exit;
$org_details	= $this->model_academy->update_facility($data); 

redirect($this->input->post('redirect_page'));
//header("Location: {$_SERVER['HTTP_X_FORWARDED_HOST']}/facility");
//echo $_SERVER['HTTP_X_FORWARDED_HOST'].'/facility';
//exit;
//redirect($_SERVER['HTTP_X_FORWARDED_HOST'].'/facility');
}

public function update_lt_team($org_id){

if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }

if(!$org_id){ echo "Something went wrong!"; exit; }

/*echo "<pre>";

print_r($_POST);
print_r($_FILES);*/

$lt_name = $this->input->post('lt_name');
$lt_role   = $this->input->post('lt_role');
$lt_desc  = $this->input->post('lt_desc');
$lt_prev_imgs  = $this->input->post('lt_prev_imgs');
$files		= $_FILES;

$doc_root = $_SERVER['DOCUMENT_ROOT'];
$club_dir = $doc_root.'\assets\club_facility\\'.$org_id;

if (!file_exists($club_dir)){
mkdir($club_dir, 0777, true);
}

$club_lt_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\lt_team';
//echo $club_lt_dir; exit;
if (!file_exists($club_lt_dir)){
mkdir($club_lt_dir, 0777, true);
}

foreach($lt_name as $i => $mem){
$mem_name = $lt_name[$i];
$mem_role    = $lt_role[$i];
$mem_sum   = $lt_desc[$i];
$img_name   = $lt_prev_imgs[$i];
//echo $re_name;exit;
if($files['lt_imgs']['name'][$i]) {
$_FILES['lt_imgs']['name']		= $files['lt_imgs']['name'][$i];
$_FILES['lt_imgs']['type']			= $files['lt_imgs']['type'][$i];
$_FILES['lt_imgs']['tmp_name']	= $files['lt_imgs']['tmp_name'][$i];
$_FILES['lt_imgs']['error']		= $files['lt_imgs']['error'][$i];
$_FILES['lt_imgs']['size']			= $files['lt_imgs']['size'][$i];

$fileName = 'lt_imgs';

$config = array(
'upload_path'	=> $club_lt_dir,
'allowed_types' => "gif|jpg|png|jpeg",
'overwrite'		=> TRUE,
'max_size'		=> "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
'max_height'	=> "8000",
'max_width'		=> "10000");

$this->load->library('upload',$config);  
$this->upload->initialize($config);

if($this->upload->do_upload($fileName)){
$upload_data = $this->upload->data();
$img_name = $upload_data['file_name'];
}
}

$revised_teams[] = array(
'img'	 => $img_name,
'name' => $mem_name,
'role'  => $mem_role,
'desc' => $mem_sum
);


}

/*echo "<pre>";
print_r($revised_teams);*/
$r_teams = json_encode($revised_teams);

$data['Aca_ID']					= $org_id;
$data['Facility_Leadership']  = $r_teams;
$upd_details						= $this->model_academy->update_facility_lt_teams($data); 

redirect($this->input->post('redirect_page'));

}

public function update_ps_team($org_id){

if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
if(!$org_id){
echo "Something went wrong!";
exit;
}
/*
echo "<pre>";

print_r($_POST);
print_r($_FILES);
exit;*/

$ps_name = $this->input->post('ps_name');
$ps_role   = $this->input->post('ps_role');
//$ps_desc  = $this->input->post('ps_desc');
$ps_prev_imgs  = $this->input->post('ps_prev_imgs');
$files		= $_FILES;

$doc_root = $_SERVER['DOCUMENT_ROOT'];			
$club_dir = $doc_root.'\assets\club_facility\\'.$org_id;

if (!file_exists($club_dir)){
mkdir($club_dir, 0777, true);
}

$club_ps_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\ps_team';
//echo $club_ps_dir; exit;
if (!file_exists($club_ps_dir)){
mkdir($club_ps_dir, 0777, true);
}


$mem_name = $ps_name;
$mem_role    = $ps_role;
//$mem_sum   = $ps_desc;
$img_name   = $ps_prev_imgs;
//echo $re_name;exit;
if($files['ps_imgs']['name']) {
$_FILES['ps_imgs']['name']		= $files['ps_imgs']['name'];
$_FILES['ps_imgs']['type']		= $files['ps_imgs']['type'];
$_FILES['ps_imgs']['tmp_name']	= $files['ps_imgs']['tmp_name'];
$_FILES['ps_imgs']['error']		= $files['ps_imgs']['error'];
$_FILES['ps_imgs']['size']			= $files['ps_imgs']['size'];

$fileName = 'ps_imgs';

$config = array(
'upload_path'	=> $club_ps_dir,
'allowed_types' => "gif|jpg|png|jpeg",
'overwrite'		=> TRUE,
'max_size'		=> "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
'max_height'	=> "8000",
'max_width'		=> "10000");

$this->load->library('upload',$config);  
$this->upload->initialize($config);

if($this->upload->do_upload($fileName)){
$upload_data = $this->upload->data();
$img_name = $upload_data['file_name'];
}
}

$revised_teams[] = array(
'img'	 => $img_name,
'name' => $mem_name,
'role'    => $mem_role
//'desc'   => $mem_sum
);

/*echo "<pre>";
print_r($revised_teams);*/
$pre_ps_team = $this->input->post('pre_ps_team');

if($pre_ps_team != null and $pre_ps_team != 'null'){
$prev_arr   = json_decode($pre_ps_team, true);
$upd_imgs = array_merge($prev_arr, $revised_teams);
$r_teams = json_encode($upd_imgs);
}
else{
$r_teams = json_encode($revised_teams);
}


$data['Aca_ID']							 = $org_id;
$data['Facility_Partner_Sponsors']  = $r_teams;
$upd_details								 = $this->model_academy->update_facility_ps_teams($data); 

redirect($this->input->post('redirect_page'));

}

public function add_lt_team($org_id){
$org_id = $this->academy_id;
if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
if(!$org_id){
echo "Something went wrong!";
exit;
}

/*echo "<pre>";
print_r($_POST);
print_r($_FILES);
exit;*/

$lt_name = $this->input->post('lt_name');
$lt_role    = $this->input->post('lt_role');
$lt_desc  = $this->input->post('lt_desc');
$lt_prev_imgs  = $this->input->post('lt_prev_imgs');
$files		= $_FILES;

$doc_root		= $_SERVER['DOCUMENT_ROOT'];			
$club_dir		= $doc_root.'\assets\club_facility\\'.$org_id;

if (!file_exists($club_dir)){
mkdir($club_dir, 0777, true);
}

$club_lt_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\lt_team';
//echo $club_ps_dir; exit;
if (!file_exists($club_lt_dir)){
mkdir($club_lt_dir, 0777, true);
}


$mem_name = $lt_name;
$mem_role    = $lt_role;
$mem_sum   = $lt_desc;
$img_name   = $lt_prev_imgs;
//echo $re_name;exit;
if($files['lt_imgs']['name']) {
$_FILES['lt_imgs']['name']		= $files['lt_imgs']['name'];
$_FILES['lt_imgs']['type']		= $files['lt_imgs']['type'];
$_FILES['lt_imgs']['tmp_name']	= $files['lt_imgs']['tmp_name'];
$_FILES['lt_imgs']['error']		= $files['lt_imgs']['error'];
$_FILES['lt_imgs']['size']		= $files['lt_imgs']['size'];

$fileName = 'lt_imgs';

$config = array(
'upload_path'	=> $club_lt_dir,
'allowed_types' => "gif|jpg|png|jpeg",
'overwrite'		=> TRUE,
'max_size'		=> "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
'max_height'	=> "8000",
'max_width'		=> "10000");

$this->load->library('upload',$config);  
$this->upload->initialize($config);

if($this->upload->do_upload($fileName)){
$upload_data = $this->upload->data();
$img_name = $upload_data['file_name'];
}
}

$revised_teams[] = array(
								'img'		=> $img_name,
								'name'	=> $mem_name,
								'role'		=> $mem_role,
								'desc'   => $mem_sum
								);

/*echo "<pre>";
print_r($revised_teams);*/
$pre_lt_team = $this->input->post('pre_lt_team');

if($pre_lt_team != null and $pre_lt_team != 'null'){
	$prev_arr		= json_decode($pre_lt_team, true);
	$upd_imgs	= array_merge($prev_arr, $revised_teams);
	$r_teams		= json_encode($upd_imgs);
}
else{
	$r_teams		= json_encode($revised_teams);
}


$data['Aca_ID']						 = $org_id;
$data['Facility_Leadership']  = $r_teams;
//echo "<pre>"; print_r($data); exit;
$upd_details							 = $this->model_academy->update_facility_lt_teams($data); 

redirect($this->input->post('redirect_page'));

}


public function delete_ps($org_id){
	if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
	if(!$org_id){ echo "Something went wrong!"; exit; }

$del_images  = $this->input->post('sel_ps');
$all_images   = json_decode($this->input->post('all_ps'), true);

foreach($del_images as $index){
		unset($all_images[$index]);
}
$upd_imgs = array_values($all_images);

/*echo "<pre>";
print_r($_POST);
print_r($this->input->post('sel_ps'));
print_r($this->input->post('all_ps'));
print_r($upd_imgs);
exit;*/

$data['Aca_ID']			   = $org_id;
if(!empty($upd_imgs))
	$data['Facility_Partner_Sponsors']  = json_encode($upd_imgs);
else
	$data['Facility_Partner_Sponsors']  = NULL;

	$upd_details = $this->model_academy->update_facility_ps_teams($data); 
}


public function delete_lt($short_code){

	$org_id = $this->academy_id;

	if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
	if(!$org_id){ echo "Something went wrong!"; exit; }

	$del_images  = $this->input->post('sel_ps');
	$all_images   = json_decode($this->input->post('all_ps'), true);

	foreach($del_images as $index){
			unset($all_images[$index]);
	}
	$upd_imgs = array_values($all_images);

	/*echo "<pre>";
	print_r($_POST);
	print_r($this->input->post('sel_ps'));
	print_r($this->input->post('all_ps'));
	print_r($upd_imgs);
	exit;*/

	$data['Aca_ID']			   = $org_id;
	if(!empty($upd_imgs))
		$data['Facility_Leadership']  = json_encode($upd_imgs);
	else
		$data['Facility_Leadership']  = NULL;
//echo "<pre>"; print_r($data); exit;
	$upd_details = $this->model_academy->update_facility_lt_teams($data); 
}

public function add_hv(){
	$org_id = $this->academy_id;
	if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
	if(!$org_id){ echo "Something went wrong!"; exit; }

	//echo "<pre>"; print_r($_FILES); exit;

$doc_root = $_SERVER['DOCUMENT_ROOT'];			

if($_FILES['home-page-video']['name'] != ''){
	$club_dir = $doc_root.'\assets\club_facility\\'.$org_id;		
	if (!file_exists($club_dir)){
	mkdir($club_dir, 0777, true);
	}

	$club_bnr_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\home_video';
	if (!file_exists($club_bnr_dir)){
	mkdir($club_bnr_dir, 0777, true);
	}

	   $this->load->helper('string');
       $config['upload_path'] = $club_bnr_dir; # check path is correct
       $config['max_size'] = '102400000';
       $config['allowed_types'] = 'mp4|gif'; # add video extenstion on here
       $config['overwrite'] = FALSE;
       $config['remove_spaces'] = TRUE;
       $video_name =$_FILES['home-page-video']['name'];
       $config['file_name'] = $video_name;
 
	   $this->load->library('upload', $config);
       $this->upload->initialize($config);
       if ($this->upload->do_upload('home-page-video')) {
            $file_name	= $_FILES['home-page-video']['name'];
			$data			= array('Aca_ID' => $org_id, 'Home_Video' => $file_name);
			$upd_aca		= $this->model_academy->update_home_video($data);
			redirect($this->input->post('redirect_page'));
        }
		else {
			//echo "<pre>";
			//print_r($this->upload->display_errors());
            echo 'Something went wrong! Please contact Admin.';
            exit;
		}
	
}
}

public function add_banner($org_id){
	//echo 'test'.$this->session->userdata('users_id');exit;
	//echo "testing"; exit;
if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
if(!$org_id){
echo "Something went wrong!";
exit;
}

$files			= $_FILES;
$file_count = count($_FILES['bnr_imgs']['name']);
//$pre_brn_imgs = $this->input->post('pre_brn_imgs');
/*			echo "<pre>";

print_r($_POST);
echo count($files['bnr_imgs']);
if($files['bnr_imgs']['name'][0] != '') echo "te";
print_r($_FILES);
exit;*/

//echo "Testing ".$file_count; exit;
$doc_root = $_SERVER['DOCUMENT_ROOT'];			

if($files['bnr_imgs']['name'][0] != ''){
$club_dir = $doc_root.'\assets\club_facility\\'.$org_id;		
if (!file_exists($club_dir)){
mkdir($club_dir, 0777, true);
}

$club_bnr_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\banner';
if (!file_exists($club_bnr_dir)){
mkdir($club_bnr_dir, 0777, true);
}

$this->load->library('image_lib');

for($i=0; $i<$file_count; $i++){
if($files['bnr_imgs']['name'][$i]) {
$_FILES['gl_imgs']['name']			= time().$files['bnr_imgs']['name'][$i];
$_FILES['gl_imgs']['type']			= $files['bnr_imgs']['type'][$i];
$_FILES['gl_imgs']['tmp_name']	= $files['bnr_imgs']['tmp_name'][$i];
$_FILES['gl_imgs']['error']		= $files['bnr_imgs']['error'][$i];
$_FILES['gl_imgs']['size']			= $files['bnr_imgs']['size'][$i];

$fileName = 'gl_imgs';

$config = array(
'upload_path'	  => $club_bnr_dir,
'allowed_types' => "gif|jpg|png|jpeg",
'overwrite'		=> TRUE,
'max_size'		=> "15000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
'max_height'	=> "8000",
'max_width'	=> "10000");

$this->load->library('upload', $config);  
$this->upload->initialize($config);

if($this->upload->do_upload($fileName)){
$upload_data = $this->upload->data();
$glry_arr[] = $upload_data['file_name'];

if($upload_data['image_width'] > 1024 and $upload_data['image_height'] > 465){
            $configer =  array(
								  'image_library'	 => 'gd2',
								  'source_image'    =>  $upload_data['full_path'],
								  'maintain_ratio'  =>  FALSE,
								  'width'           =>  1200,
								  'height'          =>  545
								  //'quality'		 =>  100
								);
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            //$this->image_lib->resize();
}
      
}
}
}

/*if($pre_brn_imgs != null and $pre_brn_imgs != 'null'){
$prev_arr   = json_decode($pre_brn_imgs, true);
$upd_imgs = array_merge($prev_arr, $glry_arr);
$glry_imgs = json_encode($upd_imgs);
}*/
if(!empty($this->input->post('pre_brn_imgs'))){
$prev_arr   = $this->input->post('pre_brn_imgs');
$upd_imgs = array_merge($prev_arr, $glry_arr);
$glry_imgs = json_encode($upd_imgs);
}
else{
$glry_imgs = json_encode($glry_arr);
}
//echo "<pre>"; print_r($prev_arr); print_r($glry_arr); echo $glry_imgs; exit;

$data['Aca_ID']			   = $org_id;
$data['Banner_Images']  = $glry_imgs;
$upd_details				   = $this->model_academy->update_banner_images($data); 
}
redirect($this->input->post('redirect_page'));
}

public function add_glry_images($org_id){
	//echo 'test'.$this->session->userdata('users_id');exit;
if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
if(!$org_id){
echo "Something went wrong!";
exit;
}

$files			= $_FILES;
$file_count = count($_FILES['fa_glry_imgs']['name']);
$pre_glry_imgs = $this->input->post('pre_glry_imgs');
/*			echo "<pre>";

print_r($_POST);
echo count($files['fa_glry_imgs']);
if($files['fa_glry_imgs']['name'][0] != '') echo "te";
print_r($_FILES);
exit;*/

//echo "Testing ".$file_count; exit;
$doc_root = $_SERVER['DOCUMENT_ROOT'];			

if($files['fa_glry_imgs']['name'][0] != ''){
$club_dir = $doc_root.'\assets\club_facility\\'.$org_id;		
if (!file_exists($club_dir)){
mkdir($club_dir, 0777, true);
}

$club_ps_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\gallery';
if (!file_exists($club_ps_dir)){
mkdir($club_ps_dir, 0777, true);
}
$club_gl_org_dir = $doc_root.'\assets\club_facility\\'.$org_id.'\gallery\originals';
if (!file_exists($club_gl_org_dir)){
mkdir($club_gl_org_dir, 0777, true);
}

for($i=0; $i<$file_count; $i++){
if($files['fa_glry_imgs']['name'][$i]) {
$_FILES['gl_imgs']['name']			= time().$files['fa_glry_imgs']['name'][$i];
$_FILES['gl_imgs']['type']			= $files['fa_glry_imgs']['type'][$i];
$_FILES['gl_imgs']['tmp_name']	= $files['fa_glry_imgs']['tmp_name'][$i];
$_FILES['gl_imgs']['error']		= $files['fa_glry_imgs']['error'][$i];
$_FILES['gl_imgs']['size']			= $files['fa_glry_imgs']['size'][$i];

$fileName = 'gl_imgs';

$config = array(
'upload_path'	  => $club_ps_dir,
'allowed_types' => "gif|jpg|png|jpeg",
'overwrite'		=> TRUE,
'max_size'		=> "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
'max_height'	=> "8000",
'max_width'	=> "10000");

$config2 = array(
'upload_path'	  => $club_gl_org_dir,
'allowed_types' => "gif|jpg|png|jpeg",
'overwrite'		=> TRUE,
'max_size'		=> "10000", // Can be set to particular file size , here it is ~10 MB(2048 Kb)
'max_height'	=> "8000",
'max_width'	=> "10000");

$this->load->library('upload',$config);  
$this->upload->initialize($config);

if($this->upload->do_upload($fileName)){
$upload_data = $this->upload->data();
$glry_arr[] = $upload_data['file_name'];
}

$this->upload->initialize($config2);
$this->upload->do_upload($fileName);

}
}

if($pre_glry_imgs != null and $pre_glry_imgs != 'null'){
$prev_arr   = json_decode($pre_glry_imgs, true);
$upd_imgs = array_merge($prev_arr, $glry_arr);
$glry_imgs = json_encode($upd_imgs);
}
else{
$glry_imgs = json_encode($glry_arr);
}

$data['Aca_ID']			   = $org_id;
$data['Facility_Gallery']  = $glry_imgs;
$upd_details				   = $this->model_academy->update_facility_glry_teams($data); 
}
redirect($this->input->post('redirect_page'));
}

public function add_videoLinks(){

$org_id = $this->academy_id;

if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
if(!$org_id){
echo "Something went wrong!";
exit;
}

$prev_vids = $this->input->post('prev_vids');
$new_vids  = $this->input->post('fa_yt_links');

$new_vid_arr = array();
if($new_vids != ''){
	$yt_link_text = explode(',', $new_vids);
	foreach($yt_link_text as $yt){
			if(trim($yt) != ""){
				$yt = str_replace('watch?v=', 'embed/', $yt);
				$new_vid_arr[] = trim($yt);
			}
	}

if($prev_vids != null and $prev_vids != 'null'){
$prev_arr   = json_decode($prev_vids, true);
$vids_final_arr = array_merge($prev_arr, $new_vid_arr);
}
else{
$vids_final_arr = $new_vid_arr;
}


$vids_json = json_encode($vids_final_arr);

$data['Aca_ID']		  = $org_id;
$data['VideoLinks']  = $vids_json;
$upd_details			  = $this->model_academy->update_facility_videolinks($data); 
}

redirect($this->input->post('redirect_page'));
}

public function delete_glry($org_id){
//echo '$this->session->userdata("users_id") '.$this->session->userdata("users_id"); 
//echo $this->is_club_admin. " - ". $this->logged_user. " - ". $this->academy_admin;
if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
if(!$org_id){
echo "Something went wrong!";
exit;
}

$del_images  = $this->input->post('sel_images');
$all_images   = $this->input->post('all_imgs');

$prev_all_imgs  = json_decode($all_images, true);

$upd_imgs = array_diff($prev_all_imgs, $del_images);

/*echo "<pre>";
print_r($_POST);
print_r($this->input->post('sel_images'));
print_r($prev_all_imgs);
print_r($upd_imgs);
exit;*/

$data['Aca_ID']			   = $org_id;
$data['Facility_Gallery']  = json_encode($upd_imgs);
$upd_details				   = $this->model_academy->update_facility_glry_teams($data); 

}

public function delete_vids(){
//echo '$this->session->userdata("users_id") '.$this->session->userdata("users_id"); 
//echo $this->is_club_admin. " - ". $this->logged_user. " - ". $this->academy_admin;
$org_id = $this->academy_id;
if(!$this->is_club_admin){ echo "Unauthorised Access!"; exit; }
if(!$org_id){
echo "Something went wrong!";
exit;
}

$del_vids  = $this->input->post('sel_vids');
$all_vids   = $this->input->post('all_vids');

$prev_all_vids  = json_decode($all_vids, true);

$upd_imgs = array_diff($prev_all_vids, $del_vids);

$data['Aca_ID']			   = $org_id;
$data['VideoLinks']		   = json_encode($upd_imgs);
$upd_details				   = $this->model_academy->update_facility_videolinks($data); 

}
}
?>