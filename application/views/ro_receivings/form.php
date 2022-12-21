<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>
<?php echo form_open('Roreceivings/save/'.$ro_receivings_info->id, array('id'=>'ro_receivings_edit_form', 'class'=>'form-horizontal')); ?>
	
	<fieldset id="item_basic_info">
	<?php $companyname=$company_name_none;
	
 foreach($company_name as $row)
 {
			$companyname[$row->person_id] = $row->company_name;
		
 }  
	?>
	

				<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('receivings_date'), 'date', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<div class="input-group">
					<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-calendar"></span></span>
					<?php echo form_input(array('type'=>'date','id'=>'date',
							'name'=>'date',
							'class'=>'required form-control input-sm datetime',
 							'value'=>date('Y-m-d')
                            )
							);?>
				</div>
			</div>
		</div>


		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('expenses_supplier_name'), 'ro_receivings_company_name', array('class'=>' control-label col-xs-3 required')); ?>
			<div class=' col-xs-8'  >								
				<?php  echo form_dropdown('company_name', $companyname, $ro_receivings_info->supplier_id, array('id'=>'supplier_company_id','class'=>' form-control')); ?>
			</div>
		</div>


		<div class="form-group form-group-sm" id="supplier_name_disp" style=display:none;>
			<?php echo form_label($this->lang->line('expenses_supplier_name'), 'supplier_name', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-6'>
			<div class="input-group">
			<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-tag"></span></span>
				<?php echo form_input(array(
						'name'=>'supplier_name',
						'id'=>'supplier_name',
						'class'=>'form-control input-sm',
						)
					);
					echo form_input(array(
						'type'=>'hidden',
						'name'=>'supplier_id',
						'id'=>'supplier_id',
						'value'=>$ro_receivings_info->supplier_id)
						);?>

					</div>
						
			</div>
			</div>

		<div class="form-group form-group-sm">
				  <?php echo form_label($this->lang->line('ro_receivings_voucher_no'), 'invoice no', array('class' => 'control-label col-xs-3')); ?>
					  <div class='col-xs-8'>
						<?php echo form_input(array(
								'name'=>'voucher_no',
								'id'=>'voucher_no',
								'class'=>'form-control input-sm',
								'value'=>$ro_receivings_info->voucher_no)
								); ?>
					  </div>
        </div>
		

        <div class="form-group form-group-sm">
				  <?php echo form_label($this->lang->line('ro_receivings_opening_balance'), 'opening_balance', array('class' => 'control-label col-xs-3')); ?>
					  <div class='col-xs-8'>
						<?php echo form_input(array(
								 
								'name'=>'opening_balance',
								'id'=>'opening_balance',
								'class'=>'form-control input-sm',
								'readonly'=>'true',
								'value'=>to_currency_no_money(0.00))
								); ?>
					  </div>
        </div>
        <div class="form-group form-group-sm">
					<?php echo form_label($this->lang->line('ro_receivings_purchase_amount'), 'purchase_amount', array('class' => 'control-label col-xs-3')); ?>
					<div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number','min'=>0,
								  
								'name'=>'purchase_amount',
								'id'=>'purchase_amount',
								'class'=>'form-control input-sm',
								'value'=>to_currency_no_money(0.00)
								)
								); ?>
					</div>
                </div>
				<div class="form-group form-group-sm">
					<?php echo form_label($this->lang->line('ro_receivings_paid_amount'), 'paid_amount', array('class' => 'control-label col-xs-3')); ?>
					<div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number','min'=>0,
								  
								'name'=>'paid_amount',
								'id'=>'paid_amount',
								'class'=>'form-control input-sm',
								'value'=>to_currency_no_money(0.00))
								); ?>
					</div>
                </div>
        
                <div class="form-group form-group-sm payment_mode">
			        <?php echo form_label($this->lang->line('ro_receivings_payment_mode'), 'payment_mode', array('class'=>'control-label col-xs-3')); ?>
			         <div class='col-xs-8'>
			           <select name="payment_mode" id="payment_mode" required="" class='form-control'>
                        <option value="" >--Select Payment Mode--</option >
                        <option value="UPI" >UPI</option>
                        <option value="Cash" >Cash</option>
				        <option value="NEFT" >NEFT</option>    
				        <option value="Cheque" >Cheque</option>        
		                </select>
			        </div>
		        </div>
				<div class="form-group form-group-sm cheque_date">
			<?php echo form_label($this->lang->line('ro_receivings_cheque_date'), 'date', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<div class="input-group">
					<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-calendar"></span></span>
					<?php echo form_input(array('type'=>'date',
							'name'=>'cheque_date',
							'class'=>'form-control input-sm datetime',
 							'value'=>date('Y-m-d'),
                           )
							);?>
				</div>
			</div>
		</div>
		<div class="form-group form-group-sm cheque_number">
					<?php echo form_label($this->lang->line('ro_receivings_cheque_number'), 'cheque_number', array('class' => 'required control-label col-xs-3')); ?>
					<div class='col-xs-4'>
						<?php echo form_input(array(
							  
								'name'=>'cheque_number',
								'id'=>'cheque_number',
								'class'=>'form-control input-sm',
								'value'=>''
								)
								); ?>
					</div> 
                </div>
				
                <div class="form-group form-group-sm">
					<?php echo form_label($this->lang->line('ro_receivings_closing_balance'), 'closing_balance', array('class' => 'control-label col-xs-3')); ?>
					<div class='col-xs-8'>
						<?php echo form_input(array(
								'name'=>'closing_balance','type'=>'number',
								'id'=>'closing_balance',
								'class'=>'form-control input-sm',
								'value'=>to_currency_no_money(0.00),
								'readonly'=>'readonly')
								); ?>
					</div> 
                </div>
                    <div class="form-group form-group-sm">
					    <?php echo form_label($this->lang->line('ro_receivings_purchase_return_amount'), 'purchase_return_amount', array('class' => 'control-label col-xs-3')); ?>
					     <div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number','min'=>0,
								  
								'name'=>'purchase_return_amount',
								'id'=>'purchase_return_amount',
								'class'=>'form-control input-sm',
								'value'=>to_currency_no_money(0.00)
								)
								); ?>
					      </div> 
                     </div>
                     <div class="form-group form-group-sm">
					    <?php echo form_label($this->lang->line('purchase_return_qty'), 'purchase_return_qty', array('class' => 'control-label col-xs-3')); ?>
					     <div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number','min'=>0,
								'name'=>'purchase_return_qty',
								'id'=>'purchase_return_qty',
								'class'=>'form-control input-sm',
								'value'=>'0')
								); ?>
					      </div> 
                     </div>
                     <div class="form-group form-group-sm">
					    <?php echo form_label($this->lang->line('discount'), 'discount', array('class' => 'control-label col-xs-3')); ?>
					     <div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number','min'=>0,
						      
								'name'=>'discount',
								'id'=>'discount',
								'class'=>'form-control input-sm',
								'value'=>to_currency_no_money(0.00))
								); ?>
					      </div> 
                     </div>
                     <div class="form-group form-group-sm">
					    <?php echo form_label($this->lang->line('pending_payables'), 'pending_payables', array('class' => 'control-label col-xs-3')); ?>
					     <div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number',
								'name'=>'pending_payables',
								'id'=>'pending_payables',
								'class'=>'form-control input-sm',
								'value'=>to_currency_no_money(0.00),
								'readonly'=>'readonly')
								); ?>
					      </div> 
                     </div>
              		<div class="form-group form-group-sm">	
	              
                  	 <?php echo form_label($this->lang->line('last_purchase_qty'), 'last_purchase_qty', array('class'=>'control-label col-xs-3')); ?>
		               <div class='col-xs-8'>
                  		 <?php echo form_input(array('type'=>'number','min'=>0,
				              'name'=>'last_purchase_qty',
				               'id'=>'last_purchase_qty',
				                'class'=>'form-control input-sm',
				                 'value'=>'0')
							);?>
						</div>
					</div>

					<div class="form-group form-group-sm">
					    <?php echo form_label($this->lang->line('gst_slab'), 'gst_slab', array('class' => 'control-label col-xs-3')); ?>
					     <div class='col-xs-8'>
						<?php echo form_input(array(
								'name'=>'gst_slab',
								'id'=>'gst_slab',
								'class'=>'form-control input-sm',
								'value'=>$ro_receivings_info->gst_slab)
								); ?>
					      </div> 
                     </div>
					 

					 <div class="form-group form-group-sm">
					    <?php echo form_label($this->lang->line('gst_amount'), 'gst_amount', array('class' => 'control-label col-xs-3')); ?>
					     <div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number','min'=>0,
								  
								'name'=>'gst_amount',
								'id'=>'gst_amount',
								'class'=>'form-control input-sm',
								'value'=>to_currency_no_money(0.00))
								); ?>
					      </div> 
                     </div>

					<div class="form-group form-group-sm ">
					    <?php echo form_label($this->lang->line('ro_receivings_rate_difference'), 'rate_difference', array('class' => 'control-label col-xs-3')); ?>
					     <div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number',
								'name'=>'rate_difference',
								'id'=>'rate_difference',
								'class'=>'form-control input-sm',
								'value'=>to_currency_no_money(0.00))
								); ?>
					      </div> 
                     </div>
					 <div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('expenses_employee'), 'employee', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-6'>
				<?php echo form_dropdown('employee_id', $employees,$ro_receivings_info->employee_id, 'id="employee_id"  class="form-control"');?>
			</div>
		</div>
					 <!-- <div class="form-group form-group-sm">
					    <?php echo form_label($this->lang->line('total_stock'), 'total_stock', array('class' => 'control-label col-xs-3')); ?>
					     <div class='col-xs-8'>
						<?php echo form_input(array('type'=>'number',
								'name'=>'total_stock',
								'id'=>'total_stock',
								'class'=>'form-control input-sm',
								'value'=>$ro_receivings_info->total_stock)
								); ?>
					      </div> 
                     </div>
              </div>
              </div>          -->
          
               
          
              </fieldset>

			 


			  
<?php echo form_close(); ?>

<script type="text/javascript">

$('#supplier_name').click(function() {
		$(this).attr('value', '');
	});
	var today = new Date().toISOString().split('T')[0];
	  document.getElementsByName("cheque_date")[0].setAttribute('min',today);
	// $('#cheque_date').attr('min',today);

	$('#supplier_name').autocomplete({
		source: '<?php echo site_url("Items/suggest_supplier"); ?>',
		minChars:0,
		delay:10,
		select: function (event, ui) {
			$('#supplier_id').val(ui.item.value);
			$(this).val(ui.item.label);
			$(this).attr('');
			$('#remove_supplier_button').css('display', 'inline-block');
			return false;
		}
	});

	$('#supplier_name').blur(function() {
		$(this).attr('value',"<?php echo $this->lang->line('expenses_start_typing_supplier_name'); ?>");
	});

	$('#remove_supplier_button').css('display', 'none');

	$('#remove_supplier_button').click(function() {
		$('#supplier_id').val('');
		$('#supplier_name').removeAttr('readonly');
		$('#supplier_name').val('');
		$(this).css('display', 'none');
	});

	<?php
	if(!empty($expenses_info->expense_id))
	{
	?>
		$('#supplier_id').val('<?php echo $expenses_info->supplier_id ?>');
		$('#supplier_name').val('<?php echo $expenses_info->supplier_name ?>').attr('readonly', 'readonly');
		$('#remove_supplier_button').css('display', 'inline-block');
	<?php
	}
	?>
	
$(document).ready(function()
{
	// var today = new Date().toISOString().slice(0, 10);
	var today = new Date().toISOString().split('T')[0];
	//  document.getElementsByName("cheque_date")[0].setAttribute('min',today);
	$('#cheque_date').attr('min',today);
	
	$('.cheque_number'). hide();
	$('.cheque_date'). hide();
	$('.payment_mode').hide();
	
	
	$('#payment_mode').on("change",function()
{

	
	$cheque= $('#payment_mode option:selected').text();
	if($cheque=="Cheque")
	{
		$('.cheque_number').show();
		$('.cheque_date'). show();
		$("#discount").attr('disabled', true); 
		$("#purchase_return_qty").attr('disabled', true); 
		$("#purchase_return_amount").attr('disabled', true);
		//$("#paid_amount").attr('required',true);
		
		 
	}
	else{
		$("#discount").attr('disabled', false); 
		$("#purchase_return_qty").attr('disabled', false); 
		$("#purchase_return_amount").attr('disabled', false);
	
		$('.cheque_number'). hide();
		$('.cheque_date'). hide();
		//$("#paid_amount").attr('required',false);
	}
});

	$('#supplier_company_id').change(function()
{	
 	$var= $('#supplier_company_id option:selected').text();
    $supplier_id= $('#supplier_company_id option:selected').val();
    $('#supplier_id').val($supplier_id);  
 	 $.ajax({
			type: 'POST',
			url: "<?php echo site_url('Roreceivings/ro_company_id/'); ?>" + $supplier_id,         
            datatype : 'json',            
            }).done(function (msg) {
                
				$('#opening_balance').val(msg);                
            }).fail(function (errorMsg)
			{            
			   $('#opening_balance').val('0');
        });
});		
	$('#paid_amount,#purchase_return_amount').change(function(){
		if($('#paid_amount').val() ==0.00 && $('#purchase_return_amount').val()==0.00)
		{
			$('.payment_mode').hide();
		}
		else{
		$('.payment_mode').show();
		}
	})




$("form").on("change", "input","click", function(e)
{       
	var paid_amt_for_mode = parseFloat($('#paid_amount').val());
	var purchase_amt_for_mode = parseFloat($('#purchase_amount').val());
	if(purchase_amt_for_mode > 0 && paid_amt_for_mode < 1){
		$("#payment_mode").attr('required',false);
	}else{
		$("#payment_mode").attr('required',true);
	}
	var payment_mode=$('#payment_mode').val();		
		if(payment_mode=="Cheque")
		{
					
		var	open_bal=parseFloat($('#opening_balance').val());
		var purchase_amt=parseFloat($('#purchase_amount').val());
		var closing_bal = open_bal + purchase_amt;
		$('#closing_balance').val(closing_bal);
		$('#pending_payables').val(closing_bal);
		
		var purchase_amt=parseFloat($('#purchase_amount').val());
		var paid_amt=parseFloat($('#paid_amount').val());
	
		var discount= parseFloat($('#discount').val());	


	}
	else{
		
                var	open_bal=parseFloat($('#opening_balance').val());
				var purchase_amt=parseFloat($('#purchase_amount').val());
				$('#paid_amount').on("focusin" ,function(e)
				{
					//$('#paid_amount').val("");					

				});			
			    var paid_amt=parseFloat($('#paid_amount').val());							
				var final_amt= (open_bal+purchase_amt)-paid_amt;
				$('#closing_balance').val(final_amt);
																	
				var return_amt=parseFloat($('#purchase_return_amount').val());
				$('#discount_amount').on("focusin",function()
				{
					$('#discount').val("");
				});				
				var discount= parseFloat($('#discount').val());
				var pending_payables=(final_amt-return_amt)-discount;
				$('#pending_payables').val(pending_payables);
			}
		
			
		});	
		
	$('#ro_receivings_edit_form').validate($.extend({
		submitHandler: function(form,event) {
			
			if($('#purchase_amount').val()==0 && $('#purchase_return_amount').val()==0 && $('#paid_amount').val()==0){
				$('#submit').attr('disabled',false);
				alert("Please enter puchase amount or purchase return amount or receiving amount");
				// dialog_support.show();
				 $('#submit').attr('disabled',false);
			 event.preventDefault();
			}

			 else{


				// var isAdjust = false;
				// var cheque_date = $("input[name='cheque_date']").val();
				//alert(cheque_date);
				// var today = new Date().toISOString().slice(0, 10);

			    // if (cheque_date <= today) {

				// 	var payment_mode=$('#payment_mode').val();

				// 	// if(payment_mode=="Cheque"){

				// 	// 		if(confirm("It seems the cheque is predated. Press Ok if the amount is already settled.")){
				// 	// 			isAdjust = true;
				// 	// 			// $('<input>').attr({
				// 	// 			// 	type: 'hidden',
				// 	// 			// 	id: 'cheque_processing',
				// 	// 			// 	name: 'cheque_processing',
				// 	// 			// 	value: isAdjust
				// 	// 			// }).appendTo('form');
								
				// 	// 		}
				// 	// }

			     

			$(form).ajaxSubmit({
				success: function(response)
				{
					dialog_support.hide();
					table_support.handle_submit("<?php echo site_url($controller_name); ?>", response);
					location.reload();
				},
				dataType: 'json'
			});
		 }
		},

		errorLabelContainer: '#error_message_box',

		rules:

		{  	
						
			company_name:"required",	
			cheque_number:"required",
			paid_amount:"required",
			purchase_return_amount:"required",
			discount:"required",

			paid_amount :
			{
				remote: {
				url: "<?php echo site_url($controller_name . '/paid_amount_validate')?>",
				type: 'POST',
				data: {
							
							'payment_mode':function(){
								return $('#payment_mode').val();

							},
							'paid_amount' : function()
							{ 
								return $('#paid_amount').val();
							},
					  }
				}
			},
			// payment_mode:
			// {
			// 	remote :{
			// 		url: "<?php echo site_url($controller_name . '/payment_mode_validate')?>",
			// 	type: 'POST',
			// 	data: {
							
							
			// 				'paid_amount' : function()
			// 				{ 
			// 					return $('#paid_amount').val();
			// 				},
			// 				'purchase_amount' : function()
			// 				{ 
			// 					return $('#purchase_amount').val();
			// 				},
			// 				'payment_mode':function(){
			// 					return $('#payment_mode').val();

			// 				},
			// 		  }

			// 	}
			// }
				
			
		},
		messages:
	{ 	 
		paid_amount :
			{
				remote:"<?php echo $this->lang->line('paid_amount_required'); ?>"
			},
		company_name: "<?php echo $this->lang->line('supplier_name_required'); ?>",		
		 payment_mode:"<?php echo $this->lang->line('ro_receivings_payment_mode_required'); ?>",
		 cheque_number:	"<?php echo $this->lang->line('cheque_number_required'); ?>",	
		 paid_amount: "<?php echo $this->lang->line('ro_receivings_paid_amount_required'); ?>",
		 purchase_return_amount: "<?php echo $this->lang->line('ro_receivings_purchase_return_amount_required'); ?>",
		 discount: "<?php echo $this->lang->line('ro_receivings_discount_required'); ?>"

	}	
	}, form_support.error));	
});

</script>