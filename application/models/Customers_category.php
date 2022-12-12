<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Expense_category class
 */

class Customers_category extends CI_Model
{
	/*
	Determines if a given Expense_id is an Expense category
	*/
	public function exists($customer_category_id )
	{
		$this->db->from('customer_category');
		$this->db->where('customer_category_id', $customer_category_id);

		return ($this->db->get()->num_rows() == 1);
	}

	/*
	Gets total of rows
	*/
	public function get_total_rows()
	{
		$this->db->from('customer_category');
		$this->db->where('deleted', 0);

		return $this->db->count_all_results();
	}

	public function customer_name_exists($name_item)
	{
		$this->db->select('lower(REPLACE(customer_category_name," ","")) as customer_category_name');
		 $this->db->from('customer_category');
		 $this->db->where('deleted',0);
		 $query=$this->db->get();
		 $item_name=$query->result();
		 foreach($item_name as $item_name)
		 { 		
			$item_name=$item_name->customer_category_name;

			$name_item = preg_replace('/\s*/', '', $name_item);
			$name_item = strtolower($name_item);

						
			if($item_name ==$name_item)
			{
				return "false";
			}			
		 }
		 return "true";		 
	}

	public function customer_name_exists_edit($name_item,$assume)
	{
		//$assume = 'b';
		 $this->db->select('lower(REPLACE(customer_category_name," ","")) as customer_category_name');
		 $this->db->from('customer_category');
		 $this->db->where('deleted',0);
		 $query=$this->db->get();
		 $item_name=$query->result();
		 foreach($item_name as $item_name)
		 { 		
			$item_name=$item_name->customer_category_name;

			$name_item = preg_replace('/\s*/', '', $name_item);
			$name_item = strtolower($name_item);

						
			if($item_name ==$name_item)
			{
				if($name_item == $assume){
					return "true";
				}
				else{
				return "false";
				}
			}			
		 }
		 return "true";		 
	}

	public function customer_category_inform()
	{
		$this->db->select('customer_category_name');
		$this->db->from('customer_category');
		$this->db->where('deleted',0);
	    $query = $this->db->get();			
		$customer_category_name = $query->result_array();
		
		return $customer_category_name;

		
	}


	public function customer_category_id()
	{
		$this->db->select('customer_category_id');
		$this->db->from('customer_category');
		$this->db->where('deleted',0);
	    $query = $this->db->get();			
		$customer_category_name = $query->result_array();
		
		return $customer_category_name;

		
	}


	public function fetch_item_id()
	{
		$this->db->select('item_id');
		$this->db->from('items');
		$this->db->where('deleted',0);
	    $query = $this->db->get();			
		$customer_category_name = $query->result_array();
		
		return $customer_category_name;

		
	}
	public function item_customer_category_price_fetch($item_id)
	{

		

		$this->db->select('sales_price');
		$this->db->from('item_customer_category_price');
		$this->db->where('item_id',$item_id);		
	    $query = $this->db->get();	
		if($query->num_rows()!=0){
			$item_customer_category_price_fetched_data = $query->result_array();
			return $item_customer_category_price_fetched_data;


		}else{
			$null_flag = 'null';
			return  $null_flag;
		}	
		
		
	}

	/*
	Gets information about a particular category
	*/
	public function get_info($customer_category_id)
	{
		$this->db->from('customer_category');
		$this->db->where('customer_category_id', $customer_category_id);
		$this->db->where('deleted', 0);
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_kit_id is NOT an item kit
			$customer_category_obj = new stdClass();

			//Get all the fields from items table
			foreach($this->db->list_fields('customer_category') as $field)
			{
				$customer_category_obj->$field = '';
			}

			return $customer_category_obj;
		}
	}

	/*
	Returns all the expense_categories
	*/
	public function get_all($rows = 0, $limit_from = 0, $no_deleted = FALSE)
	{
		$this->db->from('customer_category');
		if($no_deleted == TRUE)
		{
			$this->db->where('deleted', 0);
		}

		$this->db->order_by('customer_category_name', 'asc');

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}

	/*
	Gets information about multiple customer_category_id 
	*/
	public function get_multiple_info($customer_category_id)
	{
		$this->db->from('customer_category');
		$this->db->where_in('customer_category_id', $customer_category_id);
		$this->db->order_by('customer_category_name', 'asc');

		return $this->db->get();
	}

	/*
	Inserts or updates an expense_category
	*/
	public function save(&$customer_category_data, $customer_category_id = FALSE)
	{
		if(!$customer_category_id || !$this->exists($customer_category_id))
		{
			if($this->db->insert('customer_category', $customer_category_data))
			{
				$customer_category_data['customer_category_id'] = $this->db->insert_id();

				return TRUE;
			}

			return FALSE;
		}

		$this->db->where('customer_category_id', $customer_category_id);

		return $this->db->update('customer_category', $customer_category_data);
	}

	/*
	Deletes a list of expense_category
	*/
	public function delete_list($customer_category_id)
	{
		$this->db->where_in('customer_category_id', $customer_category_id);

		return $this->db->update('customer_category', array('deleted' => 1));
 	}

	/*	
	Gets rows
	*/
	public function get_found_rows($search)
	{
		return $this->search($search, 0, 0, 'customer_category_name', 'asc', TRUE);
	}

	/*
	Perform a search on expense_category
	*/
	public function search($search, $rows = 0, $limit_from = 0, $sort = 'customer_category_name', $order='asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(customer_category.customer_category_id) as count');
		}

		$this->db->from('customer_category AS customer_category');
		$this->db->group_start();
			$this->db->like('customer_category_price', $search);
			$this->db->like('customer_category_name', $search);
			$this->db->or_like('customer_category_disc', $search);
		$this->db->group_end();
		$this->db->where('deleted', 0);

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
