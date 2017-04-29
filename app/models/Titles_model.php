<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Titles_model extends CI_Model{
    public $tablename='lb_titles';
	function __construct() {
		parent::__construct();
                
	}
	public function getAllPackageTitles() {
		$q = $this->db->get($this->tablename);                
		if($q->num_rows() > 0) {                    
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return FALSE;
	}
}
