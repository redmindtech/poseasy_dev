<?php $this->load->view("partial/header"); ?>

<h3><center><b>Bulk Entry</b></center></h3>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>
<?php echo form_open('Roreceivings/bulk_entry_save/'.$ro_receivings_info->id, array('id'=>'ro_receivings_edit_form', 'class'=>'form-horizontal')); ?>

<div id="title_bar" class="btn-toolbar">
<?php echo anchor("Roreceivings", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . "Purchase Details",
			array('class'=>'btn btn-info btn-sm pull-right', 'id'=>'sales_takings_button', 'title'=>$this->lang->line('sales_takings'))); ?>
					
</div>
<fieldset id="item_basic_info">


	<?php
	$date = date('Y-m-d\TH:i');
	//$randam=rand(1, $count);
	$newDate = date("Ymd", strtotime($date));

	?>

	<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('receivings_cash_date'), 'receivings_cash_date', array('class'=>'control-label col-xs-3' )); ?>
			<div class='col-xs-3'>
				<?php echo form_input(array('type'=>'date',
						'name'=>'purchase_date',
						'id'=>'purchase_date',
						'class'=>'form-control input-sm',
						'value'=>date('Y-m-d'))
						);?>
			</div>
		</div>
	
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('receivings_voucher_no'), 'voucher_no', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-3'>
				<?php echo form_input(array(
						'name'=>'voucher_no',
						'id'=>'voucher_no',
						'readonly'=>'readonly',
						'class'=>'form-control input-sm',
						'value'=>'POS '.$newDate.round(bcadd($voucher_no[0]['maxid'],1)))
						);?>
			</div>
			<div class="form-group form-group-sm">
		</div><?php echo form_label($this->lang->line('expenses_employee'), 'employee', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-3'>
				
				<?php echo form_dropdown('employee_id', $employees, $ro_receivings_info->employee_id, 'id="employee_id"  class="form-control"');?>
			</div>
		</div></div>

       


		

	
	<table class="sales_table_10" id="register">
		<thead>
			<tr>
				<th style="width:1%;"><?php echo $this->lang->line('receivings_sno'); ?></th>				
				<th style="width:20%;"><?php echo $this->lang->line('receivings_account'); ?></th>
				<th style="width:12%;"><?php echo $this->lang->line('receivings_towards_vno'); ?></th>
				<th style="width:15%;"><?php echo $this->lang->line('receivings_net_amount'); ?></th>
				<th style="width:10%;"><?php echo $this->lang->line('receivings_type'); ?></th>
				<th style="width:10%;"><?php echo $this->lang->line('gst_slab'); ?></th>
				<th style="width:10%;"><?php echo $this->lang->line('gst_amount'); ?></th>
				<th style="width:45%;"><?php echo $this->lang->line('receivings_naration'); ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody id=tbody>
			<tr class=row1 name=tbrow id='tr'>	
				<td id='sno'><label>1</label></td>
			
			<td id="td">
			<div class="form-group form-group-sm">
			<div class='col-xs-12'>
				<?php echo form_input(array(
						'type'=>'text',
						'name'=>'supplier_name',
						'data-supplier_id'=>"1",
						'id'=>'supplier_name',
						'class'=>'form-control input-sm supplier_name',
						'value'=>$this->lang->line('expenses_start_typing_supplier_name'))
					);
					?>
						
			</div>

					 </td>
					 <td id="td "><div class="form-group form-group-sm">
						<div class='col-xs-11'>
						<?php echo form_input(array(
								'type'=>'text',
								'name'=>'towards_vno',
								'id'=>'towards_vno',
								'class'=>'form-control input-sm',
								'value'=>'')
								); ?>
					</div>
                </div> 
			</td>
					
					 <td id="td"><div class="form-group form-group-sm">
						<div class='col-xs-11'>
						<?php echo form_input(array(
								'type'=>'number',
								'name'=>'opening_balance_1',
								'id'=>'opening_balance_1',
								'class'=>'form-control input-sm',
								'value'=>'0')
								); ?>
					</div>
                </div> 
			</td>

					<td id="td"><div class="form-group form-group-sm">
						<div class='col-xs-11'>
						<?php echo form_input(array(
								'name'=>'type',
								'id'=>'type',
								'class'=>'form-control input-sm',
								'value'=>'0')
								); ?>
					</div>
                </div>  </td>
					<td id="td"><div class="form-group form-group-sm">
						<div class='col-xs-11'>
						<?php echo form_input(array(
								'name'=>'gst_slab',
								'id'=>'gst_slab',
								'class'=>'form-control input-sm',
								'value'=>'0')
								); ?>
					</div>
                </div>  </td>
					<td id='td'><div class="form-group form-group-sm">
						<div class='col-xs-11'>
						<?php echo form_input(array(
								'name'=>'gst_amt',
								'id'=>'gst_amt',
								'class'=>'form-control input-sm',
								'value'=>'0')
								); ?>
					</div>
                </div>  </td>
					<td id='td'><div class="form-group form-group-sm">
						<div class='col-xs-11'>
						<?php echo form_input(array(
								'name'=>'narration',
								'id'=>'narration',
								'class'=>'form-control input-sm',
								'value'=>'')
								); ?>
					</div>
                </div>  </td>
					<td><button id="addBtn" name="addBtn" class="btn btn-success btn-sm" title="Add Supplier" ><span class="glyphicon glyphicon-plus" value="Add"></span>  </button></td>
					
							
			</tr>	
			</tbody>
							</table>


							<button class='btn btn-info btn-sm pull-right submit'><span class="glyphicon glyphicon-ok">&nbsp;</span><?php echo $this->lang->line($controller_name. '_save'); ?>
    </button>
			
			
		
	</fieldset>	



	
	
					
					

<?php echo form_close(); ?>

<script type="text/javascript">
	 $('.row1').click(function(){
	
//$('#supplier_name').click(function
$(document).on('click',"#supplier_name",function() {
	// $('#supplier_name').click(function() {
		$(this).attr('value', '');
	});

	$('.supplier_name').autocomplete({
		source: '<?php echo site_url("Items/suggest_supplier"); ?>',
		minChars:1,
		delay:5,
		select: function (event, ui) {
			$('#supplier_id').val(ui.item.value);
			//var extension = $(this).attr('id').substr($(this).attr('id'),15);
			$(this).val(ui.item.label);
			$(this).attr('');
			$(this).attr('id',ui.item.value);
			$('#remove_supplier_button').css('display', 'inline-block');
		//	alert(extension);
		supplier_id=ui.item.value;
        //  alert(supplier_id);
			return false;
		
		}
		
	});

	$('.supplier_name').blur(function() {
		$(this).attr('value',"<?php echo $this->lang->line('expenses_start_typing_supplier_name'); ?>");
	});

	$("table").on("change", "input","click", function(e)
{ 
alert("hi");

var	open_bal=parseFloat($('#opening_balance').val());

});
	

	$('#remove_supplier_button').click(function() {
		$('.supplier_id').val('');
		$('.supplier_name').removeAttr('readonly');
		$('.supplier_name').val('');
		$(this).css('display', 'none');
	});

	<?php
	if(!empty($expenses_info->expense_id))
	{
	?>
		$('.supplier_id').val('<?php echo $expenses_info->supplier_id ?>');
		$('.supplier_name').val('<?php echo $expenses_info->supplier_name ?>').attr('readonly', 'readonly');
		$('#remove_supplier_button').css('display', 'inline-block');
	<?php
	}
	?>
	 });

	


$(document).ready(function(){
	
	
	var count = 1;

	$('#addBtn').click(function(e){

		var supplier_name =($('[data-supplier_id='+count+']').val());
		
		var open=$("#opening_balance_"+count).val();
		
		if(supplier_name=="" || supplier_name=="Start Typing Supplier's name..." ||open == '0')
		{ 

			if(supplier_name=="" || supplier_name=="Start Typing Supplier's name..."){
			alert('Please enter supplier name');
			e.preventDefault();
			}else{
				alert('Please enter net amount');
				e.preventDefault();
			}
		}
		else{		
		count++;
		var html = '';
		html +='<tr id="row'+count+'">';
		html += '<td id="sno"><input type="hidden" id="sno" name="sno" value="'+count+'"><label>'+count+'</label</td>';
		html += '<td><div class="col-xs-12"><input type="text" id="supplier_name_'+count+'" data-supplier_id='+count+' class="form-control input-sm supplier_name" name="supplier_name[]" placeholder="Start Typing Suppliers name..." required=""></div></td>';
		html += '<td><div class="col-xs-11"><input type="text" id="towards_vno_'+count+'" class="form-control input-sm data-id" name="towards_vno_'+count+'"></div></td>';
		html += '<td><div class="col-xs-11"><input type="number" id="opening_balance_'+count+'" class="form-control input-sm" name="opening_balance_'+count+'" value="0" ></div></td>';
		html += '<td><div class="col-xs-11"><input type="text" id="type_'+count+'" class="form-control input-sm" value="" placeholder="Cash or UPI" name="type_'+count+'" ></div></td>';
		html += '<td><div class="col-xs-11"><input type="text" id="gst_slab_'+count+'" value="0.00" class="form-control input-sm" name="gst_slab[]" ></div></td>';
		html += '<td><div class="col-xs-11"><input type="text" id="gst_amt_'+count+'" value="0.00" class="form-control input-sm" name="gst_amt_'+count+'"></div></td>';
		html += '<td><div class="col-xs-11"><input type="text" id="narration_'+count+'" class="form-control input-sm" name="narration_'+count+'" ></div></td>';
		html += '<td><a id="delete" name="delete" class="btn btn-danger btn-sm " title="Delete" ><span class="glyphicon glyphicon-minus" value="Add"></span></a></td>';
		e.preventDefault();
		
		$("tbody").append(html);
		
		$("input.supplier_name").on("keydown.autocomplete", function() {
        
			$(this).autocomplete({
            source: '<?php echo site_url("Items/suggest_supplier"); ?>',
			minLength: 1
		});
		
	});
}
	
	});
	

	$("#register").on('click','#delete',function(){
		$(this).closest('tr').remove();
	});

	$('.supplier_name_'+count+'').autocomplete({
		source: '<?php echo site_url("Items/suggest_supplier"); ?>',
		minChars:1,
		delay:5,
		select: function (event, ui) {
			$('#supplier_id_'+count+'').val(ui.item.value);
		
			$(this).val(ui.item.label);
			$(this).attr('');
			$(this).attr('id',ui.item.value);
			$('#remove_supplier_button').css('display', 'inline-block');
	
		supplier_id=ui.item.value;
        //  alert(supplier_id);
			return false;
		
		}
	
	});
	
	$(document).on('click',".submit",function(e){
		
		var purchase_date = $('#purchase_date').val();
		var voucher_no = $('#voucher_no').val();
		// var employee_id=$('#employee_id').val();
		var supplier_name1 =($('[data-supplier_id=1]').val());
		var open1=$("#opening_balance_1").val();


		var supplier_name =($('[data-supplier_id='+count+']').val());
		
		var open=$("#opening_balance_"+count).val();
		var supplier_name_0 = $("#supplier_name").val();
		//alert(supplier_name_0);

		if(supplier_name_0 == "Start Typing Supplier's name..." || supplier_name == "" ){

      			var check_null = "0";
				//alert(check_null);

		}


		
	

		if(voucher_no =="" || check_null == "0" || open== "0"){

			if(voucher_no == ""){
			alert("Please enter voucher number" )
			e.preventDefault();
			}else
			{
				if(check_null == "0"){
				alert("Please enter supplier name");
				e.preventDefault();
				}else{
					alert("Please enter net amount");
					e.preventDefault();
				}
			}
		}else{
		
		var table = $('table');
  		var ro_receivings_data_bulk = [];
		  table.find('tr').each(function (i, el)
		  {

			if(i != 0){
			
				
				var row = [];

				var purchase_date = $('#purchase_date').val();
				var voucher_no = $('#voucher_no').val();
				var employee_id=$('#employee_id').val();
				var supplier_id = $(this).find("td:eq(1) input[type='text']").attr('id');
				var towards_vno = $(this).find("td:eq(2) input[type='text']").val();
				var opening_balance = $(this).find("td:eq(3) input[type='number']").val();
				var type = $(this).find("td:eq(4) input[type='text']").val();
				var gst_slab = $(this).find("td:eq(5) input[type='text']").val();
				var gst_amt = $(this).find("td:eq(6) input[type='text']").val();
				var narration = $(this).find("td:eq(7) input[type='text']").val();

			// alert(employee_id);
				

				row.push(purchase_date,voucher_no,employee_id,supplier_id,towards_vno,opening_balance,type,gst_slab,gst_amt,narration);
				ro_receivings_data_bulk.push(row);
			
			}
		
		
           	
});

var jsonString = JSON.stringify(ro_receivings_data_bulk);
console.log(JSON.stringify(ro_receivings_data_bulk));
$.ajax({
           type: 'POST',
			url:  "<?php echo site_url("Roreceivings/bulk_entry_save/"); ?>" ,
            data: {bulk_data : jsonString},   
			datatype : 'json',
		}).done(function (msg) {



			
			    window.location.replace("<?php  echo base_url('Roreceivings'); ?>");
            
			
    	        //location.reload();
				//window.location = <?php #echo base_url('Roreceivings'); ?>
				
				
                
            }).fail((jqXHR, errorMsg) => {
                alert(jqXHR.responseText, errorMsg);
        });

e.preventDefault();
	}
});
$(document).ready(function() {
     $(':input[id="addBtn"]').prop('disabled', true);
     $('input[name="supplier_name"]').keyup(function() {
        if($(this).val() != '') {
           $(':input[id="addBtn"]').prop('disabled', false);
        }
     });
 });

});

</script>