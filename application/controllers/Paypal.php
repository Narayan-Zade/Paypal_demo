<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller{
    
     function  __construct(){
        parent::__construct();
        
        // Load paypal library & product model
        $this->load->library('paypal_lib');
        $this->load->model('Product');
     }
     
    function success(){
        // Get the transaction data
        $paypalInfo = $this->input->get();

        $data['item_name']      = $paypalInfo['item_name'];
        $data['item_number']    = $paypalInfo['item_number'];
        $data['txn_id']         = $paypalInfo["tx"];
        $data['payment_amt']    = $paypalInfo["amt"];
        $data['currency_code']  = $paypalInfo["cc"];
        $data['status']         = $paypalInfo["st"];
    
        $this->load->view('paypal/success', $data);
    }
     
     function cancel(){
        // Load payment failed view
        $this->load->view('paypal/cancel');
     }
     
     function ipn(){
        // Paypal posts the transaction data
        $paypalInfo = $this->input->post();
       // echo "called ipn";
        if(!empty($paypalInfo)){
            // Validate and get the ipn response
            $ipnCheck = $this->paypal_lib->validate_ipn($paypalInfo);

            // Check whether the transaction is valid
            if($ipnCheck){
                // Insert the transaction data in the database
               // $data['user_id']        = $paypalInfo["custom"];
                $data['product_id']        = $paypalInfo["item_number"];
                $data['txn_id']            = $paypalInfo["txn_id"];
                $data['payment_gross']    = $paypalInfo["mc_gross"];
                $data['currency_code']    = $paypalInfo["mc_currency"];
                $data['payer_email']    = $paypalInfo["payer_email"];
                $data['payment_status'] = $paypalInfo["payment_status"];
                $this->Product->insertTransaction($data);
            }else {
                echo "IPN method not calling please check ";
            }
        }
    }
}