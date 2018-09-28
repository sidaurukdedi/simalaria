<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends MY_Controller {

	public $data = array(
		'modul'         => 'kegiatan',
		'breadcrumb'    => 'Kegiatan',
		'pesan'         => '',
		'pagination'    => '',
		'tabel_data'    => '',
		'main_view'     => 'kegiatan/kegiatan',
		'form_action'   => '',
		'form_value'    => '',
		'nav_employee'  => '',
		'tree_menu_employee' => '',
		);

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kegiatan_model', 'kegiatan', TRUE);
	}

	public function index($offset = 0)
	{  
		$level = $this->session->userdata('level');
		if ($level == "Admin"){
			$this->data['nav_kegiatan'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'kegiatan/sortbymonth';

            // option bulan, untuk menu dropdown
			$bulan = $this->kegiatan->cari_bulan();
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

            // cari data kegiatan
			$kegiatan = $this->kegiatan->cari_semua($offset);
            // jika ada data kegiatan, tampilkan
			if ($kegiatan)
			{
				$tabel = $this->kegiatan->buat_tabel($kegiatan);
				$this->data['tabel_data'] = $tabel;

            // Paging
            // http://localhost/simalaria/index.php/kegiatan/pages/2
				$this->data['pagination'] = $this->kegiatan->paging(site_url('kegiatan/pages'));
			}
        	// jika tidak ada data kegiatan
			else
			{
				$this->data['pesan'] = 'Tidak ada data kegiatan.';
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
			$this->data['nav_kegiatan'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'kegiatan/sortbymonth';
            // hapus data temporary proses update
            // $this->session->unset_userdata('no_employee', '');
            // $this->session->unset_userdata('name', '');

            // option bulan, untuk menu dropdown
			$bulan = $this->kegiatan->cari_bulan();
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

            // cari data kegiatan
			$kegiatan = $this->kegiatan->cari_bymonth($sortbymonth);
            // jika ada data kegiatan, tampilkan
			if ($kegiatan)
			{
				$tabel = $this->kegiatan->buat_tabel($kegiatan);
				$this->data['tabel_data'] = $tabel;

            	// Paging
            	// http://localhost/simalaria/index.php/kegiatan/pages/2
				$this->data['pagination'] = $this->kegiatan->paging(site_url('kegiatan/pages'));
			}
        	// jika tidak ada data kegiatan
			else
			{
				$this->data['pesan'] = 'Tidak ada data kegiatan.';
			}
			$this->load->view('template', $this->data);
		}   
		else {
			redirect('error');
		}
	}

	public function export(){

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $getdata = $this->kegiatan->export(); 

        if(count($getdata)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("malaria.id") //creator
                    ->setTitle("Kegiatan - ");  //file title
 
            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
            $objget->setTitle('Kegiatan'); //sheet title
             
            $objget->getStyle("A1:R1")->applyFromArray(
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
                            "K", "L", "M", "N", "O", "P", "Q", "R");
             
            $val = array("No.", "Nama Puskesmas", "Bulan", "Tahun", "Jumlah Penduduk", "Suspek", "SD. Diperiksa", "Kasus Positif", "API", "Negatif RDT",
                            "Negatif Mikro", "Negatif PCR", "Skrining Positif", "Skrining Negatif", "Kelambu ANC", "Kelambu Imun", "Kelambu Balita", "Kelambu Lain");

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
             
            for ($a=0;$a<18; $a++) 
            {
                $objset->setCellValue($cols[$a].'1', $val[$a]);
                 
                //Setting width cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // No.
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Nama Puskesmas
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Bulan
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Tahun
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18); // Jumlah Penduduk
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Suspek
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // SD. Diperiksa
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Kasus Positif
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); // API
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); // Negatif RDT
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Negatif Mikro
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Negatif PCR
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15); // Skrining Positif
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Skrining Negatif
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Kelambu ANC
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15); // Kelambu Imun
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); // Kelambu Balita
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Kelambu Lain

                //Set Border Header
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }
             
            $baris  = 2;
            $no = 1;


            foreach ($getdata as $getdatakegiatan){
                 
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no++); //penomoran
                $objset->setCellValue("B".$baris, $getdatakegiatan->nama_pkm); 
                $objset->setCellValue("C".$baris, $getdatakegiatan->bulan); 
                $objset->setCellValue("D".$baris, $getdatakegiatan->tahun); 
                $objset->setCellValue("E".$baris, $getdatakegiatan->jumlah_penduduk); 
                $objset->setCellValue("F".$baris, $getdatakegiatan->suspek);
                $objset->setCellValue("G".$baris, $getdatakegiatan->sd_diperiksa);
                $objset->setCellValue("H".$baris, $getdatakegiatan->kasus_positif); 
                $objset->setCellValue("I".$baris, $getdatakegiatan->api); 
                $objset->setCellValue("J".$baris, $getdatakegiatan->negatif_rdt); 
                $objset->setCellValue("K".$baris, $getdatakegiatan->negatif_mikro);
                $objset->setCellValue("L".$baris, $getdatakegiatan->negatif_pcr); 
                $objset->setCellValue("M".$baris, $getdatakegiatan->skrin_pos);
                $objset->setCellValue("N".$baris, $getdatakegiatan->skrin_neg);
                $objset->setCellValue("O".$baris, $getdatakegiatan->kelambu_anc);
                $objset->setCellValue("P".$baris, $getdatakegiatan->kelambu_imun); 
                $objset->setCellValue("Q".$baris, $getdatakegiatan->kelambu_balita); 
                $objset->setCellValue("R".$baris, $getdatakegiatan->kelambu_lain); 

                //Set number value
                //$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

                //Set Style Data
				$objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('B1:B'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('H1:H'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('I1:I'.$baris)->applyFromArray($style)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('J1:J'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('K1:K'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('L1:L'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('M1:M'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('N1:N'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('O1:O'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('P1:P'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('Q1:Q'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('R1:R'.$baris)->applyFromArray($style);


                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export Kegiatan');
 
            $objPHPExcel->setActiveSheetIndex(0);

            $date = date("Y-m-d H:i:s");


            $filename = "Data Export Kegiatan ". $date .".xlsx";
               
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

/* End of file Kegiatan.php */
/* Location: ./application/controllers/Kegiatan.php */