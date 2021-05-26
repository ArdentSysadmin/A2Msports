<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//adding config items.
$config['PayPalMode'] = 'sandbox'; // sandbox or live
$config['PayPalApiUsername'] = 'admin-facilitator_api1.a2msports.com'; //PayPal API Username
$config['PayPalApiPassword'] = 'RLXDY3SQ6PNT5US6'; //Paypal API password
$config['PayPalApiSignature'] = 'AUfrWDBqps6FD.3kRn7w3-gsTcgqAGUChQUeydN3z550rOSXitwuqYWs'; //Paypal API Signature
$config['PayPalCurrencyCode'] = 'USD'; //Paypal Currency Code
$config['PayPalReturnURL'] = base_url().'paypal/success/'; //Point to process.php page
$config['PayPalCancelURL'] = base_url().'paypal/cancel/'; //Cancel URL if user clicks cancel
