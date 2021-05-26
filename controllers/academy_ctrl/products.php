<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller
{
    function  __construct() {
        parent::__construct();
        $this->load->library('paypal_lib');
        $this->load->model('product');
    }
    
    function index(){
        $data = array();
        //get products data from database
        $data['products'] = $this->product->getRows();
        //pass the products data to view
        $this->load->view('view_product', $data);
    }
    
    function buy($id){
        //Set variables for paypal form
        $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //test PayPal api url
        $paypalID = 'business@ardent-india.com'; //business email
        $returnURL = base_url().'success'; //payment success url
        $cancelURL = base_url().'cancel'; //payment cancel url
        $notifyURL = base_url().'ipn'; //ipn url
        //get particular product data
        $product = $this->product->getRows($id);
        $userID = 1; //current user id
        $logo = base_url().'/images/logo.png';
        
        $this->paypal_lib->add_field('business', $paypalID);
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $product['name']);
        $this->paypal_lib->add_field('custom', $userID);
        $this->paypal_lib->add_field('item_number',  $product['id']);
        $this->paypal_lib->add_field('amount',  $product['price']);        
        $this->paypal_lib->image($logo);
        
        $this->paypal_lib->paypal_auto_form();
    }
}