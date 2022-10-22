<form id="fm" method="post" novalidate style="margin:0;padding:10px 10px" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
             <div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>No. SPM</label></div>
                    <div class="col-sm-3"><input id="no_spm" maxlength="3" name="no_spm" type="text" class="easyui-textbox" style="width:50%;"></div>
					<div class="col-sm-6"><input id="no_spm1" name="no_spm1" type="text" class="easyui-textbox" style="width:50%; text-align: left;" readonly="true" disabled="disabled"></div>
                </div>
            </div>	
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Satkerja</label></div>
                    <div class="col-sm-3"><input id="satkerja" name="satkerja" type="text" class="easyui-textbox" style="width:80%;"></div>
					<div class="col-sm-6"><input id="nm_satkerja" name="nm_satkerja" type="text" class="easyui-textbox" style="width:100%;" readonly="true"></div>
                </div>
            </div>
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Para Pegawai</label></div>
                    <div class="col-sm-2">
                        <input id="para_pegawai" name="para_pegawai" type="text" class="easyui-textbox" style="width:80%;">
                    </div>
                </div>
            </div>		
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Nomor SPD</label></div>
                    <div class="col-sm-9">
                        <input id="no_spd" name="no_spd" type="text" class="easyui-textbox" style="width:100%;text-align:left;">
                    </div>
                </div>
            </div>
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>No. Rekening</label></div>
                    <div class="col-sm-9">
                        <input id="no_rekening" name="no_rekening" type="text" class="easyui-textbox" style="width:100%;text-align:left;">
                    </div>
                </div>
            </div>
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>NPWP</label></div>
                    <div class="col-sm-9">
                        <input id="npwp" name="npwp" type="text" class="easyui-textbox" style="width:100%;text-align:left;">
                    </div>
                </div>
            </div>
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Bayar Kepada</label></div>
                    <div class="col-sm-9">
                        <textarea id="bayar_kepada" name="bayar_kepada" class="form-control" style="width: 100%" disabled="true"></textarea>
                    </div>
                </div>
            </div>			 			          
        </div>
		<div class="col-md-6">
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Tanggal</label></div>
                    <div class="col-sm-6">
                        <div class="input-group" style="width:80%;">
                          <input id="tanggal" name="tanggal" type="text" class="form-control" style="width:100%;" >
                           <span class="input-group-addon" > <i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Golongan</label></div>
                    <div class="col-sm-3"><input id="golongan1" name="golongan1" type="text" class="easyui-textbox" style="width:50%;"></div>
					<div class="col-sm-2">S/D</div>
					<div class="col-sm-3"><span id="golongan2" name="golongan2" type="text" class="easyui-textbox" style="width:50%; text-align: center;"><span></div>
                </div>
            </div>
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>J. Belanja</label></div>
                    <div class="col-sm-2">
                        <input id="j_belanja" name="j_belanja" type="text" class="easyui-textbox" style="width:80%;">
                    </div>
                </div>
            </div>
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Nomor SPP</label></div>
                    <div class="col-sm-9">
                        <input id="no_spp" name="no_spp" type="text" class="easyui-textbox" style="width:100%;text-align:left;">
                    </div>
                </div>
            </div>
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Bank</label></div>
                    <div class="col-sm-9">
                        <input id="bank" name="bank" type="text" class="easyui-textbox" style="width:100%;text-align:left;">
                    </div>
                </div>
            </div>
			<div style="margin-bottom:10px" hidden="true">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"></div>
                    <div class="col-sm-9"></div>
                </div>
            </div> 
			<div style="margin-bottom:10px">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div class="col-sm-3" style="padding-top: 3px;"><label>Untuk</label></div>
                    <div class="col-sm-9">
					 	<textarea id="untuk" name="untuk" class="form-control" style="width:100%" disabled="true"></textarea>
                    </div>
                </div>
            </div>
		</div>
    </div>
</form>

<div style="padding-bottom: 20px;">
    <button type="button" class="btn btn-primary btn-lg btn-block" style="width:100%" onClick="javascript:savedetail();"><b>PROSES</b></button>
</div>

<table id="dg" name="dg"></table>
<div class="row" id="sum_show">
    <div class="col-md-4 text-right col-md-offset-4">
        <h3><span>Total : </span></h3>
    </div>
    <div class="col-md-4 text-right">
        <h3><span id="total_s1"></span></h3>
    </div>
</div>

<!-- 
<div id="dlg" class="easyui-dialog" style="width:70%;height:90%" closed="true" buttons="#dlg-buttons">
        <div class="row" style="width: 100%;height:90%">
            <div class="col-sm-12">               
            </div>            
        </div>
</div>

<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" onclick="savedetail()" style="width:90px">Tampung</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Kembali</a>
</div> 
-->


<div style="padding-top: 10px;" class="row">
    <div class="col-sm-2 col-sm-offset-4">
        <button type="button" class="btn btn-default btn-lg btn-block" onClick="javascript:saveData()">Simpan</button>
    </div>
    <div class="col-sm-2 col-sm-offset">
        <button type="button" class="btn btn-default btn-lg btn-block" onClick="javascript:back();">Kembali</button>
    </div>
	    <div id="progressFile" class="easyui-progressbar" style="width:50%;" hidden="true"></div>
</div>


<script type="text/javascript" src="<?php echo site_url('assets/easyui/numberFormat.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/easyui/autoCurrency.js') ?>"></script>
<script type="text/javascript">

$(document).ready(function() {
           $('#satkerja').combogrid({
				panelWidth:700,  
				idField:'satkerja',  
				textField:'satkerja',  
				url:'<?php echo base_url(); ?>transaksi/C_SPM/get_satker', 
				mode:'remote',
				columns:[[  
				   {field:'satkerja',title:'Kode',width:100,align:'center'},  
				   {field:'nm_satkerja',title:'Nama Satker',width:600}    
				]],
				onSelect:function(rowIndex,rowData){
				   satkerja = rowData.satkerja;
				   nm_satkerja = rowData.nm_satkerja;
				   $("#nm_satkerja").textbox('setValue',nm_satkerja);
				}
        	});
			
			$('#golongan1').combogrid({
				panelWidth:400,  
				idField:'id',  
				textField:'id',  
				url:'<?php echo base_url(); ?>transaksi/C_SPM/golongan1', 
				mode:'remote',
				columns:[[  
				   {field:'id',title:'Kode',width:100,align:'center'},  
				   {field:'nm_golongan',title:'Nama',width:300}    
				]],
				onSelect:function(rowIndex,rowData){
				   id1 = rowData.id;
				   nm_golongan1 = rowData.nm_golongan;
				}
        	});
			
			$('#golongan2').combogrid({
				panelWidth:400,  
				idField:'id',  
				textField:'id',  
				url:'<?php echo base_url(); ?>transaksi/C_SPM/golongan1', 
				mode:'remote',
				columns:[[  
				   {field:'id',title:'Kode',width:100,align:'center'},  
				   {field:'nm_golongan',title:'Nama',width:300}    
				]],
				onSelect:function(rowIndex,rowData){
				   id2 = rowData.id;
				   nm_golongan2 = rowData.nm_golongan;
				}
        	});
			
			$('#para_pegawai').combobox({           
				valueField:'kode',  
				textField:'kode',
				width:50,
				data:[{kode:'Y'},{kode:'T'}]
        	});
			
			$('#j_belanja').combobox({           
				valueField:'kode',  
				textField:'kode',
				width:50,
				data:[{kode:'1'},{kode:'2'}]
        	});
			
			$('#tanggal').datepicker({
              format: 'dd-mm-yyyy',
              autoclose: true
        	});

        	$('#tanggal').val(getToday());
		
		
        $('#dg').datagrid({
            idField:'id',
            width: '1150',
            height: '300',
            nowrap: true,
        pagination: true,
        rownumbers: true,
        fitColumns: true,
        singleSelect: true,
        remoteSort: true,  
        showFooter: true,           
            loadMsg: 'Tunggu Sebentar ... !',
            
            columns:[[
                {field:'kd_rek5', title:'Rekening', width:50, halign:"center",align:"left"},
				{field:'nm_rek5', title:'Nama Rekening', width:150, halign:"center",align:"left"},
				{field:'nilai', title:'Jumlah', width:50, halign:"center",align:"right"},
				{field:'kd_rek5_pot', title:'Potongan', width:50, halign:"center",align:"left"},
				{field:'nm_rek5_pot', title:'Nama Potongan', width:150, halign:"center",align:"left"},
				{field:'nilai_pot', title:'Jumlah', width:50, halign:"center",align:"right"}
            ]],
            onEndEdit:function(index,row){
            var ed = $(this).datagrid('getEditor', {
                index: index,
                field: 'no_spm'
                });
            },
            onBeforeEdit:function(index,row){
                row.editing = true;
                $(this).datagrid('refreshRow', index);
            },
            onAfterEdit:function(index,row){
                row.editing = false;
                $(this).datagrid('refreshRow', index);
            },
            onCancelEdit:function(index,row){
                row.editing = false;
                $(this).datagrid('refreshRow', index);
            }
        });
    });
	
	function load_detail(no_spm,satkerja) {
        $('#dg').datagrid({
            url:'<?php echo site_url('transaksi/C_SPM/load_detail') ?>',
            idField:'id',
            width: '1150',
            height: '300',
            nowrap: true,
        pagination: true,
        rownumbers: true,
        fitColumns: true,
        singleSelect: true,
        remoteSort: true,  
        queryParams:{no: no_spm, kode: satkerja},
            loadMsg: 'Tunggu Sebentar ... !',
            columns:[[
                {field:'kd_rek5', title:'Rekening', width:50, halign:"center",align:"left"},
				{field:'nm_rek5', title:'Nama Rekening', width:150, halign:"center",align:"left"},
				{field:'nilai', title:'Jumlah', width:50, halign:"center",align:"right"},
				{field:'kd_rek5_pot', title:'Potongan', width:50, halign:"center",align:"left"},
				{field:'nm_rek5_pot', title:'Nama Potongan', width:150, halign:"center",align:"left"},
				{field:'nilai_pot', title:'Jumlah', width:50, halign:"center",align:"right"}
            ]],
            onEndEdit:function(index,row){
            var ed = $(this).datagrid('getEditor', {
                index: index,
                field: 'no_spm'
                });
            },
            onBeforeEdit:function(index,row){
                row.editing = true;
                $(this).datagrid('refreshRow', index);
            },
            onAfterEdit:function(index,row){
                row.editing = false;
                $(this).datagrid('refreshRow', index);
            },
            onCancelEdit:function(index,row){
                row.editing = false;
                $(this).datagrid('refreshRow', index);
            }
        });
        
    }
	
	function savedetail(){    
        
        nosp2d     = $('#sp2d').val();
        tgl_sp2d   = $('#tgl_sp2d').val();
        nilaisp2d  = angka($('#nilaisp2d').val());
        keterangan = $('#keterangan').val();
        jml = $('#jml').val();
        hrg = $('#hrg').val();
        //tot = $('#total_dlg').val();
        
        if(konek!=1){
                kegi       = $('#kegi').val();
                kd_rek13   = $('#reke').val();    
        }else{
                kegi       = xkegi;
                kd_rek13   = creke;
                
        }

        if(tot > nilaisp2d){
            alert('Total Harga Tidak Boleh Melebihi Nilai SP2D');
            return false;
        }

        

        $('#dg').datagrid('selectAll');
            var rows = $('#dg').datagrid('getSelections');           
            for(var p=0;p<rows.length;p++){
                
                barang  = rows[p].kd_brg;
                if (barang==kd_brg){
                    iziToast.error({
                    title: 'Error',
                    message: 'Data Sudah ada di List!',
                    });
                    return;
                }
            }

            $('#dg').datagrid('appendRow',
                    {nm_brg:nm_brg,no_sp2d:nosp2d,tgl_sp2d:tgl_sp2d,harga:hrg,total:tot,kd_brg:kd_brg,kd_rek5:kd_rek13,jumlah:jml,nilai_sp2d:nilaisp2d,keterangan:keterangan,kd_kegiatan:kegi,jns:jen});  

            //$('#dlg').dialog('close');

        total_grid = $('#total_s1').text();
        
        sisa = angka(total_grid)+angka(tot);

        $("#total_s1").text(number_format(sisa,2,'.',','));
    }

    function back() {
        localStorage.clear();
        window.location.href = "<?php echo base_url(); ?>transaksi/C_SPM";
    }

    function getToday() {
      var d = new Date();
      var month = d.getMonth()+1;
      var day = d.getDate();
      var output = ((''+day).length<2 ? '0' : '') + day + '-' +
                   ((''+month).length<2 ? '0' : '') + month + '-' +
                   d.getFullYear();
      return output;
    }

    function tanggal_ind(tgl){
        var tahun   =  tgl.substr(0,4);
        var bulan   = tgl.substr(5,2);
        var tanggal =  tgl.substr(8,2);
        var jadi = tanggal+'-'+bulan+'-'+tahun;
        return jadi;  
        //alert(jadi);

        }
//================@Naga========================  

  

    
    
</script>