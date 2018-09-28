<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

	public $db_tabel    = 'employee';
    public $per_halaman = 5;
    public $offset      = 0;

    // rules form validasi, proses TAMBAH
    private function load_form_rules_tambah()
    {
        $form = array(
                        array(
                            'field' => 'no_employee',
                            'label' => 'Employee No.',
                            'rules' => "required|exact_length[6]|is_unique[$this->db_tabel.no_employee]"
                        ),
                        array(
                            'field' => 'name',
                            'label' => 'Name',
                            'rules' => "required|max_length[50]|is_unique[$this->db_tabel.name]"
                        ),
                        array(
                            'field' => 'place_of_birth',
                            'label' => 'Place Of Birth',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'date_of_birth',
                            'label' => 'Date Of Birth',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'gender',
                            'label' => 'Gender',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'address',
                            'label' => 'Address',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'id_religion',
                            'label' => 'Religion',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'id_marital_status',
                            'label' => 'Marital Status',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'child',
                            'label' => 'Child',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'school_majors',
                            'label' => 'School Majors',
                            'rules' => "required"
                        ),
                        // array(
                        //      'field' => 'photo',
                        //      'label' => 'Photo',
                        //      'rules' => 'required'
                        // ),
                        array(
                            'field' => 'id_last_education',
                            'label' => 'Last Education',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'school_name',
                            'label' => 'School Name',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'year_graduation',
                            'label' => 'Year Graduation',
                            'rules' => 'required'
                        ),
                        
                        array(
                            'field' => 'no_hp',
                            'label' => 'No. HP',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'no_telp',
                            'label' => 'No. Telp',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'existing_job',
                            'label' => 'Existing Job',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'join_date',
                            'label' => 'Join Date',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'id_department',
                            'label' => 'Department',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'id_employment',
                            'label' => 'Employee',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'id_employee_status',
                            'label' => 'Employee Status',
                            'rules' => 'required'
                        ),
        );
        return $form;
    }

    // jalankan proses validasi, untuk operasi TAMBAH
    public function validasi_tambah()
    {
        $form = $this->load_form_rules_tambah();
        $this->form_validation->set_rules($form);

        if ($this->form_validation->run())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    // rules form validasi, proses EDIT
    private function load_form_rules_edit()
    {
        $form = array(
                        array(
                            'field' => 'no_employee',
                            'label' => 'Employee No.',
                            'rules' => "required|exact_length[6]|callback_is_no_employee_exist"
                        ),
                        array(
                            'field' => 'name',
                            'label' => 'Name',
                            'rules' => "required|max_length[50]|callback_is_name_exist"
                        ),
                        array(
                            'field' => 'place_of_birth',
                            'label' => 'Place Of Birth',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'date_of_birth',
                            'label' => 'Date Of Birth',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'gender',
                            'label' => 'Gender',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'address',
                            'label' => 'Address',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'id_religion',
                            'label' => 'Religion',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'id_marital_status',
                            'label' => 'Marital Status',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'child',
                            'label' => 'Child',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'school_majors',
                            'label' => 'School Majors',
                            'rules' => "required"
                        ),
                        // array(
                        //      'field' => 'userfile',
                        //      'label' => 'Photo',
                        //      'rules' => 'callback_image_upload'
                        // ),
                        array(
                            'field' => 'id_last_education',
                            'label' => 'Last Education',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'school_name',
                            'label' => 'School Name',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'year_graduation',
                            'label' => 'Year Graduation',
                            'rules' => 'required'
                        ),
                        
                        array(
                            'field' => 'no_hp',
                            'label' => 'No. HP',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'no_telp',
                            'label' => 'No. Telp',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'existing_job',
                            'label' => 'Existing Job',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'join_date',
                            'label' => 'Join Date',
                            'rules' => "required"
                        ),
                        array(
                            'field' => 'id_department',
                            'label' => 'Department',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'id_employment',
                            'label' => 'Employee',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'id_employee_status',
                            'label' => 'Employee Status',
                            'rules' => 'required'
                        ),
        );
        return $form;
    }

    // jalankan proses validasi, untuk operasi EDIT
    public function validasi_edit()
    {
        $form = $this->load_form_rules_edit();
        $this->form_validation->set_rules($form);

        if ($this->form_validation->run())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }



    public function cari_semua($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }
        // $offset end

        return $this->db->select('employee.id_employee, employee.no_employee, employee.name, employee.place_of_birth,
                                    employee.date_of_birth, employee.gender, employee.address, religion.religion,
                                    marital_status.marital_status, employee.child, employee.no_hp, employee.no_telp,
                                    employee.photo, education.education, employee.school_majors, employee.school_name,
                                    employee.year_graduation, employee.existing_job, employee.join_date, department.department,
                                    employment.employment, employee_status.employee_status, employee.resign_date,
                                    employee.prob_date, employee.contract1_start, employee.contract2_start, employee.contract3_start,
                                    employee.end_date')
                            ->from($this->db_tabel)
                            ->join('religion', 'religion.id_religion = employee.id_religion')
                            ->join('marital_status', 'marital_status.id_marital_status = employee.id_marital_status')
                            ->join('education', 'education.id_education = employee.id_last_education')
                            ->join('department', 'department.id_department = employee.id_department')
                            ->join('employment', 'employment.id_employment = employee.id_employment')
                            ->join('employee_status', 'employee_status.id_employee_status = employee.id_employee_status')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('no_employee', 'ASC')
                        ->get()
                        ->result();
	}

    public function cari_detail($id_employee)
    {
        $this->db->select('employee.id_employee, employee.no_employee, employee.name, employee.place_of_birth,
                            employee.date_of_birth, employee.gender, employee.address, religion.religion,
                            marital_status.marital_status, employee.child, employee.no_hp, employee.no_telp,
                            employee.photo, education.education, employee.school_majors, employee.school_name,
                            employee.year_graduation, employee.existing_job, employee.join_date, department.department,
                            employment.employment, employee_status.employee_status, employee.resign_date,
                            employee.prob_date, employee.contract1_start, employee.contract2_start, employee.contract3_start,
                            employee.end_date')
                            ->from($this->db_tabel)
                            ->join('religion', 'religion.id_religion = employee.id_religion')
                            ->join('marital_status', 'marital_status.id_marital_status = employee.id_marital_status')
                            ->join('education', 'education.id_education = employee.id_last_education')
                            ->join('department', 'department.id_department = employee.id_department')
                            ->join('employment', 'employment.id_employment = employee.id_employment')
                            ->join('employee_status', 'employee_status.id_employee_status = employee.id_employee_status')
                            ->where('employee.id_employee', $id_employee);
        $query = $this->db->get();
        if ($query->num_rows()>0) { 
            return $query->row_array();
        }
        $query->free_result();
    }

    public function cari_semua_dropdown()
    {
        return $this->db->order_by('name', 'ASC')
                        ->get($this->db_tabel)
                        ->result();
    }


    public function cari($id_employee)
    {
        return $this->db->where('id_employee', $id_employee)
            ->limit(1)
            ->get($this->db_tabel)
            ->row();
    }


	public function buat_tabel($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array(  'table_open'            => '<table class="table table-bordered table-hover" style="width:100%">',
                        'thead_open'            => '<thead>',
                        'thead_close'           => '</thead>',

                        'heading_row_start'     => '<tr>',
                        'heading_row_end'       => '</tr>',
                        'heading_cell_start'    => '<th>',
                        'heading_cell_end'      => '</th>',

                        'tbody_open'            => '<tbody>',
                        'tbody_close'           => '</tbody>',

                        'row_start'             => '<tr>',
                        'row_end'               => '</tr>',
                        'cell_start'            => '<td>',
                        'cell_end'              => '</td>',

                        'row_alt_start'         => '<tr>',
                        'row_alt_end'           => '</tr>',
                        'cell_alt_start'        => '<td>',
                        'cell_alt_end'          => '</td>',
                        'table_close'           => '</table>');
        $this->table->set_template($tmpl);

        /// heading tabel
        $no_col                         = array('data' => 'No', 'class' => 'text-center td_no');
        $employee_no_col      	        = array('data' => 'Employee No', 'class' => 'text-center td_employee_no');
        $employee_name_col    	        = array('data' => 'Name', 'class' => 'text-center');
        $employee_place_of_birth_col    = array('data' => 'Place Of Birth', 'class' => 'text-center');
        $employee_date_of_birth_col     = array('data' => 'Date Of Birth', 'class' => 'text-center');
        $employee_gender_col            = array('data' => 'Gender', 'class' => 'text-center');
        $employee_address_col           = array('data' => 'Address', 'class' => 'text-center');
        $employee_religion_col          = array('data' => 'Religion', 'class' => 'text-center');
        $employee_marital_status_col    = array('data' => 'Marital Status', 'class' => 'text-center');
        $employee_child_col             = array('data' => 'Child', 'class' => 'text-center');
        $employee_no_hp_col             = array('data' => 'No. HP', 'class' => 'text-center');
        $employee_no_telp_col           = array('data' => 'No. Telp', 'class' => 'text-center');
        $employee_photo_col    	        = array('data' => 'Photo', 'class' => 'text-center');
        $employee_education_col	        = array('data' => 'Last Education', 'class' => 'text-center');
        $employee_school_majors_col     = array('data' => 'School Majors', 'class' => 'text-center');
        $employee_school_name_col       = array('data' => 'School Name', 'class' => 'text-center');
        $employee_yeargrad_col          = array('data' => 'Year Graduation', 'class' => 'text-center');
        $employee_existing_col	        = array('data' => 'Existing Job', 'class' => 'text-center');
        $employee_join_date_col         = array('data' => 'Join Date', 'class' => 'text-center');
        $employee_department_col        = array('data' => 'Department', 'class' => 'text-center');
        $employee_employment_col        = array('data' => 'Employment', 'class' => 'text-center');
        $employee_employee_status_col   = array('data' => 'Employee Status', 'class' => 'text-center');
        $employee_end_date_col          = array('data' => 'End Date', 'class' => 'text-center');
        $employee_resign_date_col       = array('data' => 'Resign Date', 'class' => 'text-center');
        $action_col                     = array('data' => 'Action', 'class' => 'text-center td_action', 'colspan' => 3);
        // $this->table->set_heading($no_col, $employee_no_col, $employee_name_col, $employee_place_of_birth_col, $employee_date_of_birth_col,
        //                             $employee_gender_col, $employee_address_col, $employee_religion_col, $employee_marital_status_col,
        //                             $employee_child_col, $employee_no_hp_col, $employee_no_telp_col, $employee_photo_col, 
        //                             $employee_education_col, $employee_school_majors_col, $employee_school_name_col, $employee_yeargrad_col,
        //  							$employee_existing_col, $employee_join_date_col, $employee_department_col, $employee_employment_col,
        //                             $employee_employee_status_col, $action_col);
        $this->table->set_heading($no_col, $employee_no_col, $employee_name_col, $employee_department_col,
                                    $employee_employment_col, $employee_employee_status_col, $employee_join_date_col, 
                                    $employee_end_date_col, $employee_resign_date_col, $action_col);
        // no urut data
        $no = 0 + $this->offset;
        foreach ($data as $row)
        {
            $image_properties = array(
              'src' => base_url('assets/uploads/thumbs/'.$row->photo),
              //'id'  => 'img_upload',
              //'alt' => 'Me, demonstrating how to eat 4 slices of pizza at one time',
              'class' => 'img-responsivew',
              'width' => '100',
              //'height' => '50',
              //'title' => 'That was quite a night',
              //'rel' => 'lightbox',
              );

            $this->table->add_row(
                ++$no,
                $row->no_employee,
                $row->name,
                // $row->place_of_birth,
                // $row->date_of_birth,
                // $row->gender,
                // $row->address,
                // $row->religion,
                // $row->marital_status,
                // $row->child,
                // $row->no_hp,
                // $row->no_telp,
                // img($image_properties),
                // $row->education,
                // $row->school_majors,
                // $row->school_name,
                // $row->year_graduation,                
                // $row->existing_job,
                
                $row->department,
                $row->employment,
                $row->employee_status,
                $row->join_date,
                $row->end_date,
                $row->resign_date,
                anchor('employee/detail/'.$row->id_employee,'Detail',array('class' => 'btn btn-info btn-xs btn-flat center-block')),
                anchor('employee/edit/'.$row->id_employee,'&nbsp;Edit&nbsp;',array('class' => 'btn btn-warning btn-xs btn-flat center-block')),
                anchor('employee/delete/'.$row->id_employee,'Delete',array('class'=> 'btn btn-danger btn-xs btn-flat center-block','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }

    public function paging($base_url)
    {
        $this->load->library('pagination');
        $config = array(
            'base_url'          => $base_url,
            'total_rows'        => $this->hitung_semua(),
            'per_page'          => $this->per_halaman,
            'num_links'         => 4,
            'use_page_numbers'  => TRUE,
            'full_tag_open'     => '<ul class="pagination pagination-sm no-margin pull-right">',
            'prev_link'         =>  '&laquo; Prev',
            'prev_tag_open'     => '<li>',
            'prev_tag_close'    => '</li>',
            'first_link'        => 'First',
            'first_tag_open'    => '<li>',
            'first_tag_close'   => '</li>',
            'cur_tag_open'      => '<li class="active"><a>',
            'cur_tag_close'     => '</a></li>',
            'num_tag_open'      => '<li>',
            'num_tag_close'     => '</li>',
            'next_link'         =>  'Next &raquo;',
            'next_tag_open'     => '<li>',
            'next_tag_close'    => '</li>',
            'last_tag_open'     => '<li>',
            'last_tag_close'    => '</li>',
            'full_tag_close'    => '</ul>',
        );
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    public function hitung_semua()
    {
        return $this->db->count_all($this->db_tabel);
    }

    public function tambah($file_name)
    {
        $date_of_birth      = $this->input->post('date_of_birth');
        $join_date          = $this->input->post('join_date');
        $resign_date        = $this->input->post('resign_date');  
        $prob_start         = $this->input->post('prob_start');
        $end_date           = $this->input->post('end_date');  
        $contract1_start    = $this->input->post('contract1_start');
        $contract2_start    = $this->input->post('contract2_start');
        $contract3_start    = $this->input->post('contract3_start');

        $employee = array(
            'no_employee'       => $this->input->post('no_employee'),
            'name'              => $this->input->post('name'),
            'place_of_birth'    => $this->input->post('place_of_birth'),
            'date_of_birth'     => date('Y-m-d', strtotime($date_of_birth)),
            'gender'            => $this->input->post('gender'),
            'address'           => $this->input->post('address'),
            'id_religion'       => $this->input->post('id_religion'),
            'id_marital_status' => $this->input->post('id_marital_status'),
            'child'             => $this->input->post('child'),
            'no_hp'             => $this->input->post('no_hp'),
            'no_telp'           => $this->input->post('no_telp'),
            'photo'             => $file_name,
            'id_last_education' => $this->input->post('id_last_education'),
            'school_majors'     => $this->input->post('school_majors'),
            'school_name'       => $this->input->post('school_name'),
            'year_graduation'   => $this->input->post('year_graduation'),
            'join_date'         => date('Y-m-d', strtotime($join_date)),
            'existing_job'      => $this->input->post('existing_job'),
            'id_department'     => $this->input->post('id_department'),
            'id_employment'     => $this->input->post('id_employment'),
            'id_employee_status'=> $this->input->post('id_employee_status'),
            'resign_date'       => empty($resign_date) ?  NULL : date('Y-m-d', strtotime($resign_date)),
            'prob_date'         => empty($prob_start) ?  NULL : date('Y-m-d', strtotime($prob_start)),
            'contract1_start'   => empty($contract1_start) ?  NULL : date('Y-m-d', strtotime($contract1_start)),
            'contract2_start'   => empty($contract2_start) ?  NULL : date('Y-m-d', strtotime($contract2_start)),
            'contract3_start'   => empty($contract3_start) ?  NULL : date('Y-m-d', strtotime($contract3_start)),
            'end_date'          => empty($end_date) ?  NULL : date('Y-m-d', strtotime($end_date)),
            );
            // echo "<pre>";
            // print_r ($employee);
            // echo "</pre>";
            // die();
        $this->db->insert($this->db_tabel, $employee);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function edit($id_employee, $file_name)
    {
        $date_of_birth      = $this->input->post('date_of_birth');
        $join_date          = $this->input->post('join_date'); 
        $resign_date        = $this->input->post('resign_date');  
        $prob_start         = $this->input->post('prob_start');  
        $end_date           = $this->input->post('end_date');  
        $contract1_start    = $this->input->post('contract1_start');
        $contract2_start    = $this->input->post('contract2_start');
        $contract3_start    = $this->input->post('contract3_start');


        $employee = array(
            'no_employee'       => $this->input->post('no_employee'),
            'name'              => $this->input->post('name'),
            'place_of_birth'    => $this->input->post('place_of_birth'),
            'date_of_birth'     => date('Y-m-d', strtotime($date_of_birth)),
            'gender'            => $this->input->post('gender'),
            'address'           => $this->input->post('address'),
            'id_religion'       => $this->input->post('id_religion'),
            'id_marital_status' => $this->input->post('id_marital_status'),
            'child'             => $this->input->post('child'),
            'no_hp'             => $this->input->post('no_hp'),
            'no_telp'           => $this->input->post('no_telp'),
            'photo'             => $file_name,
            'id_last_education' => $this->input->post('id_last_education'),
            'school_majors'     => $this->input->post('school_majors'),
            'school_name'       => $this->input->post('school_name'),
            'year_graduation'   => $this->input->post('year_graduation'),
            'join_date'         => date('Y-m-d', strtotime($join_date)),
            'existing_job'      => $this->input->post('existing_job'),
            'id_department'     => $this->input->post('id_department'),
            'id_employment'     => $this->input->post('id_employment'),
            'id_employee_status'=> $this->input->post('id_employee_status'),
            'resign_date'       => empty($resign_date) ?  NULL : date('Y-m-d', strtotime($resign_date)),
            'prob_date'         => empty($prob_start) ?  NULL : date('Y-m-d', strtotime($prob_start)),
            'contract1_start'   => empty($contract1_start) ?  NULL : date('Y-m-d', strtotime($contract1_start)),
            'contract2_start'   => empty($contract2_start) ?  NULL : date('Y-m-d', strtotime($contract2_start)),
            'contract3_start'   => empty($contract3_start) ?  NULL : date('Y-m-d', strtotime($contract3_start)),
            'end_date'          => empty($end_date) ?  NULL : date('Y-m-d', strtotime($end_date)),
            );

        // echo "<pre>";
        // print_r ($employee);
        // echo "</pre>";
        // die();

        // update db
        $this->db->where('id_employee', $id_employee);
        $this->db->update($this->db_tabel, $employee);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function hapus($id_employee)
    {
        $this->db->where('id_employee', $id_employee)->delete($this->db_tabel);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}

/* End of file Employee_model.php */
/* Location: ./application/models/Employee_model.php */