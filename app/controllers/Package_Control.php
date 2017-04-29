<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package_Control extends MY_Controller {
    function __construct()
	{            
		parent::__construct();

		if (!$this->sim->logged_in()) {
			redirect('auth/login');
		}
		if($this->sim->in_group('customer')) {
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			redirect('clients');
		}
                $this->load->library('form_validation');
		$this->load->model('titles_model');
	}
        
    function index(){
        $this->data['page_title'] = $this->lang->line("package_control");
        $this->data['package_titles'] = $this->titles_model->getAllPackageTitles();
        $this->page_construct('package_control/index', $this->data);
    }
}
