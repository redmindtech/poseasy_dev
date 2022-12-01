<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Item_category class
 */

class Ro_sales_cheques extends CI_Model
{
	/*
	Determines if a given item_category_id is an Item_category
	*/
	public function exists($id )
	{
		$this->db->from('ro_sales');
		$this->db->where('id', $id);

		return ($this->db->get()->num_rows() == 1);
	}

	/*
	Gets total of rows
	*/
	public function get_total_rows()
	{
		$this->db->from('ro_sales');
		// $this->db->where('deleted', 0);

		return $this->db->count_all_results();
	}

	

	/*
	Gets information about a particular category
	*/
	public function get_info($id)
	{
		
		$this->db->from('ro_sales');
		$this->db->where('id', $id );
		$this->db->where('payment_type', 'Cheque');
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
			foreach($this->db->list_fields('ro_sales') as $field)
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
		$this->db->from('ro_sales');
		if($no_deleted == TRUE)
		{
			$this->db->where('payment_type', 'Cheque');
			$this->db->where('status', 'pending');
		}

		$this->db->order_by('customer_id', 'asc');

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
		$this->db->from('ro_sales');
		$this->db->where_in('id', $id);
		$this->db->order_by('customer_id', 'asc');

		return $this->db->get();
	}

		
	// Cheque Reject
	public function reject_cheque($id,$final_val){


		$data = array(
			'paid_amount'=>0,
			'status' => 'rejected',
			// 'closing_balance'=> $closing_bal,
			'closing_balance'=> $final_val
			);
		$this->db->where('id', $id);		
		$result = $this->db->update('ro_sales', $data);
		return $result;

	}
	
	
	/*
	Gets rows
	*/
	public function get_found_rows($search)
	{
		return $this->search($search, 0, 0, 'id', 'asc', TRUE);
	}

	// save cheque 
	public function save_cheque($id,$final_val,$customer_id)
	{
		$data = array(
			'customer_id' => $customer_id,
			'closing_balance'=>$final_val,
			// 'pending_payables'=>$final_val,
			  'status'=>'complete'
			);
			log_message('debug',print_r($data,TRUE));
		$this->db->where('id', $id);		
		$result = $this->db->update('ro_sales', $data);
		return $result;
	}
	

	public function transaction_cheque($customer_id)
	{
		$this->db->select('max(id)');		
		$this->db->from('ro_sales');
		$this->db->where('customer_id',$customer_id);
		$this->db->group_by('customer_id');

		$sub_query = $this->db->get_compiled_select();
		$this->db->select('id','opening_balance','closing_balance','sales_amount','paid_amount','payment_type','status');
		$this->db->from('ro_sales');
		$this->db->where("Id IN ($sub_query)");		
			$query = $this->db->get()->result();
			
					
			return $query;
			
	}
	// SELECT * FROM ospos_ro_receivings_accounts 
	//   WHERE id > 237 AND supplier_id=65;
	public function remainding_ids($id,$customer_id)
	{
		$this->db->select('*');
		$this->db->from('ro_sales');
		$this->db->where('id >',$id);
		$this->db->where('customer_id',$customer_id);
		 
		$query = $this->db->get()->result();
		return $query;
		
	}
	public function after_cheque_pass_ids($id,$open_bal,$closing_bal)
	{
		$data = array(
			
			 'opening_balance' =>$open_bal,
			'closing_balance'=>$closing_bal,
			// 'pending_payables'=>$pending_pay,
			 'status'=>'complete'
			);
			log_message('debug',print_r($data,TRUE));
		$this->db->where('id', $id);		
		 $result = $this->db->update('ro_sales', $data);

		//  log_message('debug',print_r($result,TRUE));
		 return $result;
	}
	
	/*
	Perform a search on item_category
	*/
	public function search($search, $rows = 0, $limit_from = 0, $sort = 'cheque_number', $order='asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(ro_sales.id ) as count');
		}

		$this->db->from('ro_sales AS ro_sales');
		$this->db->join('people', 'ro_sales.customer_id = people.person_id');
		$this->db->group_start();
		$this->db->like('date_added', $search);
		$this->db->or_like('voucher_no', $search);
		$this->db->or_like('sales_cheque_no', $search);
		$this->db->or_like('first_name', $search);
		$this->db->or_like('last_name', $search);

		$this->db->group_end();
		$this->db->where('payment_type', 'Cheque');
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
