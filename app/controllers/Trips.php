<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trips extends MY_Controller {

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
| MODULE: 			Tours
| -----------------------------------------------------
| This is Trips module controller file.
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
                $this->load->library('form_validation');
		$this->load->model('trips_model');	

	}

	function index()
	{
           
            $this->data['page_title'] = $this->lang->line("Trip List");
            $this->data['total'] = $this->trips_model->getTotal(); 
            
                //$this->data['page_title'] = $this->lang->line("welcome")." ".$this->Settings->site_name."!";
		/*$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
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
		$this->page_construct('home', $this->data);*/
                $this->page_construct('trips/index', $this->data);

	}
        
        function getdatatableajax()
    {
        $tablename='lb_trips';     
        if($this->input->get('customer_id')){ $customer_id = $this->input->get('customer_id'); } else { $customer_id = NULL; }

        $this->load->library('datatables');
        //(CASE WHEN users.first_name is null THEN sales.user ELSE CONCAT(users.first_name, ' ', users.last_name) END) as user
        $this->datatables
            ->select("{$this->db->dbprefix($tablename)}.t_id as id, t_name as name, t_price as price, lb_hotels.h_name as hotel, lb_airlines.a_name as airline, t_max_capacity as max_capacity, t_country as country, t_city as city", FALSE)
            ->from($tablename)
            ->join('lb_hotels', 'lb_hotels.h_id=lb_trips.t_hotel', 'left')
            ->join('lb_airlines', 'lb_airlines.a_id=lb_trips.t_airline', 'left')
            ->add_column("Actions",
			"<center><div class='btn-group'> <a class=\"tip btn btn-warning btn-xs\" title='".$this->lang->line("Edit Trip")."' href='".site_url('trips/edit/')."?id=$1'><i class=\"fa fa-edit\"></i></a> <a class=\"tip btn btn-danger btn-xs\" title='".$this->lang->line("delete_trip")."' href='".site_url('trips/delete/')."?id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_trip') ."')\"><i class=\"fa fa-trash-o\"></i></a></div></center>", "id");
       
        echo $this->datatables->generate();
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

		if ( $this->trips_model->deleteTrip($id) )
		{  
			$this->session->set_flashdata('message', $this->lang->line("trip_deleted"));
			redirect("trips");
		}

	}
        
        function add()
	{
            //print_r($_POST);
           // EXIT;

		$this->form_validation->set_rules('tour_name', $this->lang->line("Title"), 'required');
		$this->form_validation->set_rules('tour_description', $this->lang->line("description"), 'required');
		$this->form_validation->set_rules('tour_price', $this->lang->line("price"), 'required');
                $this->form_validation->set_rules('tour_agent', $this->lang->line("Agent"), 'required');
                $this->form_validation->set_rules('tour_hotel', $this->lang->line("Hotel"), 'required');
                $this->form_validation->set_rules('tour_airline', $this->lang->line("airline"), 'required');
                $this->form_validation->set_rules('tour_max_capacity', $this->lang->line("max_capacity"), 'required');                
                $this->form_validation->set_rules('tour_from_date', $this->lang->line("from_date"), 'required');
		$this->form_validation->set_rules('tour_to_date', $this->lang->line("to_date"), 'required');
		$this->form_validation->set_rules('tour_country', $this->lang->line("country"), 'required');
		$this->form_validation->set_rules('tour_city', $this->lang->line("city"), 'required');

		if ($this->form_validation->run() == true) {
			

			$data = array('t_name' => $this->input->post('tour_name'),
                                    't_description' => $this->input->post('tour_description'),
                                    't_price' => $this->input->post('tour_price'),
                                    't_hotel' => $this->input->post('tour_hotel'),
                                    't_airline' => $this->input->post('tour_airline'),
                                    't_agent' => $this->input->post('tour_agent'),
                                    't_max_capacity' => $this->input->post('tour_max_capacity'),
                                    't_country' => $this->input->post('tour_country'),
                                    't_city' => $this->input->post('tour_city'),
                                    't_fromdate' => $this->input->post('tour_from_date'),
                                    't_todate' => $this->input->post('tour_to_date')
				);
		}

		if ( $this->form_validation->run() == true && $this->trips_model->addTrip($data)) {
                        $this->session->set_flashdata('message', $this->lang->line("trip_added"));
			redirect("trips");
		}
		else
		{
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

			$this->data['page_title'] = $this->lang->line("new_trip");
			$this->page_construct('trips/add', $this->data);

		}
	}

    function edit($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }
                $trip = $this->trips_model->getTripByID($id);
		$this->form_validation->set_rules('tour_name', $this->lang->line("Title"), 'required');
		$this->form_validation->set_rules('tour_description', $this->lang->line("description"), 'required');
		$this->form_validation->set_rules('tour_price', $this->lang->line("price"), 'required');
                $this->form_validation->set_rules('tour_agent', $this->lang->line("Agent"), 'required');
                $this->form_validation->set_rules('tour_hotel', $this->lang->line("Hotel"), 'required');
                $this->form_validation->set_rules('tour_airline', $this->lang->line("airline"), 'required');
                $this->form_validation->set_rules('tour_max_capacity', $this->lang->line("max_capacity"), 'required');                
                $this->form_validation->set_rules('tour_from_date', $this->lang->line("from_date"), 'required');
		$this->form_validation->set_rules('tour_to_date', $this->lang->line("to_date"), 'required');
		$this->form_validation->set_rules('tour_country', $this->lang->line("country"), 'required');
		$this->form_validation->set_rules('tour_city', $this->lang->line("city"), 'required');

		if ($this->form_validation->run() == true) {
			$data = array('t_name' => $this->input->post('tour_name'),
                                    't_description' => $this->input->post('tour_description'),
                                    't_price' => $this->input->post('tour_price'),
                                    't_hotel' => $this->input->post('tour_hotel'),
                                    't_airline' => $this->input->post('tour_airline'),
                                    't_agent' => $this->input->post('tour_agent'),
                                    't_max_capacity' => $this->input->post('tour_max_capacity'),
                                    't_country' => $this->input->post('tour_country'),
                                    't_city' => $this->input->post('tour_city'),
                                    't_fromdate' => $this->input->post('tour_from_date'),
                                    't_todate' => $this->input->post('tour_to_date')
				);
		}

		if ( $this->form_validation->run() == true && $this->trips_model->updateTrip($id, $data)) {  
                        $this->session->set_flashdata('message', $this->lang->line("trip_updated"));
			redirect("trips");

		} else {  
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			//$this->data['product'] = $this->products_model->getProductByID($id);
			//$this->data['tax_rates'] = $this->products_model->getAllTaxRates();
                        $this->data['trip'] = $trip;
			$this->data['id'] = $id;
			$this->data['page_title'] = $this->lang->line("update_trip");                        
			$this->page_construct('trips/edit', $this->data);
		}
	}
}

