<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
	dialog_support.init("a.modal-dlg");

</script>

<h2 class="text-center"><B><?php echo $this->lang->line('dashboard_message'); ?></B></h2>

<div id="dashboard">
<div class="row">		
  <div class="col-md-4">
    <a class="btn btn-lg list-group-item list-group-item-info" style="border-radius: 25px;padding: 20px;width: 300px;font-size:x-large;height: 170px;overflow:hidden;"><img style="height:50px" src="images/sales.png"></br>Total Receivables : </br><?php echo $total_receivables;?></a>
  </div>
  <div class="col-md-4">
    <a class="btn btn-lg  list-group-item list-group-item-info" style="background-color: #778899; border-radius: 25px;padding: 20px;width: 300px;font-size:x-large;height: 170px;overflow:hidden;"><img style="height:50px" src="images/purchase.png"></br>Total Payables : </br><?php echo $total_payables;?></a>
  </div>
  <div class="col-md-4">
	  <a style=" border-radius: 25px;padding: 20px;width: 300px;font-size:x-large;height: 170px;overflow:hidden;" class="btn btn-lg list-group-item list-group-item-info" ><img style="height:50px" src="images/income.png"><B></br>Total Income :</br><font color="<?php echo $income_color;?>"> <?php echo $total_income;?></font></B></a>
  </div>  
  </div></br></br>
  <div class="row">		
  <div class="col-md-4">
	  <a style=" background-color: #778899; border-radius: 25px;padding: 20px;width: 300px;font-size:x-large;height: 170px;overflow:hidden;" class="btn btn-lg list-group-item list-group-item-info"><img style="height:50px" src="images/inventory.png"></br>Total Stock :</br> <?php echo $total_stock;?></a>
  </div>
  <div class="col-md-4">
	  <a style=" border-radius: 25px;padding: 20px;width: 300px;font-size:x-large;height: 170px;overflow:hidden;" class="btn btn-lg list-group-item list-group-item-info"><img style="height:50px" src="images/inventory_costs.png"></br>Total Stock Value : </br><?php echo $total_stock_value;?></a>
  </div>
  <div class="col-md-4">
	  <a style=" background-color: #778899; border-radius: 25px;padding: 20px;width: 300px;font-size:x-large;height: 170px;overflow:hidden;" class="btn btn-lg list-group-item list-group-item-info"><img style="height:50px" src="images/expenses.png"></br>Total Expenses : </br><?php echo $total_expenses;?></a>
  </div>  
</div>
</div>

<?php $this->load->view("partial/footer"); ?>