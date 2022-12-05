<?php $this->load->view("partial/header"); ?>

<?php
if(isset($error_message))
{
	echo "<div class='alert alert-dismissible alert-danger'>".$error_message."</div>";
	exit;
}
?>

<?php if(!empty($customer_email)): ?>
<script type="text/javascript">
$(document).ready(function()
{
	var send_email = function()
	{
		$.get('<?php echo site_url() . "sales/send_pdf/" . $sale_id_num; ?>',
			function(response)
			{
				$.notify({ message: response.message }, { type: response.success ? 'success' : 'danger'});
			}, 'json'
		);
	};

	$("#show_email_button").click(send_email);

	<?php if(!empty($email_receipt)): ?>
		send_email();
	<?php endif; ?>
});
</script>
<?php endif; ?>

<?php $this->load->view('partial/print_receipt', array('print_after_sale'=>$print_after_sale, 'selected_printer'=>'invoice_printer')); ?>

<div class="print_hide" id="control_buttons" style="text-align:right">
	<a href="javascript:printdoc();"><div class="btn btn-info btn-sm", id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a>
	<?php /* this line will allow to print and go back to sales automatically.... echo anchor("sales", '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_print_button', 'onclick'=>'window.print();')); */ ?>
	<?php if(isset($customer_email) && !empty($customer_email)): ?>
		<a href="javascript:void(0);"><div class="btn btn-info btn-sm", id="show_email_button"><?php echo '<span class="glyphicon glyphicon-envelope">&nbsp</span>' . $this->lang->line('sales_send_invoice'); ?></div></a>
	<?php endif; ?>
	<?php echo anchor("sales", '<span class="glyphicon glyphicon-shopping-cart">&nbsp</span>' . $this->lang->line('sales_register'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_sales_button')); ?>
	<?php echo anchor("sales/manage", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . $this->lang->line('sales_takings'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_takings_button')); ?>
</div>

<div id="page-wrap">
<div id="header"><?php echo $this->lang->line('sales_cash_bill'); ?></div>

		
	
	
				



	<table id="items">

	<tr>
			<td style='border:none;'>
			<div><?php
			if($this->Appconfig->get('company_logo') != '')
			{
			?>
				<img id="image" width="70" height="80" src="<?php echo base_url('uploads/' . $this->Appconfig->get('company_logo')); ?>" alt="company_logo" />
			<?php
			}
			?></div></td>
			<td colspan="7" style='border:none; text-align:center;'><b><?php echo nl2br("ROYAL OPTICALS\n18-1/2, A.R.Building(1st floor)\nMelapudur main road, Trichy-620001.\n"); ?></b></td>
			<td  style='border:none;'></td>
		</tr>

		<tr>
			
			<td colspan="4" style='border:none; text-align:left;'><?php echo "GSTIN:33AHVPM5189L1ZG"; ?></td>			
			
			<td style='border:none;'></td>
			
			<td colspan="4"style='border:none; text-align:right;'><?php echo "E-mail:royalopticalstrichy@gmail.com";  ?></td>
		</tr>


		<tr>
			<th colspan="9" style='text-align:center;'><?php echo $this->lang->line('sales_cash_bill'); ?></th>

		</tr>


		<tr>
			<td colspan="7" rowspan="4" style='border:none;'><?php echo nl2br($customer_info) ?></td>
			<td style='border:none;'></td>
			<td style='border:none;'></td>
		</tr>
		<tr>
			
			<td style='border:none;'></td>
			<td style='border:none;'></td>
		</tr>
		<tr>
			
			<td style='border:none; text-align:right;'></td>
			<td style='border:none; text-align:left;'></td>
		</tr>
		<tr>
		
		<td style='border:none; text-align:right;'><?php echo $this->lang->line('common_date'); ?></td>
		<td style='border:none; text-align:left;'><?php echo ":".$transaction_date; ?></td>
			
		
		</tr>

		<tr>
			<th><?php echo $this->lang->line('sales_s_no'); ?></th>
			<th><?php echo $this->lang->line('sales_item_name'); ?></th>
			<?php
				$invoice_columns = 8;
				if($include_hsn)
				{
					$invoice_columns += 1;
					?>
					
					<?php
				}
			?>
			<th><?php echo $this->lang->line('sales_hsn'); ?></th>
			<th><?php echo $this->lang->line('sales_quantity'); ?></th>
			<th><?php echo $this->lang->line('sales_price'); ?></th>
			<th><?php echo $this->lang->line('sales_sub_total'); ?></th>
			<!-- <th><?php //echo $this->lang->line('sales_discount'); ?></th> -->
			<th><?php echo $this->lang->line('sales_other_cost'); ?></th>
			<th><?php echo $this->lang->line('sales_tax_percent'); ?></th>
			<?php
			if($discount > 0)
			{
				$invoice_columns += 1;
				?>
				<!-- <th><?php //echo $this->lang->line('sales_customer_discount'); ?></th> -->
			<?php
			}
			?>
			<th><?php echo $this->lang->line('sales_total'); ?></th>
		</tr>

		<?php
		$count = 0;
		foreach($cart as $line=>$item)
		{
			$count+=1;
			if($item['print_option'] == PRINT_YES)
			{
			?>
				<tr>
					
					<td  style='text-align:center;border-bottom:none;border-top:none;'><?php echo "$count"; ?></td> 
					<?php if($include_hsn): ?>
						
					<?php endif; ?>
					
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo ($item['is_serialized'] || $item['allow_alt_description']) && !empty($item['description']) ? $item['description'] : $item['name'] . ' ' . $item['attribute_values']; ?></td>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo $item['hsn_code']; ?></td>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo to_quantity_decimals($item['quantity']); ?></td>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo to_currency($item['price']); ?></td>
					<td style='text-align:center;border-bottom:none;border-top:none;' id="subtotal"><?php echo to_currency($item['price']); ?></td>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo ($item['discount_type']==FIXED)?to_currency($item['discount']):to_decimals($item['discount']) . '%';?></td>
					<?php if($discount > 0): ?>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo to_currency($item['discount'] / $item['quantity']); ?></td>
					<?php endif; ?>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo $this->config->item('discount') . '%'; ?></td>
					
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo to_currency($item['discounted_total']); ?></td>
					
				</tr>
				<?php
				if($item['is_serialized'])
				{
				?>
					<tr class="item-row">
						<td class="item-description" colspan="<?php echo $invoice_columns-1; ?>"></td>
						<td style='text-align:center;'><?php echo $item['serialnumber']; ?></td>
					</tr>
				<?php
				}
			}
		}
		?>

		

		<tr>
			<td colspan="8" style='text-align:right;'><?php echo $this->lang->line('sales_sub_total'); ?> </td>
			
			<td class="total-value" id="subtotal"><?php echo to_currency($subtotal); ?></td>
		</tr>

		<?php
		foreach($taxes as $tax_group_index=>$tax)
		{
		?>
			<tr>
				
				<td colspan="8" style='text-align:right;'><?php echo (float)$tax['tax_rate'] . '% ' . $tax['tax_group']; ?></td>
				<td id="taxes" style='text-align:right;'><?php echo to_currency_tax($tax['sale_tax_amount']); ?></td>
			</tr>
		<?php
		}
		?>

		<tr>
			
			<td colspan="8"  style='text-align:right;'><?php echo $this->lang->line('sales_total'); ?></td>
			<td id="total" style='text-align:right;'><?php echo to_currency($total); ?></td>
		</tr>

		<?php
		$only_sale_check = FALSE;
		$show_giftcard_remainder = FALSE;
		foreach($payments as $payment_id=>$payment)
		{
			$only_sale_check |= $payment['payment_type'] == $this->lang->line('sales_check');
			$splitpayment = explode(':', $payment['payment_type']);
			$show_giftcard_remainder |= $splitpayment[0] == $this->lang->line('sales_giftcard');
		?>
			<tr>
				
				<td colspan="8"  style='text-align:right;'><?php echo $splitpayment[0]; ?></td>
				<td style='text-align:right;' id="paid"><?php echo to_currency( $payment['payment_amount'] * -1 ); ?></td>
			</tr>
		<?php
		}

		if(isset($cur_giftcard_value) && $show_giftcard_remainder)
		{
		?>
			<tr>
				
				<td colspan="8"  style='text-align:right;'><?php echo $this->lang->line('sales_giftcard_balance'); ?></td>
				<td id="giftcard"><?php echo to_currency($cur_giftcard_value); ?></td>
			</tr>
			<?php
		}

		if(!empty($payments))
		{
		?>
		<tr>
			
			<td colspan="8" style='text-align:right;'><?php echo $this->lang->line($amount_change >= 0 ? ($only_sale_check ? 'sales_check_balance' : 'sales_change_due') : 'sales_amount_due') ; ?></td>
			<td id="change"><?php echo to_currency($amount_change); ?></td>
		</tr>
		<?php
		}
		?>

	</table>

	<div id="terms">
		<div id="sale_return_policy">
			<h5>
				
				
				
			</h5>
			
		</div>
		<div id='barcode'>
			<img style='padding-top:4%;' src='data:image/png;base64,<?php echo $barcode; ?>' /><br>
			<?php echo $sale_id; ?>
		</div>
	</div>
</div>

<script type="text/javascript">
$(window).on("load", function()
{
	// install firefox addon in order to use this plugin
	if(window.jsPrintSetup)
	{
		<?php if(!$this->Appconfig->get('print_header'))
		{
		?>
			// set page header
			jsPrintSetup.setOption('headerStrLeft', '');
			jsPrintSetup.setOption('headerStrCenter', '');
			jsPrintSetup.setOption('headerStrRight', '');
		<?php
		}

		if(!$this->Appconfig->get('print_footer'))
		{
		?>
			// set empty page footer
			jsPrintSetup.setOption('footerStrLeft', '');
			jsPrintSetup.setOption('footerStrCenter', '');
			jsPrintSetup.setOption('footerStrRight', '');
		<?php
		}
		?>
	}
});
</script>

<?php $this->load->view("partial/footer"); ?>
