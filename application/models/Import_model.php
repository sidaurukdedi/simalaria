<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_model extends CI_Model {

	public function importdatadesa($datadesa)
	{
		$this->db->insert("desa", $datadesa);
	}

	public function importdatavektor($datavektor)
	{
		$this->db->insert("vektor", $datavektor);
	}

	public function importdatapemetaan($datapemetaan)
	{
		$this->db->insert("pemetaan", $datapemetaan);
	}

	public function importdatalogistik($datalogistik)
	{
		$this->db->insert("logistik", $datalogistik);
	}

	public function importdatakegiatan($datakegiatan)
	{
		$this->db->insert("kegiatan", $datakegiatan);
	}

	public function importdatapasien($datapasien)
	{
		$this->db->insert("pasien", $datapasien);
	}

	function getLastInsertedDesa() {
    return $this->db->select('id_desa')
    				->order_by('id_desa','desc')->limit(1)
    				->get('desa')->row('id_desa');
	}

	function getLastInsertedPemetaan() {
    return $this->db->select('id_peta')
    				->order_by('id_peta','desc')->limit(1)
    				->get('pemetaan')->row('id_peta');
	}

	function getLastInsertedKegiatan() {
    return $this->db->select('id_kegiatan')
    				->order_by('id_kegiatan','desc')->limit(1)
    				->get('kegiatan')->row('id_kegiatan');
	}

	function getLastInsertedPasien() {
    return $this->db->select('no')
    				->order_by('no','desc')->limit(1)
    				->get('pasien')->row('no');
	}

	public function cekdeldesa($id_pkm, $tahun)
    {
        $this->db->select('*')
                 ->from('desa')
                 ->where('desa.id_pkm', $id_pkm)
                 ->where('desa.tahun', $tahun);
        $query = $this->db->get();
        if ($query->num_rows()>0) { 
        	$this->db->where('desa.id_pkm', $id_pkm)
                 		->where('desa.tahun', $tahun)
        				->delete('desa');
        }
    }

    public function cekdelvektor($lintangv, $bujurv)
    {
        $this->db->select('*')
                 ->from('vektor')
                 ->where('vektor.lintangv', $lintangv)
                 ->where('vektor.bujurv', $bujurv);
        $query = $this->db->get();
        if ($query->num_rows()>0) { 
        	$this->db->where('vektor.lintangv', $lintangv)
                 		->where('vektor.bujurv', $bujurv)
        				->delete('vektor');
        }
    }

    public function cekdellogistik($id_pkm, $bulan)
    {
        $this->db->select('*')
                 ->from('logistik')
                 ->where('logistik.id_pkm', $id_pkm)
                 ->where('logistik.bulan', $bulan);
        $query = $this->db->get();
        if ($query->num_rows()>0) { 
        	$this->db->where('logistik.id_pkm', $id_pkm)
                 		->where('logistik.bulan', $bulan)
        				->delete('logistik');
        }
    }

    public function cekdelpemetaan($lintang, $bujur)
    {
        $this->db->select('*')
                 ->from('pemetaan')
                 ->where('pemetaan.lintang', $lintang)
                 ->where('pemetaan.bujur', $bujur);
        $query = $this->db->get();
        if ($query->num_rows()>0) { 
        	$this->db->where('pemetaan.lintang', $lintang)
                 		->where('pemetaan.bujur', $bujur)
        				->delete('pemetaan');
        }
    }

    public function cekdelkegiatan($nama_pkm, $bulan, $tahun)
    {
        $this->db->select('*')
                 ->from('kegiatan')
                 ->where('kegiatan.nama_pkm', $nama_pkm)
                 ->where('kegiatan.bulan', $bulan)
                 ->where('kegiatan.tahun', $tahun);
        $query = $this->db->get();
        if ($query->num_rows()>0) { 
        	$this->db->where('kegiatan.nama_pkm', $nama_pkm)
                 		->where('kegiatan.bulan', $bulan)
                 		->where('kegiatan.tahun', $tahun)
        				->delete('kegiatan');
        }
    }

    public function cekdelpasien($id_pasien, $bulan)
    {
        $this->db->select('*')
                 ->from('pasien')
                 ->where('pasien.id_pasien', $id_pasien)
                 ->where('pasien.bulan', $bulan);
        $query = $this->db->get();
        if ($query->num_rows()>0) { 
        	$this->db->where('pasien.id_pasien', $id_pasien)
                 		->where('pasien.bulan', $bulan)
        				->delete('pasien');
        }
    }


    public function new_asal_keg($data)
    {
        return $this->db->where('nama_keg', $data)
            ->limit(1)
            ->get('asal_keg')
            ->row()->asal_keg;
    }

    public function new_jns_kelamin($data)
    {
        return $this->db->where('nama_kelamin', $data)
            ->limit(1)
            ->get('jenis_kelamin')
            ->row()->jns_kelamin;
    }

    public function new_pekerjaan($data)
    {
        return $this->db->where('jns_kerja', $data)
            ->limit(1)
            ->get('kerja')
            ->row()->id_kerja;
    }

    public function new_id_konfirmasi($data)
    {
        return $this->db->where('jns_konfirmasi', $data)
            ->limit(1)
            ->get('konfirmasi')
            ->row()->id_konf;
    }

    public function new_id_parasit($data)
    {
        return $this->db->where('jenis_parasit', $data)
            ->limit(1)
            ->get('parasit')
            ->row()->id_parasit;
    }

    public function new_id_rawat($data)
    {
        return $this->db->where('jenis_rawatan', $data)
            ->limit(1)
            ->get('perawatan')
            ->row()->id_rawat;
    }

    public function new_id_fu4($data)
    {
        return $this->db->where('hasil_fu4', $data)
            ->limit(1)
            ->get('fu4')
            ->row()->id_fu4;
    }

    public function new_id_fu14($data)
    {
        return $this->db->where('hasil_fu14', $data)
            ->limit(1)
            ->get('fu14')
            ->row()->id_fu14;
    }

    public function new_id_fu28($data)
    {
        return $this->db->where('hasil_fu28', $data)
            ->limit(1)
            ->get('fu28')
            ->row()->id_fu28;
    }

    public function new_id_fu3bl($data)
    {
        return $this->db->where('hasil_fu3bl', $data)
            ->limit(1)
            ->get('fu3bl')
            ->row()->id_fu3bl;
    }

    public function new_id_pengobatan($data)
    {
        return $this->db->where('hasil_pengobatan', $data)
            ->limit(1)
            ->get('hasil_obat')
            ->row()->id_pengobatan;
    }

    public function new_id_pkm($data)
    {
        return $this->db->where('nama_pkm', $data)
            ->limit(1)
            ->get('puskemas')
            ->row()->id_pkm;
    }
}

/* End of file Import_model.php */
/* Location: ./application/models/Import_model.php */