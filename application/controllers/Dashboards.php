<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Dashboards extends Secure_Controller
{
	function __construct()
	{
		parent::__construct('dashboards');
		//$this->load->model('Dashboard', '', TRUE);    
	}
	

	public function index()
	{
		$data['total_payables'] = $this->Dashboard->get_total_payables();
		$data['total_receivables'] = $this->Dashboard->get_total_receivables();
		$data['total_stock'] = $this->Dashboard->get_total_stock();
		$data['total_stock_value'] = $this->Dashboard->get_total_stock_value();
		$data['total_expenses'] = $this->Dashboard->get_total_expenses();
		$data['total_income'] = $data['total_receivables'] - $data['total_payables'] - $data['total_expenses'];
		$data['total_stock'] = number_format($data['total_stock'],1);
		$data['total_stock_value'] = number_format($data['total_stock_value'],2);
		$data['total_income'] = number_format($data['total_income'],2);
		if($data['total_income'] > 0)
		{
			$data['income_color'] = "green";
		}
		else
		{
			$data['income_color'] = "red";
		}

		//var_dump($data);
		$this->load->view('dashboard/form', $data);
	}

	public function logout()
	{
		$this->Employee->logout();
	}
}
?>