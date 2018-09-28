<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_model extends CI_Model {

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

        return $this->db->select('pasien.id_pasien, pasien.nm_pasien, pasien.umur, jenis_kelamin.nama_kelamin,
        							pasien.desa, puskemas.nama_pkm, pasien.tgl_kunjung, konfirmasi.jns_konfirmasi,
                                    obat.jenis_obat, parasit.jenis_parasit, klasifikasi.klas_kasus, hasil_obat.hasil_pengobatan')
                            ->from($this->db_tabel)
                            //->join('asal_keg', 'asal_keg.asal_keg = pasien.asal_keg')
                            ->join('jenis_kelamin', 'jenis_kelamin.jns_kelamin = pasien.jns_kelamin')
                            //->join('kerja', 'kerja.id_kerja = pasien.pekerjaan')
                            ->join('konfirmasi', 'konfirmasi.id_konf = pasien.id_konf')
                            ->join('parasit', 'parasit.id_parasit = pasien.id_parasit')
                            ->join('obat', 'obat.id_obat = pasien.id_obat')
                            //->join('kondisi', 'kondisi.id_kondisi = pasien.id_kondisi')
                            //->join('perawatan', 'perawatan.id_rawat = pasien.id_rawat')
                            //->join('fu4', 'fu4.id_fu4 = pasien.id_fu4')
                            //->join('fu14', 'fu14.id_fu14 = pasien.id_fu14')
                            //->join('fu28', 'fu28.id_fu28 = pasien.id_fu28')
                            //->join('fu3bl', 'fu3bl.id_fu3bl = pasien.id_fu3bl')
                            ->join('klasifikasi', 'klasifikasi.id_klasifikasi = pasien.id_klasifikasi')
                            //->join('rujuk_dari', 'rujuk_dari.id_rujukdari = pasien.id_rujukdari')
                            //->join('rujuk_ke', 'rujuk_ke.id_rujukan = pasien.id_rujukan')
                            ->join('hasil_obat', 'hasil_obat.id_pengobatan = pasien.id_pengobatan')
                            ->join('puskemas', 'puskemas.id_pkm = pasien.id_pkm')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('id_pasien', 'ASC')
                        ->get()
                        ->result();
	}


    function export(){
        $query = $this->db->select('pasien.id_pasien, pasien.nm_pasien, asal_keg.nama_keg, pasien.umur, jenis_kelamin.nama_kelamin,
                                    pasien.dusun, pasien.desa, pasien.lintang, pasien.bujur, pasien.tgl_riwayat, pasien.tgl_sakit,
                                    pasien.tgl_kunjung, pasien.tgl_obat, kerja.jns_kerja, konfirmasi.jns_konfirmasi, parasit.jenis_parasit,
                                    obat.jenis_obat, kondisi.kondisi_pasien, perawatan.jenis_rawatan, fu4.hasil_fu4, fu14.hasil_fu14,
                                    fu28.hasil_fu28, fu3bl.hasil_fu3bl, klasifikasi.klas_kasus, rujuk_dari.asal_rujuk, rujuk_ke.tujuan_rujuk,
                                    hasil_obat.hasil_pengobatan, puskemas.nama_pkm, pasien.bulan, pasien.tahun')
                            ->from($this->db_tabel)
                            ->join('asal_keg', 'asal_keg.asal_keg = pasien.asal_keg')
                            ->join('jenis_kelamin', 'jenis_kelamin.jns_kelamin = pasien.jns_kelamin')
                            ->join('kerja', 'kerja.id_kerja = pasien.pekerjaan')
                            ->join('konfirmasi', 'konfirmasi.id_konf = pasien.id_konf')
                            ->join('parasit', 'parasit.id_parasit = pasien.id_parasit')
                            ->join('obat', 'obat.id_obat = pasien.id_obat')
                            ->join('kondisi', 'kondisi.id_kondisi = pasien.id_kondisi')
                            ->join('perawatan', 'perawatan.id_rawat = pasien.id_rawat')
                            ->join('fu4', 'fu4.id_fu4 = pasien.id_fu4')
                            ->join('fu14', 'fu14.id_fu14 = pasien.id_fu14')
                            ->join('fu28', 'fu28.id_fu28 = pasien.id_fu28')
                            ->join('fu3bl', 'fu3bl.id_fu3bl = pasien.id_fu3bl')
                            ->join('klasifikasi', 'klasifikasi.id_klasifikasi = pasien.id_klasifikasi')
                            ->join('rujuk_dari', 'rujuk_dari.id_rujukdari = pasien.id_rujukdari')
                            ->join('rujuk_ke', 'rujuk_ke.id_rujukan = pasien.id_rujukan')
                            ->join('hasil_obat', 'hasil_obat.id_pengobatan = pasien.id_pengobatan')
                            ->join('puskemas', 'puskemas.id_pkm = pasien.id_pkm')
                        //->limit($this->per_halaman, $this->offset)
                        ->order_by('id_pasien', 'ASC')
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
        return $this->db->select('pasien.id_pasien, pasien.nm_pasien, pasien.umur, jenis_kelamin.nama_kelamin,
                                    pasien.desa, puskemas.nama_pkm, pasien.tgl_kunjung, konfirmasi.jns_konfirmasi,
                                    obat.jenis_obat, parasit.jenis_parasit, klasifikasi.klas_kasus, hasil_obat.hasil_pengobatan')
                            ->from($this->db_tabel)
                            //->join('asal_keg', 'asal_keg.asal_keg = pasien.asal_keg')
                            ->join('jenis_kelamin', 'jenis_kelamin.jns_kelamin = pasien.jns_kelamin')
                            //->join('kerja', 'kerja.id_kerja = pasien.pekerjaan')
                            ->join('konfirmasi', 'konfirmasi.id_konf = pasien.id_konf')
                            ->join('parasit', 'parasit.id_parasit = pasien.id_parasit')
                            ->join('obat', 'obat.id_obat = pasien.id_obat')
                            //->join('kondisi', 'kondisi.id_kondisi = pasien.id_kondisi')
                            //->join('perawatan', 'perawatan.id_rawat = pasien.id_rawat')
                            //->join('fu4', 'fu4.id_fu4 = pasien.id_fu4')
                            //->join('fu14', 'fu14.id_fu14 = pasien.id_fu14')
                            //->join('fu28', 'fu28.id_fu28 = pasien.id_fu28')
                            //->join('fu3bl', 'fu3bl.id_fu3bl = pasien.id_fu3bl')
                            ->join('klasifikasi', 'klasifikasi.id_klasifikasi = pasien.id_klasifikasi')
                            //->join('rujuk_dari', 'rujuk_dari.id_rujukdari = pasien.id_rujukdari')
                            //->join('rujuk_ke', 'rujuk_ke.id_rujukan = pasien.id_rujukan')
                            ->join('hasil_obat', 'hasil_obat.id_pengobatan = pasien.id_pengobatan')
                            ->join('puskemas', 'puskemas.id_pkm = pasien.id_pkm')
                            ->where('pasien.bulan', $sortbymonth)
                        ->order_by('id_pasien', 'ASC')
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

	public function cari_detail($id_pasien)
    {
        $this->db->select('pasien.id_pasien, pasien.nm_pasien, asal_keg.nama_keg, pasien.umur, jenis_kelamin.nama_kelamin,
        							pasien.dusun, pasien.desa, pasien.lintang, pasien.bujur, pasien.tgl_riwayat, pasien.tgl_sakit,
        							pasien.tgl_kunjung, pasien.tgl_obat, kerja.jns_kerja, konfirmasi.jns_konfirmasi, parasit.jenis_parasit,
        							obat.jenis_obat, kondisi.kondisi_pasien, perawatan.jenis_rawatan, fu4.hasil_fu4, fu14.hasil_fu14,
        							fu28.hasil_fu28, fu3bl.hasil_fu3bl, klasifikasi.klas_kasus, rujuk_dari.asal_rujuk, rujuk_ke.tujuan_rujuk,
        							hasil_obat.hasil_pengobatan, puskemas.nama_pkm, pasien.bulan')
                            ->from($this->db_tabel)
                            ->join('asal_keg', 'asal_keg.asal_keg = pasien.asal_keg')
                            ->join('jenis_kelamin', 'jenis_kelamin.jns_kelamin = pasien.jns_kelamin')
                            ->join('kerja', 'kerja.id_kerja = pasien.pekerjaan')
                            ->join('konfirmasi', 'konfirmasi.id_konf = pasien.id_konf')
                            ->join('parasit', 'parasit.id_parasit = pasien.id_parasit')
                            ->join('obat', 'obat.id_obat = pasien.id_obat')
                            ->join('kondisi', 'kondisi.id_kondisi = pasien.id_kondisi')
                            ->join('perawatan', 'perawatan.id_rawat = pasien.id_rawat')
                            ->join('fu4', 'fu4.id_fu4 = pasien.id_fu4')
                            ->join('fu14', 'fu14.id_fu14 = pasien.id_fu14')
                            ->join('fu28', 'fu28.id_fu28 = pasien.id_fu28')
                            ->join('fu3bl', 'fu3bl.id_fu3bl = pasien.id_fu3bl')
                            ->join('klasifikasi', 'klasifikasi.id_klasifikasi = pasien.id_klasifikasi')
                            ->join('rujuk_dari', 'rujuk_dari.id_rujukdari = pasien.id_rujukdari')
                            ->join('rujuk_ke', 'rujuk_ke.id_rujukan = pasien.id_rujukan')
                            ->join('hasil_obat', 'hasil_obat.id_pengobatan = pasien.id_pengobatan')
                            ->join('puskemas', 'puskemas.id_pkm = pasien.id_pkm')
                            ->where('pasien.id_pasien', $id_pasien);
        $query = $this->db->get();
        if ($query->num_rows()>0) { 
            return $query->row_array();
        }

        $query->free_result();
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
        $no_col                 		= array('data' => 'No', 'class' => 'text-center td_no');
        $pasien_id_pasien_col   		= array('data' => 'ID Pasien', 'class' => 'text-center td_nmpuskesmas');
        $pasien_nm_pasien_col    	    = array('data' => 'Nama Pasien', 'class' => 'text-center');
        //$pasien_nama_keg_col    	    = array('data' => 'Nama Kegiatan', 'class' => 'text-center');
        $pasien_umur_col 				= array('data' => 'Umur', 'class' => 'text-center');
        $pasien_nama_kelamin_col 		= array('data' => 'Jenis Kelamin', 'class' => 'text-center');
        //$pasien_dusun_col  				= array('data' => 'Dusun', 'class' => 'text-center');
        $pasien_nama_pkm_col            = array('data' => 'Nama Puskesmas', 'class' => 'text-center');
        $pasien_desa_col				= array('data' => 'Desa', 'class' => 'text-center');
        //$pasien_lintang_col 			= array('data' => 'Lintang', 'class' => 'text-center');
        //$pasien_bujur_col 				= array('data' => 'Bujur', 'class' => 'text-center');
        //$pasien_tgl_riwayat_col 		= array('data' => 'Tgl. Riwayat', 'class' => 'text-center');
        //$pasien_tgl_sakit_col 			= array('data' => 'Tgl. Sakit', 'class' => 'text-center');
        $pasien_tgl_kunjung_col 		= array('data' => 'Tgl. Kunjung', 'class' => 'text-center');
        //$pasien_tgl_obat_col 			= array('data' => 'Tgl. Obat', 'class' => 'text-center');
        //$pasien_jns_kerja_col 			= array('data' => 'Pekerjaan', 'class' => 'text-center');
        $pasien_jns_konfirmasi_col 		= array('data' => 'Jenis Konfirmasi', 'class' => 'text-center');
        $pasien_jenis_parasit_col 		= array('data' => 'Jenis Parasit', 'class' => 'text-center');
        $pasien_jenis_obat_col 			= array('data' => 'Jenis Obat', 'class' => 'text-center');
        //$pasien_kondisi_pasien_col 		= array('data' => 'Kondisi Pasien', 'class' => 'text-center');
        //$pasien_jenis_rawatan_col 		= array('data' => 'Jenis Perawatan', 'class' => 'text-center');
        //$pasien_hasil_fu4_col 			= array('data' => 'Hasil Fu4', 'class' => 'text-center');
        //$pasien_hasil_fu14_col 			= array('data' => 'Hasil Fu14', 'class' => 'text-center');
        //$pasien_hasil_fu28_col 			= array('data' => 'Hasil Fu28', 'class' => 'text-center');
        //$pasien_hasil_3bl_col 			= array('data' => 'Hasil Fu3bl', 'class' => 'text-center');
        $pasien_klas_kasus_col 			= array('data' => 'Klasifikasi', 'class' => 'text-center');
        //$pasien_asal_rujuk_col 			= array('data' => 'Asal Rujukan', 'class' => 'text-center');
        //$pasien_tujuan_rujuk_col 		= array('data' => 'Tujuan Rujukan', 'class' => 'text-center');
        $pasien_hasil_pengobatan_col	= array('data' => 'Hasil Pengobatan', 'class' => 'text-center');
        
        //$pasien_bulan_col 				= array('data' => 'Bulan', 'class' => 'text-center');
        $action_col                     = array('data' => 'Action', 'class' => 'text-center td_action', 'colspan' => 3);


        $this->table->set_heading($no_col, $pasien_id_pasien_col, $pasien_nm_pasien_col, $pasien_umur_col, $pasien_nama_kelamin_col, 
                                    $pasien_desa_col, $pasien_nama_pkm_col, $pasien_tgl_kunjung_col, $pasien_jns_konfirmasi_col, $pasien_jenis_parasit_col, 
                                    $pasien_jenis_obat_col, $pasien_klas_kasus_col, $pasien_hasil_pengobatan_col, $action_col);

        // no urut data
        $no = 0 + $this->offset;
        foreach ($data as $row)
        {
            $this->table->add_row(
                ++$no,
                $row->id_pasien,
                $row->nm_pasien,
                //$row->nama_keg,
                $row->umur,
                $row->nama_kelamin,
                //$row->dusun,
                $row->nama_pkm,
                $row->desa,
                //$row->lintang,
                //$row->bujur,
                //$row->tgl_riwayat,
                //$row->tgl_sakit,
                $row->tgl_kunjung,
                //$row->tgl_obat,
                //$row->jns_kerja,
                $row->jns_konfirmasi,
                $row->jenis_parasit,
                $row->jenis_obat,
                //$row->kondisi_pasien,
                //$row->jenis_rawatan,
                //$row->hasil_fu4,
                //$row->hasil_fu14,
                //$row->hasil_fu28,
                //$row->hasil_fu3bl,
                $row->klas_kasus,
                //$row->asal_rujuk,
                //$row->tujuan_rujuk,
                $row->hasil_pengobatan,
                
                //$row->bulan,
                anchor('pasien/detail/'.$row->id_pasien,'Detail',array('class' => 'btn btn-info btn-xs btn-flat center-block'))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }

}

/* End of file Pasien_model.php */
/* Location: ./application/models/Pasien_model.php */