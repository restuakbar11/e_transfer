<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Pph extends CI_Controller {

    public function __construct()
    
    {
        parent::__construct();
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


    public function pph(){
    	
    	if (isset($_POST['kd_skpd1'])) {
                $tanggal = date("d");
                $bln = date("m");
                $tahun = 2018;
                $c_bulan = $this->bulan($bln);
    			//$skpd1  = '1.20.03';
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
                $pdf->Cell(10,9,'PAJAK PENGHASILAN (PPH) BAGI',0,0,'L');
                $pdf->Cell(238,7,'376/65a/PUOD',0,1,'R');
                $pdf->Cell(10,9,'PEGAWAI NEGERI SIPIL DAERAH OTONOM',0,0,'L');
                $pdf->Cell(230,7,'21/02/1995',0,1,'R');
                $pdf->Cell(10,9,'KABUPATEN ASMAT',0,0,'L');
                $pdf->Cell(15,25,"Bulan : $c_bulan $tahun",0,0,'L');
                $pdf->Cell(15,20,'',0,1); // jarak antara header dan tabel
        
                $pdf->SetFont('Arial','B',10); // Setting jenis font yg akan digunakan dalam tabel
                $pdf->Cell(10,10,'No ',1,0,'C');
                $pdf->Cell(160,10,'Unit Kerja',1,0,'C');
                $pdf->Cell(30,10,'Gol 1',1,0,'C');
                $pdf->Cell(30,10,'Gol 2',1,0,'C');
                $pdf->Cell(30,10,'Gol 3',1,0,'C');
                $pdf->Cell(30,10,'Gol 4',1,0,'C');
                $pdf->Cell(25,10,'Jumlah',1,1,'C');
                $pdf->SetFont('Arial','',12); // font dan ukuran font

        		$sql = "SELECT a.satkerja,a.nm_satkerja,
                        (select sum(pph) from public.pegawai b where b.satkerja=a.satkerja and left(b.golongan,1) = '1' ) as gol_1,
                        (select sum(pph) from public.pegawai b where b.satkerja=a.satkerja and left(b.golongan,1) = '2' ) as gol_2,
                        (select sum(pph) from public.pegawai b where b.satkerja=a.satkerja and left(b.golongan,1) = '3' ) as gol_3,
                        (select sum(pph) from public.pegawai b where b.satkerja=a.satkerja and left(b.golongan,1) = '4' ) as gol_4
                        from satkerja a where a.satkerja = '$skpd1'";

                $pph = $this->db->query($sql)->result();
                foreach ($pph as $row){
                         $no++;
                         $golongan_1 = $row->gol_1;
                         $j_golongan_1 = number_format($golongan_1 ,0,',','.');
                         $golongan_2 = $row->gol_2;
                         $j_golongan_2 = number_format($golongan_2 ,0,',','.');
                         $golongan_3 = $row->gol_3;
                         $j_golongan_3 = number_format($golongan_3 ,0,',','.');
                         $golongan_4 = $row->gol_4;
                         $j_golongan_4 = number_format($golongan_4 ,0,',','.');
                         $jumlah = $golongan_1 + $golongan_2 + $golongan_3 + $golongan_4;
                         $jumlah1 = number_format($jumlah,0,',','.');
                        //echo "$jumlah";
                        $pdf->Cell(10,6,"$no",1,0); 
                        $pdf->Cell(160,6,"$row->nm_satkerja",1,0);
                        $pdf->Cell(30,6,"$j_golongan_1",1,0);
                        $pdf->Cell(30,6,"$j_golongan_2",1,0);
                        $pdf->Cell(30,6,"$j_golongan_3",1,0);
                        $pdf->cell(30,6,"$j_golongan_4",1,0);  
                        $pdf->cell(25,6,"$jumlah1",1,1);           
                        
                }
        		        $pdf->Cell(10,6,"",1,0);
                        $pdf->SetFont('Arial','B',12);
                        $pdf->Cell(160,6,"JUMLAH KESELURUHAN. . . . . . . . . ",1,0);
                        $pdf->Cell(30,6,"$j_golongan_1",1,0);
                        $pdf->Cell(30,6,"$j_golongan_2",1,0);
                        $pdf->Cell(30,6,"$j_golongan_3",1,0);
                        $pdf->cell(30,6,"$j_golongan_4",1,0);  
                        $pdf->cell(25,6,"$jumlah1",1,1);     

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
                $pdf->Cell(10,9,'PAJAK PENGHASILAN (PPH) BAGI',0,0,'L');
                $pdf->Cell(238,7,'376/65a/PUOD',0,1,'R');
                $pdf->Cell(10,9,'PEGAWAI NEGERI SIPIL DAERAH OTONOM',0,0,'L');
                $pdf->Cell(230,7,'21/02/1995',0,1,'R');
                $pdf->Cell(10,9,'KABUPATEN ASMAT',0,0,'L');
                $pdf->Cell(15,25,"Bulan : $c_bulan $tahun",0,0,'L');
                $pdf->Cell(15,20,'',0,1); // jarak antara header dan tabel
        
	        	$pdf->SetFont('Arial','B',10); // Setting jenis font yg akan digunakan dalam tabel
                $pdf->Cell(10,10,'No ',1,0,'C');
                $pdf->Cell(160,10,'Unit Kerja',1,0,'C');
                $pdf->Cell(30,10,'Gol 1',1,0,'C');
                $pdf->Cell(30,10,'Gol 2',1,0,'C');
                $pdf->Cell(30,10,'Gol 3',1,0,'C');
                $pdf->Cell(30,10,'Gol 4',1,0,'C');
                $pdf->Cell(25,10,'Jumlah',1,1,'C');
                $pdf->SetFont('Arial','',12); // font dan ukuran font

        		$sql = "SELECT a.satkerja,a.nm_satkerja,
                        (select sum(pph) from public.pegawai b where b.satkerja=a.satkerja and left(b.golongan,1) = '1' ) as gol_1,
                        (select sum(pph) from public.pegawai b where b.satkerja=a.satkerja and left(b.golongan,1) = '2' ) as gol_2,
                        (select sum(pph) from public.pegawai b where b.satkerja=a.satkerja and left(b.golongan,1) = '3' ) as gol_3,
                        (select sum(pph) from public.pegawai b where b.satkerja=a.satkerja and left(b.golongan,1) = '4' ) as gol_4
                        from satkerja a where a.satkerja  not in('001','003','002')";
                $n_gol1=0;
                $n_gol2=0;
                $n_gol3=0;
                $n_gol4=0;
                $n_jumlah=0;
                $pph = $this->db->query($sql)->result();
                foreach ($pph as $row){
                         $no++;
                         $golongan_1 = $row->gol_1;
                         $j_golongan_1 = number_format($golongan_1 ,0,',','.');
                         $golongan_2 = $row->gol_2;
                         $j_golongan_2 = number_format($golongan_2 ,0,',','.');
                         $golongan_3 = $row->gol_3;
                         $j_golongan_3 = number_format($golongan_3 ,0,',','.');
                         $golongan_4 = $row->gol_4;
                         $j_golongan_4 = number_format($golongan_4 ,0,',','.');
                         $jumlah = $golongan_1 + $golongan_2 + $golongan_3 + $golongan_4;
                         $jumlah1 = number_format($jumlah,0,',','.');

                         $n_gol1 = $n_gol1 + $golongan_1;
                         $j_gol_1 = number_format($n_gol1 ,0,',','.');
                         $n_gol2 = $n_gol2 + $golongan_2;
                         $j_gol_2 = number_format($n_gol2 ,0,',','.');
                         $n_gol3 = $n_gol3 + $golongan_3;
                         $j_gol_3 = number_format($n_gol3 ,0,',','.');
                         $n_gol4 = $n_gol4 + $golongan_4;
                         $j_gol_4 = number_format($n_gol4 ,0,',','.');
                         $n_jumlah=$n_jumlah+$jumlah;
                         $j_jumlah = number_format($n_jumlah ,0,',','.');
                        //echo "$jumlah";
                        $pdf->Cell(10,6,"$no",1,0); 
                        $pdf->Cell(160,6,"$row->nm_satkerja",1,0);
                        $pdf->Cell(30,6,"$j_golongan_1",1,0);
                        $pdf->Cell(30,6,"$j_golongan_2",1,0);
                        $pdf->Cell(30,6,"$j_golongan_3",1,0);
                        $pdf->cell(30,6,"$j_golongan_4",1,0);  
                        $pdf->cell(25,6,"$j_jumlah",1,1);           
                        
                }
                $pdf->Cell(10,6,"",1,0);
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(160,6,"JUMLAH KESELURUHAN. . . . . . . . . ",1,0);
                $pdf->Cell(30,6,"$j_gol_1",1,0);
                $pdf->Cell(30,6,"$j_gol_2",1,0);
                $pdf->Cell(30,6,"$j_gol_3",1,0);
                $pdf->cell(30,6,"$j_gol_4",1,0);  
                $pdf->cell(25,6,"$jumlah1",1,1); 
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
