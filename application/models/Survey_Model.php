<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);

class Survey_Model extends CI_Model {

	public function getSurveyCount( $systemID )
    {
    	//echo $systemID;
    	$sql = "SELECT SystemName, SurveyCount FROM [tbl.MasterSystem] WHERE ID = ?";
        $qry =  $this->db->query( $sql,array( $systemID ) );

        return $qry->num_rows() > 0 ? $qry : FALSE;
    }

    public function isSurveyDone( $systemID,$username )
    {
    	$surveyCount = (int)$this->getSurveyCount( $systemID )->row()->SurveyCount;

    	$sql = "SELECT ID FROM [tbl.MasterSystemRate] WHERE SurveyCount = ? AND SystemID = ? AND Username = ?";
        $qry =  $this->db->query( $sql,array( $surveyCount,$systemID,"$username" ) );

        return $qry->num_rows() > 0 ? TRUE : FALSE;
    }

    public function takeSurvey( $systemID,$username,$rate,$feedBack,$createdBy )
    {
    	$surveyCount = (int)$this->getSurveyCount( $systemID )->row()->SurveyCount;

    	$sql = "INSERT INTO [tbl.MasterSystemRate] ( SurveyCount, SystemID, Username, Rate, Feedback, CreatedBy ) VALUES (?,?,?,?,?,?)";
    	$qry = $this->db->query( $sql, array($surveyCount,$systemID,"$username",$rate,"$feedBack","$createdBy"));

    	$start = strrpos( $this->db->error()['message'], "]") + 1;
        $error = substr( $this->db->error()['message'], $start );

        return $qry ? TRUE : $error;
    }

} //end of class