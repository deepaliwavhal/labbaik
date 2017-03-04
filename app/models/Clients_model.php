<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Clients_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    public function getTotal($customer_id) {
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getPaid($customer_id) {
        $this->db->group_start()->where('status', 'paid')->or_where('status', $this->lang->line('paid'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getPending($customer_id) {
        $this->db->group_start()->where('status', 'pending')->or_where('status', $this->lang->line('pending'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getCancelled($customer_id) {
        $this->db->group_start()->where('status', 'canceled')->or_where('status', $this->lang->line('cancelled'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getOverdue($customer_id) {
        $this->db->group_start()->where('status', 'overdue')->or_where('status', $this->lang->line('overdue'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getPP($customer_id) {
        $this->db->group_start()->where('status', 'partial')->or_where('status', $this->lang->line('partially_paid'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function TPP($customer_id) {
        $this->db->select('COALESCE(sum(grand_total), 0) as total, COALESCE(sum(paid), 0) as paid', false);
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->row();
    }

    public function getCustomerByID($id) {
        $q = $this->db->get_where('customers', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getCompanyByID($id) {
        $q = $this->db->get_where('company', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getAllTaxRates() {
        $q = $this->db->get('tax_rates');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getTaxRateByID($id) {
        $q = $this->db->get_where('tax_rates', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getAllInvoiceTypes() {
        $q = $this->db->get('invoice_types');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getInvoiceTypeByID($id) {
        $q = $this->db->get_where('invoice_types', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getItemByID($id) {
        $q = $this->db->get_where('sale_items', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getAllSales() {
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getmonthlySales() {
        $myQuery = "SELECT date_format( date, '%b' ) as month, SUM( grand_total ) as sales FROM sales WHERE in_type = 'real' AND date >= date_sub( now( ) , INTERVAL 12 MONTH ) GROUP BY date_format( date, '%b' ) ORDER BY date_format( date, '%m' ) ASC";
        $q = $this->db->query($myQuery);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getAllInvoiceItems($sale_id) {
        $this->db->order_by('id');
        $q = $this->db->get_where('sale_items', array('sale_id' => $sale_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getInvoiceByID($id) {
        $q = $this->db->get_where('sales', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getInvoiceBySaleID($sale_id) {
        $q = $this->db->get_where('sales', array('id' => $sale_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getQuoteByID($id) {
        $q = $this->db->get_where('quotes', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getAllQuoteItems($quote_id) {
        $this->db->order_by('id');
        $q = $this->db->get_where('quote_items', array('quote_id' => $quote_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getCompanyDetails() {
        $q = $this->db->get_where('company', array('id' => 1), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function updateCustomer($id, $data = array()) {
        $this->db->where('id', $id);
        if ($this->db->update('customers', $data)) {
            return true;
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

    public function getProductByName($name) {
        $q = $this->db->get_where('products', array('name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getPaypalSettings() {
        $q = $this->db->get('paypal');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getSkrillSettings() {
        $q = $this->db->get('skrill');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getStripeSettings() {        
        $q = $this->db->get('stripe'); 
        if( $q->num_rows() > 0 ) {
            return $q->row();
        } 
        return FALSE;
    }

}
