<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends MY_Controller {

	public $data = array(
		'modul'         => 'obat',
		'breadcrumb'    => 'Logistik Obat',
		'pesan'         => '',
		'pagination'    => '',
		'tabel_data'    => '',
		'main_view'     => 'obat/obat',
		'form_action'   => '',
		'form_value'    => '',
		'nav_employee'  => '',
		'tree_menu_employee' => '',
		);

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Obat_model', 'obat', TRUE);
	}

	public function index($offset = 0)
	{  
		$level = $this->session->userdata('level');
		if ($level == "Admin"){
			$this->data['nav_obat'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'obat/sortbymonth';
            // hapus data temporary proses update
            // $this->session->unset_userdata('no_employee', '');
            // $this->session->unset_userdata('name', '');

            // option bulan, untuk menu dropdown
			$bulan = $this->obat->cari_bulan();
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

            // cari data obat
			$obat = $this->obat->cari_semua($offset);
            // jika ada data obat, tampilkan
			if ($obat)
			{
				$tabel = $this->obat->buat_tabel($obat);
				$this->data['tabel_data'] = $tabel;

            // Paging
            // http://localhost/simalaria/index.php/obat/pages/2
				$this->data['pagination'] = $this->obat->paging(site_url('obat/pages'));
			}
        	// jika tidak ada data obat
			else
			{
				$this->data['pesan'] = 'Tidak ada data obat.';
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
			$this->data['nav_obat'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			$this->data['form_action']      = 'obat/sortbymonth';
            // hapus data temporary proses update
            // $this->session->unset_userdata('no_employee', '');
            // $this->session->unset_userdata('name', '');

            // option bulan, untuk menu dropdown
			$bulan = $this->obat->cari_bulan();
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

            // cari data obat
			$obat = $this->obat->cari_bymonth($sortbymonth);
            // jika ada data obat, tampilkan
			if ($obat)
			{
				$tabel = $this->obat->buat_tabel($obat);
				$this->data['tabel_data'] = $tabel;

            	// Paging
            	// http://localhost/simalaria/index.php/obat/pages/2
				$this->data['pagination'] = $this->obat->paging(site_url('obat/pages'));
			}
        	// jika tidak ada data obat
			else
			{
				$this->data['pesan'] = 'Tidak ada data obat.';
			}
			$this->load->view('template', $this->data);
		}   
		else {
			redirect('error');
		}
		
		
	}

	public function export(){

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $getdata = $this->obat->export(); 

        if(count($getdata)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("malaria.id") //creator
                    ->setTitle("Logistik - ");  //file title
 
            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
            $objget->setTitle('Logistik'); //sheet title
             
            $objget->getStyle("A1:K1")->applyFromArray(
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
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K");
             
            $val = array("No.", "Nama Puskesmas", "Bulan", "RDT", "ACT", "Primaquin", "Artesunate Injeksi", "Artemeter Injeksi", "Kina Tablet",
                            "Kina Injeksi", "Doksi Tablet");

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
             
            for ($a=0;$a<11; $a++) 
            {
                $objset->setCellValue($cols[$a].'1', $val[$a]);
                 
                //Setting width cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // No.
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Nama Puskesmas
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Bulan
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // RDT
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // ACT
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Primaquin
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Artesunate Injeksi
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Artemeter Injeksi
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); // Kina Tablet
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); // Kina Injeksi
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Doksi Tablet

                //Set Border Header
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }
             
            $baris  = 2;
            $no = 1;

            foreach ($getdata as $getdatalogistik){
                 
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no++); //penomoran
                $objset->setCellValue("B".$baris, $getdatalogistik->nama_pkm); 
                $objset->setCellValue("C".$baris, $getdatalogistik->bulan); 
                $objset->setCellValue("D".$baris, $getdatalogistik->rdt); 
                $objset->setCellValue("E".$baris, $getdatalogistik->act); 
                $objset->setCellValue("F".$baris, $getdatalogistik->primaquin);
                $objset->setCellValue("G".$baris, $getdatalogistik->artesunate_injeksi);
                $objset->setCellValue("H".$baris, $getdatalogistik->artemeter_injeksi); 
                $objset->setCellValue("I".$baris, $getdatalogistik->kina_tablet);
                $objset->setCellValue("J".$baris, $getdatalogistik->kina_injeksi);
                $objset->setCellValue("K".$baris, $getdatalogistik->doksi_tablet);

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


                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export Logistik');
 
            $objPHPExcel->setActiveSheetIndex(0);

            $date = date("Y-m-d H:i:s");


            $filename = "Data Export Logistik ". $date .".xlsx";
               
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

/* End of file Obat.php */
/* Location: ./application/controllers/Obat.php */