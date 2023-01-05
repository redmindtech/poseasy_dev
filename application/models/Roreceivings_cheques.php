<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Item_category class
 */

class Roreceivings_cheques extends CI_Model
{
	/*
	Determines if a given item_category_id is an Item_category
	*/
	public function exists($id )
	{
		$this->db->from('ro_receivings_accounts');
		$this->db->where('id ', $id );

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
		
		$this->db->from('ro_receivings_accounts');
		$this->db->where('id', $id );
		$this->db->where('payment_mode', 'Cheque');
		$this->db->where('status', 'pending');
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
 

	/*
	Returns all the item_categories
	*/
	public function get_all($rows = 0, $limit_from = 0, $no_deleted = FALSE)
	{
		$this->db->from('ro_receivings_accounts');
		if($no_deleted == TRUE)
		{
			$this->db->where('payment_mode', 'Cheque');
			$this->db->where('status', 'pending');
		}

		$this->db->order_by('cheque_number', 'asc');

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}
	/*
	Gets information about multiple item_master_id 
	*/
	public function get_multiple_info($id)
	{
		$this->db->from('ro_receivings_accounts');
		$this->db->where_in('id ', $id );
		$this->db->order_by('cheque_number', 'asc');

		return $this->db->get();
	}

	/*
	Deletes a list of item_category
	*/
	
	/*
	Gets rows
	*/

	

	
	
	/*
	Deletes a list of item_category
	*/
	
	/*
	Gets rows
	*/
	public function get_found_rows($search)
	{
		return $this->search($search, 0, 0, 'cheque_number', 'asc', TRUE);
	}


	public function reject_cheque($id,$overall_val,$pending_payables){


		$data = array(
			'paid_amount'=>0,
			'status' => 'rejected',
			'pending_payables'=> $pending_payables,
			'closing_balance'=> $overall_val
			);
		$this->db->where('id', $id);		
		$result = $this->db->update('ro_receivings_accounts', $data);
		return $result;



	}
	public function save_cheque($id,$overall_val,$final_val,$supplier_id)
	{
		$data = array(
			'supplier_id' => $supplier_id,
			'closing_balance'=>$overall_val,
			'pending_payables'=>$final_val,
			  'status'=>'complete'
			);
		$this->db->where('id', $id);		
		$result = $this->db->update('ro_receivings_accounts', $data);
		return $result;
	}
	

	public function transaction_cheque($supplier_id )
	{
		$this->db->select('max(id)');		
		$this->db->from('ro_receivings_accounts');
		$this->db->where('supplier_id',$supplier_id);
		$this->db->group_by('supplier_id');

		$sub_query = $this->db->get_compiled_select();
		$this->db->select('id','opening_balance','purchase_amount','paid_amount','pending_payables','payment_mode','purchase_return_amount','discount','status');
		$this->db->from('ro_receivings_accounts');
		$this->db->where("Id IN ($sub_query)");		
			$query = $this->db->get()->result();
			
					
			return $query;
			
	}
	// SELECT * FROM ospos_ro_receivings_accounts 
	//   WHERE id > 237 AND supplier_id=65;
	public function remainding_ids($id,$supplier_id)
	{
		$this->db->select('*');
		$this->db->from('ro_receivings_accounts');
		$this->db->where('id >',$id );
		$this->db->where( 'supplier_id',$supplier_id);
		 
		$query = $this->db->get()->result();
		return $query;
		
	}
	public function after_cheque_pass_ids($id,$open_bal,$closing_bal,$pending_pay)
	{
		$data = array(
			
			 'opening_balance' =>$open_bal,
			'closing_balance'=>$closing_bal,
			'pending_payables'=>$pending_pay,
			//  'status'=>'complete'
			);
			log_message('debug',print_r($data,TRUE));
		$this->db->where('id', $id);		
		 $result = $this->db->update('ro_receivings_accounts', $data);

		//  log_message('debug',print_r($result,TRUE));
		// return $result;
	}
	
	/*
	Perform a search on item_category
	*/
	public function search($search, $rows = 0, $limit_from = 0, $sort = 'cheque_number', $order='asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(ro_receivings_accounts.id ) as count');
		}

		$this->db->from('ro_receivings_accounts AS ro_receivings_accounts');
		$this->db->join('suppliers AS suppliers', 'suppliers.person_id = ro_receivings_accounts.supplier_id', 'left');
		$this->db->group_start();
		$this->db->like('cheque_number', $search);
		$this->db->or_like('cheque_date', $search);
		$this->db->or_like('company_name', $search);
		$this->db->group_end();
		$this->db->where('payment_mode', 'Cheque');
		$this->db->where('status', 'pending');

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
}
?>
