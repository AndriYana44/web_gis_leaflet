<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_login');
	}


	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('password', 'Password', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));

		if ($this->form_validation->run() == true) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$this->user_login->login($username, $password);
		}
		$data = array(
			'title' => 'Login USer',
			'isi'	=> 'v_login'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function logout()
	{
		$this->user_login->logout();
	}

	public function forget_pass() {
		$data = array(
			'user' => $this->input->post('user'),
			'newuser' => $this->input->post('newuser'),
			'pass1' => $this->input->post('pass1'),
			'pass2' => $this->input->post('pass2')
		);
		if($data['pass1'] == $data['pass2']) {
			$this->m_login->ubah_password($data);
		}else{
			echo "<script>
					alert('Password tidak sinkron!');
				  </script>";
		}
	}
}

/* End of file Auth.php */
