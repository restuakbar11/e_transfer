<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_kirim extends CI_Controller {

	public function index()
	{	
		$data = array(
			'page'	 	=> 'KIRIM DATA',
			'judul'		=> 'KIRIM DATA',
			'deskripsi'	=> 'KIRIM DATA'
		);

		$this->template->views('utilitas/V_kirim', $data);
	}


	function proses_ebudget_simakda(){
		$dbsimakda=$this->load->database('simakda', TRUE);
		$this->load->model("utilitas/M_kirim");		
		$exec	= $this->M_kirim->kirim_budget_simakda();
		if($exec){
			echo '1';
		}else{
			echo '0';
		}
	}

	function proses_ebudget_simpatda(){
		$dbsimpatda=$this->load->database('simpatdasql', TRUE);
		$this->load->model("utilitas/M_kirim");		
		$exec	= $this->M_kirim->kirim_budget_simpatda_wisnu();
		if($exec){
			echo '1';
		}else{
			echo '0';
		}
	}

	function proses_ebudget_pend_simakda(){
		$dbsimakda=$this->load->database('simakda', TRUE);
		$this->load->model("utilitas/M_kirim");		
		$exec	= $this->M_kirim->kirim_budget_pend_simakda();
		if($exec){
			echo '1';
		}else{
			echo '0';
		}
	}

	function proses_ebudget_simakda_luncuran(){
		$dbsimakda=$this->load->database('simakda', TRUE);
		$this->load->model("utilitas/M_kirim");		
		$exec	= $this->M_kirim->kirim_budget_simakda_luncuran();
		if($exec){
			echo '1';
		}else{
			echo '0';
		}
	}
	
	function proses_ebudget_pemb_simakda(){
		$dbsimakda=$this->load->database('simakda', TRUE);
		$this->load->model("utilitas/M_kirim");		
		$exec	= $this->M_kirim->kirim_budget_pemb_simakda();
		if($exec){
			echo '1';
		}else{
			echo '0';
		}
	}

	function proses_ebudget_rincian_simakda(){
		$dbsimakda=$this->load->database('simakda', TRUE);
		$this->load->model("utilitas/M_kirim");		
		$exec	= $this->M_kirim->kirim_budget_rincian_simakda();
		if($exec){
			echo '1';
		}else{
			echo '0';
		}
	}

	function proses_ebudget_rincian_pend_simakda(){
		$dbsimakda=$this->load->database('simakda', TRUE);
		$this->load->model("utilitas/M_kirim");		
		$exec	= $this->M_kirim->kirim_budget_rincian_pend_simakda();
		if($exec){
			echo '1';
		}else{
			echo '0';
		}
	}
	
	
	
	
 

}

