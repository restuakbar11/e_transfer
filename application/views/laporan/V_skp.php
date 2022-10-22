<form  id="fm" action="<?php echo base_url()."proses/C_Laporan/skp";?>">
    <div class="row">
        <div class="col-md-6">
            <div style="margin-bottom:20px">
                <div class="col-sm-11" style="padding-bottom: 20px;">
                    <div class="col-sm-2" style="padding-top: 3px;"><label>NIP</label></div>
                    <div class="col-sm-4"><input id="nip" name="nip_pegawai" type="text" class="easyui-textbox" style="width:100%;" ></div>
                    <div class="col-sm-4"><input id="nm_pegawai" name="nama_pegawai" readonly="" class="easyui-textbox" style="width:100%;" ></div>
                    <div class="col-sm-2" ><button type="button" id="cetakPdf" class="btn btn-success" style="width:130%;" ><i class="fa fa-file-pdf-o" ></i> CETAK Pdf</button></div>
                    
                </div>
        
              <div class="col-sm-12" style="padding-bottom: 10px;">
        <div class="col-sm-4" style="padding-top: 3px;"><label></label></div>
        </div>                
            </div>            
        </div>
    
    </div>
</form>

<script type="text/javascript">

 
      $('#nip').combogrid({
            panelWidth:700,  
            idField:'nama',  
            textField:'nip',  
            url:'<?php echo base_url(); ?>laporan/C_Lap_Pegawai/get_nip', 
            mode:'remote',
            columns:[[  
               {field:'nip',title:'Nip',width:300,align:'center'},  
               {field:'nama',title:'Nama Pegawai',width:400}

            ]],
      onSelect:function(rowIndex,rowData){
               nip = rowData.nip;
         nama = rowData.nama;
         $("#nm_pegawai").textbox('setValue',nama);
         //$('#L_nm_satuan_kerja').val(nm_satkerja);
         $('#nip').combogrid({url:'<?php echo base_url(); ?>laporan/C_Lap_Pegawai/get_nip',

         queryParams:({nip:nip})
         });
      }
        });

 



</script>