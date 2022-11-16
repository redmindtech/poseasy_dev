<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
	dialog_support.init("a.modal-dlg");

</script>

<h3 class="text-center"><?php echo $this->lang->line('dashboard_message'); ?></h3>

<div id="dashboard">
<div class="row">		
  <div class="col-md-4"><a class="btn btn-lg list-group-item list-group-item-info">Total Receivables : <?php echo $total_receivables;?></a>
  </div>
  <div class="col-md-4">
  <a  class="btn btn-lg  list-group-item list-group-item-info">Total Payables : <?php echo $total_payables;?></a>
  </div>
  <div class="col-md-4">
	  <a class="btn btn-lg list-group-item list-group-item-info" style="color:<?php echo $income_color;?>"><B>Total Income : <?php echo $total_income;?></B></a></div>  
</div>
<div class="row">
  <div class="col-md-4">
	  <a class="btn btn-lg list-group-item list-group-item-info">Total Stock : <?php echo $total_stock;?></a></div>
  <div class="col-md-4">
	  <a class="btn btn-lg list-group-item list-group-item-info">Total Stock Value : <?php echo $total_stock_value;?></a></div>
  <div class="col-md-4">
	  <a class="btn btn-lg list-group-item list-group-item-info">Total Expenses : <?php echo $total_expenses;?></a></div>  
</div>
</div>

<?php $this->load->view("partial/footer"); ?>