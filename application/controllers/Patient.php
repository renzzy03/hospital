<?php

defined('BASEPATH') OR exit ('no direct script access allowed');

class Patient extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		$this->load->model('Patient_model');
		$this->load->library('form_validation');
		$this->load->library('session');
        $this->load->library('upload');
		$this->load->helper('url');
	}
	
	public function index()
	{
		$data['patients'] = $this->Patient_model->get_all_patients();
		$this->load->view('patients/index', $data);
	}

    //add new patient with form validation
    public function add()
    {
        $this->form_validation->set_rules('firstname', 'Firstname', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('middlename', 'Middlename', 'required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('address', 'Address', 'required|max_length[30]');
        $this->form_validation->set_rules('birthdate', 'Birthdate', 'required');
        $this->form_validation->set_rules('sex', 'Sex', 'required|in_list[Male,Female]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[patients.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|min_length[10]|max_length[15]');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('patients/add');
        } else {

            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 2048;
            $config['file_name']     = time() . "_" . $_FILES['profile_image']['name'];
    
            $this->upload->initialize($config);
    

            if ($this->upload->do_upload('profile_image')) {
                $uploadData = $this->upload->data();
                $image = $uploadData['file_name']; 
            } else {
                $image = null; 
            }
    
            // Prepare data to insert
            $patient_data = [
                'firstname'      => $this->input->post('firstname'),
                'middlename'     => $this->input->post('middlename'),
                'lastname'       => $this->input->post('lastname'),
                'address'        => $this->input->post('address'),
                'birthdate'      => $this->input->post('birthdate'),
                'sex'            => $this->input->post('sex'),
                'email'          => $this->input->post('email'),
                'phone'          => $this->input->post('phone'),
                'profile_image'  => $image,
                'created_at'     => date('Y-m-d H:i:s')
            ];
    
            // Insert data into DB
            if ($this->Patient_model->insert_patient($patient_data)) {
                $this->session->set_flashdata('success', 'Patient added successfully');
                redirect('patient/index');
            } else {
                $this->session->set_flashdata('error', 'Failed to add patient');
                $this->load->view('patients/add');
            }
        }
    }
    
    //update patient with form validation
    public function update($id)
    {

        $this->load->model('Patient_model');
        $data['patient'] = $this->Patient_model->get_patient_by_id($id);

        if (!$data['patient']) {
            show_404();
        }

        $this->form_validation->set_rules('firstname', 'Firstname', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('middlename', 'Middlename', 'required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('address', 'Address', 'required|max_length[30]');
        $this->form_validation->set_rules('birthdate', 'Birthdate', 'required');
        $this->form_validation->set_rules('sex', 'Sex', 'required|in_list[Male,Female]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|min_length[10]|max_length[15]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('patients/edit', $data);

        } else {

            $update_data = [
                'firstname'      => $this->input->post('firstname'),
                'middlename'     => $this->input->post('middlename'),
                'lastname'       => $this->input->post('lastname'),
                'address'        => $this->input->post('address'),
                'birthdate'      => $this->input->post('birthdate'),
                'sex'            => $this->input->post('sex'),
                'email'          => $this->input->post('email'),
                'phone'          => $this->input->post('phone'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if(!empty($_FILES['profile_image']['name'])){

                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']      = 2048;
                $config['file_name']     = time() . "_" . $_FILES['profile_image']['name'];
        
                $this->upload->initialize($config);
        
                if ($this->upload->do_upload('profile_image')) {
                    $uploadData = $this->upload->data();
                    $update_data['profile_image'] = $uploadData['file_name']; 
                } else {
                    $image = $patient['profile_image'];
                }
            }
          
            if ($this->Patient_model->update_patient($id, $update_data)) {
                $this->session->set_flashdata('success', 'Patient Updated Successfully');
                redirect('patient/index');
            } else {
                $this->session->set_flashdata('error', 'Failed to update patient');
                redirect('patient/edit/' . $id);
            }
        }
    }

    //delete patient
    public function delete($id)
    {
        if($this->Patient_model->delete_patient($id)){
            $this->session->set_flashdata('success','Patient Deleted Successfully!');
        }else{
            $this->session->set_flashdata('error','Failed to delete patient');
        }
        redirect('patient/index');
    }

    public function getPatientByID($id)
    {
        $output = [];
        $data = $this->Patient_model->get_patient_by_id($id);

        $output = array(
           'profile_image' => base_url() . 'uploads/' . $data['profile_image'],
           'name' => $data['firstname'] . ' ' . $data['middlename'] . ' ' . $data['lastname'], 
           'birthdate' => date('m/d/Y', strtotime($data['birthdate'])),
           'sex'     => $data['sex'],
           'address' => $data['address'],
           'email'   => $data['email'],
           'phone'   => $data['phone'],

        );

        return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($output));

    }



}
?>