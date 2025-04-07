<?php

defined('BASEPATH') OR exit ('no direct script access allowed');

class Login extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->library('form_validation');
		$this->load->library('session');
        $this->load->library('upload');
		$this->load->helper('url');
	}
	
	public function index()
	{
		$data['login'] = $this->Login_model->get_all_user();
		$this->load->view('login/index', $data);
	}
	
	public function auth()
    {
        // Set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // If validation fails
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login/index');
        } else {
            $email    = $this->input->post('email');
            $password = $this->input->post('password');

            // Check user credentials
            $user = $this->Login_model->auth_user($email);

            if ($user && password_verify($password, $user['password'])) {
                // Set session data
                $session_data = [
                    'id'        => $user['id'],
                    'firstname' => $user['firstname'],
                    'lastname'  => $user['lastname'],
                    'email'     => $user['email'],
                    'logged_in' => TRUE
                ];

                $this->session->set_userdata($session_data);
                redirect('patient/index');
				
            } else {
                $this->session->set_flashdata('error', 'Invalid email or password!');
                $this->load->view('login/index');
            }
        }
    }
}

?>