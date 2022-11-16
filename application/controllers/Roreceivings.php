<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Roreceivings extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('Roreceivings');
	}

	public function index()
	{
		 $data['table_headers'] = $this->xss_clean(get_ro_receivings_manage_table_headers());

		 $this->load->view('ro_receivings/manage', $data);
	}

	public function ro_company_id($supplier_id)
    {          
   
      $result=$this->Ro_receiving->opening_bal($supplier_id);
	  $pending=0; 
	  if($result!=NULL)
		{
			foreach($result as $row)
				{
				$pending=$row->pending_payables;
			}
		}
		if($pending == NULL || $result==NULL ){
        $pending=0;
		}
		echo $pending;
    }


	public function manage()
	{
		$data_row_cheque['table_headers'] = $this->xss_clean(get_ro_cheque_manage_table_headers());
		$row=$this->Ro_receiving->cheque_get_info();
		foreach( $row as $row){
		$data_rows = $this->xss_clean(get_ro_cheque_data_row( $row));
		
		//echo json_encode($data_rows);
		}
		
	   
		$this->load->view('ro_receivings/cheque_detail', $data_row_cheque);
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
		$ro_receivings = $this->Ro_receiving->search($search, $limit, $offset, $sort, $order);
		$total_rows = $this->Ro_receiving->get_found_rows($search);
		
       
		$data_rows = array();
		foreach($ro_receivings->result() as $ro_receivings)
		{   
			

			$data = $this->Ro_receiving->agency_name($ro_receivings->supplier_id);
		
			$data_rows[] = $this->xss_clean(get_ro_receivings_data_row_search($ro_receivings,$data));

			//$data_rows = $this->xss_clean(get_ro_cheque_data_row( $ro_receivings));
		
			
			
		}

		  echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}


   //Get row
	public function get_row($row_id)
	{ 
		$data = $this->Ro_receiving->agency_name($row_id);
		$data_db=$this->Ro_receiving->get_info_filter();
		 foreach($data_db as $ro_receivings)
		{ 			
			$data_row[] = $this->xss_clean(get_ro_receivings_data_row($ro_receivings,$data));
		}
		  echo json_encode($data_row);
		
	}

	public function get_row_cheque($id)
	{
		$data_cheque = $this->xss_clean(get_purchase_data_row($this->Ro_receiving->get_info()));
		echo json_encode($data_cheque);
	}

	
	public function bulk_entry_view($id = -1)
	{		
		$data['ro_receivings_info'] = $this->Ro_receiving->get_info($id,"");
		if(empty($id))
		{
			$data['ro_receivings_info']->receiving_time = date('Y-m-d H:i:s');
			$data['ro_receivings_info']->employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		}
		$data['company_name'] = $this->Ro_receiving->companyname(); 
		
		$this->load->view("ro_receivings/counter_sale_form", $data);
	}
	
     //View new form
	public function view($id = -1)
	{		
		$data['ro_receivings_info'] = $this->Ro_receiving->get_info($id);

		if(empty($id))
		{
			$data['ro_receivings_info']->receiving_time = date('Y-m-d H:i:s');
			$data['ro_receivings_info']->employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		}	
		$company_name_none = array('' => $this->lang->line('supplier_none'));

		$data['company_name'] = $this->Ro_receiving->companyname(); 
		
		 $data['company_name_none']=$company_name_none;
	
		$this->load->view("ro_receivings/form", $data);
	}


	//Save new form
	public function save($id = -1)
	{			
		$ro_receivings_data = array(
			// 'category' => $this->input->post('category'),
			// 'invoice_no' => $this->input->post('invoice_no'),
			'voucher_no'=> $this->input->post('voucher_no'),
			'supplier_id' => $this->input->post('supplier_id'),
			'opening_balance' => $this->input->post('opening_balance'),
			'purchase_amount' => $this->input->post('purchase_amount'),
			'paid_amount' => $this->input->post('paid_amount'),
			'payment_mode' => $this->input->post('payment_mode'),
			'cheque_date' => $this->input->post('cheque_date'),
			'cheque_number' => $this->input->post('cheque_number'),			
			'closing_balance' => $this->input->post('closing_balance'),
			'purchase_return_amount' => $this->input->post('purchase_return_amount'),
			'purchase_return_qty' => $this->input->post('purchase_return_qty'),
			'discount' => $this->input->post('discount'),
			'pending_payables' => $this->input->post('pending_payables'),
			'last_purchase_qty' => $this->input->post('last_purchase_qty'),
			'rate_difference' => $this->input->post('rate_difference'),
			// 'total_stock' => $this->input->post('total_stock'),
			'gst_slab' => $this->input->post('gst_slab'),
			'gst_amount' => $this->input->post('gst_amount'),
			// 'purchase_date' => $this->input->post('purchase_date'),
			'receiving_time' => $this->input->post('receiving_time'),			
		);

		if($this->Ro_receiving->save($ro_receivings_data, $id))
		{
			$ro_receivings_data = $this->xss_clean($ro_receivings_data);

			// New master_category_id
			if($id == -1)
			{
				
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('ro_receivings_successful_adding'), 'id' => $ro_receivings_data['id']));	
			}
			// Existing master Category
			else 
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('ro_receivings_updated_successful'), 'id' => $id));
			}
		}
		//failure
		else
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('ro_receivings_error_adding_updating') . ' ' . $ro_receivings_data['company_name'], 'id' => -1));
		}

		
	}
    //Delete data from formtable
	public function delete()
	{
		$ro_receivings_to_delete = $this->input->post('ids');

		if($this->Ro_receiving->delete_list($ro_receivings_to_delete))
		{
			echo json_encode(array('success' => TRUE, 'message' => count($ro_receivings_to_delete) . ' ' . $this->lang->line('ro_receivings_successful_delete') ));
		}
		else
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('ro_receivings_cannot_be_deleted')));
		}
	}
	public function suppliers_details($supplier_id,$id)
	{
		$data['supplier']=$this->Ro_receiving->supplier_info($supplier_id);
		$data['supplier_summary']=$this->Ro_receiving-> supplier_summary($supplier_id);
		$data['supplier_open_close_bal']=$this->Ro_receiving->open_close_bal($id);
		$data['cash']=$this->Ro_receiving->cash($supplier_id);
		$data['cheque']=$this->Ro_receiving->cheque($supplier_id);
		 $this->load->view('ro_receivings/supplier_form',$data );

	}
}
?>
