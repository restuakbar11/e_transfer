<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_SPM extends CI_Model {

	public function loadHeader($key) {
			$result = array();
			$row    = array();
			$page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
			$offset = ($page-1)*$rows;
			
			$oto = $this->session->userdata('oto');
			if ($oto=='01')// as ADMIN
			{
				if($key !=''){
				$cari  = "upper(no_dokumen) like upper('%$key%')";	
				$limit = "";	
				$where = " where $cari $limit ";
				}else{
				$limit  = "ORDER BY no_dokumen ASC LIMIT $rows OFFSET $offset";
				$where = "";
				}	
			}
			else
			{	
				$skpd = $this->session->userdata('kd_skpd');
				$kdskpd = " kd_uskpd='$skpd' ";

				if($key !=''){
				$cari  = "upper(no_dokumen) like upper('%$key%')";	
				$limit = "";	
				$where = " where $cari $limit and $kdskpd";
				}else{
				$limit  = "ORDER BY no_dokumen ASC LIMIT $rows OFFSET $offset";
				$where = "where $kdskpd";
				}

			}

		
		
		$sql = "SELECT count(*) as tot from transaksi.trh_isianbrg $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
		
        $sql = "SELECT no_dokumen,kd_comp,(select nm_comp from mcompany where kd_comp=transaksi.trh_isianbrg.kd_comp) as nm_comp,tgl_dokumen,
				kd_milik,(select nm_milik from mmilik where kd_milik=transaksi.trh_isianbrg.kd_milik)as nm_milik,
				nilai_kontrak,kd_wilayah,kd_uskpd,
				kd_uskpd,kd_unit,s_dana,tahun,s_ang,kd_cr_oleh,b_dasar,b_nomor,b_tanggal,h_total,id_lock
				from transaksi.trh_isianbrg
				$where $limit";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $row[] = array(
				'id'            => $ii,        
				'no_dokumen'    => $resulte['no_dokumen'],
				'kd_comp'       => $resulte['kd_comp'],
				'nm_comp'       => $resulte['nm_comp'],
				'tgl_dokumen'   => $this->tanggal_ind($resulte['tgl_dokumen']),
				'kd_milik'      => $resulte['kd_milik'],
				'nm_milik'      => $resulte['nm_milik'],
				'nilai_kontrak' => $resulte['nilai_kontrak'],
				'kd_wilayah'    => $resulte['kd_wilayah'],
				'kd_uskpd'      => $resulte['kd_uskpd'],
				'kd_unit'       => $resulte['kd_unit'],
				's_dana'        => $resulte['s_dana'],
				'tahun'         => $resulte['tahun'],
				's_ang'         => $resulte['s_ang'],
				'kd_cr_oleh'    => $resulte['kd_cr_oleh'],
				'b_dasar'       => $resulte['b_dasar'],
				'b_nomor'       => $resulte['b_nomor'],
				'b_tanggal'     => $this->tanggal_ind($resulte['b_tanggal']),
				'h_total'       => $resulte['h_total'],
				'id_lock'       => $resulte['id_lock']

            );
            $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        return $result;
	}

	public function get_satker($lccq){
		$sql	= "SELECT satkerja,nm_satkerja FROM public.satkerja where satkerja not in('001','002','003') order by satkerja ";
		$query  = $this->db->query($sql);
		
		return $query->result_array();
	}

	public function golongan1($lccq){
		$sql	= "SELECT id,nm_golongan FROM public.mgolongan order by id ";
		$query  = $this->db->query($sql);
		
		return $query->result_array();
	}


	public function load_detail($param)
	{
		$nomor 	= $param['nomor'];
		$skpd 	= $param['skpd'];

		$result   = array();
        $row      = array();
        $page     = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows     = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset   = ($page-1)*$rows;

        $csql = "SELECT SUM(nilai) AS total from transaksi.trhsp2d where no_spm = '$nomor' and kd_skpd = '$skpd'";
        $query1 = $this->db->query($csql);
        $ntotal = $query1->row('total');
		
        $sql = "select a.no_sp2d,a.no_spm,a.tgl_spm,a.no_spp,c.no_spd,c.keperluan,d.kd_rek5,d.nm_rek5,d.nilai,
				e.kd_rek5 as kd_rek5_pot,e.nm_rek5 as nm_rek5_pot,e.nilai as nilai_pot from transaksi.trhsp2d a 
				inner join transaksi.trhspm b on a.no_spm=b.no_spm
				inner join transaksi.trspmpot e on b.no_spm=e.no_spm
				inner join transaksi.trhspp c on b.no_spp=c.no_spp
				inner join transaksi.trdspp d on c.no_spp=d.no_spp
				where a.no_spm='$nomor' and a.kd_skpd='$skpd'";
        $query2 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query2->result_array() as $resulte)
        {            
            $row[] = array( 
            	'id'         => $ii,               
				'no_sp2d'    => $resulte['no_sp2d'],
				'no_spm'     => $resulte['no_spm'],
				'tgl_spm'    => $this->tanggal_ind($resulte['tgl_spm']),
				'no_spp'     => $resulte['no_spp'],
				'no_spd'     => $resulte['no_spd'],
				'keperluan'  => $resulte['keperluan'],
				'kd_rek5'    => $resulte['kd_rek5'],
				'nm_rek5'    => $resulte['nm_rek5'],
				'nilai'       => number_format($resulte['nilai'],0,'.',','),
				'kd_rek5_pot' => $resulte['kd_rek5_pot'],
				'nm_rek5_pot' => $resulte['nm_rek5_pot'],
				'nilai_pot'   => number_format($resulte['nilai_pot'],0,'.',',')				
            );
            $ii++;
        }           

		

		$query1->free_result();
        $query2->free_result();
        
        
        $result["total"]  = $ntotal;
        $result["rows"]   = $row; 
        
        return $result;		
        
	}



	


}
