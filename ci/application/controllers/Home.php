<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users');
	}

	public function index()
	{
		$this->load->view('home');
	}

	public function register()
	{
		$this->load->view('register');
	}

	public function login_process()
	{
		if( isset($_POST['u_login']) ){
			
			$u_name = $_POST['u_name'];
			$u_pass = md5($_POST['u_pass']);

			$this->load->database();
			$users_list = $this->db->get_where('users', array( 'u_name' => $u_name ));
			
			if ($users_list->num_rows() > 0) {
				$user = $users_list->row();
				
				if ($u_pass == $user->u_pass) {
					$this->load->library('session');
					$this->session->set_userdata('u_name', $u_name);
					redirect('dash','refresh');
				} else {
					$data['error'] = 'Username or Password Incorrect!';
					$this->load->view('home', $data);
				}
			} else {
				$data['error'] = 'Username not found!';
				$this->load->view('home', $data);
			}

		} else {
			redirect('home','refresh');
		}
	}

	public function register_process()
	{
		if( $this->input->post('u_reg') ){
			
			$u_email = $this->input->post('u_email');
			$u_name = $this->input->post('u_name');
			$u_pass = md5($this->input->post('u_pass'));

			$user_data = array(
				'u_email'	=> $u_email,
				'u_name'	=> $u_name,
				'u_pass'	=> $u_pass
			);

			$this->Users->insert_user( $user_data );
			redirect('home','refresh');

		}else{
			redirect('home','refresh');
		}
	}

	public function logout()
	{
		session_unset();
		session_destroy();
		redirect('home','refresh');
	}

}
