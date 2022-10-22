<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Lap_Pegawai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Laporan/M_Lap_Pegawai');
	}

	public function index()
	{
		$data = array(
			'page' 		=> "Data Pegawai",
			'judul'		=> "Data Pegawai",
			'deskripsi'	=> "Data Pegawai"
		);

		$this->template->views('master/V_Pegawai', $data);
	}

	public function  tanggal_balik($tgl){
		$tanggal  =  substr($tgl,0,2);
		$bulan  = substr($tgl,3,2);
		$tahun  =  substr($tgl,6,4);
		return  $tahun.'-'.$bulan.'-'.$tanggal;
		}

	// FUNGSI MODULE VIEW
	public function cetak_rtb(){
		$data = array(
			'page' 		=> "Rekap Tunjangan Beras",
			'judul'		=> "Rekap Tunjangan Beras",
			'deskripsi'	=> "Rekap Tunjangan Beras"
		);
		$this->template->views('laporan/V_rtb', $data);
	}
	
	public function cetak_skp()
	{
		$data = array(
			'page' 		=> "Surat Keterangan Penghasilan",
			'judul'		=> "Surat Keterangan Penghasilan",
			'deskripsi'	=> "Surat Keterangan Penghasilan"
		);
		$this->template->views('laporan/V_skp', $data);
	}	
	
	public function cetak_form_b()
	{
		$data = array(
			'page' 		=> "Form_B Gaji Pegawai",
			'judul'		=> "Form_B Gaji Pegawai",
			'deskripsi'	=> "Form_B Gaji Pegawai"
		);
		$this->template->views('laporan/form_b_pegawai', $data);
	}

	public function cetak_iwp()
	{
		$data = array(
			'page' 		=> "Rekapitulasi IWP",
			'judul'		=> "Rekapitulasi IWP",
			'deskripsi'	=> "Rekapitulasi IWP"
		);
		$this->template->views('laporan/V_iwp', $data);
	}

	public function cetak_pph()
	{
		$data = array(
			'page' 		=> "Rekapitulasi PPH",
			'judul'		=> "Rekapitulasi PPH",
			'deskripsi'	=> "Rekapitulasi PPH"
		);
		$this->template->views('laporan/V_pph', $data);
	}
	
	public function cetak_taperum()
	{
		$data = array(
			'page' 		=> "Rekapitulasi Taperum",
			'judul'		=> "Rekapitulasi Taperum",
			'deskripsi'	=> "Rekapitulasi Taperum"
		);
		$this->template->views('laporan/V_taperum', $data);
	}
	
	public function cetak_taperum_keseluruhan()
	{
		$data = array(
			'page' 		=> "Rekapitulasi Taperum Keseluruhan",
			'judul'		=> "Rekapitulasi Taperum Keseluruhan",
			'deskripsi'	=> "Rekapitulasi Taperum Keseluruhan"
		);
		$this->template->views('laporan/V_taperum_keseluruhan', $data);
	}

	public function cetak_sewa_rumah()
	{
		$data = array(
			'page' 		=> "Rekapitulasi Sewa Rumah",
			'judul'		=> "Rekapitulasi Sewa Rumah",
			'deskripsi'	=> "Rekapitulasi Sewa Rumah"
		);
		$this->template->views('laporan/V_sewa_rumah', $data);
	}	

	public function cetak_askes()
	{
		$data = array(
			'page' 		=> "Rekapitulasi Akses",
			'judul'		=> "Rekapitulasi Akses",
			'deskripsi'	=> "Rekapitulasi Akses"
		);
		$this->template->views('laporan/V_askes', $data);
	}

	public function cetak_potongan_lainya()
	{
		$data = array(
			'page' 		=> "Rekapitulasi Potongan Lainnya",
			'judul'		=> "Rekapitulasi Potongan Lainnya",
			'deskripsi'	=> "Rekapitulasi Akses"
		);
		$this->template->views('laporan/V_potongan_lainnya', $data);
	}

	public function cetak_keseluruhan()
	{
		$data = array(
			'page' 		=> "Rekapitulasi Keseluruhan",
			'judul'		=> "Rekapitulasi Keseluruhan",
			'deskripsi'	=> "Rekapitulasi Keseluruhan"
		);
		$this->template->views('laporan/V_keseluruhan', $data);
	}	

	// FUNGSI GET
	public function get_nip()
	{
		$lccq 		= $this->input->post('q');
		$res 		= $this->M_Lap_Pegawai->get_nip($lccq);
		echo json_encode($res);
	}

	public function get_satker()
	{
		$lccq 		= $this->input->post('q');
		$res 		= $this->M_Lap_Pegawai->get_satker($lccq);
		echo json_encode($res);
	}

	public function getUnit()
	{
		$lccq 		= $this->input->post('q');
		$satkerja 	= $this->input->post('satkerja');
		$res 		= $this->M_Lap_Pegawai->getUnit($lccq,$satkerja);
		echo json_encode($res);
	}

	public function get_golongan()
	{
		$lccq 		= $this->input->post('q');
		$res 		= $this->M_Lap_Pegawai->get_golongan($lccq);
		echo json_encode($res);
	}

	public function get_skpd()
	{
		$lccq 		= $this->input->post('q');
		$res 		= $this->M_Lap_Pegawai->get_skpd($lccq);
		echo json_encode($res);
	}

}