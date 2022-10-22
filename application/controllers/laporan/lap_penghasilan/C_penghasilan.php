<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_penghasilan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('laporan/lap_penghasilan/M_penghasilan');
	}

	function _mpdf($judul='',$isi='',$lMargin=10,$rMargin=10,$font=10,$orientasi) {
        
       	ini_set("memory_limit","-1");
        $this->load->library('M_pdf');
        $mpdf = new m_pdf('', 'Letter-L');
        $pdfFilePath = "output_pdf_name.pdf";
        $mpdf->pdf->SetFooter('Printed Simgaji on @ {DATE j-m-Y H:i:s} || Page {PAGENO} of {nb}');
        $mpdf->pdf->AddPage($orientasi);
        if (!empty($judul)) $mpdf->pdf->writeHTML($judul);
        $mpdf->pdf->WriteHTML($isi);         
        $mpdf->pdf->Output();

    }

	public function index()
	{	
		$data = array(
			'page'	 	=> 'Surat Keterangan Penghasilan',
			'judul'		=> 'Surat Keterangan Penghasilan',
			'deskripsi'	=> 'Surat Keterangan Penghasilan'
		);

		$this->template->views('laporan/lap_penghasilan/V_penghasilan', $data);
	}
	
	public function  tanggal_balik($tgl){
		/*$tanggal  =  substr($tgl,0,2);
		$bulan  = substr($tgl,3,2);
		$tahun  =  substr($tgl,6,4);
		return  $tahun.'-'.$bulan.'-'.$tanggal;*/
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	 
		$xtgl 	= substr($tgl, 0, 2);
		$xbulan 	= substr($tgl, 3, 2);
		$xtahun  = substr($tgl, 6, 4);
	 
		$result = $xtgl . " " . $BulanIndo[(int)$xbulan-1] . " ". $xtahun;		
		return($result);

	}
	
	function  tanggal_format_indonesia($tgl){
            
        $tanggal  = explode('-',$tgl); 
        $bulan  = $this->getBulanIndo($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;

    }
	
	function  getBulanIndo($bln){
        switch  ($bln){
        case  01:
        return  "Januari";
        break;
        case  02:
        return  "Februari";
        break;
        case  03:
        return  "Maret";
        break;
        case  04:
        return  "April";
        break;
        case  05:
        return  "Mei";
        break;
        case  06:
        return  "Juni";
        break;
        case  07:
        return  "Juli";
        break;
        case  08:
        return  "Agustus";
        break;
        case  09:
        return  "September";
        break;
        case  10:
        return  "Oktober";
        break;
        case  11:
        return  "November";
        break;
        case  12:
        return  "Desember";
        break;
		}
    }

	public function getConfig()
	{
		return $this->M_penghasilan->getConfig();
	}

	public function getBulan()
	{
		echo $this->M_penghasilan->getBulan();
	}

	public function getTahun()
	{
		echo $this->M_penghasilan->getTahun();
	}

	public function getSkpd()
	{
		echo $this->M_penghasilan->getSkpd(); 
	}

	public function getPangkat()
	{
		echo $this->M_penghasilan->getPangkat(); 
	}

		public function getpenghasilan()
	{
		echo $this->M_penghasilan->getpenghasilan(); 
	}

	public function getUnitSkpd()
	{
		$param = $this->uri->segment(5);
		echo $this->M_penghasilan->getUnitSkpd($param);
	}

	public function cetakLaporan()
	{
		$config = $this->getConfig();
		$kota	= strtoupper($config['nm_daerah']);
		$jenisCetak = $this->input->get('jenisCetak');
		$tgl_cetak = $this->tanggal_balik($this->input->get('tgl_cetak'));

		$nama = $this->input->get('nama');
		$nip = $this->input->get('nip');

		$bulan = $this->getBulanIndo($this->input->get('bulan_tglcetak'));
		$pangkat = $this->input->get('pangkat');
		$gapok = $this->input->get('gapok');
		
		$data = array(
			'nm_kab'	 	=> strtoupper($config['nm_daerah'])
		);


		$bluePrint = $this->M_penghasilan->cetakLaporan($data);
		$nippa = $bluePrint[0]['nippa'];
		$namapa = $bluePrint[0]['namapa'];
		$nipbk = $bluePrint[1]['nipbk'];
		$namabk = $bluePrint[1]['namabk'];

		$cRet ='';
       		 $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
                    <tr><td align=\"left\" style=\"font-size:20px;border-collapse:collapse;\"><strong>DEPARTEMEN DALAM NEGERI </strong></td></tr>
                    <tr><td align=\"left\" style=\"font-size:10px;border-collapse:collapse;\"><strong>KEPALA DAERAH/WAKIL KDH KABUPATEN ASMAT</strong></td></tr>
                    <tr><td align=\"center\"><strong>SURAT KETERANGAN PENGHASILAN</strong></td></tr>                              
                    <tr><td align=\"center\" style=\"font-size:11px;border-collapse:collapse;\"><b>Bulan : $bulan 2018</b></td></tr>    
                    <tr><td align=\"left\">Menerangkan bahwa pemegang surat ini :</td></tr>

                  </table>";

               $cRet .="<table style=\"font-size:12px;border-collapse:collapse;\" width=\"100%\" align=\"left\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
            
                     <tr>
						<td align=\"left\" width=\"9%\"><b>Nama</b></td>                    
						<td align=\"center\" width=\"1%\">:</td>
						<td align=\"left\" width=\"80%\"><b>$nama</b></td>
					</tr>
                    <tr>
						<td align=\"left\" width=\"3%\"><b>Nip</b></td>                    
						<td align=\"center\" width=\"1%\">:</td>
						<td align=\"left\" width=\"80%\"><b>$nip</b></td>
					</tr>
                    <tr>
						<td align=\"left\" width=\"3%\"><b>Pangkat<b></td>                    
						<td align=\"center\" width=\"1%\">:</td>
						<td align=\"left\" width=\"80%\"><b>$pangkat</b></td>
					</tr>
					<tr>
						<td align=\"left\" width=\"3%\"><b>Gaji Pokok<b></td>                    
						<td align=\"center\" width=\"1%\">:</td>
						<td align=\"left\" width=\"80%\"><b>Rp.&nbsp;&nbsp;".number_format($gapok,2,',','.')."</b></td>
					</tr>
 

                  </table>";
              $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
  					<tr>
						<tr><td align=\"left\"><strong>I. GAJI : </strong></td></tr>
					</tr>
  			      </table>";

  			  $sql = "SELECT * from pegawai where nip='$nip'";
			        $query = $this->db->query($sql);
			        $i = 0;
			        $totalsel = 0;
			        foreach ($query->result() as $row) {
			                
							$i++;
			                $gapok         =$row->gapok;
			                $istri       =$row->tistri;
			                $anak         =$row->tanak;
			                $Fungsional         =$row->tfung;
			                $Tunjangan_umum         =$row->tstruk;
			                $Tunjangan_irja         =$row->papua;
			                $pengabdian         =$row->tdt;
			                $beras         =$row->beras;
			                $pph         =$row->pph;
			                $bulat         =$row->bulat;
			                $tkespeg         =$row->tkespeg;
			                $bruto = $row->bruto;
			                $iwp         =$row->iwp;
			                $tabungan         =$row->tabungan;
			                $lain         =$row->lain;
			                $disc         =$row->disc;
			                $netto = $row->netto;


			              $cRet .="<table style=\"font-size:11px;border-collapse:collapse;\" width=\"50%\" align=\"left\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
			                   
			                   <tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>    
									<td align=\"left\" width=\"70%\">- Gaji Pokok </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($gapok,2,',','.')."</td>               
								</tr>
			                    <tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Istri/Suami </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($istri,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Anak </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($anak,2,',','.')."</td>
								</tr>
								 <tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Fungsional </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($Fungsional,2,',','.').";</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Umum Non jabatan </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($Tunjangan_umu,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Irja/Tim-tim </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($Tunjangan_irja,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Pengabdian </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($pengabdian,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Beras </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($beras,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Khusus Pajak </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($pph,2,',','.')."</td>
								</tr>					
			 					<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Pembulatan </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($bulat,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Tunjangan Akses </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($tkespeg,2,',','.')."</td>
								</tr>	
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"center\" width=\"70%\"><b>- Gaji Kotor </b></td>                    
									<td align=\"left\" width=\"2%\"><b>:Rp.</b></td>
									<td align=\"right\" width=\"30%\"><b>".number_format($bruto,2,',','.')."</b></td>
								</tr>				                 

			                  </table>";

			               $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
			  					<tr>
									<tr><td align=\"left\"><strong>II.  Potongan-Potongan : </strong></td></tr>
								</tr>
			  			      </table>";


			               $cRet .="<table style=\"font-size:11px;border-collapse:collapse;\" width=\"50%\" align=\"left\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
			                   
			                   <tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>    
									<td align=\"left\" width=\"70%\">- Potongan FPK 10%  </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($iwp,2,',','.')."</td>               
								</tr>
			                    <tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Potongan Uang Beras </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($beras,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Sewa Rumah Dinas/Taperum </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($tabungan,2,',','.')."</td>
								</tr>
								 <tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- PPH Pasal 21 </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($pph,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Potongan Lain-Lain </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($lain,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"left\" width=\"70%\">- Utang Akses </td>                    
									<td align=\"left\" width=\"2%\">:Rp.</td>
									<td align=\"right\" width=\"30%\">".number_format($tkespeg,2,',','.')."</td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"center\" width=\"70%\"><b>- Total Potongan </b></td>                    
									<td align=\"left\" width=\"2%\"><b>:Rp.</b></td>
									<td align=\"right\" width=\"30%\"><b>".number_format($disc,2,',','.')."</b></td>
								</tr>
								<tr>
									<td align=\"center\" width=\"10%\">&nbsp;</td>                    
									<td align=\"center\" width=\"70%\"><b>- Gaji Bersih </b></td>                    
									<td align=\"left\" width=\"2%\"><b>:Rp.</b></td>
									<td align=\"right\" width=\"30%\"><b>".number_format($netto,2,',','.')."</b></td>
								</tr>		
								
			                  </table>";
 				}

               $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
  					<tr>
						<tr><td align=\"left\">Dengan huruf :</td></tr>
					</tr>
  			      </table>";


		      
		      $cRet .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
                    <tr>
						<td align=\"center\" width=\"25%\">&nbsp;</td>                    
						<td align=\"center\" width=\"25%\">&nbsp;</td>
						<td align=\"center\" width=\"25%\"><br>Agats,$tgl_cetak </br></td>
					</tr>
                    <tr>
						<td align=\"center\" width=\"25%\">KEPALA DAERAH/WAKIL KDH KABUPATEN ASMAT</td>                    
						<td align=\"center\" width=\"25%\">&nbsp;</td>
						<td align=\"center\" width=\"25%\">PEMBUAT DAFTAR GAJI</td>
					</tr>
                    <tr>
						<td align=\"center\" width=\"25%\">&nbsp;</td>                    
						<td align=\"center\" width=\"25%\">&nbsp;</td>
						<td align=\"center\" width=\"25%\">&nbsp;</td>
					</tr>
                    <tr>
                        <td align=\"center\" width=\"25%\">&nbsp;</td>                    
						<td align=\"center\" width=\"25%\">&nbsp;</td>
						<td align=\"center\" width=\"25%\">&nbsp;</td>
					</tr>                              
                    <tr>
						<td align=\"center\" width=\"25%\">ELISA KAMBU</td>                    
						<td align=\"center\" width=\"25%\">&nbsp;</td>
						<td align=\"center\" width=\"25%\"><br></br>NIP. </td>
					</tr>                              
                  </table>";

		        $data['prev']= $cRet;
		        $test = str_replace(str_split('\\/:*?"<>|,'), ' ', $jenisCetak);
		        $judul  = 'Surat Keterangan Penghasilan' .'-'. $test;
		        // echo $judul;
		        // echo $data['tipeCetakan'];
		        switch ($data['tipeCetakan']) {
		        	case 0:
		        		$this->_mpdf('',$cRet,10,10,10,'P');
		        		break;
		        	case 1:
		        		header("Cache-Control: no-cache, no-store, must-revalidate");
			            header("Content-Type: application/vnd.ms-excel");
			            header("Content-Disposition: attachment; filename= $judul.xlsx");
			            $this->load->view('transaksi/excel', $data);
			            break;
	        		case 2:
	        			header("Cache-Control: no-cache, no-store, must-revalidate");
			            header("Content-Type: application/vnd.ms-word");
			            header("Content-Disposition: attachment; filename= $judul.doc");
			           	$this->load->view('transaksi/excel', $data);
	        			break;
		        	default:
		        		echo "Error";
		        		break;
		        }

	}
	
	/*
	public function cetakLaporan()
	{
		$config = $this->getConfig();
		$kota	= strtoupper($config['nm_daerah']);
		$jenisCetak = $this->input->get('jenisCetak');
		$tgl_cetak = $this->input->get('tglcetak');
		$tahun_1 = $this->input->get('tahun_1');
		$tahun_2 = $this->input->get('tahun_2');
		$skpd = $this->input->get('skpd');
		$nm_skpd = $this->input->get('nmskpd');
		$bulan = $this->input->get('bulan');
		$tgl_oleh = $this->tanggal_balik($this->input->get('tgl_oleh'));
		$tgl = $this->tanggal_balik($tgl_oleh);
		$tahun = $this->input->get('tahun');
		$unit_skpd = $this->input->get('unit_skpd');
		$nm_unit_skpd = $this->input->get('nm_skpd_unit');
		
		$data = array(
			'nm_kab'	 	=> strtoupper($config['nm_daerah']),
			'kota'			=> $kota,
			'logo' 			=> $config['logo'],
			'tipeCetakan' 	=> $this->input->get('tipeCetakan'),
			'skpd' 			=> $skpd,
			'nm_skpd'		=> $nm_skpd,
			'bulan'			=> $bulan,
			'tgl_oleh'		=> $this->tanggal_balik($this->input->get('tgl_oleh')),
			'tahun' 		=> $tahun,
			'tahun_1'		=> $tahun_1,
			'tahun_2'		=> $tahun_2,
			'jenisCetak'	=> $jenisCetak,
			'tgl_cetak'		=> $tgl_cetak,

		);

		// echo $data['tipeCetakan'];

		$bluePrint = $this->M_kibb->cetakLaporan($data);
		$nippa = $bluePrint[0]['nippa'];
		$namapa = $bluePrint[0]['namapa'];
		$nipbk = $bluePrint[1]['nipbk'];
		$namabk = $bluePrint[1]['namabk'];

		$cRet ='';
        $cRet .= "
        		<table style=\"border-collapse:collapse;\" width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
            		<tr>
                		<td></td>
						<img src=\"".FCPATH."/uploads/msm.png\" width=\"80px\" height=\"60px\" alt=\"\" />
                		<td align=\"center\" colspan=\"13\" style=\"font-size:14px;border: solid 1px white;\"><B>KARTU INVENTARIS BARANG (KIB) B<br>PERALATAN DAN MESIN</B></td>
            		</tr><BR/><BR/><BR/>
        		</table>
        		";
        $cRet .="
        		<table style=\"border-collapse:collapse;\" width=\"90%\" align=\"left\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
          
		if ( $skpd <> '' )
		{ 
       		$cRet .="
    	    	<tr>
        	    	<td align=\"left\" style=\"font-size:13px;\" width =\"10%\" >&ensp;&ensp;SKPD</td>
            		<td align=\"left\" style=\"font-size:13px;\">:<B> $skpd  $nm_skpd</B></td>
        		</tr>";
		}	 

		if ( $jenisCetak == '1' )
		{    
    		$cRet .=" 
    			<tr>
            		<td align=\"left\" style=\"font-size:13px;\">&ensp;&ensp;UNIT</td>
            		<td align=\"left\" style=\"font-size:13px;\">:<B> $unit_skpd  $nm_unit_skpd</B></td>
				</tr>";
    	}

		$cRet .="
			<tr>
               	<td align=\"left\" style=\"font-size:13px;\">&ensp;&ensp;KOTA</td>
               	<td align=\"left\" style=\"font-size:13px;\">: $kota</td>
           	</tr>";

        if( $jenisCetak == 0 || $jenisCetak == 1 )
        {
            $cRet .="
    			<tr>
            		<td align=\"left\" style=\"font-size:13px;\">&ensp;&ensp;PERIODE</td>
            		<td align=\"left\" style=\"font-size:13px;\">: Sampai Dengan ".$this->tanggal_format_indonesia($tgl_oleh)."</td>
        		</tr>";
        }
        else 
        {
           if ($tahun_1 != $tahun_2){
				$cRet .="
        		<tr>
	               <td align=\"left\" style=\"font-size:13px;\">&ensp;&ensp;PERIODE</td>
            		<td align=\"left\" style=\"font-size:13px;\">: Tahun $tahun_1 s/d Tahun $tahun_2</td>
        		</tr>";
			} else {
				$cRet .="
        		<tr>
	               <td align=\"left\" style=\"font-size:13px;\">&ensp;&ensp;PERIODE</td>
            		<td align=\"left\" style=\"font-size:13px;\">: Tahun $tahun_1</td>
        		</tr>";
			}
        }
		if ($jenisCetak == 0){
			$where = "WHERE a.kd_skpd = '$skpd' and tgl_reg <= '$tgl_oleh'";
		} else if ($jenisCetak == 1) {
			$where = "WHERE a.kd_skpd = '$skpd' and tgl_reg <= '$tgl_oleh' and kd_unit = '$unit_skdp'";
		} else {
			$where = "WHERE a.kd_skpd = '$skpd' and a.tahun between '$tahun_1' and '$tahun_2'";
		}
       	$cRet .="</table>";
		$cRet .="
				<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
                	<thead>
                		<tr>
                    		<td align=\"left\" colspan=\"16\" style=\"font-size:12px;border: solid 1px white;border-bottom:solid 1px black;\">&ensp;</td>
        		        </tr>
                	</thead>
                		<tr>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\" width=\"250px\">No</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Kode Barang</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Nama Barang</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">No. Register</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Merk/Tipe</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Ukuran/CC</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Bahan</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Tahun</td>
							<td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"5\" style=\"font-size:12px\">Nomor</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Asal Usul</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Harga</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"2\" style=\"font-size:12px\">Keterangan</td>
                		</tr>
                		<tr>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"1\" style=\"font-size:12px\">Pabrik</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"1\" style=\"font-size:12px\">Rangka</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"1\" style=\"font-size:12px\">Mesin</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"1\" style=\"font-size:12px\">Polisi</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" rowspan=\"1\" style=\"font-size:12px\">BPKB</td>
                		</tr>
                		<tr></tr>
                		<tr>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"3%\" style=\"font-size:10px\">1</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"5%\" style=\"font-size:10px\">2</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"10%\" style=\"font-size:10px\">3</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"5%\" style=\"font-size:10px\">4</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"5%\" style=\"font-size:10px\">5</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"3%\" style=\"font-size:10px\">6</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"3%\" style=\"font-size:10px\">7</td>
							<td bgcolor=\"#CCCCCC\" align=\"center\" width =\"3%\" style=\"font-size:10px\">8</td>
							<td bgcolor=\"#CCCCCC\" align=\"center\" width =\"7%\" style=\"font-size:10px\">9</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"5%\" style=\"font-size:10px\">10</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"5%\" style=\"font-size:10px\">11</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"3%\" style=\"font-size:10px\">12</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"3%\" style=\"font-size:10px\">13</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"5%\" style=\"font-size:10px\">14</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"5%\" style=\"font-size:10px\">15</td>
		                    <td bgcolor=\"#CCCCCC\" align=\"center\" width =\"10%\" style=\"font-size:10px\">16</td>
                		</tr>";
						
        			$sql = "SELECT
							a.kd_brg,
							b.uraian as nm_brg,
							a.no_reg,
							a.merek,
							a.tipe,
							d.nm_bahan,
							a.tahun_produksi,
							a.pabrik,
							a.no_rangka,
							a.no_mesin,
							a.no_polisi,
							a.no_bpkb,
							c.cara_peroleh  as asal,
							a.nilai,
							a.keterangan
							
						FROM
							transaksi.trkib_b a
						LEFT JOIN mbarang b ON a.kd_brg = b.kd_brg
						LEFT JOIN cara_peroleh c ON a.asal = c.kd_cr_oleh
						LEFT JOIN mbahan d ON a.kd_bahan = d.kd_bahan
						$where
						;";
			        $query = $this->db->query($sql);
			        $i = 0;
			        $totalsel = 0;
			        foreach ($query->result() as $row) {
			                
							$i++;
			                $kd_brg         =$row->kd_brg;
			                $nm_brg         =$row->nm_brg;
			                $no_reg         =$row->no_reg;
			                $merek     =$row->merek;
			                $tipe     =$row->tipe;
			                $nm_bahan         =$row->nm_bahan;
			                $tahun          =$row->tahun_produksi;
			                $pabrik          =$row->pabrik;
			                $no_rangka           =$row->no_rangka;
			                $no_mesin           =$row->no_mesin;
			                $no_polisi           =$row->no_polisi;
			                $no_bpkb           =$row->no_bpkb;
			                $asal           =$row->asal;
			                $nilai          =$row->nilai;
			                $keterangan     =$row->keterangan;
							$totalsel = $totalsel + $nilai;
			                $cRet .="
			                    <tr>
			                        <td align=\"center\" style=\"font-size:11px\">$i</td>
			                        <td align=\"left\" style=\"font-size:11px\">$kd_brg</td>
			                        <td align=\"left\" style=\"font-size:11px\">$nm_brg</td>
			                        <td align=\"left\" style=\"font-size:11px\">$no_reg</td>
			                        <td align=\"center\" style=\"font-size:11px\">$merek</td>
			                        <td align=\"center\" style=\"font-size:11px\">$tipe</td>
			                        <td align=\"center\" style=\"font-size:11px\">$nm_bahan</td>
			                        <td align=\"left\" style=\"font-size:11px\">$tahun</td>
			                        <td align=\"left\" style=\"font-size:11px\">$pabrik</td>
			                        <td align=\"left\" style=\"font-size:11px\">$no_rangka</td>
			                        <td align=\"left\" style=\"font-size:11px\">$no_mesin</td>
			                        <td align=\"left\" style=\"font-size:11px\">$no_polisi</td>
			                        <td align=\"left\" style=\"font-size:11px\">$no_bpkb</td>
			                        <td align=\"left\" style=\"font-size:11px\">$asal</td>
			                        <td align=\"left\" style=\"font-size:11px\">".number_format($nilai,2,',','.')."</td>
			                        <td align=\"left\" style=\"font-size:11px\">$keterangan</td>
			                    </tr>";
			            
			    	}
			    	$cRet .="
						<tr>
			                <td bgcolor=\"#CCCCCC\" colspan=\"14\" align=\"center\" width =\"2%\" style=\"font-size:11px\">Jumlah</td>
			                <td bgcolor=\"#CCCCCC\" align=\"right\" width =\"5%\" style=\"font-size:11px\">".number_format($totalsel,2,',','.')."</td>
			                <td bgcolor=\"#CCCCCC\" align=\"left\" width =\"15%\" style=\"font-size:11px\"></td>
			            </tr>";

				
        		
        		$cRet .="</table>"; 
		        $cRet.="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
		            <tr>
		                <td><td>
		                <td align=\"center\" colspan=\"7\" style=\"font-size:10px\"></td>
		            </tr>
		                <br/><br/>
		            <tr>
		                <td><td>
		                <td colspan=\"5\"></td>
		                <td align=\"center\" style=\"font-size:11px\">$kota, $tgl_cetak</td>
		            </tr>
		            <tr>
		                <td><td>
		                <td align=\"center\" style=\"font-size:11px\">&ensp;&ensp;&ensp;&ensp;MENGETAHUI</td>
		                <td colspan=\"2\"></td>
		                <td colspan=\"3\"></td>
		            </tr>
		                <Tr></Tr><Tr></Tr>
		            <tr>
		                <td><td>
		                <td align=\"center\" style=\"font-size:11px\">&ensp;&ensp;&ensp;&ensp;KEPALA $nm_skpd</td>
		                <td colspan=\"2\"></td>
		                <td colspan=\"2\"></td>
		                <td align=\"center\" style=\"font-size:11px\">PENGURUS BARANG</td>          
		            </tr>
		            <tr>
		                <td><td>
		                <td align=\"center\" colspan=\"7\" style=\"font-size:11px\" height=\"50\"></td>
		            </tr>
		            <tr>
		                <td><td>
		                <td align=\"center\" style=\"font-size:11px\">&ensp;&ensp;&ensp;&ensp;(<u> .$namapa </u>)</td>
		                <td colspan=\"2\"></td>
		                <td colspan=\"2\"></td>
		                <td align=\"center\" style=\"font-size:11px\">(<u> $namabk </u>)</td>
		            </tr>
		            <tr>
		                <td><td>
		                <td align=\"center\" style=\"font-size:11px\">&ensp;&ensp;&ensp;&ensp;&ensp;NIP. $nippa </td>
		                <td colspan=\"2\"></td>
		                <td colspan=\"2\"></td>
		                <td align=\"center\" style=\"font-size:11px\">&ensp;NIP. $nipbk</td>
		            </tr>";
		            
		        $cRet .=       " </table>";
		        $data['prev']= $cRet;
		        $test = str_replace(str_split('\\/:*?"<>|,'), ' ', $nm_skpd);
		        $judul  = 'Laporan KIB B' .'-'. $test;
		        // echo $judul;
		        // echo $data['tipeCetakan'];
		        switch ($data['tipeCetakan']) {
		        	case 0:
		        		$this->_mpdf('',$cRet,10,10,10,'L');
		        		break;
		        	case 1:
		        		header("Cache-Control: no-cache, no-store, must-revalidate");
			            header("Content-Type: application/vnd.ms-excel");
			            header("Content-Disposition: attachment; filename= $judul.xlsx");
			            $this->load->view('transaksi/excel', $data);
			            break;
	        		case 2:
	        			header("Cache-Control: no-cache, no-store, must-revalidate");
			            header("Content-Type: application/vnd.ms-word");
			            header("Content-Disposition: attachment; filename= $judul.doc");
			           	$this->load->view('transaksi/excel', $data);
	        			break;
		        	default:
		        		echo "Error";
		        		break;
		        }

	}*/

	public function cetakLaporan2()
	{
		$skpd = $this->input->get('_skpd');
		echo $skpd;
		$cRet ='';
        $cRet .= "
        		<table style=\"border-collapse:collapse;\" width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
            		<tr>
                		<td></td>
						<img src=\"".FCPATH."/data/100.jpg\" width=\"60px\" height=\"60px\" alt=\"\" />
                		<td align=\"center\" colspan=\"13\" style=\"font-size:14px;border: solid 1px white;\"><B>KARTU INVENTARIS BARANG (KIB) A<br>TANAH</B> $skpd uyyt77</td>
            		</tr><BR/><BR/><BR/>
        		</table>
        		";
        
       	$cRet .="</table>";
		
		        $data['prev']= $cRet;
		        //$test = str_replace(str_split('\\/:*?"<>|,'), ' ', $nm_skpd);
		        $judul  = 'Laporan KIB B';
		        // echo $judul;
		        // echo $data['tipeCetakan'];
				$this->_mpdf('',$cRet,10,10,10,'L');
		        switch ($data['tipeCetakan']) {
		        	case 0:
		        		$this->_mpdf('',$cRet,10,10,10,'L');
		        		break;
		        	case 1:
		        		header("Cache-Control: no-cache, no-store, must-revalidate");
			            header("Content-Type: application/vnd.ms-excel");
			            header("Content-Disposition: attachment; filename= $judul.xlsx");
			            $this->load->view('transaksi/excel', $data);
			            break;
	        		case 2:
	        			header("Cache-Control: no-cache, no-store, must-revalidate");
			            header("Content-Type: application/vnd.ms-word");
			            header("Content-Disposition: attachment; filename= $judul.doc");
			           	$this->load->view('transaksi/excel', $data);
	        			break;
		        	default:
		        		echo "Error";
		        		break;
		        }

	}



}

/* End of file C_kib_b.php */
/* Location: ./application/controllers/laporan/C_kib_b.php */
