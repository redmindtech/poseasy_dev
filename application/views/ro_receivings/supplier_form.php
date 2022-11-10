<style>
@media (min-width: 768px)
{
	.modal-dlg .modal-dialog
	{
		width: 750px !important;
	}
}
</style>
<table id="supplier_table" class="table table-striped table-hover">
	<thead>
		<tr bgcolor="#CCC">
			
			
			<th><?php echo $this->lang->line('ro_receivings_date'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_opening_balance'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_purchase_amount'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_paid_amount'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_rate_difference'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_payment_mode'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_purchase_return_amount'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_less'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_closing_balance'); ?></th>

		</tr>
	</thead>
	<tbody>
	
	<?php
		foreach($supplier as $supplier)
		{
		?>
		<tr>
		
	<td><?php echo $supplier['receiving_time']; ?></td>
<td><?php echo $supplier['opening_balance']; ?></td>
<td><?php echo $supplier['purchase_amount']; ?></td>
<td><?php echo $supplier['paid_amount']; ?></td>
<td><?php echo $supplier['rate_difference']; ?></td>
<td><?php echo $supplier['payment_mode']; ?></td>
<td><?php echo $supplier['purchase_return_amount']; ?></td>
<td><?php echo $supplier['discount']; ?></td>
<td><?php echo $supplier['closing_balance']; ?></td>

		</tr>
	<?php
		}
		?>
	</tbody>

</table>
<h5><b> <?php echo $this->lang->line('ro_receivings_supplier_summary'); ?></b></h5>
 <table id="supplier_table" class="table table-striped table-hover"> 
 <thead>
		<tr bgcolor="#CCC">
					
			<th><?php echo $this->lang->line('ro_receivings_total_purchase'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_total_return'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_total_discount/less'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_total_rate_difference'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_total cash'); ?></th>	
			<th><?php echo $this->lang->line('ro_receivings_total_cheque'); ?></th>	
			<th><?php echo $this->lang->line('ro_receivings_opening_balance'); ?></th>
			<th><?php echo $this->lang->line('ro_receivings_closing_balance'); ?></th>
					
					
			
			
			</thead>
		
			<tbody>
	
	<?php
		foreach($supplier_summary as $supplier_details)
		{
		?>
		<tr>
		
	<td><?php echo $supplier_details['purchase_amount']; ?></td>
	<td><?php echo $supplier_details['purchase_return_amount']; ?></td>
	<td><?php echo $supplier_details['discount']; ?></td>
	<td><?php echo $supplier_details['rate_difference']; ?></td>

	<?php
		}
		?>
		
		
		<?php
		foreach($cash as $cash)
		{
		?>
		<td><?php echo $cash['paid_amount']; ?></td>
	
	<?php
		}
		?> 
<?php
		foreach($cheque as $cheque)
		{
		?>
		<td><?php echo $cheque['paid_amount']; ?></td>
	
	<?php
		}
		?> 

		<?php
		foreach($supplier_open_close_bal as $supplier_open_close_bal)
		{
		?>
		<td><?php echo $supplier_open_close_bal['opening_balance']; ?></td>
	<td><?php echo $supplier_open_close_bal['pending_payables']; ?></td>
	<?php
		}
		?> 

		</tr>
	</tbody>

	</table>

