<?php
/*
- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.
*/
/*
define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
define('PAYTM_MERCHANT_KEY', '6Ce@cOe!DI5B45YD'); //Change this constant's value with Merchant key received from Paytm.
define('PAYTM_MERCHANT_MID', 'QQvMKK87780530447906'); //Change this constant's value with MID (Merchant ID) received from Paytm.
define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm.
*/

define('PAYTM_ENVIRONMENT', 'PROD'); // PROD
define('PAYTM_MERCHANT_KEY', $PAYTM_MERCHANT_KEY); //Change this constant's value with Merchant key received from Paytm.
define('PAYTM_MERCHANT_MID', $PAYTM_MERCHANT_MID); //Change this constant's value with MID (Merchant ID) received from Paytm.
define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm.

//$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/order/status';
//$PAYTM_TXN_URL		= 'https://securegw-stage.paytm.in/order/process';
$PAYTM_CALLBACK_URL	= base_url().'paytm/success';
if($PAYTM_CALLBACK_URL_UPDATED){
$PAYTM_CALLBACK_URL	= $PAYTM_CALLBACK_URL_UPDATED;
}

if (PAYTM_ENVIRONMENT == 'PROD') {
	/*$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';*/
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/order/status';
	$PAYTM_TXN_URL='https://securegw.paytm.in/order/process';
}

define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
//define('PAYTM_CALLBACK_URL', $PAYTM_CALLBACK_URL);
define('PAYTM_CALLBACK_URL', $PAYTM_CALLBACK_URL);
?>