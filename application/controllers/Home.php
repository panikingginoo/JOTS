<?php defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();

    	if( !is_logged_in('sess_name') ) {
    		redirect('Login');
    	}
	}

	public function index()
	{
		$data['param'] = '';
		$this->load->view('vHome',$data);
	}

} // end of class