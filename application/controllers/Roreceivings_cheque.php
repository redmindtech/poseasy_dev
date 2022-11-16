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
			$data_rows[] = $this->xss_clean(get_ro_cheque_data_row($ro_receivings_accounts,$count));
			$count++;
		}

		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
   //Get row
	public function get_row($row_id)
	{
		$data_row = $this->xss_clean(get_ro_cheque_data_row($this->Roreceivings_cheques->get_info($row_id)));
		echo json_encode($data_row);
	}
     //View new form
	// public function view($id = -1)
	// {
	// 	$data['Master_category_info'] = $this->Roreceivings_cheques->get_info($id);

	// 	$this->load->view("masters/form", $data);
	// }
	//Save new form
	
	
}
?>
