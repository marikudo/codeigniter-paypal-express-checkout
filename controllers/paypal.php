<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Paypal extends CI_Controller {

    /**
     * Index Page for this controller.
     */
  
    public function __construct() {
	    parent::__construct();
    }

    public function index() {
		 $settings = array('api_username' => 'platfo_1255077030_biz_api1.gmail.com',
						   'api_password' => '1255077037',
						   'api_signature' => 'Abg0gYcQyxQvnf2HDJkKtA-p6pqhA1k-KTYE0Gcy1diujFio4io5Vqjf',
						   'api_endpoint' => 'https://api-3t.sandbox.paypal.com/nvp',
						   'api_url' => 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=',
						   'api_version' => '65.1',
						   'payment_type' => 'Sale',
						   'currency' => 'USD'
						   );
		 $this->load->library('paypalexpress', $settings);		  
		 if(!isset($_GET['token'])) {
		 
		       // Setting up your intial variable to send payment process.
			   $url = dirname('http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']);
			   $personName  = 'test';
			   $L_NAME0   = 'test';
			   $L_AMT0  = '1';
			   $L_QTY0  =	'1';
			   $returnURL = urlencode($url.'/paypal');
			   $cancelURL = urlencode("$url/paypal");
			   $itemamt = 0.00;
			   $itemamt = $L_QTY0*$L_AMT0;
			   $amt = 1.00;
			   $nvpstr = "&L_NAME0=".$L_NAME0."&L_AMT0=".$L_AMT0."&L_QTY0=".$L_QTY0."&AMT=".(string)$amt."&ITEMAMT=".(string)$itemamt."&L_NUMBER0=1000&L_DESC0=Size: 8.8-oz&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$settings['currency']."&PAYMENTACTION=".$settings['payment_type'];
		        // calling initial api.
				$initresult = $this->paypalexpress->process_payment($nvpstr);
				if(isset($initresult) && $initresult['ACK'] == 'Failure') {
				  // redirect to view with error message.
				  $this->session->set_flashdata('error_message', 'Please check your details and try again');
				  redirect('myview');
				}
         } 
		 else {
			 $token = urlencode($_GET['token']);
			 $result = $this->paypalexpress->make_payment($token);
			 if(isset($result) && $result['ACK'] == 'Failure') {
			   // redirect to view with error message.
			   $this->session->set_flashdata('error_message', 'Please check your details and try again');
			   redirect('myview');
			 }
			 else {
			    // Do your stuff with success result.
			    print_r($result);
			 }
	     }
	}
}