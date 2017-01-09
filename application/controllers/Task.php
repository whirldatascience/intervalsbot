<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Task extends CI_Controller {
	public function getTasks($userKey, $password, $limit) {
		$uri = INTERVALS_API . '/task/?limit=' . $limit;
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
		
		$responseObj = '{"messages":[
				{"text" : "Total Count' . $taskCount . '"}]}';
		$content = "";
		$i = 0;
		foreach ( $taskObj->task as $task ) {
			$summary = "-";
			if (isset ( $task->summary ) && $task->summary != null && $task->summary != "")
				$summary = $task->summary;
			if ($i > 0)
				$content = $content . ',';
			$content = $content . '
            {
              "title":"' . $task->title . '",
              "subtitle":"' . $summary . '"
            }';
			$i ++;
		}
		
		$responseObj = '{
 "messages": [
    {
      "attachment":{
        "type":"template",
        "payload":{
          "template_type":"generic",
          "elements":[' . $content . ']
        }
      }
    }
  ]
}';
		
		echo ($responseObj);
	}
}