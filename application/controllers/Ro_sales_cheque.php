<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Ro_sales_cheque extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('Ro_sales_cheque');
	}

	public function manage()
	{
		 $data['table_headers'] = $this->xss_clean(get_ro_sales_manage_table_headers());

		 $this->load->view('sales/cheque_approval', $data);
	}


	public function update_cheque(){
		$opening_balance = $_POST['opening_balance'];
		
	}

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
		$ro_sales = $this->Ro_sales_cheques->search($search, $limit, $offset, $sort, $order);
		$total_rows = $this->Ro_sales_cheques->get_found_rows($search);

		//var_dump($offset);

		$count = $offset+1;

		$data_rows = array();
		foreach($ro_sales->result() as $ro_sales)
		{
			$data_rows[] = $this->xss_clean(get_ro_sales_cheque_data_row($ro_sales,$count));
			$count++;
		}

		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
   
	//Get row
	public function get_row( $row_id)
	{
		$data_row = $this->xss_clean(get_ro_sales_cheque_data_row($this->Ro_sales_cheques->get_info($row_id)));
		echo json_encode($data_row);
	}
     

	// Cheque Reject

	public function cheque_reject()
	{

		$id = $_POST['id'];

		$customer_id = $_POST['customer_id'];
		$final_val = $_POST['final_val'];
		//$discount = $_POST['discount'];
		//$closing_bal = $overall_val;
				
		$this->Ro_sales_cheques->reject_cheque($id);

		// $check_id= $this->Ro_sales_cheques->transaction_cheque($customer_id);
		
		// $next_row=$this->Ro_sales_cheques->remainding_ids($id,$customer_id);	

		// foreach($check_id as $check_id){
		// 	$next_id=$check_id;
		// }
		// if($next_id==$id)
		// {
		// 	log_message('debug',print_r($id,TRUE));
		// }
		// else{			
		// 	$next_row=$this->Ro_sales_cheques->remainding_ids($id,$customer_id);
		// 	$this->adjust_balance($final_val,$next_row);
				
		// 	}
	}

	
	//Save new form
	public function cheque_valid(){
		
		$id = $_POST['id'];
		
		$customer_id = $_POST['customer_id'];
		$final_val = $_POST['final_val'];
		
					
		$this->Ro_sales_cheques->save_cheque($id,$final_val,$customer_id);	
		
		$check_id= $this->Ro_sales_cheques->transaction_cheque($customer_id);
		$next_row=$this->Ro_sales_cheques->remainding_ids($id,$customer_id);	

		foreach($check_id as $check_id){
			$next_id=$check_id;
		}
		if($next_id==$id)
		{
			log_message('debug',print_r($id,TRUE));
		}
		else{			
			$next_row=$this->Ro_sales_cheques->remainding_ids($id,$customer_id);
			$this->adjust_balance($final_val,$next_row);
				
			}
	
	}

	public function adjust_balance($final_val,$next_row)
	{ 
		 $open_bal=$final_val;
		$obj=json_decode(json_encode($next_row));	

		foreach($obj as $key=>$value)
		 {   
			
			$id=$value->id;			 
			
			if($value->payment_type=="Cheque")
			{
				$open_bal=$open_bal;
				$closing_bal=$open_bal;
			//	$pending_pay=$open_bal;
				
				$this->Ro_sales_cheques->after_cheque_pass_ids($id,$open_bal,$closing_bal);

			}
		 else{		
			
			$sum=(($open_bal)+ ($value->sales_amount))-($value->paid_amount);
			$closing_bal=number_format($sum,2, ".", "");
			
			$this->Ro_sales_cheques->after_cheque_pass_ids($id,$open_bal,$closing_bal);
			$open_bal=$closing_bal;
			
		 }
		 }
}
}
?>
