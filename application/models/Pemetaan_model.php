<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemetaan_model extends CI_Model {

	public $db_tabel    = 'pemetaan';
    public $per_halaman = 5;
    public $offset      = 0;

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

        return $this->db->select('pemetaan.id_peta, pemetaan.lintang, pemetaan.bujur, pemetaan.kategori')
                            ->from($this->db_tabel)
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('id_peta', 'ASC')
                        ->get()
                        ->result();
	}

    function export(){
        $query = $this->db->query("SELECT * from pemetaan");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
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
        $no_col                 	= array('data' => 'No', 'class' => 'text-center td_no');
        $pemetaan_id_peta_col   	= array('data' => 'ID Peta', 'class' => 'text-center td_id_peta');
        $pemetaan_lintang_col    	    = array('data' => 'Lintang', 'class' => 'text-center');
        $pemetaan_bujur_col    	    = array('data' => 'Bujur', 'class' => 'text-center');
        $pemetaan_kategori_col 		= array('data' => 'Kategori', 'class' => 'text-center');
        $this->table->set_heading($no_col, $pemetaan_id_peta_col, $pemetaan_lintang_col, $pemetaan_bujur_col,
                                    $pemetaan_kategori_col);
        // no urut data
        $no = 0 + $this->offset;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->id_peta,
                $row->lintang,
                $row->bujur,
                $row->kategori
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }



	

}

/* End of file Pemetaan_model.php */
/* Location: ./application/models/Pemetaan_model.php */