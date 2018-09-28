<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat_model extends CI_Model {

	public $db_tabel    = 'logistik';
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

        return $this->db->select('puskemas.nama_pkm, logistik.bulan, logistik.rdt, logistik.act, 
        							logistik.primaquin, logistik.artesunate_injeksi, logistik.artemeter_injeksi,
        							logistik.kina_tablet, logistik.kina_injeksi, logistik.doksi_tablet')
                            ->from($this->db_tabel)
                            ->join('puskemas', 'puskemas.id_pkm = logistik.id_pkm')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_pkm', 'ASC')
                        ->get()
                        ->result();
	}

    function export(){
        $query = $this->db->select('puskemas.nama_pkm, logistik.bulan, logistik.rdt, logistik.act, 
                                    logistik.primaquin, logistik.artesunate_injeksi, logistik.artemeter_injeksi,
                                    logistik.kina_tablet, logistik.kina_injeksi, logistik.doksi_tablet')
                            ->from($this->db_tabel)
                            ->join('puskemas', 'puskemas.id_pkm = logistik.id_pkm')
                        //->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_pkm', 'ASC')
                        ->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

	public function cari_bulan()
	{

		return $this->db->distinct()
		->select('bulan')
		->from($this->db_tabel)
		->get()
		->result();

	}



	public function cari_bymonth($sortbymonth)
	{

        return $this->db->select('puskemas.nama_pkm, logistik.bulan, logistik.rdt, logistik.act, 
        							logistik.primaquin, logistik.artesunate_injeksi, logistik.artemeter_injeksi,
        							logistik.kina_tablet, logistik.kina_injeksi, logistik.doksi_tablet')
                            ->from($this->db_tabel)
                            ->join('puskemas', 'puskemas.id_pkm = logistik.id_pkm')
                            ->where('logistik.bulan', $sortbymonth)
                        ->order_by('nama_pkm', 'ASC')
                        ->get()
                        ->result();
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
        $no_col                 = array('data' => 'No', 'class' => 'text-center td_no');
        $obat_nmpuskesmas_col   = array('data' => 'Nama Puskesmas', 'class' => 'text-center td_nmpuskesmas');
        $obat_bulan_col    	    = array('data' => 'Bulan', 'class' => 'text-center');
        $obat_rdt_col    		= array('data' => 'RDT', 'class' => 'text-center');
        $obat_act_col  			= array('data' => 'ACT', 'class' => 'text-center');
        $obat_primaquin_col     = array('data' => 'Primaquin', 'class' => 'text-center');
        $obat_artesunate_col    = array('data' => 'Artesunate Injeksi', 'class' => 'text-center');
        $obat_artemeter_col     = array('data' => 'Artemeter Injeksi', 'class' => 'text-center');
        $obat_kinatablet_col    = array('data' => 'Kina Tablet', 'class' => 'text-center');
        $obat_kinainjeksi_col	= array('data' => 'Kina Injeksi', 'class' => 'text-center');
        $obat_doksi_col         = array('data' => 'Doksi Tablet', 'class' => 'text-center');
        $this->table->set_heading($no_col, $obat_nmpuskesmas_col, $obat_bulan_col, $obat_rdt_col,
                                    $obat_act_col, $obat_primaquin_col, $obat_artesunate_col, 
                                    $obat_artemeter_col, $obat_kinatablet_col, $obat_kinainjeksi_col, $obat_doksi_col);
        // no urut data
        $no = 0 + $this->offset;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->nama_pkm,
                $row->bulan,
                $row->rdt,
                $row->act,
                $row->primaquin,
                $row->artesunate_injeksi,
                $row->artemeter_injeksi,
                $row->kina_tablet,
                $row->kina_injeksi,
                $row->doksi_tablet
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }



}

/* End of file Obat_model.php */
/* Location: ./application/models/Obat_model.php */