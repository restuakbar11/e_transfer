<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_fungsional extends CI_Model {
	
	
	function simpan($post){
		$kd_fung = htmlspecialchars($post['kd_fung'], ENT_QUOTES);
		$golongan = htmlspecialchars($post['golongan'], ENT_QUOTES);
		$jumlah = htmlspecialchars($post['jumlah'], ENT_QUOTES);
		$jumlah2 = htmlspecialchars($post['jumlah2'], ENT_QUOTES);
		$ket= htmlspecialchars($post['ket'], ENT_QUOTES);
		try {
			$sql=$this->db->query("insert into fungsional (kd_fung,golongan,jumlah,jumlah2,ket) values ('$kd_fung','$golongan','$jumlah','$jumlah2','$ket')");
			if($sql){
				return 1;
			}else{
				return 0;
			}
		}catch (Exception $e) {
			return 0;
		}
		
	}
	
	function ubah($post){
		$kd_fung = htmlspecialchars($post['kd_fung'], ENT_QUOTES);
		$golongan = htmlspecialchars($post['golongan'], ENT_QUOTES);
		$jumlah = htmlspecialchars($post['jumlah'], ENT_QUOTES);
		$jumlah2 = htmlspecialchars($post['jumlah2'], ENT_QUOTES);
		$ket= htmlspecialchars($post['ket'], ENT_QUOTES);
		try{
			$sql = $this->db->query("update fungsional set golongan='$golongan',jumlah='$jumlah',jumlah2='$jumlah2',ket='$ket' where kd_fung='$kd_fung'");
			return 1;
		}catch(Exception $e){
			return 0;
		}
		
	}
	
	function hapus($post){
		$kd_fung = htmlspecialchars($post['kd_fung'], ENT_QUOTES);
		$ex	  = explode("#", $kd_fung);
		try{
			if(count($ex) > 0){
				foreach($ex as $idx=>$val){
					$sql = $this->db->query("delete FROM fungsional where eselon='$val'");
				}
			
			return 1;
			}
		}catch(Exception $e){
			return 0;
		}
		
	}
	
	
}

?>