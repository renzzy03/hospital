<?php
defined('BASEPATH') OR exit ('no direct script access allowed');

class Login_model extends CI_Model
{
    private $table = 'user_tbl';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_user()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function auth_user($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->row_array();
    }

}
?>