<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Askes extends CI_Controller {

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


    public function askes(){
    	
       if (isset($_POST['kd_skpd1'])) {

                $tanggal = date("d");
                $bln = date("m");
                $tahun = 2018;
                $c_bulan = $this->bulan($bln);
                $skpd1 = $_POST['kd_skpd1'];
                //$skpd1 = '1.01.01';
                $no = 0;
                $nip = '196005021981031020';
                $pdf = new FPDF('L','mm','LEGAL');
                $pdf->AddPage(); // Membuat Halaman Baru
                $pdf->SetMargins(19,19);           
                $pdf->SetFont('Arial','B',12);// Setting Jenis Font Yang Akan Digunakan HEADER
                $pdf->Cell(170,7,'',0,1,'L');
                $pdf->Cell(10,7,'DAFTAR REKAPITULASI',0,0,'L');
                $pdf->Cell(270,5,'Lapiran III : S.E MENTERI DALAM NEGERI',0,1,'R');
                $pdf->Cell(10,9,'TUNJANGAN ASKES',0,0,'L');
                $pdf->Cell(238,7,'376/65a/PUOD',0,1,'R');
                $pdf->Cell(10,9,'PEGAWAI NEGERI SIPIL DAERAH',0,0,'L');
                $pdf->Cell(230,7,'21/02/1995',0,1,'R');
                $pdf->Cell(10,9,'KABUPATEN ASMAT',0,0,'L');
                $pdf->Cell(15,25,"Bulan : $c_bulan $tahun",0,0,'L');
                $pdf->Cell(15,20,'',0,1); // jarak antara header dan tabel
        
                $pdf->SetFont('Arial','B',10); // Setting jenis font yg akan digunakan dalam tabel
                $pdf->Cell(10,10,'No ',1,0,'C');
                $pdf->Cell(160,10,'Unit Kerja',1,0,'C');
                $pdf->Cell(25,10,'Jml pegawai',1,0,'C');
                $pdf->Cell(25,10,'jml gapok',1,0,'C');
                $pdf->Cell(25,10,'jml tkeluarga',1,0,'C');
                $pdf->Cell(25,10,'jumlah',1,0,'C');
                $pdf->Cell(20,10,'Askes (2%)',1,0,'C');
                $pdf->Cell(40,10,'Keterangan',1,1,'C');
                $pdf->SetFont('Arial','',12); // font dan ukuran font

                $sql = "SELECT a.satkerja,a.nm_satkerja,
                        (select count(*) as jml_peg from pegawai b where b.satkerja=a.satkerja) as jml_peg,
                        (select sum(gapok) as j_gapok from pegawai c where c.satkerja=a.satkerja) as j_gapok,
                        (select sum(tistri+tanak) as t_keluarga from pegawai d where d.satkerja=a.satkerja) as t_keluarga,
                        (select sum(tistri+tanak+gapok) as jumlah from pegawai d where d.satkerja=a.satkerja) as Jumlah
                        from satkerja a where a.satkerja = '$skpd1' " ;
                $j_pegawai = 0;
                $j_gapok = 0;
                $j_keluarga = 0;
                $j_jumlah = 0;
                //$j_askes = 0;

                $askes = $this->db->query($sql)->result();
                foreach ($askes as $row){
                        $no++;
                        $n_peg = $row->jml_peg;
                        $n_gapok = $row->j_gapok;
                        $n_gapok1 = number_format($n_gapok ,0,',','.');
                        $t_kel = $row->t_keluarga;
                        $t_kel1 = number_format($t_kel ,0,',','.');
                        $jumlah = $row->jumlah;
                        $jumlah1 = number_format($jumlah ,0,',','.');
                        $askes = $jumlah*(2/100);
                        $askes1 = number_format($askes ,0,',','.');

                        $j_pegawai = $j_pegawai + $n_peg;

                        $pdf->SetFont('Arial','B',10);
                        $pdf->Cell(10,6,"$no",1,0,'R');  
                        $pdf->Cell(160,6,"$row->nm_satkerja",1,0,'L');
                        $pdf->Cell(25,6,"$n_peg",1,0,'R');  
                        $pdf->Cell(25,6,"$n_gapok1",1,0,'R');  
                        $pdf->Cell(25,6,"$t_kel1",1,0,'R');
                        $pdf->Cell(25,6,"$jumlah1",1,0,'R');  
                        $pdf->Cell(20,6,"$askes1",1,0,'R');
                        $pdf->Cell(40,6,"",1,1);
                    }
                        $pdf->Cell(10,6,"",1,0);
                        $pdf->SetFont('Arial','B',10);
                        $pdf->Cell(160,6,"JUMLAH KESELURUHAN . . . . .",1,0,'L');
                        $pdf->Cell(25,6,"$j_pegawai",1,0,'R');  
                        $pdf->Cell(25,6,"$n_gapok1",1,0,'R');  
                        $pdf->Cell(25,6,"$t_kel1",1,0,'R');
                        $pdf->Cell(25,6,"$jumlah1",1,0,'R');  
                        $pdf->Cell(20,6,"$askes1",1,0,'R');
                        $pdf->Cell(40,6,"",1,1);
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
            
        else{
                $tanggal = date("d");
                $bln = date("m");
                $tahun = 2018;
                $c_bulan = $this->bulan($bln);
                //$skpd1 = $_POST['kd_skpd1'];
                //$skpd1 = '1.01.01';
                $no = 0;
                $nip = '196005021981031020';
                $pdf = new FPDF('L','mm','LEGAL');
                $pdf->AddPage(); // Membuat Halaman Baru
                $pdf->SetMargins(19,19);           
                $pdf->SetFont('Arial','B',12);// Setting Jenis Font Yang Akan Digunakan HEADER
                $pdf->Cell(170,7,'',0,1,'L');
                $pdf->Cell(10,7,'DAFTAR REKAPITULASI',0,0,'L');
                $pdf->Cell(270,5,'Lapiran III : S.E MENTERI DALAM NEGERI',0,1,'R');
                $pdf->Cell(10,9,'TUNJANGAN ASKES',0,0,'L');
                $pdf->Cell(238,7,'376/65a/PUOD',0,1,'R');
                $pdf->Cell(10,9,'PEGAWAI NEGERI SIPIL DAERAH',0,0,'L');
                $pdf->Cell(230,7,'21/02/1995',0,1,'R');
                $pdf->Cell(10,9,'KABUPATEN ASMAT',0,0,'L');
                $pdf->Cell(15,25,"Bulan : $c_bulan $tahun",0,0,'L');
                $pdf->Cell(15,20,'',0,1); // jarak antara header dan tabel
        
                $pdf->SetFont('Arial','B',10); // Setting jenis font yg akan digunakan dalam tabel
                $pdf->Cell(10,10,'No ',1,0,'C');
                $pdf->Cell(150,10,'Unit Kerja',1,0,'C');
                $pdf->Cell(25,10,'Jml pegawai',1,0,'C');
                $pdf->Cell(25,10,'jml gapok',1,0,'C');
                $pdf->Cell(25,10,'jml tkeluarga',1,0,'C');
                $pdf->Cell(25,10,'jumlah',1,0,'C');
                $pdf->Cell(25,10,'Askes (2%)',1,0,'C');
                $pdf->Cell(40,10,'Keterangan',1,1,'C');
                $pdf->SetFont('Arial','',12); // font dan ukuran font

                $sql = "SELECT a.satkerja,a.nm_satkerja,
                        (select count(*) as jml_peg from pegawai b where b.satkerja=a.satkerja) as jml_peg,
                        (select sum(gapok) as j_gapok from pegawai c where c.satkerja=a.satkerja) as j_gapok,
                        (select sum(tistri+tanak) as t_keluarga from pegawai d where d.satkerja=a.satkerja) as t_keluarga,
                        (select sum(tistri+tanak+gapok) as jumlah from pegawai d where d.satkerja=a.satkerja) as Jumlah
                        from satkerja a where a.satkerja not in('001','003','002') " ;
                $j_pegawai = 0;
                $j_gapok = 0;
                $j_keluarga = 0;
                $j_jumlah = 0;
                $j_askes =0;
                $askes = $this->db->query($sql)->result();
                foreach ($askes as $row){
                        $no++;
                        $n_peg = $row->jml_peg;
                        $n_gapok = $row->j_gapok;
                        $n_gapok1 = number_format($n_gapok ,0,',','.');
                        $t_kel = $row->t_keluarga;
                        $t_kel1 = number_format($t_kel ,0,',','.');
                        $jumlah = $row->jumlah;
                        $jumlah1 = number_format($jumlah ,0,',','.');
                        $askes = $jumlah*(2/100);
                        $askes1 = number_format($askes ,0,',','.');

                        $j_pegawai = $j_pegawai + $n_peg;
                        $j_gapok = $j_gapok + $n_gapok;
                        $j_gapok1 = number_format($j_gapok,0,',','.');
                        $j_keluarga = $j_keluarga + $t_kel;
                        $j_keluarga1 = number_format($j_keluarga,0,',','.');
                        $j_jumlah = $j_jumlah + $jumlah;
                        $j_jumlah1 = number_format($j_jumlah,0,',','.');
                        $j_askes = $j_askes + $askes;
                        $j_askes1 = number_format($j_askes,0,',','.');

                        $pdf->SetFont('Arial','B',10);
                        $pdf->Cell(10,6,"$no",1,0,'R');  
                        $pdf->Cell(150,6,"$row->nm_satkerja",1,0,'L');
                        $pdf->Cell(25,6,"$row->jml_peg",1,0,'R');  
                        $pdf->Cell(25,6,"$n_gapok1",1,0,'R');  
                        $pdf->Cell(25,6,"$t_kel1",1,0,'R');
                        $pdf->Cell(25,6,"$jumlah1",1,0,'R');  
                        $pdf->Cell(25,6,"$askes1",1,0,'R');
                        $pdf->Cell(40,6,"",1,1);
                    }
                        $pdf->Cell(10,6,"",1,0);
                        $pdf->SetFont('Arial','B',10);
                        $pdf->Cell(150,6,"JUMLAH KESELURUHAN . . . . .",1,0,'L');
                        $pdf->Cell(25,6,"$j_pegawai",1,0,'R');  
                        $pdf->Cell(25,6,"$j_gapok1",1,0,'R');  
                        $pdf->Cell(25,6,"$j_keluarga1",1,0,'R');
                        $pdf->Cell(25,6,"$j_jumlah1",1,0,'R');  
                        $pdf->Cell(25,6,"$j_askes1",1,0,'R');
                        $pdf->Cell(40,6,"",1,1);
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
