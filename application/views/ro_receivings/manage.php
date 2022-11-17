<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
$(document).ready(function()
{
	<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

	table_support.init({
		resource: '<?php echo site_url($controller_name);?>',
		headers: <?php echo $table_headers; ?>,
		pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
		uniqueId: 'id',
		
	});
	// $('table').find('tr').each(function(){ 
	
	// row.find("tr:eq(15)").hide();
	// });

	// when any filter is clicked and the dropdown window is closed
	$('#filters').on('hidden.bs.select', function(e)
	{
		
		table_support.refresh();
	});
	$('table').find('tr').each(function(){ 
		
		var row = $(this).closest("tr");
	//  row.find("th:eq(15)").hide();

	row.find("th:eq(-1)").hide();
	row.find("td:eq(-1)").hide();
	});
	var myClasses = document.querySelectorAll('.btn.btn-default.btn-sm.dropdown-toggle');
               
			   myClasses[0].style.display = 'none';

	$('ul li:contains(JSON)').first().remove();
                $('ul li:contains(XML)').first().remove();
                $('ul li:contains(TXT)').first().remove();
                $('ul li:contains(CSV)').first().remove();
                $('ul li:contains(SQL)').first().remove();
	
});
</script>



<div id="title_bar" class="btn-toolbar">


	<?php echo anchor("Roreceivings_cheque/manage", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . "Cheque detail",
			array('class'=>'btn btn-info btn-sm pull-right', 'id'=>'sales_takings_button', 'title'=>$this->lang->line('sales_takings'))); ?>
					
	
	
	<button class='btn btn-info btn-sm pull-right modal-dlg' data-btn-submit='<?php echo $this->lang->line('common_submit') ?>' data-href='<?php echo site_url($controller_name."/view"); ?>'
			title='<?php echo $this->lang->line($controller_name.'_new'); ?>'>
		<span class="glyphicon glyphicon-list">&nbsp</span><?php echo $this->lang->line($controller_name . '_new'); ?>
	</button>
</div>
<ul class="pull-left">
						<?php echo anchor($controller_name."/bulk_entry_view", '<span class="glyphicon glyphicon-list">&nbsp</span>' . $this->lang->line('receivings_bulk_entry'),
									array('class'=>'btn btn-primary btn-sm', 'id'=>'sales_takings_button', 'title'=>$this->lang->line('receivings_bulk_entry'))); ?>
					</ul>





<!-- <div id="toolbar">
	<div class="pull-left form-inline" role="toolbar">
		<button id="delete" class="btn btn-default btn-sm print_hide">
			<span class="glyphicon glyphicon-trash">&nbsp</span><?php echo $this->lang->line("common_delete");?>
		</button>
	</div>
</div> -->

<div id="table_holder">
	<table id="table"></table>
</div>

<?php $this->load->view("partial/footer"); ?>
