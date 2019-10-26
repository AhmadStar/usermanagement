<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role, BaseTbl.picture , COUNT(bonus.user_id) as stars');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        $this->db->join('bonus', 'bonus.user_id = BaseTbl.userId','left');        
        $this->db->group_by('BaseTbl.userId');
        $this->db->HAVING('stars >= 0');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        // $now = new \DateTime('now');
		// $month = $now->format('m');		
        // $this->db->where('month(bonus.date)', $month);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();

        // var_dump($result);die();

        return $result;
    }
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get the user getUserGroups
     * @return array $result : This is result of the query
     */
    function getUserGroups()
    {
        $this->db->select('id, name');
        $this->db->from('groups');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get picture
     * @param string $userId : This is the Id of user
     */
    function get_picture($userId)
    {
        $this->db->select('picture');
        $this->db->from('tbl_users');
        $this->db->where("userId", $userId);
        $query = $this->db->get();
        $res = $query->result();
        return $res[0];
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * This function is used to check whether User name id is already exist or not
     * @param {string} $fname : This is fname
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkUsernameExists($fname, $userId = 0)
    {
        $this->db->select("name");
        $this->db->from("tbl_users");
        $this->db->where("name", $fname);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to add user to group
     * @return number $insert_id : This is last inserted id
     */
    function addUserToGroup($userGroup)
    {
        $this->db->trans_start();
        $this->db->insert('user_group', $userGroup);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId , picture , user_group.group_id');
        $this->db->from('tbl_users');
        $this->db->join('user_group', 'user_group.user_id = tbl_users.userId');        
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return TRUE;
    }


    /**
     * This function is used to update the user group information
     * @param array $userGroup : This is users group information
     * @param number $userId : This is user id
     */
    function editUserGroup($userGroup, $userId)
    {
        $this->db->where('user_id', $userId);
        $this->db->update('user_group', $userGroup);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to delete bonus
     * @param number $bonusid : This is bonus id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteBonus($bonusid)
    {
        $this->db->where('id', $bonusid);
        $this->db->delete('bonus');
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to addBonus the user
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function addBonus($userId , $title , $desc)
    {
        $userInfo = array('user_id'=>$userId , 'title' => $title , 'description' => $desc);
        $this->db->trans_start();
        $this->db->insert('bonus', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function used to get user bonus by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserBonus($bonusId)
    {
        $this->db->select('id, title, description, date');
        $this->db->from('bonus');        
        $this->db->where('id', $bonusId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function is used to update the user bonus
     * @param array $bonusInfo : This is bonus updated information
     * @param number $userId : This is user id
     */
    function editBonus($bonusInfo, $bonusId)
    {
        $this->db->where('id', $bonusId);
        $this->db->update('bonus', $bonusInfo);
        
        return TRUE;
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user log history count
     * @param number $userId : This is user id
     */
    	
    function logHistoryCount($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_log as BaseTbl');
        $this->db->group_by('userId , userName , day(createdDtm)');

        if ($userId == NULL)
        {
            $query = $this->db->get();
            return $query->num_rows();
        }
        else
        {
            $this->db->where('BaseTbl.userId', $userId);
            $query = $this->db->get();
            return $query->num_rows();
        }
    }

/**
     * This function is used to get user bonus
     * @param number $userId : This is user id
     * @return array $result : This is result
     */
    function userBonus($userId)
    {
        $this->db->select('*');        
        $this->db->from('bonus as BaseTbl');

        if ($userId == NULL)
        {
            $this->db->order_by('BaseTbl.date', 'DESC');
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }
        else
        {
            $this->db->where('BaseTbl.user_id', $userId);
            $this->db->order_by('BaseTbl.date', 'DESC');
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }

    /**
     * This function is used to get user log history
     * @param number $userId : This is user id
     * @return array $result : This is result
     */
    function logHistory($userId)
    {
        $this->db->select('*');        
        $this->db->from('tbl_log as BaseTbl');
        $this->db->group_by('userId , userName , day(createdDtm)');

        if ($userId == NULL)
        {
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();            
        }
        else
        {
            $this->db->where('BaseTbl.userId', $userId);
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();            
        }

        // to count the work hout for every day or record
        foreach ($result as $key => $employee) {
			$item = new stdClass();
			$item->userName = $employee->userName;
			$item->userId = $employee->userId;
            $item->createdDtm = $employee->createdDtm;
            // invoke to get the sum of work hours
			$sum = $this->get_day_hours($employee->userId , $employee->createdDtm);
			$hours = floor($sum / 3600);
			$minutes = floor(($sum / 60) % 60);
			$seconds = $sum % 60;
			$sum = "$hours:$minutes:$seconds";
			$item->total = $sum;
			$result[$key] = $item;
        }
        
        return $result;
    }

    public function get_day_hours($id , $date)
	{
		$this->db->where('userId', $id);		
		$this->db->from('tbl_log');
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

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function is used to get tasks
     */
    function getTasks($employee_id = '')
    {
        // $this->db->select('*');
        $this->db->select('TaskTbl.id , TaskTbl.title , TaskTbl.comment , Situations.statusId ,Situations.status, Users.name , Roles.role, 
        Prioritys.priorityId , Prioritys.priority , 
        endDtm , TaskTbl.createdDtm , employee_id');
        $this->db->from('tbl_task as TaskTbl');
        $this->db->join('tbl_users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('tbl_roles as Roles','Roles.roleId = Users.roleId');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = TaskTbl.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = TaskTbl.priorityId');
        $this->db->order_by('TaskTbl.createdDtm DESC');
        $this->db->where('TaskTbl.statusId', 1);
        if($employee_id != '')
            $this->db->where('employee_id', $employee_id);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get tasks
     */
    function getBendingTasks()
    {
        $this->db->select('TaskTbl.id , TaskTbl.title , TaskTbl.comment , Situations.statusId ,Situations.status, Users.name , Roles.role, 
        Prioritys.priorityId , Prioritys.priority , 
        endDtm , TaskTbl.createdDtm , employee_id');
        $this->db->from('tbl_task as TaskTbl');
        $this->db->join('tbl_users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('tbl_roles as Roles','Roles.roleId = Users.roleId');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = TaskTbl.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = TaskTbl.priorityId');
        $this->db->order_by('TaskTbl.createdDtm DESC');
        $this->db->where('TaskTbl.statusId', 3);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get tasks
     */
    function getClientTasks($userId)
    {
        $this->db->select('TaskTbl.id , TaskTbl.title , TaskTbl.comment , Situations.statusId ,Situations.status, Users.name , Roles.role, 
        Prioritys.priorityId , Prioritys.priority , 
        endDtm , TaskTbl.createdDtm , employee_id');
        $this->db->from('tbl_task as TaskTbl');
        $this->db->join('tbl_users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('tbl_roles as Roles','Roles.roleId = Users.roleId');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = TaskTbl.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = TaskTbl.priorityId');
        $this->db->order_by('TaskTbl.createdDtm DESC');
        $this->db->where('TaskTbl.createdBy', $userId);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get tasks
     */
    function getFinishedTasks($employee_id = '')
    {
        // $this->db->select('*');
        $this->db->select('TaskTbl.id , TaskTbl.title , TaskTbl.comment , Situations.statusId ,Situations.status, Users.name , Roles.role, 
        Prioritys.priorityId , Prioritys.priority , 
        endDtm , TaskTbl.createdDtm , employee_id , finished_by');
        $this->db->from('tbl_task as TaskTbl');
        $this->db->join('tbl_users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('tbl_roles as Roles','Roles.roleId = Users.roleId');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = TaskTbl.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = TaskTbl.priorityId');
        $this->db->order_by('TaskTbl.endDtm DESC');
        $this->db->where('TaskTbl.statusId', 2);
        if($employee_id != ''){
            $this->db->where('employee_id', $employee_id);
            $this->db->or_where('finished_by', $employee_id);
        }
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }


    /**
     * This function is used to get group tasks
     */
    function getgroupTasks($group)
    {
        // $this->db->select('*');
        $this->db->select('TaskTbl.id , TaskTbl.title , TaskTbl.comment , Situations.statusId ,Situations.status, Users.name , Roles.role, 
        Prioritys.priorityId , Prioritys.priority , 
        endDtm , TaskTbl.createdDtm , employee_id');
        $this->db->from('tbl_task as TaskTbl');
        $this->db->join('tbl_users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('tbl_roles as Roles','Roles.roleId = Users.roleId');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = TaskTbl.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = TaskTbl.priorityId');
        $this->db->order_by('TaskTbl.statusId ASC, TaskTbl.priorityId');
        $this->db->where('TaskTbl.statusId', 1);
        if($group != '')
            $this->db->where('group_id', $group);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get stars of user
     */
    function getUserStars($user_id)
    {
        $this->db->select('id , title , description , date');
        $this->db->from('bonus');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get task prioritys
     */
    function getTasksPrioritys()
    {
        $this->db->select('*');
        $this->db->from('tbl_tasks_prioritys');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get task situations
     */
    function getTasksSituations()
    {
        $this->db->select('*');
        $this->db->from('tbl_tasks_situations');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get task Images
     */
    function getTasksImages($taskId)
    {
        $this->db->select('*');
        $this->db->from('task_files');
        $this->db->where('task_id', $taskId);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get task Links
     */
    function getTasksLinks($taskId)
    {
        $this->db->select('*');
        $this->db->from('links');
        $this->db->where('task_id', $taskId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to add a new task
     */
    function addNewTasks($taskInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_task', $taskInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }


    /**
     * This function is used to add link of task
     */
    function addTaskLinks($taskLink)
    {
        $this->db->trans_start();
        $this->db->insert('links', $taskLink);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to add files of task
     */
    function addTaskFiles($taskFile)
    {
        $this->db->trans_start();
        $this->db->insert('task_files', $taskFile);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function used to get task information by id
     * @param number $taskId : This is task id
     * @return array $result : This is task information
     */
    function getTaskInfo($taskId)
    {
        $this->db->select('tbl_task.id , title , comment , users.name as createdBy, tbl_task.createdDtm ,
             endDtm , tbl_task.employee_id , groups.name as groupName , finish_detail , Situations.status , Prioritys.priority
        ');
        $this->db->from('tbl_task');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = tbl_task.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = tbl_task.priorityId');
        $this->db->join('tbl_users as users','users.userId = tbl_task.createdBy');
        $this->db->join('groups','groups.id = tbl_task.group_id');
        $this->db->where('tbl_task.id', $taskId);
        $query = $this->db->get();
        
        // var_dump($query->result());die();
        return $query->result();
    }

    /**
     * This function used to get task information by id
     * @param number $taskId : This is task id
     * @return array $result : This is task information
     */
    function getTaskInfoEdit($taskId)
    {
        $this->db->select('*');
        $this->db->from('tbl_task');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = tbl_task.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = tbl_task.priorityId');
        $this->db->where('id', $taskId);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function used to get bonus information by id
     * @param number $bonusId : This is bonus id
     * @return array $result : This is task information
     */
    function getBonusInfo($bonusId)
    {
        $this->db->select('*');
        $this->db->from('bonus');
        $this->db->where('id', $bonusId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to edit tasks
     */
    function editTask($taskInfo, $taskId)
    {
        $this->db->where('id', $taskId);
        $this->db->update('tbl_task', $taskInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to edit link
     */
    function updateLink($Link, $linkId)
    {
        $this->db->where('id', $linkId);
        $this->db->update('links', $Link);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to delete link
     */
    function deleteLink($linkId)
    {
        $this->db->where('id', $linkId);
        $this->db->delete('links');
        return TRUE;        
    }

    /**
     * This function is used to delete all links
     */
    function deleteAllLink($taskId)
    {
        $this->db->where('task_id', $taskId);
        $this->db->delete('links');
        return TRUE;
    }
    
    /**
     * This function is used to delete tasks
     */
    function delete_file($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('task_files');
        return TRUE;
    }

    /**
     * This function is used to delete tasks
     */
    function deleteTask($taskId)
    {
        $this->db->where('id', $taskId);
        $this->db->delete('tbl_task');

        // Delete All llinks and Images of this task
        return TRUE;
    }

    /**
     * This function is used to confirm tasks
     */
    function confirmTask($taskId , $data)
    {
        $this->db->where('id', $taskId);
        $this->db->update('tbl_task', $data);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to return the size of the table
     * @param string $tablename : This is table name
     * @param string $dbname : This is database name
     * @return array $return : Table size in mb
     */
    function gettablemb($tablename,$dbname)
    {
        $this->db->select('round(((data_length + index_length)/1024/1024),2) as total_size');
        $this->db->from('information_schema.tables');
        $this->db->where('table_name', $tablename);
        $this->db->where('table_schema', $dbname);
        $query = $this->db->get($tablename);
        
        return $query->row();
    }

    /**
     * This function is used to delete tbl_log table records
     */
    function clearlogtbl()
    {
        $this->db->truncate('tbl_log');
        return TRUE;
    }

    /**
     * This function is used to delete tbl_log_backup table records
     */
    function clearlogBackuptbl()
    {
        $this->db->truncate('tbl_log_backup');
        return TRUE;
    }

    /**
     * This function is used to get user log history
     * @return array $result : This is result
     */
    function logHistoryBackup()
    {
        $this->db->select('*');        
        $this->db->from('tbl_log_backup as BaseTbl');
        $this->db->group_by('userId , userName , day(createdDtm)');
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to complete tasks
     */
    function endTask($taskId, $taskInfo)
    {
        $this->db->where('id', $taskId);
        $this->db->update('tbl_task', $taskInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to get the tasks count
     * @return array $result : This is result
     */
    function tasksCount($userId = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');
        if($userId != '')
            $this->db->where('employee_id', $userId);
        $this->db->where('BaseTbl.statusId', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }


    /**
     * This function is used to get the tasks count
     * @return array $result : This is result
     */
    function BendingTasksCount($userId = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');        
        $this->db->where('BaseTbl.statusId', 3);
        if($userId != '')
            $this->db->where('createdBy', $userId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the tasks count
     * @return array $result : This is result
     */
    function ClientTasksCount($userId = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');        
        if($userId != '')
            $this->db->where('createdBy', $userId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the tasks count
     * @return array $result : This is result
     */
    function myAllTasksCount($userId = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');
        if($userId != '')
            $this->db->where('employee_id', $userId);        
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the tasks count
     * @return array $result : This is result
     */
    function AllTasksCount($userId = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the finished tasks count
     * @return array $result : This is result
     */
    function finishedTasksCount($userId = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');
        $this->db->where('BaseTbl.statusId', 2);
        if($userId != ''){
            $this->db->where('employee_id', $userId);
            $this->db->or_where('finished_by', $userId);
        }        
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the tasks count
     * @return array $result : This is result
     */
    function groupTaskCount($group_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');        
        $this->db->where('group_id', $group_id);
        $this->db->where('BaseTbl.statusId', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the logs count
     * @return array $result : This is result
     */
    function logsCount($userId = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_log as BaseTbl');
        if($userId != '')
            $this->db->where('userId', $userId);
        $this->db->group_by('userId , userName , day(createdDtm)');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the stars of user
     * @return array $result : This is result
     */
    function userStars($userId = '')
    {
        $this->db->select('*');
        $this->db->from('bonus');
        if($userId != '')
            $this->db->where('user_id', $userId);
        $now = new \DateTime('now');
		$month = $now->format('m');		
        $this->db->where('month(bonus.date)', $month);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the users count
     * @return array $result : This is result
     */
    function usersCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the connected users count
     * @return array $result : This is result
     */
    function connectedUsersCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->where('isDeleted', 0);
        $this->db->where('is_logged', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getUserStatus($userId)
    {
        $this->db->select('BaseTbl.status');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->limit(1);
        $query = $this->db->get('tbl_users as BaseTbl');

        return $query->row();
    }    
    
    public function get_users(){
		$this->db->select('*');		
		$this->db->from('tbl_users');		
        $this->db->where('roleId', 3);		
		$query = $this->db->get();
		return $query->result();
    }
    
    public function connectedUsers(){
        $this->db->select('userId , name , role , picture , last_login');
        $this->db->from('tbl_users');
        $this->db->join('tbl_roles as Roles','Roles.roleId = tbl_users.roleId');		
        $this->db->where('is_logged', 1);
		$query = $this->db->get();
		return $query->result();
    }
    
    /**
     * This function is used to get tasks
     */
    function getLatestTasks($userId = '')
    {
        $this->db->select('TaskTbl.id , TaskTbl.title , TaskTbl.comment , Situations.statusId ,Situations.status, Users.name , Roles.role, 
        Prioritys.priorityId , Prioritys.priority , endDtm , TaskTbl.createdDtm , employee_id , Users.picture ');
        $this->db->from('tbl_task as TaskTbl');
        $this->db->join('tbl_users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('tbl_roles as Roles','Roles.roleId = Users.roleId');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = TaskTbl.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = TaskTbl.priorityId');
        $this->db->order_by('TaskTbl.statusId ASC, TaskTbl.priorityId');
        $this->db->where('TaskTbl.statusId', 1);
        if($userId != '')
            $this->db->where('employee_id', $userId);
        $this->db->limit(4);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get Browse data      
     * @return array $result : This is result
     */
    function get_browse_data()
    {
        $this->db->select('userAgent , COUNT(userAgent) as count');
        $this->db->from('tbl_log as BaseTbl');
        $this->db->group_by('userAgent');        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
}

  