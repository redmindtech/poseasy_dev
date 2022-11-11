<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Masters extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('masters');
	}

	public function index()
	{
		 $data['table_headers'] = $this->xss_clean(get_Master_manage_table_headers());

		 $this->load->view('masters/manage', $data);
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
		$master_category = $this->Master->search($search, $limit, $offset, $sort, $order);
		$total_rows = $this->Master->get_found_rows($search);

		//var_dump($offset);

		$count = $offset+1;

		$data_rows = array();
		foreach($master_category->result() as $master_category)
		{
			$data_rows[] = $this->xss_clean(get_master_data_row($master_category,$count));
			$count++;
		}

		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
   //Get row
	public function get_row($row_id)
	{
		$data_row = $this->xss_clean(get_master_data_row($this->Master->get_info($row_id)));
		echo json_encode($data_row);
	}
     //View new form
	public function view($item_master_id = -1)
	{
		$data['Master_category_info'] = $this->Master->get_info($item_master_id);

		$this->load->view("masters/form", $data);
	}
	//Save new form
	public function save($item_master_id = -1)
	{
		
		$master_category_data = array(
			'item_category_name' => $this->input->post('item_category_name'),
			'item_category_description' => $this->input->post('item_category_description'),
		);
		
		if($this->Master->save($master_category_data, $item_master_id))
		{
			$master_category_data = $this->xss_clean($master_category_data);

			// New master_category_id
			if($item_master_id == -1)
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('masters_successful_adding'), 'id' => $master_category_data['item_master_id']));	
			}
			// Existing master Category
			else 
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('item_updated_successful'), 'id' => $item_master_id));
			}
		}
		//failure
		else
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('item_categories_error_adding_updating') . ' ' . $master_category_data['item_master_name'], 'id' => -1));
		}
	}
    //Delete data from formtable
	public function delete()
	{
		$master_category_to_delete = $this->input->post('ids');

		if($this->Master->delete_list($master_category_to_delete))
		{
			echo json_encode(array('success' => TRUE, 'message' => count($master_category_to_delete) . ' ' . $this->lang->line('item_categories_successful_delete') ));
		}
		else
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('item_categories_cannot_be_deleted')));
		}
	}
}
?>
