<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public $db_tabel = 'employee';

	public function count_m()
	{

		return $this->db->from($this->db_tabel)
						->where('gender', 'M')
						->get()
						->num_rows();
	}

	public function count_f()
	{

		return $this->db->from($this->db_tabel)
						->where('gender', 'F')
						->get()
						->num_rows();
	}

	public function count_contract()
	{

		return $this->db->from($this->db_tabel)
						->where('id_employee_status', '02')
						->get()
						->num_rows();
	}

	public function count_fulltime()
	{

		return $this->db->from($this->db_tabel)
						->where('id_employee_status', '01')
						->get()
						->num_rows();
	}

	public function count_kasuspositif()
	{

		return $this->db->from('pasien')
						->where('id_pasien IS NOT NULL', NULL, false)
						->get()
						->num_rows();
	}

	public function count_indigenous()
	{

		return $this->db->from('pasien')
						->where('id_klasifikasi', '1')
						->get()
						->num_rows();
	}

	public function count_kasusimpor()
	{

		return $this->db->from('pasien')
						->where('id_klasifikasi', '2')
						->get()
						->num_rows();
	}

	public function sum_suspek()
	{

		return $this->db->select_sum('suspek')
						->from('kegiatan')
						->get()
						->row()->suspek;
	}

	public function sum_sd_diperiksa()
	{
		return $this->db->select_sum('sd_diperiksa')
						->from('kegiatan')
						->get()
						->row()->sd_diperiksa;
	}

	public function sum_jumlah_penduduk()
	{
		return $this->db->select_sum('jumlah_penduduk')
						->from('kegiatan')
						->get()
						->row()->jumlah_penduduk;
	}

	public function sum_kasus_positif()
	{
		return $this->db->select_sum('kasus_positif')
						->from('kegiatan')
						->get()
						->row()->kasus_positif;
	}

	public function count_jenis_tp()
	{

		return $this->db->from('vektor')
						->where('jenis_tp IS NOT NULL', NULL, false)
						->get()
						->num_rows();
	}

	public function count_jenis_kendali()
	{

		return $this->db->from('vektor')
						->where('jenis_kendali IS NOT NULL', NULL, false)
						->get()
						->num_rows();
	}


}

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */