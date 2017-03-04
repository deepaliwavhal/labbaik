<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MY_Controller {

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
| MODULE: 			SETTINGS
| -----------------------------------------------------
| This is setting module controller file.
| -----------------------------------------------------
*/


	function __construct()
	{
		parent::__construct();

		if (!$this->sim->logged_in()) {
			redirect('auth/login');
		}

		if (!$this->sim->in_group('admin')) {
			$this->session->set_flashdata('error', $this->lang->line('access_denied'));
			redirect('home');
		}

		$this->load->library('form_validation');
		$this->load->model('settings_model');
		$this->data['message'] = $this->session->flashdata('message');
	}

	function index() {
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['page_title'] = $this->lang->line('setting');
		$this->page_construct('content', $this->data);

	}

	function system_setting() {

		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
		$this->form_validation->set_rules('site_name', $this->lang->line('site_name'), 'required');
		$this->form_validation->set_rules('language', $this->lang->line('language'), 'required');
		$this->form_validation->set_rules('currency_prefix', $this->lang->line('currency_code'), 'required|max_length[3]');
		$this->form_validation->set_rules('tax_rate', $this->lang->line('default_tax_rate'), 'required');
		$this->form_validation->set_rules('rows_per_page', $this->lang->line('rows_per_page'), 'required|greater_than[9]|less_than[501]');
		$this->form_validation->set_rules('no_of_rows', $this->lang->line('no_of_rows'), 'required|greater_than[0]|less_than[50]');
		$this->form_validation->set_rules('date_format', $this->lang->line('date_format'), 'required');
		$this->form_validation->set_rules('print_payment', $this->lang->line('print_payment_on_invoice'), 'required');
		$this->form_validation->set_rules('display_words', $this->lang->line('display_to_words'), 'required');
		$this->form_validation->set_rules('calendar', $this->lang->line('calendar'), 'required');
		$this->form_validation->set_rules('restrict_sales', $this->lang->line('restrict_sales'), 'required');
		$this->form_validation->set_rules('email', $this->lang->line('default_email'), 'required');
		$this->form_validation->set_rules('protocol', $this->lang->line('protocol'), 'required');
		$this->form_validation->set_rules('decimals', $this->lang->line('decimals'), 'required');
		$this->form_validation->set_rules('decimals_sep', $this->lang->line('decimals_sep'), 'required');
		$this->form_validation->set_rules('thousands_sep', $this->lang->line('thousands_sep'), 'required');
		if($this->input->post('protocol') == 'smtp') {
			$this->form_validation->set_rules('smtp_host', lang('smtp_host'), 'required');
			$this->form_validation->set_rules('smtp_user', lang('smtp_user'), 'required');
			$this->form_validation->set_rules('smtp_pass', lang('smtp_pass'), 'required');
			$this->form_validation->set_rules('smtp_port', lang('smtp_port'), 'required');
		}
		if($this->input->post('protocol') == 'sendmail') {
			$this->form_validation->set_rules('mailpath', lang('mailpath'), 'required');
		}

		if ($this->form_validation->run() == true) {
			$this->load->library('encrypt');
			$data = array(
				'site_name' => DEMO ? 'Invoice Manager' : $this->input->post('site_name'),
				'language' => $this->input->post('language'),
				'currency_prefix' => DEMO ? 'USD' : $this->input->post('currency_prefix'),
				'default_tax_rate' => $this->input->post('tax_rate'),
				'rows_per_page' => $this->input->post('rows_per_page'),
				'no_of_rows' => $this->input->post('no_of_rows'),
				'dateformat' => $this->input->post('date_format'),
				'print_payment' => $this->input->post('print_payment'),
				'calendar' => $this->input->post('calendar'),
				'restrict_sales' => $this->input->post('restrict_sales'),
				'major' => $this->input->post('major'),
				'minor' => $this->input->post('minor'),
				'display_words' => $this->input->post('display_words'),
				'customer_user' => $this->input->post('customer_user'),
				'email_html' => $this->input->post('email_html'),
				'default_email' =>DEMO ? 'noreply@sim.tecdiary.my' :  $this->input->post('email'),
				'protocol' => DEMO ? 'mail' : $this->input->post('protocol'),
				'mailpath' => $this->input->post('mailpath'),
				'smtp_host' => $this->input->post('smtp_host'),
				'smtp_user' => $this->input->post('smtp_user'),
				'smtp_port' => $this->input->post('smtp_port'),
				'smtp_pass' => $this->encrypt->encode($this->input->post('smtp_pass')),
				'smtp_crypto' => $this->input->post('smtp_crypto') ? $this->input->post('smtp_crypto') : NULL,
				'decimals' => $this->input->post('decimals'),
				'decimals_sep' => $this->input->post('decimals_sep'),
				'thousands_sep' => $this->input->post('thousands_sep'),
				'theme' => $this->input->post('theme'),
				'product_discount' => $this->input->post('product_discount'),
				);
		}

		if ( $this->form_validation->run() == true && $this->settings_model->updateSetting($data)) {

			$this->session->set_flashdata('message', $this->lang->line('setting_updated'));
			redirect("settings/system_setting");

		} else {
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['message'] = $this->session->flashdata('message');
			$this->data['date_formats'] = $this->settings_model->getDateFormats(); 
			$this->data['tax_rates'] = $this->settings_model->getAllTaxRates();
			$this->data['page_title'] = $this->lang->line('system_setting');
			$this->page_construct('settings/index', $this->data);
		}
	}

	function companies() {
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['companies'] = $this->settings_model->getAllCompanies(); 
		$this->data['page_title'] = $this->lang->line('companies');
		$this->page_construct('settings/companies', $this->data);
	}


	function add_company() {
		
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'required');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'required');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'required');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|min_length[6]|max_length[16]');
		
		if ($this->form_validation->run() == true) {

			$data = array('name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'company' => $this->input->post('company'),
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

			
			if ($_FILES['logo']['size'] > 0) {
				
				$this->load->library('upload');
				$config['upload_path'] = 'uploads/'; 
				$config['allowed_types'] = 'gif|jpg|png'; 
				$config['max_size'] = '300';
				$config['max_width'] = '300';
				$config['max_height'] = '80';
				$config['file_ext_tolower'] = TRUE;
				$config['max_filename'] = 30;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);

				if( ! $this->upload->do_upload('logo')){
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect("settings/add_company");
				} 

				$data['logo'] = $this->upload->file_name;
			} 

			if ($_FILES['image']['size'] > 0) {
				
				$this->load->library('upload');
				$config['upload_path'] = 'uploads/'; 
				$config['allowed_types'] = 'gif|jpg|png'; 
				$config['max_size'] = '300';
				$config['max_width'] = '300';
				$config['max_height'] = '150';
				$config['file_ext_tolower'] = TRUE;
				$config['max_filename'] = 30;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);

				if( ! $this->upload->do_upload('image')){
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect("settings/add_company");
				} 

				$data['ss_image'] = $this->upload->file_name;
			} 

		}
		
		if ($this->form_validation->run() == true && $this->settings_model->addCompany($data)) {  

			$this->session->set_flashdata('message', $this->lang->line("company_added"));
			redirect("settings/companies");

		} else { 
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['page_title'] = $this->lang->line('add_company');
			$this->page_construct('settings/add_company', $this->data);
		}
	}

	function edit_company($id = NULL) {
		if($this->input->get('id')){ $id = $this->input->get('id'); }	
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'required');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'required');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'required');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|min_length[6]|max_length[16]');
		
		if ($this->form_validation->run() == true) {

			$data = array('name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'company' => $this->input->post('company'),
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

			if ($_FILES['logo']['size'] > 0) {
				
				$this->load->library('upload');
				$config['upload_path'] = 'uploads/'; 
				$config['allowed_types'] = 'gif|jpg|png'; 
				$config['max_size'] = '300';
				$config['max_width'] = '300';
				$config['max_height'] = '80';
				$config['file_ext_tolower'] = TRUE;
				$config['max_filename'] = 30;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);

				if( ! $this->upload->do_upload('logo')){
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect("settings/add_company");
				} 

				$logo = $this->upload->file_name;
			} 

			if ($_FILES['image']['size'] > 0) {
				
				$this->load->library('upload');
				$config['upload_path'] = 'uploads/'; 
				$config['allowed_types'] = 'gif|jpg|png'; 
				$config['max_size'] = '300';
				$config['max_width'] = '300';
				$config['max_height'] = '150';
				$config['file_ext_tolower'] = TRUE;
				$config['max_filename'] = 30;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);

				if( ! $this->upload->do_upload('image')){
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect("settings/add_company");
				} 

				$ss_image = $this->upload->file_name;
			}

			if(isset($logo) && !empty($logo)) { $data['logo'] = $logo; }
			if(isset($ss_image) && !empty($ss_image)) { $data['ss_image'] = $ss_image; }
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateCompany($id, $data)) { 

			$this->session->set_flashdata('message', $this->lang->line("details_updated"));
			redirect("settings/companies");

		} else { 
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['details'] = $this->settings_model->getCompanyByID($id);
			$this->data['page_title'] = $this->lang->line('edit_company');
			$this->page_construct('settings/edit_company', $this->data);
		}
	}

	function tax_rates() {

		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['tax_rates'] = $this->settings_model->getAllTaxRates(); 
		$this->data['page_title'] = $this->lang->line('tax_rates');
		$this->page_construct('settings/tax_rates', $this->data);

	}

	function add_tax_rate() {

		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
		$this->form_validation->set_rules('name', $this->lang->line('title'), 'required');
		$this->form_validation->set_rules('rate', $this->lang->line('rate'), 'required');
		$this->form_validation->set_rules('type', $this->lang->line('type'), 'required|is_natural_no_zero');
		
		
		if ($this->form_validation->run() == true) {
			$data = array('name' => $this->input->post('name'),
				'rate' => $this->input->post('rate'),
				'type' => $this->input->post('type')
				);
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->addTaxRate($data)) { 

			$this->session->set_flashdata('message', $this->lang->line('tax_rate_added'));
			redirect("settings/tax_rates");

		} else {
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['page_title'] = $this->lang->line('new_tax_rate');
			$this->page_construct('settings/add_tax_rate', $this->data);
		}
	}

	function edit_tax_rate($id = NULL) {

		if($this->input->get('id')){ $id = $this->input->get('id'); }
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
		$this->form_validation->set_rules('name', $this->lang->line('title'), 'required');
		$this->form_validation->set_rules('rate', $this->lang->line('rate'), 'required');
		$this->form_validation->set_rules('type', $this->lang->line('type'), 'required|is_natural_no_zero');
		
		
		if ($this->form_validation->run() == true) {
			$data = array('name' => $this->input->post('name'),
				'rate' => $this->input->post('rate'),
				'type' => $this->input->post('type')
				);
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateTaxRate($id, $data)) {  

			$this->session->set_flashdata('message', $this->lang->line('tax_rate_updated'));
			redirect("settings/tax_rates");

		} else {
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['tax_rate'] = $this->settings_model->getTaxRateByID($id);
			$this->data['id'] = $id;
			$this->data['page_title'] = $this->lang->line('update_tax_rate');
			$this->page_construct('settings/edit_tax_rate', $this->data);
		}
	}


	
	function change_logo() {

		$this->load->helper('security');
		$this->form_validation->set_rules('logo', 'Logo Image', 'xss_clean');
		
		if ($this->form_validation->run() == true) {

			if (DEMO) {
				$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
				redirect('home');
			}
			
			if ($_FILES['logo']['size'] > 0) {
				
				$this->load->library('upload');
				$config['upload_path'] = 'uploads/'; 
				$config['allowed_types'] = 'gif|jpg|png'; 
				$config['max_size'] = '300';
				$config['max_width'] = '300';
				$config['max_height'] = '80';
				$config['file_ext_tolower'] = TRUE;
				$config['max_filename'] = 30;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);

				if( ! $this->upload->do_upload('logo')){
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect("settings/change_logo");
				} 

				$photo = $this->upload->file_name;

			} else {
				$this->session->set_flashdata('error', $this->lang->line('not_uploaded'));
				redirect("settings/change_logo");	
			}
			
		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateLogo($photo)) { 

			$this->session->set_flashdata('message', $this->lang->line('logo_changed'));
			redirect("settings/change_logo");

		} else {
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['page_title'] = $this->lang->line('change_logo');
			$this->page_construct('settings/logo', $this->data);
		}
	}

	function change_invoice_logo() {

		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}
		$this->load->helper('security');
		$this->form_validation->set_rules('logo', 'Logo Image', 'xss_clean');
		
		if ($this->form_validation->run() == true) {

			if ($_FILES['logo']['size'] > 0) {
				
				$this->load->library('upload');
				$config['upload_path'] = 'uploads/'; 
				$config['allowed_types'] = 'gif|jpg|png'; 
				$config['max_size'] = '300';
				$config['max_width'] = '300';
				$config['max_height'] = '80';
				$config['overwrite'] = FALSE; 
				$this->upload->initialize($config);

				if( ! $this->upload->do_upload('logo')){
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect("settings/change_logo");
				} 

				$photo = $this->upload->file_name;

			} else {
				$this->session->set_flashdata('error', $this->lang->line('not_uploaded'));
				redirect("settings/change_logo");	
			}
			

		}
		
		if ( $this->form_validation->run() == true && $this->settings_model->updateInvoiceLogo($photo)) {  

			$this->session->set_flashdata('message', $this->lang->line('logo_changed'));
			redirect("settings/change_invoice_logo");

		} else {
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['page_title'] = $this->lang->line('change_invoice_logo');
			$this->page_construct('settings/invoice_logo', $this->data);
		}
	}

	function delete_tax_rate($id = NULL) {
		
		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}
		if($this->input->get('id')){ $id = $this->input->get('id'); }
		
		if ( $this->settings_model->deleteTaxRate($id) ) { 
			$this->session->set_flashdata('message', $this->lang->line("tax_rate_deleted"));
			redirect('settings/tax_rates');
		}
		
	}
	
	function delete_invoice_type($id = NULL) {

		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}
		if($this->input->get('id')){ $id = $this->input->get('id'); }
		
		if ( $this->settings_model->deleteInvoiceType($id) ) { 
			$this->session->set_flashdata('message', $this->lang->line("invoice_type_deleted"));
			redirect('settings/invoice_types');
		}
		
	}

	function stripe() {

		$this->form_validation->set_rules('active', $this->lang->line('activate'), 'trim');
		if($this->input->post('active')) {
			$this->form_validation->set_rules('secret_key', $this->lang->line('secret_key'), 'required|trim');
			$this->form_validation->set_rules('publishable_key', $this->lang->line('publishable_key'), 'required|trim');
		}
		$this->form_validation->set_rules('fixed_charges', $this->lang->line('fixed_charges'), 'trim');
		$this->form_validation->set_rules('extra_charges_my', $this->lang->line('extra_charges_my'), 'trim');
		$this->form_validation->set_rules('extra_charges_other', $this->lang->line('extra_charges_others'), 'trim');

		if ($this->form_validation->run() == true) {
			$data = array('active' => $this->input->post('active'),
				'secret_key' => $this->input->post('secret_key'),
				'publishable_key' => $this->input->post('publishable_key'),
				'fixed_charges' => $this->input->post('fixed_charges'),
				'extra_charges_my' => $this->input->post('extra_charges_my'),
				'extra_charges_other' => $this->input->post('extra_charges_other')
				);
		}

		if ( $this->form_validation->run() == true && $this->settings_model->updateStripe($data)) { 

			$this->session->set_flashdata('message', $this->lang->line('stripe_setting_updated'));
			redirect("settings/stripe");

		} else {
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['stripe'] = $this->settings_model->getStripeSettings();
			$this->data['page_title'] = $this->lang->line('stripe_settings');
			$this->page_construct('settings/stripe', $this->data);
		}
	}

	function paypal() {

		$this->form_validation->set_rules('active', $this->lang->line('activate'), 'trim');
		$this->form_validation->set_rules('account_email', $this->lang->line('paypal_account_email'), 'trim|valid_email');
		if($this->input->post('active')) {
			$this->form_validation->set_rules('account_email', $this->lang->line('paypal_account_email'), 'required');
		}
		$this->form_validation->set_rules('fixed_charges', $this->lang->line('fixed_charges'), 'trim');
		$this->form_validation->set_rules('extra_charges_my', $this->lang->line('extra_charges_my'), 'trim');
		$this->form_validation->set_rules('extra_charges_other', $this->lang->line('extra_charges_others'), 'trim');

		if ($this->form_validation->run() == true) {
			$data = array('active' => $this->input->post('active'),
				'account_email' => $this->input->post('account_email'),
				'fixed_charges' => $this->input->post('fixed_charges'),
				'extra_charges_my' => $this->input->post('extra_charges_my'),
				'extra_charges_other' => $this->input->post('extra_charges_other')
				);
		}

		if ( $this->form_validation->run() == true && $this->settings_model->updatePaypal($data)) { 

			$this->session->set_flashdata('message', $this->lang->line('paypal_setting_updated'));
			redirect("settings/paypal");

		} else {
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['paypal'] = $this->settings_model->getPaypalSettings();
			$this->data['page_title'] = $this->lang->line('paypal_settings');
			$this->page_construct('settings/paypal', $this->data);
		}
	}

	function skrill()
	{

		$this->form_validation->set_rules('active', $this->lang->line('activate'), 'trim');
		$this->form_validation->set_rules('account_email', $this->lang->line('paypal_account_email'), 'trim|valid_email');
		if($this->input->post('active')) {
			$this->form_validation->set_rules('account_email', $this->lang->line('paypal_account_email'), 'required');
		}
		$this->form_validation->set_rules('fixed_charges', $this->lang->line('fixed_charges'), 'trim');
		$this->form_validation->set_rules('extra_charges_my', $this->lang->line('extra_charges_my'), 'trim');
		$this->form_validation->set_rules('extra_charges_other', $this->lang->line('extra_charges_others'), 'trim');

		if ($this->form_validation->run() == true) {
			$data = array('active' => $this->input->post('active'),
				'account_email' => $this->input->post('account_email'),
				'fixed_charges' => $this->input->post('fixed_charges'),
				'extra_charges_my' => $this->input->post('extra_charges_my'),
				'extra_charges_other' => $this->input->post('extra_charges_other')
				);
		}

		if ( $this->form_validation->run() == true && $this->settings_model->updateSkrill($data)) { 

			$this->session->set_flashdata('message', $this->lang->line('skrill_setting_updated'));
			redirect("settings/skrill");

		} else {
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['skrill'] = $this->settings_model->getSkrillSettings();
			$this->data['page_title'] = $this->lang->line('skrill_settings');
			$this->page_construct('settings/skrill', $this->data);
		}
	}

	function updates() {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->form_validation->set_rules('purchase_code', lang("purchase_code"), 'required');
        $this->form_validation->set_rules('envato_username', lang("envato_username"), 'required');
        if ($this->form_validation->run() == true) {
            $this->db->update('settings', array('purchase_code' => $this->input->post('purchase_code', TRUE), 'envato_username' => $this->input->post('envato_username', TRUE)), array('setting_id' => 1));
            redirect('settings/updates');
        } else {
            $fields = array('version' => $this->Settings->version, 'code' => $this->Settings->purchase_code, 'username' => $this->Settings->envato_username, 'site' => base_url());
            $this->load->helper('curl');
            $updates = get_curl_contents('http://api.tecdiary.com/v1/update/', $fields);
            $this->data['updates'] = json_decode($updates);
            $this->data['page_title'] = lang('updates');
            $this->page_construct('settings/updates', $this->data);
        }
    }

	function install_update($file, $m_version, $version) {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    $this->load->helper('curl');
	    save_remote_file($file.'.zip');
	    $this->sim->unzip('./files/updates/'.$file.'.zip');
	    if ($m_version) {
	        $this->load->library('migration');
	        if (! $this->migration->current()) {
	            $this->session->set_flashdata('error', $this->migration->error_string());
	            redirect("settings/updates");
	        }
	    }
	    if($this->Settings->version < '3.3') {
	    	$this->settings_model->updateSalesUser();
	    	$this->settings_model->updateQuotesUser();
	    }
	    $this->db->update('settings', array('version' => $version), array('setting_id' => 1));
	    unlink('./files/updates/'.$file.'.zip');
	    $this->session->set_flashdata('success', lang('update_done'));
	    redirect("settings/updates");
	}

	function backups() {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    $this->data['files'] = glob('./files/backups/*.zip', GLOB_BRACE);
	    $this->data['dbs'] = glob('./files/backups/*.txt', GLOB_BRACE);
	    $this->data['page_title'] = lang('backups');
	    $this->page_construct('settings/backups', $this->data);
	}

	function backup_database() {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    $this->load->dbutil();
	    $prefs = array(
	        'format' => 'txt',
	        'filename' => 'sma_db_backup.sql'
	    );
	    $back = $this->dbutil->backup($prefs);
	    $backup =& $back;
	    $db_name = 'db-backup-on-' . date("Y-m-d-H-i-s").'.txt';
	    $save = './files/backups/' . $db_name;
	    $this->load->helper('file');
	    write_file($save, $backup);
	    $this->session->set_flashdata('messgae', lang('db_saved'));
	    redirect("settings/backups");
	}

	function backup_files() {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    set_time_limit(300);
	    $name = 'file-backup-'.date("Y-m-d-H-i-s");
	    $this->sim->zip("./", './files/backups/', $name);
	    $this->session->set_flashdata('messgae', lang('backup_saved'));
	    redirect("settings/backups");
	    exit();
	}

	function restore_database($dbfile) {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    $file = file_get_contents('./files/backups/'.$dbfile.'.txt');
	    $this->db->conn_id->multi_query($file);
	    $this->db->conn_id->close();
	    redirect('auth/logout/db');
	}

	function download_database($dbfile) {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    $this->load->library('zip');
	    $this->zip->read_file('./files/backups/'.$dbfile.'.txt');
	    $name = $dbfile.'.zip';
	    $this->zip->download($name);
	    exit();
	}

	function download_backup($zipfile) {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    $this->load->helper('download');
	    force_download('./files/backups/'.$zipfile.'.zip', NULL);
	    exit();
	}

	function restore_backup($zipfile) {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    $file = './files/backups/'.$zipfile.'.zip';
	    $this->sim->unzip($file, './');
	    $this->session->set_flashdata('success', lang('files_restored'));
	    redirect("settings/backups");
	    exit();
	}

	function delete_database($dbfile) {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    unlink('./files/backups/'.$dbfile.'.txt');
	    $this->session->set_flashdata('messgae', lang('db_deleted'));
	    redirect("settings/backups");
	}

	function delete_backup($zipfile) {
	    if(DEMO) {
	        $this->session->set_flashdata('error', lang('disabled_in_demo'));
	        redirect($_SERVER["HTTP_REFERER"]);
	    }
	    if(!$this->Admin) {
	        $this->session->set_flashdata('error', lang('access_denied'));
	        redirect("welcome");
	    }
	    unlink('./files/backups/'.$zipfile.'.zip');
	    $this->session->set_flashdata('messgae', lang('backup_deleted'));
	    redirect("settings/backups");
	}

	function email_templates($template = "credentials") {

	    $this->form_validation->set_rules('mail_body', lang('mail_message'), 'trim|required');
	    $this->load->helper('file');
	    $temp_path = is_dir('./themes/' . $this->Settings->theme . '/views/email_templates/');
	    $theme = $temp_path ? $this->Settings->theme : 'default';
	    if($this->form_validation->run() == true) {

	        $data = $_POST["mail_body"];
	        if(file_put_contents('./themes/' . $this->Settings->theme . '/views/email_templates/' . $template . '.html', $data)) {
	            $this->session->set_flashdata('message', lang('template_successfully_saved'));
	            redirect('settings/email_templates#' . $template);
	        } else {
	            $this->session->set_flashdata('error', lang('failed_to_save_template'));
	            redirect('settings/email_templates#' . $template);
	        }
	        
	    } else {
	        
	        $this->data['credentials'] = file_get_contents('./themes/' . $theme . '/views/email_templates/credentials.html');
	        $this->data['new_password'] = file_get_contents('./themes/' . $theme . '/views/email_templates/new_password.html');
	        $this->data['forgot_password'] = file_get_contents('./themes/' . $theme . '/views/email_templates/forgot_password.html');
	        $this->data['activate_email'] = file_get_contents('./themes/' . $theme . '/views/email_templates/activate_email.html');
	        $this->data['page_title'] = $this->lang->line('email_templates');
	        $this->page_construct('settings/email_templates', $this->data);

	    }
	}

	function notes() {

		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['notes'] = $this->settings_model->getAllNotes(); 
		$this->data['page_title'] = $this->lang->line('notes');
		$this->page_construct('settings/notes', $this->data);

	}

	function note() {

		$this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
		
		if ($this->form_validation->run() == true) {

			$data = array('description' => $this->input->post('description'));
			if ($this->input->post('action') == 'add') {
				$this->settings_model->addNote($data);
				$this->session->set_flashdata('message', $this->lang->line('note_added'));
			} elseif ($this->input->post('action') == 'edit') {
				$this->settings_model->updateNote($this->input->post('id'), $data);
				$this->session->set_flashdata('message', $this->lang->line('note_updated'));
			}
			redirect("settings/notes");

		} else {
			$this->session->set_flashdata('error', validation_errors());
			redirect("settings/notes");
		}
	}

	function delete_note($id) {
		if ($this->settings_model->deleteNote($id)) {
			echo lang('note_deleted');
			exit();
		}
		echo lang('action_failed');
		exit();
	}
	

}