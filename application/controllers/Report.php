<?php defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Report extends CI_Controller {

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
		$this->load->view('vReport');
    }

    private function _employees() {
		$rs = $this->Home_Model->getEmployees('');
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$data[] = (object) array(
					'id' => (int)$row->UserID,
					'desc' => ucwords(strtolower($row->EmployeeName))
				);
			}
		}

		return $data;
    }
    
    private function _listStatus() {
		$rs = $this->Home_Model->listStatus();
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$data[] = (object) array(
					'id' => (int)$row->TaskStatusID,
					'desc' => $row->Description
				);
			}
		}

		return $data;
    }
    
    private function _listCategory() {
		$rs = $this->Home_Model->getCategory();
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$data[] = (object) array(
					'id' => (int)$row->CategoryID,
					'desc' => $row->Description
				);
			}
		}

		return $data;
	}

    public function getList() {
        $data = array(
            'status' => $this->_listStatus(),
            'assignee' => $this->_employees(),
            'category' => $this->_listCategory()
        );

        echo json_encode($data);
    }
    
} // end class