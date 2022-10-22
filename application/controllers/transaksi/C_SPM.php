<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_SPM extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/M_SPM');
	}

	public function index()
	{
		$data = array(
			'page' 		=> "SPM GAJI",
			'judul'		=> "SPM GAJI",
			'deskripsi'	=> "SPM GAJI"
		);

		$this->template->views('transaksi/dokumen/V_SPM', $data);
	}


	function load_header(){
		$key = $this->input->post('key');
		$res = $this->M_SPM->loadHeader($key);
    	echo json_encode($res);
	}

	public function add()
	{
		$data = array(
			'page' 		=> "SPM GAJI",
			'judul'		=> "SPM GAJI",
			'deskripsi'	=> "SPM GAJI"
		);

		$this->template->views('transaksi/dokumen/V_Add_SPM', $data);
	}


	public function get_satker()
	{
		$lccq 		= $this->input->post('q');
		$res 		= $this->M_SPM->get_satker($lccq);
		echo json_encode($res);
	}

	public function golongan1()
	{
		$lccq 		= $this->input->post('q');
		$res 		= $this->M_SPM->golongan1($lccq);
		echo json_encode($res);
	}

	function load_detail(){

        $data = array(
        	'nomor'		=> $this->input->post('no'), 	// no_dokumen
        	'skpd' 		=> $this->input->post('kode')	// uskpd
    	);

    	$res = $this->M_SPM->load_detail($data);
    	echo json_encode($res);
    	//print_r($res);
    }

	//=========@Naga=====================================================

}