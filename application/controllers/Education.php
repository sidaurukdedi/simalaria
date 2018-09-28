<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Education extends MY_Controller {

	public $data = array(
                        'modul'         => 'education',
                        'breadcrumb'    => 'Education',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        'main_view'     => 'education/education',
                        'form_action'   => '',
                        'form_value'    => '',
                        'nav_education' => '',
                        'tree_menu_master' => '',
                        );

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Education_model', 'education', TRUE);
	}

	public function index($offset = 0)
	{
        $level = $this->session->userdata('level');
        if ($level == "HR"){
		// hapus data temporary proses update
            $this->session->unset_userdata('id_education_sekarang', '');
            $this->session->unset_userdata('education_sekarang', '');
            $this->data['nav_education'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // Cari semua data Education
            $education = $this->education->cari_semua($offset);

        // data education ada, tampilkan
            if ($education)
            {
            // buat tabel
                $tabel = $this->education->buat_tabel($education);
                $this->data['tabel_data'] = $tabel;
                // Paging
                // http://localhost:8080/CodeIgniter-3.1.0/sim/index.php/education/pages/2
                $this->data['pagination'] = $this->education->paging(site_url('education/pages'));
            }
        // data kelas tidak ada
            else
            {
                $this->data['pesan'] = 'Tidak ada data Education.';
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
            $this->data['breadcrumb']  = 'Education > Add';
            $this->data['main_view']   = 'education/education_form';
            $this->data['form_action'] = 'education/tambah';
            $this->data['nav_education'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // submit
            if($this->input->post('submit'))
            {
            // validasi sukses
                if($this->education->validasi_tambah())
                {
                    if($this->education->tambah())
                    {
                        $this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
                        redirect('education');
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

    public function edit($id_education = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Education > Edit';
            $this->data['main_view']   = 'education/education_form';
            $this->data['form_action'] = 'education/edit/' . $id_education;
            $this->data['nav_education'] = 'active';
            $this->data['tree_menu_master'] = 'active';

        // pastikan id_education ada
            if( ! empty($id_education))
            {
            // print_r($id_kelas);
            // die();
            // submit
                if($this->input->post('submit'))
                {
                // validasi berhasil
                    if($this->education->validasi_edit() === TRUE)
                    {
                    //update db
                        $this->education->edit($this->session->userdata('id_education_sekarang'));
                        $this->session->set_flashdata('pesan', 'Proses update data berhasil.');

                        redirect('education');
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
                    $education = $this->education->cari($id_education);
                    foreach($education as $key => $value)
                    {
                        $this->data['form_value'][$key] = $value;
                    // print_r($key);
                    // die();
                    }

                // set temporary data for edit
                    $this->session->set_userdata('id_education_sekarang', $education->id_education);
                    $this->session->set_userdata('education_sekarang', $education->education);

                    $this->load->view('template', $this->data);
                }
            }
        // tidak ada parameter id_education, kembalikan ke halaman kelas
            else
            {
                redirect('education');
            }
        }   
        else {
            redirect('error');
        }
    }

    public function delete($id_education = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
        // pastikan id_education yang akan dihapus
            if( ! empty($id_education))
            {
                if($this->education->hapus($id_education))
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                    redirect('education');
                }
                else
                {
                    $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                    redirect('education');
                }
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('education');
            }
        }   
        else {
            redirect('error');
        }
    }




    // callback, apakah id_education sama? untuk proses edit
    function is_id_education_exist()
    {
        $id_education_sekarang     = $this->session->userdata('id_education_sekarang');
        $id_education_baru         = $this->input->post('id_education');

        // jika id_education baru dan id_education yang sedang diedit sama biarkan
        // artinya id_education tidak diganti
        if ($id_education_baru === $id_education_sekarang)
        {
            return TRUE;
        }
        // jika id_education yang sedang diupdate (di session) dan yang baru (dari form) tidak sama,
        // artinya id_education mau diganti
        // cek di database apakah id_education sudah terpakai?
        else
        {
            // cek database untuk id_education yang sama
            $query = $this->db->get_where('education', array('id_education' => $id_education_baru));

            // id_education sudah dipakai
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_id_education_exist',
                                                    "Kelas dengan kode $id_education_baru sudah terdaftar");
                return FALSE;
            }
            // id_education belum dipakai, OK
            else
            {
                return TRUE;
            }
        }
    }

    // callback, apakah nama education sama? untuk proses edit
    function is_education_exist()
    {
        $education_sekarang    = $this->session->userdata('education_sekarang');
        $education_baru        = $this->input->post('education');

        if ($education_baru === $education_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk nama education yang sama
            $query = $this->db->get_where('education', array('education' => $education_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_education_exist',
                                                    "Kelas dengan nama $education_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }

}

/* End of file Education.php */
/* Location: ./application/controllers/Education.php */