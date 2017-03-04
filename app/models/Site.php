<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_setting() {
        $q = $this->db->get('settings');
        if($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getDateFormat($id) {
        $q = $this->db->get_where('date_format', array('id' => $id), 1);
        if($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getUser($id = NULL) {
        if(!$id) { $id = $this->session->userdata('user_id'); }
        $q = $this->db->get_where('users', array('id' => $id), 1);
        if($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getProductByID($id) {
        $q = $this->db->get_where('products', array('id' => $id), 1);
        if($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function modal_js() {
        return '<script type="text/javascript">' . read_file($this->data['assets'] . 'js/modal.js') . '</script>';
    }

    public function getUpcomingEvents() {
        $dt = date('Y-m-d');
        $this->db->where('start >=', $dt)->order_by('start')->limit(5);
        if ($this->Settings->calendar) {
            $this->db->where('user_id', $this->session->userdata('user_id'));
        }

        $q = $this->db->get('calendar');

        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getUserGroup($user_id = NULL) {
        if(!$user_id) { $user_id = $this->session->userdata('user_id'); }
        if($group_id = $this->getUserGroupID($user_id)) {
            $q = $this->db->get_where('groups', array('id' => $group_id), 1);
            if($q->num_rows() > 0) {
                return $q->row();
            }
        }
        return FALSE;
    }

    public function getGroupByUID($user_id = NULL) {
        if(!$user_id) { $user_id = $this->session->userdata('user_id'); }
        $q = $this->db->get_where('users_groups', array('user_id' => $user_id), 1);
        if($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getUserGroupID($user_id = NULL) {
        if($group = $this->getGroupByUID($user_id)) {
            return $group->group_id;
        }
        return FALSE;
    }

}

/* End of file site.php */ 
/* Location: ./application/models/site.php */
