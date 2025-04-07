<?php
defined('BASEPATH') OR exit ('no direct script access allowed');

class Register_model extends CI_Model
{
    private $table = 'user_tbl';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function registerView()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function add_user($data)
    {
        return $this->db->insert($this->table, $data);
    }

}
?>