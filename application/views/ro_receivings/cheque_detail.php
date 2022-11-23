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
		onLoadSuccess: function(response) 
		{
			
			//alert($('#table tr'). length);
			
				$('table').find('tr').each(function(){ 						
                    var row = $(this).closest("tr");
                    var id=$(this).find("td:eq(2)").text();;
                    serial_no = row.find("td:eq(1)").text();


					//$(this).find("td:eq(3)").hide();
					//$(this).find("th:eq(3)").hide();


					// date_format = row.find("td:eq(4)").text();
					// date_format = date_format.slice(0,-8);
					// $(this).find('td').eq(4).html('<td id="g">'+date_format+'</td>'); 



					// date_format = row.find("td:eq(7)").text();
					// date_format = date_format.slice(0,-8);
					// $(this).find('td').eq(7).html('<td id="g">'+date_format+'</td>');

					


					//if($('#table tr'). length != 2){
					
					$(this).find('td').eq(-1).after('<td><a href id="submit_qty" name="'+id+'" title="Approve" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok id="submit_span"></span></a></td>');
					$(this).find('td').eq(-1).after('<td><a href id="reject_cheque" name="'+id+'" title="Reject" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove id="submit_span"></span></a></td>');
					//}
					
			}); 



			var myClasses = document.querySelectorAll('.btn.btn-default.btn-sm.dropdown-toggle');
               
                myClasses[0].style.display = 'none';

				$('[data-type="pdf"]').click(function(event) {
                        window.location.reload();
                        console.log('[data-type="pdf"]');
                });
			
		} 
	});
	
	$(document).on("click", '#submit_qty',  function(e){
				console.log($(this).attr("name"));
                var current_row = $(this).attr("name");
				var row = $(this).closest("tr");
                var id= row.find("td:eq(2)").text();
				var supplier_id=  row.find("td:eq(3)").text();
				var purchase_amt= row.find("td:eq(7)").text();
				var paid_amt = row.find("td:eq(8)").text();
				var closing_bal = row.find("td:eq(14)").text();
				var pending_payable = row.find("td:eq(15)").text();
				// var quantity_reg = e.target.value ;

				
				opening_balance = parseFloat(row.find("td:eq(13)").text());
				purchase_amount = parseFloat(row.find("td:eq(7)").text());
				
				overall_val = ((parseFloat(opening_balance) + parseFloat(purchase_amount))- parseFloat(paid_amt));
				final_val = overall_val ;
			
				alert('Do you want update the stock quantity?');
        $.ajax({
           type: 'POST',
			url: "<?php echo site_url("Roreceivings_cheque/cheque_valid/"); ?>",
            data: {'id':id,'overall_val':overall_val,'final_val':final_val,'supplier_id':supplier_id},   
            datatype : 'json',
            }).done(function (msg) {
                //  alert(data);
                alert("Stock quantity has been successfully updated " );
    	        window.location.reload();
                
            }).fail((jqXHR, errorMsg) => {
                alert(jqXHR.responseText, errorMsg);
        });
		e.preventDefault();
	});



	$(document).on("click", '#reject_cheque',  function(e){
				console.log($(this).attr("name"));

				var current_row = $(this).attr("name");
				var row = $(this).closest("tr");
                var id= row.find("td:eq(2)").text();
				var supplier_id=  row.find("td:eq(3)").text();
				var purchase_amt= row.find("td:eq(7)").text();
				var paid_amt = row.find("td:eq(8)").text();
				var closing_bal = row.find("td:eq(14)").text();
				var pending_payable = row.find("td:eq(15)").text();
				// var quantity_reg = e.target.value ;

				
				opening_balance = parseFloat(row.find("td:eq(13)").text());
				purchase_amount = parseFloat(row.find("td:eq(7)").text());
				
				overall_val = ((parseFloat(opening_balance) + parseFloat(purchase_amount))- parseFloat(paid_amt));
				final_val = overall_val ;
                
			
				alert('Do you want to reject cheque');
        $.ajax({
           type: 'POST',
			url: "<?php echo site_url("Roreceivings_cheque/cheque_reject/"); ?>",
            data: {'id':id,'overall_val':overall_val,'final_val':final_val,'supplier_id':supplier_id},   
            datatype : 'json',
            }).done(function (msg) {
                //  alert(data);
                alert("Cheque rejected" );
    	        window.location.reload();
                
            }).fail((jqXHR, errorMsg) => {
                alert(jqXHR.responseText, errorMsg);
        });
		e.preventDefault();
	});
	

	// when any filter is clicked and the dropdown window is closed
	$('#filters').on('hidden.bs.select', function(e)
	{
		table_support.refresh();
	});
				$('ul li:contains(JSON)').first().remove();
                $('ul li:contains(XML)').first().remove();
                $('ul li:contains(TXT)').first().remove();
                $('ul li:contains(CSV)').first().remove();
                $('ul li:contains(SQL)').first().remove();

         
});

</script>

<div id="title_bar" class="btn-toolbar">
<?php echo anchor("Roreceivings", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . "Purchase Details",
			array('class'=>'btn btn-info btn-sm pull-right', 'id'=>'sales_takings_button', 'title'=>$this->lang->line('sales_takings'))); ?>
					
</div>

<div id="toolbar">
	<!-- <div class="pull-left form-inline" role="toolbar">
		<button id="delete" class="btn btn-default btn-sm print_hide">
			<span class="glyphicon glyphicon-trash">&nbsp</span><?php echo $this->lang->line("common_delete");?>
		</button>
	</div> -->
</div>

<div id="table_holder">
	<table id="table"></table>
</div>

<?php $this->load->view("partial/footer"); ?>
