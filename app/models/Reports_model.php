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
| MODULE:             Reports
| -----------------------------------------------------
| This is reports module model file.
| -----------------------------------------------------
 */

class Reports_model extends CI_Model
{

    public function __construct() {
        parent::__construct();

    }

    public function getAllProducts() {
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllStaff() {
        $q = $this->db->get_where('users', array('customer_id' => null));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getDailySales($year, $month) {
        $this->db->select("date AS date, SUM( COALESCE( total, 0 ) ) AS inv_total, SUM( COALESCE( total_tax, 0 ) ) as tax, sum( COALESCE(grand_total, 0) ) as total, SUM( COALESCE( paid, 0 ) ) as paid", false)
             ->from('sales')
             ->where('status !=', 'canceled')->where("DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'", null, false)
             ->group_by('DATE_FORMAT( date, \'%Y-%m-%d\' )');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getMonthlySales($year) {
        $this->db->select('date, SUM( COALESCE( total, 0 ) ) AS inv_total, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_tax, 0 ) ) as tax, SUM( COALESCE( paid, 0 ) ) as paid', false)
             ->from('sales')
             ->where('status !=', 'canceled')->where("DATE_FORMAT( date,  '%Y' ) =  '{$year}'", null, false)
             ->group_by('DATE_FORMAT( date, \'%Y-%m\' )')
             ->order_by('date_format( date, \'%c\' ) ASC');
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllCustomers() {
        $q = $this->db->get('customers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllSuppliers() {
        $q = $this->db->get('suppliers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getTotal($customer_id) {
        if ($this->Settings->restrict_sales && !$this->sim->in_group('admin')) {$this->db->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'));}
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getPaid($customer_id) {
        if ($this->Settings->restrict_sales && !$this->sim->in_group('admin')) {$this->db->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'));}
        $this->db->group_start()->where('status', 'paid')->or_where('status', $this->lang->line('paid'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getPending($customer_id) {
        if ($this->Settings->restrict_sales && !$this->sim->in_group('admin')) {$this->db->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'));}
        $this->db->group_start()->where('status', 'pending')->or_where('status', $this->lang->line('pending'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getCancelled($customer_id) {
        if ($this->Settings->restrict_sales && !$this->sim->in_group('admin')) {$this->db->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'));}
        $this->db->group_start()->where('status', 'canceled')->or_where('status', $this->lang->line('cancelled'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getOverdue($customer_id) {
        if ($this->Settings->restrict_sales && !$this->sim->in_group('admin')) {$this->db->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'));}
        $this->db->group_start()->where('status', 'overdue')->or_where('status', $this->lang->line('overdue'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function getPP($customer_id) {
        if ($this->Settings->restrict_sales && !$this->sim->in_group('admin')) {$this->db->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'));}
        $this->db->group_start()->where('status', 'partial')->or_where('status', $this->lang->line('partially_paid'))->group_end();
        $q = $this->db->get_where('sales', array('customer_id' => $customer_id));
        return $q->num_rows();
    }

    public function TPP($customer_id) {
        if ($this->Settings->restrict_sales && !$this->sim->in_group('admin')) {$this->db->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'));}
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
    

}
