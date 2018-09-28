<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Religion_model extends CI_Model {

	public $db_tabel = 'religion';

    public function __construct()
    {
        parent::__construct();
    }

    public function load_form_rules_tambah()
    {
        $form_rules = array(
            array(
                'field' => 'id_religion',
                'label' => 'Religion ID',
                'rules' => "required|numeric|exact_length[2]|is_unique[$this->db_tabel.id_religion]"
                ),
            array(
                'field' => 'religion',
                'label' => 'Religion',
                'rules' => "required|max_length[32]|is_unique[$this->db_tabel.religion]"
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
                'field' => 'id_religion',
                'label' => 'Religion ID',
                'rules' => "required|numeric|exact_length[2]|callback_is_id_religion_exist"
                ),
            array(
                'field' => 'religion',
                'label' => 'Religion',
                'rules' => "required|max_length[32]|callback_is_religion_exist"
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
    	return $this->db->order_by('id_religion', 'ASC')
                        ->get($this->db_tabel)
                        ->result();
    }

    public function cari($id_religion)
    {
        return $this->db->where('id_religion', $id_religion)
        ->limit(1)
        ->get($this->db_tabel)
        ->row();
    }

    public function buat_tabel($data)
    {
        $this->load->library('table');

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
        $no_col				= array('data' => 'No', 'class' => 'text-center td_no');
        $religion_id_col    = array('data' => 'Religion ID', 'class' => 'text-center td_religion_id');
        $religion_col    	= array('data' => 'Religion', 'class' => 'text-center');
        $action_col         = array('data' => 'Action', 'class' => 'text-center td_action', 'colspan' => 2);
        $this->table->set_heading($no_col, $religion_id_col, $religion_col, $action_col);

        $no = 0;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->id_religion,
                $row->religion,
                anchor('religion/edit/'.$row->id_religion,'&nbsp;Edit&nbsp;',array('class' => 'btn btn-warning btn-xs btn-flat center-block')),
                anchor('religion/delete/'.$row->id_religion,'Delete',array('class'=> 'btn btn-danger btn-xs btn-flat center-block','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }

    public function tambah()
    {
        $religion = array(
          'id_religion' => $this->input->post('id_religion'),
          'religion' 	=> $this->input->post('religion')
          );
        $this->db->insert($this->db_tabel, $religion);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function edit($id_religion)
    {
        $religion = array(
            'id_religion' => $this->input->post('id_religion'),
          	'religion' 		=> $this->input->post('religion')
            );

        // update db
        $this->db->where('id_religion', $id_religion);
        $this->db->update($this->db_tabel, $religion);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function hapus($id_religion)
    {
        $this->db->where('id_religion', $id_religion)->delete($this->db_tabel);

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

/* End of file Religion_model.php */
/* Location: ./application/models/Religion_model.php */