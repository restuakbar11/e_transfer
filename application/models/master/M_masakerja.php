<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_masakerja extends CI_Model {
	
	
	function simpan($post){
		$golongan = htmlspecialchars($post['golongan'], ENT_QUOTES);
		$tahun = htmlspecialchars($post['tahun'], ENT_QUOTES);
		$gapok = htmlspecialchars($post['gapok'], ENT_QUOTES);
		$gapok2 = htmlspecialchars($post['gapok2'], ENT_QUOTES);
		try {
			$sql=$this->db->query("insert into masakerja (golongan,tahun,gapok,gapok2) values ('$golongan','$tahun','$gapok','$gapok2')");
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
		$golongan = htmlspecialchars($post['golongan'], ENT_QUOTES);
		$tahun = htmlspecialchars($post['tahun'], ENT_QUOTES);
		$gapok = htmlspecialchars($post['gapok'], ENT_QUOTES);
		$gapok2 = htmlspecialchars($post['gapok2'], ENT_QUOTES);
		try{
			$sql = $this->db->query("update masakerja set tahun='$tahun',gapok='$gapok',gapok2='$gapok2' where golongan='$golongan'");
			return 1;
		}catch(Exception $e){
			return 0;
		}
		
	}
	
	function hapus($post){
		$golongan = htmlspecialchars($post['golongan'], ENT_QUOTES);
		$ex	  = explode("#", $golongan);
		try{
			if(count($ex) > 0){
				foreach($ex as $idx=>$val){
					$sql = $this->db->query("delete FROM masakerja where golongan='$val'");
				}
			
			return 1;
			}
		}catch(Exception $e){
			return 0;
		}
		
	}
	
	
}

?>