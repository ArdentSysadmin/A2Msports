<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//adding config items.
$config['PayPalMode'] = 'live'; // sandbox or live
$config['PayPalApiUsername'] = 'admin_api1.a2msports.com'; //PayPal API Username
$config['PayPalApiPassword'] = '728KLXR5QWS9URBW'; //Paypal API password
$config['PayPalApiSignature'] = 'ADfSJQMOTfIywNttfIXyG-eEEiNwAdDynxyQeY.Pg.mMmpioaCUsSEuZ'; //Paypal API Signature
$config['PayPalCurrencyCode'] = 'USD'; //Paypal Currency Code
$config['PayPalReturnURL'] = base_url().'paypal/success/'; //Point to process.php page
$config['PayPalCancelURL'] = base_url().'paypal/cancel/'; //Cancel URL if user clicks cancel