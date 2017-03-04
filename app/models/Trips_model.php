<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Trips_model extends CI_Model
{
        public $tablename='lb_trips';
	function __construct() {
		parent::__construct();
                
	}
	
	public function getTotal() {
            if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $this->db->group_start()->where('user', $this->session->userdata('user_id'))->or_where('user', $this->session->userdata('first_name'))->group_end(); } 
		 $q=$this->db->get($this->tablename);
		 return $q->num_rows();
	}
	
        public function deleteTrip($id) {
		if($this->db->delete($this->tablename, array('t_id' => $id))) {
			return true;
		}
		return FALSE;
	}
        public function addTrip($data = array()) {
		if($this->db->insert($this->tablename, $data)) {
			return true;
		} else {
			return false;
		}
	}
        
        public function getTripByID($id) {
		$q = $this->db->get_where($this->tablename, array('t_id' => $id), 1); 
		if( $q->num_rows() > 0 ) {
			return $q->row();
		} 
		return FALSE;
	}
        
        public function updateTrip($id, $data = array())
	{		
		$this->db->where('t_id', $id);
		if($this->db->update($this->tablename, $data)) {
			return true;
		} else {
			return false;
		}
	}
	
}
