<?php $this->load->view("partial/header"); ?>

<?php
if(isset($error))
{
	echo "<div class='alert alert-dismissible alert-danger'>".$error."</div>";
}

if(!empty($warning))
{
	echo "<div class='alert alert-dismissible alert-warning'>".$warning."</div>";
}

if(isset($success))
{
	echo "<div class='alert alert-dismissible alert-success'>".$success."</div>";
}
?>

<div id="register_wrapper">

<!-- Top register controls -->

	<?php echo form_open($controller_name."/change_mode", array('id'=>'mode_form', 'class'=>'form-horizontal panel panel-default')); ?>
		<div class="panel-body form-group">
			<ul>
				<li class="pull-left first_li">
					<label class="control-label"><?php echo $this->lang->line('sales_mode'); ?></label>
				</li>
				
				<li class="pull-left">
					<?php echo form_dropdown('mode', $modes, $mode, array('onchange'=>"$('#mode_form').submit();",'id'=>'mode', 'class'=>'selectpicker show-menu-arrow mode', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
				</li>
				
				<!-- <li class="pull-left ">	
					<input type="checkbox">
					<label class="control-label"><b><?php echo $this->lang->line('sales_ebill_with_address'); ?></b></label>
                </li>			  -->
												 
				<?php
				if($this->config->item('dinner_table_enable') == TRUE)
				{
				?>
					<li class="pull-left first_li">
						<label class="control-label"><?php echo $this->lang->line('sales_table'); ?></label>
					</li>
					<li class="pull-left">
						<?php echo form_dropdown('dinner_table', $empty_tables, $selected_table, array('onchange'=>"$('#mode_form').submit();", 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
					</li>
				<?php
				}
				if(count($stock_locations) > 1)
				{
				?>
					<li class="pull-left">
						<label class="control-label"><?php echo $this->lang->line('sales_stock_location'); ?></label>
					</li>
					<li class="pull-left">
						<?php echo form_dropdown('stock_location', $stock_locations, $stock_location, array('onchange'=>"$('#mode_form').submit();", 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
					</li>
				<?php
				}
				?>

				<!-- <li class="pull-right">
					<button class='btn btn-default btn-sm modal-dlg' id='show_suspended_sales_button' data-href="<?php echo site_url($controller_name."/suspended"); ?>"
							title="<?php echo $this->lang->line('sales_suspended_sales'); ?>">
						<span class="glyphicon glyphicon-align-justify">&nbsp</span><?php echo $this->lang->line('sales_suspended_sales'); ?>
					</button>
				</li> -->

				<li class="pull-right">
					<?php echo anchor("Ro_sales_cheque/manage", '<span class="glyphicon glyphicon-check">&nbsp</span>' . $this->lang->line('ro_checque_approve'),
					array('class'=>'btn btn-info btn-sm pull-right', 'id'=>'sales_takings_button', 'title'=>$this->lang->line('ro_checque_approve'))); ?>
			
				</li>

				<li class="pull-right">
					<?php echo anchor($controller_name."/bulk_entry_view", '<span class="glyphicon glyphicon-book">&nbsp</span>' . $this->lang->line('sales_bulk_entry'),
					array('class'=>'btn btn-info btn-sm pull-right', 'id'=>'sales_takings_button', 'title'=>$this->lang->line('sales_bulk_entry'))); ?>
			
				</li>
				<li class="pull-right">
					
				<div class='btn btn-info btn-sm pull-right' id='new_button' name='new_button'><span class="glyphicon glyphicon-tasks">&nbsp</span><?php echo $this->lang->line('new_sale'); ?></div>			

			</li>


				<?php
				if($this->Employee->has_grant('reports_sales', $this->session->userdata('person_id')))
				{
				?>
					<li class="pull-right">
						<?php echo anchor("Ro_daily_sale/manage", '<span class="glyphicon glyphicon-tags">&nbsp</span>' . $this->lang->line('sales_takings'),
									array('class'=>'btn btn-info btn-sm', 'id'=>'sales_takings_button', 'title'=>$this->lang->line('sales_takings'))); ?>
					</li>
				<?php
				}
				?>

			</ul>
		</div>
	<?php echo form_close(); ?>
	

	<?php echo form_open($controller_name."/select_customer", array('id'=>'select_customer_form', 'class'=>'form-horizontal')); ?>
			<?php
			if(isset($customer))
			{
			?>
				<table class="sales_table_100">
					<tr>
						<th style="width: 5%;"><?php echo $this->lang->line("sales_customer"); ?></th>
						<th style="width:15%; text-align: left;"><?php echo anchor('customers/view/'.$customer_id, $customer, array('class' => 'modal-dlg', 'data-btn-submit' => $this->lang->line('common_submit'), 'title' => $this->lang->line('customers_update'))); ?></th>
					</tr>
					<?php
					if(!empty($customer_email))
					{
					?>
						<tr>
							<th style="width: 5%;"><?php echo $this->lang->line("sales_customer_email"); ?></th>
							<th style="width: 45%; text-align: left;"><?php echo $customer_email; ?></th>
						</tr>
					<?php
					}
					?>
					<?php
					if(!empty($customer_address))
					{
					?>
						<tr>
							<th style="width: 5%;"><?php echo $this->lang->line("sales_customer_address"); ?></th>
							<th style="width: 45%; text-align: left;"><?php echo $customer_address; ?></th>
						</tr>
					<?php
					}
					?>
					<?php
					if(!empty($customer_location))
					{
					?>
						<tr>
							<th style="width: 5%;"><?php echo $this->lang->line("sales_customer_location"); ?></th>
							<th style="width: 45%; text-align: left;"><?php echo $customer_location; ?></th>
						</tr>
					<?php
					}
					?>
					<!-- <tr>
						<th style="width: 5%;"><?php echo $this->lang->line("sales_customer_discount"); ?></th>
						<th style="width: 45%; text-align: left;"><?php echo ($customer_discount_type == FIXED)?to_currency($customer_discount):$customer_discount . '%'; ?></th>
					</tr> -->
					<?php if($this->config->item('customer_reward_enable') == TRUE): ?>
					<?php
					if(!empty($customer_rewards))
					{
					?>
						<tr>
							<th style="width: 5%;"><?php echo $this->lang->line("rewards_package"); ?></th>
							<th style="width: 45%; text-align: left;"><?php echo $customer_rewards['package_name']; ?></th>
						</tr>
						<tr>
							<th style="width: 5%;"><?php echo $this->lang->line("customers_available_points"); ?></th>
							<th style="width: 45%; text-align: left;"><?php echo $customer_rewards['points']; ?></th>
						</tr>
					<?php
					}
					?>
					<?php endif; ?>
					<!-- <tr>
						<th style="width: 5%;"><?php echo $this->lang->line("sales_customer_total"); ?></th>
						<th style="width: 45%; text-align: left;"><?php echo to_currency($customer_total); ?></th>
					</tr> -->
					<?php
					if(!empty($mailchimp_info))
					{
					?>
						<tr>
							<th style="width: 5%;"><?php echo $this->lang->line("sales_customer_mailchimp_status"); ?></th>
							<th style="width: 45%; text-align: left;"><?php echo $mailchimp_info['status']; ?></th>
						</tr>
					<?php
					}
					?>
				</table>

				<button class="btn btn-danger btn-sm" id="remove_customer_button" name="remove_customer_button" title="<?php echo $this->lang->line('common_remove').' '.$this->lang->line('customers_customer')?>">
					<span class="glyphicon glyphicon-remove">&nbsp</span><?php echo $this->lang->line('common_remove').' '.$this->lang->line('customers_customer') ?>
				</button>
				
			<?php
			}
			else
			{
			?>
			<div class="form-group" id="add_item_form" >				
					
				<label id="customer_label" for="customer" class="control-label pull-left" style="margin-left: 1em; margin-top: 0.5em;"><?php echo $this->lang->line('sales_select_customer') . ' ' . $customer_required; ?></label>
				<div class='col-xs-6 pull-center'style=' margin-top: 1em; margin-bottom: 0.1em;'>
				
				<?php echo form_input(array('name'=>'customer', 'id'=>'customer','class'=>'form-control input-sm','style'=>"margin-left: 1em; margin-bottom: 0.7em;", 'value'=>$this->lang->line('sales_start_typing_customer_name'))); ?>
			
					<!-- <button class='btn btn-info btn-sm modal-dlg' data-btn-submit="<?php echo $this->lang->line('common_submit') ?>" data-href="<?php echo site_url("customers/view"); ?>"
							title="<?php echo $this->lang->line($controller_name. '_new_customer'); ?>">
						<span class="glyphicon glyphicon-user">&nbsp</span><?php echo $this->lang->line($controller_name. '_new_customer'); ?>
					</button>					 -->
					<!-- <button class='btn btn-default btn-sm modal-dlg' id='show_keyboard_help' data-href="<?php echo site_url("$controller_name/sales_keyboard_help"); ?>"
							title="<?php echo $this->lang->line('sales_key_title'); ?>">
						<span class="glyphicon glyphicon-share-alt">&nbsp</span><?php echo $this->lang->line('sales_key_help'); ?>
					</button> -->
				</div></div>
			<?php
			}
			?>
		<?php echo form_close(); ?>
	


	<?php $tabindex = 0; 
	?>
	
	<?php echo form_open($controller_name."/add", array('id'=>'add_item_form', 'class'=>'form-horizontal panel panel-default')); ?>
		<div class="panel-body form-group">
			<ul>
				<li class="pull-left first_li">
					<label for="item" class='control-label'><?php echo $this->lang->line('sales_find_or_scan_item_or_receipt'); ?></label>
				</li>
				<li class="pull-left">
					<?php echo form_input(array('name'=>'item', 'id'=>'item', 'class'=>'form-control input-sm', 'size'=>'50', 'tabindex'=>++$tabindex)); ?>
					<span class="ui-helper-hidden-accessible" role="status"></span>
				</li>
				<li class="pull-right">
					<button id='new_item_button' class='btn btn-info btn-sm pull-right modal-dlg' data-btn-new="<?php echo $this->lang->line('common_new') ?>" data-btn-submit="<?php echo $this->lang->line('common_submit')?>" data-href="<?php echo site_url("items/view"); ?>"
							title="<?php echo $this->lang->line($controller_name . '_new_item'); ?>">
						<span class="glyphicon glyphicon-tag">&nbsp</span><?php echo $this->lang->line($controller_name. '_new_item'); ?>
					</button>
				</li>
			</ul>
		</div>
	<?php echo form_close(); ?></div>
	
<!-- Overall Sale -->
	<div id="overall_sale" class="panel panel-default right">
	<div class="panel-body">

		<table class="sales_table_100">
			<tr>
			<?php	if($mode=='return')
				{?>
				<th style="width: 55%;"><?php echo $this->lang->line('sales_quantity_of_items',$item_count); ?></th>
				<th style="width: 45%; text-align: right;"><?php echo -$total_units; ?></th>
			<?php	}
				else
				{?>
					<th style="width: 55%;"><?php echo $this->lang->line('sales_quantity_of_items',$item_count); ?></th>
				<th style="width: 45%; text-align: right;"><?php echo $total_units; ?></th>
				<?php
			}?>
			</tr>
			<!-- <tr>
				<th style="width: 55%;"><?php echo $this->lang->line('sales_sub_total'); ?></th>
				<th style="width: 45%; text-align: right;"><?php echo to_currency($subtotal); ?></th>
			</tr> -->

			<?php
			foreach($taxes as $tax_group_index=>$tax)
			{
			?>
				<tr>
					<th style="width: 55%;"><?php echo (float)$tax['tax_rate'] . '% ' . $tax['tax_group']; ?></th>
					<th style="width: 45%; text-align: right;"><?php echo to_currency_tax($tax['sale_tax_amount']); ?></th>
				</tr>
			<?php
			}
			?>

			<tr>
				
				<th style="width: 55%; font-size: 150%"><?php echo $this->lang->line('sales_total'); ?></th>
				<th style="width: 45%; font-size: 150%; text-align: right;"><span id="sale_total"><?php echo to_currency($total); ?></span></th>
				
			</tr>
		</table>

		<?php
		$is_add_payment='0';
	
		
		// Only show this part if there are Items already in the register
		if(count($cart) > 0)
		{
		?>
			<table class="sales_table_100" id="payment_totals">
				<tr>
					<th style="width: 55%;"><span id="sales_payments_total_lable"><?php echo $this->lang->line('sales_payments_total'); ?></span></th>
					<th style="width: 45%; text-align: right;"><span id="sales_payments_total"><?php echo to_currency($payments_total); ?></span></th>
				</tr>
				<!-- <tr>
					<th style="width: 55%; font-size: 120%"><span id="sale_amount_due_lable"><?php echo $this->lang->line('sales_amount_due'); ?></span></th>
					<th style="width: 45%; font-size: 120%; text-align: right;"><span id="sale_amount_due"><?php echo to_currency($amount_due); ?></span></th>
				</tr> -->
			</table>

			<div id="payment_details">
		
	
	
				<?php
				// Show Complete sale button instead of Add Payment if there is no amount due left
				if($payments_cover_total)
				{
				?>
					<?php echo form_open($controller_name."/add_payment", array('id'=>'add_payment_form', 'class'=>'form-horizontal')); ?>
						<table class="sales_table_100">
							<tr>
								<td><?php echo $this->lang->line('sales_payment'); ?></td>
								<td>
									<?php echo form_dropdown('payment_type', $payment_options, $selected_payment_type, array('id'=>'payment_types', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit', 'disabled'=>'disabled')); ?>
								</td>
							</tr>
							<tr>
								<td><span id="amount_tendered_label"><?php echo $this->lang->line('sales_amount_tendered'); ?></span></td>
								<td>
								<?php echo form_input(array('type'=>'number','name'=>'amount_tendered', 'id'=>'amount_tendered', 'class'=>'form-control input-sm non-giftcard-input', 'oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null','value'=>to_currency_no_money($amount_due), 'size'=>'5','min'=>'0', 'tabindex'=>++$tabindex, 'onClick'=>'this.select();')); ?>
									<?php echo form_input(array('type'=>'number','name'=>'amount_tendered', 'id'=>'amount_tendered', 'class'=>'form-control input-sm giftcard-input', 'disabled' => true, 'oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null','value'=>to_currency_no_money($amount_due), 'size'=>'5','min'=>'0', 'tabindex'=>++$tabindex)); ?>
								</td>
							</tr>
						</table>
					<?php echo form_close(); ?>
					
					

					<?php
					// Only show this part if in sale or return mode
					if($pos_mode)
					{ 
						$due_payment = FALSE;

						if(count($payments) > 0)
						{
							foreach($payments as $payment_id => $payment)
							{
								if($payment['payment_type'] == $this->lang->line('sales_due'))
								{
									$due_payment =TRUE;
								}
							}
						}
						
						if(!$due_payment || ($due_payment && isset($customer)))
						{
					?>
							<div class='btn btn-sm btn-success pull-right' id='finish_sale_button' tabindex="<?php echo ++$tabindex; ?>"><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $this->lang->line('sales_complete_sale'); ?></div>
					<?php
						}
					}
					?>
				<?php
				}
				else
				{
					
				?>
				
					<?php echo form_open($controller_name."/add_payment", array('id'=>'add_payment_form', 'class'=>'form-horizontal')); ?>
						<table class="sales_table_100">
							<tr>
								<td><?php echo $this->lang->line('sales_payment'); ?></td>
								<td>
									<?php echo form_dropdown('payment_type', $payment_options,  $selected_payment_type, array('id'=>'payment_types', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
								</td>
							</tr>
							<tr>
								<td><span id="amount_tendered_label"><?php echo $this->lang->line('sales_amount_tendered'); ?></span></td>
								<td>
									<?php echo form_input(array('type'=>'number','name'=>'amount_tendered', 'id'=>'amount_tendered', 'class'=>'form-control input-sm non-giftcard-input', 'oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null','value'=>to_currency_no_money($amount_due), 'size'=>'5','min'=>'0' , 'onClick'=>'this.select();')); ?>
									<?php echo form_input(array('type'=>'number','name'=>'amount_tendered', 'id'=>'amount_tendered', 'class'=>'form-control input-sm giftcard-input', 'disabled' => true,'oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null', 'value'=>to_currency_no_money($amount_due),'min'=>'0' ,'size'=>'5')); ?>
								</td>
							</tr>
							<tr>
							<div class="form-group form-group-sm cheque_date" >
		<td>	<?php echo form_label($this->lang->line('ro_receivings_cheque_date'), 'date', array('class'=>' control-label col-xs-3' ,'id'=>'lable_cheque_date')); ?>
				</td><td>	<div class='col-xs-13'>
				<div class="input-group">
					
					<?php echo form_input(array('type'=>'date',
							'id'=>'cheque_date',
							'name'=>'cheque_date',
							'class'=>'form-control input-sm datetime',
 							'value'=>date('Y-m-d'),
                           )
							);?>
				</div>
			</div>
		</div></td>
							</tr>
							<tr><div class="form-group form-group-sm cheque_number" >
					<td><?php echo form_label($this->lang->line('ro_receivings_cheque_number'), 'cheque_number', array('class' => 'control-label col-xs-1', 'id'=>'lable_cheque_number')); ?>
						</td><td><div class='col-xs-13'>
						<?php echo form_input(array('type'=>'number','min'=>'6','max'=>'6','requierd'=>'true',
						
							  'onfocus'=>"this.value=''",
								'name'=>'cheque_number',
								'id'=>'cheque_number',
								'class'=>'form-control input-sm',			
								

								)
								); ?>
					</div> 
                </div></td></tr>
						</table>
					<?php echo form_close(); ?>

					<div class='btn btn-sm btn-success pull-right' id='add_payment_button' ><span class="glyphicon glyphicon-credit-card">&nbsp</span><?php echo $this->lang->line('sales_add_payment'); ?></div>
				<?php
				}
				?>

				<?php
				//  $is_add_payment='1';
				//  echo $is_add_payment;
				// Only show this part if there is at least one payment entered.
				if(count($payments) > 0)
				{
					// print_r('hello');
					$is_add_payment='1';
				?>
					<table class="sales_table_100" id="register">
						<thead>
							<tr>
								<th style="width: 10%;"><?php echo $this->lang->line('common_delete'); ?></th>
								<th style="width: 60%;"><?php echo $this->lang->line('sales_payment_type'); ?></th>
								<th style="width: 20%;"><?php echo $this->lang->line('sales_payment_amount'); ?></th>
							</tr>
						</thead>

						<tbody id="payment_contents">
							<?php
							foreach($payments as $payment_id => $payment)
							{
							?>
								<tr>
									<td><span data-payment-id="<?php echo $payment_id; ?>" class="delete_payment_button"><span class="glyphicon glyphicon-trash"></span></span></td>
									<td><?php echo $payment['payment_type']; ?></td>
									<td style="text-align: right;"><?php echo to_currency($payment['payment_amount']); ?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				<?php
				}
				?>
			</div>

			<?php echo form_open($controller_name."/cancel", array('id'=>'buttons_form')); ?>
				<div class="form-group" id="buttons_sale">
					<!-- <div class='btn btn-sm btn-default pull-left' id='suspend_sale_button'><span class="glyphicon glyphicon-align-justify">&nbsp</span><?php echo $this->lang->line('sales_suspend_sale'); ?></div> -->
					<?php
					// Only show this part if the payment covers the total
			
					if($pos_mode && isset($customer))
					{
						
					?>
						<div class='btn btn-sm btn-success pull-right finish_invoice_quote_button1' id='finish_invoice_quote_button' name= 'finish_invoice_quote_button1'><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $mode_label; ?></div>
					<?php
					}
					
					if(!$pos_mode && isset($customer))
					{
					?>
						<div class='btn btn-sm btn-success pull-right' id='finish_invoice_quote_button'  name= 'finish_invoice_quote_button'><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $mode_label; ?></div>
					<?php
					}
					?>
					<div class='btn btn-sm btn-danger pull-left' id='cancel_sale_button'><span class="glyphicon glyphicon-remove">&nbsp</span><?php echo $this->lang->line('sales_cancel_sale'); ?></div>
				</div>
			<?php echo form_close(); ?>

			<?php
			// Only show this part if the payment cover the total
			if($payments_cover_total || !$pos_mode)
			{
			?>
				<div class="container-fluid">
					<div class="no-gutter row">
						<div class="form-group form-group-sm">
							<div class="col-xs-12">
								<!-- <?php echo form_label($this->lang->line('common_comments'), 'comments', array('class'=>'control-label', 'id'=>'comment_label', 'for'=>'comment')); ?>
								<?php echo form_textarea(array('name'=>'comment', 'id'=>'comment', 'class'=>'form-control input-sm', 'value'=>$comment, 'rows'=>'2')); ?>  -->
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group form-group-sm">
							<div class="col-xs-6">
								<!-- <label for="sales_print_after_sale" class="control-label checkbox">
									<?php echo form_checkbox(array('name'=>'sales_print_after_sale', 'id'=>'sales_print_after_sale', 'value'=>1, 'checked'=>$print_after_sale)); ?>
									<?php echo $this->lang->line('sales_print_after_sale')?>
								</label> -->
							</div>

							<?php
							if(!empty($customer_email))
							{
							?>
								<div class="col-xs-6">
									<!-- <label for="email_receipt" class="control-label checkbox">
										<?php echo form_checkbox(array('name'=>'email_receipt', 'id'=>'email_receipt', 'value'=>1, 'checked'=>$email_receipt)); ?>
										<?php echo $this->lang->line('sales_email_receipt'); ?>
									</label> -->
								</div>
							<?php
							}
							?>
							<?php
							if($mode == 'sale_work_order')
							{
							?>
								<div class="col-xs-6">
									<label for="price_work_orders" class="control-label checkbox">
									<?php echo form_checkbox(array('name'=>'price_work_orders', 'id'=>'price_work_orders', 'value'=>1, 'checked'=>$price_work_orders)); ?>
									<?php echo $this->lang->line('sales_include_prices'); ?>
									</label>
								</div>
							<?php
							}
							?>
						</div>
					</div>
					<?php
					if(($mode == 'sale_invoice') && $this->config->item('invoice_enable') == TRUE)
					{
					?>
						<div class="row">
							<div class="form-group form-group-sm">
								<div class="col-xs-6">
									<label for="sales_invoice_number" class="control-label checkbox">
										<?php echo $this->lang->line('sales_invoice_enable'); ?>
									</label>
								</div>

								<?php
								$date = date('Y-m-d\TH:i');
								//$randam=rand(1, $count);
								$newDate = date("Ymd", strtotime($date));

								?>
								<div class="col-xs-6">
									<div class="input-group input-group-sm">
										<!-- <span class="input-group-addon input-sm"></span> -->
										<?php echo form_input(array('name'=>'sales_invoice_number', 'readonly'=>'readonly','id'=>'sales_invoice_number', 'class'=>'form-control input-sm', 'value'=>'POS '.$newDate.round(bcadd($voucher_no[0]['maxid'],1)))); ?>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			<?php
			}
			?>
		<?php
		}
		?>
	</div>
</div>
	
			</div>
			
<!-- Sale Items List -->
<div class="row" name="cart_save">
	<table class="sales_table_100" id="register" name="register" >
		<thead>
			<tr>
				<th style="width: 5%; "><?php echo $this->lang->line('common_delete'); ?></th>
				<th style="width: 7%;"><?php echo $this->lang->line('sales_serial_number'); ?></th>
				<!-- <th style="width: 15%;"><?php echo $this->lang->line('sales_item_number'); ?></th> -->
				<th style="width: 15%;"><?php echo $this->lang->line('sales_item_name'); ?></th>
				<th style="width: 10%;"><?php echo $this->lang->line('sales_hsn'); ?></th>				
				<th style="width: 7%;"><?php echo $this->lang->line('sales_quantity'); ?></th>
				<th style="width: 7%;"><?php echo $this->lang->line('sales_price'); ?></th>
				<th style="width: 7%;"><?php echo $this->lang->line('sales_tax'); ?></th>
				<th style="width: 7%;"><?php echo $this->lang->line('sales_gross_amount'); ?></th>
				<th style="width: 10%;"><?php echo $this->lang->line('sales_discount'); ?></th>
				
				<th style="width: 7%;"><?php echo $this->lang->line('sales_other_cost'); ?></th>
				
				<th style="width: 10%;"><?php echo $this->lang->line('sales_total'); ?></th>
				<th style="width: 10%;"><?php echo $this->lang->line('sales_narration'); ?></th>
				<!-- <th style="width: 5%; "><?php echo $this->lang->line('sales_update'); ?></th> -->
			</tr>
		</thead>

		<tbody id="cart_contents" name='cart_contents'>
			<?php
			$serial_no_counter=1;
			if(count($cart) == 0)
			{
			?>
				<tr>
					<td colspan='22'>
						<div class='alert alert-dismissible alert-info'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
					</td>
				</tr>
			<?php
			}
			else
			{
				foreach(array_reverse($cart, TRUE) as $line=>$item)
				{
			?>
					<?php echo form_open($controller_name."/edit_item/$line", array('class'=>'form-horizontal', 'id'=>'cart_'.$line)); ?>
						<tr>
							<td>
								<span data-item-id="<?php echo $line; ?>" class="delete_item_button" name="delete_item_button" id="delete_item_button<?php echo $line; ?>" ><span class="glyphicon glyphicon-trash" name="delete_item_button" ></span></span>
								<?php
								echo form_hidden('location', $item['item_location']);
								echo form_input(array('type'=>'hidden', 'name'=>'item_id', 'value'=>$item['item_id']));
								?>
							</td>
							<?php
							if($item['item_type'] == ITEM_TEMP)
							{
							?>
								<td><?php echo form_input(array('name'=>'item_number', 'id'=>'item_number','class'=>'form-control input-sm', 'value'=>$item['item_number'], 'tabindex'=>++$tabindex)); ?></td>
								<td style="align: center;">
									<?php echo form_input(array('name'=>'name','id'=>'name', 'class'=>'form-control input-sm', 'value'=>$item['name'], 'tabindex'=>++$tabindex)); ?>
								</td>
							<?php
							}
							else
							{
							?>
								<td><?php 
										echo $serial_no_counter;
										$serial_no_counter++; ?></td>
								
								<td style="align: center;">
									<?php echo $item['name'] . ' '. implode(' ', array($item['attribute_values'], $item['attribute_dtvalues'])); ?>
									<br/>
									<!-- <?php if ($item['stock_type'] == '0'): echo '[' . to_quantity_decimals($item['in_stock']) . ' in ' . $item['stock_name'] . ']'; endif; ?> -->
								</td>
							<?php
							}
							?>

							<td>
								 <?php
								 echo $item['hsn_code'] ;											
								
								?>
							</td>

							<td>
								<?php
								if($mode=='return')
								{
									if($item['is_serialized'])
								{
									echo to_quantity_decimals(-$item['quantity']);
									echo form_hidden('quantity', -$item['quantity']);
								}
								else
								{
									echo form_input(array('name'=>'quantity','id'=>'quantity','min'=>'0','type'=>'number','oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null','class'=>'form-control input-sm', 'value'=>to_quantity_decimals(-$item['quantity']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));
								}
								}
								else
								{
								if($item['is_serialized'])
								{
									echo to_quantity_decimals($item['quantity']);
									echo form_hidden('quantity', $item['quantity']);
								}
								else
								{
									echo form_input(array('name'=>'quantity','id'=>'quantity','min'=>'0','type'=>'number','oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null','class'=>'form-control input-sm', 'value'=>to_quantity_decimals($item['quantity']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));
								}
								}
								?>
							</td><td>
								 <?php
								if($items_module_allowed && $change_price)
								{
									echo form_input(array('name'=>'price','type'=>'number','oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null','class'=>'form-control input-sm', 'class'=>'form-control input-sm', 'value'=>to_currency_no_money($item['price']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));
								}
								else
								{ 
									echo to_currency($item['price']);
									echo form_hidden('price', to_currency_no_money($item['price']));
								 }
								?>
							</td>
							<td>
								 <?php
								
									echo form_input(array('name'=>'tax','id'=>'tax','type'=>'number','oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null','class'=>'form-control input-sm', 'class'=>'form-control input-sm', 'value'=>to_currency_no_money($item['tax']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));
								
								
								?>
							</td>
							<td>
								
								<?php

								if($item['item_type'] == ITEM_AMOUNT_ENTRY)
								{
									echo form_input(array('name'=>'discounted_total', 'class'=>'form-control input-sm', 'value'=>number_format($item['discounted_total']),'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));
								}
								else
								{
									echo number_format($item['discounted_total']);
								}
								?>
							</td>

							<td>
								<div class="input-group">
									<?php echo form_input(array('name'=>'discount', 'class'=>'form-control input-sm', 'value'=>$item['discount_type'] ? to_currency_no_money($item['discount']) : to_decimals($item['discount']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();')); ?>
									<!-- <span class="input-group-btn">
										<?php echo form_checkbox(array('id'=>'discount_toggle', 'name'=>'discount_toggle', 'value'=>1, 'data-toggle'=>"toggle",'data-size'=>'small', 'data-onstyle'=>'success', 'data-on'=>'<b>'.$this->config->item('currency_symbol').'</b>', 'data-off'=>'<b>%</b>', 'data-line'=>$line, 'checked'=>$item['discount_type'])); ?>
									</span> -->
								</div>
							</td>
							
							
							<td>
								<div class="input-group">
									<?php echo form_input(array('name'=>'other_cost','type'=>'number', 'oninput'=>'this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null','class'=>'form-control input-sm','class'=>'form-control input-sm', 'value'=>$item['other_cost'] ? to_currency_no_money($item['other_cost']) : to_decimals($item['other_cost']), 'tabindex'=>++$tabindex, 'onClick'=>'this.select();')); ?>
									<!-- <span class="input-group-btn">
										<?php echo form_checkbox(array('id'=>'discount_toggle', 'name'=>'discount_toggle', 'value'=>1, 'data-toggle'=>"toggle",'data-size'=>'small', 'data-onstyle'=>'success', 'data-on'=>'<b>'.$this->config->item('currency_symbol').'</b>', 'data-off'=>'<b>%</b>', 'data-line'=>$line, 'checked'=>$item['discount_type'])); ?>
									</span> -->
								</div>
							</td>
							
							<td>
							<?php echo number_format($item['total'],2); ?>
							</td>
							<td>
								 <?php
								
									echo form_input(array('name'=>'item_comments', 'class'=>'form-control input-sm', 'value'=>$item['item_comments'], 'tabindex'=>++$tabindex, 'onClick'=>'this.select();'));
								
								
								?>
							</td>

							<td style=display:none;><a href="javascript:document.getElementById('<?php echo 'cart_'.$line ?>').submit();" title=<?php echo $this->lang->line('sales_update')?> ><span class="glyphicon glyphicon-refresh"></span></a></td>
						</tr>
						<tr>
							<?php
							if($item['item_type'] == ITEM_TEMP)
							{
							?>
								<td><?php echo form_input(array('type'=>'hidden', 'name'=>'item_id', 'value'=>$item['item_id'])); ?></td>
								<td style="align: center;" colspan="6">
									<?php echo form_input(array('name'=>'item_description', 'id'=>'item_description', 'class'=>'form-control input-sm', 'value'=>$item['description'], 'tabindex'=>++$tabindex)); ?>
								</td>
								<td> </td>
							<?php
							}
							else
							{
							?>
								<td> </td>
								<?php
								if($item['allow_alt_description'])
								{
								?>
									<td style="color: #2F4F4F;"><?php echo $this->lang->line('sales_description_abbrv'); ?></td>
								<?php
								}
								?>

								<td colspan='6' style="text-align: left;">
									<?php
									if($item['allow_alt_description'])
									{
										// echo form_input(array('name'=>'description', 'class'=>'form-control input-sm', 'value'=>$item['description'], 'onClick'=>'this.select();'));
									}
									else
									{
										if($item['description'] != '')
										{
											// echo $item['description'];
											// echo form_hidden('description', $item['description']);
										}
										else
										{
											// echo $this->lang->line('sales_no_description');
											// echo form_hidden('description','');
										}
									}
									?>
								</td>
								<td>&nbsp;</td>
								<td style="color: #2F4F4F;">
									<?php
									if($item['is_serialized'])
									{
										echo $this->lang->line('sales_serial');
									}
									?>
								</td>
								<td colspan='4' style="text-align: left;">
									<?php
									if($item['is_serialized'])
									{
										echo form_input(array('name'=>'serialnumber', 'class'=>'form-control input-sm', 'value'=>$item['serialnumber'], 'onClick'=>'this.select();'));
									}
									else
									{
										echo form_hidden('serialnumber', '');
									}
									?>
								</td>
							<?php
							}
							?>
						</tr>
					<?php echo form_close(); ?>
			<?php
				}
			}
			?>
		</tbody>
	</table>
	
</div>
		

<script type="text/javascript">
$(document).ready(function()
{
	var is_add=<?php echo json_encode($is_add_payment);?>;
	var cart_val=<?php echo json_encode($cart);?>;
	var today = new Date().toISOString().split('T')[0];
	var cart_count=<?php echo json_encode($serial_no_counter);?>;
	var serial_no=cart_count-1;
	// alert(cart_count-1);
	//  docart_countcument.getElementsByName("cheque_date")[0].setAttribute('min',today);
	$('#cheque_date').attr('min',today);
	
	// alert(cart_val);
	// console.log(cart_val);
	if(cart_val == "")
	{
		$('#mode').attr('disabled', false);
		$('#remove_customer_button').show();
		$('#new_button').hide();

	
	}
	else{
		$('#mode').attr('disabled',true);		
		$('#remove_customer_button').hide();
		$('#new_button').show();
	}
	$('#new_button').click(function() {
		// alert(cart_val);
		if(cart_val == ""){
			window.location.reload();
		}
		else{
		if(confirm("Do you want to start new sale ?"))
		{
			
			$('#buttons_form').attr('action', "<?php echo site_url($controller_name.'/cancel'); ?>");
			
			$('#buttons_form').submit();
		}
		}
	});
	
	const redirect = function() {
		window.location.href = "<?php echo site_url('sales'); ?>";
	};
	
	
	$("#remove_customer_button").click(function()
	{
		$.post("<?php echo site_url('sales/remove_customer'); ?>", redirect);
	});

	$(".delete_item_button").click(function()
	{
		const item_id = $(this).data('item-id');
		$.post("<?php echo site_url('sales/delete_item/'); ?>" + item_id, redirect);
	});

	$(".delete_payment_button").click(function() {
		const item_id = $(this).data('payment-id');
		$.post("<?php echo site_url('sales/delete_payment/'); ?>" + item_id, redirect);
	});

	$("input[name='item_number']").change(function() {
		var item_id = $(this).parents('tr').find("input[name='item_id']").val();
		var item_number = $(this).val();
		$.ajax({
			url: "<?php echo site_url('sales/change_item_number'); ?>",
			method: 'post',
			data: {
				'item_id': item_id,
				'item_number': item_number,
			},
			dataType: 'json'
		});
	});

	$("input[name='name']").change(function() {
		var item_id = $(this).parents('tr').find("input[name='item_id']").val();
		var item_name = $(this).val();
		$.ajax({
			url: "<?php echo site_url('sales/change_item_name'); ?>",
			method: 'post',
			data: {
				'item_id': item_id,
				'item_name': item_name,
			},
			dataType: 'json'
		});
	});

	$("input[name='item_description']").change(function() {
		var item_id = $(this).parents('tr').find("input[name='item_id']").val();
		var item_description = $(this).val();
		$.ajax({
			url: "<?php echo site_url('sales/change_item_description'); ?>",
			method: 'post',
			data: {
				'item_id': item_id,
				'item_description': item_description,
			},
			dataType: 'json'
		});
	});	

	$('#item').blur(function() {
		$(this).val("<?php echo $this->lang->line('sales_start_typing_item_name'); ?>");
	});

	$('#item').autocomplete( {
		
		
		source: "<?php echo site_url($controller_name . '/item_search'); ?>",
		minChars: 0,
		autoFocus: false,
		delay: 500,
		select: function (a, ui) {
			$(this).val(ui.item.value);
			item_id=ui.item.value;			
			$('#add_item_form').submit();
			
			return false;
		}
	});

	$('#item').keypress(function (e) {
		if(e.which == 13) {
			$('#add_item_form').submit();
			return false;
		}
	});
	if($('#mode').val()=='sale')
	{
		$("input[name='tax']").attr('disabled', true);
		
	}
	if($('#mode').val()=='return')
	{
		$("input[name='discount']").attr('disabled', true);
		$("input[name='other_cost']").attr('disabled', true);
		 $("#payment_types option[value='Cheque']").attr("disabled","disabled");
	}
	
	// var mode= $('#mode option:selected').text();
	//  alert(mode);
	 
	
// $('#mode').change(function(event){
	
// 	if(confirm("Do you want to change the mode?"))
// 		{ 
// 				console.log('mode_if');
// 			$('#buttons_form').attr('action', "<?php echo site_url($controller_name.'/cancel'); ?>");
// 			$('#buttons_form').submit();
// 		}
		
// 		else{
// 			console.log('mode else');
// 			// table_support.refresh();
// 			//  window.location.reload();
// 		 event.preventDefault()
// 		 return false;
			
// 		}
		
	
// });

	// $("#amount_tendered").keydown(function (event) {
			
	// 	$('input[name=quantity]').focus();
            
            
    //  });


	var clear_fields = function() {
		if($(this).val().match("<?php echo $this->lang->line('sales_start_typing_item_name') . '|' . $this->lang->line('sales_start_typing_customer_name'); ?>"))
		{
			
			$(this).val('');
		}
	};

	$('#item, #customer').click(clear_fields).dblclick(function(event) {
		
		$(this).autocomplete('search');
	});
	
	$("input[name='name']").change(function() {
		var item_id = $(this).parents('tr').find("input[name='item_id']").val();
		var item_name = $(this).val();
		$.ajax({
			url: "<?php echo site_url('sales/change_item_name'); ?>",
			method: 'post',
			data: {
				'item_id': item_id,
				'item_name': item_name,
			},
			dataType: 'json'
		});
	});


	$('#customer').blur(function() {
		$(this).val("<?php echo $this->lang->line('sales_start_typing_customer_name'); ?>");
	});

	$('#customer').autocomplete( {
		source: "<?php echo site_url('customers/suggest'); ?>",
		minChars: 0,
		delay: 10,
		select: function (a, ui) {
			$('#customer').val(ui.item.value);
			$(this).val(ui.item.lable);
			$(this).val(ui.item.value);
			$('#select_customer_form').submit();
			return false;
		}
	});

	$('#customer').keypress(function (e) {
		if(e.which == 13) {
			$('#select_customer_form').submit();
			return false;
		}
	});
	$("input[name='item_price']").change(function() {
		var item_id = $(this).parents('tr').find("input[name='item_id']").val();
		var item_description = $(this).val();
		$.ajax({
			url: "<?php echo site_url('sales/change_item_description'); ?>",
			method: 'post',
			data: {
				'item_id': item_id,
				'item_description': item_description,
			},
			dataType: 'json'
		});
	});

	$('.giftcard-input').autocomplete( {
		source: "<?php echo site_url('giftcards/suggest'); ?>",
		minChars: 0,
		delay: 10,
		select: function (a, ui) {
			$(this).val(ui.item.value);
			$('#add_payment_form').submit();
			return false;
		}
	});

	$('#comment').keyup(function() {
		$.post("<?php echo site_url($controller_name.'/set_comment'); ?>", {comment: $('#comment').val()});
	});

	<?php
	if($this->config->item('invoice_enable') == TRUE)
	{
	?>
		$('#sales_invoice_number').keyup(function() {
			$.post("<?php echo site_url($controller_name.'/set_invoice_number'); ?>", {sales_invoice_number: $('#sales_invoice_number').val()});
		});

	<?php
	}
	?>

	$('#sales_print_after_sale').change(function() {
		$.post("<?php echo site_url($controller_name.'/set_print_after_sale'); ?>", {sales_print_after_sale: $(this).is(':checked')});
	});

	$('#price_work_orders').change(function() {
		$.post("<?php echo site_url($controller_name.'/set_price_work_orders'); ?>", {price_work_orders: $(this).is(':checked')});
	});

	$('#email_receipt').change(function() {
		$.post("<?php echo site_url($controller_name.'/set_email_receipt'); ?>", {email_receipt: $(this).is(':checked')});
	});

	$('#finish_sale_button').click(function() {
		$('#buttons_form').attr('action', "<?php echo site_url($controller_name.'/complete'); ?>");
		$('#buttons_form').submit();
	});

	$('#finish_invoice_quote_button').click(function() {
		$('#buttons_form').attr('action', "<?php echo site_url($controller_name.'/complete'); ?>");
		$('#buttons_form').submit();
	});

	$('#suspend_sale_button').click(function() {
		$('#buttons_form').attr('action', "<?php echo site_url($controller_name.'/suspend'); ?>");
		$('#buttons_form').submit();
	});

	$('#cancel_sale_button').click(function() {
		if(confirm("<?php echo $this->lang->line('sales_confirm_cancel_sale'); ?>"))
		{
			$('#buttons_form').attr('action', "<?php echo site_url($controller_name.'/cancel'); ?>");
			$('#buttons_form').submit();
		}
	});

	$('#add_payment_button').click(function(e) 
	{
		// $("input[name='item']").attr('disabled', true);
		// $("input[name='item']").hide();
		var isAdjust = false;
		if($("#payment_types").val() == "Cheque")
		{	if($('#cheque_number').val()=="")
			{
				alert("please enter the check number");
				e.preventDefault();
				
			}

			 else{		

			
			// var cheque_date = $("input[name='cheque_date']").val();
			// // alert(cheque_date);
			// var today = new Date().toISOString().slice(0, 10);
			// // alert(today);
			// var $payed_amt =$('#amount_tendered').val();
			// // alert($payed_amt);
			// if(cheque_date <= today){
			// 	if(confirm("It seems the cheque is Pre-Dated. Press Ok if the amount is already settled.")){
			// 					isAdjust = true;
			// 					$('<input>').attr({
			// 						type: 'hide',
			// 						id: 'cheque_processing',
			// 						name: 'cheque_processing',
			// 						value: isAdjust
			// 					}).appendTo('form');
								
			// 				}
			// }

			$('#add_payment_form').submit();	
				
		}
	}
		else{
			var isAdjust = false;
			
			if(confirm("Items in the cart can't be added or modified after payment. Do you want to make payment?"))
			{						
				// $("input[name='item']").attr('disabled', true);		
				// $("input[name='register']").hide()	;
				// document.getElementsByClassName('single_add_to_cart_button')[0].disabled = true;
				// $('#delete_item_button').hide();
		$('#add_payment_form').submit();	
		
			}
			
		}	
	});
	

	$('#payment_types').change(check_payment_type).ready(check_payment_type);

	

	$('#cart_contents input').keypress(function(event) {
		if(event.which == 13)
		{
			$(this).parents('tr').prevAll('form:first').submit();
		}
	});

	$('#amount_tendered').keypress(function(event) {
		if(event.which == 13)
		{
			$('#add_payment_form').submit();
		}
	});

	$('#finish_sale_button').keypress(function(event) {
		if(event.which == 13)
		{
			$('#finish_sale_form').submit();
		}
	});


	dialog_support.init('a.modal-dlg, button.modal-dlg');

	table_support.handle_submit = function(resource, response, stay_open) {
		$.notify( { message: response.message }, { type: response.success ? 'success' : 'danger'} )

		if(response.success)
		{
			if(resource.match(/customers$/))
			{
				$('#customer').val(response.id);
				$('#select_customer_form').submit();
			}
			else
			{
				var $stock_location = $("select[name='stock_location']").val();
				$('#item_location').val($stock_location);
				$('#item').val(response.id);
				if(stay_open)
				{
					$('#add_item_form').ajaxSubmit();
				}
				else
				{
					$('#add_item_form').submit();
				}
			}
		}
	}
	
	$('[name="price"],[name="quantity"],[name="discount"],[name="description"],[name="serialnumber"],[name="discounted_total"],[name="other_cost"],[name="tax"],[name="item_comments"]').change(function() {
		// $('input[name=other_cost]').focus();
		$(this).parents('tr').prevAll('form:first').submit()
	});
	$('[name="quantity"]').change(function() {
		$(this).parents('tr').prevAll('form:first').submit()
		 $('input[name=name="price"]').focus();

		//  $(this).parents('tr').prevAll('form:first').submit()
	});


	$('[name="discount_toggle"]').change(function() {
		var input = $('<input>').attr('type', 'hidden').attr('name', 'discount_type').val(($(this).prop('checked'))?1:0);
		$('#cart_'+ $(this).attr('data-line')).append($(input));
		$('#cart_'+ $(this).attr('data-line')).submit();

	});
	function check_payment_type()

{	
	var cash_mode = <?php echo json_encode($cash_mode); ?>;
	
	 $('#cheque_date').hide();
	$('#cheque_number').hide();
	$('#lable_cheque_date').hide();
	$('#lable_cheque_number').hide();
	

	if($('#mode').val()=='sale'||$('#mode').val()=='sale_invoice'||$('#mode').val()=='return')
	{ 
		if( is_add == '0')
		{

		$('#finish_invoice_quote_button').attr('disabled', true);
		
		}
		else
		{		
			// console.log(cart_val.lenght());
			$("input[name='item']").attr('disabled', true);				 
			$('#payment_details').hide();
			$('#finish_invoice_quote_button').attr('disabled', false);
		
		for(var i=1; i<=serial_no;i++)
		{		
		$('#delete_item_button'+i).hide();
		}
		   $("#register *").attr("disabled",true);
		  
		}
	}
	else{
		$('#payment_totals').hide();		
		$('#payment_details').hide();
		$('#finish_invoice_quote_button').attr('disabled',false);
		
	}		
	
	

	if($("#payment_types").val() == "<?php echo $this->lang->line('sales_giftcard'); ?>")
	{
		$("#sale_total").html("<?php echo to_currency($total); ?>");
		$("#sale_amount_due").html("<?php echo to_currency($amount_due); ?>");
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_giftcard_number'); ?>");
		$("#amount_tendered:enabled").val('').focus();
		$(".giftcard-input").attr('disabled', false);
		$(".non-giftcard-input").attr('disabled', true);
		$(".giftcard-input:enabled").val('').focus();
	}
	else if(($("#payment_types").val() == "<?php echo $this->lang->line('sales_cash'); ?>" && cash_mode == '1'))
	{
		$("#sale_total").html("<?php echo to_currency($non_cash_total); ?>");
		$("#sale_amount_due").html("<?php echo to_currency($cash_amount_due); ?>");
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");
		$("#amount_tendered:enabled").val("<?php echo to_currency_no_money($cash_amount_due); ?>");
		$(".giftcard-input").attr('disabled', true);
		$(".non-giftcard-input").attr('disabled', false);
	}
	else if($("#payment_types").val() == "Cheque")
	 {
		
		$('#cheque_date').show();
		$('#cheque_number').show();
		$('#lable_cheque_date').show();
		$('#lable_cheque_number').show();	

 		
	}
	else
	{
		$("#sale_total").html("<?php echo to_currency($non_cash_total); ?>");
		$("#sale_amount_due").html("<?php echo to_currency($amount_due); ?>");
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");
		$("#amount_tendered:enabled").val("<?php echo to_currency_no_money($amount_due); ?>");
		$(".giftcard-input").attr('disabled', true);
		$(".non-giftcard-input").attr('disabled', false);
		// $('#finish_invoice_quote_button').attr('disabled', true);
	}
	if($('#mode').val()=='return')
	{
		$("#sale_total").html("<?php echo to_currency(-$non_cash_total); ?>");
	$("#amount_tendered_label").html("<?php echo "Return Amount" ?>");
		$("#amount_tendered:enabled").val("<?php echo to_currency_no_money(-$amount_due); ?>");
	}
}

});



// Add Keyboard Shortcuts/Hotkeys to Sale Register
document.body.onkeyup = function(e)
{
	switch(event.altKey && event.keyCode) 
	{
        case 49: // Alt + 1 Items Seach
			$("#item").focus();
			$("#item").select();
            break;
        case 50: // Alt + 2 Customers Search
			$("#customer").focus();
			$("#customer").select();
            break;
		case 51: // Alt + 3 Suspend Current Sale
			$("#suspend_sale_button").click();
			break;
		case 52: // Alt + 4 Check Suspended
			$("#show_suspended_sales_button").click();
			break;
        case 53: // Alt + 5 Edit Amount Tendered Value
			$("#amount_tendered").focus();
			$("#amount_tendered").select();
            break;
		case 54: // Alt + 6 Add Payment
			$("#add_payment_button").click();
			break;	
		case 55: // Alt + 7 Add Payment and Complete Sales/Invoice
			$("#add_payment_button").click();
			window.location.href = "<?php echo site_url('sales/complete'); ?>";
			break; 
		case 56: // Alt + 8 Finish Quote/Invoice without payment
			$("#finish_invoice_quote_button").click();
			break;
		case 57: // Alt + 9 Open Shortcuts Help Modal
			$("#show_keyboard_help").click();
			break;
	}
	
	switch(event.keyCode) 
	{
		case 27: // ESC Cancel Current Sale
			$("#cancel_sale_button").click();
			break;		  
    }
}

</script>

<?php $this->load->view("partial/footer"); ?>
