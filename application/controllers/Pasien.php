<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends MY_Controller {

	public $data = array(
		'modul'         => 'pasien',
		'breadcrumb'    => 'Pasien',
		'pesan'         => '',
		'pagination'    => '',
		'tabel_data'    => '',
		'main_view'     => 'pasien/pasien',
		'form_action'   => '',
		'form_value'    => '',
		'nav_employee'  => '',
		'tree_menu_employee' => '',
		);

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pasien_model', 'pasien', TRUE);
	}

	public function index($offset = 0)
	{  
		$level = $this->session->userdata('level');
		if ($level == "Admin"){
			$this->data['nav_pasien'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'pasien/sortbymonth';

            // option bulan, untuk menu dropdown
			$bulan = $this->pasien->cari_bulan();
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

            // cari data pasien
			$pasien = $this->pasien->cari_semua($offset);
            // jika ada data pasien, tampilkan
			if ($pasien)
			{
				$tabel = $this->pasien->buat_tabel($pasien);
				$this->data['tabel_data'] = $tabel;

            // Paging
            // http://localhost/simalaria/index.php/pasien/pages/2
				$this->data['pagination'] = $this->pasien->paging(site_url('pasien/pages'));
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

	public function sortbymonth()
	{
		$level = $this->session->userdata('level');
		if ($level == "Admin"){
			$sortbymonth =  $this->input->post('bulan');
			$this->data['nav_pasien'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'pasien/sortbymonth';
            // hapus data temporary proses update
            // $this->session->unset_userdata('no_employee', '');
            // $this->session->unset_userdata('name', '');

            // option bulan, untuk menu dropdown
			$bulan = $this->pasien->cari_bulan();
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
			$pasien = $this->pasien->cari_bymonth($sortbymonth);
            // jika ada data pasien, tampilkan
			if ($pasien)
			{
				$tabel = $this->pasien->buat_tabel($pasien);
				$this->data['tabel_data'] = $tabel;

            	// Paging
            	// http://localhost/simalaria/index.php/pasien/pages/2
				$this->data['pagination'] = $this->pasien->paging(site_url('pasien/pages'));
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

	public function detail($id_pasien = NULL)
    {
        $level = $this->session->userdata('level');
        if ($level == "Admin"){
            $this->data['breadcrumb']  = 'Pasien';
            $this->data['sub_breadcrumb']  = 'Detail';
            $this->data['main_view']   = 'pasien/pasien_detail';
            $this->data['form_action'] = 'pasien/detail/' . $id_pasien;
            $this->data['nav_pasien'] = 'active';
            $this->data['tree_menu_master'] = 'active';
            $this->data['pasien'] = $this->pasien->cari_detail($id_pasien);
            // echo "<pre>";
            // print_r ($id_pasien);
            // echo "</pre>";
            // die();
            $this->load->view('template', $this->data);
        }   
        else {
            redirect('error');
        }
    }

    public function export(){

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $getdata = $this->pasien->export(); 
        // echo "<pre>";
        // print_r ($getdata);
        // echo "</pre>";
        // die();

        if(count($getdata)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("malaria.id") //creator
                    ->setTitle("Pasien - ");  //file title
 
            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
            $objget->setTitle('Pasien'); //sheet title
             
            $objget->getStyle("A1:AE1")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '777777')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );
 
            //table header
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J",
                            "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T",
                            "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE");
             
            $val = array("No.", "ID Pasien", "Nama", "Asal Kegiatan", "Umur", "Jenis Kelamin", "Dusun", "Desa", "Lintang", "Bujur",
                            "Tgl. Riwayat", "Tgl. Sakit", "Tgl. Kunjung", "Tgl. Obat", "Pekerjaan", "Jenis Konfirmasi", "Jenis Parasit", "Jenis Obat",
                            "Kondisi Pasien", "Jenis Perawatan", "Hasil fu4", "Hasil fu14", "Hasil fu28", "Hasil fu3bl", "Klasifikasi Kasus", "Asal Rujukan",
                            "Tujuan Rujukan", "Hasil Pengobatan", "Nama Puskesmas", "Bulan", "Tahun");

            $style = array(
                	'alignment' => array(
                		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                		),
                	'borders' => array(
                		'allborders' => array(
                			'style' => PHPExcel_Style_Border::BORDER_THIN
                			)
                		)

                	);
             
            for ($a=0;$a<31; $a++) 
            {
                $objset->setCellValue($cols[$a].'1', $val[$a]);
                 
                //Setting width cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // No.
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // ID Pasien
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Nama
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Asal Kegiatan
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Umur
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Jenis Kelamin
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Dusun
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Desa
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); // Lintang
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); // Bujur
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Tgl. Riwayat
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Tgl. Sakit
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15); // Tgl. Kunjung
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Tgl. Obat
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Pekerjaan
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15); // Jenis Konfirmasi
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); // Jenis Parasit
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Jenis Obat
                $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20); // Kondisi Pasien
                $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15); // Jenis Perawatan
                $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15); // Hasil fu4
                $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15); // Hasil fu14
                $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15); // Hasil fu28
                $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15); // Hasil Fu3bl
                $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15); // Klasifikasi Kasus
                $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15); // Asal Rujukan
                $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15); // Tujuan Rujukan
                $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(18); // Hasil Pengobatan
                $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(18); // Nama Puskesmas
                $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15); // Bulan
                $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15); // Tahun


                //Set Border Header
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }
             
            $baris  = 2;
            $no = 1;

            foreach ($getdata as $getdatapasien){
                 
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no++); //penomoran
                $objset->setCellValue("B".$baris, $getdatapasien->id_pasien); 
                $objset->setCellValue("C".$baris, $getdatapasien->nm_pasien); 
                $objset->setCellValue("D".$baris, $getdatapasien->nama_keg); 
                $objset->setCellValue("E".$baris, $getdatapasien->umur); 
                $objset->setCellValue("F".$baris, $getdatapasien->nama_kelamin);
                $objset->setCellValue("G".$baris, $getdatapasien->dusun);
                $objset->setCellValue("H".$baris, $getdatapasien->desa); 
                $objset->setCellValue("I".$baris, $getdatapasien->lintang); 
                $objset->setCellValue("J".$baris, $getdatapasien->bujur); 
                $objset->setCellValue("K".$baris, $getdatapasien->tgl_riwayat);
                $objset->setCellValue("L".$baris, $getdatapasien->tgl_sakit); 
                $objset->setCellValue("M".$baris, $getdatapasien->tgl_kunjung);
                $objset->setCellValue("N".$baris, $getdatapasien->tgl_obat);
                $objset->setCellValue("O".$baris, $getdatapasien->jns_kerja);
                $objset->setCellValue("P".$baris, $getdatapasien->jns_konfirmasi); 
                $objset->setCellValue("Q".$baris, $getdatapasien->jenis_parasit); 
                $objset->setCellValue("R".$baris, $getdatapasien->jenis_obat); 
                $objset->setCellValue("S".$baris, $getdatapasien->kondisi_pasien); 
                $objset->setCellValue("T".$baris, $getdatapasien->jenis_rawatan); 
                $objset->setCellValue("U".$baris, $getdatapasien->hasil_fu4); 
                $objset->setCellValue("V".$baris, $getdatapasien->hasil_fu14); 
                $objset->setCellValue("W".$baris, $getdatapasien->hasil_fu28); 
                $objset->setCellValue("X".$baris, $getdatapasien->hasil_fu3bl); 
                $objset->setCellValue("Y".$baris, $getdatapasien->klas_kasus); 
                $objset->setCellValue("Z".$baris, $getdatapasien->asal_rujuk); 
                $objset->setCellValue("AA".$baris, $getdatapasien->tujuan_rujuk); 
                $objset->setCellValue("AB".$baris, $getdatapasien->hasil_pengobatan); 
                $objset->setCellValue("AC".$baris, $getdatapasien->nama_pkm); 
                $objset->setCellValue("AD".$baris, $getdatapasien->bulan); 
                $objset->setCellValue("AE".$baris, $getdatapasien->tahun);

                //Set number value
                //$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

                //Set Style Data
				$objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('B1:B'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->applyFromArray($style)->getNumberFormat()->setFormatCode('General');
                $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$baris)->applyFromArray($style)->getNumberFormat()->setFormatCode('General');
                $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('H1:H'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('I1:I'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('J1:J'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('K1:K'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('L1:L'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('M1:M'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('N1:N'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('O1:O'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('P1:P'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('Q1:Q'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('R1:R'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('S1:S'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('T1:T'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('U1:U'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('V1:V'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('W1:W'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('X1:X'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('Y1:Y'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('Z1:Z'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('AA1:AA'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('AB1:AB'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('AC1:AC'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('AD1:AD'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('AE1:AE'.$baris)->applyFromArray($style);

                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export Pasien');
 
            $objPHPExcel->setActiveSheetIndex(0);

            $date = date("Y-m-d H:i:s");


            $filename = "Data Export Pasien ". $date .".xlsx";
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');                
            $objWriter->save('php://output');
        }else{
        	echo "export gagal";
            //redirect('Excel');
        }
    }

}

/* End of file Pasien.php */
/* Location: ./application/controllers/Pasien.php */