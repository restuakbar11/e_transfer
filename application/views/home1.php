	<div class="row">
			<div class="col-md-9">
				<!--<div id="piechart" style="width: 900px; height: 500px;"></div>
				-->
				<div id="piechart1" style="min-width: 350px; height: 500px; max-width: 800px; margin: 0 auto"></div>
			</div>
			
	</div>	
	<!--highcharts-->
	<script src="<?php echo base_url(); ?>assets/scripts/highcharts.js"></script>
	<script src="<?php echo base_url(); ?>assets/scripts/highcharts-3d.js"></script>
	<script src="<?php echo base_url(); ?>assets/scripts/exporting.js"></script>
	<script src="<?php echo base_url(); ?>assets/scripts/highcharts-more.js"></script>
	
<script>

 $(function() {
	 		 
	//*****HIGHTCHART	
 	Highcharts.chart('piechart1', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 50,
            beta: 0
        }
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        //url	:'<?php echo base_url('Welcome/getData') ?>',
        data: [
            ['', 213123],
            ['',  2123],
            {
                name: '',
                y:  5442,
                sliced: true,
                selected: true
            },
            ['',  86],
            ['',  64],
            ['',  890]
        ]
    }]
});
		
 });
</script>