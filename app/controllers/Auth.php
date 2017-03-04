<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
	}

	function index()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		} else {
			redirect('home');
		}
	}

	function users() {
		if (!$this->ion_auth->in_group('admin'))
		{
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			redirect('home');
		}
		
		
		$this->user_check();
		
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['message'] = $this->session->flashdata('message');
			//list the users
			$this->data['users'] = $this->ion_auth_model->getAllStaff();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			
			$this->data['page_title'] = 'Users';
			$this->page_construct('auth/index', $this->data);
						
	}
	//log the user in
	function login($msg = NULL)
	{
		if ($this->ion_auth->logged_in()) {
			redirect('home');
		}
		$this->data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{ //check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{ //if the login is successful
				//redirect them back to the home page
				if($this->ion_auth->in_group('customer')) {
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('clients');
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('home');	
				}
				
			}
			else
			{ //if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect('auth/login'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{  //the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->data['message'] =  $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			if ($msg == 'db') {
                $this->data['message'] = lang('db_restored');
            }

			$this->load->view($this->theme.'auth/login', $this->data);
		}
	}

	//log the user out
	function logout($msg = NULL)
	{
		$this->data['title'] = $this->lang->line("logout");

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them back to the page they came from
		$this->session->set_flashdata('message', $this->lang->line('logged_out'));
		redirect('auth/login/'.$msg);
	}

	//change password
	function change_password()
	{
		
		$this->user_check();
		
		$this->form_validation->set_rules('old', $this->lang->line("old_pw"), 'required');
		$this->form_validation->set_rules('new', $this->lang->line("new_pw"), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line("confirm_pw"), 'required');

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{ 
		
		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);


			$this->data['page_title'] = $this->lang->line("change_password");
			$this->page_construct('auth/change_password', $this->data);
			
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{ //if the password was successfully changed
				
				$logout = $this->ion_auth->logout();
				$this->session->set_flashdata('message', $this->lang->line('password_changed'));
				redirect('auth/login');
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect('auth/change_password');
			}
		}
	}

	//forgot password
	function forgot_password()
	{
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);
			//set any errors and display the form
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$this->load->view($this->theme.'auth/forgot_password', $this->data);
		}
		else
		{
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten)
			{ //if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login"); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect("auth/forgot_password");
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if ($this->input->get('code')) { $code = $this->input->get('code'); }
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{  //if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line("new_pw"), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line("confirm_pw"), 'required');

			if ($this->form_validation->run() == false)
			{//display the form
				//set the flash data error message if there is one
				$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$this->load->view($this->theme.'auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_404();

				} else {
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{ //if the password was successfully changed
						$this->session->set_flashdata('error', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('error', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code);
					}
				}
			}
		}
		else
		{ //if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('error', $this->ion_auth->errors());
			redirect("auth/forgot_password");
		}
	}


	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
			$activation = $this->ion_auth->activate($id, $code);
		else if ($this->ion_auth->is_admin())
			$activation = $this->ion_auth->activate($id);

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('error', $this->ion_auth->messages());
			redirect("auth");
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('error', $this->ion_auth->errors());
			redirect("auth/forgot_password");
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		$id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();
			
			$thid->data['page_title'] = "Deactivate User";
			$this->page_construct('auth/deactivate_user', $this->data);

		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_404();
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth');
		}
	}

	//create a new user
	function create_user()
	{
		if (!$this->ion_auth->in_group('admin'))
		{
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			redirect('home');
		}
		
				
		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line("first_name"), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line("last_name"), 'required');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|min_length[9]|max_length[16]');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required');
		$this->form_validation->set_rules('password', $this->lang->line("pw"), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line("confirm_pw"), 'required');

		if ($this->form_validation->run() == true)
		{
		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}
			
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$additional_data = array('first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
			);
			
			$group = array($this->input->post('role')); 

		}
		
		
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data, $group))
		{ //check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->lang->line("user_added"));
			redirect("auth/users");
		}
		else
		{ //display the create user form
			//set the flash data error message if there is one
		
			$this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

			$this->data['first_name'] = array('name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array('name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array('name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array('name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);
			
			$this->data['page_title'] = $this->lang->line("new_user");

			$this->page_construct('auth/create_user', $this->data);
			
		}
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function user_check()
	{
		if (!$this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('error', "Login Required!");
			redirect('auth/login');
		}
	}
	
	
	function edit_user($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		
		if (!$this->ion_auth->in_group('admin'))
		{
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			redirect('auth/users');
		}
		
		$user = $this->ion_auth_model->getUserByID($id);
		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line("first_name"), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line("last_name"), 'required');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		if($this->input->post('email') && $this->input->post('email') != $user->email) {
			$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'is_unique[users.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|min_length[9]|max_length[16]');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required');
		$this->form_validation->set_rules('password', $this->lang->line("pw"), 'min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line("confirm_pw"), 'matches[password]');

		if ($this->form_validation->run() == true)
		{
			
		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}
		
			$email = $this->input->post('email');
			if($this->input->post('password')){
			$password = $this->input->post('password');
			} else {
				$password = NULL;
			}
			$additional_data = array('first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
			);
			$group = $this->input->post('role'); 
			
			
		}
		
		
		if ($this->form_validation->run() == true && $this->ion_auth_model->updateUser($id, $email, $password, $additional_data, $group))
		{ //check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->lang->line("user_updated"));
			if($this->input->get('customer')) {
				redirect("customers");
			} else {
				redirect("auth/users");
			}
		}
		else
		{ //display the create user form
			//set the flash data error message if there is one
		
			$this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
			

			$this->data['first_name'] = array('name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array('name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array('name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array('name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);
			
		
		$this->data['user'] = $this->ion_auth_model->getUserByID($id);
		$this->data['group'] = $this->ion_auth_model->getUserGroupByUserID($id);
		

		$this->data['id'] = $id;
		$this->data['customer'] = $this->input->get('customer');
		$this->data['page_title'] = $this->lang->line("update_user");
		$this->page_construct('auth/edit_user', $this->data);
		
		}
	}
	
	function delete_user($id = NULL)
	{
		if (DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('home');
		}
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		
		
		if (!$this->ion_auth->in_group('admin'))
		{
			$this->session->set_flashdata('error', $this->lang->line("access_denied"));
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
		if ( $this->ion_auth_model->deleteUser($id) )
		{ //check to see if we are deleting the biller
			//redirect them back to the admin page
			$this->session->set_flashdata('error', $this->lang->line("user_deleted"));
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}

}
