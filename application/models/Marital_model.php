<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marital_model extends CI_Model {

	public $db_tabel = 'marital_status';

    public function __construct()
    {
        parent::__construct();
    }

    public function load_form_rules_tambah()
    {
        $form_rules = array(
            array(
                'field' => 'id_marital_status',
                'label' => 'Marital Status ID',
                'rules' => "required|numeric|exact_length[2]|is_unique[$this->db_tabel.id_marital_status]"
            ),
            array(
                'field' => 'marital_status',
                'label' => 'Marital Status',
                'rules' => "required|max_length[32]|is_unique[$this->db_tabel.marital_status]"
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
                'field' => 'id_marital_status',
                'label' => 'Marital Status ID',
                'rules' => "required|numeric|exact_length[2]|callback_is_id_marital_status_exist"
            ),
            array(
                'field' => 'marital_status',
                'label' => 'Marital Status',
                'rules' => "required|max_length[32]|callback_is_marital_status_exist"
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
    	return $this->db->order_by('id_marital_status', 'ASC')
                        ->get($this->db_tabel)
                        ->result();
    }

    public function cari($id_marital_status)
    {
        return $this->db->where('id_marital_status', $id_marital_status)
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
        $marital_status_id_col  = array('data' => 'Marital ID', 'class' => 'text-center td_marital_status_id');
        $marital_status_col    	= array('data' => 'Marital Status', 'class' => 'text-center');
        $action_col             = array('data' => 'Action', 'class' => 'text-center td_action', 'colspan' => 2);
        $this->table->set_heading($no_col, $marital_status_id_col, $marital_status_col, $action_col);

        $no = 0;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->id_marital_status,
                $row->marital_status,
                anchor('marital_status/edit/'.$row->id_marital_status,'&nbsp;Edit&nbsp;',array('class' => 'btn btn-warning btn-xs btn-flat center-block')),
                anchor('marital_status/delete/'.$row->id_marital_status,'Delete',array('class'=> 'btn btn-danger btn-xs btn-flat center-block','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }

    public function tambah()
    {
        $marital_status = array(
                      'id_marital_status' 	=> $this->input->post('id_marital_status'),
                      'marital_status' 		=> $this->input->post('marital_status')
                      );
        $this->db->insert($this->db_tabel, $marital_status);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function edit($id_marital_status)
    {
        $marital_status = array(
            'id_marital_status'=>$this->input->post('id_marital_status'),
            'marital_status'=>$this->input->post('marital_status'),
        );

        // update db
        $this->db->where('id_marital_status', $id_marital_status);
        $this->db->update($this->db_tabel, $marital_status);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function hapus($id_marital_status)
    {
        $this->db->where('id_marital_status', $id_marital_status)->delete($this->db_tabel);

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

/* End of file Marital_model.php */
/* Location: ./application/models/Marital_model.php */