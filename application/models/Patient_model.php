<?php
defined('BASEPATH') OR exit ('no direct script access allowed');

class Patient_model extends CI_Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'firstname',
        'middlename',
        'lastname',
        'email',
        'phone',
        'address',
        'birthdate',
        'sex',
        'profile_image'
    ];
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_patient_list()
    {
        $this->db->query("
        SELECT 
            id,
            name,
            phone,
            email 
             FROM patients");
        return $query->result_array();
    }

    public function get_patient_list_all()
    {
        $this->db->select('
            id,
            name,
            phone,
            email ');
            $this->db->from($this->table);
            return $this->db->get()->result_array();
    }

    //Insert Patient Data
    public function insert_patient($data)
    {
        return $this->db->insert($this->table, $data);
    }

    //Get All Patient Data
    public function get_all_patients()
    {
        return $this->db->get($this->table)->result_array();
    }

    //Get a Patient Data by ID
    public function get_patient_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    //Update Patient Data
    public function update_patient($id,$data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    //Delete Patient Data
    public function delete_patient($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

}




?>