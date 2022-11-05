<style>
	#supplier_table thead tr {
		padding:5px;
		background:#0ad;
		color:#fff;

	}
	#supplier_table, #supplier_table td, #supplier_table th{
		
		padding:5px;
		border:1px solid #999 !important;
	}
	#supplier_table{
		width:100%;
		margin-top: 20px;
	}
</style>
<?php
	if ($controller_name == 'suppliers')
	{
	?>
<div class="supplier_div">
<table id="supplier_table" >
	<thead>
		<tr>
			<th>Date</th>
			<th>Opening Balance</th>
			<th>Purchase</th>
			<th>Paid Amount</th>
			<th>Rate Difference</th>
			<th>Payment Mode</th>
			<th>Return</th>
			<th>Less</th>
			<th>Closing Balance</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>01/04/2022</td>
			<td>9,98,710</td>
			<td>-</td>
			<td>2,27,900</td>
			<td>-</td>
			<td>Cash/cheque</td>
			<td>-</td>
			<td>-</td>
			<td>9,38,170</td>
		</tr>
				<tr>
			<td>14/04/2002</td>
			<td>52,810</td>
			<td>-</td>
			<td>48,900</td>
			<td>-</td>
			<td>Cash/cheque</td>
			<td>-</td>
			<td>-</td>
			<td>538</td>
		</tr>
				<tr>
			<td>14/04/2001</td>
			<td>98,710</td>
			<td>-</td>
			<td>55,900</td>
			<td>-</td>
			<td>Cash/cheque</td>
			<td>-</td>
			<td>-</td>
			<td>170</td>
		</tr>
	</tbody>
</table>
</div>

<div class="supplier_div">
<table id="supplier_table" >
	<thead>
		<tr>
			<td colspan="4" style="text-align: center;">Summary</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Total Purchase</th>
			<td>9,98,710</td>
			<th>Total Return</th>
			<td>2,27,900</td>
		</tr>
				<tr>
			<th>Total Cheque</th>
			<td>52,810</td>
			<th>Total Less</th>
			<td>48,900</td>
		</tr>
				<tr>
			<th>Total Rate Difference</th>
			<td>98,710</td>
			<th>Opening Balance</th>
			<td>55,900</td>
		</tr>
						<tr>
			<th>Total Cash</th>
			<td>710</td>
			<th>Closing Balance</th>
			<td>5,900</td>
		</tr>
	</tbody>
</table>
</div>


	<?php
	}
	?>
<?php $this->load->view("partial/footer"); ?>
