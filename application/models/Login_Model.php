<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);

class Login_Model extends CI_Model {

	public function getUserInfo( $user )
    {
		$qry = $this->db->where('SparkAccount',$user)
						->get('vwUser');
		return $qry->num_rows() > 0 ? $qry : FALSE;
    }

}