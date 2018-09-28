<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasienklas_model extends CI_Model {

	public $db_tabel    = 'pasien';
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

        // $query = $this->db->query("SELECT DISTINCT b.nama_pkm AS NamaPuskesmas, a.bulan AS Bulan, COUNT(a.id_pasien) as TotalPasien,
								// 	(SELECT COUNT(pasien.id_klasifikasi) FROM pasien where  pasien.bulan = a.bulan AND pasien.id_klasifikasi='1' AND pasien.id_pkm = a.id_pkm) AS Indigenous,
								// 	(SELECT COUNT(pasien.id_klasifikasi) FROM pasien where   pasien.bulan = a.bulan AND pasien.id_klasifikasi='2' AND pasien.id_pkm = a.id_pkm) AS KasusImpor
								// 	FROM  pasien a INNER JOIN puskemas b ON a.id_pkm=b.id_pkm GROUP BY a.id_pasien ORDER BY NamaPuskesmas ASC");

        $query = $this->db->query("SELECT DISTINCT b.nama_pkm AS NamaPuskesmas, a.bulan AS Bulan,
                                    (SELECT COUNT(pasien.id_klasifikasi) FROM pasien where  pasien.bulan = a.bulan AND pasien.id_klasifikasi='1' AND pasien.id_pkm = a.id_pkm) AS Indigenous,
                                    (SELECT COUNT(pasien.id_klasifikasi) FROM pasien where   pasien.bulan = a.bulan AND pasien.id_klasifikasi='2' AND pasien.id_pkm = a.id_pkm) AS KasusImpor,
                                    (SELECT Indigenous + KasusImpor ) AS TotalPasien
                                    FROM  pasien a INNER JOIN puskemas b ON a.id_pkm=b.id_pkm GROUP BY a.id_pasien");
                                    return $query->result();
	}

	public function cari_bymonth($sortbymonth)
	{
		// $query = $this->db->query("SELECT DISTINCT b.nama_pkm AS NamaPuskesmas, a.bulan AS Bulan, COUNT(a.id_pasien) as TotalPasien,
		// 							(SELECT COUNT(pasien.id_klasifikasi) FROM pasien where  pasien.bulan = a.bulan AND pasien.id_klasifikasi='1' AND pasien.id_pkm = a.id_pkm) AS Indigenous,
		// 							(SELECT COUNT(pasien.id_klasifikasi) FROM pasien where   pasien.bulan = a.bulan AND pasien.id_klasifikasi='2' AND pasien.id_pkm = a.id_pkm) AS KasusImpor
		// 							FROM  pasien a INNER JOIN puskemas b ON a.id_pkm=b.id_pkm WHERE Bulan = '$sortbymonth'  GROUP BY a.id_pasien ORDER BY NamaPuskesmas ASC");
        $query = $this->db->query("SELECT DISTINCT b.nama_pkm AS NamaPuskesmas, a.bulan AS Bulan,
                                    (SELECT COUNT(pasien.id_klasifikasi) FROM pasien where  pasien.bulan = a.bulan AND pasien.id_klasifikasi='1' AND pasien.id_pkm = a.id_pkm) AS Indigenous,
                                    (SELECT COUNT(pasien.id_klasifikasi) FROM pasien where   pasien.bulan = a.bulan AND pasien.id_klasifikasi='2' AND pasien.id_pkm = a.id_pkm) AS KasusImpor,
                                    (SELECT Indigenous + KasusImpor ) AS TotalPasien
                                    FROM  pasien a INNER JOIN puskemas b ON a.id_pkm=b.id_pkm WHERE Bulan = '$sortbymonth' GROUP BY a.id_pasien");

        return $query->result();
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

        //return $this->db->count_all($this->db_tabel);
        $query = $this->db->query("SELECT COUNT(*) AS TotalRow FROM (SELECT DISTINCT b.nama_pkm AS NamaPuskesmas,
                                    a.bulan AS Bulan, (SELECT COUNT(pasien.id_klasifikasi) FROM pasien where  pasien.bulan = a.bulan AND pasien.id_klasifikasi='1' AND pasien.id_pkm = a.id_pkm) AS Indigenous,
                                    (SELECT COUNT(pasien.id_klasifikasi) FROM pasien where   pasien.bulan = a.bulan AND pasien.id_klasifikasi='2' AND pasien.id_pkm = a.id_pkm) AS KasusImpor,
                                    (SELECT Indigenous + KasusImpor ) AS TotalPasien FROM  pasien a INNER JOIN puskemas b ON a.id_pkm=b.id_pkm GROUP BY a.id_pasien) as aTotalRow");
        return $query->row()->TotalRow;
        

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
        $pasien_nama_pkm_col   		= array('data' => 'Nama Puskesmas', 'class' => 'text-center td_nmpuskesmas');
        $pasien_bulan_col    	    = array('data' => 'Bulan', 'class' => 'text-center');
        $pasien_total_pasien_col	= array('data' => 'Total Pasien', 'class' => 'text-center');
        $pasien_indigenous_col 		= array('data' => 'Indigenous', 'class' => 'text-center');
        $pasien_kasusimpor_col 		= array('data' => 'Kasus Impor', 'class' => 'text-center');

        $this->table->set_heading($no_col, $pasien_nama_pkm_col, $pasien_bulan_col, $pasien_total_pasien_col,
        							$pasien_indigenous_col, $pasien_kasusimpor_col);

        // no urut data
        $no = 0 + $this->offset;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->NamaPuskesmas,
                $row->Bulan,
                $row->TotalPasien,
                $row->Indigenous,
                $row->KasusImpor
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }

}

/* End of file Pasienklas_model.php */
/* Location: ./application/models/Pasienklas_model.php */