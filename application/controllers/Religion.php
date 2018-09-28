<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Religion extends CI_Controller {

    public $data = array(
        'modul'         => 'religion',
        'breadcrumb'    => 'Religion',
        'pesan'         => '',
        'pagination'    => '',
        'tabel_data'    => '',
        'main_view'     => 'religion/religion',
        'form_action'   => '',
        'form_value'    => '',
        'nav_education' => '',
        'tree_menu_master' => '',
        );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Religion_model', 'religion', TRUE);
    }

    public function index()
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
                // hapus data temporary proses update
            $this->session->unset_userdata('id_religion_sekarang', '');
            $this->session->unset_userdata('religion_sekarang', '');
            $this->data['nav_religion'] = 'active';
            $this->data['tree_menu_master'] = 'active';

                // Cari semua data Religion
            $religion = $this->religion->cari_semua();

                // data religion ada, tampilkan
            if ($religion)
            {
            // buat tabel
                $tabel = $this->religion->buat_tabel($religion);
                $this->data['tabel_data'] = $tabel;
                $this->load->view('template', $this->data);
            }
            // data religion tidak ada
            else
            {
                $this->data['pesan'] = 'Tidak ada data Religion.';
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
            $this->data['breadcrumb']       = 'Religion > Add';
            $this->data['main_view']        = 'religion/religion_form';
            $this->data['form_action']      = 'religion/tambah';
            $this->data['nav_religion']    = 'active';
            $this->data['tree_menu_master'] = 'active';

        // submit
            if($this->input->post('submit'))
            {
            // validasi sukses
                if($this->religion->validasi_tambah())
                {
                    if($this->religion->tambah())
                    {
                        $this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
                        redirect('religion');
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

    public function edit($id_religion = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Religion > Edit';
            $this->data['main_view']   = 'religion/religion_form';
            $this->data['form_action'] = 'religion/edit/' . $id_religion;
            $this->data['nav_religion'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // pastikan id_religion ada
            if( ! empty($id_religion))
            {
                if($this->input->post('submit'))
                {
                // validasi berhasil
                    if($this->religion->validasi_edit() === TRUE)
                    {
                    //update db
                        $this->religion->edit($this->session->userdata('id_religion_sekarang'));
                        $this->session->set_flashdata('pesan', 'Proses update data berhasil.');

                        redirect('religion');
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
                    $religion = $this->religion->cari($id_religion);
                    foreach($religion as $key => $value)
                    {
                        $this->data['form_value'][$key] = $value;
                    }

                // set temporary data for edit
                    $this->session->set_userdata('id_religion_sekarang', $religion->id_religion);
                    $this->session->set_userdata('religion_sekarang', $religion->religion);

                    $this->load->view('template', $this->data);
                }
            }
        // tidak ada parameter id_religion, kembalikan ke halaman kelas
            else
            {
                redirect('religion');
            }
        }   
        else {
            redirect('error');
        }
    }

    public function delete($id_religion = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
        // pastikan id_religion yang akan dihapus
            if( ! empty($id_religion))
            {
                if($this->religion->hapus($id_religion))
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                    redirect('religion');
                }
                else
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                    redirect('religion');
                }
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('religion');
            }
        }   
        else {
            redirect('error');
        }
    }

    // callback, apakah id_religion sama? untuk proses edit
    function is_id_religion_exist()
    {
        $id_religion_sekarang   = $this->session->userdata('id_religion_sekarang');
        $id_religion_baru       = $this->input->post('id_religion');

        // jika id_religion baru dan id_religion yang sedang diedit sama biarkan
        // artinya id_religion tidak diganti
        if ($id_religion_baru === $id_religion_sekarang)
        {
            return TRUE;
        }
        // jika id_religion yang sedang diupdate (di session) dan yang baru (dari form) tidak sama,
        // artinya id_religion mau diganti
        // cek di database apakah id_religion sudah terpakai?
        else
        {
            // cek database untuk id_education yang sama
            $query = $this->db->get_where('religion', array('id_religion' => $id_religion_baru));

            // id_religion sudah dipakai
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_id_religion_exist',
                                                    "Kelas dengan kode $id_religion_baru sudah terdaftar");
                return FALSE;
            }
            // id_religion belum dipakai, OK
            else
            {
                return TRUE;
            }
        }
    }

    // callback, apakah nama education sama? untuk proses edit
    function is_religion_exist()
    {
        $religion_sekarang    = $this->session->userdata('religion_sekarang');
        $religion_baru        = $this->input->post('religion');

        if ($religion_baru === $religion_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk nama education yang sama
            $query = $this->db->get_where('religion', array('religion' => $religion_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_religion_exist',
                                                    "Kelas dengan nama $religion_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }



}

/* End of file Religion.php */
/* Location: ./application/controllers/Religion.php */