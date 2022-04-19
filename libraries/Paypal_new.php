<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Paypal_new {

   protected $_errors = array();
   protected $_credentials = array(
      'USER' => 'admin_api1.a2msports.com',
      'PWD' => '728KLXR5QWS9URBW',
      'SIGNATURE' => 'ADfSJQMOTfIywNttfIXyG-eEEiNwAdDynxyQeY.Pg.mMmpioaCUsSEuZ',
   );

  // protected $_endPoint = 'https://api-3t.sandbox.paypal.com/nvp';
   protected $_endPoint = 'https://api-3t.paypal.com/nvp';
   protected $_version = '74.0';


   public function request($method,$params = array()) {
     $this->_errors = array();
     if( empty($method)): 
       $this->_errors = array('API method is missing');
       return false;
     endif;

     $requestParams = [
		       'METHOD' => $method,
		       'VERSION' => $this ->_version
		       ] + $this->_credentials;

     $request = http_build_query($requestParams + $params);
     $ch = curl_init();
     curl_setopt($ch,CURLOPT_URL, $this->_endPoint);
     curl_setopt($ch,CURLOPT_VERBOSE, 1);
     curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch,CURLOPT_POST,1);
     curl_setopt($ch,CURLOPT_POSTFIELDS,$request);
     $response = curl_exec($ch);
     if (curl_errno($ch)):
       $this->_errors = curl_error($ch);
       curl_close($ch);
       return false;
     else:
       curl_close($ch);
       $responseArray = array();
       parse_str($response,$responseArray); 
       return $responseArray;
     endif;

   }

}
