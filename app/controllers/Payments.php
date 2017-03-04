<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('payments_model');
    }

    function index($action = NULL) {
        show_404();
    }

    function paypalipn() {

        $this->log_payment('Paypal IPN called');

        //$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        $fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);

        if (!$fp) {

            $this->log_payment('Paypal Payment Failed (IPN HTTP ERROR)', $errstr);

        } else {

            $paypal = $this->payments_model->getPaypalSettings();
            if(!empty($_POST)) {

                $req = 'cmd=_notify-validate';
                foreach ($_POST as $key => $value) {
                    $value = urlencode(stripslashes($value));
                    $req .= "&$key=$value";
                }

                $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
                $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
                $header .= "Host: www.paypal.com\r\n";  // www.sandbox.paypal.com for a test site
                $header .= "Content-Length: " . strlen($req) . "\r\n";
                $header .= "Connection: close\r\n\r\n";

                fputs($fp, $header . $req);
                while (!feof($fp)) {
                    $res = fgets($fp, 1024);
                    //log_message('error', 'Paypal IPN - fp handler -'.$res);
                    if (stripos($res, "VERIFIED") !== false) {
                        $this->log_payment('Paypal IPN - VERIFIED');

                        $custom = explode('__', $_POST['custom']);
                        $payer_email = $_POST['payer_email'];

                        if (($_POST['payment_status'] == 'Completed' || $_POST['payment_status'] == 'Processed' || $_POST['payment_status'] == 'Pending') && ($_POST['receiver_email'] == $paypal->account_email) && ($_POST['mc_gross'] == ($custom[1] + $custom[2]))) {
                            $invoice_no = $_POST['item_number'];
                            $reference = $_POST['item_name'];
                            $amount = $_POST['mc_gross'];

                            if($inv = $this->payments_model->getInvoiceByID($invoice_no)) { 
                                $note = $_POST['mc_currency'].' '.$_POST['mc_gross'].' had been paid for the Sale No. '.$inv->id.' (Reference No '.$reference.'). Paypal transaction id is '.$_POST['txn_id'];
                                if($this->payments_model->addPaument($inv->id, $inv->customer_id, $amount, $note)){
                                    $this->send_email($paypal->account_email, $inv->id, $inv->customer_id, $amount, $note);
                                    $this->log_payment('Payment has been made for Sale Reference #' . $_POST['item_name'] . ' via Paypal ('.$_POST['txn_id'].').', print_r($_POST, ture));
                                }
                            }
                        } else {
                            $this->log_payment('Payment failed via Paypal, please check manually. ', (!empty($_POST) ? print_r($_POST, ture) : NULL));
                        }
                    } else if (stripos($res, "INVALID") !== false) {
                        $this->log_payment('INVALID response from Paypal. Payment failed. ', (!empty($_POST) ? print_r($_POST, ture) : NULL));
                    }
                } 
                fclose($fp);
            } else {
                $this->log_payment('INVALID response from Paypal (no post data received). Payment failed. ', (!empty($_POST) ? print_r($_POST, ture) : NULL));
            }
        } 
    }

    function skrillipn() {

        $skrill = $this->payments_model->getSkrillSettings();
        $this->log_payment('Skrill IPN called');
        if(!empty($_POST)) {
            // Validate the skrill signature
            $concatFields = $_POST['merchant_id'].$_POST['transaction_id'].strtoupper(md5($skrill->secret_word)).$_POST['mb_amount'].$_POST['mb_currency'].$_POST['status'];
            // Ensure the signature is valid, the status code == 2, and that the money is paid to you
            if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2  && $_POST['pay_to_email'] == $skrill->account_email) {
                $invoice_no = $_POST['item_number'];
                $reference = $_POST['item_name'];
                $amount = $_POST['mb_amount'];

                if($inv = $this->payments_model->getInvoiceByID($invoice_no)) { 
                    $note = $_POST['mb_currency'].' '.$_POST['mb_amount'].' had been paid for the Sale No. '.$inv->id.' (Reference No '.$reference.'). Skrill transaction id is '.$_POST['mb_transaction_id'];

                    if($this->payments_model->addPaument($inv->id, $inv->customer_id, $amount, $note)){
                        $this->send_email($skrill->account_email, $inv->id, $inv->customer_id, $amount, $note);
                        $this->log_payment('Payment has been made for Sale Reference #' . $_POST['item_name'] . ' via Skrill ('.$_POST['mb_transaction_id'].').', print_r($_POST, ture));
                    }
                }
            } else {
                $this->log_payment('Payment failed via Skrill, please check manually. ', (!empty($_POST) ? print_r($_POST, ture) : NULL));
                exit;
            }
        } else {
            $this->log_payment('INVALID response from Skrill (no post data received). Payment failed ', (!empty($_POST) ? print_r($_POST, ture) : NULL));
            exit;
        }
    }

    function send_email($email, $invoice_id, $customer_id, $amount, $note) {
        $customer = $this->payments_model->getCustomerByID($customer_id);
        $msg = '<html><body>Hello '.($customer->compnay ? $customer->compnay : $customer->name).', <br><br>'.$note.'<br><br>Thank you<br>'.$this->Settings->site_name.'</body></html>';

        $this->load->library('email');
        //$config['protocol'] = 'sendmail';
        //$config['mailpath'] = '/usr/sbin/sendmail';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from($email);
        $this->email->to($customer->email);
        $this->email->bcc($email);
        $this->email->subject('Payment Received');
        $this->email->message($msg);
        $this->email->send();
    }

    function log_payment($msg, $val = NULL) {
        $this->load->library('logs');
        return (bool) $this->logs->write('payments', $msg, $val);
    }

}
