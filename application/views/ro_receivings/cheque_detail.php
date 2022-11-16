<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
$(document).ready(function()
{

	var opening_balance;
	var id_new;
	<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

	table_support.init({

		resource: '<?php echo site_url($controller_name);?>',
		headers: <?php echo $table_headers; ?>,
		pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
		uniqueId: 'id',
		enableActions: function()
		{
			
			
			$('#table').find('tr').each(function(){ 

				id_new =  $(this).find("td:eq(2)").text();

				//opening_balance=  $(this).find("td:eq(13)").text();
				
				$(this).find('td').eq(-1).after('<td><a href id="submit_cheque" name="'+id_new+'" title="Save Quantity" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok id="submit_span"></span></a></td>');
			
			
			
			}); 
			var myClasses = document.querySelectorAll('.btn.btn-default.btn-sm.dropdown-toggle');
               
                myClasses[0].style.display = 'none';
			
		} 
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

	$(document).on('click',"#submit_cheque",function(evt){
       
       
     
        alert('Do you want update the stock quantity?');
		evt.preventDefault();
		
		
		
		
        $.ajax({
           type: 'POST',
			url: "<?php echo site_url("Roreceivings_cheque/update_cheque/"); ?>" ,
            data: {'id':id_new,'opening_balance':opening_balance},   
            datatype : 'json',
            }).done(function (msg) {
                // alert(data);
                alert("Stock quantity has been successfully updated " );
    	        window.location.reload();
                
            }).fail((jqXHR, errorMsg) => {
                alert(jqXHR.responseText, errorMsg);
        });
       
            
            //return FALSE;

			evt.preventDefault();
       
  
 });
});

</script>



<div id="table_holder">
	<table id="table"></table>
</div>

<?php $this->load->view("partial/footer"); ?>
