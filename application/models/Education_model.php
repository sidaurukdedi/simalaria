<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Education_model extends CI_Model {

	public $db_tabel = 'education';
    public $per_halaman = 3;
    public $offset      = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function load_form_rules_tambah()
    {
        $form_rules = array(
            array(
                'field' => 'id_education',
                'label' => 'Education ID',
                'rules' => "required|exact_length[2]|is_unique[$this->db_tabel.id_education]"
                ),
            array(
                'field' => 'education',
                'label' => 'Education Name',
                'rules' => "required|max_length[32]|is_unique[$this->db_tabel.education]"
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
                'field' => 'id_education',
                'label' => 'Education ID',
                'rules' => "required|exact_length[2]|callback_is_id_education_exist"
                ),
            array(
                'field' => 'education',
                'label' => 'Education Name',
                'rules' => "required|max_length[32]|callback_is_education_exist"
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

        return $this->db->order_by('id_education', 'ASC')
                            ->limit($this->per_halaman, $this->offset)
                            ->get($this->db_tabel)
                            ->result();
    }


    public function cari_semua_dropdown()
    {
    	return $this->db->order_by('id_education', 'ASC')
        ->get($this->db_tabel)
        ->result();
    }

    public function cari($id_education)
    {
        return $this->db->where('id_education', $id_education)
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
        $education_id_col      = array('data' => 'Education ID', 'class' => 'text-center td_education_id');
        $education_name_col    = array('data' => 'Education Name', 'class' => 'text-center');
        $action_col             = array('data' => 'Action', 'class' => 'text-center td_action', 'colspan' => 2);
        $this->table->set_heading($no_col, $education_id_col, $education_name_col, $action_col);

        $no = 0 + $this->offset;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->id_education,
                $row->education,
                anchor('education/edit/'.$row->id_education,'&nbsp;Edit&nbsp;',array('class' => 'btn btn-warning btn-xs btn-flat center-block')),
                anchor('education/delete/'.$row->id_education,'Delete',array('class'=> 'btn btn-danger btn-xs btn-flat center-block','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
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

    public function tambah()
    {
        $education = array(
          'id_education' => $this->input->post('id_education'),
          'education' => $this->input->post('education')
          );
        $this->db->insert($this->db_tabel, $education);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function edit($id_education)
    {
        $education = array(
            'id_education'=>$this->input->post('id_education'),
            'education'=>$this->input->post('education'),
            );

        // update db
        $this->db->where('id_education', $id_education);
        $this->db->update($this->db_tabel, $education);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function hapus($id_education)
    {
        $this->db->where('id_education', $id_education)->delete($this->db_tabel);

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

/* End of file Education_model.php */
/* Location: ./application/models/Education_model.php */