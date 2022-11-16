<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dashboard class
 */
class Dashboard extends CI_Model
{
	
	public function get_total_payables()
	{
		 $this->db->select('SUM(paid_amount) as paid_amount');
		 $this->db->from('ro_receivings_accounts');
		 $query=$this->db->get();
		 $fetched_item_id=$query->row();
		 return $fetched_item_id->paid_amount;		
	}
	public function get_total_receivables()
	{
		 $this->db->select('SUM(paid_amount) as paid_amount');
		 $this->db->from('ro_sales');
		 $query=$this->db->get();
		 $fetched_item_id=$query->row();
		 var_dump($fetched_item_id->paid_amount);
		 return $fetched_item_id->paid_amount;		
	}
	public function get_total_expenses()
	{
		
		 $this->db->select('SUM(amount) as paid_amount');
		 $this->db->from('expenses');
		 $query=$this->db->get();
		 $fetched_item_id=$query->row();
		 var_dump($fetched_item_id->paid_amount);
		 return $fetched_item_id->paid_amount;		
	}
	public function get_total_stock()
	{
		
		 $this->db->select('SUM(receiving_quantity) as receiving_quantity');
		 $this->db->from('items');
		 $query=$this->db->get();
		 $fetched_item_id=$query->row();
		 return $fetched_item_id->receiving_quantity;		
	}
	public function get_total_stock_value()
	{
		
		 $this->db->select('SUM(receiving_quantity * unit_price) as total_amount');
		 $this->db->from('items');
		 $query=$this->db->get();
		 $fetched_item_id=$query->row();
		 return $fetched_item_id->total_amount;		
	}

	
}
?>
