<?php defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Login extends CI_Controller {

	public function index()
	{
		if( is_logged_in( 'sess_name' ) )
		{
			redirect('Home');
		}
		else
		{
			$con = ldap_connect("192.168.1.244");
			ldap_set_option( $con, LDAP_OPT_PROTOCOL_VERSION, 3 );
			ldap_set_option( $con, LDAP_OPT_REFERRALS, 0 );

			$comp = $this->input->post('comp');
			$comp = isset($comp) ? $comp : FALSE;

			$user = $this->input->post('user');
			$pass = $this->input->post('pass');

			if( isset($user) )
			{
				if( $con )
				{
					$bind = ldap_bind($con,$user."@phoenix.net.ph",$pass);
					if( $bind )
					{
						$dn = "DC=phoenix,DC=net,DC=ph";
						$search =ldap_search($con, $dn, "samaccountname=$user");
						$data = ldap_get_entries($con, $search);
						
						$list_of_my_dept = [];
						for ($ii=0; $ii < $data[0]['memberof']['count']; $ii++)
						{
							//$dept = strpos(strtolower($data[0]['memberof'][$ii]), 'accounting') !== FALSE ? $data[0]['memberof'][$ii] : $data[0]['memberof'][0];
							!in_array($data[0]['memberof'][$ii], $list_of_my_dept) ? array_push($list_of_my_dept, $data[0]['memberof'][$ii]) : '';
						}

						$_SESSION['company'] = $comp;				
						$user_session = array(
										'is_auth' => TRUE,
					                    'ufullname'  => $data[0]["displayname"][0],
					                    'udept'     => $list_of_my_dept,
					                    'uusername'  => $data[0]["samaccountname"][0]
					                );
						
						build_session( 'sess_name', $user_session );
						if( is_logged_in( 'sess_name' ) )
						{
							unset( $_SESSION['error'] );
							redirect('Home');
						}
					}
					else { $_SESSION['error'] = "Invalid Account"; }
				}
				else { $_SESSION['error'] = "Unable to connect to the server."; }
			}
			
			$this->load->view('vLogin');
		} 
	}
}