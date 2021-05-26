<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paytm extends CI_Controller {
  
		public function __construct()
		{
			parent:: __construct();

			//$this->load->helper(array('form', 'url'));

			//$this->load->library('form_validation');
			//$this->load->library('session');
			//$this->load->library('image_lib');

			//$this->is_super_admin = 0;

			$this->load->model('model_league');
		}
  
public function paytm(){
  $this->load->view('TxnTest');
}

public function paytm_test(){
print_r($this->session->all_userdata());
}

 public function success() {
   
    /*echo "<pre>";
	print_r($_REQUEST);
	print_r($this->session->userdata('paytm_session'));
	exit;*/

	$paytm_return  = $_REQUEST;
	$paytm_session = $this->session->userdata('paytm_session');


	if($paytm_return['STATUS'] == 'TXN_SUCCESS') {
		
		if($paytm_session) {
		
		//----------------------------------------------------------------
		$this->session->unset_userdata('tour_reg_fee');
		$this->session->unset_userdata('reg_tour_id');

		$data = array();

			$data['item_number']	= $paytm_return['STATUS'];
			$data['txn_id']			= $paytm_return['TXNID'];
			$data['payment_amt']	= $paytm_return['TXNAMOUNT'];
			$data['currency_code']	= $paytm_return['CURRENCY'];
			$data['status']			= 'Completed';
			$data['coup_code']	= $paytm_session['coup_code'];
			$data['coup_disc']	= $paytm_session['coup_disc'];

		 if($paytm_session['ttype'] == 'Teams') {
			$data['team']		= $team_id		= $paytm_session['team'];
			$data['player']		= $user_id		= $paytm_session['reg_user'];
			$data['team_players']= $team_players= $paytm_session['team_players'];
			$data['tourn_id']	= $tourn_id		= $paytm_session['tourn_id'];
			$data['age_group']	= $age_group	= $paytm_session['age_group'];
			$data['level']		= $level		= $paytm_session['level'];
			$data['hc_loc_id']	= $hc_loc		= $paytm_session['hc_loc'];
			$data['tsize']		= $tsize		= $paytm_session['tsize'];
			$data['note_to_admin'] = $note_to_admin	= $paytm_session['note_to_admin'];

			$res = $this->model_league->team_reg_tourn_with_fee($data);
		 }
		 else if($paytm_session['ttype'] == 'Indv') {		
			$data['player']		= $user_id		= $paytm_session['player'];
			$data['tourn_id']	= $tourn_id		= $paytm_session['tourn_id'];
			$data['age_group']	= $age_group	= $paytm_session['age_group'];
			$data['mtypes']		= $match_types	= $paytm_session['mtypes'];
			$data['partners']	= $partner1		= $paytm_session['partners'];
			//$data['partner2']	= $partner2		= $this->input->get('partner2');
			$data['level']		= $level		= $paytm_session['level'];
			$data['hc_loc_id']	= $hc_loc		= $paytm_session['hc_loc'];
			$data['tsize']		= $tsize		= $paytm_session['tsize'];
			$data['events']     = $reg_events   = $paytm_session['events'];
			$data['note_to_admin'] = $note_to_admin	= $paytm_session['note_to_admin'];

			$res = $this->model_league->reg_tourn_with_fee($data);
		 }

			if($res) {
			$data['reg_suc'] = "You have successfully registered for this tournament.";
			redirect("league/$tourn_id/1");
			}
		//-----------------------------------------------------
		}
		else{
			echo "Payment Successful. But, something went wrong! please check with admin@a2msports.com";
			echo "<br>Transaction ID: " . $paytm_return['TXNID'];
			exit;
		}
	}
	else{
		echo $paytm_return['RESPMSG'];
		exit;
	}
 }

 public function pay_success() {
   	
	$paytm_return  = $_REQUEST;
	$paytm_session = $this->session->userdata('paytm_session');


	if($paytm_return['STATUS'] == 'TXN_SUCCESS') {
		
		if($paytm_session) {
		
		//----------------------------------------------------------------
		$this->session->unset_userdata('tour_per_player_fee');
		$this->session->unset_userdata('tour_reg_team_id');

		$data = array();

		$data['item_number']	= $paytm_return['STATUS'];
		$data['txn_id']			= $paytm_return['TXNID'];
		$data['payment_amt']	= $paytm_return['TXNAMOUNT'];
		$data['currency_code']	= $paytm_return['CURRENCY'];
		$data['status']			= 'Completed';

		$data['player']		= $user_id		= $paytm_session['reg_user'];
		$data['league']		= $tourn_id		= $paytm_session['tourn_id'];
		$data['team']		= $team			= $paytm_session['team'];

			$res = $this->model_league->team_player_fee_paymet($data);



			if($res) {
			$data['reg_suc'] = "You have successfully registered for this tournament.";
			redirect("league/$tourn_id/1");
			}
		//-----------------------------------------------------
		}
		else{
			echo "Payment Successful. But, something went wrong! please check with admin@a2msports.com";
			echo "<br>Transaction ID: " . $paytm_return['TXNID'];
			exit;
		}
	}
	else{
		echo $paytm_return['RESPMSG'];
		exit;
	}
 }


public function paytmpost()
{
 header("Pragma: no-cache");
 header("Cache-Control: no-cache");
 header("Expires: 0");

 // following files need to be included
 require_once(APPPATH . "/third_party/paytm/config_paytm.php");
 require_once(APPPATH . "/third_party/paytm/encdec_paytm.php");

 $checkSum = "";
 $paramList = array();

 $ORDER_ID = $_POST["ORDER_ID"];
 $CUST_ID = $_POST["CUST_ID"];
 $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
 $CHANNEL_ID = $_POST["CHANNEL_ID"];
 $TXN_AMOUNT = $_POST["TXN_AMOUNT"];

// Create an array having all required parameters for creating checksum.
 $paramList["MID"] = PAYTM_MERCHANT_MID;
 $paramList["ORDER_ID"] = $ORDER_ID;
 $paramList["CUST_ID"] = $CUST_ID;
 $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
 $paramList["CHANNEL_ID"] = $CHANNEL_ID;
 $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
 $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
 $paramList["CALLBACK_URL"] = PAYTM_CALLBACK_URL;

 /*
 $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
 $paramList["EMAIL"] = $EMAIL; //Email ID of customer
 $paramList["VERIFIED_BY"] = "EMAIL"; //
 $paramList["IS_USER_VERIFIED"] = "YES"; //

 */

//Here checksum string will return by getChecksumFromArray() function.
 $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
/* echo $checkSum;
 exit;*/
 echo "<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
    <center><h1>Please do not refresh this page...</h1></center>
        <form method='post' action='".PAYTM_TXN_URL."' name='f1'>
<table border='1'>
 <tbody>";

 foreach($paramList as $name => $value) {
 echo '<input type="hidden" name="' . $name .'" value="' . $value .         '">';
 }

 echo "<input type='hidden' name='CHECKSUMHASH' value='". $checkSum . "'>
 </tbody>
</table>
<script type='text/javascript'>
 document.f1.submit();
</script>
</form>
</body>
</html>";
 }

}
?>