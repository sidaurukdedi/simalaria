<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public $db_tabel = 'user';

	public function cek_user($username, $password)
	{
		$this->db->select('user.id_user, employee.name, user.username, user.level, employee.photo');
		$this->db->join('employee', 'employee.id_employee = user.id_employee');
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));


		$query = $this->db->get($this->db_tabel);
		if($this->db->affected_rows() > 0)
		{
			return $query;
		}
		else
		{
			return FALSE;
		}
	}

	public function logout()
	{
		$this->session->unset_userdata(array(
									'id_user'	=> '',
									'name_user'  => '',
									'level'  	=> '',
									'logged_in' => FALSE));
		$this->session->sess_destroy();
	}
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */