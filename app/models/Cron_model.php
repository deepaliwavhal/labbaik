<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
| -----------------------------------------------------
| PRODUCT NAME:     SIMPLE INVOICE MANAGER
| -----------------------------------------------------
| AUTHER:            MIAN SALEEM
| -----------------------------------------------------
| EMAIL:            saleem@tecdiary.com
| -----------------------------------------------------
| COPYRIGHTS:        RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:            http://tecdiary.com
| -----------------------------------------------------
|
| Model:             Corn
| -----------------------------------------------------
| This is corn model file.
| -----------------------------------------------------
 */

class Cron_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    public function getAllRecurringInvoices($company) {
        $q = $this->db->get_where('sales', array('company_id' => $company, 'recurring >=' => 1));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllDueInvoices($company) {
        $today = date('Y-m-d');
        $this->db->where('company_id', $company)
        ->where('status !=', 'paid')
        ->where('status !=', 'canceled')
        ->where('due_date <=', $today);
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function updateInvoiceStatus($id) {
        if ($this->db->update('sales', array('status' => 'overdue'), array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function createInvoice($id, $rd) {
        $today = date('Y-m-d');
        $invoice = $this->getInvoiceByID($id);
        if ( ! $this->getInvoiceByDR($today, $invoice['reference_no'])) {
            unset($invoice['id']);
            if ($invoice['due_date'] && $invoice['due_date'] != $invoice['date']) {
                $inv_date = strtotime($invoice['date']);
                $inv_due = strtotime($invoice['due_date']);
                $datediff = $inv_due - $inv_date;
                $daysdiff = ceil($datediff / (60 * 60 * 24));
                $days = ($daysdiff == 1) ? '+'.$daysdiff.' day' : '+'.$daysdiff.' days';
                $invoice['due_date'] = date('Y-m-d', strtotime($days));
            } else {
                $invoice['due_date'] = $today;
            }
            $invoice['date'] = $today;
            $invoice['status'] = 'pending';
            $invoice['recurring'] = -1;
            $invoice['recur_date'] = NULL;
            $items = $this->getAllInvoiceItems($id);
            if ($this->db->insert('sales', $invoice)) {
                $sale_id = $this->db->insert_id();
                foreach ($items as $item) {
                    unset($item['id']);
                    $item['sale_id'] = $sale_id;
                    $this->db->insert('sale_items', $item);
                }
                $recur_date = ($rd >= $today) ? $rd : $today;
                $this->db->update('sales', array('recur_date' => $recur_date), array('id' => $id));
                return $sale_id;
            }
        }
        return false;
    }

    public function getInvoiceByID($id) {
        $q = $this->db->get_where('sales', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return false;
    }

    public function getInvoiceByDR($date, $ref) {
        $q = $this->db->get_where('sales', array('date' => $date, 'reference_no' => $ref), 1);
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return false;
    }

    public function getAllInvoiceItems($sale_id) {
        $this->db->order_by('id');
        $q = $this->db->get_where('sale_items', array('sale_id' => $sale_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result_array()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllSellers() {
        $q = $this->db->get('company');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getCustomerByID($id) {
        $q = $this->db->get_where('customers', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getPaymentBySaleID($sale_id) {
        $this->db->order_by('id');
        $q = $this->db->get_where('payment', array('invoice_id' => $sale_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getPaidAmount($invoice_id) {
        $this->db->select('COALESCE(sum(amount), 0) as amount', false);
        $q = $this->db->get_where('payment', array('invoice_id' => $invoice_id));
        if ($q->num_rows() > 0) {
            $da = $q->row();
            return $da->amount;
        }
        return false;
    }


}
