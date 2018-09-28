<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends MY_Controller {

	public $data = array(
                        'modul'         => 'user_management',
                        'breadcrumb'    => 'User Management',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        'main_view'     => 'user_management/user_management',
                        'form_action'   => '',
                        'form_value'    => '',
                        'nav_department'=> '',
                        'tree_menu_master' => '',
                        );
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_management_model', 'user_management', TRUE);
		$this->load->model('Employee_model', 'employee', TRUE);
	}

	public function index($offset = 0)
    {
        $level = $this->session->userdata('level');
        if ($level == "Staff"){

            $this->data['nav_user_management'] = 'active';
            $this->data['tree_menu_master'] = 'active';
		      // hapus data temporary proses update
            $this->session->unset_userdata('id_user_sekarang', '');
            $this->session->unset_userdata('user_sekarang', '');

            // Cari semua data USer
            $user_management = $this->user_management->cari_semua($offset);

            // data user ada, tampilkan
            if ($user_management)
            {
            // buat tabel
                $tabel = $this->user_management->buat_tabel($user_management);
                $this->data['tabel_data'] = $tabel;
                //$this->load->view('template', $this->data);
                // Paging
                // http://localhost:8080/CodeIgniter-3.1.0/sim/index.php/user_management/pages/2
                $this->data['pagination'] = $this->user_management->paging(site_url('user_management/pages'));
            }
            // data user tidak ada
            else
            {
                $this->data['pesan'] = 'Tidak ada data Department.';
                
            }
            $this->load->view('template', $this->data);
        }	
        else {
            redirect('error');
        }
    }

    public function tambah()
    {
        $level = $this->session->userdata('level');
        if ($level == "Staff"){
            $this->data['breadcrumb']  = 'User > Tambah';
            $this->data['main_view']   = 'user_management/user_management_form';
            $this->data['form_action'] = 'user_management/tambah';
            $this->data['nav_user_management'] = 'active';
            $this->data['tree_menu_master'] = 'active';

            // option employee, untuk menu dropdown
            $employee = $this->employee->cari_semua_dropdown();
            // data employee ada
            if($employee)
            {
                $this->data['opt_employee'] = array('' => 'Select One...');
                foreach($employee as $row)
                {
                    $this->data['opt_employee'][$row->id_employee] = $row->name;
                }
            }
            // data employee tidak ada
            else
            {
                $this->data['opt_employee']['00'] = '-';
                $this->data['pesan'] = $this->data['pesan'] . '<br>' . 'Data User tidak tersedia. Silahkan isi dahulu data user.';
            }

            $this->data['opt_level'] = array('' => 'Select One...',
                'Admin' => 'Admin',
                'Staff' => 'Staff',
                'HR'    => 'HR');
            // if submit
            if($this->input->post('submit'))
            {
            // validasi sukses
            	if($this->user_management->validasi_tambah())
            	{
            		if($this->user_management->tambah())
            		{
            			$this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
            			redirect('user_management');
            		}
            		else
            		{
            			$this->data['pesan'] = 'Proses tambah data gagal.';
            			$this->load->view('template', $this->data);
            		}
            	}
                // validasi gagal
            	else
            	{
            		$this->load->view('template', $this->data);
            	}
            }
            // if no submit
            else
            {
                $this->load->view('template', $this->data);
            }
        }   
        else {
            redirect('error');
        }
    }

    public function edit($id_user = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "Staff"){
            $this->data['breadcrumb']  = 'User > Edit';
            $this->data['main_view']   = 'user_management/user_management_form';
            $this->data['form_action'] = 'user_management/edit/' . $id_user;
            $this->data['nav_user_management'] = 'active';
            $this->data['tree_menu_master'] = 'active';

            // option employee
            $employee = $this->employee->cari_semua_dropdown();
            foreach($employee as $row)
            {
                $this->data['opt_employee'][$row->id_employee] = $row->name;
            }
            $this->data['opt_level'] = array('' => 'Select One...',
                'Admin' => 'Admin',
                'Staff' => 'Staff',
                'HR'    => 'HR');


        // Mencegah error http://localhost/absensi2014/siswa/edit/$nis (edit tanpa ada parameter)
        // Ada parameter
            if( ! empty($id_user))
            {
            	// submit
                if($this->input->post('submit'))
                {
                	// validasi berhasil
                    if($this->user_management->validasi_edit() === TRUE)
                    {
                    	//update db
                        $this->user_management->edit($this->session->userdata('id_userakses'));
                        $this->session->set_flashdata('pesan', 'Proses update data berhasil.');
                        redirect('user_management');
                    }
                	// validasi gagal
                    else
                    {
                        $this->load->view('template', $this->data);
                    }

                }
                // tidak disubmit, form pertama kali dimuat
                else
                {
                    // ambil data dari database, $form_value sebagai nilai default form
                    $user_management = $this->user_management->cari($id_user);
                    foreach($user_management as $key => $value)
                    {
                        $this->data['form_value'][$key] = $value;
                    }

                // set temporary data untuk edit
                    $this->session->set_userdata('id_userakses', $user_management->id_user);
                    $this->session->set_userdata('userakses', $user_management->id_employee);
                    $this->load->view('template', $this->data);
                }
            }
        // tidak ada parameter $nis di URL, kembalikan ke halaman siswa
            else
            {
                redirect('user_management');
            }
        }   
        else {
            redirect('error');
        }
    }

    public function delete($id_user = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "Staff"){
        // pastikan id_department yang akan dihapus
            if( ! empty($id_user))
            {
                if($this->user_management->hapus($id_user))
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                    redirect('user_management');
                }
                else
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                    redirect('user_management');
                }
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('user_management');
            }
        }
        else {
            redirect('error');
        }
    }


    public function is_id_user_exist()
    {
        $id_user_sekarang   = $this->session->userdata('id_userakses');
        $id_user_baru       = $this->input->post('id_user');

        if ($id_user_baru === $id_user_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk no employee yang sama
            $query = $this->db->get_where('user', array('id_user' => $id_user_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_id_user_exist',
                                                    "User dengan User ID $id_user_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }

    public function is_user_exist()
    {
        $user_sekarang   = $this->session->userdata('userakses');
        $user_baru       = $this->input->post('id_employee');

        if ($user_baru === $user_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk name yang sama
            $query = $this->db->get_where('user', array('id_employee' => $user_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_user_exist',
                                                    "User dengan ID $user_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }

}

/* End of file User_management.php */
/* Location: ./application/controllers/User_management.php */