<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan_model extends CI_Model {

	public $db_tabel    = 'kegiatan';
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

        return $this->db->select('kegiatan.nama_pkm, kegiatan.bulan, kegiatan.tahun, kegiatan.jumlah_penduduk, kegiatan.kasus_positif,
                                    kegiatan.api, kegiatan.skrin_pos, kegiatan.skrin_neg, 
        							kegiatan.kelambu_anc, kegiatan.kelambu_imun, kegiatan.kelambu_balita, kegiatan.kelambu_lain')
                            ->from($this->db_tabel)
                            //->join('puskemas', 'puskemas.id_pkm = logistik.id_pkm')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_pkm', 'ASC')
                        ->get()
                        ->result();
	}

    function export(){
        $query = $this->db->select('kegiatan.nama_pkm, kegiatan.bulan, kegiatan.tahun, kegiatan.jumlah_penduduk, 
                                    kegiatan.suspek, kegiatan.sd_diperiksa, kegiatan.kasus_positif, kegiatan.api,  
                                    kegiatan.negatif_rdt, kegiatan.negatif_mikro, kegiatan.negatif_pcr, kegiatan.skrin_pos, kegiatan.skrin_neg, 
                                    kegiatan.kelambu_anc, kegiatan.kelambu_imun, kegiatan.kelambu_balita, kegiatan.kelambu_lain')
                            ->from($this->db_tabel)
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

	public function cari_bymonth($sortbymonth)
	{
        return $this->db->select('kegiatan.nama_pkm, kegiatan.bulan, kegiatan.tahun, kegiatan.jumlah_penduduk, kegiatan.kasus_positif,
                                    kegiatan.api, kegiatan.skrin_pos, kegiatan.skrin_neg, 
                                    kegiatan.kelambu_anc, kegiatan.kelambu_imun, kegiatan.kelambu_balita, kegiatan.kelambu_lain')
                            ->from($this->db_tabel)
                            //->join('puskemas', 'puskemas.id_pkm = logistik.id_pkm')
                            ->where('kegiatan.bulan', $sortbymonth)
                        ->order_by('nama_pkm', 'ASC')
                        ->get()
                        ->result();
	}

    public function cari_bulan()
	{
		return $this->db->distinct()
		->select('bulan')
		->from($this->db_tabel)
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
        $no_col                         = array('data' => 'No', 'class' => 'text-center td_no');
        $kegiatan_nmpuskesmas_col       = array('data' => 'Nama Puskesmas', 'class' => 'text-center td_nmpuskesmas');
        $kegiatan_bulan_col    	        = array('data' => 'Bulan', 'class' => 'text-center');
        $kegiatan_tahun_col    	        = array('data' => 'Tahun', 'class' => 'text-center');
        $kegiatan_jumlah_penduduk_col   = array('data' => 'Jumlah Penduduk', 'class' => 'text-center');
        $kegiatan_kasus_positif_col     = array('data' => 'Kasus Positif', 'class' => 'text-center');
        $kegiatan_api_col               = array('data' => 'API', 'class' => 'text-center');
        $kegiatan_skrinpos_col 		    = array('data' => 'Skrining Positif', 'class' => 'text-center');
        $kegiatan_skrinneg_col 		    = array('data' => 'Skrining Negatif', 'class' => 'text-center');
        $kegiatan_kelambuanc_col  	    = array('data' => 'Kelambu ANC', 'class' => 'text-center');
        $kegiatan_kelambuimun_col       = array('data' => 'Kelambu Imun', 'class' => 'text-center');
        $kegiatan_kelambubalita_col     = array('data' => 'Kelambu Balita', 'class' => 'text-center');
        $kegiatan_kelambulain_col       = array('data' => 'Kelambu Lain', 'class' => 'text-center');
        $this->table->set_heading($no_col, $kegiatan_nmpuskesmas_col, $kegiatan_bulan_col, $kegiatan_tahun_col,
                                    $kegiatan_jumlah_penduduk_col, $kegiatan_kasus_positif_col, $kegiatan_api_col,
                                    $kegiatan_skrinpos_col, $kegiatan_skrinneg_col, $kegiatan_kelambuanc_col, 
                                    $kegiatan_kelambuimun_col, $kegiatan_kelambubalita_col, $kegiatan_kelambulain_col);
        // no urut data
        $no = 0 + $this->offset;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->nama_pkm,
                $row->bulan,
                $row->tahun,
                $row->jumlah_penduduk,
                $row->kasus_positif,
                number_format((float)$row->api, 2, '.', ''),
                $row->skrin_pos,
                $row->skrin_neg,
                $row->kelambu_anc,
                $row->kelambu_imun,
                $row->kelambu_balita,
                $row->kelambu_lain
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
}

/* End of file Kegiatan_model.php */
/* Location: ./application/models/Kegiatan_model.php */