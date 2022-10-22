<div class="tab-content" id="myTabContent">
	<div style="padding-bottom: 20px;">
		<button type="button" class="btn btn-primary btn-lg btn-block" style="width: 100%" id="proses1" ><b> PROSES KIRIM DATA  E-BUDGETING =====&gt; SIMAKDA </b></button>
	</div>
  <div style="padding-bottom: 20px;">
    <button type="button" class="btn btn-primary btn-lg btn-block" style="width: 100%" id="proses5" ><b> PROSES KIRIM DATA RINCIAN E-BUDGETING =====&gt; SIMAKDA </b></button>
  </div>
    <div style="padding-bottom: 20px;">
    <button type="button" class="btn btn-primary btn-lg btn-block" style="width: 100%" id="proses8" ><b> PROSES KIRIM DATA RINCIAN E-BUDGETING (LUNCURAN) =====&gt; SIMAKDA </b></button>
  </div>
    </div>
    <div style="padding-bottom: 20px;">
    <button type="button" class="btn btn-primary btn-lg btn-block" style="width: 100%" id="proses6" ><b> PROSES KIRIM DATA RINCIAN PENDAPATAN E-BUDGETING =====&gt; SIMAKDA </b></button>
  </div>
	<div style="padding-bottom: 20px;">
		<button type="button" class="btn btn-primary btn-lg btn-block" style="width: 100%" id="proses2" ><b> PROSES KIRIM DATA  E-BUDGETING wisnu=====&gt; SIMPATDA </b></button>
	</div>
  <div style="padding-bottom: 20px;">
    <button type="button" class="btn btn-primary btn-lg btn-block" style="width: 100%" id="proses7" ><b> PROSES KIRIM DATA PEMBIAYAAN E-BUDGETING =====&gt; SIMAKDA </b></button>
  </div>
  <div style="padding-bottom: 20px;">
    <button type="button" class="btn btn-primary btn-lg btn-block" style="width: 100%" id="proses3" ><b> PROSES KIRIM DATA PENDAPATAN E-BUDGETING =====&gt; SIMAKDA </b></button>
  </div>
	<div style="padding-bottom: 20px;">
		<button type="button" class="btn btn-primary btn-lg btn-block" style="width: 100%" id="proses4" ><b> PROSES SINKRONISASI  DATA  E-BUDGETING =====&gt; SIMBAKDA </b></button>
	</div>
</div>
<!--<tr height="70%" >
<td align="center" style="visibility:hidden" >	<DIV id="load" > <IMG SRC="<?php echo base_url(); ?>assets/img/mapping.gif" WIDTH="100%" HEIGHT="40" BORDER="0" ALT=""></DIV></td>
</tr> -->
<script type="text/javascript">  

  var urll     = "<?php echo site_url(); ?>utilitas/C_kirim/proses_ebudget_simakda";
  var url2     = "<?php echo site_url(); ?>utilitas/C_kirim/proses_ebudget_simpatda";
  var url3     = "<?php echo site_url(); ?>utilitas/C_kirim/proses_ebudget_pend_simakda";
  var url5     = "<?php echo site_url(); ?>utilitas/C_kirim/proses_ebudget_rincian_simakda";
  var url6     = "<?php echo site_url(); ?>utilitas/C_kirim/proses_ebudget_rincian_pend_simakda";
  var url7     = "<?php echo site_url(); ?>utilitas/C_kirim/proses_ebudget_pemb_simakda";
  var url8     = "<?php echo site_url(); ?>utilitas/C_kirim/proses_ebudget_simakda_luncuran";
  
  $(document).ready(function() {
  	
    $('#proses1').click(function(){
       window.open(urll);
       window.focus();
    });	

   $('#proses2').click(function(){
       window.open(url2);
       window.focus();
    }); 

    $('#proses3').click(function(){
       window.open(url3);
       window.focus();
    });
    $('#proses5').click(function(){
       window.open(url5);
       window.focus();
    });
    $('#proses6').click(function(){
       window.open(url6);
       window.focus();
    });
    $('#proses7').click(function(){
       window.open(url7);
       window.focus();
    });
    $('#proses8').click(function(){
       window.open(url8);
       window.focus();
    });

  });
</script>

<!--<script type="text/javascript">  

  var urll     = "<?php echo site_url(); ?>utilitas/C_kirim/proses_ebudget_simpatda";
  
  $(document).ready(function() {
    
    $('#proses2').click(function(){
       window.open(urll);
       window.focus();
    }); 
  });
</script>-->