<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapor extends MY_Controller {

	public $data = array(
                        'modul'         => 'lapor',
                        'breadcrumb'    => 'Lapor',
                        'main_view'     => 'lapor/lapor',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        'main_view'     => 'lapor/lapor',
                        'form_action'   => '',
                        'form_value'    => '',
                        );

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('Import_model', 'import', TRUE);
    }

	public function index()
	{
		$this->data['form_action'] = 'lapor/upload';
		$this->load->view('template', $this->data);

	}

	public function upload(){
		// ini_set('max_execution_time', 0); 
		// ini_set('memory_limit','2048M');
		//ini_set('max_execution_time', 300);
		date_default_timezone_set('Asia/Jakarta');
		$nm = $_FILES['file']['name'];
		$now = date('y-m-d');
		$fileName = $now . '_' . $nm;
        //$fileName = time().$_FILES['file']['name'];

        $config['upload_path'] = './assets/uploads/temp/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(!$this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        //$media = $this->upload->data('file');
        //$inputFileName = './assets/uploads/temp/'. $media['file_name'];
    	$inputFileName = './assets/uploads/temp/'. $fileName;

        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }


 			// Sheet 0 Start
 			
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            // Import Data table desa Start
            $getdatacountdesa 	= $sheet->getCellByColumnAndRow(4,10)->getValue(); 
			$maxrowdesa 		= $getdatacountdesa+17;  
            for ($row = 18; $row <= $maxrowdesa; $row++){                  //  Read a row of data into an array                                                          
                
                 $no = $this->import->getLastInsertedDesa(); // Get Last ID Desa Database

                 //Sesuaikan sama nama kolom tabel di database                    
                 $datadesa = array(
                    "id_desa"		=> ++$no,
                    "nama_desa"		=> $sheet->getCellByColumnAndRow(2,$row)->getValue(),
                    "id_pkm"		=> $sheet->getCellByColumnAndRow(10,$row)->getValue(),
                    "jml_penduduk"	=> $sheet->getCellByColumnAndRow(3,$row)->getValue(),
                    "tahun"			=> $sheet->getCellByColumnAndRow(3,$row)->getValue()
                );

   				// Cek di database jika ada data sama, hapus.
                $this->import->cekdeldesa($datadesa['id_pkm'], $datadesa['tahun']);

                //sesuaikan nama dengan nama tabel
                $this->import->importdatadesa($datadesa);

                    
            }
            // Import Data table desa End


            // Import Data table vektor & pemetaan Start
            $maxrowvektor = $sheet->getCellByColumnAndRow(11,15)->getValue();
            for($row1 = 19; $row1<=$maxrowvektor+18; $row1++) {
            	//Sesuaikan sama nama kolom tabel di database                    
                 $datavektor = array(
                    "id_pkm"		=> $sheet->getCellByColumnAndRow(16,$row1)->getValue(),
                    "bulan"			=> $sheet->getCellByColumnAndRow(6,5)->getValue(),
                    "jenis_tp"		=> $sheet->getCellByColumnAndRow(11,$row1)->getValue(),
                    "lintangv"		=> $sheet->getCellByColumnAndRow(12,$row1)->getValue(),
                    "bujurv"		=> $sheet->getCellByColumnAndRow(13,$row1)->getValue(),
                    "luas_tp"		=> $sheet->getCellByColumnAndRow(14,$row1)->getValue(),
                    "jenis_kendali"	=> $sheet->getCellByColumnAndRow(15,$row1)->getValue(),
                    "kategori"		=> $sheet->getCellByColumnAndRow(22,$row1)->getValue()
                );

                $no = $this->import->getLastInsertedPemetaan(); // Get Last ID Peta Database
                //Sesuaikan sama nama kolom tabel di database   
                $datapemetaan = array(
                    "id_peta"		=> ++$no,
                    "lintang"		=> $sheet->getCellByColumnAndRow(12,$row1)->getValue(),
                    "bujur"			=> $sheet->getCellByColumnAndRow(13,$row1)->getValue(),
                    "kategori"		=> $sheet->getCellByColumnAndRow(22,$row1)->getValue()
                );

                 // Cek di database jika ada data sama, hapus.
                $this->import->cekdelvektor($datavektor['lintangv'], $datavektor['bujurv']);

                //sesuaikan nama dengan nama tabel
                $this->import->importdatavektor($datavektor);


                $this->import->cekdelpemetaan($datapemetaan['lintang'], $datapemetaan['bujur']);
                //sesuaikan nama dengan nama tabel
                $this->import->importdatapemetaan($datapemetaan);
            }
            // Import Data table vektor & pemetaan End

            // Import Data table logistik Start
            for($i = 0; $i<=1; $i++) {
            	$datalogistik = array(
            		"id_pkm"				=> $sheet->getCellByColumnAndRow(4,14)->getValue(),
            		"bulan"					=> $sheet->getCellByColumnAndRow(6,5)->getValue(),
            		"rdt"					=> $sheet->getCellByColumnAndRow(14,33)->getValue(),
            		"act"					=> $sheet->getCellByColumnAndRow(14,34)->getValue(),
            		"primaquin"				=> $sheet->getCellByColumnAndRow(14,35)->getValue(),
            		"artesunate_injeksi"	=> $sheet->getCellByColumnAndRow(14,36)->getValue(),
            		"artemeter_injeksi"		=> $sheet->getCellByColumnAndRow(14,37)->getValue(),
            		"kina_tablet"			=> $sheet->getCellByColumnAndRow(14,38)->getValue(),
            		"kina_injeksi"			=> $sheet->getCellByColumnAndRow(14,39)->getValue(),
            		"doksi_tablet"			=> $sheet->getCellByColumnAndRow(14,40)->getValue()
            		);

            	// Cek di database jika ada data sama, hapus.
                $this->import->cekdellogistik($datalogistik['id_pkm'], $datalogistik['bulan']);
                //sesuaikan nama dengan nama tabel
                $this->import->importdatalogistik($datalogistik);
            }
            // Import Data table logistik End
            // Sheet 0 End



            // Sheet 1 Start

            $sheet1 = $objPHPExcel->getSheet(1); 
            $highestRow1 = $sheet1->getHighestRow(); 
            $highestColumn1 = $sheet1->getHighestColumn();	


            // Import Data table kegiatan End       
            for($i = 0; $i<1; $i++) {                 //  Read a row of data into an array                                                          
                
                $no = $this->import->getLastInsertedKegiatan(); // Get Last ID Kegiatan Database
                $jumlah_penduduk    = $sheet1->getCellByColumnAndRow(8,6)->getValue();
                $kasus_positif      = $sheet1->getCellByColumnAndRow(4,18)->getValue();
                $total_api          = ($kasus_positif * 1000) / $jumlah_penduduk;
                 //Sesuaikan sama nama kolom tabel di database                    
                 $datakegiatan = array(
                    "id_kegiatan"		=> ++$no,
                    "nama_pkm"			=> $sheet1->getCellByColumnAndRow(3,7)->getValue(),
                    "bulan"				=> $sheet1->getCellByColumnAndRow(8,5)->getValue(),
                    "tahun"				=> $sheet1->getCellByColumnAndRow(8,4)->getValue(),
                    "jumlah_penduduk"   => $jumlah_penduduk,
                    "suspek"			=> $sheet1->getCellByColumnAndRow(4,9)->getValue(),
                    "sd_diperiksa"		=> $sheet1->getCellByColumnAndRow(4,17)->getValue(),
                    "kasus_positif"     => $kasus_positif,
                    "api"               => $total_api,
                    "negatif_rdt"		=> $sheet1->getCellByColumnAndRow(4,11)->getValue(),
                    "negatif_mikro"		=> $sheet1->getCellByColumnAndRow(6,11)->getValue(),
                    "negatif_pcr"		=> $sheet1->getCellByColumnAndRow(5,11)->getValue(),
                    "skrin_pos"			=> $sheet1->getCellByColumnAndRow(5,12)->getValue(),
                    "skrin_neg"			=> $sheet1->getCellByColumnAndRow(7,12)->getValue(),
                    "kelambu_anc"		=> $sheet1->getCellByColumnAndRow(4,13)->getValue(),
                    "kelambu_imun"		=> $sheet1->getCellByColumnAndRow(4,14)->getValue(),
                    "kelambu_balita"	=> $sheet1->getCellByColumnAndRow(4,15)->getValue(),
                    "kelambu_lain"		=> $sheet1->getCellByColumnAndRow(4,16)->getValue()
                );

   				// Cek di database jika ada data sama, hapus.
                $this->import->cekdelkegiatan($datakegiatan['nama_pkm'], $datakegiatan['bulan'], $datakegiatan['tahun']);

                //sesuaikan nama dengan nama tabel
                $this->import->importdatakegiatan($datakegiatan);  
            }
            // Import Data table desa End

            $getdatacountpasien = $sheet1->getCellByColumnAndRow(3,21)->getValue();
			$maxrowpasien 		= $getdatacountpasien+26;  
			for ($row2 = 27; $row2 <= $maxrowpasien; $row2++){                  //  Read a row of data into an array     
				$no = $this->import->getLastInsertedPasien(); 				// Get Last ID Kegiatan Database
				//Sesuaikan sama nama kolom tabel di database
				$new_asal_keg 		= $this->import->new_asal_keg($sheet1->getCellByColumnAndRow(2,$row2)->getValue());
				$new_jns_kelamin 	= $this->import->new_jns_kelamin($sheet1->getCellByColumnAndRow(6,$row2)->getValue());
				$new_pekerjaan 		= $this->import->new_pekerjaan($sheet1->getCellByColumnAndRow(16,$row2)->getValue());
				$new_id_konfirmasi 	= $this->import->new_id_konfirmasi($sheet1->getCellByColumnAndRow(17,$row2)->getValue());
				$new_id_parasit 	= $this->import->new_id_parasit($sheet1->getCellByColumnAndRow(18,$row2)->getValue());
				$new_id_rawat  		= $this->import->new_id_rawat($sheet1->getCellByColumnAndRow(24,$row2)->getValue());
				$new_id_fu4  		= $this->import->new_id_fu4($sheet1->getCellByColumnAndRow(25,$row2)->getValue());
				$new_id_fu14  		= $this->import->new_id_fu14($sheet1->getCellByColumnAndRow(26,$row2)->getValue());
				$new_id_fu28  		= $this->import->new_id_fu28($sheet1->getCellByColumnAndRow(27,$row2)->getValue());
				$new_id_fu3bl  		= $this->import->new_id_fu3bl($sheet1->getCellByColumnAndRow(28,$row2)->getValue());
				// echo $new_id_fu4;
				// echo $new_id_fu14;
				// echo $new_id_fu28;
				// echo $new_id_fu3bl;
				//echo $sheet1->getCellByColumnAndRow(25,$row2)->getValue();
				//echo $sheet1->getCellByColumnAndRow(26,$row2)->getValue();
				//echo $sheet1->getCellByColumnAndRow(27,$row2)->getValue();
				//echo $sheet1->getCellByColumnAndRow(28,$row2)->getValue();
				//die();
				$new_id_pengobatan  = $this->import->new_id_pengobatan($sheet1->getCellByColumnAndRow(32,$row2)->getValue());
				$new_id_pkm  		= $this->import->new_id_pkm($sheet1->getCellByColumnAndRow(3,7)->getValue());
                $datapasien = array(
                    "no"				=> ++$no,
                    "id_pasien"			=> $sheet1->getCellByColumnAndRow(1,$row2)->getValue(),
                    "nm_pasien"			=> $sheet1->getCellByColumnAndRow(3,$row2)->getValue(),
                    "asal_keg"			=> $new_asal_keg,
                    "umur"				=> $sheet1->getCellByColumnAndRow(4,$row2)->getValue(),
                    "jns_kelamin"		=> $new_jns_kelamin,
                    "dusun"				=> $sheet1->getCellByColumnAndRow(8,$row2)->getValue(),
                    "desa"				=> $sheet1->getCellByColumnAndRow(9,$row2)->getValue(),
                    "lintang"			=> $sheet1->getCellByColumnAndRow(10,$row2)->getValue(),
                    "bujur"				=> $sheet1->getCellByColumnAndRow(11,$row2)->getValue(),
                    "tgl_riwayat"		=> date('Y-m-d', ($sheet1->getCellByColumnAndRow(12,$row2)->getValue() - 25569) * 86400),
                    "tgl_sakit"			=> date('Y-m-d', ($sheet1->getCellByColumnAndRow(13,$row2)->getValue() - 25569) * 86400),
                    "tgl_kunjung"		=> date('Y-m-d', ($sheet1->getCellByColumnAndRow(14,$row2)->getValue() - 25569) * 86400),
                    "tgl_obat"			=> date('Y-m-d', ($sheet1->getCellByColumnAndRow(15,$row2)->getValue() - 25569) * 86400),
                    "pekerjaan"			=> $new_pekerjaan,
                    "id_konf"			=> $new_id_konfirmasi,
                    "id_parasit"		=> $new_id_parasit,
                    "id_obat"			=> $sheet1->getCellByColumnAndRow(19,$row2)->getValue(),
                    "id_kondisi"		=> $sheet1->getCellByColumnAndRow(23,$row2)->getValue(),
                    "id_rawat"			=> $new_id_rawat,
                    "id_fu4"			=> $new_id_fu4,
                    "id_fu14"			=> $new_id_fu14,
                    "id_fu28"			=> "3",
                    "id_fu3bl"			=> "3",
                    "id_klasifikasi"	=> $sheet1->getCellByColumnAndRow(29,$row2)->getValue(),
                    "id_rujukdari"		=> $sheet1->getCellByColumnAndRow(30,$row2)->getValue(),
                    "id_rujukan"		=> $sheet1->getCellByColumnAndRow(31,$row2)->getValue(),
                    "id_pengobatan"		=> $new_id_pengobatan,
                    "id_pkm"			=> $new_id_pkm,
                    "bulan"				=> $sheet1->getCellByColumnAndRow(8,5)->getValue(),
                    "tahun"				=> $sheet1->getCellByColumnAndRow(8,4)->getValue()
                );
// echo "<pre>";
// print_r ($datapasien);
// echo "</pre>";
// die();

				// Cek di database jika ada data sama, hapus.
                $this->import->cekdelpasien($datapasien['id_pasien'], $datapasien['bulan']);

                //sesuaikan nama dengan nama tabel
                $this->import->importdatapasien($datapasien);

                //Delete file temp upload
                @unlink('./assets/uploads/temp/' . $inputFileName); 
                    
			}



        redirect('dashboard');
    }

}

/* End of file Lapor.php */
/* Location: ./application/controllers/Lapor.php */