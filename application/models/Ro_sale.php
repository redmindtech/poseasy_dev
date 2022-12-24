<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Item_category class
 */

class Ro_sale extends CI_Model
{
	/*
	Determines if a given item_category_id is an Item_category
	*/
	public function exists($id )
	{
		$this->db->from('ro_sales');
		$this->db->where('id', $id );

		return ($this->db->get()->num_rows() == 1);
	}

	/*
	Gets total of rows
	*/
	public function get_total_rows()
	{
		$this->db->from('ro_sales');
		$this->db->where('deleted', 0);

		return $this->db->count_all_results();
	}

	/*
	Gets information about a particular category
	*/
	public function get_info($id)
	{
        $this->db->select('*');
		$this->db->from('ro_sales');
		$this->db->where('id', $id);
		// $this->db->where('deleted', 0);
		$query = $this->db->get();
        
		if($query->num_rows()==1)
		{
			return $query->row();
            // var_dump($this->db->get());
		}
		else
		{
			//Get empty base parent object, as $item_kit_id is NOT an item kit
			$ro_sales_obj = new stdClass();

			//Get all the fields from items table
			foreach($this->db->list_fields('ro_sales') as $field)
			{
				$ro_sales_obj->$field = '';
			}

			return $ro_sales_obj;
		}
	}

	// Get Open Balance

	// SELECT closing_balance FROM ospos_ro_sales
	// WHERE id IN ( SELECT MAX(id) FROM ospos_ro_sales
	// WHERE customer_id=26  GROUP BY customer_id);

	public function pending_pay($customer_id)
	{
			$this->db->select('max(id)');		
			$this->db->from('ro_sales');
			$this->db->where('customer_id',$customer_id);
			$this->db->group_by('customer_id');

			$sub_query = $this->db->get_compiled_select();
			$this->db->select('closing_balance');
			$this->db->from('ro_sales');
			$this->db->where("Id IN ($sub_query)");		
			$query = $this->db->get()->result();
						
			if($query==NULL || $query=='0')
			{
				$query='0.00';
			 
				return $query;
			}
			return $query;
			
	}



	/*
	Returns all the item_categories
	*/
	public function get_all($rows = 0, $limit_from = 0, $no_deleted = FALSE)
	{
		$this->db->from('ro_sales');
		if($no_deleted == TRUE)
		{
			// $this->db->where('deleted', 0);
		}

		$this->db->order_by('voucher_no', 'asc');

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
		$this->db->order_by('voucher_no', 'asc');

		return $this->db->get();
	}

    // Inserts bulk data

    public function save_sales($save_bulk_entry,$id)
	{
	
		// log_message('debug',print_r($save_bulk_entry,TRUE));
	
			foreach($save_bulk_entry as $row)
			{
				
				
				$query=$this->db->insert('ro_sales', $row);
			}
			
	}

	/*
	Inserts or updates an item_category
	*/
	// public function save(&$master_category_data, $item_master_id  = FALSE)
	// {
	// 	if(!$item_master_id  || !$this->exists($item_master_id))
	// 	{
	// 		if($this->db->insert('master_category', $master_category_data))
	// 		{
	// 			$master_category_data['item_master_id '] = $this->db->insert_id();

	// 			return TRUE;
	// 		}

	// 		return FALSE;
	// 	}

	// 	$this->db->where('item_master_id ', $item_master_id );

	// 	return $this->db->update('master_category', $master_category_data);
	// }

	/*
	Deletes a list of item_category
	*/
	// public function delete_list($item_master_id)
	// {
	// 	$this->db->where_in('item_master_id ', $item_master_id);

	// 	return $this->db->update('master_category', array('deleted' => 1));
 	// }

	/*
	Gets rows
	*/
	public function get_found_rows($search)
	{
		return $this->search($search, 0, 0, 'voucher_no', 'asc', TRUE);
	}

	/*
	Perform a search on item_category
	*/
	public function search($search, $rows = 0, $limit_from = 0, $sort = 'voucher_no', $order='asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(ro_sales.id ) as count');
		}

		$this->db->from('ro_sales AS ro_sales');
		$this->db->group_start();
		$this->db->like('voucher_no', $search);
		$this->db->or_like('payment_type', $search);
		$this->db->group_end();
		// $this->db->where('deleted', 0);

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
