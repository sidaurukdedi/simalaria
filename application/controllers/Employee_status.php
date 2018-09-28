<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_status extends MY_Controller {

	public $data = array(
                        'modul'         		=> 'employee_status',
                        'breadcrumb'    		=> 'Employee Status',
                        'pesan'         		=> '',
                        'pagination'    		=> '',
                        'tabel_data'    		=> '',
                        'main_view'     		=> 'employee_status/employee_status',
                        'form_action'   		=> '',
                        'form_value'    		=> '',
                        'nav_employee_status'	=> '',
                        'tree_menu_master' 		=> '',
                        );

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Employee_status_model', 'employee_status', TRUE);
	}

	public function index()
	{
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['nav_employee_status'] = 'active';
            $this->data['tree_menu_master'] = 'active';
		// hapus data temporary proses update
            $this->session->unset_userdata('id_employee_status_sekarang', '');
            $this->session->unset_userdata('employee_status_sekarang', '');

        // Cari semua data Employee Status
            $employee_status = $this->employee_status->cari_semua();

        // data employee status ada, tampilkan
            if ($employee_status)
            {
            // buat tabel
                $tabel = $this->employee_status->buat_tabel($employee_status);
                $this->data['tabel_data'] = $tabel;
                $this->load->view('template', $this->data);
            }
        // data employee status tidak ada
            else
            {
                $this->data['pesan'] = 'Tidak ada data Employee Status.';
                $this->load->view('template', $this->data);
            }
        }   
        else {
            redirect('error');
        }
    }

	public function tambah()
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Employee Status > Add';
            $this->data['main_view']   = 'employee_status/employee_status_form';
            $this->data['form_action'] = 'employee_status/tambah';
            $this->data['nav_employee_status'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // submit
            if($this->input->post('submit'))
            {
            // validasi sukses
                if($this->employee_status->validasi_tambah())
                {
                    if($this->employee_status->tambah())
                    {
                        $this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
                        redirect('employee_status');
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

    public function edit($id_employee_status = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Employee Status > Edit';
            $this->data['main_view']   = 'employee_status/employee_status_form';
            $this->data['form_action'] = 'employee_status/edit/' . $id_employee_status;
            $this->data['nav_employee_status'] = 'active';
            $this->data['tree_menu_master'] = 'active';

            if( ! empty($id_employee_status))
            {
                if($this->input->post('submit'))
                {
                // validasi berhasil
                    if($this->employee_status->validasi_edit() === TRUE)
                    {
                    //update db
                        $this->employee_status->edit($this->session->userdata('id_employee_status_sekarang'));
                        $this->session->set_flashdata('pesan', 'Proses update data berhasil.');

                        redirect('employee_status');
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
                    $employee_status = $this->employee_status->cari($id_employee_status);
                    foreach($employee_status as $key => $value)
                    {
                        $this->data['form_value'][$key] = $value;
                    // print_r($key);
                    // die();
                    }

                // set temporary data for edit
                    $this->session->set_userdata('id_employee_status_sekarang', $employee_status->id_employee_status);
                    $this->session->set_userdata('employee_status_sekarang', $employee_status->employee_status);

                    $this->load->view('template', $this->data);
                }
            }
        // tidak ada parameter id_employee_status, kembalikan ke halaman kelas
            else
            {
                redirect('employee_status');
            }
        }   
        else {
            redirect('error');
        }
    }

    public function delete($id_employee_status = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
        // pastikan id_employee_status yang akan dihapus
            if( ! empty($id_employee_status))
            {
                if($this->employee_status->hapus($id_employee_status))
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                    redirect('employee_status');
                }
                else
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                    redirect('employee_status');
                }
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('employee_status');
            }
        }   
        else {
            redirect('error');
        }
    }

    // callback, apakah id_employee_status sama? untuk proses edit
    function is_id_employee_status_exist()
    {
        $id_employee_status_sekarang     = $this->session->userdata('id_employee_status_sekarang');
        $id_employee_status_baru         = $this->input->post('id_employee_status');

        // jika id_employee_status baru dan id_employee_status yang sedang diedit sama biarkan
        // artinya id_employee_status tidak diganti
        if ($id_employee_status_baru === $id_employee_status_sekarang)
        {
            return TRUE;
        }
        // jika id_employee_status yang sedang diupdate (di session) dan yang baru (dari form) tidak sama,
        // artinya id_employee_status mau diganti
        // cek di database apakah id_employee_status sudah terpakai?
        else
        {
            // cek database untuk id_employee_status yang sama
            $query = $this->db->get_where('employee_status', array('id_employee_status' => $id_employee_status_baru));

            // id_employee_status sudah dipakai
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_id_employee_status_exist',
                                                    "Kelas dengan kode $id_employee_status_baru sudah terdaftar");
                return FALSE;
            }
            // id_employee_status belum dipakai, OK
            else
            {
                return TRUE;
            }
        }
    }

    // callback, apakah nama employee_status sama? untuk proses edit
    function is_employee_status_exist()
    {
        $employee_status_sekarang    = $this->session->userdata('employee_status_sekarang');
        $employee_status_baru        = $this->input->post('employee_status');

        if ($employee_status_baru === $employee_status_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk nama employee_status yang sama
            $query = $this->db->get_where('employee_status', array('employee_status' => $employee_status_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_employee_status_exist',
                                                    "Kelas dengan nama $employee_status_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }

}

/* End of file Employee_status.php */
/* Location: ./application/controllers/Employee_status.php */