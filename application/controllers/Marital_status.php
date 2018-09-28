<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marital_status extends MY_Controller {

	public $data = array(
                        'modul'         => 'marital_status',
                        'breadcrumb'    => 'Marital Status',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        'main_view'     => 'marital_status/marital_status',
                        'form_action'   => '',
                        'form_value'    => '',
                        'nav_education' => '',
                        'tree_menu_master' => '',
                        );

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Marital_model', 'marital', TRUE);
	}

	public function index()
	{
        $level = $this->session->userdata('level');
        if ($level == "HR"){
		// hapus data temporary proses update
            $this->session->unset_userdata('id_marital_status_sekarang', '');
            $this->session->unset_userdata('marital_status_sekarang', '');
            $this->data['nav_marital'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // Cari semua data Marital Status
            $marital = $this->marital->cari_semua();

        // data marital ada, tampilkan
            if ($marital)
            {
            // buat tabel
                $tabel = $this->marital->buat_tabel($marital);
                $this->data['tabel_data'] = $tabel;
                $this->load->view('template', $this->data);
            }
        // data marital tidak ada
            else
            {
                $this->data['pesan'] = 'Tidak ada data Marital Status.';
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
            $this->data['breadcrumb']  = 'Marital > Add';
            $this->data['main_view']   = 'marital_status/marital_status_form';
            $this->data['form_action'] = 'marital_status/tambah';
            $this->data['nav_marital'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // submit
            if($this->input->post('submit'))
            {
            // validasi sukses
                if($this->marital->validasi_tambah())
                {
                    if($this->marital->tambah())
                    {
                        $this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
                        redirect('marital_status');
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

    public function edit($id_marital_status = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Marital Status > Edit';
            $this->data['main_view']   = 'marital_status/marital_status_form';
            $this->data['form_action'] = 'marital_status/edit/' . $id_marital_status;
            $this->data['nav_marital'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // pastikan id_marital_status ada
            if( ! empty($id_marital_status))
            {
                if($this->input->post('submit'))
                {
                // validasi berhasil
                    if($this->marital->validasi_edit() === TRUE)
                    {
                    //update db
                        $this->marital->edit($this->session->userdata('id_marital_status_sekarang'));
                        $this->session->set_flashdata('pesan', 'Proses update data berhasil.');

                        redirect('marital_status');
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
                    $marital = $this->marital->cari($id_marital_status);
                    foreach($marital as $key => $value)
                    {
                        $this->data['form_value'][$key] = $value;
                    }

                // set temporary data for edit
                    $this->session->set_userdata('id_marital_status_sekarang', $marital->id_marital_status);
                    $this->session->set_userdata('marital_status_sekarang', $marital->marital_status);

                    $this->load->view('template', $this->data);
                }
            }
        // tidak ada parameter id_marital_status, kembalikan ke halaman Marital Status
            else
            {
                redirect('marital_status');
            }
        }   
        else {
            redirect('error');
        }
    }

    public function delete($id_marital_status = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
        // pastikan id_marital_status yang akan dihapus
            if( ! empty($id_marital_status))
            {
                if($this->marital->hapus($id_marital_status))
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                    redirect('marital_status');
                }
                else
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                    redirect('marital_status');
                }
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('marital_status');
            }
        }   
        else {
            redirect('error');
        }
    }

    // callback, apakah id_marital_status sama? untuk proses edit
    function is_id_marital_status_exist()
    {
        $id_marital_status_sekarang = $this->session->userdata('id_marital_status_sekarang');
        $id_marital_status_baru     = $this->input->post('id_marital_status');

        // jika id_marital_status baru dan id_marital_status yang sedang diedit sama biarkan
        // artinya id_marital_status tidak diganti
        if ($id_marital_status_baru === $id_marital_status_sekarang)
        {
            return TRUE;
        }
        // jika id_marital_status yang sedang diupdate (di session) dan yang baru (dari form) tidak sama,
        // artinya id_marital_status mau diganti
        // cek di database apakah id_marital_status sudah terpakai?
        else
        {
            // cek database untuk id_education yang sama
            $query = $this->db->get_where('marital_status', array('id_marital_status' => $id_marital_status_baru));

            // id_marital_status sudah dipakai
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_id_marital_status_exist',
                                                    "Kelas dengan kode $id_marital_status_baru sudah terdaftar");
                return FALSE;
            }
            // id_marital_status belum dipakai, OK
            else
            {
                return TRUE;
            }
        }
    }

    // callback, apakah nama marital_status sama? untuk proses edit
    function is_marital_status_exist()
    {
        $marital_status_sekarang    = $this->session->userdata('marital_status_sekarang');
        $marital_status_baru        = $this->input->post('marital_status');

        if ($marital_status_baru === $marital_status_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk nama marital_status yang sama
            $query = $this->db->get_where('marital_status', array('marital_status' => $marital_status_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_marital_status_exist',
                                                    "Kelas dengan nama $marital_status_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }

}

/* End of file Marital_status.php */
/* Location: ./application/controllers/Marital_status.php */