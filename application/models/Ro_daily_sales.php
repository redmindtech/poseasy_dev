<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Item_category class
 */

class Ro_daily_sales extends CI_Model
{
	/*
	Determines if a given item_category_id is an Item_category
	*/
	public function exists($id)
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

		// $decimals = totals_decimals();

		$this->db->select('
		ro_sales.id AS id,
		MAX(DATE(ro_sales.date_added)) AS date_added,
		MAX(ro_sales.date_added) AS date_added,
		MAX(ro_sales.voucher_no) AS voucher_no,
		MAX(CONCAT(customer_p.first_name, " ", customer_p.last_name)) AS customer_name,
		MAX(ro_sales.opening_balance) AS opening_balance,
		MAX(ro_sales.closing_balance) AS closing_balance,
		MAX(ro_sales.paid_amount) AS paid_amount,
		MAX(ro_sales.sales_amount) AS sales_amount,
		MAX(ro_sales.payment_type) AS payment_type,
		MAX(ro_sales.status) AS status,
		');

		$this->db->from('ro_sales AS ro_sales');
		$this->db->join('people AS customer_p', 'ro_sales.customer_id = customer_p.person_id', 'LEFT');
		// $this->db->join('sales_payments AS payments', 'ro_sales.id = payments.sale_id', 'LEFT OUTER');
		$this->db->join('people', 'ro_sales.customer_id = people.person_id');
		$this->db->where('id', $id );

		$this->db->group_by('ro_sales.id');
		$this->db->order_by('ro_sales.date_added', 'asc');
		// $this->db->where('payment_type', 'Cheque');
		// $this->db->where('status', 'pending');
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		// else
		// {
		// 	//Get empty base parent object, as $item_kit_id is NOT an item kit
		// 	$ro_sales_obj = new stdClass();

		// 	//Get all the fields from items table
		// 	foreach($this->db->list_fields('ro_sales') as $field)
		// 	{
		// 		$ro_sales_obj->$field = '';
		// 	}

		// 	return $ro_sales_obj;
		// }
	}
 

	/*
	Returns all the item_categories
	*/
	public function get_all($rows = 0, $limit_from = 0, $no_deleted = FALSE)
	{
		$this->db->from('ro_sales');
		if($no_deleted == TRUE)
		{
			// $this->db->where('date_added', 'Cheque');
			$this->db->where('status', 'complete');
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

		
	
	
	/*
	Gets rows
	*/
	public function get_found_rows($search, $filters)
	{
		return $this->search($search, $filters, 0, 0, 'ro_sales.date_added', 'desc', TRUE);
	}

	// save cheque 
	// public function save_cheque($id,$final_val,$customer_id)
	// {
	// 	$data = array(
	// 		'customer_id' => $customer_id,
	// 		'closing_balance'=>$final_val,
	// 		// 'pending_payables'=>$final_val,
	// 		  'status'=>'complete'
	// 		);
	// 		log_message('debug',print_r($data,TRUE));
	// 	$this->db->where('id', $id);		
	// 	$result = $this->db->update('ro_sales', $data);
	// 	return $result;
	// }
	

	// public function transaction_cheque($customer_id)
	// {
	// 	$this->db->select('max(id)');		
	// 	$this->db->from('ro_sales');
	// 	$this->db->where('customer_id',$customer_id);
	// 	$this->db->group_by('customer_id');

	// 	$sub_query = $this->db->get_compiled_select();
	// 	$this->db->select('id','opening_balance','closing_balance','sales_amount','paid_amount','payment_type','status');
	// 	$this->db->from('ro_sales');
	// 	$this->db->where("Id IN ($sub_query)");		
	// 		$query = $this->db->get()->result();
			
					
	// 		return $query;
			
	// }
	// SELECT * FROM ospos_ro_sales 
	//   WHERE id > 237 AND supplier_id=65;
	// public function remainding_ids($id,$customer_id)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('ro_sales');
	// 	$this->db->where('id >',$id);
	// 	$this->db->where('customer_id',$customer_id);
		 
	// 	$query = $this->db->get()->result();
	// 	return $query;
		
	// }
	// public function after_cheque_pass_ids($id,$open_bal,$closing_bal)
	// {
	// 	$data = array(
			
	// 		 'opening_balance' =>$open_bal,
	// 		'closing_balance'=>$closing_bal,
	// 		// 'pending_payables'=>$pending_pay,
	// 		 'status'=>'complete'
	// 		);
	// 		log_message('debug',print_r($data,TRUE));
	// 	$this->db->where('id', $id);		
	// 	 $result = $this->db->update('ro_sales', $data);

	// 	//  log_message('debug',print_r($result,TRUE));
	// 	 return $result;
	// }
	
	/*
	Perform a search on item_category
	*/
	public function search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'ro_sales.date_added', $order = 'desc', $count_only = FALSE)
	{

		$where = 'ro_sales.sale_type = 0 AND ';	
		
		

		if(empty($this->config->item('date_or_time_format')))
		{
			$where .= 'DATE(ro_sales.date_added) BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']);
		}
		else
		{
			$where .= 'ro_sales.date_added BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date']));
		}

		// $date = new DateTime("now");
		// $curr_date = $date->format('Y-m-d');
		
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(ro_sales.id ) as count');
		}
		else
		{
		$this->db->select('
		ro_sales.id AS id,
		MAX(DATE(ro_sales.date_added)) AS date_added,
		MAX(ro_sales.date_added) AS date_added,
		MAX(ro_sales.voucher_no) AS voucher_no,
		MAX(CONCAT(customer_p.first_name, " ", customer_p.last_name)) AS customer_name,
		MAX(ro_sales.opening_balance) AS opening_balance,
		MAX(ro_sales.closing_balance) AS closing_balance,
		MAX(ro_sales.paid_amount) AS paid_amount,
		MAX(ro_sales.sales_amount) AS sales_amount,
		MAX(ro_sales.payment_type) AS payment_type,
		MAX(ro_sales.status) AS status,
		');
		}
		$this->db->from('ro_sales AS ro_sales');
		$this->db->join('ro_sales_items', 'ro_sales.id = ro_sales_items.sales_id');
		$this->db->join('people', 'ro_sales.customer_id = people.person_id');
		$this->db->join('people AS customer_p', 'ro_sales.customer_id = customer_p.person_id', 'LEFT');
		// $this->db->join('sales_payments AS payments', 'ro_sales.id = payments.sale_id', 'LEFT OUTER');
		$this->db->group_start();
		$this->db->like('date_added', $search);
		$this->db->or_like('voucher_no', $search);
		// $this->db->or_like('sales_cheque_no', $search);
		$this->db->or_like('customer_p.first_name', $search);
		$this->db->or_like('customer_p.last_name', $search);

		$this->db->group_end();
		
		// $this->db->where('id', $id);

		$this->db->group_by('ro_sales.id');
		$this->db->order_by('ro_sales.date_added', 'asc');
		
		$this->db->where($where);
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
