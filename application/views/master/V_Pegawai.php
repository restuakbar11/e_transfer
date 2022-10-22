<div class="row">
	<div class="col-sm-12">
		<div class="box-header">
			<div style="padding-left: 0px !important;" class="col-sm-2">
				<button id="tambah"  type="button" class="btn btn-default" onClick="javascript:newUser();"><span><i class="fa fa-plus"></i></span> Tambah</button>  
				<div class="help-block with-errors" id="error_custom1"></div>
			</div>

			<div style="padding-left: 0px !important;" class="col-sm-2">
				<button id="detail"  type="button" class="btn btn-default" onClick="javascript:detail();"><span><i class="fa fa-info-circle"></i></span> Detail</button>  
				<div class="help-block with-errors" id="error_custom1"></div>
			</div>
			<div style="padding-left: 0px !important;" class="col-sm-2">
				<button id="hapus" type="button" class="btn btn-default" onClick="javascript:hapus();"><span><i class="fa fa-trash"></i></span> Hapus</button>  
				<div class="help-block with-errors" id="error_custom1"></div>
			</div>

	        <div class="col-sm-4 col-sm-offset-2" align="right">
				<form class="navbar-right">
					<div class="input-group">
						<input type="text" value="" id="keyword" name="keyword" class="form-control" style="width:100%;" placeholder="Ketik disini">
						<span class="input-group-btn"><button type="button" class="btn btn-default" onClick="javascript:cari();"><i class="fa fa-search"></i></button></span>
					</div>
				</form>
			</div>		 
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<table id="dg"></table>
	</div>
</div>


<script type="text/javascript">

	function newUser() {
		localStorage.setItem('status', 'tambah');
		window.location.href = '<?php echo site_url('master/C_Pegawai/add'); ?>';
	}

	function detail() {		
		localStorage.setItem('status', 'detail');
		localStorage.setItem('id',id);
		localStorage.setItem('nip',nip);
		localStorage.setItem('nip_lama',nip_lama);
		localStorage.setItem('nama',nama);		
		localStorage.setItem('nokartu',nokartu);
		localStorage.setItem('seks',seks);		
		localStorage.setItem('npwp',npwp);
		localStorage.setItem('kota',kota);
		localStorage.setItem('lahir',lahir);
		localStorage.setItem('agama',agama);
		localStorage.setItem('stskawin',stskawin);
		localStorage.setItem('anak',anak);
		localStorage.setItem('satkerja',satkerja);
		localStorage.setItem('nm_satkerja',nm_satkerja);
		localStorage.setItem('unit',unit);
		localStorage.setItem('nm_unit',nm_unit);
		localStorage.setItem('golongan',golongan);
		localStorage.setItem('nama_golongan',nama_golongan);
		localStorage.setItem('masa_tahun',masa_tahun);
		localStorage.setItem('masa_bulan',masa_bulan);
		localStorage.setItem('gapok',gapok);
		localStorage.setItem('gapok1',gapok1);
		localStorage.setItem('eselon',eselon);
		localStorage.setItem('tstruk',tstruk);
		localStorage.setItem('kd_fung',kd_fung);
		localStorage.setItem('tfung',tfung);
		localStorage.setItem('pensiun',pensiun);
		localStorage.setItem('stspegawai',stspegawai);
		localStorage.setItem('kdguru',kdguru);
		localStorage.setItem('sk_fung',sk_fung);
		localStorage.setItem('tdt',tdt);
		localStorage.setItem('kdbantu',kdbantu);
		localStorage.setItem('ket',ket);
		localStorage.setItem('rekening',rekening);
		localStorage.setItem('kd_beras',kd_beras);
		localStorage.setItem('sk_jab',sk_jab);
		localStorage.setItem('tmt_pns',tmt_pns);
		localStorage.setItem('tmt_pangkat',tmt_pangkat);
		localStorage.setItem('tmt_berkala',tmt_berkala);
		localStorage.setItem('sewa',sewa);
		localStorage.setItem('tunggakan',tunggakan);
		localStorage.setItem('tabungan',tabungan);
		localStorage.setItem('hutang',hutang);
		localStorage.setItem('lain',lain);
		localStorage.setItem('skorsing',skorsing);
		localStorage.setItem('kd_daerah',kd_daerah);
		//localStorage.setItem('photo',photo);		
		window.location.href = '<?php echo site_url('master/C_Pegawai/add'); ?>';
	}	

	$(document).ready(function() {
		$("#hapus").attr("disabled", "disabled");
		$("#detail").attr("disabled", "disabled");
		$('#dg').datagrid({
			width:1150,
			height:400,
			rownumbers:true,
			remoteSort:false,
			nowrap:false,
			fitColumns:true,
			pagination:true,
			url: '<?php echo base_url(); ?>master/C_Pegawai/load_header',
		    loadMsg:"Tunggu Sebentar....!!",
			columns:[[
				{field:'nip',title:'NIP',width:'20%',align:"left"},
				{field:'nama',title:'NAMA',width:'30%',align:"left"},
	    		{field:'nm_satkerja', title:'NAMA SKPD', width:'45%', align:"left"},
				{field:'ck',title:'',width:'5%',align:'center',checkbox:true}
			]],
			onSelect:function(rowIndex,rowData){
				id		    =rowData.id ;
				nip       	=rowData.nip ;
				nip_lama   	=rowData.nip_lama ;
				nama	    =rowData.nama ;				
				nokartu 	= rowData.nokartu ;	
				seks 		= rowData.seks ;		
				npwp 		= rowData.npwp;
				kota		=rowData.kota;
				lahir 		=rowData.lahir;
				agama		=rowData.agama;
				stskawin 	=rowData.stskawin;
				anak 		=rowData.anak;
				satkerja 	=rowData.satkerja;
				nm_satkerja =rowData.nm_satkerja;
				unit 		=rowData.unit;
				nm_unit 	=rowData.nm_unit;
				golongan 	=rowData.golongan;
				nama_golongan	=rowData.nama_golongan;
				masa_tahun 	=rowData.masa_tahun;
				masa_bulan 	=rowData.masa_bulan;
				gapok 		=rowData.gapok;
				gapok1 		=rowData.gapok1;
				eselon 		=rowData.eselon;
				tstruk 		=rowData.tstruk;
				kd_fung 	=rowData.kd_fung;
				tfung 		=rowData.tfung;
				pensiun 	=rowData.pensiun;
				stspegawai 	=rowData.stspegawai;
				kdguru 		=rowData.kdguru;
				sk_fung 	=rowData.sk_fung;
				tdt 		=rowData.tdt;
				kdbantu 	=rowData.kdbantu;
				ket 		=rowData.ket;
				rekening 	=rowData.rekening;
				kd_beras 	=rowData.kd_beras;
				sk_jab 		=rowData.sk_jab;
				tmt_pns 	=rowData.tmt_pns;
				tmt_pangkat =rowData.tmt_pangkat;
				tmt_berkala =rowData.tmt_berkala;
				sewa 		=rowData.sewa;
				tunggakan 	=rowData.tunggakan;
				tabungan 	=rowData.tabungan;
				hutang 		=rowData.hutang;
				lain 		=rowData.lain;
				skorsing 	=rowData.skorsing; 
				kd_daerah 	=rowData.kd_daerah; 
				//photo 		=rowData.photo; 
				cekjumlah();
			},
			onCheck: function(index, row) {
			cekjumlah();
			},
			onUncheck: function(index,row) {
			cekjumlah();
			},
			onCheckAll: function(row) {
			cekjumlah();
			},
			onUncheckAll: function(row) {
			cekjumlah();
					}
		}); 

	});
	
	function hapus() {
		var row = $('#dg').datagrid('getSelections');
		var ids = [];
		var idt = [];
		for(var i=0; i<row.length; i++){ids.push(row[i].nip);idt.push(row[i].nama);}
		var kode = ids.join('#');
		var nama = idt.join('#');
		if ( row ){
			$.messager.confirm('Konfirmasi','Yakin ingin menghapus data pegawai atas nama '+nama+' ?',function(r){
				if (r){
					$.post('<?php echo base_url(); ?>master/C_Pegawai/hapus',
						{nip:kode},function(result){
						if (result.pesan){
							iziToast.info({
								title: 'OK',
								message: 'Data Berhasil Dihapus.!!',
							});
							$('#dg').datagrid('reload'); 
							$("#ubah").attr("disabled", "disabled");
							$("#hapus").attr("disabled", "disabled");
						} else {
							iziToast.error({
								title: 'Error',
								message: 'Data Gagal Dihapus.!',
							});
							$("#ubah").attr("disabled", "disabled");
							$("#hapus").attr("disabled", "disabled");
						}
					},'json');
				}
			});
		}
	}
	
	function cari(){
		var key = $('#keyword').val();
			$(function(){
			 $('#dg').datagrid({
				url: '<?php echo base_url();?>master/C_Pegawai/load_header',
				queryParams:({key:key})
				});        
			 });
	}
    </script>