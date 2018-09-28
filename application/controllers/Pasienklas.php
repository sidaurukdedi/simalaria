<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasienklas extends MY_Controller {

	public $data = array(
		'modul'         => 'pasienklas',
		'breadcrumb'    => 'Pasien Klasifikasi',
		'pesan'         => '',
		'pagination'    => '',
		'tabel_data'    => '',
		'main_view'     => 'pasienklas/pasienklas',
		'form_action'   => '',
		'form_value'    => '',
		'nav_employee'  => '',
		'tree_menu_employee' => '',
		);

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pasienklas_model', 'pasienklas', TRUE);
	}


	public function index($offset = 0)
	{  
		$level = $this->session->userdata('level');
		if ($level == "Admin"){
			$this->data['nav_pasienklas'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'pasienklas/sortbymonth';

            // option bulan, untuk menu dropdown
			$bulan = $this->pasienklas->cari_bulan();
            // data bulan ada
			if($bulan)
			{
				$this->data['opt_bulan'] = array('' => 'Select One...');
				foreach($bulan as $row)
				{
					$this->data['opt_bulan'][$row->bulan] = $row->bulan;
				}
			}
			else
			{
				$this->data['opt_bulan'][''] = '-';
				$this->data['pesan'] = 'Data bulan tidak tersedia.';
			}

            // cari data pasienklas
			$pasienklas = $this->pasienklas->cari_semua($offset);
            // jika ada data pasienklas, tampilkan
			if ($pasienklas)
			{
				$tabel = $this->pasienklas->buat_tabel($pasienklas);
				$this->data['tabel_data'] = $tabel;

            // Paging
            // http://localhost/simalaria/index.php/pasienklas/pages/2
				$this->data['pagination'] = $this->pasienklas->paging(site_url('pasienklas/pages'));
			}
        	// jika tidak ada data pasienklas
			else
			{
				$this->data['pesan'] = 'Tidak ada data pasien klasifikasi.';
			}
			$this->load->view('template', $this->data);
		}   
		else {
			redirect('error');
		}
	}

	public function sortbymonth()
	{
		$level = $this->session->userdata('level');
		if ($level == "Admin"){
			$sortbymonth =  $this->input->post('bulan');
			$this->data['nav_pasienklas'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'pasienklas/sortbymonth';
            // hapus data temporary proses update
            // $this->session->unset_userdata('no_employee', '');
            // $this->session->unset_userdata('name', '');

            // option bulan, untuk menu dropdown
			$bulan = $this->pasienklas->cari_bulan();
            // data bulan ada
			if($bulan)
			{
				$this->data['opt_bulan'] = array('' => 'Select One...');
				foreach($bulan as $row)
				{
					$this->data['opt_bulan'][$row->bulan] = $row->bulan;
				}
			}
			else
			{
				$this->data['opt_bulan']['00'] = '-';
				$this->data['pesan'] = 'Data bulan tidak tersedia.';
			}

            // cari data pasien
			$pasienklas = $this->pasienklas->cari_bymonth($sortbymonth);
            // jika ada data pasien, tampilkan
			if ($pasienklas)
			{
				$tabel = $this->pasienklas->buat_tabel($pasienklas);
				$this->data['tabel_data'] = $tabel;

            	// Paging
            	// http://localhost/simalaria/index.php/pasien/pages/2
				$this->data['pagination'] = $this->pasienklas->paging(site_url('pasienklas/pages'));
			}
        	// jika tidak ada data pasien
			else
			{
				$this->data['pesan'] = 'Tidak ada data pasien.';
			}
			$this->load->view('template', $this->data);
		}   
		else {
			redirect('error');
		}
	}

}

/* End of file Pasienklas.php */
/* Location: ./application/controllers/Pasienklas.php */