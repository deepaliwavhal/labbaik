<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packages extends MY_Controller {

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
| This is customers module controller file.
| -----------------------------------------------------
*/


	function __construct()
	{
		parent::__construct();

		if (!$this->sim->logged_in())
		{
			redirect('auth/login');
		}
		if($this->sim->in_group('package')) {
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			redirect('clients');
		}

		$this->load->library('form_validation');
		$this->load->model('packages_model');

	}

	function index()
	{
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['page_title'] = 'Trip Titles';
		$this->page_construct('packages/index', $this->data);

	}

	function getdatatableajax()
	{

               // echo "here";exit;
		$this->load->library('datatables');
		$this->datatables
		->select("id,title_trip")
		->from("sim_lb_titles")
		->add_column("Actions",
			"<center><div class='btn-group'><a class=\"tip btn btn-warning btn-xs\" title='".$this->lang->line("edit_title")."' href='".site_url('packages/edit_title/')."?id=$1'><i class=\"fa fa-edit\"></i></a> </div></center>", "id");
		
                        
		echo $this->datatables->generate();

	}

	function add_title()
	{

            $this->form_validation->set_rules('title_trip', $this->lang->line("title_trip"), 'required');		

            if ($this->form_validation->run() == true) {     
                
                $data = array('title_trip' => $this->input->post('title_trip'));
            }          
            
            if ( $this->form_validation->run() == true && $this->packages_model->addTitle($data)) {

                    $this->session->set_flashdata('message','Trip Title Added');
                    redirect("packages");
            }
            else
            {

                $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

                $this->data['page_title'] = 'Add New Trip Title';
                $this->page_construct('packages/add_title', $this->data);

            }
	}
        /*
         * this function is used for editing trip title
         */

	function edit_title($id = NULL)
	{
		
                if($this->input->get('id')) { $id = $this->input->get('id'); }
                
                
		$title = $this->packages_model->getTitleByID($id);
               
		$this->form_validation->set_rules('title_trip', $this->lang->line("title_trip"), 'required');
				

		if ($this->form_validation->run() == true) {
                    
                  
                    $data = array('title_trip' => $this->input->post('title_trip')				                         
				);
		}
                

		if ( $this->form_validation->run() == true && $this->packages_model->updateTitle($id, $data)) {
			$this->session->set_flashdata('message', 'Trip Title Updated');
			redirect("packages");
		}
		else
		{
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

			$this->data['title'] = $title;
			$this->data['id'] = $id;
			$this->data['page_title'] = 'Update Title';
			$this->page_construct('packages/edit_title', $this->data);
		}
	}

	function delete_title($id = NULL)
	{
		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}

		if($this->input->get('id')) { $id = $this->input->get('id'); }
		if (!$this->sim->in_group('admin'))
		{
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			redirect('home');
		}

		if ( $this->packages_model->deleteTitle($id) ) {
			$this->session->set_flashdata('message', 'Supplier Deleted');
			redirect("packages");
		}

	}

}
