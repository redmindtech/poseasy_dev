<?php $this->load->view("partial/header"); ?>

<?php
if (isset($error_message))
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
			$.get('<?php echo site_url() . "/sales/send_receipt/" . $sale_id_num; ?>',
				function(response)
				{
					$.notify( { message: response.message }, { type: response.success ? 'success' : 'danger'} )
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

<?php $this->load->view('partial/print_receipt', array('print_after_sale'=>$print_after_sale, 'selected_printer'=>'receipt_printer')); ?>

<div class="print_hide" id="control_buttons" style="text-align:right">
	<a href="javascript:printdoc();"><div class="btn btn-info btn-sm", id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a>
	<?php if(!empty($customer_email)): ?>
		<a href="javascript:void(0);"><div class="btn btn-info btn-sm", id="show_email_button"><?php echo '<span class="glyphicon glyphicon-envelope">&nbsp</span>' . $this->lang->line('sales_send_receipt'); ?></div></a>
	<?php endif; ?>
	<?php echo anchor("sales", '<span class="glyphicon glyphicon-shopping-cart">&nbsp</span>' . $this->lang->line('sales_register'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_sales_button')); ?>
	<?php if($this->Employee->has_grant('reports_sales', $this->session->userdata('person_id'))): ?>
		<?php echo anchor("sales/manage", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . $this->lang->line('sales_takings'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_takings_button')); ?>
	<?php endif; ?>
</div>






<?php
if (isset($error_message))
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
				$.get('<?php echo site_url() . "/sales/send_pdf/" . $sale_id_num . "/quote"; ?>',
					function(response)
					{
						$.notify( { message: response.message }, { type: response.success ? 'success' : 'danger'} )
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



<div id="page-wrap">
	<div id="header"><?php echo $this->lang->line('sales_estimate'); ?></div>
	
		

		
			
			
			
			
			
		
	

	

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
			<td colspan="3" style='border:none; text-align:center;'><b><?php echo nl2br("ROYAL OPTICALS\n18-1/2, A.R.Building(1st floor)\nMelapudur main road, Trichy-620001.\n"); ?></b></td>
			<td  style='border:none;'></td>
		</tr>

		<tr>
			
			<td colspan="2" style='border:none; text-align:left;'><?php echo "GSTIN:33AHVPM5189L1ZG"; ?></td>			
			
			<td style='border:none;'></td>
			
			<td colspan="2"style='border:none; text-align:right;'><?php echo "E-mail:royalopticalstrichy@gmail.com";  ?></td>
		</tr>


		

		<tr>
			<th colspan="5"><?php echo $this->lang->line('sales_estimate'); ?></th>
		</tr>

		<tr>
			<td colspan="3" rowspan="4" style='border:none;'><?php echo nl2br($customer_info) ?></td>
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
			
			<td style='border:none; text-align:right;'></td>
			<td style='border:none; text-align:right;'><?php echo $this->lang->line('common_date'); ?><?php echo ":".$transaction_date; ?></td>
		</tr>




		<tr>
			<th width="10px"><?php echo $this->lang->line('sales_s_no'); ?></th>
			<th><?php echo $this->lang->line('sales_price'); ?></th>
			<th><?php echo $this->lang->line('sales_item_name'); ?></th>
			<th><?php echo $this->lang->line('sales_quantity'); ?></th>
			
			
			<?php
			$quote_columns = 5;
			
			?>
			
			<th width="110px"><?php echo $this->lang->line('sales_total'); ?></th>
		</tr>

		

		<?php
		$s_no_counter=0;
		$total_amount = 0;
		foreach($cart as $line=>$item)
		{
			$s_no_counter++;
			if($item['print_option'] == PRINT_YES)
			{
			?>
				<tr>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo $s_no_counter ?></td>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo "₹".$item['price']; ?></td>
					<td style='text-align:center;border-bottom:none;border-top:none;' class="item-name"><?php echo $item['name']; ?></td>
					<td style='text-align:center;border-bottom:none;border-top:none;'><?php echo to_quantity_decimals($item['quantity']);
														$price_item = $item['price'];														
														$total_item_price = $price_item*to_quantity_decimals($item['quantity']);  ?></td>
					
					
					<td style='border-right: solid 1px; text-align:right;border-bottom:none;border-top:none;'><?php echo "₹".$total_item_price;					
																			$total_amount = $total_amount + $total_item_price; ?></td>
				</tr>

				



				<?php if($item['is_serialized'])
				{
				?>
					<tr>
						<td class="item-name" colspan="<?php echo $quote_columns-1; ?>"></td>
						<td style='text-align:center;'><?php echo $item['serialnumber']; ?></td>
					</tr>
				<?php
				}
			}
		}
		?>

		
		

		<tr>
			<td colspan="<?php echo $quote_columns-1; ?>" style='text-align:right;'><?php echo $this->lang->line('net_gross'); ?> </td>
			<td id="subtotal" style='text-align:right;'><?php echo "₹".$total_amount; ?></td>
		</tr>


		<tr>
			<td colspan="<?php echo $quote_columns-1; ?>" style='text-align:right;'> <?php echo $this->lang->line('opening_bal'); ?></td>
			<td id="total" style='text-align:right;'><?php echo "₹".$cus_opening_bal; ?></td>
		</tr>

		<?php
		$only_sale_check = FALSE;
		$show_giftcard_remainder = FALSE;
		
		?>
			<tr>
				<td colspan="<?php echo $quote_columns-1; ?>" style='text-align:right;'> <?php echo $this->lang->line('total_amount');
																$total_bal = $total_amount+$cus_opening_bal; ?></td>
				
				<td id="paid" style='text-align:right;'><?php echo "₹".$total_bal; ?></td>
			</tr>
		
	</table>
	<div id="terms">
		<div id="sale_return_policy">
			<h5>
				<div style='padding:4%;'><?php echo empty($comments) ? '' : $this->lang->line('sales_comments') . ': ' . $comments; ?></div>
				<div style='padding:4%;'><?php echo $this->config->item('quote_default_comments'); ?></div>
			</h5>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(window).on("load", function()
	{
		// install firefox addon in order to use this plugin
		if (window.jsPrintSetup)
		{
			<?php
			if(!$this->Appconfig->get('print_header'))
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
