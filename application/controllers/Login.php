<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public $data = array(
                        'modul'         => 'department',
                        'breadcrumb'    => 'Department',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        //'main_view'     => 'department/department',
                        'form_action'   => '',
                        'form_value'    => '',
                        'nav_department'=> '',
                        'tree_menu_master' => '',
                        );

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('Login_model', 'login', TRUE);
    }

	public function index()
	{
		// status user login = BENAR, pindah ke halaman absen
		if ($this->session->userdata('logged_in') == TRUE)
		{
			redirect('dashboard');
		}
		else{
			$this->data['form_action'] = 'login/verify_login';
			$this->load->view('login', $this->data);
		}
	}

	public function verify_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		// submit
		if($this->input->post('submit'))
		{
			$verify = $this->login->cek_user($username, $password);
			if ($verify == FALSE)
			{	
				$this->session->set_flashdata('error_login', 'Login failed, please check your username and password');	
				redirect('login');
			}
			else
			{

				foreach ($verify->result() as $row) {
					$logdata = array(
						'id_user'	=> $row->id_user,
						//'username'  => $row->username,
						'name_user'	=> $row->name,
						'level'  	=> $row->level,
						'photo'  	=> $row->photo,
						'logged_in' => TRUE);
					// echo "<pre>";
					// print_r ($logdata);
					// echo "</pre>";
					// die();
					$this->session->set_userdata($logdata);
				}
				

				redirect('dashboard');
			}
        }
        // no submit
        else
        {
            $this->load->view('dashboard');
        }
	}

	public function logout()
	{
        $this->login->logout();
		redirect('login');
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */