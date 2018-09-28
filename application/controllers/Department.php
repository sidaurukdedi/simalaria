<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends MY_Controller {

	public $data = array(
                        'modul'         => 'department',
                        'breadcrumb'    => 'Department',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        'main_view'     => 'department/department',
                        'form_action'   => '',
                        'form_value'    => '',
                        'nav_department'=> '',
                        'tree_menu_master' => '',
                        );

    public function __construct()
	{
		parent::__construct();		
		$this->load->model('Department_model', 'department', TRUE);
    }

    public function index($offset = 0)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['nav_department'] = 'active';
            $this->data['tree_menu_master'] = 'active';
		      // hapus data temporary proses update
            $this->session->unset_userdata('id_department_sekarang', '');
            $this->session->unset_userdata('department_sekarang', '');

            // Cari semua data Department
            $department = $this->department->cari_semua($offset);

            // data department ada, tampilkan
            if ($department)
            {
            // buat tabel
                $tabel = $this->department->buat_tabel($department);
                $this->data['tabel_data'] = $tabel;
                //$this->load->view('template', $this->data);
                // Paging
                // http://localhost:8080/CodeIgniter-3.1.0/sim/index.php/department/pages/2
                $this->data['pagination'] = $this->department->paging(site_url('department/pages'));
            }
            // data department tidak ada
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
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Department > Add';
            $this->data['main_view']   = 'department/department_form';
            $this->data['form_action'] = 'department/tambah';
            $this->data['nav_department'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // submit
            if($this->input->post('submit'))
            {
            // validasi sukses
                if($this->department->validasi_tambah())
                {
                    if($this->department->tambah())
                    {
                        $this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
                        redirect('department');
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
        // no submit
            else
            {
                $this->load->view('template', $this->data);
            }
        }
        else {
            redirect('error');
        }
    }

    public function edit($id_department = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Department > Edit';
            $this->data['main_view']   = 'department/department_form';
            $this->data['form_action'] = 'department/edit/' . $id_department;
            $this->data['nav_department'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // pastikan id_department ada
            if( ! empty($id_department))
            {
                if($this->input->post('submit'))
                {
                // validasi berhasil
                    if($this->department->validasi_edit() === TRUE)
                    {
                    //update db
                        $this->department->edit($this->session->userdata('id_department_sekarang'));
                        $this->session->set_flashdata('pesan', 'Proses update data berhasil.');

                        redirect('department');
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
                // ambil data dari database, $form_value sebagai nilai dafault form
                    $department = $this->department->cari($id_department);
                    foreach($department as $key => $value)
                    {
                        $this->data['form_value'][$key] = $value;
                    // print_r($key);
                    // die();
                    }

                // set temporary data for edit
                    $this->session->set_userdata('id_department_sekarang', $department->id_department);
                    $this->session->set_userdata('department_sekarang', $department->department);

                    $this->load->view('template', $this->data);
                }
            }
        // tidak ada parameter id_kelas, kembalikan ke halaman kelas
            else
            {
                redirect('department');
            }
        }
        else {
            redirect('error');
        }
    }

    public function delete($id_department = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
        // pastikan id_department yang akan dihapus
            if( ! empty($id_department))
            {
                if($this->department->hapus($id_department))
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                    redirect('department');
                }
                else
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                    redirect('department');
                }
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('department');
            }
        }
        else {
            redirect('error');
        }
    }

    // callback, apakah id_department sama? untuk proses edit
    function is_id_department_exist()
    {
        $id_department_sekarang 	= $this->session->userdata('id_department_sekarang');
        $id_department_baru			= $this->input->post('id_department');

        // jika id_department baru dan id_department yang sedang diedit sama biarkan
        // artinya id_department tidak diganti
        if ($id_department_baru === $id_department_sekarang)
        {
            return TRUE;
        }
        // jika id_department yang sedang diupdate (di session) dan yang baru (dari form) tidak sama,
        // artinya id_department mau diganti
        // cek di database apakah id_department sudah terpakai?
        else
        {
            // cek database untuk id_department yang sama
            $query = $this->db->get_where('department', array('id_department' => $id_department_baru));

            // id_department sudah dipakai
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_id_department_exist',
                                                    "Kelas dengan kode $id_department_baru sudah terdaftar");
                return FALSE;
            }
            // id_department belum dipakai, OK
            else
            {
                return TRUE;
            }
        }
    }

    // callback, apakah nama department sama? untuk proses edit
    function is_department_exist()
    {
        $department_sekarang 	= $this->session->userdata('department_sekarang');
        $department_baru		= $this->input->post('department');

        if ($department_baru === $department_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk nama department yang sama
            $query = $this->db->get_where('department', array('department' => $department_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_department_exist',
                                                    "Kelas dengan nama $department_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }
}

/* End of file Department.php */
/* Location: ./application/controllers/Department.php */