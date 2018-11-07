<?php defined('BASEPATH') OR exit('No direct script access allowed');

function is_survey_done( $systemID,$username )
{
	$CI =& get_instance();
	$CI->load->model('Survey_Model');
	return $CI->Survey_Model->isSurveyDone( $systemID,$username );
}

function get_system_name( $systemID )
{
	$CI =& get_instance();
	$CI->load->model('Survey_Model');
	return strtoupper( $CI->Survey_Model->getSurveyCount( $systemID )->row()->SystemName );
}

function is_logged_in( $sess_name )
{
	$CI =& get_instance();
	return $CI->session->userdata( $sess_name ) ? TRUE : FALSE;
}

function session_data( $sess_name )
{
	$CI =& get_instance();
	return $CI->session->userdata( $sess_name );
}

function build_session( $sess_name,$user_session = [] )
{
	$CI =& get_instance();
	$CI->session->set_userdata( $sess_name,$user_session );
}