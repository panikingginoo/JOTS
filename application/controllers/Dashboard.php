<?php defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Dashboard extends CI_Controller {

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

		if( (int)$this->user->UserLevelID === 3 ) {
			if( $current_status === 3 ) {
				$data['breakInfo'] = $this->breakInfo;
				$this->load->view('vBreakOut',$data);
			} else {
				$data['current_status'] = $current_status;
				$this->load->view('vDashboard',$data);
			}
		} else { redirect('Home'); }
	}

	public function getEmployeesStatus() {
		$search = $this->input->post('search');
		$search = isset($search) ? $search : '';
		$rs = $this->Home_Model->getEmployees( $search );
		$data = [];

		if( $rs !== FALSE ) {
			foreach ($rs->result() as $row) {
				$task_desc = $this->Home_Model->currentWIP( $row->UserID );
				$task_desc = $task_desc[0] === TRUE && $task_desc[1]->num_rows() > 0 ? $task_desc[1]->row()->TaskDescription : '';

				$data[] = array(
		            'avatar' => base_url('img/avatars/female.png'),
		            'fn' => strtoupper($row->EmployeeName),
		            'status' => array(
		                'id' => $row->MyStatusID,
		                'desc' => $row->Status 
		            ),
		            'task_desc' => $task_desc
		        );
			}
		}

		echo json_encode($data);
	}

} // end of class