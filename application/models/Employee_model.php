<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

	var $table = 'tbl_log';
	var $column_order = array(null,'userName',null,'createdDtm'); //set column field database for datatable orderable
	var $column_search = array('userName'); //set column field database for datatable searchable 
	var $order = array('createdDtm' => 'desc'); // default order 

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


		foreach ($list as $key => $employee) {
			$item = new stdClass();
			$item->userName = $employee->userName;
			$item->userId = $employee->userId;
			$item->createdDtm = $employee->createdDtm;
			$sum = $this->get_day_hours($employee->userId , $employee->createdDtm);
			$hours = floor($sum / 3600);
			$minutes = floor(($sum / 60) % 60);
			$seconds = $sum % 60;
			$sum = "$hours:$minutes:$seconds";
			$item->total = $sum;
			$list[$key] = $item;
		}

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
		$this->db->from('tbl_users');
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


	//return array all hours of every day
    public function get_month_hours($month , $year , $userId = '')
	{
        $this->db->select('BaseTbl.userId');
        $this->db->from('tbl_users as BaseTbl');
		$this->db->where('BaseTbl.isDeleted', 0);
		if($userId != '')
			$this->db->where('userId', $userId);
        $query = $this->db->get();
        
        $list = $query->result();
		
		$array= [];
		
		if(!$year){
			$year=date('Y');
		}
		$num = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
		for($day=1;$day<=$num;$day++){
			$sum = 0 ;
			foreach($list as $key => $employee) {				
				$sum = $sum + $this->get_total_as_sum($employee->userId , $day);
			}
			$hours = floor($sum / 3600);
			$minutes = floor(($sum / 60) % 60);
			$seconds = $sum % 60;
			
			$array[] = "$hours.$minutes";
		}
		return $array;
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

			$hours = floor($sum / 3600);
			$minutes = floor(($sum / 60) % 60);
			$seconds = $sum % 60;

			$sum = "$hours:$minutes:$seconds";

			// $all_data = [];
			// $all_data[0] = $list;
			// $all_data[1] = $sum;
			return $sum;
		}		
		$all_data = 'empty';		
		return $all_data;
	}
	
	
	public function get_total_as_sum($userId = '' , $day){		
		$this->db->select('userId, userName , createdDtm');
		$this->db->group_by('userId , userName , day(createdDtm)');
		$this->db->from('tbl_log');
		$this->db->where('userId', $userId);

		$now = new \DateTime('now');
		$current_month = $now->format('m');
		$current_year = $now->format('Y');		

		
		$this->db->where('month(createdDtm)', $current_month);
	
		$this->db->where('day(createdDtm)', $day);
	
		$this->db->where('year(createdDtm)', $current_year);
		

		$query = $this->db->get();
		$list = $query->result();

		$sum = 0 ;
		foreach($list as $key1 => $employee) {
			$sum = $sum +  $this->get_day_hours($employee->userId , $employee->createdDtm );
		}
		return $sum;		
	}
}
