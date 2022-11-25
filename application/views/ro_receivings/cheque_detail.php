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


					$(this).find("td:eq(4)").hide();
					$(this).find("th:eq(4)").hide();

					$(this).find("td:eq(2)").hide();
					$(this).find("th:eq(2)").hide();


					date_format = row.find("td:eq(5)").text();
					date_format = date_format.slice(0,-8);
					$(this).find('td').eq(5).html('<td id="g">'+date_format+'</td>'); 



					date_format = row.find("td:eq(8)").text();
					date_format = date_format.slice(0,-8);
					$(this).find('td').eq(8).html('<td id="g">'+date_format+'</td>');

					


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
				//alert("current_row"+current_row);
				var row = $(this).closest("tr");
				//alert("row"+row);
                var id= row.find("td:eq(2)").text();
				//alert("id"+id);
				var supplier_id=  row.find("td:eq(4)").text();
				//alert("supplier_id"+supplier_id);
				var purchase_amt= row.find("td:eq(10)").text();
				//alert("purchase_amt"+purchase_amt);
				var paid_amt = row.find("td:eq(11)").text();
				//alert("paid_amt"+paid_amt);
				var closing_bal = row.find("td:eq(17)").text();
				//alert("closing_bal"+closing_bal);
				var pending_payable = row.find("td:eq(18)").text();
				//alert("pending_payable"+pending_payable);
				
				
				opening_balance = parseFloat(row.find("td:eq(16)").text());
				//alert("opening_balance"+opening_balance);
				purchase_amount = parseFloat(row.find("td:eq(10)").text());
				//alert("purchase_amount"+purchase_amount);
				
				overall_val = ((parseFloat(opening_balance) + parseFloat(purchase_amount))- parseFloat(paid_amt));
				final_val = overall_val ;
			
				alert('Do you want to approve cheque?');
        $.ajax({
           type: 'POST',
			url: "<?php echo site_url("Roreceivings_cheque/cheque_valid/"); ?>",
            data: {'id':id,'overall_val':overall_val,'final_val':final_val,'supplier_id':supplier_id},   
            datatype : 'json',
            }).done(function (msg) {
                
                alert("Cheque has been approved successfully" );
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
				
				var supplier_id=  row.find("td:eq(4)").text();
				
				var purchase_amt= row.find("td:eq(10)").text();
				
				var paid_amt = row.find("td:eq(11)").text();
				
				var closing_bal = row.find("td:eq(17)").text();
				
				var pending_payable = row.find("td:eq(18)").text();
				

				
				opening_balance = parseFloat(row.find("td:eq(16)").text());
				
				purchase_amount = parseFloat(row.find("td:eq(10)").text());
				
				discount = parseFloat(row.find("td:eq(15)").text());
				
				overall_val = ((parseFloat(opening_balance) + parseFloat(purchase_amount)));
				final_val = overall_val ;
                
			
				alert('Do you want to reject cheque');
        $.ajax({
           type: 'POST',
			url: "<?php echo site_url("Roreceivings_cheque/cheque_reject/"); ?>",
            data: {'id':id,'overall_val':overall_val,'final_val':final_val,'supplier_id':supplier_id,'discount':discount},   
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
