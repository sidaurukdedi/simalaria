<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employment extends CI_Controller {

	public $data = array(
                        'modul'         => 'employment',
                        'breadcrumb'    => 'Employment',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        'main_view'     => 'employment/employment',
                        'form_action'   => '',
                        'form_value'    => '',
                        'nav_employment' => '',
                        'tree_menu_master' => '',
                        );

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Employment_model', 'employment', TRUE);
	}

	public function index($offset = 0)
	{
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['nav_employment'] = 'active';
            $this->data['tree_menu_master'] = 'active';
		// hapus data temporary proses update
            $this->session->unset_userdata('id_employment_sekarang', '');
            $this->session->unset_userdata('employment_sekarang', '');

        // Cari semua data Employment
            $employment = $this->employment->cari_semua($offset);

        // data employment ada, tampilkan
            if ($employment)
            {
            // buat tabel
                $tabel = $this->employment->buat_tabel($employment);
                $this->data['tabel_data'] = $tabel;
                // Paging
                // http://localhost:8080/CodeIgniter-3.1.0/sim/index.php/employment/pages/2
                $this->data['pagination'] = $this->employment->paging(site_url('employment/pages'));
                
            }
        // data kelas tidak ada
            else
            {
                $this->data['pesan'] = 'Tidak ada data Employment.';
                $this->load->view('template', $this->data);
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
            $this->data['breadcrumb']  = 'Employment > Add';
            $this->data['main_view']   = 'employment/employment_form';
            $this->data['form_action'] = 'employment/tambah';
            $this->data['nav_employment'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // submit
            if($this->input->post('submit'))
            {
            // validasi sukses
                if($this->employment->validasi_tambah())
                {
                    if($this->employment->tambah())
                    {
                        $this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
                        redirect('employment');
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


    public function edit($id_employment = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Employment > Edit';
            $this->data['main_view']   = 'employment/employment_form';
            $this->data['form_action'] = 'employment/edit/' . $id_employment;
            $this->data['nav_employment'] = 'active';
            $this->data['tree_menu_master'] = 'active';

            if( ! empty($id_employment))
            {
                if($this->input->post('submit'))
                {
                // validasi berhasil
                    if($this->employment->validasi_edit() === TRUE)
                    {
                    //update db
                        $this->employment->edit($this->session->userdata('id_employment_sekarang'));
                        $this->session->set_flashdata('pesan', 'Proses update data berhasil.');

                        redirect('employment');
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
                    $employment = $this->employment->cari($id_employment);
                    foreach($employment as $key => $value)
                    {
                        $this->data['form_value'][$key] = $value;
                    // print_r($key);
                    // die();
                    }

                // set temporary data for edit
                    $this->session->set_userdata('id_employment_sekarang', $employment->id_employment);
                    $this->session->set_userdata('employment_sekarang', $employment->employment);

                    $this->load->view('template', $this->data);
                }
            }
        // tidak ada parameter id_kelas, kembalikan ke halaman kelas
            else
            {
                redirect('employment');
            }
        }   
        else {
            redirect('error');
        }
    }

    public function delete($id_employment = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
        // pastikan id_employment yang akan dihapus
            if( ! empty($id_employment))
            {
                if($this->employment->hapus($id_employment))
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                    redirect('employment');
                }
                else
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                    redirect('employment');
                }
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('employment');
            }
        }   
        else {
            redirect('error');
        }
    }


    // callback, apakah id_employment sama? untuk proses edit
    function is_id_employment_exist()
    {
        $id_employment_sekarang     = $this->session->userdata('id_employment_sekarang');
        $id_employment_baru         = $this->input->post('id_employment');

        // jika id_employment baru dan id_employment yang sedang diedit sama biarkan
        // artinya id_employment tidak diganti
        if ($id_employment_baru === $id_employment_sekarang)
        {
            return TRUE;
        }
        // jika id_employment yang sedang diupdate (di session) dan yang baru (dari form) tidak sama,
        // artinya id_employment mau diganti
        // cek di database apakah id_employment sudah terpakai?
        else
        {
            // cek database untuk id_employment yang sama
            $query = $this->db->get_where('employment', array('id_employment' => $id_employment_baru));

            // id_employment sudah dipakai
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_id_employment_exist',
                                                    "Kelas dengan kode $id_employment_baru sudah terdaftar");
                return FALSE;
            }
            // id_employment belum dipakai, OK
            else
            {
                return TRUE;
            }
        }
    }

    // callback, apakah nama employment sama? untuk proses edit
    function is_employment_exist()
    {
        $employment_sekarang    = $this->session->userdata('employment_sekarang');
        $employment_baru        = $this->input->post('employment');

        if ($employment_baru === $employment_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk nama employment yang sama
            $query = $this->db->get_where('employment', array('employment' => $employment_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_employment_exist',
                                                    "Kelas dengan nama $employment_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }
}

/* End of file Employment.php */
/* Location: ./application/controllers/Employment.php */