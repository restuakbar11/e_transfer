<form action="<?php echo base_url()."proses/C_Laporan/rtb";?>" id="fm" method="post" novalidate style="margin:0;padding:10px 10px" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div style="margin-bottom:20px">
                <div class="col-sm-12" style="padding-bottom: 20px;">
                    <div class="col-sm-2" style="padding-top: 3px;"><label>SKPD</label></div>
                    <div class="col-sm-2"><input id="L_kdskpd_dari" name="kd_skpd_dari" type="text" class="easyui-textbox" style="width:125%;" ></div>
                    <div class="col-sm-8"><input id="L_nmskpd_dari" name="nm_skpd_dari" readonly="" class="easyui-textbox" style="width:200%;" ></div>
                    
                </div>
                
                <div class="col-sm-12" style="padding-bottom: 20px;">
                    <div class="col-sm-2" style="padding-top: 3px;"><label></label></div>
                    <div class="col-sm-3" ><button type="submit" value="cetak" name="coba" class="btn btn-success" style="width:100%;" ><i class="fa fa-desktop" ></i> CETAK PER SKPD</button></div>
            	   <div class="col-sm-4" ><button type="submit" value="cetak" name="coba" class="btn btn-success" style="width:120%;" ><i class="fa fa-desktop" ></i> CETAK SEMUA SKPD</button></div>
                

				</div>								
            </div>            
        </div>
		
    </div>
</form>

<script type="text/javascript">
		

			$('#L_kdskpd_dari').combogrid({
            panelWidth:1200,  
            idField:'nm_skpd',  
            textField:'kd_skpd',  
            url:'<?php echo base_url(); ?>laporan/C_Lap_Pegawai/get_skpd', 
            mode:'remote',
            columns:[[  
               {field:'kd_skpd',title:'Kode SKPD',width:200},  
               {field:'nm_skpd',title:'Nama SKPD',width:1000}

            ]],
			onSelect:function(rowIndex,rowData){
               kd_skpd = rowData.kd_skpd;
			   nm_skpd = rowData.nm_skpd;
			   $("#L_nmskpd_dari").textbox('setValue',nm_skpd);
			   //$('#L_nm_satuan_kerja').val(nm_satkerja);
			   $('#L_kdskpd_dari').combogrid({url:'<?php echo base_url(); ?>laporan/C_Lap_Pegawai/get_skpd',

			   queryParams:({kd_skpd:kd_skpd})
			   });
               $('#L_kdskpd_sampai').combogrid("enable","enable");
			}
        });

</script>