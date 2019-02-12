<?php defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Home extends CI_Controller {

	protected $user;
	protected $breakInfo;
	protected $current_status;

	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Manila');
    	if( !is_logged_in('jots_sess') ) {
    		redirect('Login');
    	}
    	$this->user = session_data('jots_sess');
    	$this->load->model('Home_Model');

    	$this->breakInfo = $this->Home_Model->getBreakInfo();
    	$this->current_status = (int)$this->Home_Model->current_status();
	}

	public function index() {

		$current_status = $this->current_status;
		$data['userLevel'] = $this->user->UserLevelID;
		switch ( (int)$this->user->UserLevelID ) {
			case 2: // client
				if( $current_status !== 3 ) {
					$data['current_status'] = $current_status;
					$this->load->view('vHome',$data);
				} else {
					$data['breakInfo'] = $this->breakInfo;
					$this->load->view('vBreakOut',$data);
				}
				break;
			case 3: // supervisor
				if( $current_status !== 3 ) {
					$data['current_status'] = $current_status;
					$this->load->view('vSupervisor_Home',$data);
				} else {
					$data['breakInfo'] = $this->changeBreakStatus;
					$this->load->view('vBreakOut',$data);
				}
				// redirect('Dashboard');
				break;
			case 4: // manager
				$this->load->view('vHome');
				break;
			default: // employee
				if( $current_status !== 3 ) {
					$data['current_status'] = $current_status;
					$this->load->view('vHome',$data);
				} else {
					$data['breakInfo'] = $this->breakInfo;
					$this->load->view('vBreakOut',$data);
				}
				break;
		}
	}

	public function breakOut() {
		if( $this->current_status !== 3 ) {
			$breakOut = date('Y-m-d H:i:s');
			$rs = $this->Home_Model->changeBreakStatus( 0,'',$breakOut );
			if( $rs ) {
				// redirect('Home');
				echo 0;
			} else {
				echo 'ERROR: '.$rs;
			}
		} else { echo 'Unable to break in'; }
	}

	public function breakIn() {
		if( $this->current_status === 3 ) {
			$breakIn = date('Y-m-d H:i:s');
			$rs = $this->Home_Model->changeBreakStatus( $this->breakInfo->BreakLogID,$breakIn,$this->breakInfo->BreakOut );
			if( $rs ) {
				// redirect('Home');
				echo 0;
			} else {
				echo 'ERROR: '.$rs;
			}
		} else { echo 'Unable to break in'; }
	}

	private function _multiKeyExists(array $arr, $key) {
	    // is in base array?
	    // if (array_key_exists($key, $arr)) {
	    //     return true;
	    // }

	    // check arrays contained in this array
	    foreach ($arr as $element) {
	        if (is_array($element)) {
	            if ($this->_multiKeyExists($element, $key)) {
	                return true;
	            }
	        }
	        
	    }
	    return false;
	}

	public function test() {
		$rs = $this->Home_Model->getBreakInfo();
		echo '<pre>';
		print_r( $rs );
		echo $rs->row()->BreakOut;
	}
	public function getMyTask() {
		$rs = $this->Home_Model->getTaskHistory();
		$task['my_task'] = [];
		$task['current_wip'] = [];
		if( $rs !== FALSE ) {
			$c_wip = $this->Home_Model->currentWIP();

			foreach ($rs->result() as $row) {
				$TaskNo = $row->TaskNo;

				$attrs = $this->Home_Model->getMyTaskAttributes( $row->TaskHistoryID );
				$attrList = [];

				if( $attrs !== FALSE ) {
					foreach ($attrs->result() as $attr) {
						$attrList[] = array(
							'name' => $attr->Name,
							'desc' => $attr->Description,
							'val' => $attr->AttributeValue
						);
					}
				}

				$info['id'] = $row->TaskHistoryID;
				$info['TaskNo'] = $TaskNo;
				$info['Description'] = $row->TaskDescription;
				$info['TaskStatus'] = $row->TaskStatusID;
				$info['StartTime'] = $row->StartTime;
				$info['StopTime'] = $row->StopTime;
				$info['StartDate'] = is_null($row->StartTime) ? null : date('M d, Y',strtotime($row->StartTime));
				$info['DueDate'] = date('M d, Y',strtotime($row->DueDate));
				$info['EndTime'] = is_null($row->EndTime) ? null : date('M d, Y',strtotime($row->EndTime));
				$info['attributes'] = $attrList;
				$info['isRunning'] = (bool) $row->isRunning;
				$info['CategoryID'] = $row->CategoryID;
				$info['AssignedTo'] = (int)$row->AssignedTo;
				$info['AssignedBy'] = (int)$row->AssignedBy;
				$info['SubmittedBy'] = (int)$row->TaskStatusID > 2 ? strtoupper($row->AssignedToName) : null;
				$info['SubmittedTime'] = is_null($row->SubmittedTime) || $row->SubmittedTime == '' ? null : date('F d, Y - h:i A',strtotime($row->SubmittedTime));

				if( $c_wip[0] === TRUE && $c_wip[1]->num_rows() > 0 && ( (int)$row->TaskHistoryID === (int)$c_wip[1]->row()->TaskHistoryID ) ) {
					$task['current_wip'][] = $info;
				}

				$task['my_task'][] = $info;
			}
		}

		// echo '<pre>';
		// print_r( $task );
		echo json_encode( $task );
		// $this->db->cache_off();
	}

	public function getMyTaskAttributes() {
		$TaskHistoryID = $this->input->post('TaskHistoryID');
		$rs = $this->Home_Model->getMyTaskAttributes( $TaskHistoryID );
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$data[] = array(
					'label' => $row->Name,
					'val' => strtoupper( $row->AttributeValue )
				);
			}
			
			// IF TASK IS ASSIGNED BY SUPERVISOR
			if( (int)$rs->row()->AssignedBy !== (int)$rs->row()->AssignedTo ) {
				$data[] = array(
					'label' => 'ASSIGNED BY',
					'val' => strtoupper($rs->row()->AssignedByName)
				);
			}
		}
		

		// $data['assignedBy'] 

		echo json_encode( $data );
	}

	public function getMyStatus() {
		$rs = $this->Home_Model->getMyStatus();
		echo json_encode( $rs !== FALSE ? array((int)$rs->MyStatusID,$rs->Status) : [] );
	}

	public function getMyActivity() {
		$rs = $this->Home_Model->getMyActivity();
		$logs = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$d = date('m/d/Y',strtotime($row->StartTime));
				$t = date('h:i:s A',strtotime($row->StartTime));

				$obj = (object) array(
					'task' => $row->TaskDescription,
					'dt' => (object) array('d'=>$d,'t'=>$t)
				);

				$logs[] = $obj;
			}
		}

		echo json_encode( $logs );
	}

	/*public function getTasksListByCategory() {
		$rs = $this->Home_Model->getCategory();
		$category = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$cat['id'] = $row->CategoryID;
				$cat['desc'] = $row->Description;

				$list['cat'] = (object) $cat;

				$types = $this->Home_Model->getCategoryAttributes( $row->CategoryID );
				$list['type'] = [];

				if( $types !== FALSE ) {
					foreach ($types->result() as $row2) {
						$list['type'][] = $row2->TaskDescription;
					}
				}

				$category[] = (object) $list;
			}
		}
	}*/

	public function getTaskAttributes( $taskID = null ) {
		$data = [];
		$data['task_type'] = $this->_tasksType();

		$taskID = isset($taskID) ? $taskID : (int)$this->_tasksType()[0]->id;
		$rs = $this->Home_Model->getTaskAttributes( $taskID );
		
		if( $rs !== FALSE ) {
			$data['attr'] = $rs->result();
		}
		if( (int)$this->user->SupervisorID === 0 ) {
			
			$data['employee'] = $this->_employees();
			array_unshift( $data['employee'], (object) array(
				'id' => $this->user->UserID,
				'desc' => ucwords(strtolower($this->user->EmployeeName))
			) );
		}

		echo json_encode( $data );
	}

	private function _tasksType() {
		$rs = $this->Home_Model->getTaskTypeList();
		$list = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$list[] = (object) array(
					'id' => $row->TaskID,
					'code' => $row->TaskCode,
					'desc' => $row->TaskDescription
				);
			}
		}
		return $list;
	}

	public function startTask() {

		$id = (int)$this->input->post('id');
		$startTime = date('Y-m-d H:i:s');

		if( $id > 0 ) {
			$rs = $this->Home_Model->startTask( $id,$startTime );
			echo json_encode(array(
				'error' => $rs === TRUE ? 0 : $rs
			));
		}
	}

	private function _items( $comp ) {
		$rs = $this->Home_Model->getItems( $comp );
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$data[] = (object) array(
					'val' => $row->No_,
					'txt' => $row->No_
				);
			}
		}

		return $data;
	}

	private function _publisher() {
		// return $this->Home_Model->getItems();
		$rs = array(
			(object)array('Code' => 'PHOENIX','Name' => 'PHOENIX'),
			(object)array('Code' => 'SIBS','Name' => 'SIBS'),
			(object)array('Code' => 'PHOENIX DIGITAL MEDIA','Name' => 'PHOENIX DIGITAL MEDIA')
		);

		$data = [];
		if( $rs !== FALSE ) {
			foreach ($rs as $row) {
				$data[] = (object) array(
					'val' => $row->Code,
					'txt' => $row->Name
				);
			}
		}

		return $data;
	}

	private function _rdc( $comp ) {
		$rs = $this->Home_Model->getRDC( $comp );
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				if( $row->Code !== '' ) {
					$data[] = (object) array(
						'val' => $row->Code,
						'txt' => $row->Name
					);
				}
			}
		}

		return $data;
	}

	private function _lessons() {
		$rs = $this->Home_Model->getLessons();
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$data[] = (object) array(
					'val' => $row->Lesson,
					'txt' => $row->Lesson
				);
			}
		}

		return $data;
	}

	private function _units() {
		$rs = $this->Home_Model->getUnits();
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$data[] = (object) array(
					'val' => $row->Unit,
					'txt' => $row->Unit
				);
			}
		}

		return $data;
	}

	public function getList() {
		$comp = $this->input->post('comp');
		$name = strtolower( $this->input->post('name') );

		switch ( $name ) {
			case 'publisher':
				$data = $this->_publisher();
				break;
			case 'item':
				$data = $this->_items( $comp );
				break;
			case 'rdc code':
				$data = $this->_rdc( $comp );
				break;
			case 'lesson':
				$data = $this->_lessons();
				break;
			case 'unit':
				$data = $this->_units();
				break;
			default:
				$data = [];
				break;
		}

		echo json_encode( $data );
	}

	public function addTask() {
		$datas = $this->input->post('data');
		$assignedTo = $this->input->post('assignedTo');
		$assignedTo = isset($assignedTo) ? $assignedTo : (int)$this->user->UserID;
		$assignedBy = (int)$this->user->UserID;
		$userLevel = (int)$this->user->UserLevelID;
		$taskID = (int)$this->input->post('taskid');

		$dueDate = date('Y-m-d',strtotime($this->input->post('dueDate')));

		$taskAttributeID = [];
		$attributeValue = [];

		foreach ($datas as $data) {
			$data = (object) $data;
			$taskAttributeID[] = (int)$data->id;
			$attributeValue[] = trim($data->val);
		}

		$rs = $this->Home_Model->addTask( $assignedTo,$assignedBy,$userLevel,$taskID,implode(',', $taskAttributeID),implode(',', $attributeValue),$dueDate );
		echo $rs === TRUE ? 0 : 'ERROR: '.$rs;

	}

	public function deleteTask() {
		$taskHistoryID = (int)$this->input->post('id');
		if( $taskHistoryID > 0 ) {
			$rs = $this->Home_Model->deleteTask( $taskHistoryID );
			echo $rs === TRUE ? 0 : 'ERROR: '.$rs;
		} else {
			echo 'ERROR: No record found';
		}
	}

	public function stopTask() {
		$taskHistoryID = (int)$this->input->post('id');
		$stopTime = date('Y-m-d H:i:s');
		if( $taskHistoryID > 0 ) {
			$rs = $this->Home_Model->stopTask( $taskHistoryID,$stopTime );
			echo $rs === TRUE ? 0 : 'ERROR: '.$rs;
		} else {
			echo 'ERROR: No record found';
		}
	}

	public function submitTask() {
		$taskHistoryID = (int)$this->input->post('id');
		$submitTime = date('Y-m-d H:i:s');
		if( $taskHistoryID > 0 ) {
			$rs = $this->Home_Model->submitTask( $taskHistoryID,$submitTime );
			echo $rs === TRUE ? 0 : 'ERROR: '.$rs;
		} else {
			echo 'ERROR: No record found';
		}
	}

	public function _employees() {
		$rs = $this->Home_Model->getEmployees('');
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$data[] = (object) array(
					'id' => $row->UserID,
					'desc' => ucwords(strtolower($row->EmployeeName))
				);
			}
		}

		return $data;
	}

	public function doneTask() {
		$taskHistoryID = (int)$this->input->post('id');
		$endTime = date('Y-m-d H:i:s');
		if( $taskHistoryID > 0 ) {
			$rs = $this->Home_Model->doneTask( $taskHistoryID,$endTime );
			echo $rs === TRUE ? 0 : 'ERROR: '.$rs;
		} else {
			echo 'ERROR: No record found';
		}
	}
	
	public function returnTask() {
		$taskHistoryID = (int)$this->input->post('id');
		$remarks = trim($this->input->post('remarks'));
		$returnDate = date('Y-m-d H:i:s');

		if( $taskHistoryID > 0 ) {
			$rs = $this->Home_Model->returnTask( $taskHistoryID,$remarks,$returnDate );
			echo $rs === TRUE ? 0 : 'ERROR: '.$rs;
		} else {
			echo 'ERROR: No record found';
		}
	}

} // end of class