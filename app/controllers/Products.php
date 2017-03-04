<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller {

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
	| MODULE: 			Products
	| -----------------------------------------------------
	| This is products module controller file.
	| -----------------------------------------------------
	*/


	function __construct()
	{
		parent::__construct();

		if (!$this->sim->logged_in()) {
			redirect('auth/login');
		}
		if($this->sim->in_group('customer')) {
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			redirect('clients');
		}
		
		$this->load->library('form_validation');
		$this->load->model('products_model');

	}

	function index()
	{

		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['page_title'] = $this->lang->line("products");
		$this->page_construct('products/index', $this->data);
	}

	function getdatatableajax()
	{
		
		$this->load->library('datatables');
		$this->datatables
		->select("{$this->db->dbprefix('products')}.id as pid, products.name as product_name, details, price, tax_rates.name as tax_rate")
		->from("products")
		->join('tax_rates', 'tax_rates.id=products.tax_rate', 'left')
		->group_by("{$this->db->dbprefix('products')}.id")
		
		->add_column("Actions", 
			"<center><div class='btn-group'><a class=\"tip btn btn-primary btn-xs\" title='".$this->lang->line("edit_product")."' href='".site_url('products/edit')."?id=$1'><i class=\"fa fa-edit\"></i></a> <a class=\"tip btn btn-danger btn-xs\" title='".$this->lang->line("delete_product")."' href='".site_url('products/delete')."?id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_product') ."')\"><i class=\"fa fa-trash-o\"></i></a></div></center>", "pid");
		
		echo $this->datatables->generate();

	}

	function add()
	{

		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required');
		$this->form_validation->set_rules('price', $this->lang->line("price"), 'required');
		
		if ($this->form_validation->run() == true) {
			$data = array('name' => $this->input->post('name'),
				'price' => $this->input->post('price'),
				'tax_rate' => $this->input->post('tax_rate'),
				'details' => $this->input->post('details'),
				);
		}
		
		if ($this->form_validation->run() == true && $this->products_model->addProduct($data)) { 

			$this->session->set_flashdata('message', $this->lang->line("product_added"));
			redirect("products");

		} else { 
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['tax_rates'] = $this->products_model->getAllTaxRates();
			$this->data['page_title'] = $this->lang->line("new_product");
			$this->page_construct('products/add', $this->data);

		}
	}

	function edit($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }

		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required');
		$this->form_validation->set_rules('price', $this->lang->line("price"), 'required');

		if ($this->form_validation->run() == true) {
			$data = array('name' => $this->input->post('name'),
				'price' => $this->input->post('price'),
				'tax_rate' => $this->input->post('tax_rate'),
				'details' => $this->input->post('details'),
				);
		}

		if ( $this->form_validation->run() == true && $this->products_model->updateProduct($id, $data)) {  

			$this->session->set_flashdata('message', $this->lang->line("product_updated"));
			redirect("products");

		} else {  
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['product'] = $this->products_model->getProductByID($id);
			$this->data['tax_rates'] = $this->products_model->getAllTaxRates();
			$this->data['id'] = $id;
			$this->data['page_title'] = $this->lang->line("update_product");
			$this->page_construct('products/edit', $this->data);

		}
	}

	function import()
	{
		if (!$this->sim->in_group('admin')) {
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			redirect('products');
		}
		$this->load->helper('security');
		$this->form_validation->set_rules('userfile', $this->lang->line("upload_file"), 'xss_clean');

		if ($this->form_validation->run() == true) {

			if (DEMO) {
				$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
				redirect('home');
			}

			$category = $this->input->post('category');			
			if ( isset($_FILES["userfile"])) /*if($_FILES['userfile']['size'] > 0)*/
			{

				$this->load->library('upload');

				$config['upload_path'] = 'uploads/'; 
				$config['allowed_types'] = 'csv'; 
				$config['max_size'] = '200';
				$config['overwrite'] = TRUE; 

				$this->upload->initialize($config);

				if( ! $this->upload->do_upload()){

					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect("products/import");
				} 

				$csv = $this->upload->file_name;

				$arrResult = array();
				$handle = fopen("uploads/".$csv, "r");
				if( $handle ) {
					while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
						$arrResult[] = $row;
					}
					fclose($handle);
				}
				$titles = array_shift($arrResult);

				$keys = array('name', 'price', 'tax', 'details');

				$final = array();

				foreach ( $arrResult as $key => $value ) {
					$final[] = array_combine($keys, $value);
				}
				$rw=2;
				foreach($final as $csv_pr) {
					if($this->products_model->getProductByName($csv_pr['name'])) {
						$this->session->set_flashdata('error', $this->lang->line("check_product_name")." (".$csv_pr['name']."). ".$this->lang->line("product_name_already_exist")." ".$this->lang->line("line_no")." ".$rw);
						redirect("products/import");
					}
					if( $taxd = $this->products_model->getTaxRateByName($csv_pr['tax'])) {
						$pr_name[] = $csv_pr['name'];
						$pr_tax[] = $taxd->id;
						$pr_price[] = $csv_pr['price'];
						$pr_details[] = $csv_pr['details'];
					} else {
						$this->session->set_flashdata('error', $this->lang->line("check_tax_rate")." (".$csv_pr['tax']."). ".$this->lang->line("tax_x_exist")." ".$this->lang->line("line_no")." ".$rw);
						redirect("products/import");
					}

					$rw++;	
				}
			} 

			$ikeys = array('name', 'price', 'tax_rate', 'details');

			$items = array();
			foreach ( array_map(null, $pr_name, $pr_price, $pr_tax, $pr_details) as $ikey => $value ) {
				$items[] = array_combine($ikeys, $value);
			}

			$final = $this->sim->escape_str($items);
		}

		if ( $this->form_validation->run() == true && $this->products_model->add_products($final)) { 

			$this->session->set_flashdata('message', $this->lang->line("products_added"));
			redirect('products');

		} else {  

			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['userfile'] = array('name' => 'userfile',
				'id' => 'userfile',
				'type' => 'text',
				'value' => $this->form_validation->set_value('userfile')
				);
			$this->data['page_title'] = $this->lang->line("csv_add_products");
			$this->page_construct('products/upload_csv', $this->data);

		}
	}

	function delete($id = NULL)
	{
		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}

		if($this->input->get('id')) { $id = $this->input->get('id'); }
		if (!$this->sim->in_group('admin')) {
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			redirect('home');
		}

		if ( $this->products_model->deleteProduct($id) )
		{  
			$this->session->set_flashdata('message', $this->lang->line("product_deleted"));
			redirect("products");
		}

	}

	function suggestions()
	{
		$term = $this->input->get('term', TRUE);
		if (strlen($term) < 1) {
			die();
		}

		$rows = $this->products_model->getProductNames($term);
		if ($rows) {
			foreach ($rows as $row) {
				$pr[] = array('id' => $row->id, 'label' => $row->name, 'price' => $row->price, 'tax' => $row->tax_rate, 'details' => $row->details);
			}
			$this->sim->send_json($pr);
		}
		echo FALSE;

	}


}