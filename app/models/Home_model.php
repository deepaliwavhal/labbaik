<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home_model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}
	
	public function getTotal() {
		 if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $this->db->group_start()->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'))->group_end(); } 
		 $q=$this->db->get('sales');
		 return $q->num_rows();
	}
	
	public function getPaid() {
		 if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $this->db->group_start()->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'))->group_end(); } 
		 $this->db->group_start()->where('status', 'paid')->or_where('status', $this->lang->line('paid'))->group_end();
		 $q = $this->db->get('sales');
		 return $q->num_rows();
	}
	
	public function getPending() {
		if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $this->db->group_start()->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'))->group_end(); } 
		$this->db->group_start()->where('status', 'pending')->or_where('status', $this->lang->line('pending'))->group_end();
		$q = $this->db->get('sales');
		 return $q->num_rows();
	}
	
	public function getCancelled() {
		if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $this->db->group_start()->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'))->group_end(); } 
		$this->db->group_start()->where('status', 'canceled')->or_where('status', $this->lang->line('cancelled'))->group_end();
		$q = $this->db->get('sales');
		 return $q->num_rows();
	}
	
	public function getOverdue() {
		if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $this->db->group_start()->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'))->group_end(); } 
		$this->db->group_start()->where('status', 'overdue')->or_where('status', $this->lang->line('overdue'))->group_end();
		$q = $this->db->get('sales');
		 return $q->num_rows();
	}
		
	public function getPP() {
		if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $this->db->group_start()->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'))->group_end(); } 
		$this->db->group_start()->where('status', 'partial')->or_where('status', $this->lang->line('partially_paid'))->group_end();
		$q = $this->db->get('sales');
		 return $q->num_rows();
	}	
	
	public function updatePaidValues() {
		$sales = $this->getAllSales();
		foreach ($sales as $sale) {
			$paid = $this->getPaidAmount($sale->id);
			$this->db->update('sales', array('paid' => $paid), array('id' => $sale->id));
		}
		$this->db->update('settings', array('version' => '3.1.2'), array('setting_id' => 1));
		return TRUE;
	}

	public function getAllSales() {
		$q = $this->db->get('sales');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function getPaidAmount($invoice_id) {
		$this->db->select('COALESCE(sum(amount), 0) as amount', FALSE);
		$q = $this->db->get_where('payment', array('invoice_id' => $invoice_id)); 
		if( $q->num_rows() > 0 ) {
			$da = $q->row();
			return $da->amount;
		} 
		return FALSE;
	}

	
}
