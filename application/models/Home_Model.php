<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);

class Home_Model extends CI_Model {

	protected $user;

	public function __construct() {
		parent::__construct();
		$this->user = session_data('jots_sess');
	}

	public function getTaskHistory()
    {
        $this->db->where('AssignedTo',$this->user->UserID);

        if( (int)$this->user->SupervisorID === 0 ) {
            $UserID = $this->user->UserID;
            $this->db->or_group_start()
                    ->where_in('AssignedTo',"SELECT UserID FROM [vwUser] WHERE SupervisorID = $UserID",false)
                    ->where('TaskStatusID',3)
                    ->group_end();

        }
        $this->db->order_by('TaskHistoryID','DESC');
        $qry = $this->db->get('vwTaskHistory');
        // echo $this->db->last_query();

		return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getMyTaskAttributes( $TaskHistoryID )
    {
		$qry = $this->db->where('TaskHistoryID',$TaskHistoryID)
						->get('vwTaskAttributeValue');
		return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getTaskAttributes( $taskID )
    {
		$qry = $this->db->select('TaskAttributeID,Name,Description,HTMLTypeID,isRequired,Class')
						->where('TaskID',$taskID)
						->get('vwTaskAttributeGroup');
		return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getMyActivity() {
    	$qry = $this->db->select('TaskDescription,StartTime')
    					->where('AssignedTo',$this->user->UserID)
    					->where('TaskStatusID',2) // WIP
    					->get('vwTaskHistory');
    	return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getCategory() {
    	$qry = $this->db->get('tblCategory');
    	return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getTaskTypeList() {
    	$qry = $this->db->where('DepartmentID',$this->user->DepartmentID)
    					->get('vwTaskGroup');
    	return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getCategoryAttributes( $cat_id )
    {
		$qry = $this->db->select('TaskID,TaskDescription')
						->where('CategoryID',$cat_id)
						->get('tblTask');
		return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function startTask( $taskHistoryID,$startTime ) {
    	$sql = "EXEC [spStartTask] @TaskHistoryID = ?, @StartTime = ?";
        $qry = $this->db->query($sql,array( $taskHistoryID,"$startTime" ));

        $start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? TRUE : $error;
    }

    public function getItems( $comp ) {
    	$db243 = $this->load->database('nav_replication',TRUE);
    	$qry = $db243->query("SELECT No_ FROM [$comp, Inc_\$Item]");

    	return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getRDC( $comp ) {
    	$db243 = $this->load->database('nav_replication',TRUE);
    	$qry = $db243->query("SELECT Code, Name FROM [$comp, Inc_\$Dimension Value]");

    	return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getLessons() {
    	$qry = $this->db->select('id,Lesson')->get('tblLesson');
    	return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function getUnits() {
    	$qry = $this->db->select('id,Unit')->get('tblListUnit');
    	return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function addTask( $assignedTo,$assignedBy,$userLevel,$taskID,$taskAttributeID,$attributeValue,$dueDate ) {
    	$sql = "EXEC [spInsertHistoryTask] @AssignedTo = ?, @AssignedBy = ?, @UserLevelID = ?, @TaskID = ?, @TaskAttributeID = ?, @AttributeValue = ?, @DueDate = ?";
    	$qry = $this->db->query($sql,array($assignedTo,$assignedBy,$userLevel,$taskID,"$taskAttributeID","$attributeValue","$dueDate"));

    	$start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? TRUE : $error;
    }

    public function deleteTask( $taskHistoryID ) {
    	$sql = "EXEC [spDeleteTask] @TaskHistoryID = ?";
    	$qry = $this->db->query($sql,array( $taskHistoryID ));

    	$start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? TRUE : $error;
    }

    public function stopTask( $taskHistoryID,$stopTime ) {
    	$sql = "EXEC [spStopTask] @TaskHistoryID = ?,@StopTime = ?";
        $qry = $this->db->query($sql,array( $taskHistoryID,"$stopTime" ));

    	$start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? TRUE : $error;
    }

    public function submitTask( $taskHistoryID,$submitTime ) {
    	$sql = "EXEC [spSubmitTask] @TaskHistoryID = ?, @SubmittedTime = ?";
        $qry = $this->db->query($sql,array( $taskHistoryID,"$submitTime" ));

        $start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? TRUE : $error;
    }

    public function getTaskList() {
        $qry = $this->db->get('tblTask');
        return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function currentWIP( $UserID = '' )
    {
        $UserID = $UserID != '' ? $UserID : $this->user->UserID;
        $sql = "EXEC [spCurrentTask] @UserID = ?";
        $qry = $this->db->query($sql,array($UserID));

        $start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? array(TRUE,$qry) : array(FALSE,$error);
    }

    public function getMyStatus() {
        $qry = $this->db->select('MyStatusID,Status')
                        ->where('UserID', $this->user->UserID)
                        ->get('vwUser');
        return $qry->num_rows() > 0 ? $qry->row() : FALSE;
    }

    public function current_status() {
        $qry = $this->db->select('MyStatusID')
                        ->where('UserID',$this->user->UserID)
                        ->get('tblUser');
        
        return $qry->num_rows() > 0 ? $qry->row()->MyStatusID : 1;
    }

    public function getBreakInfo() {
        $qry = $this->db->where('UserID',$this->user->UserID)
                        ->limit(1)
                        ->order_by('BreakLogID','desc')
                        ->get('tblBreakLogs');
        // echo $this->db->last_query();
        return $qry->num_rows() > 0 ? $qry->row() : FALSE;
    }

    public function changeBreakStatus( $breakLogID,$breakIn,$breakOut )
    {
        $UserID = $this->user->UserID;

        $sql = "EXEC [spBreakStatus] @UserID = ?, @BreakLogID = ?, @BreakIn = ?, @BreakOut = ?";
        $qry = $this->db->query($sql,array($UserID,$breakLogID,$breakIn,$breakOut));

        $start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? array(TRUE,$qry) : array(FALSE,$error);
    }

    public function getEmployees( $search ) {
        $this->db->where('SupervisorID',$this->user->UserID)
                ->order_by('MyStatusID', 'ASC');
        if( trim($search) != '' ) {
            $this->db->like('EmployeeName',$search);
        }
        $qry = $this->db->get('vwUser');
        // echo $this->db->last_query();

        return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function doneTask( $taskHistoryID,$endTime ) {
        $sql = "EXEC [spDoneTask] @TaskHistoryID = ?, @EndTime = ?";
        $qry = $this->db->query($sql,array( $taskHistoryID,"$endTime" ));

        $start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? TRUE : $error;
    }

    public function returnTask( $taskHistoryID,$remarks,$returnDate ) {
        $sql = "EXEC [spReturnTask] @TaskHistoryID = ?, @Remark = ?, @ReturnDate = ?, @CreatedBy = ?";
        $qry = $this->db->query($sql,array( $taskHistoryID,"$remarks","$returnDate",$this->user->UserID ));

        $start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? TRUE : $error;
    }

    public function getBackJobRemarks( $taskHistoryID ) {
        // $qry = $this->db->get_where()
    }

    public function listStatus() {
        $qry = $this->db->get('tblTaskStatus');
        return $qry->num_rows() > 0 ? $qry : FALSE;
    }

}