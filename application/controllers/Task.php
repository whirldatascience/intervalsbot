<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Task extends CI_Controller {
	public function getTasks($userKey, $password) {
		$uri = INTERVALS_API . '/task/';
		$curl = curl_init ();
		curl_setopt_array ( $curl, array (
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => $uri,
				CURLOPT_USERAGENT => "Whirlian's API request" 
		) );
		curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
				"Authorization: Basic " . base64_encode ( "$userKey:$password" ) 
		) );
		$resp = curl_exec ( $curl );
		
		curl_close ( $curl );
		$taskObj = json_decode ( $resp );
		$taskCount = count ( $taskObj->task );
		
		$responseObj = array (
				'messages' => array (
						'text' => 'Total count: ' . $taskCount 
				) 
		);
		
		echo json_encode ( $responseObj );
		
		/*
		 * {
		 * "messages": [
		 * {"text": "Welcome to our store!"},
		 * {"text": "How can I help you?"}
		 * ]
		 * }
		 */
		// print_r ( $taskObj );
	}
}