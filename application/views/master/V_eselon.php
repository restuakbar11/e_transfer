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
    <div id="dlg" class="easyui-dialog" style="width:500px" closed="true" buttons="#dlg-buttons">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <div style="margin-bottom:10px">
                <input id="eselon" type="text" name="eselon" class="easyui-textbox" label="Eselon:" style="width:50%;">
            </div>
            <div style="margin-bottom:10px">
                <input id="nm_eselon" name="nm_eselon" class="easyui-textbox" data-options="required:true" label="Nama Eselon:" style="width:100%">
            </div>
			<div style="margin-bottom:10px">
                <input id="jumlah" name="jumlah" class="easyui-textbox" data-options="required:true" label="Jumlah:" style="width:60%">
            </div>
			<div style="margin-bottom:10px">
                <input id="golongan" name="golongan" class="easyui-textbox" data-options="required:true" label="Golongan:" style="width:60%">
            </div>
        </form>
    </div>
	
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Simpan</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Batal</a>
    </div>
	
    <script type="text/javascript">
		$(document).ready(function(){
			//$("#golongan").textbox('textbox').attr('maxlength',4).textbox({disabled: true});
			$("#eselon").textbox('textbox').attr('maxlength',4);
			$("#nm_eselon").focus();
			$("#ubah").attr("disabled", "disabled");
			$("#hapus").attr("disabled", "disabled");
			var status = '';
			var ck = $("[type='checkbox']:checked").length;
			
				$('#dg').datagrid({
					title:'List Data <?php echo $page;?>',
					width:1000,
					height:350,
					rownumbers:true,
					remoteSort:false,
					nowrap:false,
					fitColumns:true,
					pagination:true,
					url:'<?php echo base_url(); ?>master/C_eselon/load_eselon',
					columns:[[
						{field:'eselon',title:'eselon',width:200,align:'center',sortable:true},
						{field:'nm_eselon',title:'nm_eselon',width:400,align:'left'},
						{field:'jumlah',title:'jumlah',width:400,align:'left'},
						{field:'golongan',title:'golongan',width:400,align:'left'},
						{field:'ck',title:'',width:60,align:'center',checkbox:true}
					]],
					onSelect:function(rowIndex,rowData){
						lcidx 			= rowIndex;
						eselon		= rowData.eselon;
						nm_eselon		= rowData.nm_eselon;
						jumlah		= rowData.jumlah;
						golongan		= rowData.golongan;
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
	
	$('#golongan').combogrid({
			panelWidth:500,  
	       	idField:'golongan',  
	       	textField:'golongan',  
	       	mode:'remote',
	       	url: '<?php echo base_url(); ?>master/C_golongan/load_golongan',
	       	columns:[[  
	           {field:'golongan',title:'golongan',width:100},  
	           {field:'nm_golongan',title:'nama golongan',width:400}    
	       	]],  
	       	onSelect:function(rowIndex,rowData){
			   lcstatus = 'tambah';
			   nmgolongan	= rowData.nm_golongan;         
			//  $('#nm_golongan').textbox('setValue',nmgolongan);
	       	}  
		}); 
		
		
				var url;
				function newUser(){
					$('#dlg').dialog('open').dialog('center').dialog('setTitle','Input Data <?php echo $page;?>');
					$('#fm').form('clear');
					status = 'add';
					//max_number();
				}		
				function editUser(){
					var row = $('#dg').datagrid('getSelected');
					status = 'edit';
					if (row){
						$('#dlg').dialog('open').dialog('setTitle','Edit Eselon');
						$('#fm').form('load',row);
					}
				}
				
				function cari(){
					var key = $('#keyword').val();
					    $(function(){
						 $('#dg').datagrid({
							url: '<?php echo base_url();?>master/C_eselon/load_eselon',
							queryParams:({key:key})
							});        
						 });
				}

				
				// function cekjumlah(){

				// 	var v = $('#dg').datagrid('getRows');
				// 	var ck = $("[type='checkbox']:checked").length;

				// 	if (v.length != 1) {
				// 		if ( ck == 0 ) {

				// 			$("#ubah").attr("disabled", "disabled");
				// 			$('#hapus').attr("disabled", "disabled");

				// 		} else if ( ck > 1 ) {

				// 			$("#ubah").attr("disabled", "disabled");
				// 			$("#hapus").removeAttr("disabled");

				// 		} else if ( ck == 1 ) {

				// 			$("#hapus").removeAttr("disabled");						
				// 			$("#ubah").removeAttr("disabled");						
				// 		}
				// 	} else {

				// 		if ( ck == 2 ) {
				// 			$("#hapus").removeAttr("disabled");						
				// 			$("#ubah").removeAttr("disabled");		
				// 		} else {
				// 			$("#ubah").attr("disabled", "disabled");
				// 			$('#hapus').attr("disabled", "disabled");
				// 		}

				// 	}
				// }
				
			/*	function max_number(){ 
					$.ajax({
						type: "POST",
						url: '<?php echo base_url(); ?>master/C_masakerja/max_number',
						data: ({table:'golongan',kolom:'golongan'}),
						dataType:"json",
						success:function(data){                                          
							$.each(data,function(i,n){                                    
								max = Number(n['no_urut'])+1; 
								nom = String('' + max).slice(-3);
								$('#golongan').textbox('setValue', nom);
								$('#tahun').textbox('setValue', '');
							});
						}
					}); 
				 }*/
				 
				function saveUser(){
					var eselon = $('#eselon').val();
					var nm_eselon = $('#nm_eselon').val();
					var jumlah = $('#jumlah').val();
					var golongan = $('#golongan').val();
					if(status=='add'){
					  $(document).ready(function(){
						  if(eselon=='' && nm_eselon=='' && jumlah=='' && golongan=='' ){
								iziToast.warning({
									title: 'Caution',
									message: 'Mohon Lengkapi inputan anda.!',
								});
						  }else{
								$.post('<?php echo base_url(); ?>master/C_eselon/simpan',
									{eselon:eselon,nm_eselon:nm_eselon,jumlah:jumlah,golongan:golongan},function(result){
									if (result.pesan){
										iziToast.success({
											title: 'OK',
											message: 'Data Berhasil Disimpan.!!',
										});
										$('#dg').datagrid('reload'); 
										max_number();
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
						$.post('<?php echo base_url(); ?>master/C_eselon/ubah',
									{eselon:eselon,nm_eselon:nm_eselon,jumlah:jumlah,golongan:golongan},function(result){
									if (result.pesan){
										iziToast.info({
											title: 'OK',
											message: 'Data Berhasil Dirubah.!!',
										});
										$('#dg').datagrid('reload'); 
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
					var ids = [];
					for(var i=0; i<row.length; i++){ids.push(row[i].eselon);}
					var eselon = ids.join('#');
					if (row){
						$.messager.confirm('Konfirmasi','Yakin ingin menghapus data ini?',function(r){
							if (r){
								$.post('<?php echo base_url(); ?>master/C_eselon/hapus',
									{eselon:eselon},function(result){
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