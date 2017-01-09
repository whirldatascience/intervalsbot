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
		
		$content = '
            {
              "title":"Classic White T-Shirt",
              "image_url":"http://petersapparel.parseapp.com/img/item100-thumb.png",
              "subtitle":"Soft white cotton t-shirt is back in style",
              "buttons":[
                {
                  "type":"web_url",
                  "url":"https://petersapparel.parseapp.com/view_item?item_id=100",
                  "title":"View Item"
                },
                {
                  "type":"web_url",
                  "url":"https://petersapparel.parseapp.com/buy_item?item_id=100",
                  "title":"Buy Item"
                }
              ]
            },
            {
              "title":"Classic Grey T-Shirt",
              "image_url":"http://petersapparel.parseapp.com/img/item101-thumb.png",
              "subtitle":"Soft gray cotton t-shirt is back in style",
              "buttons":[
                {
                  "type":"web_url",
                  "url":"https://petersapparel.parseapp.com/view_item?item_id=101",
                  "title":"View Item"
                },
                {
                  "type":"web_url",
                  "url":"https://petersapparel.parseapp.com/buy_item?item_id=101",
                  "title":"Buy Item"
                }
              ]
            },
          ';
		
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