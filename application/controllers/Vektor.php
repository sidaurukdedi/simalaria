<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vektor extends MY_Controller {

	public $data = array(
		'modul'         => 'vektor',
		'breadcrumb'    => 'Vektor',
		'pesan'         => '',
		'pagination'    => '',
		'tabel_data'    => '',
		'main_view'     => 'vektor/vektor',
		'form_action'   => '',
		'form_value'    => '',
		'nav_employee'  => '',
		'tree_menu_employee' => '',
		);

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Vektor_model', 'vektor', TRUE);
	}

	public function index($offset = 0)
	{  
		$level = $this->session->userdata('level');
		if ($level == "Admin"){
			$this->data['nav_vektor'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'vektor/sortbymonth';

            // option bulan, untuk menu dropdown
			$bulan = $this->vektor->cari_bulan();
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

            // cari data vektor
			$vektor = $this->vektor->cari_semua($offset);
            // jika ada data vektor, tampilkan
			if ($vektor)
			{
				$tabel = $this->vektor->buat_tabel($vektor);
				$this->data['tabel_data'] = $tabel;

            // Paging
            // http://localhost/simalaria/index.php/vektor/pages/2
				$this->data['pagination'] = $this->vektor->paging(site_url('vektor/pages'));
			}
        	// jika tidak ada data vektor
			else
			{
				$this->data['pesan'] = 'Tidak ada data vektor.';
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
			$this->data['nav_vektor'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'vektor/sortbymonth';

            // option bulan, untuk menu dropdown
			$bulan = $this->vektor->cari_bulan();
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

            // cari data vektor
			$vektor = $this->vektor->cari_bymonth($sortbymonth);
            // jika ada data vektor, tampilkan
			if ($vektor)
			{
				$tabel = $this->vektor->buat_tabel($vektor);
				$this->data['tabel_data'] = $tabel;

            	// Paging
            	// http://localhost/simalaria/index.php/vektor/pages/2
				$this->data['pagination'] = $this->vektor->paging(site_url('vektor/pages'));
			}
        	// jika tidak ada data vektor
			else
			{
				$this->data['pesan'] = 'Tidak ada data vektor.';
			}
			$this->load->view('template', $this->data);
		}   
		else {
			redirect('error');
		}
	}

	public function export(){

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $getdata = $this->vektor->export(); 
        
        if(count($getdata)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("malaria.id") //creator
                    ->setTitle("Vektor - ");  //file title
 
            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
            $objget->setTitle('Vektor'); //sheet title
             
            $objget->getStyle("A1:I1")->applyFromArray(
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
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");
             
            $val = array("No.", "Nama Puskesmas", "Bulan", "Jenis TP", "Lintang", "Bujur", "Luas TP", "Jenis Kendali", "Kategori");

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
             
            for ($a=0;$a<9; $a++) 
            {
                $objset->setCellValue($cols[$a].'1', $val[$a]);
                 
                //Setting width cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // No.
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Nama Puskesmas
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Bulan
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Jenis TP
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Lintang
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Bujur
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Luas TP
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Jenis Kendali
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); // Kategori

                //Set Border Header
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }
             
            $baris  = 2;
            $no = 1;

            foreach ($getdata as $getdatavektor){
                 
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no++); //penomoran
                $objset->setCellValue("B".$baris, $getdatavektor->nama_pkm); 
                $objset->setCellValue("C".$baris, $getdatavektor->bulan); 
                $objset->setCellValue("D".$baris, $getdatavektor->jenis_tp); 
                $objset->setCellValue("E".$baris, $getdatavektor->lintangv); 
                $objset->setCellValue("F".$baris, $getdatavektor->bujurv);
                $objset->setCellValue("G".$baris, $getdatavektor->luas_tp);
                $objset->setCellValue("H".$baris, $getdatavektor->jenis_kendali); 
                $objset->setCellValue("I".$baris, $getdatavektor->kategori);

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


                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export Vektor');
 
            $objPHPExcel->setActiveSheetIndex(0);

            $date = date("Y-m-d H:i:s");


            $filename = "Data Export Vektor ". $date .".xlsx";
               
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

/* End of file Vektor.php */
/* Location: ./application/controllers/Vektor.php */