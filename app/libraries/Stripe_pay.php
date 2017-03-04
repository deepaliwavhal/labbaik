<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'third_party/stripe/init.php');

class Stripe_pay
{

    protected $private_key;
    public $message = '';
    public $code;
    public $error = FALSE;

    public function __construct() {
    }

    public function __get($var) {
        return get_instance()->$var;
    }

    function set_api_key($private_key) {
        \Stripe\Stripe::setApiKey($private_key);
    }

    public function get_balance() {
        try {
            $bal = \Stripe\Balance::retrieve();
            return array('mode' => ($bal->livemode ? $bal->livemode : 'Test'), 'pending_amount' => ($bal->pending[0]->amount / 100), 'pending_currency' => strtoupper($bal->pending[0]->currency), 'available_amount' => ($bal->available[0]->amount / 100), 'available_currency' => strtoupper($bal->available[0]->currency));
        } catch (Exception $e) {
            $this->error = TRUE;
            $this->message = $e->getMessage();
            $this->code = $e->getCode();
            //return FALSE;
            return array('error' => TRUE, 'code' => $this->code, 'message' => $this->message);
        }
    }

    public function insert($token, $description, $amount, $currency) {
        try {
            $charge = \Stripe\Charge::create(array(
                'amount' => $amount,
                'currency' => $currency,
                'card' => $token,
                'description' => $description
            ));
            return $charge;
        } catch (Exception $e) {
            $this->error = TRUE;
            $this->message = $e->getMessage();
            $this->code = $e->getCode();
            //return FALSE;
            return array('error' => TRUE, 'code' => $this->code, 'message' => $this->message);
        }
    }

    function charge($token, $description, $amount, $currency) {
        return $this->insert($token, $description, $amount, $currency);
    }

}