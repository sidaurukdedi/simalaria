<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemetaan extends MY_Controller {

	public $data = array(
		'modul'         => 'pemetaan',
		'breadcrumb'    => 'Pemetaan',
		'pesan'         => '',
		'pagination'    => '',
		'tabel_data'    => '',
		'main_view'     => 'pemetaan/pemetaan',
		'form_action'   => '',
		'form_value'    => '',
		'nav_employee'  => '',
		'tree_menu_employee' => '',
		);

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pemetaan_model', 'pemetaan', TRUE);
		
	}

	public function index($offset = 0)
	{  
		$level = $this->session->userdata('level');
		if ($level == "Admin"){
			$this->data['nav_pemetaan'] = 'active';
			$this->data['tree_menu_master'] = 'active';
			//$this->data['form_action']      = 'pemetaan/sortbymonth';

            // option bulan, untuk menu dropdown
			// $bulan = $this->vektor->cari_bulan();
   //          // data bulan ada
			// if($bulan)
			// {
			// 	$this->data['opt_bulan'] = array('' => 'Select One...');
			// 	foreach($bulan as $row)
			// 	{
			// 		$this->data['opt_bulan'][$row->bulan] = $row->bulan;
			// 	}
			// }
			// else
			// {
			// 	$this->data['opt_bulan']['00'] = '-';
			// 	$this->data['pesan'] = 'Data bulan tidak tersedia.';
			// }

            // cari data pemetaan
			$pemetaan = $this->pemetaan->cari_semua($offset);
            // jika ada data pemetaan, tampilkan
			if ($pemetaan)
			{
				$tabel = $this->pemetaan->buat_tabel($pemetaan);
				$this->data['tabel_data'] = $tabel;

            // Paging
            // http://localhost/simalaria/index.php/pemetaan/pages/2
				$this->data['pagination'] = $this->pemetaan->paging(site_url('pemetaan/pages'));
			}
        	// jika tidak ada data pemetaan
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
        $getdata = $this->pemetaan->export();       

        if(count($getdata)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("malaria.id") //creator
                    ->setTitle("Pemetaan - ");  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Pemetaan'); //sheet title

            $objget->getStyle("A1:E1")->applyFromArray(
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
            $cols = array("A","B","C", "D", "E");

            $val = array("No.", "ID Peta", "Lintang", "Bujur", "Kategori");

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

            for ($a=0;$a<5; $a++) 
            {
                $objset->setCellValue($cols[$a].'1', $val[$a]);

                //Setting width cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // No.
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // ID Peta
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Lintang
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Bujur
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Kategori

                //Set Border Header
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }

            $baris  = 2;
            $no = 1;


            foreach ($getdata as $getdatapeta){

                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no++); //penomoran
                $objset->setCellValue("B".$baris, $getdatapeta->id_peta); //membaca data id_peta
                $objset->setCellValue("C".$baris, $getdatapeta->lintang); //membaca data lintang
                $objset->setCellValue("D".$baris, $getdatapeta->bujur); //membaca data bujur
                $objset->setCellValue("E".$baris, $getdatapeta->kategori); //membaca data kategori

                //Set number value
                //$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

                //Set Style Data
                $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('B1:B'.$baris)->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->applyFromArray($style)->getNumberFormat()->setFormatCode('General');
                $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$baris)->applyFromArray($style)->getNumberFormat()->setFormatCode('General');
                $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$baris)->applyFromArray($style);

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export Pemetaan');

            $objPHPExcel->setActiveSheetIndex(0);

            $date = date("Y-m-d H:i:s");


            $filename = "Data Export Pemetaan ". $date .".xlsx";

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


    public function pdf(){
        $this->load->library('tcpdf/tcpdf.php');

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('My Title');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');

        $pdf->AddPage();
        $getdata = $this->pemetaan->export(); 

        $tbl = '<table border="0">';
        $tbl .= '<tr>';
        $tbl .= '<th>No. </th>';
        $tbl .= '<th>ID</th>';
        $tbl .= '<th>Lintang</th>';
        $tbl .= '<th>Bujur</th>';
        $tbl .= '<th>Kategori</th>';
        $tbl .= '</tr>';


        $no = 0;
        foreach($getdata as $post)
        {
            $tbl .= '<tr>'; 
            $tbl .= '<td>' . $no++ . '</td>';
            $tbl .= '<td>' . $post->id_peta . '</td>';
            $tbl .= '<td>' . $post->lintang . '</td>'; 
            $tbl .= '<td>' . $post->bujur . '</td>'; 
            $tbl .= '<td>' . $post->kategori . '</td>';   
            $tbl .= '</tr>'; 
        }

        $tbl .='</table>';
        $pdf->writeHTML($tbl, true, false, false, false, '');
        $pdf->Output('My-File-Name.pdf', 'I');

    }
}

/* End of file Pemetaan.php */
/* Location: ./application/controllers/Pemetaan.php */