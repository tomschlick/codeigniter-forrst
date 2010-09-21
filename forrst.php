<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * CodeIgniter/PHP Forrst API Library (http://github.com/trs21219/codeigniter-forrst)
 * 
 * Author: Tom Schlick (http://www.tomschlick.com), tom@tomschlick.com
 *
 * ========================================================
 * REQUIRES: php5, curl, json_decode
 * ========================================================
 * 
 * VERSION: 1.0 (2010-09-20)
 * LICENSE: GNU GENERAL PUBLIC LICENSE - Version 2, June 1991
 * 
 **/
 
class Forrst 
{
	private $_url = 'http://api.forrst.com/api/v1/';
	
	private static $_curl_opts = array(
		CURLOPT_CONNECTTIMEOUT => 10,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_TIMEOUT        => 60,
		CURLOPT_USERAGENT      => 'codeigniter-forrst'
	);
	
	public function __construct()
	{
		
	}
	
	public function user_info($user = FALSE)
	{
		if(empty($user))
		{
			return FALSE;
		}
		
		if(is_numeric($user))
		{
			return $this->do_request('users/info', array('id' => $user));
		}
		else
		{
			return $this->do_request('users/info', array('username' => $user));
		}
	}
	
	public function user_posts($username = NULL, $since = NULL, $last_id = NULL)
	{
		if(empty($username))
		{
			return FALSE;
		}
		
		return $this->do_request('users/posts', array('username' => $username, 'since' => $since, 'last_id' => $last_id));
	}
	
	private function do_request($uri = NULL, $params)
	{
		$ch = curl_init();
		
		$opts = self::$_curl_opts;
		
		$param_string = '';
		if(!empty($params))
		{
			foreach($params as $key=>$row)
			{
				if(empty($row))
				{
					unset($params[$key]);
				}
			}
			
			$param_string = '?'.http_build_query($params, null, '&');
		}
		
		$opts[CURLOPT_URL] = $this->_url.$uri.$param_string;
		 
		curl_setopt_array($ch, $opts);
		
		$result = curl_exec($ch);
		
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if($status == '200')
		{
			return json_decode($result);
		}
		else
		{
			return array('error' => TRUE, 'message' => 'something unexpected happened!', 'status_code' => $status);
		}
	}
}
/* End of file forrst.php */
/* Location: ./application/libraries/forrst.php */