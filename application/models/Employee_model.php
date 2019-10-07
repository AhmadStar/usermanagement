<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

	var $table = 'tbl_log';
	var $column_order = array(null,'userName',null,'createdDtm'); //set column field database for datatable orderable
	var $column_search = array('userName'); //set column field database for datatable searchable 
	var $order = array('createdDtm' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		//add custom filter here
		if($this->input->post('userName') && $this->input->post('userName') != 'Choose Employee')
		{
			$this->db->like('userName', $this->input->post('userName'));
		}		
		if($this->input->post('userId'))
		{
			$this->db->where('userId', $this->input->post('userId'));
		}

		$now = new \DateTime('now');
		$month = $now->format('m');
		$year = $now->format('Y');

		if($this->input->post('day'))
		{
			$this->db->where('day(createdDtm)', $this->input->post('day'));
		}

		if($this->input->post('month'))
		{
			$this->db->where('month(createdDtm)', $this->input->post('month'));
		}else{
			$this->db->where('month(createdDtm)', $month);
		}

		if($this->input->post('year'))
		{
			$this->db->where('year(createdDtm)', $this->input->post('year'));
		}else{
			$this->db->where('year(createdDtm)', $year);
		}		
		
		$this->db->from($this->table);
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->group_by('userId , userName , day(createdDtm)');
		$query = $this->db->get();
		$list = $query->result();
		return $list;
	}

	public function get_day_logins($id , $date)
	{
		$this->db->where('userId', $id);		
		$this->db->from($this->table);
		$query = $this->db->get();
		$list = $query->result();

		$array = [];
		foreach($list as $key => $employee) {
			if(date('d', strtotime($date)).' '.date('F', strtotime($date))
			!= date('d', strtotime($employee->createdDtm)).' '.date('F', strtotime($employee->createdDtm))){
				// Remove duplicate instance from the list
				unset($list[$key]);
			}
		}

		$sum = 0;			
		foreach($list as $key => $employee) {
			$array[] = $employee;		
		}

		for($i = 0 ; $i < count($array) ; $i++){
			if(array_key_exists($i+1 , $array))
				$sum = $sum + strtotime($array[$i + 1]->createdDtm) - strtotime($array[$i]->createdDtm);
			$i++;
		}
				
		$hours = floor($sum / 3600);
		$minutes = floor(($sum / 60) % 60);
		$seconds = $sum % 60;

		$sum = "$hours:$minutes:$seconds";

		$all_data = [];
		$all_data[0] = $list;
		$all_data[1] = $sum;
		return $all_data;
	}

	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		$list = $query->result();
		$temp_pageno = array();
		foreach($list as $key => $employee) {
			$pageno = $employee->userId.'day '.date('d', strtotime($employee->createdDtm)).' month '.date('F', strtotime($employee->createdDtm));
			if (in_array($pageno, $temp_pageno)) {
				// Remove duplicate instance from the list
				unset($list[$key]);
			}
			else {
				// Add to temporary list
				$temp_pageno[] = $pageno;
			}
		}
		return count($list);
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
    
	public function get_employees($employee_id = ''){
		$this->db->select('*');		
		$this->db->from('tbl_log');
		if($employee_id != '')
			$this->db->where('userId', $employee_id);		
		$query = $this->db->get();
		return $query->result();
	}

	public function get_day_hours($id , $date)
	{
		$this->db->where('userId', $id);		
		$this->db->from($this->table);
		$query = $this->db->get();
		$list = $query->result();

		$array = [];
		foreach($list as $key => $employee) {
			if(date('d', strtotime($date)).' '.date('F', strtotime($date))
			!= date('d', strtotime($employee->createdDtm)).' '.date('F', strtotime($employee->createdDtm))){
				// Remove duplicate instance from the list
				unset($list[$key]);
			}
		}

		$sum = 0;			
		foreach($list as $key => $employee) {
			$array[] = $employee;		
		}

		for($i = 0 ; $i < count($array) ; $i++){
			if(array_key_exists($i+1 , $array))
				$sum = $sum + strtotime($array[$i + 1]->createdDtm) - strtotime($array[$i]->createdDtm);
			$i++;
		}						

		return $sum;
	}

	public function get_total($userName = '', $month = '' , $year = ''){
		if($userName != 'Choose Employee'){

		$this->db->select('userId, userName , createdDtm');
		$this->db->group_by('userId , userName , day(createdDtm)');
		$this->db->from('tbl_log');
		$this->db->where('userName', $userName);

		$now = new \DateTime('now');
		$current_month = $now->format('m');
		$current_year = $now->format('Y');

		if($month != '')
		{
			$this->db->where('month(createdDtm)', $month);
		}else{
			$this->db->where('month(createdDtm)', $current_month);
		}

		if($year != '')
		{
			$this->db->where('year(createdDtm)', $year);
		}else{
			$this->db->where('year(createdDtm)', $current_year);
		}

		$query = $this->db->get();
		$list = $query->result();

		$sum = 0 ;
		foreach($list as $key1 => $employee) {
			$sum = $sum +  $this->get_day_hours($employee->userId , $employee->createdDtm );
		}

		// Create a temporary list of page numbers
		// $temp_pageno = array();
		// foreach($list as $key => $employee) {
		// 	$pageno = $employee->user_id.'day '.date('d', strtotime($employee->time)).' month '.date('F', strtotime($employee->time));
		// 	if (in_array($pageno, $temp_pageno)) {
		// 		// Remove duplicate instance from the list
		// 		unset($list[$key]);
		// 	}
		// 	else{
		// 		// Add to temporary list
		// 		$temp_pageno[] = $pageno;				
		// 	}
		// }

		// foreach($list as $key1 => $employee) {
		// 	$temp_array = array();
		// 	foreach($alllist as $key2 => $emp2) {
		// 		if($employee->user_id.''.date('d', strtotime($employee->time)).''.date('F', strtotime($employee->time))
		// 			== $emp2->user_id.''.date('d', strtotime($emp2->time)).''.date('F', strtotime($emp2->time))){
		// 			$temp_array[] = $alllist[$key2];
		// 		}
		// 	}

		// 	$sum_like = 0;
		// 	for($i = 0 ; $i < count($temp_array) ; $i++){
		// 		if(isset($temp_array[$i]) && isset($temp_array[$i+1]))
		// 			$sum_like = $sum_like + round(abs(strtotime($temp_array[$i]->time) - strtotime($temp_array[$i + 1]->time)));
		// 		$i++;				
		// 	}
		// 	$hours = floor($sum_like / 3600);
		// 	$minutes = floor(($sum_like / 60) % 60);
		// 	$seconds = $sum_like % 60;

		// 	$sum_like = "$hours:$minutes:$seconds";

		// 	$item = new stdClass();
		// 	$item->user_name = $employee->user_name;
		// 	$item->user_id = $employee->user_id;			
		// 	// $item->time = $employee->time;
		// 	$item->time = date('d', strtotime($employee->time)).' '.date('F', strtotime($employee->time));
		// 	$item->period = $sum_like ;
		// 	$item->type = $employee->type;
		// 	$list[$key1] = $item;
		// }

		$hours = floor($sum / 3600);
		$minutes = floor(($sum / 60) % 60);
		$seconds = $sum % 60;

		$sum = "$hours:$minutes:$seconds";

		$all_data = [];
		$all_data[0] = $list;
		$all_data[1] = $sum;
		return $all_data;
		}
		return 'please select a user';
	}	
}
