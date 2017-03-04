<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller {

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
| MODULE: 			REPORTS
| -----------------------------------------------------
| This is reports module controller file.
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

		$this->load->model('reports_model');

	}

	function index()
	{
		redirect('reports/daily_sales');
	}

	function daily_sales($year = NULL, $month = NULL)
	{
		if($this->input->get('year')){ $year = $this->input->get('year'); } 
		if($this->input->get('month')){ $month = $this->input->get('month'); }
		if(!$year) { $year = date('Y'); }
		if(!$month) { $month = date('m'); }
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

		$config = array (
			'show_next_prev'  => TRUE,
			'next_prev_url'   => site_url('reports/daily_sales'),
			'month_type'   => 'long',
			'day_type'     => 'long'
			);

		$config['template'] = '

		{table_open}<table border="0" cellpadding="0" cellspacing="0" class="table table-bordered" style="min-width:522px;">{/table_open}

		{heading_row_start}<tr>{/heading_row_start}

		{heading_previous_cell}<th><div class="text-center"><a href="{previous_url}">&lt;&lt;</div></a></th>{/heading_previous_cell}
		{heading_title_cell}<th colspan="{colspan}"><div class="text-center">{heading}</div></th>{/heading_title_cell}
		{heading_next_cell}<th><div class="text-center"><a href="{next_url}">&gt;&gt;</a></div></th>{/heading_next_cell}

		{heading_row_end}</tr>{/heading_row_end}

		{week_row_start}<tr>{/week_row_start}
		{week_day_cell}<td class="cl_equal"><div class="cl_wday">{week_day}</div></td>{/week_day_cell}
		{week_row_end}</tr>{/week_row_end}

		{cal_row_start}<tr>{/cal_row_start}
		{cal_cell_start}<td>{/cal_cell_start}

		{cal_cell_content}{day}<br>{content}{/cal_cell_content}
		{cal_cell_content_today}<div class="highlight">{day}</div>{content}{/cal_cell_content_today}

		{cal_cell_no_content}{day}{/cal_cell_no_content}
		{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

		{cal_cell_blank}&nbsp;{/cal_cell_blank}

		{cal_cell_end}</td>{/cal_cell_end}
		{cal_row_end}</tr>{/cal_row_end}

		{table_close}</table>{/table_close}
		';


		$this->load->library('calendar', $config);


		$sales = $this->reports_model->getDailySales($year, $month);

		if(!empty($sales)) {
			foreach($sales as $sale){
				// $daily_sale[date('j', strtotime($sale->date))] = "<span class='violet'>". $this->sim->formatMoney($sale->total)."</span><br><span class='green'>".$this->sim->formatMoney($sale->paid)."</span><br><span class='orange'>".$this->sim->formatMoney($sale->total - $sale->paid)."</span>";	
				$daily_sale[date('j', strtotime($sale->date))] = "<table class='table table-condensed table-striped' style='margin-bottom:0;'><tr><td>".lang('total').
                "</td><td style='font-weight:bold;text-align:right;'>{$this->sim->formatMoney($sale->inv_total)}</td></tr><tr><td>".lang('tax').
                "</td><td style='font-weight:bold;text-align:right;'>{$this->sim->formatMoney($sale->tax)}</td></tr><tr><td class='violet'>".lang('grand_total').
                "</td><td style='font-weight:bold;text-align:right;' class='violet'>{$this->sim->formatMoney($sale->total)}</td></tr><tr><td class='green'>".lang('paid').
                "</td><td style='font-weight:bold;text-align:right;' class='green'>{$this->sim->formatMoney($sale->paid)}</td></tr><tr><td class='orange'>".lang('balance').
                "</td><td style='font-weight:bold;text-align:right;' class='orange'>{$this->sim->formatMoney($sale->total - $sale->paid)}</td></tr></table>";
			}
		} else {
			$daily_sale = array();
		}

		$this->data['calender'] = $this->calendar->generate($year, $month, $daily_sale);

		$this->data['page_title'] = $this->lang->line("daily_sales");
		$this->page_construct('reports/daily', $this->data);
	}


	function monthly_sales()
	{
		if($this->input->get('year')){ $year = $this->input->get('year'); } else { $year = date('Y'); }
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->load->language('calendar');
		$this->data['year'] = $year;
		$this->data['sales'] = $this->reports_model->getMonthlySales($year);
		$this->data['page_title'] = $this->lang->line("monthly_sales");
		$this->page_construct('reports/monthly', $this->data);

	}



	function sales()
	{
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');	   
		$this->data['customers'] = $this->reports_model->getAllCustomers();
		$this->data['users'] = $this->reports_model->getAllStaff();
		if($this->input->post('submit') && $this->input->post('customer')) {
			$this->data['cus'] = $this->reports_model->getCustomerByID($this->input->post('customer')); 
			$this->data['tpp'] = $this->reports_model->TPP($this->input->post('customer')); 
			$this->data['total'] = $this->reports_model->getTotal($this->input->post('customer')); 
			$this->data['paid'] = $this->reports_model->getPaid($this->input->post('customer')); 
			$this->data['cancelled'] = $this->reports_model->getCancelled($this->input->post('customer')); 
			$this->data['overdue'] = $this->reports_model->getOverdue($this->input->post('customer')); 
			$this->data['pending'] = $this->reports_model->getPending($this->input->post('customer'));
			$this->data['pp'] = $this->reports_model->getPP($this->input->post('customer'));
		}
		$this->data['page_title'] = $this->lang->line("sale_reports");
		$this->page_construct('reports/sales', $this->data);
	}


	function getsales()
	{
		if($this->input->get('product')){ $product = $this->input->get('product'); } else { $product = NULL; }
		if($this->input->get('user')){ $user = $this->input->get('user'); } else { $user = NULL; }
		if($this->input->get('status')){ $status = $this->input->get('status'); } else { $status = NULL; }
		if($this->input->get('customer')){ $customer = $this->input->get('customer'); } else { $customer = NULL; }
		if($this->input->get('cf')){ $cf = $this->input->get('cf'); } else { $cf = NULL; }
		if($this->input->get('start_date')){ 
			$start_date = $this->sim->fsd($this->input->get('start_date')); 
		} else { $start_date = NULL; }
		if($this->input->get('end_date')){ 
			$end_date = $this->sim->fsd($this->input->get('end_date'));
		} else { $end_date = NULL; }

		if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $check = TRUE; } else { $check = NULL; }

		$this->load->library('datatables');
		$this->datatables
		->select("{$this->db->dbprefix('sales')}.id as id, date, company_name, reference_no, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as user, customer_name, grand_total, paid, grand_total-paid as balance, due_date, status, {$this->db->dbprefix('sales')}.customer_id as cid, {$this->db->dbprefix('sale_items')}.product_name as product_name", FALSE)
		->from('sales')
		->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
		->join('users', 'users.id=sales.user', 'left')
		->group_by('sales.id');
		if($cf) { 
			$this->datatables->join('customers', 'customers.id=sales.customer_id', 'left'); 
			$this->datatables->where(" ( customers.cf1 LIKE '%{$cf}%' OR customers.cf2 LIKE '%{$cf}%' OR customers.cf3 LIKE '%{$cf}%' OR customers.cf4 LIKE '%{$cf}%' OR customers.cf5 LIKE '%{$cf}%' OR customers.cf6 LIKE '%{$cf}%' ) ", NULL, FALSE);
		}	
		if($check) { $this->datatables->where('sales.user', $this->session->userdata('user_id')); }
		if($product) { $this->datatables->like('sale_items.product_name', $product, 'both'); }
		if($customer) { $this->datatables->where('sales.customer_id', $customer); }	
		if($user) { $this->datatables->where('sales.user_id', $user); }	
		if($status) { $this->datatables->where('sales.status', $status); }
		if($start_date) { $this->datatables->where('sales.date >=', $start_date); }
		if($end_date) { $this->datatables->where('sales.date <=', $end_date); }


		$this->datatables
		->unset_column('cid')
		->unset_column('product_name');

		echo $this->datatables->generate();
	}

	function payments()
	{
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');	 
		$this->data['customers'] = $this->reports_model->getAllCustomers(); 
		if($this->input->post('submit') && $this->input->post('customer')) {
			$this->data['cus'] = $this->reports_model->getCustomerByID($this->input->post('customer')); 
			$this->data['tpp'] = $this->reports_model->TPP($this->input->post('customer')); 
			$this->data['total'] = $this->reports_model->getTotal($this->input->post('customer')); 
			$this->data['paid'] = $this->reports_model->getPaid($this->input->post('customer')); 
			$this->data['cancelled'] = $this->reports_model->getCancelled($this->input->post('customer')); 
			$this->data['overdue'] = $this->reports_model->getOverdue($this->input->post('customer')); 
			$this->data['pending'] = $this->reports_model->getPending($this->input->post('customer'));
			$this->data['pp'] = $this->reports_model->getPP($this->input->post('customer'));
		}
		$this->data['page_title'] = $this->lang->line("payment_reports");
		$this->page_construct('reports/payment', $this->data);

	}

	function getpayments()
	{
		if($this->input->get('customer')){ $customer = $this->input->get('customer'); } else { $customer = NULL; }
		if($this->input->get('cf')){ $cf = $this->input->get('cf'); } else { $cf = NULL; }
		if($this->input->get('note')){ $note = $this->input->get('note'); } else { $note = NULL; }
		if($this->input->get('start_date')){ 
			$start_date = $this->sim->fsd($this->input->get('start_date')); 
		} else { $start_date = NULL; }
		if($this->input->get('end_date')){ 
			$end_date = $this->sim->fsd($this->input->get('end_date'));
		} else { $end_date = NULL; }

		if($this->Settings->restrict_sales && !$this->sim->in_group('admin')) { $check = TRUE; } else { $check = NULL; }

		$this->load->library('datatables');
		$this->datatables
		->select("{$this->db->dbprefix('payment')}.id as id, {$this->db->dbprefix('payment')}.date as date, {$this->db->dbprefix('payment')}.invoice_id, {$this->db->dbprefix('customers')}.company, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as user, amount, note", FALSE)
		->from('payment')
		->join('users', 'users.id=payment.user', 'left')
		->join('customers', 'customers.id=payment.customer_id', 'left')
		->group_by('payment.id');
		if($cf) { 
			$this->datatables->join('customers', 'customers.id=payment.customer_id', 'left'); 
			$this->datatables->where(" ( customers.cf1 LIKE '%{$cf}%' OR customers.cf2 LIKE '%{$cf}%' OR customers.cf3 LIKE '%{$cf}%' OR customers.cf4 LIKE '%{$cf}%' OR customers.cf5 LIKE '%{$cf}%' OR customers.cf6 LIKE '%{$cf}%' ) ", NULL, FALSE);
		}
		if($check) { $this->datatables->where('payment.user', $this->session->userdata('user_id')); }
		if($note) { $this->datatables->like('payment.note', $note, 'both'); }
		if($customer) { $this->datatables->where('payment.customer_id', $customer); }	
		if($start_date) { $this->datatables->where('payment.date >=', $start_date); }
		if($end_date) { $this->datatables->where('payment.date <=', $end_date); }
		//$this->datatables->join('customers', 'customers.id=payment.customer_id', 'left')->group_by('payment.id');

		$this->datatables->unset_column('id');
		echo $this->datatables->generate();
	}

}