<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kirim extends CI_Model {

	public function loadHeader($key) {
		$result = array();
	    $row = array();
	    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
	    
	    if($key !=''){
			$cari  = "(upper(no_kirim) like upper('%$key%'))";	
			$limit = "";	
			$where = " where $cari $limit ";
			}else{
			$limit  = "ORDER BY no_kirim ASC LIMIT $rows OFFSET $offset";
			$where = "";
		}
	    
	    $sql = "SELECT count(*) as total from transaksi.trhkirim $where " ;
	    $query1 = $this->db->query($sql);
	    $total = $query1->row();
	    $result["total"] = $total->total; 
	    $query1->free_result();
	    
	    $sql = "SELECT * from transaksi.trhkirim $where $limit";
	    $query1 = $this->db->query($sql);       
	    $ii = 0;
	    foreach($query1->result_array() as $resulte)
	    { 
	     
	        $row[] = array(
	            'id' => $ii,        
	            'no_kirim' => $resulte['no_kirim'],
	            'tgl_kirim' => $resulte['tgl_kirim'],
	            'bulan' => $resulte['bulan'],
	            'total1' => number_format($resulte['total']),                                                      
	            'total' => $resulte['total']              
	            );
	        $ii++;
	    }
           
        $result["rows"] = $row; 
        return $result;
	}

	public function tanggal_ind($tgl){
		$tahun   =  substr($tgl,0,4);
		$bulan   = substr($tgl,5,2);
		$tanggal =  substr($tgl,8,2);
		return  $tanggal.'-'.$bulan.'-'.$tahun;
		}

	

	public function bulan($lccq){
		$sql	= "SELECT n_bulan,nama_bulan FROM public.bulan order by n_bulan ";
		$query  = $this->db->query($sql);
		
		return $query->result_array();
	}

	function kirim_budget_simakda(){

		$dbsimakda=$this->load->database('simakda', TRUE);
		$dbsimakda->query("delete from trdrka where left(kd_rek5,'1')='5' ");
		
		$sql = "SELECT DISTINCT kodeurusan,kodesuburusan,rtrim(kodeorganisasi) as kodeorganisasi,rtrim(kodebidang) as kodebidang,kodeprogram,kodekegiatan FROM kua.belanjarincian ORDER BY kodeurusan,kodesuburusan,rtrim(kodeorganisasi),rtrim(kodebidang),kodeprogram,kodekegiatan";
	    $query1 = $this->db->query($sql);       
	    $ii = 0;
	    foreach($query1->result_array() as $resulte) { 
	     
	            $id =  $ii;        
	           
	            $ckodeurusan 		= $resulte['kodeurusan'];
				$ckodesuburusan 	= $resulte['kodesuburusan'];
				$ckodeorganisasi 	= $resulte['kodeorganisasi'];
				$xkodebidang 		= $resulte['kodebidang'];
				$ckodeprogram 		= $resulte['kodeprogram'];
				$ckodekegiatan 		= $resulte['kodekegiatan'];

				$sql1a="select  distinct kb.kodeurusan,kb.kodesuburusan,kb.kodeorganisasi,rtrim(kb.kodebidang) as kodebidang,kb.kodeprogram,kb.kodekegiatan,mp.urai from kua.belanjarincian kb inner join master.program mp on (kb.kodebidang=mp.kodebidang or 'x.xx'=mp.kodebidang ) and kb.kodeprogram=mp.kodeprogram and kb.kodekegiatan = mp.kodekegiatan where kb.kodeurusan = '$ckodeurusan' and kb.kodesuburusan = '$ckodesuburusan ' and kb.kodeorganisasi='$ckodeorganisasi' and kb.kodebidang = '$xkodebidang' and kb.kodeprogram = '$ckodeprogram' and kb.kodekegiatan = '$ckodekegiatan '
					order by kb.kodeurusan,kb.kodesuburusan,kb.kodeorganisasi,rtrim(kb.kodebidang),kb.kodeprogram,kb.kodekegiatan" ;
				$query1a = $this->db->query($sql1a);
				foreach($query1a->result_array() as $resulte1a){
					 $nmkegiatan 		= $resulte1a['urai'];
				}


				$sql3 = "select * from rkpd.organisasi where kodeurusan='$ckodeurusan' and kodesuburusan = '$ckodesuburusan' and kodeorganisasi = '$ckodeorganisasi' ";
				$query3 = $this->db->query($sql3);
				foreach($query3->result_array() as $resulte3){
					 $cnmskpd 		= $resulte3['urai'];
				}

	         
	           if (strlen($ckodeurusan)== 1){
	           	$xkodeurusan = '0'.$ckodeurusan;
	           }else{
	           	$xkodeurusan = $ckodeurusan;
	           }

	           if (strlen($ckodeprogram)== 1){
	           	$xkodeprogram = '0'.$ckodeprogram;
	           }else{
	           	$xkodeprogram = $ckodeprogram;
	           }

	            if (strlen($ckodekegiatan)== 1){
	           	$xkodekegiatan = '0'.$ckodekegiatan;
	           }else{
	           	$xkodekegiatan = $ckodekegiatan;
	           }

	           if (strlen($ckodesuburusan)== 1){
	           	$xkodesuburusan = '0'.$ckodesuburusan;
	           }else{
	           	$xkodesuburusan = $ckodesuburusan;
	           }

	           if ($xkodeprogram== '00'){
				  $xkodeprogram 	= 'TL';
				  $xkodebidang 		= '';
				  $ykodebidang 		= $ckodeurusan.'.'.$xkodesuburusan;
				  $nmkegiatan 		= 'Belanja Pegawai';
			   }

			   $ckodebidang=$ckodeurusan.'.'.$xkodesuburusan;

			   $sql2 = "select  distinct  kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek,ks.kodesumberdana 
						from kua.belanjarincian kb inner join kua.belanjasub ks on kb.kodeurusan=ks.kodeurusan 
						and kb.kodesuburusan=ks.kodesuburusan and kb.kodeorganisasi=ks.kodeorganisasi 
 						and kb.kodebidang=ks.kodebidang and kb.kodeprogram=ks.kodeprogram and kb.kodekegiatan = ks.kodekegiatan and kb.id=ks.id 
						and kb.kodesub=ks.kodesub 
						Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And kb.kodeorganisasi='$ckodeorganisasi' 
						AND kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And kb.kodekegiatan='$ckodekegiatan'
						order by kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek,ks.kodesumberdana";
	    		$query2 = $this->db->query($sql2);       
	    	
	    		foreach($query2->result_array() as $resulte2) { 
					$ckodeakun 			= $resulte2['kodeakun'];
					$ckodekelompok 		= $resulte2['kodekelompok'];
					$ckodejenis 		= $resulte2['kodejenis'];
					$ckodeobjek 		= $resulte2['kodeobjek'];
					$ckoderincianobjek 	= $resulte2['koderincianobjek'];
					$nkd_sumberdana 	= $resulte2['kodesumberdana'];

					$sql2a = "select kodesumberdana,urai,singkat from rkpd.sumberdana where kodesumberdana = '$nkd_sumberdana' ";
					$query2a = $this->db->query($sql2a);
					foreach($query2a->result_array() as $resulte2a){
					 $cnmdana 		= $resulte2a['urai'];
					}



					if ($nkd_sumberdana == 1){
						$ckd_sumberdana = 'A';
					}else if ($nkd_sumberdana == 2){
						$ckd_sumberdana = 'B';
					}else if ($nkd_sumberdana == 3){
						$ckd_sumberdana = 'C';
					}else if ($nkd_sumberdana == 4){
						$ckd_sumberdana = 'D';
					}else if ($nkd_sumberdana == 5){
						$ckd_sumberdana = 'E';
					}else if ($nkd_sumberdana == 6){
						$ckd_sumberdana = 'F';
					}else if ($nkd_sumberdana == 7){
						$ckd_sumberdana = 'G';
					}else if ($nkd_sumberdana == 8){
						$ckd_sumberdana = 'H';
					}else if ($nkd_sumberdana == 9){
						$ckd_sumberdana = 'I';
					}else if ($nkd_sumberdana == 10){
						$ckd_sumberdana = 'J';
					}else if ($nkd_sumberdana == 11){
						$ckd_sumberdana = 'K';
					}else if ($nkd_sumberdana == 12){
						$ckd_sumberdana = 'L';
					}else if ($nkd_sumberdana == 13){
						$ckd_sumberdana = 'M';
					}else if ($nkd_sumberdana == 34){
						$ckd_sumberdana = 'N';
					}else if ($nkd_sumberdana == 35){
						$ckd_sumberdana = 'O';
					}else if ($nkd_sumberdana == 33){
						$ckd_sumberdana = 'P';
					}else if ($nkd_sumberdana == 31){
						$ckd_sumberdana = 'Q';
					}else if ($nkd_sumberdana == 32){
						$ckd_sumberdana = 'R';
					}else if ($nkd_sumberdana == 19){
						$ckd_sumberdana = 'S';
					}else if ($nkd_sumberdana == 20){
						$ckd_sumberdana = 'T';
					}else if ($nkd_sumberdana == 21){
						$ckd_sumberdana = 'U';
					}else if ($nkd_sumberdana == 22){
						$ckd_sumberdana = 'V';
					}else if ($nkd_sumberdana == 23){
						$ckd_sumberdana = 'W';
					}else if ($nkd_sumberdana == 24){
						$ckd_sumberdana = 'X';
					}else if ($nkd_sumberdana == 25){
						$ckd_sumberdana = 'Y';
					}else if ($nkd_sumberdana == 26){
						$ckd_sumberdana = 'Z';
					}else if ($nkd_sumberdana == 30){
						$ckd_sumberdana = 'A';
					}else{
						$ckd_sumberdana = '';
					}

					if (strlen($ckodeorganisasi) == 3){
						$xkodeorganisasi = '0'.$ckodeorganisasi ;
					}Else{
						$xkodeorganisasi = $ckodeorganisasi;
					}

					if (strlen($ckodeobjek) == 1){
						$xkodeobjek = '0'.$ckodeobjek ;
					}Else{
						$xkodeobjek = $ckodeobjek;
					}
					
					if (strlen($ckoderincianobjek) == 1){
						$xkoderincianobjek = '0'.$ckoderincianobjek;
					}Else{
						$xkoderincianobjek = $ckoderincianobjek;
					}
					$ckd_skpd 		=  $ckodeurusan.'.'.$xkodesuburusan.'.'.substr(rtrim($ckodeorganisasi),0,2).'.'.substr(rtrim($ckodeorganisasi),2,2) ;
					$ckd_skpd2 		=   $ckodeurusan.'.'.$ckodesuburusan.'.'.substr($ckodeorganisasi,1,2).'.'.substr($ckodeorganisasi,3,2) ; 

					if ($xkodeprogram == 'TL'){
						$ckd_urusan		= $ckodebidang ;
					}Else{
						$ckd_urusan		= $xkodebidang ; 
					}
		
					$ckd_program		= $ckd_urusan.'.'.$ckd_skpd.'.'.$xkodeprogram ;
					$ckd_kegiatan		= $ckd_program.'.'.$xkodekegiatan ;

					$ckd_rek5			= $ckodeakun.$ckodekelompok.$ckodejenis.$xkodeobjek.$xkoderincianobjek ;
					$cno_trdrka 		= $ckd_skpd.'.'.$ckd_kegiatan.'.'.$ckd_rek5 ;

					 $sql3 = "select   Sum(kb.pagu) As nilai,Sum(kb.paguubah) As nilaiubah from kua.belanjarincian kb inner join kua.belanjasub ks on kb.kodeurusan=ks.kodeurusan and kb.kodesuburusan=ks.kodesuburusan and kb.kodeorganisasi=ks.kodeorganisasi and 
						kb.kodebidang=ks.kodebidang and kb.kodeprogram=ks.kodeprogram and kb.kodekegiatan = ks.kodekegiatan and kb.id=ks.id 
						and kb.kodesub=ks.kodesub Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And 
						kb.kodeorganisasi='$ckodeorganisasi' And kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And 
						kb.kodekegiatan='$ckodekegiatan' And kb.kodeakun = '$ckodeakun' And kb.kodekelompok = '$ckodekelompok' And 
						kb.kodejenis='$ckodejenis' AND kb.kodeobjek = '$ckodeobjek' And kb.koderincianobjek = '$ckoderincianobjek' And 
						ks.kodesumberdana= '$nkd_sumberdana' ";
	    			$query3 = $this->db->query($sql3);       
	    	
	    			foreach($query3->result_array() as $resulte3) { 
	    				$cnilai				= $resulte3['nilai'];
						$cnilai_ubah		= $resulte3['nilaiubah'];
						$cusername			= '';
						$ctriw1				= 0;
						$ctriw2				= 0;
						$ctriw3				= 0;
						$ctriw4				= 0;
						$ctriw1_ubah		= 0;
						$ctriw2_ubah		= 0;
						$ctriw3_ubah		= 0;
						$ctriw4_ubah		= 0;
						$cnilai_thnmin1		= 0;
						$cnilai_thnplus		= 0;
						$cdasar_hukum		= '';
						$cdasar_hukum_ubah 	= '';
						$cjanuari			= 0;
						$cfebruari			= 0;
						$cmaret				= 0;
						$capril				= 0;
						$cmei				= 0;
						$cjuni				= 0;
						$cjuli				= 0;
						$cagust				= 0;
						$csept				= 0;
						$cokt				= 0;
						$cnov				= 0;
						$cdes				= 0;
						$cket				= '';
						$cminplus			= '';
						$cpotensi			= '';
						$cluncur			= '';
						$cket2				= '';

						if ($cnilai == 'NULL'){
							$cnilai = 0;
						}else{
							$cnilai = $cnilai ;
						}
						if ($cnilai_ubah == 'NULL'){
							$cnilai_ubah = 0;
						}else{
							$cnilai_ubah = $cnilai ;
						}


						$dbsimakda->query(" insert into trdrka(no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah,sumber,sumber_ubah) 
							values('$cno_trdrka','$ckd_skpd','$cnmskpd','$ckd_kegiatan','$nmkegiatan','$ckd_rek5','','$cnilai','$cnilai_ubah','$cnmdana ','$cnmdana') ");


	    			}

				
			
		
				}
	    					   

	         	 //ECHO($nmkegiatan);

	        	$ii++;
	    }
	    
	echo "<script>alert('PROSES KIRIM DATA E-BUDGETTING ANGGARAN KE SIMAKDA SELESAI')</script>";	

	}

	function kirim_budget_simakda_luncuran(){

		$dbsimakda=$this->load->database('simakda', TRUE);
		$dbsimakda->query("delete from trdrka where left(kd_rek5,'1')='5' AND sumber LIKE '%LANJUTAN%'");
		
		$sql = "SELECT DISTINCT kodeurusan,kodesuburusan,rtrim(kodeorganisasi) as kodeorganisasi,rtrim(kodebidang) as kodebidang,kodeprogram,kodekegiatan FROM kua.belanjarincian ORDER BY kodeurusan,kodesuburusan,rtrim(kodeorganisasi),rtrim(kodebidang),kodeprogram,kodekegiatan";
	    $query1 = $this->db->query($sql);       
	    $ii = 0;
	    foreach($query1->result_array() as $resulte) { 
	     
	            $id =  $ii;        
	           
	            $ckodeurusan 		= $resulte['kodeurusan'];
				$ckodesuburusan 	= $resulte['kodesuburusan'];
				$ckodeorganisasi 	= $resulte['kodeorganisasi'];
				$xkodebidang 		= $resulte['kodebidang'];
				$ckodeprogram 		= $resulte['kodeprogram'];
				$ckodekegiatan 		= $resulte['kodekegiatan'];

				$sql1a="select  distinct kb.kodeurusan,kb.kodesuburusan,kb.kodeorganisasi,rtrim(kb.kodebidang) as kodebidang,kb.kodeprogram,kb.kodekegiatan,mp.urai from kua.belanjarincian kb inner join master.program mp on (kb.kodebidang=mp.kodebidang or 'x.xx'=mp.kodebidang ) and kb.kodeprogram=mp.kodeprogram and kb.kodekegiatan = mp.kodekegiatan where kb.kodeurusan = '$ckodeurusan' and kb.kodesuburusan = '$ckodesuburusan ' and kb.kodeorganisasi='$ckodeorganisasi' and kb.kodebidang = '$xkodebidang' and kb.kodeprogram = '$ckodeprogram' and kb.kodekegiatan = '$ckodekegiatan '
					order by kb.kodeurusan,kb.kodesuburusan,kb.kodeorganisasi,rtrim(kb.kodebidang),kb.kodeprogram,kb.kodekegiatan" ;
				$query1a = $this->db->query($sql1a);
				foreach($query1a->result_array() as $resulte1a){
					 $nmkegiatan 		= $resulte1a['urai'];
				}


				$sql3 = "select * from rkpd.organisasi where kodeurusan='$ckodeurusan' and kodesuburusan = '$ckodesuburusan' and kodeorganisasi = '$ckodeorganisasi' ";
				$query3 = $this->db->query($sql3);
				foreach($query3->result_array() as $resulte3){
					 $cnmskpd 		= $resulte3['urai'];
				}

	         
	           if (strlen($ckodeurusan)== 1){
	           	$xkodeurusan = '0'.$ckodeurusan;
	           }else{
	           	$xkodeurusan = $ckodeurusan;
	           }

	           if (strlen($ckodeprogram)== 1){
	           	$xkodeprogram = '0'.$ckodeprogram;
	           }else{
	           	$xkodeprogram = $ckodeprogram;
	           }

	            if (strlen($ckodekegiatan)== 1){
	           	$xkodekegiatan = '0'.$ckodekegiatan;
	           }else{
	           	$xkodekegiatan = $ckodekegiatan;
	           }

	           if (strlen($ckodesuburusan)== 1){
	           	$xkodesuburusan = '0'.$ckodesuburusan;
	           }else{
	           	$xkodesuburusan = $ckodesuburusan;
	           }

	           if ($xkodeprogram== '00'){
				  $xkodeprogram 	= 'TL';
				  $xkodebidang 		= '';
				  $ykodebidang 		= $ckodeurusan.'.'.$xkodesuburusan;
				  $nmkegiatan 		= 'Belanja Pegawai';
			   }

			   $ckodebidang=$ckodeurusan.'.'.$xkodesuburusan;

			   $sql2 = "select  distinct  kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek,ks.kodesumberdana 
						from kua.belanjarincian kb inner join kua.belanjasub ks on kb.kodeurusan=ks.kodeurusan 
						and kb.kodesuburusan=ks.kodesuburusan and kb.kodeorganisasi=ks.kodeorganisasi 
 						and kb.kodebidang=ks.kodebidang and kb.kodeprogram=ks.kodeprogram and kb.kodekegiatan = ks.kodekegiatan and kb.id=ks.id 
						and kb.kodesub=ks.kodesub 
						Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And kb.kodeorganisasi='$ckodeorganisasi' 
						AND kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And kb.kodekegiatan='$ckodekegiatan'
						AND ks.kodesumberdana in ('5','6','7','10','12','14','16','18','20','33','35','34','48','49')
						order by kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek,ks.kodesumberdana";
	    		$query2 = $this->db->query($sql2);       
	    	
	    		foreach($query2->result_array() as $resulte2) { 
					$ckodeakun 			= $resulte2['kodeakun'];
					$ckodekelompok 		= $resulte2['kodekelompok'];
					$ckodejenis 		= $resulte2['kodejenis'];
					$ckodeobjek 		= $resulte2['kodeobjek'];
					$ckoderincianobjek 	= $resulte2['koderincianobjek'];
					$nkd_sumberdana 	= $resulte2['kodesumberdana'];

					$sql2a = "select kodesumberdana,urai,singkat from rkpd.sumberdana where kodesumberdana = '$nkd_sumberdana' ";
					$query2a = $this->db->query($sql2a);
					foreach($query2a->result_array() as $resulte2a){
					 $cnmdana 		= $resulte2a['urai'];
					}



					if ($nkd_sumberdana == 1){
						$ckd_sumberdana = 'A';
					}else if ($nkd_sumberdana == 2){
						$ckd_sumberdana = 'B';
					}else if ($nkd_sumberdana == 3){
						$ckd_sumberdana = 'C';
					}else if ($nkd_sumberdana == 4){
						$ckd_sumberdana = 'D';
					}else if ($nkd_sumberdana == 5){
						$ckd_sumberdana = 'E';
					}else if ($nkd_sumberdana == 6){
						$ckd_sumberdana = 'F';
					}else if ($nkd_sumberdana == 7){
						$ckd_sumberdana = 'G';
					}else if ($nkd_sumberdana == 8){
						$ckd_sumberdana = 'H';
					}else if ($nkd_sumberdana == 9){
						$ckd_sumberdana = 'I';
					}else if ($nkd_sumberdana == 10){
						$ckd_sumberdana = 'J';
					}else if ($nkd_sumberdana == 11){
						$ckd_sumberdana = 'K';
					}else if ($nkd_sumberdana == 12){
						$ckd_sumberdana = 'L';
					}else if ($nkd_sumberdana == 13){
						$ckd_sumberdana = 'M';
					}else if ($nkd_sumberdana == 34){
						$ckd_sumberdana = 'N';
					}else if ($nkd_sumberdana == 35){
						$ckd_sumberdana = 'O';
					}else if ($nkd_sumberdana == 33){
						$ckd_sumberdana = 'P';
					}else if ($nkd_sumberdana == 31){
						$ckd_sumberdana = 'Q';
					}else if ($nkd_sumberdana == 32){
						$ckd_sumberdana = 'R';
					}else if ($nkd_sumberdana == 19){
						$ckd_sumberdana = 'S';
					}else if ($nkd_sumberdana == 20){
						$ckd_sumberdana = 'T';
					}else if ($nkd_sumberdana == 21){
						$ckd_sumberdana = 'U';
					}else if ($nkd_sumberdana == 22){
						$ckd_sumberdana = 'V';
					}else if ($nkd_sumberdana == 23){
						$ckd_sumberdana = 'W';
					}else if ($nkd_sumberdana == 24){
						$ckd_sumberdana = 'X';
					}else if ($nkd_sumberdana == 25){
						$ckd_sumberdana = 'Y';
					}else if ($nkd_sumberdana == 26){
						$ckd_sumberdana = 'Z';
					}else if ($nkd_sumberdana == 30){
						$ckd_sumberdana = 'A';
					}else{
						$ckd_sumberdana = '';
					}

					if (strlen($ckodeorganisasi) == 3){
						$xkodeorganisasi = '0'.$ckodeorganisasi ;
					}Else{
						$xkodeorganisasi = $ckodeorganisasi;
					}

					if (strlen($ckodeobjek) == 1){
						$xkodeobjek = '0'.$ckodeobjek ;
					}Else{
						$xkodeobjek = $ckodeobjek;
					}
					
					if (strlen($ckoderincianobjek) == 1){
						$xkoderincianobjek = '0'.$ckoderincianobjek;
					}Else{
						$xkoderincianobjek = $ckoderincianobjek;
					}
					$ckd_skpd 		=  $ckodeurusan.'.'.$xkodesuburusan.'.'.substr(rtrim($ckodeorganisasi),0,2).'.'.substr(rtrim($ckodeorganisasi),2,2) ;
					$ckd_skpd2 		=   $ckodeurusan.'.'.$ckodesuburusan.'.'.substr($ckodeorganisasi,1,2).'.'.substr($ckodeorganisasi,3,2) ; 

					if ($xkodeprogram == 'TL'){
						$ckd_urusan		= $ckodebidang ;
					}Else{
						$ckd_urusan		= $xkodebidang ; 
					}
		
					$ckd_program		= $ckd_urusan.'.'.$ckd_skpd.'.'.$xkodeprogram ;
					$ckd_kegiatan		= $ckd_program.'.'.$xkodekegiatan ;

					$ckd_rek5			= $ckodeakun.$ckodekelompok.$ckodejenis.$xkodeobjek.$xkoderincianobjek ;
					$cno_trdrka 		= $ckd_skpd.'.'.$ckd_kegiatan.'.'.$ckd_rek5 ;

					 $sql3 = "select   Sum(kb.pagu) As nilai,Sum(kb.paguubah) As nilaiubah from kua.belanjarincian kb inner join kua.belanjasub ks on kb.kodeurusan=ks.kodeurusan and kb.kodesuburusan=ks.kodesuburusan and kb.kodeorganisasi=ks.kodeorganisasi and 
						kb.kodebidang=ks.kodebidang and kb.kodeprogram=ks.kodeprogram and kb.kodekegiatan = ks.kodekegiatan and kb.id=ks.id 
						and kb.kodesub=ks.kodesub Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And 
						kb.kodeorganisasi='$ckodeorganisasi' And kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And 
						kb.kodekegiatan='$ckodekegiatan' And kb.kodeakun = '$ckodeakun' And kb.kodekelompok = '$ckodekelompok' And 
						kb.kodejenis='$ckodejenis' AND kb.kodeobjek = '$ckodeobjek' And kb.koderincianobjek = '$ckoderincianobjek' And 
						ks.kodesumberdana= '$nkd_sumberdana' ";
	    			$query3 = $this->db->query($sql3);       
	    	
	    			foreach($query3->result_array() as $resulte3) { 
	    				$cnilai				= $resulte3['nilai'];
						$cnilai_ubah		= $resulte3['nilaiubah'];
						$cusername			= '';
						$ctriw1				= 0;
						$ctriw2				= 0;
						$ctriw3				= 0;
						$ctriw4				= 0;
						$ctriw1_ubah		= 0;
						$ctriw2_ubah		= 0;
						$ctriw3_ubah		= 0;
						$ctriw4_ubah		= 0;
						$cnilai_thnmin1		= 0;
						$cnilai_thnplus		= 0;
						$cdasar_hukum		= '';
						$cdasar_hukum_ubah 	= '';
						$cjanuari			= 0;
						$cfebruari			= 0;
						$cmaret				= 0;
						$capril				= 0;
						$cmei				= 0;
						$cjuni				= 0;
						$cjuli				= 0;
						$cagust				= 0;
						$csept				= 0;
						$cokt				= 0;
						$cnov				= 0;
						$cdes				= 0;
						$cket				= '';
						$cminplus			= '';
						$cpotensi			= '';
						$cluncur			= '';
						$cket2				= '';

						if ($cnilai == 'NULL'){
							$cnilai = 0;
						}else{
							$cnilai = $cnilai ;
						}
						if ($cnilai_ubah == 'NULL'){
							$cnilai_ubah = 0;
						}else{
							$cnilai_ubah = $cnilai ;
						}


						$dbsimakda->query(" insert into trdrka(no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah,sumber,sumber_ubah) 
							values('$cno_trdrka','$ckd_skpd','$cnmskpd','$ckd_kegiatan','$nmkegiatan','$ckd_rek5','','$cnilai','$cnilai_ubah','$cnmdana ','$cnmdana') ");


	    			}

				
			
		
				}
	    					   

	         	 //ECHO($nmkegiatan);

	        	$ii++;
	    }
	    
	echo "<script>alert('PROSES KIRIM DATA E-BUDGETTING ANGGARAN KE SIMAKDA SELESAI')</script>";	

	}

	function kirim_budget_pend_simakda(){

		$dbsimakda=$this->load->database('simakda', TRUE);
		$dbsimakda->query("delete from trdrka WHERE LEFT(kd_rek5,'1')='4'");
		
		$sql = "SELECT DISTINCT kodeurusan,kodesuburusan,rtrim(kodeorganisasi) as kodeorganisasi,rtrim(kodebidang) as kodebidang,
		kodeprogram,kodekegiatan FROM kua.pendapatanrincian 
		ORDER BY kodeurusan,kodesuburusan,rtrim(kodeorganisasi),rtrim(kodebidang),
		kodeprogram,kodekegiatan";
	    $query1 = $this->db->query($sql);       
	    $ii = 0;
	    foreach($query1->result_array() as $resulte) { 
	     
	            $id =  $ii;        
	           
	            $ckodeurusan 		= $resulte['kodeurusan'];
				$ckodesuburusan 	= $resulte['kodesuburusan'];
				$ckodeorganisasi 	= $resulte['kodeorganisasi'];
				$xkodebidang 		= $resulte['kodebidang'];
				$ckodeprogram 		= $resulte['kodeprogram'];
				$ckodekegiatan 		= "1";

				$nmkegiatan 		= 'Pendapatan Asli Daerah';

				$sql3 = "select * from rkpd.organisasi where kodeurusan='$ckodeurusan' and kodesuburusan = '$ckodesuburusan' and 
				kodeorganisasi = '$ckodeorganisasi' ";
				$query3 = $this->db->query($sql3);
				foreach($query3->result_array() as $resulte3){
					 $cnmskpd 		= $resulte3['urai'];
				}

	         
	           if (strlen($ckodeurusan)== 1){
	           	$xkodeurusan = '0'.$ckodeurusan;
	           }else{
	           	$xkodeurusan = $ckodeurusan;
	           }

	           if (strlen($ckodeprogram)== 1){
	           	$xkodeprogram = '0'.$ckodeprogram;
	           }else{
	           	$xkodeprogram = $ckodeprogram;
	           }

	            if (strlen($ckodekegiatan)== 1){
	           	$xkodekegiatan = '0'.$ckodekegiatan;
	           }else{
	           	$xkodekegiatan = $ckodekegiatan;
	           }

	           if (strlen($ckodesuburusan)== 1){
	           	$xkodesuburusan = '0'.$ckodesuburusan;
	           }else{
	           	$xkodesuburusan = $ckodesuburusan;
	           }


			   $ckodebidang=$ckodeurusan.'.'.$xkodesuburusan;

			    $sql2 = "select  distinct  kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek
						from kua.pendapatanrincian kb 
						Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And kb.kodeorganisasi='$ckodeorganisasi' 
						order by kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek";
	    	    $query2 = $this->db->query($sql2); 
	    		      
	    	
	    		foreach($query2->result_array() as $resulte2) { 
					$ckodeakun 			= $resulte2['kodeakun'];
					$ckodekelompok 		= $resulte2['kodekelompok'];
					$ckodejenis 		= $resulte2['kodejenis'];
					$ckodeobjek 		= $resulte2['kodeobjek'];
					$ckoderincianobjek 	= $resulte2['koderincianobjek'];
					

					

					if (strlen($ckodeorganisasi) == 3){
						$xkodeorganisasi = '0'.$ckodeorganisasi ;
					}Else{
						$xkodeorganisasi = $ckodeorganisasi;
					}

					if (strlen($ckodeobjek) == 1){
						$xkodeobjek = '0'.$ckodeobjek ;
					}Else{
						$xkodeobjek = $ckodeobjek;
					}
					
					if (strlen($ckoderincianobjek) == 1){
						$xkoderincianobjek = '0'.$ckoderincianobjek;
					}Else{
						$xkoderincianobjek = $ckoderincianobjek;
					}
					$ckd_skpd 		=  $ckodeurusan.'.'.$xkodesuburusan.'.'.substr(rtrim($ckodeorganisasi),0,2).'.'.substr(rtrim($ckodeorganisasi),2,2) ;
					$ckd_skpd2 		=   $ckodeurusan.'.'.$ckodesuburusan.'.'.substr($ckodeorganisasi,1,2).'.'.substr($ckodeorganisasi,3,2) ; 

					if ($xkodeprogram == 'TL'){
						$ckd_urusan		= $ckodebidang ;
					}Else{
						$ckd_urusan		= $xkodebidang ; 
					}
		
					$ckd_program		= $ckd_skpd.'.'.$xkodeprogram ;
					$ckd_kegiatan		= $ckodebidang.'.'.$ckd_program.'.'.$xkodekegiatan ;

					$ckd_rek5			= $ckodeakun.$ckodekelompok.$ckodejenis.$xkodeobjek.$xkoderincianobjek ;
					$cno_trdrka 		= $ckd_skpd.'.'.$ckd_kegiatan.'.'.$ckd_rek5 ;

					 $sql3 = "select sum(pagu) as nilai, sum(paguubah) as nilaiubah from kua.pendapatanrincian kb 
						Where kb.kodeurusan=$ckodeurusan And kb.kodesuburusan=$ckodesuburusan And 
						kb.kodeorganisasi='$ckodeorganisasi' and kb.kodeakun=$ckodeakun and kb.kodekelompok=$ckodekelompok and 
						kb.kodejenis=$ckodejenis and kb.kodeobjek=$ckodeobjek and kb.koderincianobjek=$ckoderincianobjek";
						
	    			$query3 = $this->db->query($sql3);       
	    	
	    			foreach($query3->result_array() as $resulte3) { 
	    				$cnilai				= $resulte3['nilai'];
						$cnilai_ubah		= $resulte3['nilaiubah'];
						$cusername			= '';
						$ctriw1				= 0;
						$ctriw2				= 0;
						$ctriw3				= 0;
						$ctriw4				= 0;
						$ctriw1_ubah		= 0;
						$ctriw2_ubah		= 0;
						$ctriw3_ubah		= 0;
						$ctriw4_ubah		= 0;
						$cnilai_thnmin1		= 0;
						$cnilai_thnplus		= 0;
						$cdasar_hukum		= '';
						$cdasar_hukum_ubah 	= '';
						$cjanuari			= 0;
						$cfebruari			= 0;
						$cmaret				= 0;
						$capril				= 0;
						$cmei				= 0;
						$cjuni				= 0;
						$cjuli				= 0;
						$cagust				= 0;
						$csept				= 0;
						$cokt				= 0;
						$cnov				= 0;
						$cdes				= 0;
						$cket				= '';
						$cminplus			= '';
						$cpotensi			= '';
						$cluncur			= '';
						$cket2				= '';

						if ($cnilai == 'NULL'){
							$cnilai = 0;
						}else{
							$cnilai = $cnilai ;
						}
						if ($cnilai_ubah == 'NULL'){
							$cnilai_ubah = 0;
						}else{
							$cnilai_ubah = $cnilai ;
						}


						$dbsimakda->query(" insert into trdrka(no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah) 
							values('$cno_trdrka','$ckd_skpd','$cnmskpd','$ckd_kegiatan','$nmkegiatan','$ckd_rek5','','$cnilai','$cnilai_ubah') ");


	    			}

				
			
		
				}
	    					   

	         	 //ECHO($nmkegiatan);

	        	$ii++;
	    }
	    
	 echo "<script>alert('PROSES KIRIM DATA E-BUDGETTING PENDAPATAN KE SIMAKDA SELESAI')</script>";

	}

	function kirim_budget_pemb_simakda(){

		$dbsimakda=$this->load->database('simakda', TRUE);
		$dbsimakda->query("delete from trdrka WHERE LEFT(kd_rek5,'1')='6'");
		
		$sql = "SELECT DISTINCT kodeurusan,kodesuburusan,rtrim(kodeorganisasi) as kodeorganisasi,rtrim(kodebidang) as kodebidang,
		kodeprogram,kodekegiatan FROM kua.pembiayaanrincian 
		ORDER BY kodeurusan,kodesuburusan,rtrim(kodeorganisasi),rtrim(kodebidang),
		kodeprogram,kodekegiatan";
	    $query1 = $this->db->query($sql);       
	    $ii = 0;
	    foreach($query1->result_array() as $resulte) { 
	     
	            $id =  $ii;        
	           
	            $ckodeurusan 		= $resulte['kodeurusan'];
				$ckodesuburusan 	= $resulte['kodesuburusan'];
				$ckodeorganisasi 	= $resulte['kodeorganisasi'];
				$xkodebidang 		= $resulte['kodebidang'];
				$ckodeprogram 		= $resulte['kodeprogram'];
				$ckodekegiatan 		= "1";

				$nmkegiatan 		= 'Pembiayaan Asli Daerah';

				$sql3 = "select * from rkpd.organisasi where kodeurusan='$ckodeurusan' and kodesuburusan = '$ckodesuburusan' and 
				kodeorganisasi = '$ckodeorganisasi' ";
				$query3 = $this->db->query($sql3);
				foreach($query3->result_array() as $resulte3){
					 $cnmskpd 		= $resulte3['urai'];
				}

	         
	           if (strlen($ckodeurusan)== 1){
	           	$xkodeurusan = '0'.$ckodeurusan;
	           }else{
	           	$xkodeurusan = $ckodeurusan;
	           }

	           if (strlen($ckodeprogram)== 1){
	           	$xkodeprogram = '0'.$ckodeprogram;
	           }else{
	           	$xkodeprogram = $ckodeprogram;
	           }

	            if (strlen($ckodekegiatan)== 1){
	           	$xkodekegiatan = '0'.$ckodekegiatan;
	           }else{
	           	$xkodekegiatan = $ckodekegiatan;
	           }

	           if (strlen($ckodesuburusan)== 1){
	           	$xkodesuburusan = '0'.$ckodesuburusan;
	           }else{
	           	$xkodesuburusan = $ckodesuburusan;
	           }


			   $ckodebidang=$ckodeurusan.'.'.$xkodesuburusan;

			    $sql2 = "select  distinct  kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek
						from kua.pembiayaanrincian kb 
						Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And kb.kodeorganisasi='$ckodeorganisasi' 
						order by kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek";
	    	    $query2 = $this->db->query($sql2); 
	    		      
	    	
	    		foreach($query2->result_array() as $resulte2) { 
					$ckodeakun 			= $resulte2['kodeakun'];
					$ckodekelompok 		= $resulte2['kodekelompok'];
					$ckodejenis 		= $resulte2['kodejenis'];
					$ckodeobjek 		= $resulte2['kodeobjek'];
					$ckoderincianobjek 	= $resulte2['koderincianobjek'];
					

					

					if (strlen($ckodeorganisasi) == 3){
						$xkodeorganisasi = '0'.$ckodeorganisasi ;
					}Else{
						$xkodeorganisasi = $ckodeorganisasi;
					}

					if (strlen($ckodeobjek) == 1){
						$xkodeobjek = '0'.$ckodeobjek ;
					}Else{
						$xkodeobjek = $ckodeobjek;
					}
					
					if (strlen($ckoderincianobjek) == 1){
						$xkoderincianobjek = '0'.$ckoderincianobjek;
					}Else{
						$xkoderincianobjek = $ckoderincianobjek;
					}
					$ckd_skpd 		=  $ckodeurusan.'.'.$xkodesuburusan.'.'.substr(rtrim($ckodeorganisasi),0,2).'.'.substr(rtrim($ckodeorganisasi),2,2) ;
					$ckd_skpd2 		=   $ckodeurusan.'.'.$ckodesuburusan.'.'.substr($ckodeorganisasi,1,2).'.'.substr($ckodeorganisasi,3,2) ; 

					if ($xkodeprogram == 'TL'){
						$ckd_urusan		= $ckodebidang ;
					}Else{
						$ckd_urusan		= $xkodebidang ; 
					}
		
					$ckd_program		= $ckd_skpd.'.'.$xkodeprogram ;
					$ckd_kegiatan		= $ckodebidang.'.'.$ckd_program.'.'.$xkodekegiatan ;

					$ckd_rek5			= $ckodeakun.$ckodekelompok.$ckodejenis.$xkodeobjek.$xkoderincianobjek ;
					$cno_trdrka 		= $ckd_skpd.'.'.$ckd_kegiatan.'.'.$ckd_rek5 ;

					 $sql3 = "select sum(pagu) as nilai, sum(paguubah) as nilaiubah from kua.pendapatanrincian kb 
						Where kb.kodeurusan=$ckodeurusan And kb.kodesuburusan=$ckodesuburusan And 
						kb.kodeorganisasi='$ckodeorganisasi' and kb.kodeakun=$ckodeakun and kb.kodekelompok=$ckodekelompok and 
						kb.kodejenis=$ckodejenis and kb.kodeobjek=$ckodeobjek and kb.koderincianobjek=$ckoderincianobjek";
						
	    			$query3 = $this->db->query($sql3);       
	    	
	    			foreach($query3->result_array() as $resulte3) { 
	    				$cnilai				= $resulte3['nilai'];
						$cnilai_ubah		= $resulte3['nilaiubah'];
						$cusername			= '';
						$ctriw1				= 0;
						$ctriw2				= 0;
						$ctriw3				= 0;
						$ctriw4				= 0;
						$ctriw1_ubah		= 0;
						$ctriw2_ubah		= 0;
						$ctriw3_ubah		= 0;
						$ctriw4_ubah		= 0;
						$cnilai_thnmin1		= 0;
						$cnilai_thnplus		= 0;
						$cdasar_hukum		= '';
						$cdasar_hukum_ubah 	= '';
						$cjanuari			= 0;
						$cfebruari			= 0;
						$cmaret				= 0;
						$capril				= 0;
						$cmei				= 0;
						$cjuni				= 0;
						$cjuli				= 0;
						$cagust				= 0;
						$csept				= 0;
						$cokt				= 0;
						$cnov				= 0;
						$cdes				= 0;
						$cket				= '';
						$cminplus			= '';
						$cpotensi			= '';
						$cluncur			= '';
						$cket2				= '';

						if ($cnilai == 'NULL'){
							$cnilai = 0;
						}else{
							$cnilai = $cnilai ;
						}
						if ($cnilai_ubah == 'NULL'){
							$cnilai_ubah = 0;
						}else{
							$cnilai_ubah = $cnilai ;
						}


						$dbsimakda->query(" insert into trdrka(no_trdrka,kd_skpd,nm_skpd,kd_kegiatan,nm_kegiatan,kd_rek5,nm_rek5,nilai,nilai_ubah) 
							values('$cno_trdrka','$ckd_skpd','$cnmskpd','$ckd_kegiatan','$nmkegiatan','$ckd_rek5','','$cnilai','$cnilai_ubah') ");


	    			}

				
			
		
				}
	    					   

	         	 //ECHO($nmkegiatan);

	        	$ii++;
	    }
	    
	 echo "<script>alert('PROSES KIRIM DATA E-BUDGETTING PEMBIAYAAN KE SIMAKDA SELESAI')</script>";

	}

	function kirim_budget_simpatda(){

		$dbsimpatda=$this->load->database('simpatdasql', TRUE);
		$dbsimpatda->query("delete from trdrka ");
		$dbsimpatda->query("delete from mprog ");
		$dbsimpatda->query("delete from mgiat ");

		$sql = "SELECT DISTINCT kodeurusan,kodesuburusan,rtrim(kodeorganisasi) as kodeorganisasi,rtrim(kodebidang) as kodebidang,kodeprogram,kodekegiatan FROM kua.pendapatanrincian where kodeorganisasi <> '0501' ORDER BY kodeurusan,kodesuburusan,rtrim(kodeorganisasi),rtrim(kodebidang),kodeprogram,kodekegiatan";
	    $query1 = $this->db->query($sql);       
	    $ii = 0;
	    foreach($query1->result_array() as $resulte) { 
	     
	            $id =  $ii;        
	           
	            $ckodeurusan 		= $resulte['kodeurusan'];
				$ckodesuburusan 	= $resulte['kodesuburusan'];
				$ckodeorganisasi 	= $resulte['kodeorganisasi'];
				$xkodebidang 		= $resulte['kodebidang'];
				$ckodeprogram 		= $resulte['kodeprogram'];
				$ckodekegiatan 		= $resulte['kodekegiatan'];

				if (strlen($ckodeurusan)== 1){
	           	$xkodeurusan = '0'.$ckodeurusan;
	           }else{
	           	$xkodeurusan = $ckodeurusan;
	           }

	           if (strlen($ckodeprogram)== 1){
	           	$xkodeprogram = '0'.$ckodeprogram;
	           }else{
	           	$xkodeprogram = $ckodeprogram;
	           }

	            if (strlen($ckodekegiatan)== 1){
	           	$xkodekegiatan = '0'.$ckodekegiatan;
	           }else{
	           	$xkodekegiatan = $ckodekegiatan;
	           }

	           if (strlen($ckodesuburusan)== 1){
	           	$xkodesuburusan = '0'.$ckodesuburusan;
	           }else{
	           	$xkodesuburusan = $ckodesuburusan;
	           }

	          
 			   $ckd_skpd 		=  $ckodeurusan.'.'.$xkodesuburusan.'.'.substr(rtrim($ckodeorganisasi),0,2) ;
			   $ckodebidang		= $ckodeurusan.'.'.$xkodesuburusan;
			   $ckd_program		= $ckd_skpd.'.'.$xkodeprogram ;
			   $ckd_kegiatan	= $ckd_program.'.'.$xkodekegiatan ;
			   $nmprogram 		= 'PENDAPATAN';
			   $lpermen 		= '1';
			  
			   $jns_keg  		= '4';

			   	$dbsimpatda->query(" insert into mprog( kd_program,nm_program,kd_skpd,lpermen) 
							values('$ckd_program','$nmprogram','$ckd_skpd','$lpermen') ");

			   		$dbsimpatda->query(" insert into mgiat( kd_kegiatan,kd_program,nm_kegiatan,jns_kegiatan,lpermen) 
							values('$ckd_kegiatan','$ckd_program','$nmprogram','$jns_keg','$lpermen') ");


		

				 $sql2 = "select  distinct  kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek 
						from kua.pendapatanrincian kb 
						Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And kb.kodeorganisasi='$ckodeorganisasi' 
						AND kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And kb.kodekegiatan='$ckodekegiatan'
						order by kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek";
	    		$query2 = $this->db->query($sql2);       
	    	
	    		foreach($query2->result_array() as $resulte2) { 
					$ckodeakun 			= $resulte2['kodeakun'];
					$ckodekelompok 		= $resulte2['kodekelompok'];
					$ckodejenis 		= $resulte2['kodejenis'];
					$ckodeobjek 		= $resulte2['kodeobjek'];
					$ckoderincianobjek 	= $resulte2['koderincianobjek'];


	         		if (strlen($ckodeorganisasi) == 3){
						$xkodeorganisasi = '0'.$ckodeorganisasi ;
					}Else{
						$xkodeorganisasi = $ckodeorganisasi;
					}

					if (strlen($ckodeobjek) == 1){
						$xkodeobjek = '0'.$ckodeobjek ;
					}Else{
						$xkodeobjek = $ckodeobjek;
					}
					
					if (strlen($ckoderincianobjek) == 1){
						$xkoderincianobjek = '0'.$ckoderincianobjek;
					}Else{
						$xkoderincianobjek = $ckoderincianobjek;
					}
					$ckd_skpd 		=  $ckodeurusan.'.'.$xkodesuburusan.'.'.substr(rtrim($ckodeorganisasi),0,2) ;
					$ckd_skpd2 		=   $ckodeurusan.'.'.$ckodesuburusan.'.'.substr($ckodeorganisasi,1,2) ; 

					
					$ckd_urusan		= $ckodebidang ; 
					

		
					$ckd_program		= $ckd_skpd.'.'.$xkodeprogram ;
					$ckd_kegiatan		= $ckd_program.'.'.$xkodekegiatan ;

					$ckd_rek5			= $ckodeakun.$ckodekelompok.$ckodejenis.$xkodeobjek.$xkoderincianobjek ;
					$cno_trdrka 		= $ckd_skpd.'.'.$ckd_kegiatan.'.'.$ckd_rek5 ;

					 $sql3 = "select   Sum(kb.pagu) As nilai,Sum(kb.paguubah) As nilaiubah from kua.pendapatanrincian kb inner join kua.belanjasub ks on kb.kodeurusan=ks.kodeurusan and kb.kodesuburusan=ks.kodesuburusan and kb.kodeorganisasi=ks.kodeorganisasi and 
						kb.kodebidang=ks.kodebidang and kb.kodeprogram=ks.kodeprogram and kb.kodekegiatan = ks.kodekegiatan  
						and kb.kodesub=ks.kodesub Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And kb.kodeorganisasi='$ckodeorganisasi' And kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And kb.kodekegiatan='$ckodekegiatan' And kb.kodeakun = '$ckodeakun' And kb.kodekelompok = '$ckodekelompok' And kb.kodejenis='$ckodejenis' AND kb.kodeobjek = '$ckodeobjek' And kb.koderincianobjek = '$ckoderincianobjek'  ";
	    			$query3 = $this->db->query($sql3);       
	    	
	    			foreach($query3->result_array() as $resulte3) { 
	    				$cnilai				= $resulte3['nilai'];
						$cnilai_ubah		= $resulte3['nilaiubah'];
						$cusername			= '';
						$ctriw1				= 0;
						$ctriw2				= 0;
						$ctriw3				= 0;
						$ctriw4				= 0;
						$ctriw1_ubah		= 0;
						$ctriw2_ubah		= 0;
						$ctriw3_ubah		= 0;
						$ctriw4_ubah		= 0;
						$cnilai_thnmin1		= 0;
						$cnilai_thnplus		= 0;
						$cdasar_hukum		= '';
						$cdasar_hukum_ubah 	= '';
						$cjanuari			= 0;
						$cfebruari			= 0;
						$cmaret				= 0;
						$capril				= 0;
						$cmei				= 0;
						$cjuni				= 0;
						$cjuli				= 0;
						$cagust				= 0;
						$csept				= 0;
						$cokt				= 0;
						$cnov				= 0;
						$cdes				= 0;
						$cket				= '';
						$cminplus			= '';
						$cpotensi			= '';
						$cluncur			= '';
						$cket2				= '';

						if ($cnilai == 'NULL'){
							$cnilai = 0;
						}else{
							$cnilai = $cnilai ;
						}
						if ($cnilai_ubah == 'NULL'){
							$cnilai_ubah = 0;
						}else{
							$cnilai_ubah = $cnilai ;
						}


						$dbsimpatda->query(" insert into trdrka( NO_TRDRKA, KD_SKPD, kd_program, KD_KEGIATAN, KD_REK5, NILAI,NILAI_UBAH) 
							values('$cno_trdrka','$ckd_skpd','$ckd_program','$ckd_kegiatan','$ckd_rek5','$cnilai','$cnilai_ubah') ");


	    			}

				
			
		
				}
	    					   

	         	

	        	$ii++;
	    }
	    
	 echo 'PROSES KIRIM DATA E-BUDGETING KE SIMPATDA SELESAI...!! ';	
		
	}

	function kirim_budget_rincian_simakda(){

		$dbsimakda=$this->load->database('simakda', TRUE);
		$dbsimakda->query("delete from trdpo where left(kd_rek5,'1')='5' ");
		
		$sql = "SELECT DISTINCT kodeurusan,kodesuburusan,rtrim(kodeorganisasi) as kodeorganisasi,rtrim(kodebidang) as kodebidang,kodeprogram,kodekegiatan FROM kua.belanjarincian ORDER BY kodeurusan,kodesuburusan,rtrim(kodeorganisasi),rtrim(kodebidang),kodeprogram,kodekegiatan";
	    $query1 = $this->db->query($sql);       
	    $ii = 0;
	    foreach($query1->result_array() as $resulte) { 
	     
	            $id =  $ii;        
	           
	            $ckodeurusan 		= $resulte['kodeurusan'];
				$ckodesuburusan 	= $resulte['kodesuburusan'];
				$ckodeorganisasi 	= $resulte['kodeorganisasi'];
				$xkodebidang 		= $resulte['kodebidang'];
				$ckodeprogram 		= $resulte['kodeprogram'];
				$ckodekegiatan 		= $resulte['kodekegiatan'];

				
         
	           if (strlen($ckodeurusan)== 1){
	           	$xkodeurusan = '0'.$ckodeurusan;
	           }else{
	           	$xkodeurusan = $ckodeurusan;
	           }

	           if (strlen($ckodeprogram)== 1){
	           	$xkodeprogram = '0'.$ckodeprogram;
	           }else{
	           	$xkodeprogram = $ckodeprogram;
	           }

	            if (strlen($ckodekegiatan)== 1){
	           	$xkodekegiatan = '0'.$ckodekegiatan;
	           }else{
	           	$xkodekegiatan = $ckodekegiatan;
	           }

	           if (strlen($ckodesuburusan)== 1){
	           	$xkodesuburusan = '0'.$ckodesuburusan;
	           }else{
	           	$xkodesuburusan = $ckodesuburusan;
	           }

	           if ($xkodeprogram== '00'){
				  $xkodeprogram 	= 'TL';
				  $xkodebidang 		= '';
				  $ykodebidang 		= $ckodeurusan.'.'.$xkodesuburusan;
				  $nmkegiatan 		= 'Belanja Pegawai';
			   }

			   $ckodebidang=$ckodeurusan.'.'.$xkodesuburusan;

			   $sql2 = "select  distinct  kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek 
						from kua.belanjarincian kb inner join kua.belanjasub ks on kb.kodeurusan=ks.kodeurusan 
						and kb.kodesuburusan=ks.kodesuburusan and kb.kodeorganisasi=ks.kodeorganisasi 
 						and kb.kodebidang=ks.kodebidang and kb.kodeprogram=ks.kodeprogram and kb.kodekegiatan = ks.kodekegiatan and kb.id=ks.id 
						and kb.kodesub=ks.kodesub 
						Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And kb.kodeorganisasi='$ckodeorganisasi' 
						AND kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And kb.kodekegiatan='$ckodekegiatan'
						order by kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek";
	    		$query2 = $this->db->query($sql2);       
	    	
	    		foreach($query2->result_array() as $resulte2) { 
					$ckodeakun 			= $resulte2['kodeakun'];
					$ckodekelompok 		= $resulte2['kodekelompok'];
					$ckodejenis 		= $resulte2['kodejenis'];
					$ckodeobjek 		= $resulte2['kodeobjek'];
					$ckoderincianobjek 	= $resulte2['koderincianobjek'];



					if (strlen($ckodeorganisasi) == 3){
						$xkodeorganisasi = '0'.$ckodeorganisasi ;
					}Else{
						$xkodeorganisasi = $ckodeorganisasi;
					}

					if (strlen($ckodeobjek) == 1){
						$xkodeobjek = '0'.$ckodeobjek ;
					}Else{
						$xkodeobjek = $ckodeobjek;
					}
					
					if (strlen($ckoderincianobjek) == 1){
						$xkoderincianobjek = '0'.$ckoderincianobjek;
					}Else{
						$xkoderincianobjek = $ckoderincianobjek;
					}
					$ckd_skpd 		=  $ckodeurusan.'.'.$xkodesuburusan.'.'.substr(rtrim($ckodeorganisasi),0,2).'.'.substr(rtrim($ckodeorganisasi),2,2) ;
					$ckd_skpd2 		=   $ckodeurusan.'.'.$ckodesuburusan.'.'.substr($ckodeorganisasi,1,2).'.'.substr($ckodeorganisasi,3,2) ; 

					if ($xkodeprogram == 'TL'){
						$ckd_urusan		= $ckodebidang ;
					}Else{
						$ckd_urusan		= $xkodebidang ; 
					}
		
					$ckd_program		= $ckd_urusan.'.'.$ckd_skpd.'.'.$xkodeprogram ;
					$ckd_kegiatan		= $ckd_program.'.'.$xkodekegiatan ;

					$ckd_rek5			= $ckodeakun.$ckodekelompok.$ckodejenis.$xkodeobjek.$xkoderincianobjek ;
					$cno_trdrka 		= $ckd_skpd.'.'.$ckd_kegiatan.'.'.$ckd_rek5 ;

					 $sql3 = "select kb.urai as uraian,kb.volume as volume1,kb.volume2,kb.volume3,kb.jmlvolume as tvolume,
					 	kb.satuan as satuan1,kb.satuan2,kb.satuan3,kb.jmlsatuan,kb.hargasatuan as harga1,kb.pagu as total,
					 	kb.paguubah as total_ubah
					 	from kua.belanjarincian kb 
					 	Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And 
						kb.kodeorganisasi='$ckodeorganisasi' And kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And 
						kb.kodekegiatan='$ckodekegiatan' And kb.kodeakun = '$ckodeakun' And kb.kodekelompok = '$ckodekelompok' And 
						kb.kodejenis='$ckodejenis' AND kb.kodeobjek = '$ckodeobjek' And kb.koderincianobjek = '$ckoderincianobjek'  ";
	    			$query3 = $this->db->query($sql3);       
	    	
	    			foreach($query3->result_array() as $resulte3) { 
						$curai				= $resulte3['uraian'];
						$cvolume1			= $resulte3['volume1'];
						$cvolume2			= $resulte3['volume2'];
						$cvolume3			= $resulte3['volume3'];
						$cjmlvolume			= $resulte3['tvolume'];
						$csatuan1			= $resulte3['satuan1'];
						$csatuan2			= $resulte3['satuan2'];
						$csatuan3			= $resulte3['satuan3'];
						$chargasatuan		= $resulte3['harga1'];
						$ctotal				= $resulte3['total'];
						$ctotal_ubah		= $resulte3['total_ubah'];


						if ($ctotal == 'NULL'){
							$ctotal = 0;
						}else{
							$ctotal = $ctotal ;
						}
						if ($ctotal_ubah == 'NULL'){
							$ctotal_ubah = 0;
						}else{
							$ctotal_ubah = $ctotal_ubah ;
						}


						$dbsimakda->query("insert into trdpo(kd_kegiatan,kd_rek5,no_trdrka,uraian,volume1,volume2,volume3,tvolume,satuan1,satuan2,satuan3,harga1,total,total_ubah) 
							values('$ckd_kegiatan','$ckd_rek5','$cno_trdrka','$curai','$cvolume1','$cvolume2','cvolume3','$cjmlvolume','$csatuan1','$csatuan2','$csatuan3','$chargasatuan','$ctotal','$ctotal_ubah') ");


	    			}

				
			
		
				}
	    					   

	         	 //ECHO($nmkegiatan);

	        	$ii++;
	    }
	    
	echo "<script>alert('PROSES KIRIM DATA E-BUDGETTING BELANJA KE SIMAKDA SELESAI')</script>";	

	}

	function kirim_budget_rincian_pend_simakda(){

		$dbsimakda=$this->load->database('simakda', TRUE);
		$dbsimakda->query("delete from trdpopend where left(kd_rek5,'1')='4' ");
		
		$sql = "SELECT DISTINCT kodeurusan,kodesuburusan,rtrim(kodeorganisasi) as kodeorganisasi,rtrim(kodebidang) as kodebidang,kodeprogram,kodekegiatan 
		FROM kua.belanjarincian ORDER BY kodeurusan,kodesuburusan,rtrim(kodeorganisasi),rtrim(kodebidang),kodeprogram,kodekegiatan";
	    $query1 = $this->db->query($sql);       
	    $ii = 0;
	    foreach($query1->result_array() as $resulte) { 
	     
	            $id =  $ii;        
	           
	            $ckodeurusan 		= $resulte['kodeurusan'];
				$ckodesuburusan 	= $resulte['kodesuburusan'];
				$ckodeorganisasi 	= $resulte['kodeorganisasi'];
				$xkodebidang 		= $resulte['kodebidang'];
				$ckodeprogram 		= $resulte['kodeprogram'];
				$ckodekegiatan 		= $resulte['kodekegiatan'];

				
         
	           if (strlen($ckodeurusan)== 1){
	           	$xkodeurusan = '0'.$ckodeurusan;
	           }else{
	           	$xkodeurusan = $ckodeurusan;
	           }

	           if (strlen($ckodeprogram)== 1){
	           	$xkodeprogram = '0'.$ckodeprogram;
	           }else{
	           	$xkodeprogram = $ckodeprogram;
	           }

	            if (strlen($ckodekegiatan)== 1){
	           	$xkodekegiatan = '0'.$ckodekegiatan;
	           }else{
	           	$xkodekegiatan = $ckodekegiatan;
	           }

	           if (strlen($ckodesuburusan)== 1){
	           	$xkodesuburusan = '0'.$ckodesuburusan;
	           }else{
	           	$xkodesuburusan = $ckodesuburusan;
	           }

	           if ($xkodeprogram== '00'){
				  $xkodeprogram 	= 'TL';
				  $xkodebidang 		= '';
				  $ykodebidang 		= $ckodeurusan.'.'.$xkodesuburusan;
				  $nmkegiatan 		= 'Belanja Pegawai';
			   }

			   $ckodebidang=$ckodeurusan.'.'.$xkodesuburusan;

			   $sql2 = "select  distinct  kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek 
						from kua.pendapatanrincian kb 
						Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And kb.kodeorganisasi='$ckodeorganisasi' 
						AND kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And kb.kodekegiatan='$ckodekegiatan'
						order by kb.kodeakun,kb.kodekelompok,kb.kodejenis,kb.kodeobjek,kb.koderincianobjek";
	    		$query2 = $this->db->query($sql2);       
	    	
	    		foreach($query2->result_array() as $resulte2) { 
					$ckodeakun 			= $resulte2['kodeakun'];
					$ckodekelompok 		= $resulte2['kodekelompok'];
					$ckodejenis 		= $resulte2['kodejenis'];
					$ckodeobjek 		= $resulte2['kodeobjek'];
					$ckoderincianobjek 	= $resulte2['koderincianobjek'];



					if (strlen($ckodeorganisasi) == 3){
						$xkodeorganisasi = '0'.$ckodeorganisasi ;
					}Else{
						$xkodeorganisasi = $ckodeorganisasi;
					}

					if (strlen($ckodeobjek) == 1){
						$xkodeobjek = '0'.$ckodeobjek ;
					}else{
						$xkodeobjek = $ckodeobjek;
					}
					
					if (strlen($ckoderincianobjek) == 1){
						$xkoderincianobjek = '0'.$ckoderincianobjek;
					}else{
						$xkoderincianobjek = $ckoderincianobjek;
					}
					$ckd_skpd 		=  $ckodeurusan.'.'.$xkodesuburusan.'.'.substr(rtrim($ckodeorganisasi),0,2).'.'.substr(rtrim($ckodeorganisasi),2,2) ;
					$ckd_skpd2 		=   $ckodeurusan.'.'.$ckodesuburusan.'.'.substr($ckodeorganisasi,1,2).'.'.substr($ckodeorganisasi,3,2) ; 

					if ($xkodeprogram == 'TL'){
						$ckd_urusan		= $ckodebidang ;
					}else{
						$ckd_urusan		= $xkodebidang ; 
					}
		
					

					$ckd_rek5			= $ckodeakun.$ckodekelompok.$ckodejenis.$xkodeobjek.$xkoderincianobjek ;
					

					 $sql3 = "select kb.urai as uraian,kb.volume as volume1,kb.volume2,kb.volume3,kb.jmlvolume as tvolume,
					 	kb.satuan as satuan1,kb.satuan2,kb.satuan3,kb.jmlsatuan,kb.hargasatuan as harga1,kb.pagu as total,
					 	kb.paguubah as total_ubah
					 	from kua.pendapatanrincian kb 
					 	Where kb.kodeurusan='$ckodeurusan' And kb.kodesuburusan='$ckodesuburusan' And 
						kb.kodeorganisasi='$ckodeorganisasi' And kb.kodebidang='$xkodebidang' And kb.kodeprogram='$ckodeprogram' And 
						kb.kodekegiatan='$ckodekegiatan' And kb.kodeakun = '$ckodeakun' And kb.kodekelompok = '$ckodekelompok' And 
						kb.kodejenis='$ckodejenis' AND kb.kodeobjek = '$ckodeobjek' And kb.koderincianobjek = '$ckoderincianobjek'  ";
	    			$query3 = $this->db->query($sql3);       
	    			$ckd_rek6=0;
	    			foreach($query3->result_array() as $resulte3) { 
						$curai				= $resulte3['uraian'];
						$cvolume1			= $resulte3['volume1'];
						$cvolume2			= $resulte3['volume2'];
						$cvolume3			= $resulte3['volume3'];
						$cjmlvolume			= $resulte3['tvolume'];
						$csatuan1			= $resulte3['satuan1'];
						$csatuan2			= $resulte3['satuan2'];
						$csatuan3			= $resulte3['satuan3'];
						$chargasatuan		= $resulte3['harga1'];
						$ctotal				= $resulte3['total'];
						$ctotal_ubah		= $resulte3['total'];
						$ckd_rek6++;


						if ($ctotal == 'NULL'){
							$ctotal = 0;
						}else{
							$ctotal = $ctotal ;
						}
						if ($ctotal_ubah == 'NULL'){
							$ctotal_ubah = 0;
						}else{
							$ctotal_ubah = $ctotal_ubah ;
						}


						$dbsimakda->query("insert into trdpopend(kd_rek5,kd_rek6,nilai,kd_skpd,nilai_ubah) 
							values('$ckd_rek5','','$ctotal','$ckd_skpd','$ctotal_ubah') ");


	    			}

				
			
		
				}
	    					   

	         	 //ECHO($nmkegiatan);

	        	$ii++;
	    }
	    
	echo "<script>alert('PROSES KIRIM DATA E-BUDGETTING RINCIAN PENDAPATAN KE SIMAKDA SELESAI')</script>";	

	}

// ========================  SELESAI  ==========================
}
