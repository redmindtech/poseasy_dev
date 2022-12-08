<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Ro_daily_sale extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('Ro_daily_sale');
	}

	public function manage()
	{
		 $data['table_headers'] = $this->xss_clean(get_sales_daily_manage_table_headers());

		 $this->load->view('sales/manage', $data);
	}


	// public function update_cheque(){
	// 	$opening_balance = $_POST['opening_balance'];
		
	// }

	/*
	Returns Item_category_manage table data rows. This will be called with AJAX.
	*/
	public function search()
	{
		$search = $this->input->get('search');
		$limit  = $this->input->get('limit');
		$offset = $this->input->get('offset');
		$sort   = $this->input->get('sort');
		$order  = $this->input->get('order');

		$filters = array(
			// 'sale_type' => 'all',
			// 			 'location_id' => 'all',
						 'start_date' => $this->input->get('start_date'),
						 'end_date' => $this->input->get('end_date'),
						//  'only_cash' => FALSE,
						//  'only_due' => FALSE,
						//  'only_check' => FALSE,
						//  'only_creditcard' => FALSE,
						//  'only_invoices' => $this->config->item('invoice_enable') && $this->input->get('only_invoices'),
						//  'is_valid_receipt' => $this->Ro_daily_sales->is_valid_receipt($search)
						);

		$filledup = array_fill_keys($this->input->get('filters'), TRUE);
		$filters = array_merge($filters, $filledup);
		// check if any filter is set in the multiselect dropdown
		
		$daily_sale = $this->Ro_daily_sales->search($search, $filters, $limit, $offset, $sort, $order);
		$total_rows = $this->Ro_daily_sales->get_found_rows($search, $filters);
		
		//var_dump($offset);

		$count = $offset+1;

		$data_rows = array();
		foreach($daily_sale->result() as $daily_sale)
		{
			$data_rows[] = $this->xss_clean(get_sale_daily_data_row($daily_sale,$count));
			$count++;
		}
		
		// if($total_rows > 0)
		// {
		// 	$data_rows[] = $this->xss_clean(get_sale_data_last_row($daily_sale));
		// }

		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
   
	//Get row
	public function get_row($row_id)
	{
		$data_row = $this->xss_clean(get_sale_daily_data_row($this->Ro_daily_sales->get_info($row_id)));
		echo json_encode($data_row);
	}
     

	// Cheque Reject

	// public function cheque_reject()
	// {

	// 	$id = $_POST['id'];

	// 	$customer_id = $_POST['customer_id'];
	// 	$final_val = $_POST['final_val'];
	// 	//$discount = $_POST['discount'];
	// 	//$closing_bal = $overall_val;
				
	// 	$this->Ro_daily_sales->reject_cheque($id,$final_val);

	// 	$check_id= $this->Ro_daily_sales->transaction_cheque($customer_id);
	// 	$next_row=$this->Ro_daily_sales->remainding_ids($id,$customer_id);	

	// 	foreach($check_id as $check_id){
	// 		$next_id=$check_id;
	// 	}
	// 	if($next_id==$id)
	// 	{
	// 		log_message('debug',print_r($id,TRUE));
	// 	}
	// 	else{			
	// 		$next_row=$this->Ro_daily_sales->remainding_ids($id,$customer_id);
	// 		$this->adjust_balance($final_val,$next_row);
				
	// 		}
	// }

	
	//Save new form
	// public function cheque_valid(){
		
	// 	$id = $_POST['id'];
		
	// 	$customer_id = $_POST['customer_id'];
	// 	$final_val = $_POST['final_val'];
					
	// 	$this->Ro_daily_sales->save_cheque($id,$final_val,$customer_id);	
		
	// 	$check_id= $this->Ro_daily_sales->transaction_cheque($customer_id);
	// 	$next_row=$this->Ro_daily_sales->remainding_ids($id,$customer_id);	

	// 	foreach($check_id as $check_id){
	// 		$next_id=$check_id;
	// 	}
	// 	if($next_id==$id)
	// 	{
	// 		log_message('debug',print_r($id,TRUE));
	// 	}
	// 	else{			
	// 		$next_row=$this->Ro_sales_cheques->remainding_ids($id,$customer_id);
	// 		$this->adjust_balance($final_val,$next_row);
				
	// 		}
	
	// }

// 	public function adjust_balance($final_val,$next_row)
// 	{ 
// 		 $open_bal=$final_val;
// 		$obj=json_decode(json_encode($next_row));	

// 		foreach($obj as $key=>$value)
// 		 {   
			
// 			$id=$value->id;			 
			
// 			if($value->payment_type=="Cheque")
// 			{
// 				$open_bal=$open_bal;
// 				$closing_bal=$open_bal;
// 			//	$pending_pay=$open_bal;
				
// 				$this->Ro_sales_cheques->after_cheque_pass_ids($id,$open_bal,$closing_bal);

// 			}
// 		 else{
			
// 			$sum=($open_bal)-($value->paid_amount);
// 			$closing_bal=number_format($sum,2, ".", "");
			

// 			// $sum1=($closing_bal-($value->purchase_return_amount))-($value->discount);
// 			// $closing_bal=number_format($sum1,2, ".", "");
		

// 			$this->Ro_sales_cheques->after_cheque_pass_ids($id,$open_bal,$closing_bal);
// 			$open_bal=$closing_bal;
			
// 		 }
// 		 }
// }
}
?>
