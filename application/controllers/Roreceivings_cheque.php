<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Roreceivings_cheque extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('Roreceivings_cheque');
	}

	public function manage()
	{
		 $data['table_headers'] = $this->xss_clean(get_ro_cheque_manage_table_headers());

		 $this->load->view('ro_receivings/cheque_detail', $data);
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
		$ro_receivings_accounts = $this->Roreceivings_cheques->search($search, $limit, $offset, $sort, $order);
		$total_rows = $this->Roreceivings_cheques->get_found_rows($search);

		//var_dump($offset);

		$count = $offset+1;

		$data_rows = array();
		foreach($ro_receivings_accounts->result() as $ro_receivings_accounts)
		{

			$data = $this->Ro_receiving->agency_name($ro_receivings_accounts->supplier_id);
			$data_rows[] = $this->xss_clean(get_ro_cheque_data_row($ro_receivings_accounts,$count,$data));
			$count++;
		}

		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
   //Get row
	public function get_row( $row_id)
	{
		$data_row = $this->xss_clean(get_ro_cheque_data_row($this->Roreceivings_cheques->get_info($row_id)));
		echo json_encode($data_row);
	}
     

	public function cheque_reject(){

		$id = $_POST['id'];

		
		$this->Roreceivings_cheques->reject_cheque($id);




	}
	//Save new form
	public function cheque_valid(){
		
		$id = $_POST['id'];
		
		$supplier_id = $_POST['supplier_id'];
		$overall_val = $_POST['overall_val'];
		$final_val = $_POST['final_val'];
					
		$this->Roreceivings_cheques->save_cheque($id,$overall_val,$final_val,$supplier_id);	
		
		$check_id= $this->Roreceivings_cheques->transaction_cheque($supplier_id);
		$next_row=$this->Roreceivings_cheques->remainding_ids($id,$supplier_id);	

		foreach($check_id as $check_id){
			$next_id=$check_id;
		}
		if($next_id==$id)
		{
			log_message('debug',print_r($id,TRUE));
		}
		else{			
			$next_row=$this->Roreceivings_cheques->remainding_ids($id,$supplier_id);
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
			
			if($value->payment_mode=="Cheque")
			{
				$open_bal=$open_bal;
				$closing_bal=$open_bal;
				$pending_pay=$open_bal;
				
				$this->Roreceivings_cheques->after_cheque_pass_ids($id,$open_bal,$closing_bal,$pending_pay);

			}
		 else{
			
			$sum=($open_bal+($value->purchase_amount))-($value->paid_amount);
			$closing_bal=number_format($sum,2, ".", "");
			

			$sum1=($closing_bal-($value->purchase_return_amount))-($value->discount);
			$pending_pay=number_format($sum1,2, ".", "");
		

			$this->Roreceivings_cheques->after_cheque_pass_ids($id,$open_bal,$closing_bal,$pending_pay);
			$open_bal=$pending_pay;
			
		 }
		 }
		
	
}
	
	
}
?>
