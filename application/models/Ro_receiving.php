<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Item_category class
 */

class Ro_receiving extends CI_Model
{
	/*
	Determines if a given item_category_id is an Item_category
	*/
	public function exists($id)
	{
		$this->db->from('ro_receivings_accounts');
		$this->db->where('id', $id);

		return ($this->db->get()->num_rows() == 1);
	}

	/*
	Gets total of rows
	*/
	public function get_total_rows()
	{
		$this->db->from('ro_receivings_accounts');
		// $this->db->where('deleted', 0);

		return $this->db->count_all_results();
	}

	/*
	Gets information about a particular category
	*/
	 public function get_info($id)
	 {	
		$this->db->select('*');
	 	$this->db->from('ro_receivings_accounts');
	 	$this->db->where('id',$id);
	 	// $this->db->where('deleted', 0);
	 	$query = $this->db->get();

	 	if($query->num_rows()==1)
	 	{
	 		return $query->row();
	 	}
	 	else
	 	{
	 		//Get empty base parent object, as $item_kit_id is NOT an item kit
	 		$ro_receivings_obj = new stdClass();

	 		//Get all the fields from items table
	 		foreach($this->db->list_fields('ro_receivings_accounts') as $field)
	 		{
	 			$ro_receivings_obj->$field = '';
	 		}

	 		return $ro_receivings_obj;
	 	}
	  }
	public function get_info_filter()
	{ 
		// SELECT * FROM ospos_ro_receivings_accounts 
		// WHERE id IN ( SELECT MAX(id) FROM ospos_ro_receivings_accounts
		//  where id IN(select id from ospos_ro_receivings_accounts where deleted = 0)
		//  GROUP BY supplier_id );		
		$this->db->select('max(id)');		
		$this->db->from('ro_receivings_accounts');		
		$this->db->group_by('supplier_id');		
		$sub_query = $this->db->get_compiled_select();
		$this->db->select('id,supplier_id,opening_balance,purchase_amount,payment_mode,paid_amount,purchase_return_amount,closing_balance,purchase_return_qty,discount,pending_payables,last_purchase_qty,total_stock, receiving_time');
		$this->db->from('ro_receivings_accounts');
		$this->db->where("Id IN ($sub_query),deleted,0");
		
		$query = $this->db->get()->result();
					// //Get all the fields from items table
			foreach($query as $row)
			{		
				$ro_receivings_accounts[$row->supplier_id]=array('id'=>$row->id,
				'supplier_id'=>$row->supplier_id,
				'opening_balance'=>$row->opening_balance,
				'purchase_amount'=>$row->purchase_amount,
				'paid_amount'=>$row->paid_amount,
				'purchase_return_amount'=>$row->purchase_return_amount,				
				'closing_balance' =>$row->closing_balance,				
				'purchase_return_qty' => $row->purchase_return_qty,
				'discount' => $row->discount,
				'pending_payables' =>$row->pending_payables,
				'last_purchase_qty' =>$row->last_purchase_qty,				
				'total_stock' => $row->total_stock,
				'payment_mode'=>$row->payment_mode,
				'cheque_number'=>$row->cheque_number,
				'cheque_date'=>$row->cheque_date,
				'receiving_time'=>$row->receiving_time,
				'voucher_no'=>$row->voucher_no				
				);				
			}			
			
			  return $ro_receivings_accounts;
		 }
	/*
	Returns all the item_categories
	*/
	public function get_all($rows = 0, $limit_from = 0, $no_deleted = FALSE)
	{
		$this->db->from('ro_receivings_accounts');
		if($no_deleted == TRUE)
		{
			$this->db->where('deleted', 0);
		}

		$this->db->order_by('company_name', 'asc');

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}


	public function cheque_get_info()
	{
		$this->db->select('*');
	 	$this->db->from('ro_receivings_accounts');
	 	$this->db->where('payment_mode',"Cheque");
		
	 	// $this->db->where('deleted', 0);
	 	$query = $this->db->get()->result();
		return $query;

	 	// if($query->num_rows()==1)
	 	// {
	 	// 	return $query->row();
	 	// }
	 	// else
	 	// {
	 	// 	//Get empty base parent object, as $item_kit_id is NOT an item kit
	 	// 	$ro_receivings_obj = new stdClass();

	 	// 	//Get all the fields from items table
	 	// 	foreach($this->db->list_fields('ro_receivings_accounts') as $field)
	 	// 	{
	 	// 		$ro_receivings_obj->$field = '';
	 	// 	}

	 	// 	return $ro_receivings_obj;
	 	// }
	}

	public function get_cheque_info($id )
	{
		$this->db->from('ro_receivings_accounts');
		$this->db->where('id ', $id );
		$this->db->where('deleted', 0);
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_kit_id is NOT an item kit
			$ro_receivings_accounts_obj = new stdClass();

			//Get all the fields from items table
			foreach($this->db->list_fields('ro_receivings_accounts') as $field)
			{
				$ro_receivings_accounts_obj->$field = '';
			}

			return $ro_receivings_accounts_obj;
		}
	}


	public function companyname()
	{ 
		
		$this->db->from('suppliers');
		$this->db->select('suppliers.company_name,suppliers.person_id');
		$query = $this->db->get();			
		$rocompanyid = $query->result();
		return $rocompanyid;
		
	}

	public function agency_name($person_id)
	{ 		
		$this->db->from('suppliers');
		$this->db->select('suppliers.agency_name,suppliers.company_name');
		$this->db->where('suppliers.person_id',$person_id);
		$query = $this->db->get();			
		$agency_name = $query->result();		
		return $agency_name ;
		
	}

	public function opening_bal($person_id)
		{	
			$this->db->select ('ro_receivings_accounts.pending_payables') ;
			$this->db->from ('ro_receivings_accounts'); 
			$this->db->where('ro_receivings_accounts.supplier_id',$person_id);
			$query=$this->db->get();		
			$opening_result=$query->result();
	    	return  $opening_result;
		}

	/*
	Gets information about multiple item_master_id 
	*/
	public function get_multiple_info($id)
	{
		$this->db->from('ro_receivings_accounts');
		$this->db->where_in('id', $id);
		$this->db->order_by('company_name', 'asc');
		return $this->db->get();
	}

	/*
	Inserts or updates an item_category
	*/
	public function save(&$ro_receivings_data, $id = FALSE)
	{
		if(!$id || !$this->exists($id))
		{
			if($this->db->insert('ro_receivings_accounts', $ro_receivings_data))
			{
				$ro_receivings_data['id'] = $this->db->insert_id();

				return TRUE;
			}

			return FALSE;
		}

		$this->db->where('id', $id);

		return $this->db->update('ro_receivings_accounts', $ro_receivings_data);
	}

	/*
	Deletes a list of item_category
	*/
	public function delete_list($id)
	{
		$this->db->where_in('id', $id);

		return $this->db->update('ro_receivings_accounts', array('deleted' => 1));
 	}

	/*
	Gets rows
	*/
	public function get_found_rows($search)
	{
		return $this->search($search, 0, 0, 'company_name', 'asc', TRUE);
	}

	/*
	Perform a search on item_category
	*/
	public function search($search, $rows = 0, $limit_from = 0, $sort = 'company_name', $order='asc', $count_only = FALSE)
	{        
		// get_found_rows case
		if($count_only == TRUE)
		{	$this->db->select('max(id)');		
			$this->db->from('ro_receivings_accounts');
			$this->db->group_by('supplier_id');
			
			$sub_query = $this->db->get_compiled_select();
			$this->db->select('id,supplier_id,opening_balance,cheque_number,voucher_no,cheque_date,receiving_time,purchase_amount,payment_mode,paid_amount,purchase_return_amount,closing_balance,purchase_return_qty,discount,pending_payables,last_purchase_qty,total_stock, receiving_time');
			$this->db->from('ro_receivings_accounts');
			$this->db->where("Id IN ($sub_query)");		
			$query = $this->db->get()->result();					
			$num_of_row=count($query);
				return $num_of_row;
			
		}
			$this->db->select('max(id)');		
			$this->db->from('ro_receivings_accounts');
			$this->db->group_by('supplier_id');
			$sub_query = $this->db->get_compiled_select();
			$this->db->select('id,supplier_id,opening_balance,cheque_number,voucher_no,cheque_date,receiving_time,purchase_amount,payment_mode,paid_amount,purchase_return_amount,closing_balance,purchase_return_qty,discount,pending_payables,last_purchase_qty,total_stock, receiving_time');
			$this->db->from('ro_receivings_accounts');
			$this->db->where("Id IN ($sub_query)");						
			$this->db->group_start();
			$this->db->like('id', $search);
			$this->db->like('discount', $search);
			$this->db->or_like('purchase_date', $search);
			$this->db->group_end();	

		// get_found_rows case
		if($count_only == TRUE)
		{
			return $this->db->get()->row()->count;
		}

		$this->db->order_by($sort, $order);

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}
	// GET supplier info//
	// SELECT receiving_time,`opening_balance`,`purchase_amount`,`paid_amount`,`rate_difference`,
	// `payment_mode`,`purchase_return_amount`,`discount`,`closing_balance`
	//  FROM ospos_ro_receivings_accounts WHERE supplier_id=10;
	public function supplier_info($id)
	{ 
		$this->db->select('supplier_id,receiving_time,opening_balance,cheque_number,voucher_no,cheque_date,receiving_time,purchase_amount,paid_amount,rate_difference,payment_mode,purchase_return_amount,discount,closing_balance');
		$this->db->from('ro_receivings_accounts');
		$this->db->where('supplier_id',$id );
		$query = $this->db->get();			
		$supplier_details = $query->result_array();
		return $supplier_details;
	}
	public function supplier_summary($id)
	{
		// SELECT SUM(opening_balance) FROM ospos_ro_receivings_accounts WHERE supplier_id=10;
		$this->db->select('supplier_id,sum(purchase_amount) as purchase_amount,sum(purchase_return_amount) as purchase_return_amount,sum(discount) as discount,sum(rate_difference) as rate_difference');
		$this->db->from('ro_receivings_accounts');
		$this->db->where('supplier_id',$id);
		$query = $this->db->get()->result();			
		foreach($query as $row)
			{
				$supplier_total_open_balance[$row->supplier_id]=array('purchase_amount'=>$row->purchase_amount,
				'purchase_return_amount'=>$row->purchase_return_amount,
				'discount'=>$row->discount,
				'rate_difference'=>$row->rate_difference,							
				);
			}
		 return $supplier_total_open_balance;
	}

	public function open_close_bal($id)
	{
		$this->db->select('	opening_balance,pending_payables');
		$this->db->from('ro_receivings_accounts');
		$this->db->where('id',$id);
		$query = $this->db->get();			
		$open_close_bal = $query->result_array();
		 return $open_close_bal;
		
	}
	public function cash($id)
	{
		// SELECT  supplier_id,SUM(paid_amount),payment_mode FROM ospos_ro_receivings_accounts 
		// WHERE payment_mode='Cash' AND supplier_id=10;
	$this->db->select('SUM(paid_amount) as paid_amount');
	$this->db->from('ro_receivings_accounts');
	$this->db->where(' payment_mode="Cash" and supplier_id='.$id);
	$query = $this->db->get();			
	$cash= $query->result_array();
    return $cash;

	}
	public function cheque($id)
	{
		// SELECT  supplier_id,SUM(paid_amount),payment_mode FROM ospos_ro_receivings_accounts 
		// WHERE payment_mode!='Cash' AND supplier_id=10;
	$this->db->select('SUM(paid_amount) as paid_amount');
	$this->db->from('ro_receivings_accounts');
	$this->db->where(' payment_mode!="Cash" and supplier_id='.$id);
	$query = $this->db->get();			
	$cheque= $query->result_array();
	
    return $cheque;

	}
	public function save_bulk($save_bulk_entry,$id)
	{
	
		// log_message('debug',print_r($save_bulk_entry,TRUE));
	
			foreach($save_bulk_entry as $row)
			{
				
				 log_message('debug',print_r($row,TRUE));
				$query=$this->db->insert('ro_receivings_accounts', $row);
			}
			
	}
	// SELECT pending_payables FROM ospos_ro_receivings_accounts 
	// WHERE id IN ( SELECT MAX(id) FROM ospos_ro_receivings_accounts 
	// WHERE supplier_id=62  GROUP BY supplier_id   );
	public function pending_pay($supplier_id)
	{
			$this->db->select('max(id)');		
			$this->db->from('ro_receivings_accounts');
			$this->db->where('supplier_id',$supplier_id);
			$this->db->group_by('supplier_id');
			
			$sub_query = $this->db->get_compiled_select();
			$this->db->select('pending_payables');
			$this->db->from('ro_receivings_accounts');
			$this->db->where("Id IN ($sub_query)");		
			$query = $this->db->get()->result();
						
			if($query==NULL || $query=='0')
			{
				$query='0.00';
			 
				return $query;
			}
			return $query;
			
	}

}
?>
