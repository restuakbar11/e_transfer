<div class="row">
    <div class="col-md-12">  
	<div class="box-header">
		<div style="padding-left: 0px !important;" class="col-md-2">
			<button id="tambah"  type="button" class="btn btn-default" onClick="javascript:newUser();"><span><i class="fa fa-plus"></i></span> Tambah</button>  
			<div class="help-block with-errors" id="error_custom1"></div>
		</div>		
		<div style="padding-left: 0px !important;" class="col-md-2">
			<button id="ubah" type="button" class="btn btn-default" onClick="javascript:editUser();"><span><i class="fa fa-pencil"></i></span> Ubah</button>  
			<div class="help-block with-errors" id="error_custom1"></div>
		</div>	
		<div style="padding-left: 0px !important;" class="col-md-2">
			<button id="hapus" type="button" class="btn btn-default" onClick="javascript:destroyUser();"><span><i class="fa fa-trash"></i></span> Hapus</button>  
			<div class="help-block with-errors" id="error_custom1"></div>
		</div>
         <div class="col-md-8" align="right">
			<form class="navbar-right">
					<div class="input-group">
						<input type="text" value="" id="keyword" name="keyword" class="form-control" placeholder="">
						<span class="input-group-btn"><button type="button" class="btn btn-default" onClick="javascript:cari();"><i class="fa fa-search"></i></button></span>
					</div>
				</form>
		</div>
		
	</div>

    <table id="dg"></table>
    <div id="dlg" class="easyui-dialog" style="width:950px" closed="true" buttons="#dlg-buttons">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 20px">

			<table width="862" border="0">
			  <tr>
				<td width="21%"><label>Satuan Kerja :</label></td>
				<td width="32%"><input id="satkerja" name="satkerja" class="easyui-textbox" required="true"  style="width:20%"><input id="nm_satkerja" name="nm_satkerja" class="easyui-textbox" required="true"  style="width:80%"></td>  

			  </tr>
			  
			  <tr>
				<td><label>Unitkerja : </label></td>
				<td><input id="unit" name="unit" class="easyui-textbox" required="true"  style="width:30%"></td> 
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			   <tr>
				<td><label>Nama UnitKerja : </label></td>
				<td><input id="nm_unit" name="nm_unit" class="easyui-textbox" required="true"  style="width:80%"></td> 
				<td><label>Jabatan Bendahara I : </label></td>
				<td><input id="jab_bend" name="jab_bend" class="easyui-textbox" required="true"  style="width:100%"></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><label>Kota :</label> </td>
				<td><input id="kota" name="kota" class="easyui-textbox" required="true"  style="width:40%"></td> 
				<td><label>Nama Bendahara I : </label></td>
				<td><input id="nama_bend" name="nama_bend" class="easyui-textbox" required="true"  style="width:100%"></td> 
				<td>&nbsp;</td>
			  </tr>
			   <tr>
				<td><label>Jabatan Atasan Langsung :</label> </td>
				<td><input id="jab_atasan" name="jab_atasan" class="easyui-textbox" required="true"  style="width:70%"></td> 
				<td><label>Nip I : </label></td>
				<td><input id="nip_bend" name="nip_bend" class="easyui-textbox" required="true"  style="width:100%"></td> 
				<td>&nbsp;</td>
			  </tr>
			  	<tr>
				<td><label>An. Atasan Langsung : </label></td>
				<td><input id="jab_atasan2" name="jab_atasan2" class="easyui-textbox" required="true"  style="width:70%"></td> 
				<td><label>Jabatan Operator : </label></td>
				<td><input id="jab_operator" name="jab_operator" class="easyui-textbox" required="true"  style="width:100%"></td> 
				<td>&nbsp;</td>
			  </tr>
			   <tr>
				<td><label>Nama Atasan :</label></td>
				<td><input id="nama_atasan" name="nama_atasan" class="easyui-textbox" required="true"  style="width:70%"></td> 
				<td><label>Nama Operator : </label></td>
				<td><input id="nama_operator" name="nama_operator" class="easyui-textbox" required="true"  style="width:100%"></td> 
				<td>&nbsp;</td>
		 	  </tr>
				<tr>
				<td><label>Nip : </label></td>
				<td><input id="nip_atasan" name="nip_atasan" class="easyui-textbox" required="true"  style="width:70%"></td> 
				<td><label>Nip Operator : </label></td>
				<td><input id="nip_operator" name="nip_operator" class="easyui-textbox" required="true"  style="width:100%"></td> 
				<td>&nbsp;</td>
		 	  </tr>
			 
			 </table>
        </form>
    </div>

    <div id="dlg-buttons" >
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Simpan</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Batal</a>
    </div>
	
    <script type="text/javascript">
		$(document).ready(function(){
			$("#satkerja").textbox('textbox').attr('maxlength',10);
			$("#ubah").attr("disabled", "disabled");
			$("#hapus").attr("disabled", "disabled");
			var status = '';
				$('#dg').datagrid({
					title:'List Data <?php echo $page;?>',
					width:1000,
					height:350,
					rownumbers:true,
					remoteSort:false,
					nowrap:false,
					fitColumns:true,
					pagination:true,
					url:'<?php echo base_url(); ?>master/C_unitskpd/load_unit',
					columns:[[
						{field:'satkerja',title:'Satuan Kerja',width:200,align:'center',sortable:true},
						{field:'unit',title:'Unit Kerja',width:80,align:'left'},
						{field:'nm_unit',title:'Nama UnitKerja',width:400,align:'left'},
						{field:'ck',title:'',width:60,align:'center',checkbox:true}
					]],
					onSelect:function(rowIndex,rowData){
						lcidx 		= rowIndex;
						satkerja		= rowData.satkerja;				
						unit		= rowData.unit;
						nm_unit		= rowData.nm_unit;
						kota	= rowData.kota;
						jab_atasan	= rowData.jab_atasan;
						jab_atasan2	= rowData.jab_atasan2;
						nama_atasan	= rowData.nama_atasan;
						nip_atasan	= rowData.nip_atasan;
						jab_bend	= rowData.jab_bend;
						nama_bend	= rowData.nama_bend;
						nip_bend	= rowData.nip_bend;
						jab_operator	= rowData.jab_operator;
						nama_operator	= rowData.nama_operator;
						nip_operator	= rowData.nip_operator;
	
						cekjumlah();
						
					},
					onUncheck: function(index,row) {
						cekjumlah();
						
					},
					onCheck: function(index,row) {
					cekjumlah();
						
					},
					onUncheckAll:function(index,row){
						cekjumlah();
					},
					onCheckAll:function(index,row){
						cekjumlah();
					}
				}); 
			
							
 		$('#satkerja').combogrid({
			panelWidth:500,  
	       	idField:'satkerja',  
	       	textField:'satkerja',  
	       	mode:'remote',
	       	url: '<?php echo base_url(); ?>master/C_skpd/load_skpd',
	       	columns:[[  
	           {field:'satkerja',title:'satkerja',width:100},  
	           {field:'nm_satkerja',title:'nama satkerja',width:400}    
	       	]],  
	       	onSelect:function(rowIndex,rowData){
			   lcstatus = 'tambah';
			   nmsatkerja	= rowData.nm_satkerja;         
			  $('#nm_satkerja').textbox('setValue',nmsatkerja);
	       	}  
		}); 
		
		});
	
				var url;
				function newUser(){
					$('#dlg').dialog('open').dialog('center').dialog('setTitle','Input Data <?php echo $page;?>');
					$('#fm').form('clear');
					status = 'add';
				}		

	
				function editUser(){
					$('#nm_satkerja').val("disabled");
					var row = $('#dg').datagrid('getSelected');

					status = 'edit';
					if (row){
						$('#dlg').dialog('open').dialog('setTitle','Edit Data UnitKerja');
						
						$('#fm').form('load',row);
					}
				}
				
				function cari(){
					var key = $('#keyword').val();
					alert(key);
					    $(function(){
						 $('#dg').datagrid({
							url: '<?php echo base_url();?>master/C_unitskpd/load_unit',
							queryParams:({key:key})
							});        
						 });
				}

								 
				function saveUser(){
					var satkerja = $('#satkerja').val();
					var unit = $('#unit').val();
					var nm_unit = $('#nm_unit').val();
					var kota = $('#kota').val();
					var jab_atasan = $('#jab_atasan').val();
					var jab_atasan2 = $('#jab_atasan2').val();
					var nama_atasan = $('#nama_atasan').val();
					var nip_atasan = $('#nip_atasan').val();
					var jab_bend = $('#jab_bend').val();
					var nama_bend = $('#nama_bend').val();
					var nip_bend = $('#nip_bend').val();
					var jab_operator = $('#jab_operator').val();
					var nama_operator = $('#nama_operator').val();
					var nip_operator = $('#nip_operator').val();
					alert(satkerja);
					if(status=='add'){
					  $(document).ready(function(){
						  if( satkerja=='' && nmsatkerja==''){
								iziToast.warning({
									title: 'Caution',
									message: 'Mohon Lengkapi inputan anda.!',
								});
						  }else{
								$.post('<?php echo base_url(); ?>master/C_unitskpd/simpan',
									{satkerja:satkerja,unit:unit,nm_unit:nm_unit,kota:kota,
									jab_atasan:jab_atasan,jab_atasan2:jab_atasan2,nama_atasan:nama_atasan,
									nip_atasan:nip_atasan,jab_bend:jab_bend,nama_bend:nama_bend,
									nip_bend:nip_bend,jab_operator:jab_operator,nama_operator:nama_operator,
									nip_operator:nip_operator},function(result){
									if (result.pesan){
										iziToast.success({
											title: 'OK',
											message: 'Data Berhasil Disimpan.!!',
										});
										$('#dg').datagrid('reload'); 
										$('#dlg').dialog('close');
										$("#ubah").attr("disabled", "disabled");
										$("#hapus").attr("disabled", "disabled");
									} else {
										iziToast.error({
											title: 'Error',
											message: 'Data Gagal Disimpan.!',
										});
									}
								},'json');
						  }
						});
					}else{
						$.post('<?php echo base_url(); ?>master/C_unitskpd/ubah',
									{satkerja:satkerja,unit:unit,nm_unit:nm_unit,kota:kota,
									jab_atasan:jab_atasan,jab_atasan2:jab_atasan2,nama_atasan:nama_atasan,
									nip_atasan:nip_atasan,jab_bend:jab_bend,nama_bend:nama_bend,
									nip_bend:nip_bend,jab_operator:jab_operator,nama_operator:nama_operator,
									nip_operator:nip_operator},function(result){
									if (result.pesan){
										iziToast.info({
											title: 'OK',
											message: 'Data Berhasil Dirubah.!!',
										});
										$('#dg').datagrid('reload');
										$('#dlg').dialog('close');	
										$("#ubah").attr("disabled", "disabled");
										$("#hapus").attr("disabled", "disabled");								
									} else {
										iziToast.error({
											title: 'Error',
											message: 'Data Gagal Dirubah.!',
										});
									}
								},'json');
					}
				}
				
				function destroyUser(){
					var row = $('#dg').datagrid('getSelections');
					var ida = [];
					var ids = [];
					for(var i=0; i<row.length; i++){ids.push(row[i].unit);ids.push(row[i].satekrja);}
					var kd_skpd = ids.join('#');
					var kd_urusan = ids.join('#');
					if (row){
						$.messager.confirm('Konfirmasi','Yakin ingin menghapus data ini?',function(r){
							if (r){
								$.post('<?php echo base_url(); ?>master/C_unitskpd/hapus',
									{satkerja:satkerja,unit:unit},function(result){
									if (result.pesan){
										iziToast.info({
											title: 'OK',
											message: 'Data Berhasil Dihapus.!!',
										});
										$('#dg').datagrid('reload'); 
									} else {
										iziToast.error({
											title: 'Error',
											message: 'Data Gagal Dihapus.!',
										});
									}
								},'json');
							}
						});
					}
				} 
				
				
			</script>
	</div>
</div>	