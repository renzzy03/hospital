<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Register_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('register/index');
    }

    public function add()
    {
        // Set form validation rules
        $this->form_validation->set_rules('firstname', 'Firstname', 'required|regex_match[/^[a-zA-Z ]+$/]');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required|regex_match[/^[a-zA-Z ]+$/]');        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user_tbl.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        // If validation fails
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('register/index');
        } else {
            // Data to insert
            $register_data = [
                'firstname'  => $this->input->post('firstname'),
                'lastname'   => $this->input->post('lastname'),
                'email'      => $this->input->post('email'),
                'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Insert data into DB
            if ($this->Register_model->add_user($register_data)) {
                $this->session->set_flashdata('success', 'User registered successfully!');
                redirect('register');
            } else {
                $this->session->set_flashdata('error', 'Failed to register user.');
                $this->load->view('register/index');
            }
        }
    }
}
