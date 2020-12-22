<?php $this->load->view("partial/header"); ?>

<div id="page_title"><?php echo $title ?></div>

<div id="page_subtitle"><?php echo $subtitle ?></div>
<div id="table_holder">
	<table id="table"></table>
</div>

<div id="report_summary">
	<?php
	foreach($summary_data as $name=>$value)
	{
	?>
		<div class="summary_row"><?php echo $this->lang->line('reports_'.$name). ': '.to_currency($value); ?></div>
	<?php
	}
	?>
</div>
<?php $this->load->view("partial/reportfooter"); ?>
<script type="text/javascript">
	$(document).ready(function()
	{
		<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

		$('#table').bootstrapTable({
			columns: <?php echo transform_headers($headers, TRUE, FALSE); ?>,
			pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
			striped: true,
			sortable: true,
			showExport: true,
			pagination: true,
			showColumns: true,
			showExport: true,
			data: <?php echo json_encode($data); ?>,
			iconSize: 'sm',
			paginationVAlign: 'bottom',
			escape: false
		});

		$('#btnmessage').click(function(){
			$data = {
					subject : '<?php echo $title;?>',
					subtitle : '<?php echo $subtitle;?>',		
					columns: <?php echo transform_headers($headers, TRUE, FALSE); ?>,
					data: <?php echo json_encode($data); ?>
							
					};
			 $.ajax({
	                type: "POST",
	                url: "<?=base_url()?>reports/messagereport",
	                data: {data :$data , '<?php echo $this->security->get_csrf_token_name();?>' : '<?php echo $this->security->get_csrf_hash();?>'} ,
	                dataType : 'json',
	                cache: "false",
	                success: function(data) {
	                    console.log("success!"); 
	                },
	                error: function(data) {
	                    console.log("error");  
	                }
	            }).always( function() {
                    console.log("always");   $('#btnmessage').hide();	                  
                });

		});

	});
</script>
<?php $this->load->view("partial/footer"); ?>