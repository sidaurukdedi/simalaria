<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_status_model extends CI_Model {

	public $db_tabel = 'employee_status';

	public function __construct()
	{
        parent::__construct();
	}

	public function load_form_rules_tambah()
    {
        $form_rules = array(
            array(
                'field' => 'id_employee_status',
                'label' => 'Employee Status ID',
                'rules' => "required|numeric|exact_length[2]|is_unique[$this->db_tabel.id_employee_status]"
            ),
            array(
                'field' => 'employee_status',
                'label' => 'Employee Status',
                'rules' => "required|max_length[32]|is_unique[$this->db_tabel.employee_status]"
            ),
        );
        return $form_rules;
    }

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

    public function load_form_rules_edit()
    {
        $form_rules = array(
            array(
                'field' => 'id_employee_status',
                'label' => 'Employee Status ID',
                'rules' => "required|numeric|exact_length[2]|callback_is_id_employee_status_exist"
            ),
            array(
                'field' => 'employee_status',
                'label' => 'Employee Status',
                'rules' => "required|max_length[32]|callback_is_employee_status_exist"
            ),
        );
        return $form_rules;
    }

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

	public function cari_semua()
    {
    	return $this->db->order_by('id_employee_status', 'ASC')
                        ->get($this->db_tabel)
                        ->result();
    }

    public function cari($id_employee_status)
    {
        return $this->db->where('id_employee_status', $id_employee_status)
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
        $no_col                 = array('data' => 'No', 'class' => 'text-center td_no');
        $employee_status_id_col = array('data' => 'Employee Status ID', 'class' => 'text-center td_employee_status_id');
        $employee_status_col    = array('data' => 'Employee Status', 'class' => 'text-center');
        $action_col             = array('data' => 'Action', 'class' => 'text-center td_action', 'colspan' => 2);
        $this->table->set_heading($no_col, $employee_status_id_col, $employee_status_col, $action_col);

        $no = 0;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->id_employee_status,
                $row->employee_status,
                anchor('employee_status/edit/'.$row->id_employee_status,'&nbsp;Edit&nbsp;',array('class' => 'btn btn-warning btn-xs btn-flat center-block')),
                anchor('employee_status/delete/'.$row->id_employee_status,'Delete',array('class'=> 'btn btn-danger btn-xs btn-flat center-block','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }

    public function tambah()
    {
    	$employee_status = array(
    		'id_employee_status' => $this->input->post('id_employee_status'),
    		'employee_status' => $this->input->post('employee_status')
    		);
        $this->db->insert($this->db_tabel, $employee_status);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

	public function edit($id_employee_status)
    {
    	$employee_status = array(
    		'id_employee_status'=>$this->input->post('id_employee_status'),
    		'employee_status'=>$this->input->post('employee_status'),
    		);

        // update db
        $this->db->where('id_employee_status', $id_employee_status);
		$this->db->update($this->db_tabel, $employee_status);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function hapus($id_employee_status)
    {
        $this->db->where('id_employee_status', $id_employee_status)->delete($this->db_tabel);

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

/* End of file Employee_status_model.php */
/* Location: ./application/models/Employee_status_model.php */