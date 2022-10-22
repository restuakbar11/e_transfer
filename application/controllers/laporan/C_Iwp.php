<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Iwp extends CI_Controller {

    public function __construct()
    
    {
        parent::__construct();
        //$this->load->model('Laporan/M_Iwp');
        $this->load->library('pdf');
    }

    public function bulan($bln)
    {
        //$bln = date("m");
        switch ($bln) {
            case 1: 
            return "Januari";
                break;
            case 2: 
            return "Februari";
                break;
            case 3:
            return "Maret";
                break;
            case 4: 
            return "April";
                break;
            case 5: 
            return "Mei";
                break;
            case 6: 
            return "Juni";
                break;
            case 7: 
            return "Juli";
                break;
            case 8: 
            return "Agustus";
                break;
            case 9: 
            return "September";
                break;
            case 10: 
            return "Oktober";
                break;
            case 11: 
            return "November";
                break;
            case 12: 
            return "Desember";
                break;
                                                                  
        }

    }


    public function iwp(){
    	
    	if (isset($_POST['kd_skpd1'])) {
                $tanggal = date("d");
                $bln = date("m");
                $tahun = 2018;
                $c_bulan = $this->bulan($bln);
                $skpd1 = $_POST['kd_skpd1'];
	    		$no = 0;
	    		$nip = '196005021981031020';
	        	$pdf = new FPDF('L','mm','LEGAL');
                $pdf->AddPage(); // Membuat Halaman Baru
                $pdf->SetMargins(19,19);           
                $pdf->SetFont('Arial','B',12);// Setting Jenis Font Yang Akan Digunakan HEADER
                $pdf->Cell(170,7,'',0,1,'L');
                $pdf->Cell(10,7,'DAFTAR REKAPITULASI',0,0,'L');
                $pdf->Cell(270,5,'Lapiran III : S.E MENTERI DALAM NEGERI',0,1,'R');
                $pdf->Cell(10,9,'HASIL PEMUNGUTAN IURAN WAJIB',0,0,'L');
                $pdf->Cell(238,7,'376/65a/PUOD',0,1,'R');
                $pdf->Cell(10,9,'PEGAWAI NEGERI SIPIL DAERAH',0,0,'L');
                $pdf->Cell(230,7,'21/02/1995',0,1,'R');
                $pdf->Cell(10,9,'KABUPATEN ASMAT',0,0,'L');
                $pdf->Cell(15,25,"Bulan : $c_bulan $tahun",0,0,'L');
                $pdf->Cell(15,20,'',0,1); // jarak antara header dan tabel
        
                $pdf->SetFont('Arial','B',12); // Setting jenis font yg akan digunakan dalam tabel
                $pdf->Cell(10,10,'No ',1,0,'C');
                $pdf->Cell(160,10,'Unit Kerja',1,0,'C');
                $pdf->Cell(20,10,'Jml pegawai',1,0,'C');
                $pdf->Cell(30,10,'jml gapok',1,0,'C');
                $pdf->Cell(20,10,'jml tkeluarga',1,0,'C');
                $pdf->Cell(25,10,'jumlah',1,0,'C');
                $pdf->Cell(20,10,'8% (Rp)',1,0,'C');
                $pdf->Cell(20,10,'2% (Rp)',1,0,'C');
                $pdf->Cell(30,10,'Keterangan',1,1,'C');
                $pdf->SetFont('Arial','',10); // font dan ukuran font

        			$sql_unit_kerja = "SELECT distinct a.nm_satkerja from public.satkerja a inner join 
					public.pegawai b ON a.satkerja=b.satkerja
					where a.satkerja = '$skpd1'";
					$unit_kerja = $this->db->query($sql_unit_kerja)->result();
        			foreach ($unit_kerja as $row){
                        $no++;
        				$pdf->Cell(10,6,"$no",1,0); 
        				$pdf->Cell(160,6,"$row->nm_satkerja",1,0);  
        			}
        
			        $sql_pegawai = "SELECT count(satkerja) as jumpeg FROM public.pegawai where satkerja = '$skpd1'  ";
			        $pegawai = $this->db->query($sql_pegawai)->result();
			        foreach ($pegawai as $row){
        	
			        	$pdf->Cell(20,6,"$row->jumpeg",1,0);  
			        }
			        $sql = "SELECT sum(gapok) as n_gapok, sum(tistri+tanak) as t_kel, sum(gapok+tistri+tanak) as jumlah
			            	FROM public.pegawai
			            	WHERE satkerja = '$skpd1' ";

        			$tunjangan = $this->db->query($sql)->result();
        			foreach ($tunjangan as $row){
        				$n_gapok = $row->n_gapok;
        				$n_gapok1 = number_format($n_gapok ,0,',','.');
        				$t_kel = $row->t_kel;
        				$t_kel1 = number_format($t_kel ,0,',','.');
        				$jumlah = $row->jumlah;
        				$jumlah1 = number_format($jumlah ,0,',','.');
        				$iwp_8 = $jumlah*(8/100);
        				$iwp_81 = number_format($iwp_8 ,0,',','.');
        				$iwp_2 = $jumlah*(2/100);
        				$iwp_21 = number_format($iwp_2 ,0,',','.');

        				$pdf->SetFont('Arial','B',10);
        				$pdf->Cell(30,6,"$n_gapok1",1,0,'R');  
        				$pdf->Cell(20,6,"$t_kel1",1,0,'R');
        				$pdf->Cell(25,6,"$jumlah1",1,0);  
        				$pdf->Cell(20,6,"$iwp_81",1,0);
        				$pdf->Cell(20,6,"$iwp_21",1,0);
                        $pdf->Cell(30,6,"",1,1);
    				}
                        $pdf->Cell(0,10,'',0,1);
                        $pdf->SetFont('Arial','',13);
                        $pdf->Cell(220,5,"AGATS, $tanggal $c_bulan $tahun",0,1,'R');
                        $pdf->Cell(213,9,'Kepala BPKAD',0,1,'R');
                        $pdf->Cell(225,9,'Bendahara Umum Daerah',0,1,'R');
                        $pdf->Cell(0,20,'',0,1);
                        $pdf->SetFont('Arial','U',13);
                        $pdf->Cell(235,9,'HALASON F SINURAT, SSTP,M.Si',0,1,'R');
                        $pdf->SetFont('Arial','',13);
                        $pdf->Cell(210,2,'PEMBINA',0,1,'R');
                        $pdf->Cell(227,11,'NIP.198108241999121001',0,1,'R');
                        $pdf->Cell(10,9,'',0,0,'L');
        				$pdf->Output();
    		}

    	else {

                $no = 0;
                $tanggal = date("d");
                $bln = date("m");
                $tahun = 2018;
                $c_bulan = $this->bulan($bln);
                $pdf = new FPDF('L','mm','LEGAL');
                $pdf->AddPage(); // Membuat Halaman Baru
                $pdf->SetMargins(19,19);           
               	$pdf->SetFont('Arial','B',12);// Setting Jenis Font Yang Akan Digunakan HEADER
	        	$pdf->Cell(170,7,'',0,1,'L');
	        	$pdf->Cell(10,7,'DAFTAR REKAPITULASI',0,0,'L');
	        	$pdf->Cell(270,5,'Lapiran III : S.E MENTERI DALAM NEGERI',0,1,'R');
	        	$pdf->Cell(10,9,'HASIL PEMUNGUTAN IURAN WAJIB',0,0,'L');
	        	$pdf->Cell(238,7,'376/65a/PUOD',0,1,'R');
	        	$pdf->Cell(10,9,'PEGAWAI NEGERI SIPIL DAERAH',0,0,'L');
	        	$pdf->Cell(230,7,'21/02/1995',0,1,'R');
	        	$pdf->Cell(10,9,'KABUPATEN ASMAT',0,0,'L');
                $pdf->Cell(15,25,"Bulan : $c_bulan $tahun",0,0,'L');
	        	$pdf->Cell(15,20,'',0,1); // jarak antara header dan tabel
        
	        	$pdf->SetFont('Arial','B',12); // Setting jenis font yg akan digunakan dalam tabel
	        	$pdf->Cell(10,10,'No ',1,0,'C');
                $pdf->Cell(140,10,'Unit Kerja',1,0,'C');
                $pdf->Cell(25,10,'Jml pegawai',1,0,'C');
                $pdf->Cell(25,10,'jml gapok',1,0,'C');
                $pdf->Cell(30,10,'jml tkeluarga',1,0,'C');
                $pdf->Cell(25,10,'jumlah',1,0,'C');
                $pdf->Cell(20,10,'8% (Rp)',1,0,'C');
                $pdf->Cell(20,10,'2% (Rp)',1,0,'C');
                $pdf->Cell(30,10,'Keterangan',1,1,'C');
        		$pdf->SetFont('Arial','',9); // font dan ukuran font

        		$sql = "SELECT a.satkerja,a.nm_satkerja,
						(select count(*) as jml_peg from pegawai b where b.satkerja=a.satkerja) as jml_peg,
						(select sum(gapok) as j_gapok from pegawai c where c.satkerja=a.satkerja) as j_gapok,
						(select sum(tistri+tanak) as t_keluarga from pegawai d where d.satkerja=a.satkerja) as t_keluarga,
						(select sum(tistri+tanak+gapok) as jumlah from pegawai d where d.satkerja=a.satkerja) as Jumlah
						from satkerja a where a.satkerja not in('001','003','002') ";
                $n_jml_peg=0;
                $n_jml_gapok=0;
                $n_keluarga=0;
                $n_jumlah=0;
                $n_iwp2=0;
                $n_iwp8=0;
				$nm_satkerja = $this->db->query($sql)->result();
				foreach ($nm_satkerja as $row){
						$no++;
                        $jml_peg = $row->jml_peg;
						$gapok = $row->j_gapok;
        				$gapok1 = number_format($gapok ,0,',','.');
        				$t_keluarga = $row->t_keluarga;
        				$t_keluarga1 = number_format($t_keluarga ,0,',','.');
        				$jumlah = $row->jumlah;
        				$jumlah1 = number_format($jumlah ,0,',','.');
        				$iwp_8 = $jumlah*(8/100);
        				$iwp_81 = number_format($iwp_8 ,0,',','.');
        				$iwp_2 = $jumlah*(2/100);
        				$iwp_21 = number_format($iwp_2 ,0,',','.');

                        $n_jml_peg=$n_jml_peg+$jml_peg;
                        $j_jml_peg = number_format($n_jml_peg ,0,',','.');
                        $n_jml_gapok=$n_jml_gapok+$gapok1;
                        $j_jml_gapok = number_format($n_jml_gapok ,0,',','.');
                        $n_keluarga=$n_keluarga+$t_keluarga1;
                        $j_keluarga = number_format($n_keluarga ,0,',','.');
                        $n_jumlah=$n_jumlah+$jumlah;
                        $j_jumlah = number_format($n_jumlah ,0,',','.');
                        $n_iwp8=$n_iwp8+$iwp_8;
                        $j_iwp8 = number_format($n_iwp8 ,0,',','.');
                        $n_iwp2=$n_iwp2+$iwp_2;
                        $j_iwp2 = number_format($n_iwp2 ,0,',','.');

        				$pdf->Cell(10,6,"$no",1,0); 
        				$pdf->Cell(140,6,"$row->nm_satkerja",1,0);
        				$pdf->Cell(25,6,"$jml_peg",1,0);
        				$pdf->Cell(25,6,"$gapok1",1,0);
        				$pdf->cell(30,6,"$t_keluarga1",1,0);  
        				$pdf->cell(25,6,"$jumlah1",1,0);
        				$pdf->cell(20,6,"$iwp_81",1,0);
        				$pdf->Cell(20,6,"$iwp_21",1,0);
                        $pdf->Cell(30,6,'',1,1,'C');
        				
        		}
                $pdf->Cell(10,6,"",1,0);
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(140,6,"JUMLAH KESELURUHAN. . . . . . . . . ",1,0);
                $pdf->Cell(25,6,"$j_jml_peg",1,0);
                $pdf->Cell(25,6,"$j_jml_gapok",1,0);
                $pdf->cell(30,6,"$j_keluarga",1,0);  
                $pdf->cell(25,6,"$j_jumlah",1,0);
                $pdf->cell(20,6,"$j_iwp8",1,0);
                $pdf->Cell(20,6,"$j_iwp2",1,0);
                $pdf->Cell(30,6,'',1,1,'C');
                $pdf->Cell(0,10,'',0,1);
                $pdf->SetFont('Arial','',13);
                $pdf->Cell(220,5,"AGATS, $tanggal $c_bulan $tahun",0,1,'R');
                $pdf->Cell(213,9,'Kepala BPKAD',0,1,'R');
                $pdf->Cell(225,9,'Bendahara Umum Daerah',0,1,'R');
                $pdf->Cell(0,20,'',0,1);
                $pdf->SetFont('Arial','U',13);
                $pdf->Cell(235,9,'HALASON F SINURAT, SSTP,M.Si',0,1,'R');
                $pdf->SetFont('Arial','',13);
                $pdf->Cell(210,2,'PEMBINA',0,1,'R');
                $pdf->Cell(227,11,'NIP.198108241999121001',0,1,'R');
                $pdf->Cell(10,9,'',0,0,'L');
        		$pdf->Output();
    	}
	}
}
