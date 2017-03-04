<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cron_model');
        define('WORDS_LANG', 'en_US');
        $this->load->library('mywords');
        $this->mywords->load('Numbers/Words');
    }

    public function index($action = null)
    {
        show_404();
    }

    public function run()
    {
        $today = date('Y-m-d');
        $res = '';
        $sellers = $this->cron_model->getAllSellers();
        foreach ($sellers as $seller) {

            $due_invoices = $this->cron_model->getAllDueInvoices($seller->id);
            $di = 0;
            if (!empty($due_invoices)) {
                foreach ($due_invoices as $due_inv) {
                    if ($due_inv->due_date && $due_inv->due_date != $due_inv->date && $due_inv->due_date < $today) {
                        $this->cron_model->updateInvoiceStatus($due_inv->id);
                        $this->email_invoice($due_inv->id);
                        $di++;
                    }
                }
            }
            $recurring_invoices = $this->cron_model->getAllRecurringInvoices($seller->id);
            $ri = 0;
            if (!empty($recurring_invoices)) {
                foreach ($recurring_invoices as $rec_inv) {
                    if ($rec_inv->recurring == 1) {
                        $rd = date('Y-m-d', strtotime('now', strtotime($rec_inv->recur_date)));
                        if ($today >= $rd) {
                            $this->create_send($rec_inv->id, $rd);
                        }
                    } elseif ($rec_inv->recurring == 2) {
                        $rd = date('Y-m-d', strtotime('+7 days', strtotime($rec_inv->recur_date)));
                        if ($today >= $rd) {
                            $this->create_send($rec_inv->id, $rd);
                        }
                    } elseif ($rec_inv->recurring == 3) {
                        $rd = date('Y-m-d', strtotime('+1 month', strtotime($rec_inv->recur_date)));
                        if ($today >= $rd) {
                            $this->create_send($rec_inv->id, $rd);
                        }
                    } elseif ($rec_inv->recurring == 4) {
                        $rd = date('Y-m-d', strtotime('+3 months', strtotime($rec_inv->recur_date)));
                        if ($today >= $rd) {
                            $this->create_send($rec_inv->id, $rd);
                        }
                    } elseif ($rec_inv->recurring == 5) {
                        $rd = date('Y-m-d', strtotime('+6 months', strtotime($rec_inv->recur_date)));
                        if ($today >= $rd) {
                            $this->create_send($rec_inv->id, $rd);
                        }
                    } elseif ($rec_inv->recurring == 6) {
                        $rd = date('Y-m-d', strtotime('+1 year', strtotime($rec_inv->recur_date)));
                        if ($today >= $rd) {
                            $this->create_send($rec_inv->id, $rd);
                        }
                    } elseif ($rec_inv->recurring == 7) {
                        $rd = date('Y-m-d', strtotime('+2 years', strtotime($rec_inv->recur_date)));
                        if ($today >= $rd) {
                            $this->create_send($rec_inv->id, $rd);
                        }
                    }
                }
            }
            $this->email_details($seller->company, $seller->name, $seller->email, $di, $ri);
            $res .= "<p><strong>" . $seller->company . "</strong><br>" . $di . " invoices' status has been updated to <strong>overdue</strong><br>" .
                $ri . " invoices has been created.<p>";
        }
        echo $res;
    }

    private function create_send($id, $rd)
    {
        if ($iid = $this->cron_model->createInvoice($id, $rd)) {
            $this->email_invoice($iid);
            $ri++;
        }
    }

    public function email_details($company, $name, $email, $di, $ri)
    {
        $note = $di . " invoices' status has been updated to <strong>overdue</strong><br>";
        $note .= $ri . " invoices has been created.<br>";
        $msg = '<html><body>Hello ' . $name . ' (' . $company . '),<br><br>The cron job has successfully run and<br><br>' . $note . '<br>Thank you<br>' . $this->Settings->site_name . '</body></html>';
        $this->sim->send_email($email, 'Cron job results for ' . $this->Settings->site_name, $msg, $email);
    }

    public function email_invoice($sale_id)
    {

        $this->load->model('sales_model');
        $inv = $this->sales_model->getInvoiceByID($sale_id);

        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($sale_id);
        $customer_id = $inv->customer_id;
        $bc = isset($inv->company) ? $inv->company : 1;
        $biller = $this->sales_model->getCompanyByID($bc);
        $customer = $this->sales_model->getCustomerByID($customer_id);
        $payment = $this->sales_model->getPaymentBySaleID($sale_id);
        $paid = $this->sales_model->getPaidAmount($sale_id);
        $this->data['inv'] = $inv;
        $this->data['sid'] = $sale_id;
        $this->data['biller'] = $biller;
        $this->data['customer'] = $customer;
        $this->data['payment'] = $payment;
        $this->data['paid'] = $paid;

        $to = $customer->email;
        $subject = $this->lang->line('invoice_from') . ' ' . $biller->company;
        $note = $this->lang->line("find_attached_invoice");

        $this->data['page_title'] = $this->lang->line("invoice");

        $html = $this->load->view($this->theme . 'sales/view_invoice', $this->data, true);
        $name = $this->lang->line("invoice") . " " . $this->lang->line("no") . " " . $inv->id . ".pdf";

        $search = array("<div id=\"wrap\">", "<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">", "<div class=\"span4\">", "<div class=\"span4 offset3\">", "<div class=\"span4 pull-left\">", "<div class=\"span4 pull-right\">");
        $replace = array("<div style='padding:0;'>", "<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>");

        $html = str_replace($search, $replace, $html);

        $email_data = $this->load->view($this->theme . 'sales/view_invoice', $this->data, true);
        $email_data = str_replace($search, $replace, $email_data);
        $grand_total = ($inv->total - $paid) + $inv->shipping;
        $paypal = $this->sales_model->getPaypalSettings();
        $skrill = $this->sales_model->getSkrillSettings();
        $btn_code = '<br><br><div id="payment_buttons" class="text-center margin010">';
        if ($paypal->active == "1" && $grand_total != "0.00") {
            if (trim(strtolower($customer->country)) == $biller->country) {
                $paypal_fee = $paypal->fixed_charges + ($grand_total * $paypal->extra_charges_my / 100);
            } else {
                $paypal_fee = $paypal->fixed_charges + ($grand_total * $paypal->extra_charges_other / 100);
            }
            $btn_code .= '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' . $paypal->account_email . '&item_name=' . $inv->reference_no . '&item_number=' . $inv->id . '&image_url=' . base_url() . 'uploads/logos/' . $this->Settings->logo . '&amount=' . (($grand_total - $inv->paid) + $paypal_fee) . '&no_shipping=1&no_note=1&currency_code=' . $this->Settings->currency_prefix . '&bn=FC-BuyNow&rm=2&return=' . site_url('clients/sales') . '&cancel_return=' . site_url('clients/sales') . '&notify_url=' . site_url('payments/paypalipn') . '&custom=' . $inv->reference_no . '__' . ($grand_total - $inv->paid) . '__' . $paypal_fee . '"><img src="' . base_url('assets/img/btn-paypal.png') . '" alt="Pay by PayPal"></a> ';
        }
        if ($skrill->active == "1" && $grand_total != "0.00") {
            if (trim(strtolower($customer->country)) == $biller->country) {
                $skrill_fee = $skrill->fixed_charges + ($grand_total * $skrill->extra_charges_my / 100);
            } else {
                $skrill_fee = $skrill->fixed_charges + ($grand_total * $skrill->extra_charges_other / 100);
            }
            $btn_code .= ' <a href="https://www.moneybookers.com/app/payment.pl?method=get&pay_to_email=' . $skrill->account_email . '&language=EN&merchant_fields=item_name,item_number&item_name=' . $inv->reference_no . '&item_number=' . $inv->id . '&logo_url=' . base_url() . 'uploads/logos/' . $this->Settings->logo . '&amount=' . (($grand_total - $inv->paid) + $skrill_fee) . '&return_url=' . site_url('clients/sales') . '&cancel_url=' . site_url('clients/sales') . '&detail1_description=' . $inv->reference_no . '&detail1_text=Payment for the sale invoice ' . $inv->reference_no . ': ' . $grand_total . '(+ fee: ' . $skrill_fee . ') = ' . $this->sim->formatDecimal($grand_total + $skrill_fee) . '&currency=' . $this->Settings->currency_prefix . '&status_url=' . site_url('payments/skrillipn') . '"><img src="' . base_url('assets/img/btn-skrill.png') . '" alt="Pay by Skrill"></a>';
        }

        $btn_code .= '<div class="clearfix"></div></div>';

        $note = $note . $btn_code;
        if ($this->Settings->email_html) {
            if ($note) {$message = $note . "<br /><hr>" . $email_data;} else { $message = $email_data;}
        } else {
            $message = $note;
        }

        $attachment = $this->sim->generate_pdf($html, $name, 'S');
        if ($this->sim->send_email($to, $subject, $message, null, null, $attachment, $cc, $bcc)) {
            unlink($attachment);
            return true;
        } else {
            return false;
        }

    }

    public function log_cron($msg, $val = null)
    {
        $this->load->library('logs');
        return (bool) $this->logs->write('cron', $msg, $val);
    }

}
