<style>
	#customer_table thead tr {
		padding:5px;
		background:#0ad;
		color:#fff;

	}
	#customer_table, #customer_table td, #customer_table th{
		
		padding:5px;
		border:1px solid #999 !important;
	}
	#customer_table_1
	{
		padding:5px;
		border:1px solid #999 !important; */
	}
@media (min-width: 768px)
{
	.modal-dlg .modal-dialog
	{
		width: 750px !important;
	}
}
</style>
<?php
	if ($controller_name == 'customers' && $customer_sales != NULL || $customer_sales_return  != NULL)
	{
	?>

<table id="customer_table" class="table table-striped table-hover">
<thead>
		<tr bgcolor="#CCC">
			
			
			<th><?php echo $this->lang->line('customers_date'); ?></th>
			<th><?php echo $this->lang->line('customers_balance'); ?></th>
			<th><?php echo $this->lang->line('customers_purchase_amount'); ?></th>
			<th><?php echo $this->lang->line('customers_paid_amount'); ?></th>
			<th><?php echo $this->lang->line('customers_payment_mode'); ?></th>
			
			<th><?php echo $this->lang->line('customers_closing_balance'); ?></th>

		</tr>
	</thead>
	<tbody>
	
	
	<?php
		 foreach($customer_sales as $customer)
		 {
		?>
		<tr>
<td><?php echo $customer['date_added']; ?></td>
<td><?php echo $customer['opening_balance'];?></td>
<td><?php echo $customer['sales_amount'];?></td>
<td><?php echo $customer['paid_amount']; ?></td>
<td><?php echo $customer['payment_type'];?></td>
<td><?php echo $customer['closing_balance'];?></td>
		</tr>
	<?php
		}
		?>

</table>
<h4><strong>Return sales</strong> </h4>
<table id="customer_table" >
<!-- <thead>
		<tr>
			<td colspan="8" style="text-align: ;">Return sales</td>
		</tr>
	</thead> -->
<thead>
		<tr bgcolor="#CCC">
			
			
			<th><?php echo $this->lang->line('customers_date'); ?></th>
			<th><?php echo $this->lang->line('customers_balance'); ?></th>
			<th><?php echo $this->lang->line('customers_purchase_amount'); ?></th>
			<th><?php echo $this->lang->line('customers_paid_amount'); ?></th>
			<th><?php echo $this->lang->line('customers_payment_mode'); ?></th>
			
			<th><?php echo $this->lang->line('customers_closing_balance'); ?></th>

		</tr>
	</thead>
	<tbody>
	
	
	<?php
		 foreach($customer_sales_return as $customer)
		 {
		?>
		<tr>
<td><?php echo $customer['date_added']; ?></td>
<td><?php echo $customer['opening_balance'];?></td>
<td><?php echo $customer['sales_amount'];?></td>
<td><?php echo $customer['paid_amount']; ?></td>
<td><?php echo $customer['payment_type'];?></td>
<td><?php echo $customer['closing_balance'];?></td>
		</tr>
	<?php
		}
		?>

</table>

<br><br>
<table id="customer_table" >
	<thead>
		<tr>
			<td colspan="10" style="text-align: center;">Summary</td>
		</tr>
	</thead>
	<tbody>
		<tr>
		<?php foreach($overall_customer_sales as $overall_customer_sales){?>
			<th><?php echo $this->lang->line('total_sale');?></th>
			<td><?php echo $overall_customer_sales['sales_amount'];?></td>
		<?php 
	}?>

		<?php foreach($cash as $cash){?>
		<th><?php echo $this->lang->line('total_cash');?></th>
		<td><?php echo $cash['paid_amount'];?></td>
		<?php }?>

		<?php foreach($cheque as $cheque){?>
		<th><?php echo $this->lang->line('total_cheque');?></th>
		<td><?php echo $cheque['paid_amount'];?></td>
		<?php }?>

		<?php foreach($pending_cheque as $pending_cheque){?>
		<th><?php echo $this->lang->line('total_cheque_pending');?></th>
		<td><?php echo $pending_cheque['paid_amount'];?></td>
		<?php }?>
		
<tr>

<?php foreach($upi as $upi){?>
		<th><?php echo $this->lang->line('total_upi');?></th>
		<td><?php echo $upi['paid_amount'];?></td>
		<?php }?>
	
		<?php foreach($neft as $neft){?>
		<th><?php echo $this->lang->line('total_neft');?></th>
		<td><?php echo $neft['paid_amount'];?></td>
		<?php }?>
		
		<?php foreach($overall_customer_return_sales as $overall_customer_return_sales){?>
		<th><?php echo $this->lang->line('overall_customer_return_sales');?></th>
		<td><?php echo $overall_customer_return_sales['sales_amount'];?></td>
		<?php }?>

		<?php foreach($return_cash as $return_cash){?>
		<th><?php echo $this->lang->line('total_return_cash');?></th>
		<td><?php echo $return_cash['paid_amount'];?></td>
		<?php }?>

		
		
		
		
		
		
		</tr>
		<tr>
		<?php foreach($return_upi as $return_upi){?>
		<th><?php echo $this->lang->line('total_return_upi');?></th>
		<td><?php echo $return_upi['paid_amount'];?></td>
		<?php }?>
		<?php foreach($return_neft as $return_neft){?>
		<th><?php echo $this->lang->line('total_return_neft');?></th>
		<td><?php echo $return_neft['paid_amount'];?></td>
		<?php }?>
		<?php foreach($new_open_bal as $new_open_bal){?>
		<th><?php echo $this->lang->line('last_opening_balance');?></th>
		<td><?php echo $new_open_bal['opening_balance'];?></td>
		<?php }?>
		<?php foreach($new_close_bal as $new_close_bal){?>
		<th><?php echo $this->lang->line('last_closing_balance');?></th>
		<td><?php echo $new_close_bal['closing_balance'];?></td>
		<?php }?>

		</tr>
	</tbody>
</table>
</div>

<?php
	}else{
		$null_message = "This Customer has no transaction";
	?>
	
	<h3><center><?php echo $null_message; ?></center></h3>

	<?php
	}
	?>