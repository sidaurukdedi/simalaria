<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {

	public $data = array(
                        'modul'         => 'employee',
                        'breadcrumb'    => 'Employee',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        'main_view'     => 'employee/employee',
                        'form_action'   => '',
                        'form_value'    => '',
                        'option_kelas'  => '',
                        'nav_employee'  => '',
                        'tree_menu_employee' => '',
                         );

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Education_model', 'education', TRUE);
		$this->load->model('Department_model', 'department', TRUE);
		$this->load->model('Employment_model', 'employment', TRUE);
		$this->load->model('Employee_model', 'employee', TRUE);
        $this->load->model('Religion_model', 'religion', TRUE);
        $this->load->model('Marital_model', 'marital', TRUE);
        $this->load->model('Employee_status_model', 'employee_status', TRUE);
        $this->load->helper('html');
	}

	public function index($offset = 0)
    {  
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['nav_employee'] = 'active';
            $this->data['tree_menu_employee'] = 'active';
            // hapus data temporary proses update
            $this->session->unset_userdata('no_employee', '');
            $this->session->unset_userdata('name', '');

            // cari data employee
            $employee = $this->employee->cari_semua($offset);
            // =========test json_decode()============
            
            // echo json_encode($employee);
            
            // echo "<br><br><br>";
            // print_r ($employee);
            // die();
            // ada data employee, tampilkan
            if ($employee)
            {
                $tabel = $this->employee->buat_tabel($employee);
                $this->data['tabel_data'] = $tabel;

            // Paging
            // http://localhost:8080/CodeIgniter-3.1.0/sim/index.php/employee/pages/2
                $this->data['pagination'] = $this->employee->paging(site_url('employee/pages'));
            }
        // tidak ada data siswa
            else
            {
                $this->data['pesan'] = 'Tidak ada data Employee.';
            }
            $this->load->view('template', $this->data);
        }   
        else {
            redirect('error');
        }
    }

    public function detail($id_employee = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Employee > Detail';
            $this->data['main_view']   = 'employee/employee_detail';
            $this->data['form_action'] = 'employee/detail/' . $id_employee;
            $this->data['nav_employee'] = 'active';
            $this->data['tree_menu_employee'] = 'active';
            $this->data['employee'] = $this->employee->cari_detail($id_employee);
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
            $this->data['breadcrumb']  = 'Employee > Tambah';
            $this->data['main_view']   = 'employee/employee_form';
            $this->data['form_action'] = 'employee/tambah';
            $this->data['nav_employee'] = 'active';
            $this->data['tree_menu_employee'] = 'active';

            // option religion, untuk menu dropdown
            $religion = $this->religion->cari_semua();
            // data religion ada
            if($religion)
            {
                $this->data['opt_religion'] = array('' => 'Select One...');
                foreach($religion as $row)
                {
                    $this->data['opt_religion'][$row->id_religion] = $row->religion;
                }
            }
            // data religion tidak ada
            else
            {
                $this->data['opt_religion']['00'] = '-';
                $this->data['pesan'] = $this->data['pesan'] . '<br>' . 'Data Religion tidak tersedia. Silahkan isi dahulu data religion.';
            }

            // option marital, untuk menu dropdown
            $marital = $this->marital->cari_semua();
            // data marital ada
            if($marital)
            {
                $this->data['opt_marital'] = array('' => 'Select One...');
                foreach($marital as $row)
                {
                    $this->data['opt_marital'][$row->id_marital_status] = $row->marital_status;
                }
            }
            // data marital tidak ada
            else
            {
                $this->data['opt_marital']['00'] = '-';
                $this->data['pesan'] = $this->data['pesan'] . '<br>' . 'Data Marital tidak tersedia. Silahkan isi dahulu data marital.';
            //$this->load->view('template', $this->data);
            }


            // option education, untuk menu dropdown
            $education = $this->education->cari_semua_dropdown();
            // data education ada
            if($education)
            {
                $this->data['opt_education'] = array('' => 'Select One...');
                foreach($education as $row)
                {
                    $this->data['opt_education'][$row->id_education] = $row->education;
                }
            }
            // data education tidak ada
            else
            {
                $this->data['opt_education']['00'] = '-';
                $this->data['pesan'] = 'Data education tidak tersedia. Silahkan isi dahulu data education.';
            //$this->load->view('template', $this->data);
            }

            // option department, untuk menu dropdown
            $department = $this->department->cari_semua_dropdown();
            // data department ada
            if($department)
            {
                $this->data['opt_department'] = array('' => 'Select One...');
                foreach($department as $row)
                {
                    $this->data['opt_department'][$row->id_department] = $row->department;
                }
            }
            // data department tidak ada
            else
            {
                $this->data['opt_department']['00'] = '-';
                $this->data['pesan'] = $this->data['pesan'] . '<br>' . 'Data department tidak tersedia. Silahkan isi dahulu data department.';
                //$this->load->view('template', $this->data);
            }

            // option employment, untuk menu dropdown
            $employment = $this->employment->cari_semua_dropdown();
            // data employment ada
            if($employment)
            {
                $this->data['opt_employment'] = array('' => 'Select One...');
                foreach($employment as $row)
                {
                    $this->data['opt_employment'][$row->id_employment] = $row->employment;
                }
            }
            // data employment tidak ada
            else
            {
                $this->data['opt_employment']['00'] = '-';
                $this->data['pesan'] = $this->data['pesan'] . '<br>' . 'Data employment tidak tersedia. Silahkan isi dahulu data employment.';
            //$this->load->view('template', $this->data);
            }

            // option employee_status, untuk menu dropdown
            $employee_status = $this->employee_status->cari_semua();
            // data employee_status ada
            if($employee_status)
            {
                $this->data['opt_employee_status'] = array('' => 'Select One...');
                foreach($employee_status as $row)
                {
                    $this->data['opt_employee_status'][$row->id_employee_status] = $row->employee_status;
                }
            }
            // data opt_employee_status tidak ada
            else
            {
                $this->data['opt_employee_status']['00'] = '-';
                $this->data['pesan'] = $this->data['pesan'] . '<br>' . 'Data Employee Status tidak tersedia. Silahkan isi dahulu data Employee Status.';
            //$this->load->view('template', $this->data);
            }

            $this->data['opt_gender'] = array('' => 'Select One...',
                'F' => 'Female',
                'M' => 'Male');

            // if submit
            if($this->input->post('submit'))
            {
            // validasi sukses
                if($this->employee->validasi_tambah())
                {
                    $no = $this->input->post('no_employee');
                    $nm = $this->input->post('name');
                    $now = date('y-m-d');
                    $new_name = $no . '_' . $nm . '_' . $now;
                    $path = './assets/uploads/employee/';
                    $config['upload_path']          = $path;
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['max_size']             = 2048000;
                    $config['max_width']            = 2000;
                    $config['max_height']           = 2000;
                    $config['file_name']            = $new_name;
                    $this->load->library('upload', $config);

                    //if ( ! $this->upload->do_upload('userfile'))
                    if (empty($_FILES['userfile']['name']))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        $this->data['pesan'] = 'Upload foto gagal.';
                        $this->load->view('template', $this->data);
                        //echo "gagal upload, cek...!!!";
                        //$this->load->view('upload_form', $error);
                    }
                    else
                    {
                        $this->upload->do_upload('userfile');
                        $upload_image = $this->upload->data();
                        $file_name = $upload_image['file_name'];
                        $gallery_path = './assets/uploads/employee/';
                        $config = array(
                            'image_library' => 'gd2',
                            'source_image' => $gallery_path . $file_name,
                            'new_image' => $gallery_path . 'thumbs/' . $file_name,
                            //'create_thumb' => TRUE,
                            'maintain_ration' => TRUE,
                            'width' => 160,
                            'height' => 160
                            );
                        $this->load->library('image_lib', $config);
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        if($this->employee->tambah($file_name))
                        {
                            $this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
                            redirect('employee');
                        }
                        else
                        {
                            $this->data['pesan'] = 'Proses tambah data gagal.';
                            $this->load->view('template', $this->data);
                        }
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

    public function edit($id_employee = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            $this->data['breadcrumb']  = 'Employee > Edit';
            $this->data['main_view']   = 'employee/employee_form';
            $this->data['form_action'] = 'employee/edit/' . $id_employee;
            $this->data['nav_employee'] = 'active';
            $this->data['tree_menu_employee'] = 'active';


            // option religion
            $religion = $this->religion->cari_semua();
            foreach($religion as $row)
            {
                $this->data['opt_religion'][$row->id_religion] = $row->religion;
            }

            // option marital
            $marital = $this->marital->cari_semua();
            foreach($marital as $row)
            {
                $this->data['opt_marital'][$row->id_marital_status] = $row->marital_status;
            }

            // option Education_model
            $education = $this->education->cari_semua_dropdown();
            foreach($education as $row)
            {
                $this->data['opt_education'][$row->id_education] = $row->education;
            }

            // option department
            $department = $this->department->cari_semua_dropdown();
            foreach($department as $row)
            {
                $this->data['opt_department'][$row->id_department] = $row->department;
            }

            // option employment
            $employment = $this->employment->cari_semua_dropdown();
            foreach($employment as $row)
            {
                $this->data['opt_employment'][$row->id_employment] = $row->employment;
            }

            // option employment
            $employee_status = $this->employee_status->cari_semua();
            foreach($employee_status as $row)
            {
                $this->data['opt_employee_status'][$row->id_employee_status] = $row->employee_status;
            }
            $this->data['opt_gender'] = array('' => 'Select One...',
                'F' => 'Female',
                'M' => 'Male');


        // Mencegah error http://localhost/absensi2014/siswa/edit/$nis (edit tanpa ada parameter)
        // Ada parameter
            if( ! empty($id_employee))
            {
            // submit
                if($this->input->post('submit'))
                {
                // validasi berhasil
                    if($this->employee->validasi_edit() === TRUE)
                    {
                    //update db
                        $no = $this->input->post('no_employee');
                        $nm = $this->input->post('name');
                        $now = date('y-m-d');
                        $new_name = $no . '_' . $nm . '_' . $now;
                        $path = './assets/uploads/employee/';
                        $path_thumb = $path . 'thumbs/';
                        $old_photo = $this->session->userdata('photo_employee');
                        $config['upload_path']          = $path;
                        $config['allowed_types']        = 'gif|jpg|png';
                        $config['max_size']             = 2048000;
                        $config['max_width']            = 2000;
                        $config['max_height']           = 2000;
                        $config['file_name']            = $new_name;
                        $this->load->library('upload', $config);
                        

                        if ( ! $this->upload->do_upload('userfile'))
                        {
                            $file_name = $this->session->userdata('photo_employee');

                            if($this->employee->edit($this->session->userdata('id_employee'), $file_name))
                            {
                                $this->session->set_flashdata('pesan', 'Proses update data berhasil.');
                                redirect('employee');
                            }
                            else
                            {
                                $this->data['pesan'] = 'Proses update data gagal.';
                                $this->load->view('template', $this->data);
                            }


                            // $error = array('error' => $this->upload->display_errors());
                            // $this->data['pesan'] = 'Upload foto gagal.';
                            // $this->load->view('template', $this->data);
                            //echo "gagal upload, cek...!!!";
                            //$this->load->view('upload_form', $error);
                        }
                        else
                        {
                            @unlink($path.$old_photo);
                            @unlink($path_thumb.$old_photo);
                            $upload_image = $this->upload->data();
                            $file_name = $upload_image['file_name'];
                            $gallery_path = './assets/uploads/employee/';
                            $config = array(
                                'image_library' => 'gd2',
                                'source_image' => $gallery_path . $file_name,
                                'new_image' => $gallery_path . 'thumbs/' . $file_name,
                                //'create_thumb' => TRUE,
                                'maintain_ration' => TRUE,
                                'width' => 160,
                                'height' => 160
                                );
                            $this->load->library('image_lib', $config);
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();

                            if($this->employee->edit($this->session->userdata('id_employee'), $file_name))
                            {
                                $this->session->set_flashdata('pesan', 'Proses update data berhasil.');
                                redirect('employee');
                            }
                            else
                            {
                                $this->data['pesan'] = 'Proses update data gagal.';
                                $this->load->view('template', $this->data);
                            }
                        }


                        // $this->employee->edit($this->session->userdata('id_employee'));
                        // $this->session->set_flashdata('pesan', 'Proses update data berhasil.');
                        // redirect('employee');
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
                    $employee = $this->employee->cari($id_employee);
                    foreach($employee as $key => $value)
                    {
                        $this->data['form_value'][$key] = $value;
                    }

                // set temporary data untuk edit
                    $this->session->set_userdata('no_employee_sekarang', $employee->no_employee);
                    $this->session->set_userdata('name_sekarang', $employee->name);
                    $this->session->set_userdata('id_employee', $employee->id_employee);
                    $this->session->set_userdata('photo_employee', $employee->photo);
                    $this->load->view('template', $this->data);
                }
            }
        // tidak ada parameter $nis di URL, kembalikan ke halaman siswa
            else
            {
                redirect('employee');
            }
        }   
        else {
            redirect('error');
        }
    }

    public function delete($id_employee = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "HR"){
            if( ! empty($id_employee))
            {
                $path = './assets/uploads/employee/';
                $path_thumb = $path . 'thumbs/';
                $employee = $this->employee->cari_detail($id_employee);
                if($this->employee->hapus($id_employee))
                {
                    @unlink($path.$employee['photo']);
                    @unlink($path_thumb.$employee['photo']);
                    $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                    redirect('employee');
                }
                else
                {

                    $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                    redirect('employee');
                }
            }
            else
            {

                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('employee');
            }
        }   
        else {
            redirect('error');
        }
    }

    public function is_no_employee_exist()
    {
        $no_employee_sekarang   = $this->session->userdata('no_employee_sekarang');
        $no_employee_baru       = $this->input->post('no_employee');

        if ($no_employee_baru === $no_employee_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk no employee yang sama
            $query = $this->db->get_where('employee', array('no_employee' => $no_employee_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_no_employee_exist',
                                                    "Karyawan dengan NIK $no_employee_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }

    public function is_name_exist()
    {
        $name_sekarang   = $this->session->userdata('name_sekarang');
        $name_baru       = $this->input->post('name');

        if ($name_baru === $name_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk name yang sama
            $query = $this->db->get_where('employee', array('name' => $name_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_name_exist',
                                                    "Siswa dengan NIS $name_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }


    // function image_upload()
    // {
    //     if (empty($_FILES['userfile']['name']))
    //     {
    //         $this->form_validation->set_rules('userfile', 'Photo', 'required');
    //     }
    // }
}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */