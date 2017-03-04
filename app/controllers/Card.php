<?php defined('BASEPATH') or exit('No direct script access allowed');

class Card extends MY_Controller
{

    public function __construct() {
        parent::__construct();
        if ( ! $this->sim->logged_in()) {
            redirect('auth/login');
        }
    }

    public function charge($id = NULL) {
        $stripeToken = $this->input->post('stripeToken');
        $stripeEmail = $this->input->post('stripeEmail');
        if (!$id || !$stripeToken) {
            show_404();
        }
        $inv = $this->getInvoiceByID($id);
        $this->load->model('settings_model');
        $stripe = $this->settings_model->getStripeSettings();
        $biller = $this->settings_model->getCompanyByID($inv->company_id ? $inv->company_id : 1);
        $customer = $this->settings_model->getCustomerByID($inv->customer_id);
        $stripe_fee = 0;
        if (trim(strtolower($customer->country)) == $biller->country) {
            $stripe_fee = $stripe->fixed_charges+($inv->grand_total*$stripe->extra_charges_my/100);
        } else {
            $stripe_fee = $stripe->fixed_charges+($inv->grand_total*$stripe->extra_charges_other/100);
        }

        $description = lang('invoice').' '.lang('no').' '.$id;
        $grand_total = ($inv->grand_total - $inv->paid) + $inv->shipping;
        $amount = (($grand_total+$stripe_fee) * 100);
        if ($stripeToken) {
            $this->load->library('stripe_pay');
            $this->stripe_pay->set_api_key($stripe->secret_key);
            $data = $this->stripe_pay->charge($stripeToken, $description, $amount, $this->Settings->currency_prefix);
            if (isset($data['error']) && !empty($data['error'])) {
                $this->session->set_flashdata('error', $data['message']);
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                if (strtolower($data->currency) == strtolower($this->Settings->currency_prefix)) {
                    $date = date('Y-m-d');
                    $note = lang('cc_pay');
                    $amount = ($data->amount / 100) - $stripe_fee;
                    $adata = array(
                        'date' => $date,
                        'invoice_id' => $inv->id,
                        'customer_id' => $inv->customer_id,
                        'amount' => $amount,
                        'transaction_id' => $data->id,
                        'note' => $note,
                        );
                    if($this->db->insert('payment', $adata)) {
                        $paid = $this->getPaidAmount($inv->id);
                        $total = $inv->total+$inv->shipping;
                        if($paid->amount >= $total) {
                            $this->db->update('sales', array('status' => 'paid', 'paid' => $paid->amount), array('id' => $inv->id));
                        } else {
                            $this->db->update('sales', array('status' => 'partial', 'paid' => $paid->amount), array('id' => $inv->id));
                        }
                    }

                    $this->session->set_flashdata('message', $this->lang->line("amount_added"));
                }
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
    }

    private function getInvoiceByID($id) {
        return $this->db->get_where('sales', array('id' => $id), 1)->row();
    }

    private function getPaidAmount($invoice_id) {
        $this->db->select("COALESCE(sum({$this->db->dbprefix('payment')}.amount), 0) as amount", FALSE);
        return $this->db->get_where('payment', array('invoice_id' => $invoice_id))->row(); 
    }  

}
