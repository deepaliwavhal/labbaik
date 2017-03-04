<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

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
| MODULE: 			Homepage / Dashboard
| -----------------------------------------------------
| This is homepage module controller file.
| -----------------------------------------------------
*/


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

		$this->load->model('home_model');	

	}

	function index()
	{

		$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		$user = $this->site->getUser();	
		$this->data['name'] = $user->first_name." (".$user->email.") ";
		$this->data['total'] = $this->home_model->getTotal(); 
		$this->data['paid'] = $this->home_model->getPaid(); 
		$this->data['cancelled'] = $this->home_model->getCancelled(); 
		$this->data['overdue'] = $this->home_model->getOverdue(); 
		$this->data['pending'] = $this->home_model->getPending();
		$this->data['pp'] = $this->home_model->getPP();
		$meta['page_title'] = $this->lang->line("welcome")." ".$this->Settings->site_name."!";
		$this->data['page_title'] = $this->lang->line("welcome")." ".$this->Settings->site_name."!";
		$this->page_construct('home', $this->data);

	}

	function language($lang = false) {
		if($this->input->get('lang')){ $lang = $this->input->get('lang'); }
		$folder = 'app/language/';
		$languagefiles = scandir($folder);
		if(in_array($lang, $languagefiles)){
			$cookie = array(
				'name'   => 'language',
				'value'  => $lang,
				'expire' => '31536000',
				'prefix' => 'sim_',
				'secure' => false
				);
			$this->input->set_cookie($cookie);
		}
		redirect($_SERVER["HTTP_REFERER"]); 
	}

}

