<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_golongan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('master/M_golongan');
		$this->load->library('form_validation');        
		$this->load->helper(array('form', 'url'));
	}

	public function index()
	{
		$data['page'] 			= "Golongan";
		$data['judul'] 			= "Master Tabel Golongan";
		$data['deskripsi'] 		= "Golongan";
		$this->template->views('master/V_golongan', $data);
	}
	
	function load_golongan() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $key = $this->input->post('key');
		$where = '';
		$limit = "ORDER BY golongan ASC LIMIT $rows OFFSET $offset";
		if($key!=''){
		$where = "where upper(golongan) like upper('%$key%')";	
		$limit = "";	
		}
		
		$sql = "SELECT count(*) as tot from golongan $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
		
        $sql = "SELECT * from golongan $where $limit";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
            $row[] = array(
                        'id' => $ii,        
                        'golongan' => $resulte['golongan'],
                        'nm_golongan' => $resulte['nm_golongan'],
                        'tnpapua' => $resulte['tnpapua']					
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
	
	public function simpan(){
		$param  = $this->input->post();
		$sukses = $this->M_golongan->simpan($param);
			if($sukses){
				echo json_encode(array('pesan'=>true));
			}else {
				echo json_encode(array('pesan'=>false));
			}
	}
	
	public function ubah(){
		$param  = $this->input->post();
		$sukses = $this->M_golongan->ubah($param);
			if($sukses){
				echo json_encode(array('pesan'=>true));
			}else {
				echo json_encode(array('pesan'=>false));
			}
	}
	
	public function hapus(){
		$param  = $this->input->post();
		$sukses = $this->M_golongan->hapus($param);
			if($sukses){
				echo json_encode(array('pesan'=>true));
			}else{
				echo json_encode(array('pesan'=>false));
			}
	}
	
	function max_number(){
        $table = $this->input->post('table');
        $kolom = $this->input->post('kolom');
        $query1 = $this->db->query("SELECT MAX($kolom) AS kode FROM $table");  
        $result = array();
        foreach($query1->result_array() as $resulte)
        { 
            $result[] = array(      
                        'no_urut' => $resulte['kode']
                        );
        }
        echo json_encode($result);
	}


		
}
