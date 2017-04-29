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
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			Customers
| -----------------------------------------------------
| This is customers module's model file.
| -----------------------------------------------------
*/


class Packages_model extends CI_Model
{
	
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getAllTitles() {
		$q = $this->db->get('sim_lb_titles');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return FALSE;
	}
	
	public function titles_count() {
		return $this->db->count_all("sim_lb_titles");
	}

	public function fetch_suppliers($limit, $start) {
		$this->db->limit($limit, $start);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get("sim_lb_suppliers");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getTitleByID($id) {
		$q = $this->db->get_where('sim_lb_titles', array('id' => $id), 1); 
		if( $q->num_rows() > 0 ) {
			return $q->row();
		} 
		return FALSE;
	}
	public function addTitle($data = array()) { 
            if($this->db->insert('sim_lb_titles', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateTitle($id, $data = array()) {
           
	   if($this->db->update('sim_lb_titles', $data, array('id' => $id))) {
			return true;
		}else{
                    return false;
            }
	}
	
	public function deleteTitle($id) {
	    if($this->db->delete('sim_lb_titles', array('id' => $id))) {
		
		return true;
	    }else{
		return false;
            }
	}

}
