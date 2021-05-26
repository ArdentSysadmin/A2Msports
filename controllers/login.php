<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

public function __construct(){
parent:: __construct();
//echo "test"; exit;
$this->load->helper(array('form','url'));
$this->load->model('model_login','login');
$this->load->model('model_general','general');
$this->load->model('model_news');
$this->load->library(array('session','form_validation'));
//$this->load->library('user_agent');

parse_str($_SERVER['QUERY_STRING'] , $_REQUEST);
$this->load->library('facebook' ,  array("appId" => FB_APPID, "secret" => FB_KEY, "redirect_url" => FB_REDIRECT));
}

public function get_fb_login(){

$login  = $this->facebook->getLoginUrl();
return $login;
}

public function get_google_login(){


/* *************************************************************************** */

// Store values in variables from project created in Google Developer Console
$client_id = '170374605326-p02hhgiia6fqncck0982i401madv6n72.apps.googleusercontent.com';
$client_secret = 'XyOwkQkScXXca0wG4paTUx6A';
$redirect_uri = 'https://a2msports.com/login/auth_check';
$simple_api_key = 'AIzaSyC0JNMWyyW6t1fSNyrprBJC2bWKG4btytc';

include_once APPPATH."libraries/google_login_api_HRWNdR/src/Google_Client.php";
include_once APPPATH."libraries/google_login_api_HRWNdR/src/contrib/Google_Oauth2Service.php";

// Google Project API Credentials
$clientId	  = $client_id;
$clientSecret = $client_secret;
$redirectUrl  = $redirect_uri;

// Google Client Configuration
$gClient = new Google_Client();
$gClient->setApplicationName('A2MSports');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);
//$gclient->setDefaultOption('verify', false); // Can be removed
$google_oauthV2 = new Google_Oauth2Service($gClient);

if (isset($_REQUEST['code'])) {

$gClient->authenticate();
$this->session->unset_userdata('menu_items');
$this->session->set_userdata('token', $gClient->getAccessToken());
/*echo "Test 123 ".$this->session->userdata('token');
echo "fdfsd ".$gClient->getAccessToken();
exit;*/
redirect($redirectUrl);
}

$token = $this->session->userdata('token');

// if (!empty($token)) {
if ($token != "") {
$gClient->setAccessToken($token);
}

if ($gClient->getAccessToken() and $token != "") {
$userProfile = $google_oauthV2->userinfo->get();
// Preparing data for database insertion

$userData['oauth_provider'] = 'google';
$userData['oauth_uid']		= $userProfile['id'];
$userData['first_name']		= $userProfile['given_name'];
$userData['last_name']		= $userProfile['family_name'];
$userData['email']			= $userProfile['email'];
$userData['gender']			= $userProfile['gender'];
$userData['locale']			= $userProfile['locale'];
$userData['profile_url']	= $userProfile['link'];
$userData['picture_url']	= $userProfile['picture'];

/*echo "<pre>";
print_r($userData);
exit;*/
// Insert or update user data
$user_info = $this->login->checkGoogleUser($userData['email']);

if($user_info){
if($user_info['IsGoogleLogin'] != 1){
$this->login->updateGoogleUser($userData, $user_info['Users_ID']);
}
}
else{
$user_info = $this->login->createGoogleUser($userData);
}
$this->prepare_user_login($user_info);

/*echo "<pre>";
print_r($userData);
exit;*/

/*if(!empty($userID)){
$data['userData'] = $userData;
$this->session->set_userdata('userData',$userData);
} else {
$data['userData'] = array();
}*/
}
else {
$data['authUrl'] = $gClient->createAuthUrl();
}
/* *************************************************************************** */

return $data['authUrl'];
}

public function index($data = ''){
if($this->session->userdata('user')){
redirect('profile');
}
else{
$this->session->unset_userdata('redirect_to');
$blocked_redirects = array(
'https://a2msports.com/profile/add_player', 
'https://a2msports.com/login/send_email_activation',
'https://a2msports.com/reset/password'
);

$get_flash = $this->session->flashdata('act_stat');

if($get_flash){
$redirect_to = array('redirect_to' => $get_flash);
}
else if(in_array($_SERVER['HTTP_REFERER'], $blocked_redirects)){
$redirect_to = array('redirect_to' => base_url().'profile');
}
else if(strpos($_SERVER['HTTP_REFERER'], "a2msports.com/reset/password") > 0){
$redirect_to = array('redirect_to' => base_url().'profile');
}
else if($this->session->userdata('return_to')){
$redirect_to = array('redirect_to' => $this->session->userdata('return_to'));
$this->session->unset_userdata('return_to');
}
else{
$redirect_to = array('redirect_to' => $_SERVER['HTTP_REFERER']);
}

$this->session->set_userdata($redirect_to);
}

$data['results'] = $this->model_news->get_news();


$this->load->view('includes/header_static');
$this->load->view('view_login', $data);
$this->load->view('includes/footer_static');
}

public function auth_check(){
// Store values in variables from project created in Google Developer Console
$client_id = '170374605326-p02hhgiia6fqncck0982i401madv6n72.apps.googleusercontent.com';
$client_secret = 'XyOwkQkScXXca0wG4paTUx6A';
$redirect_uri = 'https://a2msports.com/login/auth_check';
$simple_api_key = 'AIzaSyC0JNMWyyW6t1fSNyrprBJC2bWKG4btytc';

include_once APPPATH."libraries/google_login_api_HRWNdR/src/Google_Client.php";
include_once APPPATH."libraries/google_login_api_HRWNdR/src/contrib/Google_Oauth2Service.php";

// Google Project API Credentials
$clientId	  = $client_id;
$clientSecret = $client_secret;
$redirectUrl  = $redirect_uri;

// Google Client Configuration
$gClient = new Google_Client();
$gClient->setApplicationName('A2MSports');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);
//$gclient->setDefaultOption('verify', false); // Can be removed
$google_oauthV2 = new Google_Oauth2Service($gClient);

if (isset($_REQUEST['code'])) {

$gClient->authenticate();
$this->session->unset_userdata('menu_items');
$this->session->set_userdata('token', $gClient->getAccessToken());

// redirect($redirectUrl);
}

$token = $this->session->userdata('token');
/*echo "test".$token;
exit;*/
if ($gClient->getAccessToken() and $token != "") {
$userProfile = $google_oauthV2->userinfo->get();
// Preparing data for database insertion

$userData['oauth_provider'] = 'google';
$userData['oauth_uid']		= $userProfile['id'];
$userData['first_name']		= $userProfile['given_name'];
$userData['last_name']		= $userProfile['family_name'];
$userData['email']			= $userProfile['email'];
$userData['gender']			= $userProfile['gender'];
$userData['locale']			= $userProfile['locale'];
$userData['profile_url']	= $userProfile['link'];
$userData['picture_url']	= $userProfile['picture'];

/*echo "<pre>";
print_r($userProfile);
exit;*/
// Insert or update user data
$user_info = $this->login->checkGoogleUser($userData['email']);

if($user_info){
if($user_info['IsGoogleLogin'] != 1){
$this->login->updateGoogleUser($userData, $user_info['Users_ID']);
}
}
else{
$user_info = $this->login->createGoogleUser($userData);
}
$this->prepare_user_login($user_info);

/*echo "<pre>";
print_r($userData);
exit;*/

/*if(!empty($userID)){
$data['userData'] = $userData;
$this->session->set_userdata('userData',$userData);
} else {
$data['userData'] = array();
}*/
}
else {
echo "Something went wrong! Please contact admin.";
}
/* *************************************************************************** */

}

public function validate_login()
{
$this->user = $this->facebook->getUser();

if($this->user){
try{
//$data['public_profile'] = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
$data['public_profile'] = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');

$fb_details = $this->login->is_social_user($data);

if(!empty($fb_details)){
$new_user = array(
'user'		=>	$fb_details['Firstname']." ".$fb_details['Lastname'],
'email'		=>	$fb_details['EmailID'],
'users_id'	=>	$fb_details['Users_ID'],
'is_social'	=>	'true',
'social_id'	=>	$fb_details['Socialactid'],
'lat'		=>	$fb_details['Latitude'],
'long'		=>	$fb_details['Longitude'],
'role'		=>	$fb_details['Role'],
'admin'		=>	$fb_details['Role']
);

$data['user_details'] = $fb_details;
}
else{
$res = $this->login->insert_fb($data);

$new_user = array(
'user'		=>	$res['Firstname']." ".$res['Lastname'],
'email'		=>	$res['EmailID'],
'users_id'	=>	$res['Users_ID'],
'is_social'	=>	'true',
'social_id'	=>	$res['Socialactid'],
'lat'		=>	$res['Latitude'],
'long'		=>	$res['Longitude'],
'role'		=>	$fb_details['Role'],
'admin'		=>	$fb_details['Role']
);

$data['user_details'] = $res;
}

$this->session->set_userdata($new_user);
$this->login->insert_a2mscore();  // Insert default score entries for a user if, he doesn't have records in A2MScore table

$data['logout'] = $this->facebook->getLogoutUrl(array("next" => base_url().'logout/fb_logout'));

if($data['user_details']['IsProfileUpdated'] ==	1){
$data['users_id']	= $this->session->userdata('users_id');
$data['lat']		= $this->session->userdata('lat');
$data['long']		= $this->session->userdata('long');
$data['range']		= 25;
$data['interests']	= $this->login->get_sports();
$data['tournments'] = $this->login->get_all($data);
$data['tourn_ids']  = $this->login->get_reg_tourn_ids();
$data['past_tournments'] = $this->login->get_past($data['tourn_ids']);

if(($this->session->userdata('redirect_to'))){
redirect($this->session->userdata('redirect_to'));
}
else{
redirect('Play',$data);
}
}
else{
$data['sports']	= $this->general->get_sports();

$this->load->view('includes/header', $data);
$this->load->view('view_fb_profile', $data);
$this->load->view('includes/footer_static');
}
}

catch (FacebookApiException $e){
print_r($e);
$user = null;
}
}
else{
echo "Something Went Wrong! Please write to us at admin@a2msports.com";
}
}

public function verify_user()
{
	//echo "<pre>"; print_r($_POST); exit;
if($this->input->post('submit_web_login')){				
$this->form_validation->set_rules('name_login','User Name','required');
$this->form_validation->set_rules('password_login','Password','required');


if($this->form_validation->run()===TRUE){
	//$this->session->sess_destroy();
	//		$this->facebook->destroySession();
			//delete_cookie('ci_session');
$get_data = $this->login->check_user();
//echo "<pre>"; print_r($get_data); exit;
if($get_data and $get_data['IsUserActivation'] == 1){
$notify = json_decode($get_data['NotifySettings']);

if(in_array('2', $notify)){
$email_notify = 1;
}
else{
$email_notify = 0;
}

$new_user = array(
'user'			=>	$get_data['Firstname']." ".$get_data['Lastname'], 
'email'			=>	$get_data['EmailID'],
'username'		=>	$get_data['Username'],
'users_id'		=>	$get_data['Users_ID'], 
'lat'			=>	$get_data['Latitude'],
'long'			=>	$get_data['Longitude'],
'role'			=>	$get_data['Role'],
'admin'			=>	$get_data['Role'],
'email_notify'	=>	$email_notify);

$this->session->set_userdata($new_user);
//echo "<pre>"; print_r($this->session->userdata); exit;

$child_data = $this->login->child_user();
$child_user = array('child_user_id'=>$child_data['Users_ID'],'child_parent_id'=>$child_data['Ref_ID']);

$this->session->set_userdata($child_user);

$data['users_id'] = $this->session->userdata('users_id');
$data['lat']   = $this->session->userdata('lat');
$data['long']  = $this->session->userdata('long');
$data['range'] = 10;

$this->login->insert_a2mscore();  // Insert default score entries for a user if, he doesn't have records in A2MScore table

$data['interests'] = $this->login->get_sports();
$data['tournments'] = $this->login->get_all($data);


/*echo "<pre>test"; 
//print_r($_POST);
print_r($this->session->userdata); 
//print_r( $_COOKIE);
print_r(getallheaders());
print_r(headers_list());
exit;*/
//echo "<pre>"; print_r($this->session);exit;
//print_r($_SERVER);
//echo "test"; exit;
//redirect("https://primesportsventures.in");

if($this->input->post('academy')){
	if($this->input->post('aca_page'))
	redirect($this->input->post('shortcode')."/".$this->input->post('aca_page'));
	else
	redirect($this->input->post('shortcode'));
}

if(($this->session->userdata('redirect_to'))){
$exp = explode('.com', $this->session->userdata('redirect_to'));
redirect($exp[1]);
}
else{
redirect('Play', $data);
}
}
else{
	///echo "Test"; var_dump($get_data['IsUserActivation']); echo $get_data['IsUserActivation']; exit;
	//count($get_data); exit;
	 if(count($get_data) > 0 and $get_data['IsUserActivation'] === 0)
		$err_msg = "Email verification not completed!";
	else
		$err_msg = "Invalid Login Details!";
	//$this->index($data);
	$this->session->set_flashdata('err_msg', $err_msg);
	if($this->input->post('academy')){
	redirect($this->input->post('shortcode'));
	}

	redirect('login');
}
}
}
else{
	echo "Invalid Request!";
}
}

//  forgot password form for registered user .... 
public function forgot_password()
{
$data['results'] = $this->model_news->get_news();

$this->load->view('includes/header_static');
$this->load->view('view_forgot_password');
$this->load->view('includes/view_right_column',$data);
$this->load->view('includes/footer_static');					
}

// user can reset the password , by enter the valid email address 

public function ref_accounts() 
{
if($this->input->post('submit')) 
{
$email  = trim($this->input->post('email'));
$result = $this->login->email_exists($email); 
$ref_id = $result[0]->Users_ID;

$child_accounts = "";

if($ref_id){
$child_accounts = $this->login->child_accounts($ref_id);         // child account or not check
}

if($result or $child_accounts){
$data['child_accounts']  = array_merge($result,$child_accounts);
$data['parent_id']		 = $ref_id;
$data['results']		 = $this->model_news->get_news();

$this->load->view('includes/header');
$this->load->view('view_forgot_password',$data);
$this->load->view('includes/view_right_column',$data);
$this->load->view('includes/footer_static');
}
else{
$data['error']   = "We will send password reset links only to registered email address";
$data['results'] = $this->model_news->get_news();

$this->load->view('includes/header');
$this->load->view('view_forgot_password', $data);
$this->load->view('includes/view_right_column',$data);
$this->load->view('includes/footer_static');
}
}
}

public function get_child_name($user_id){     //for child email send
return $this->login->get_child_name($user_id);   
}

public function send_email_activation()     //for child email send
{
$user_id = $this->input->post('child_user_id');  //child user id
$parent_id = $this->input->post('uid');  //child user id

$get_user = $this->login->check_act_code($user_id);

if($get_user['Username'] == ""){
$this->send_reset_password_email($parent_id);
$data['msg'] = "Password reset link has been sent to your email.";
}
else{
$code = md5($get_user['Lastname']. $get_user['AlternateEmailID']);
$auth_code = substr($code, 0, 16);

$update_act_code = $this->login->upd_child_act_code($user_id,$auth_code);

$this->send_reset_child_password_email($parent_id, $user_id);
$data['msg'] = "Password reset link has been sent to your email.";
}

$data['results'] = $this->model_news->get_news();
$this->load->view('includes/header');
$this->load->view('view_forgot_password',$data);
$this->load->view('includes/view_right_column',$data);
$this->load->view('includes/footer_static');
}


private function send_reset_password_email($parent_id)
{
$pa_id			= $parent_id;
$parent_details = $this->get_child_name($pa_id);

$parent_email = $parent_details['EmailID'];
$first_name   = $parent_details['Firstname'];
$last_name    = $parent_details['Lastname'];

if($parent_details['ActivationCode']){
$activation_code = $parent_details['ActivationCode'];
}
else{
$code = md5($parent_details['Lastname']. $parent_details['AlternateEmailID']);
$activation_code = substr($code, 0, 16);

$update_act_code = $this->login->upd_child_act_code($pa_id, $activation_code);
}

$this->load->library('email');
$this->email->set_newline("\r\n");

$this->email->from(FROM_EMAIL, 'A2MSports');
$this->email->to($parent_email); 
$this->email->subject('Reset password - A2MSports');

$data = array(
'firstname'=> $first_name,
'lastname'=> $last_name,
'code' => $activation_code,
'page'=> 'Reset Password'
);

$body = $this->load->view('view_email_template.php',$data,TRUE);
$this->email->message($body);   
$stat = $this->email->send();

return $stat;
}

private function send_reset_child_password_email($parent_id , $user_id){
$pa_id = $parent_id;
$parent_details = $this->get_child_name($pa_id);
$parent_email = $parent_details['EmailID'];
$p_first_name = $parent_details['Firstname'];
$p_last_name = $parent_details['Lastname'];

$child_id = $user_id;
$child_data = $this->get_child_name($child_id);

$activation_code = $child_data['ActivationCode'];
$first_name = $child_data['Firstname'];
$last_name = $child_data['Lastname'];
$child_user_name = $child_data['Username'];

$this->load->library('email');
$this->email->set_newline("\r\n");

$this->email->from(FROM_EMAIL, 'A2MSports');
$this->email->to($parent_email); 
$this->email->subject('Reset password - A2MSports');

$data = array(
'p_firstname'	=> $p_first_name,
'p_lastname'	=> $p_last_name,
'firstname'	=> $first_name,
'lastname'		=> $last_name,
'child_user_name'	=> $child_user_name,
'code'				=> $activation_code,
'page'				=> 'Reset Profile Password'
);

$body = $this->load->view('view_email_template.php', $data, TRUE);
$this->email->message($body);   
$stat = $this->email->send();

return $stat;
}


// update password form 
public function reset_password_form($activation_code)
{
$this->session->sess_destroy();
$this->facebook->destroySession();

$code = trim($activation_code);

//check the verified code to the url and database ...then only update password form visible ..
$verified = $this->login->verify_reset_password_code($code);

$data = array('act_stat' => 'Welcome to A2msports. Reset your login with a new password');

if($verified){
$data['results']		= $this->model_news->get_news();
$data['user_details']  = $this->login->verify_reset_password_code($code);

$this->load->view('includes/header');
$this->load->view('view_update_password', $data);
$this->load->view('includes/view_right_column',$data);
$this->load->view('includes/footer_static');

}
else{
// this should never happen 
echo 'Error in request. Please contact admin info@a2msports.com ';
}
}

public function update_password(){
$result = $this->login->update_password();
$data   = array('update' => 'Your Password updated Successfully . Please login to continue our website');

$this->index($data);
}

public function auth_token($token){
//	$this->session->sess_destroy();
$get_data = $this->login->validate_token(trim($token));

if($get_data){
$new_user = array(
'user'     => $get_data['Firstname']." ".$get_data['Lastname'], 
'email'    => $get_data['EmailID'],
'username' => $get_data['Username'],
'users_id' => $get_data['Users_ID'],
'lat'	   => $get_data['Latitude'],
'long'	   => $get_data['Longitude']
);

$this->session->set_userdata($new_user);

$child_data = $this->login->child_user();
$child_user = array('child_user_id'=>$child_data['Users_ID'],'child_parent_id'=>$child_data['Ref_ID']);

$this->session->set_userdata($child_user);

$data['users_id']	= $this->session->userdata('users_id');
$data['lat']		= $this->session->userdata('lat');
$data['long']		= $this->session->userdata('long');
$data['range']		= 10;

//$this->login->insert_a2mscore();  // Insert default score entries for a user if, he doesn't have records in A2MScore table

$data['interests'] = $this->login->get_sports();
$data['tournments'] = $this->login->get_all($data);

redirect('Play',$data);
}	
else{
$data['err_msg'] = "Authentication is Failed! Please contact admin@a2msports.com";
$this->index($data);
}
}

public function prepare_user_login($get_data){

if($get_data){
$notify = json_decode($get_data['NotifySettings']);

if(in_array('2', $notify)){
$email_notify = 1;
}
else{
$email_notify = 0;
}

$new_user = array(
'user'			=>	$get_data['Firstname']." ".$get_data['Lastname'], 
'email'			=>	$get_data['EmailID'],
'username'		=>	$get_data['Username'],
'users_id'		=>	$get_data['Users_ID'], 
'lat'			=>	$get_data['Latitude'],
'long'			=>	$get_data['Longitude'],
'role'			=>	$get_data['Role'],
'admin'			=>	$get_data['Role'],
'email_notify'	=>	$email_notify);

$this->session->set_userdata($new_user);

$child_data = $this->login->child_user();
$child_user = array('child_user_id'=>$child_data['Users_ID'],'child_parent_id'=>$child_data['Ref_ID']);

$this->session->set_userdata($child_user);

$data['users_id'] = $this->session->userdata('users_id');
$data['lat']   = $this->session->userdata('lat');
$data['long']  = $this->session->userdata('long');
$data['range'] = 10;

//$this->login->insert_a2mscore();  // Insert default score entries for a user if, he doesn't have records in A2MScore table

$data['interests'] = $this->login->get_sports();
$data['tournments'] = $this->login->get_all($data);

$this->session->unset_userdata('token');

//redirect('Play', $data);
//if($get_data['IsProfileUpdated'] ==	1){
if(($this->session->userdata('redirect_to'))){
$exp = explode('.com', $this->session->userdata('redirect_to'));
redirect($exp[1]);
}
else{
redirect('Play', $data);
}
/*}
else{
$data['user_details'] = $get_data;

$this->load->view('includes/header', $data);
$this->load->view('view_fb_profile', $data);
$this->load->view('includes/footer');
}*/
}
else{
echo "Something went wrong! Please contact admin.";
exit;
}
}

public function ajax_validate_login(){
		
		if($this->input->post('name_login') and $this->input->post('password_login')){
			$email = $this->input->post('name_login');
			$pwd   = $this->input->post('password_login');
			$get_data = $this->login->check_user();
				if($get_data and $get_data['IsUserActivation'] == 1){
					echo 1;
				}
				else{
					if(count($get_data) > 0 and $get_data['IsUserActivation'] === 0)
						echo -1;
					else
						echo -2;
				}
		}
		else{
			echo 0;
		}
}

		public function send_activation(){
			//echo $_SERVER['REQUEST_URI'];
			//echo "<pre>"; //print_r($_POST); 
			//echo $this->input->post('txt_reg_email'); exit;
			if($this->input->post('txt_reg_email') != ''){
				$user_email = $this->input->post('txt_reg_email'); 
				$get_user = $this->login->check_user_exists($user_email);

				if($get_user){
				$this->send_reset_password_email($get_user['Users_ID']);
				$msg = "<h3>Password reset link has been sent to your email.</h3>";
				}
				else{
				$msg = "<h3>Something went wrong! Please contact admin</h3>";
				}
				//echo $msg; 
				//exit;
				$this->session->set_flashdata('frg_pwd_msg', $msg);
				$http_orig_url = explode('/', $_SERVER['HTTP_X_ORIGINAL_URL']);


				if($_SERVER['HTTP_X_FORWARDED_HOST'] != '')
				$red =$_SERVER['HTTP_X_REQUEST_SCHEME']."://".$_SERVER['HTTP_X_FORWARDED_HOST'];
				else
				$red= $config['base_url'].$http_orig_url[1];

				//echo $this->config->item('club_form_url');
				//exit;
				redirect($red);

				exit;
			}
			else{
				echo "Invalid Access!"; exit;
			}
		}

	public function phone_login(){
		
		$token = $this->input->post('token');
		$mobile = $this->input->post('Mobilephone');
		$regas = $this->input->post('regas');

		if($token and $regas){

			$exp	= explode('.', $token);
			$arr		= json_decode(base64_decode($exp[1]), true);
			$exp_time = $arr['exp'];
			$cur_time = strtotime(date('Y-m-d H:i:s'));
			//echo "<pre>"; print_r($arr); exit;
			if($cur_time < $exp_time){
			$phone	= $arr['phone_number'];
			$ph			= substr($phone, -10);
				if($phone != $mobile){
				echo "Invalid Mobile Number. Please contact admin!";
				exit;
				}
				
				$get_user = $this->general->get_user($regas);

				if($get_user){
					if($get_user['Mobilephone'] == $mobile or $get_user['Mobilephone'] == $ph){
						$this->create_user_session($regas, '1', $get_user);
					}
					else{
						echo "Something went wrong! please contact admin";
						exit;
					}
				}
			}
			else{
				echo "Token Expired. Please try again!";
				exit;
			}
		}
		else{
			echo "Invalid Access!";
		}
	}

	
		public function create_user_session($user, $is_valid, $get_data){
			if($is_valid == '1') {
				//get_data = $this->general->get_user($user);
				if($get_data) {
					$notify = json_decode($get_data['NotifySettings']);

					if(in_array('2', $notify)) {
					$email_notify = 1;
					}
					else {
					$email_notify = 0;
					}

					$new_user = array(
					'user'				=>	$get_data['Firstname']." ".$get_data['Lastname'], 
					'email'			=>	$get_data['EmailID'],
					'username'		=>	$get_data['Username'],
					'users_id'		=>	$get_data['Users_ID'], 
					'lat'				=>	$get_data['Latitude'],
					'long'				=>	$get_data['Longitude'],
					'role'				=>	$get_data['Role'],
					'admin'			=>	$get_data['Role'],
					'email_notify'	=>	$email_notify);

				$this->session->set_userdata($new_user);

				$data['users_id']  = $this->session->userdata('users_id');
				$data['lat']			 = $this->session->userdata('lat');
				$data['long']		 = $this->session->userdata('long');
				$data['range']		 = 10;

				$this->login->insert_a2mscore();  
				// Insert default score entries for a user if, he doesn't have records in A2MScore table

				$data['interests']		 = $this->login->get_sports();
				$data['tournments'] = $this->login->get_all($data);

				if($this->input->post('academy')) {
					if($this->input->post('aca_page'))
						redirect($this->input->post('shortcode')."/".$this->input->post('aca_page'));
					else
						redirect($this->input->post('shortcode'));
				}

				if(($this->session->userdata('redirect_to'))) {
					$exp = explode('.com', $this->session->userdata('redirect_to'));
					redirect($exp[1]);
				}
				else {
					redirect('Play', $data);
				}
				}
			}
		}


}