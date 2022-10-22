<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Skp extends CI_Controller {

    public function __construct()
    
    {
        parent::__construct();
        $this->load->model('Laporan/M_Skp');
        $this->load->library('pdf');
    }

    
    public function Cetak_skp(){
       if (isset($_POST['cetak'])) {
           echo "cetak per skpd";
       }
       elseif (isset($_POST['semua'])) {
           echo "cetak semua";
       }
    
    }
}
