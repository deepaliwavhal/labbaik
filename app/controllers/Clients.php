<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends MY_Controller {

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
| MODULE: 			Clients
| -----------------------------------------------------
| This is clients module controller file.
| -----------------------------------------------------
*/


	function __construct() {
		parent::__construct();

		if (!$this->sim->logged_in()) {
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			redirect('login');
		}

		$this->load->library('form_validation');
		$this->load->model('clients_model');
		define('WORDS_LANG', 'en_US');
		$this->load->library('mywords');
		$this->mywords->load('Numbers/Words');
		$this->data['message'] = $this->session->flashdata('message');
	}

	function index() {

		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
			$this->session->set_userdata('customer_id', $customer_id);
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}
		$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		$this->data['cus'] = $this->clients_model->getCustomerByID($customer_id); 
		$this->data['tpp'] = $this->clients_model->TPP($customer_id); 
		$this->data['total'] = $this->clients_model->getTotal($customer_id); 
		$this->data['paid'] = $this->clients_model->getPaid($customer_id); 
		$this->data['cancelled'] = $this->clients_model->getCancelled($customer_id); 
		$this->data['overdue'] = $this->clients_model->getOverdue($customer_id); 
		$this->data['pending'] = $this->clients_model->getPending($customer_id);
		$this->data['pp'] = $this->clients_model->getPP($customer_id);
		$this->data['page_title'] = $this->lang->line("dashboard");
		$this->load->view($this->theme.'clients/header', $this->data);
		$this->load->view($this->theme.'clients/index', $this->data);
		$this->load->view($this->theme.'clients/footer');

	}

	function sales() {

		$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		
		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}

		$this->data['customer_id'] = $customer_id;
		$this->data['page_title'] = $this->lang->line("invoices");
		$this->load->view($this->theme.'clients/header', $this->data);
		$this->load->view($this->theme.'clients/sales', $this->data);
		$this->load->view($this->theme.'clients/footer');
	}

	function get_sales() {

		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}

		$this->load->library('datatables');
		$this->datatables
		->select("{$this->db->dbprefix('sales')}.id as sid, date, company_name, reference_no, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as user, customer_name, grand_total, paid, grand_total-COALESCE(paid, 0) as balance, due_date, status", FALSE)
		->from('sales')
		->join('users', 'users.id=sales.user', 'left')
		->group_by('sales.id');

		if($customer_id) { $this->datatables->where("{$this->db->dbprefix('sales')}.customer_id", $customer_id); }	

		$this->datatables->edit_column('status', '$1-$2', 'status, id');

		echo $this->datatables->generate();
	}

	function quotes() {

		$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		
		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}

		$this->data['customer_id'] = $customer_id;
		$this->data['page_title'] = $this->lang->line("quotes");
		$this->load->view($this->theme.'clients/header', $this->data);
		$this->load->view($this->theme.'clients/quotes', $this->data);
		$this->load->view($this->theme.'clients/footer');

	}

	function get_quotes() {

		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}

		$this->load->library('datatables');
		$this->datatables
		->select("{$this->db->dbprefix('quotes')}.id as id, date, company_name, reference_no, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as user, customer_name, total, total_tax, COALESCE(shipping, 0) as shipping, COALESCE(total_discount, 0) as discount, grand_total, expiry_date, {$this->db->dbprefix('quotes')}.customer_id as cid", FALSE)
		->from('quotes')
		->join('users', 'users.id=quotes.user', 'left')
		->group_by('quotes.id')
		->where('quotes.customer_id', $customer_id)	
		->unset_column('cid');

		if($customer_id) { $this->datatables->where("{$this->db->dbprefix('quotes')}.customer_id", $customer_id); }	

		echo $this->datatables->generate();

	}

	function change_password() {
		
		$this->user_check();
		
		$this->form_validation->set_rules('old', $this->lang->line("old_pw"), 'required');
		$this->form_validation->set_rules('new', $this->lang->line("new_pw"), 'required|min_length[8]|max_length[25]|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line("confirm_pw"), 'required');

		$user = $this->site->getUser();

		if ($this->form_validation->run() == false) { 
			
			if (DEMO) {
				$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
				redirect('clients');
			}
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
				);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{8}.*$',
				);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{8}.*$',
				);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
				);

			$this->data['page_title'] = $this->lang->line("change_password");
			$this->load->view($this->theme.'clients/header', $this->data);
			$this->load->view($this->theme.'clients/change_password', $this->data);
			$this->load->view($this->theme.'clients/footer');
			
		} else {

			$this->load->library('ion_auth');
			$identity = 'email';
			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change) {
				$logout = $this->ion_auth->logout();
				$this->session->set_flashdata('message', $this->lang->line('password_changed'));
				redirect('auth/login');
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password');
			}
		}
	}

	public function user_check() {
		if (!$this->sim->logged_in()) {
			$this->session->set_flashdata('message', "Login Required!");
			redirect('auth/login');
		}
	}

	function company_details() {

		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|min_length[9]|max_length[16]');

		if ($this->form_validation->run() == true) {
			$data = array(
				'email' => $this->input->post('email'),
				'cf1' => $this->input->post('cf1'),
				'cf2' => $this->input->post('cf2'),
				'cf3' => $this->input->post('cf3'),
				'cf4' => $this->input->post('cf4'),
				'cf5' => $this->input->post('cf5'),
				'cf6' => $this->input->post('cf6'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'postal_code' => $this->input->post('postal_code'),
				'country' => $this->input->post('country'),
				'phone' => $this->input->post('phone')
				);
		}

		if ( $this->form_validation->run() == true && $this->clients_model->updateCustomer($customer_id, $data)) { 

			$this->session->set_flashdata('message', $this->lang->line("company_updated"));
			redirect("clients/company_details");

		} else { 
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['customer'] = $this->clients_model->getCustomerByID($customer_id);
			$this->data['id'] = $customer_id;
			$this->data['page_title'] = $this->lang->line("company_details");
			$this->load->view($this->theme.'clients/header', $this->data);
			$this->load->view($this->theme.'clients/company_details', $this->data);
			$this->load->view($this->theme.'clients/footer');
		}
	}

	function view_invoice() {

		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}

		if($this->input->get('id')){ $sale_id = $this->input->get('id'); } else { $sale_id = NULL; }

		$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		$this->data['rows'] = $this->clients_model->getAllInvoiceItems($sale_id);
		$inv = $this->clients_model->getInvoiceBySaleID($sale_id);
		if($inv->customer_id != $customer_id) {
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			redirect("clients");
		}
		$customer_id = $inv->customer_id;
		$bc = $inv->company_id ? $inv->company_id : 1;
		$this->data['biller'] = $this->clients_model->getCompanyByID($bc);
		$this->data['customer'] = $this->clients_model->getCustomerByID($customer_id);
		$this->data['payment'] = $this->clients_model->getPaymentBySaleID($sale_id);
		$this->data['paid'] = $this->clients_model->getPaidAmount($sale_id);
		$this->data['inv'] = $inv;
		$this->data['sid'] = $sale_id; 
		$this->data['client'] = true;
		$this->data['paypal'] = $this->clients_model->getPaypalSettings();
		$this->data['skrill'] = $this->clients_model->getSkrillSettings();
		$this->data['stripe'] = $this->clients_model->getStripeSettings();
		$this->data['page_title'] = $this->lang->line("invoice");
		$this->load->view($this->theme.'sales/view_invoice_modal', $this->data);

	}

	function view_quote() {

		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}

		if($this->input->get('id')){ $quote_id = $this->input->get('id'); } else { $quote_id = NULL; }

		$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		$this->data['rows'] = $this->clients_model->getAllQuoteItems($quote_id);
		$inv = $this->clients_model->getQuoteByID($quote_id);
		if($inv->customer_id != $customer_id) {
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			redirect("clients");
		}
		$customer_id = $inv->customer_id;
		$bc = $inv->company_id ? $inv->company_id : 1;
		$this->data['biller'] = $this->clients_model->getCompanyByID($bc);
		$this->data['customer'] = $this->clients_model->getCustomerByID($customer_id);
		$this->data['inv'] = $inv;
		$this->data['sid'] = $quote_id; 
		$this->data['client'] = true;
		$this->data['page_title'] = $this->lang->line("quote");
		$this->load->view($this->theme.'sales/view_quote_modal', $this->data);

	}

	function pdf($save_bufffer = NULL) {

		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}

		if($this->input->get('id')){ $sale_id = $this->input->get('id'); } else { $sale_id = NULL; }

		$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		$this->data['rows'] = $this->clients_model->getAllInvoiceItems($sale_id);
		$inv = $this->clients_model->getInvoiceBySaleID($sale_id);
		$customer_id = $inv->customer_id;
		$bc = $inv->company_id ? $inv->company_id : 1;
		$this->data['biller'] = $this->clients_model->getCompanyByID($bc);
		$this->data['customer'] = $this->clients_model->getCustomerByID($customer_id);
		$this->data['payment'] = $this->clients_model->getPaymentBySaleID($sale_id);
		$this->data['paid'] = $this->clients_model->getPaidAmount($sale_id);
		$this->data['inv'] = $inv;
		$this->data['sid'] = $sale_id;
		$this->data['page_title'] = $this->lang->line("invoice");

		$html =  $this->load->view($this->theme.'sales/view_invoice', $this->data, TRUE);
		$name = $this->lang->line("invoice")." ".$this->lang->line("no")." ".$inv->id.".pdf";
		// $search = array("<div id=\"wrap\">", "<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">", "<div class=\"span4\">", "<div class=\"span4 offset3\">", "<div class=\"span4 pull-left\">", "<div class=\"span4 pull-right\">");
		// $replace = array("<div style='padding:0;'>", "<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>");
		// $html = str_replace($search, $replace, $html);

		if($save_bufffer) {
			return $this->sim->generate_pdf($html, $name, $save_bufffer);
		} else {
			$this->sim->generate_pdf($html, $name);
		}	

	}

	function pdf_quote() {

		if($this->sim->in_group('admin')) {
			$customer_id = $this->input->get('customer_id') ? $this->input->get('customer_id') : $this->session->userdata('customer_id');
		} else {
			$customer_id = $this->session->userdata('customer_id');
		}
		if($this->input->get('id')){ $quote_id = $this->input->get('id'); } else { $quote_id = NULL; }

		$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		$this->data['rows'] = $this->clients_model->getAllQuoteItems($quote_id);
		$inv = $this->clients_model->getQuoteByID($quote_id);
		$customer_id = $inv->customer_id;
		$bc = $inv->company_id ? $inv->company_id : 1;
		$this->data['biller'] = $this->clients_model->getCompanyByID($bc);
		$this->data['customer'] = $this->clients_model->getCustomerByID($customer_id);
		$this->data['inv'] = $inv;
		$this->data['page_title'] = $this->lang->line("quote");

		$html =  $this->load->view($this->theme.'sales/view_quote', $this->data, TRUE);
		$name = $this->lang->line("quote")." ".$this->lang->line("no")." ".$inv->id.".pdf";
		// $search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span2\">", "<div class=\"span10\">", "<div class=\"span4\">", "<div class=\"span4 offset3\">", "<div class=\"span4 pull-left\">", "<div class=\"span4 pull-right\">");
		// $replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 18%; float: left;'>", "<div style='width: 78%; float: left;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>");
		// $html = str_replace($search, $replace, $html);

		if($save_bufffer) {
			return $this->sim->generate_pdf($html, $name, $save_bufffer);
		} else {
			$this->sim->generate_pdf($html, $name);
		}

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