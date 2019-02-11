<?php defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class SuperVisor extends CI_Controller {

	protected $user;

	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Manila');
    	if( !is_logged_in('jots_sess') ) {
    		redirect('Login');
    	}
    	$this->user = session_data('jots_sess');
    	$this->load->model('Home_Model');
	}

	public function index() {
		echo 'Batman';
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

				if( $c_wip[0] !== FALSE && ((int)$row->TaskHistoryID === (int)$c_wip[1]->row()->TaskHistoryID) ) {
					$task['current_wip'] = $info;
				}

				$task['my_task'][] = $info;
			}
		}

		// echo '<pre>';
		// print_r( $task );
		echo json_encode( $task );
		// $this->db->cache_off();
	}

	public function getMyActivity() {
		$rs = $this->Home_Model->getMyActivity();
		$logs = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$d = date('m/d/Y',strtotime($row->StartTime));
				$t = date('h:i:s A',strtotime($row->StartTime));

				$obj = (object) array(
					'task' => $row->TaskNo,
					'dt' => (object) array('d'=>$d,'t'=>$t)
				);

				$logs[] = $obj;
			}
		}

		echo json_encode( $logs );
	}

	public function getTaskAttributes( $taskID = null ) {
		$data = [];
		$data['task_type'] = $this->_tasksType();

		$taskID = isset($taskID) ? $taskID : (int)$this->_tasksType()[0]->id;
		$rs = $this->Home_Model->getTaskAttributes( $taskID );
		
		if( $rs !== FALSE ) {
			$data['attr'] = $rs->result();
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
		$assignedTo = (int)$this->user->UserID;
		$assignedBy = (int)$this->user->UserID;
		$userLevel = (int)$this->user->UserLevelID;
		$taskID = (int)$this->input->post('taskid');

		$taskAttributeID = [];
		$attributeValue = [];

		foreach ($datas as $data) {
			$data = (object) $data;
			$taskAttributeID[] = (int)$data->id;
			$attributeValue[] = trim($data->val);
		}

		$rs = $this->Home_Model->addTask( $assignedTo,$assignedBy,$userLevel,$taskID,implode(',', $taskAttributeID),implode(',', $attributeValue) );
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

} // end of class