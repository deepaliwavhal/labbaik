<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -----------------------------------------------------
| PRODUCT NAME: 	SIMPLE INVOICE MANAGER
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			saleem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.com
| -----------------------------------------------------
|
| Model: 			Payments
| -----------------------------------------------------
| This is payments model file.
| -----------------------------------------------------
*/


class Payments_model extends CI_Model
{
	
	
	public function __construct() {
		parent::__construct();

	}
	
	public function getCustomerByID($id) {
		$q = $this->db->get_where('customers', array('id' => $id), 1); 
		if( $q->num_rows() > 0 ) {
			return $q->row();
		} 
		return FALSE;
	}
	
	public function getInvoiceByID($id) {
		$q = $this->db->get_where('sales', array('id' => $id), 1); 
		if( $q->num_rows() > 0 ) {
			return $q->row();
		} 
		return FALSE;
	}

	public function addPaument($invoice_id, $customer_id, $amount, $note = NULL) {
		$inv = $this->getInvoiceByID($invoice_id);
		$total = $inv->total+$inv->shipping;
		$adata = array(
			'date' => date('Y-m-d'),
			'invoice_id' => $invoice_id,
			'customer_id' => $customer_id,
			'amount' => $amount,
			'note' => $note,
			);
		if($this->db->insert('payment', $adata)) {
			$paid = $this->getPaidAmount($invoice_id);
			
			if($paid && $paid >= $total) {
				$this->db->update('sales', array('status' => 'paid'), array('id' => $invoice_id));
				return true;
			} else {
				$this->db->update('sales', array('status' => 'partial'), array('id' => $invoice_id));
				return true;
			}
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

	public function getPaypalSettings() {        
		$q = $this->db->get('paypal'); 
		if( $q->num_rows() > 0 ) {
			return $q->row();
		} 
		return FALSE;
	}

	public function getSkrillSettings() {        
		$q = $this->db->get('skrill'); 
		if( $q->num_rows() > 0 ) {
			return $q->row();
		} 
		return FALSE;
	}
	
	
}
