<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public $data = array(
                        'breadcrumb'    => 'Dashboard',
                        'main_view'     => 'dashboard',
                        );

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('Dashboard_model', 'dashboard', TRUE);
    }

	public function index()
	{
		$this->data['count_m'] = $this->dashboard->count_m();
		$this->data['count_f'] = $this->dashboard->count_f();
		$this->data['count_contract'] = $this->dashboard->count_contract();
		$this->data['count_fulltime'] = $this->dashboard->count_fulltime();
		$this->data['count_kasuspositif'] = $this->dashboard->count_kasuspositif();
		$this->data['count_indigenous'] = $this->dashboard->count_indigenous();
		$this->data['count_kasusimpor'] = $this->dashboard->count_kasusimpor();
		$this->data['sum_suspek'] = $this->dashboard->sum_suspek();
		$this->data['sum_sd_diperiksa'] = $this->dashboard->sum_sd_diperiksa();
		$this->data['count_jenis_tp'] = $this->dashboard->count_jenis_tp();
		$this->data['count_jenis_kendali'] = $this->dashboard->count_jenis_kendali();

		$sum_jumlah_penduduk = $this->dashboard->sum_jumlah_penduduk();
		$sum_kasus_positif = $this->dashboard->sum_kasus_positif();
		$api_dashboard = ($sum_kasus_positif * 1000) / $sum_jumlah_penduduk;
		$this->data['api_dashboard'] = number_format((float)$api_dashboard, 2, '.', '');
		$this->load->view('template', $this->data);
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */