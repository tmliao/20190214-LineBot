<?php
	$json_str = file_get_contents('php://input'); //接收request的body
	$json_obj = json_decode($json_str); //轉成json格式
  
	$myfile = fopen("log.txt", "w+") or die("Unable to open file!"); //設定一個log.txt來印訊息
	fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  
	$sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
	$sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
	$sender_replyToken = $json_obj->events[0]->replyToken; //取得訊息的replyToken
  
	$response = array (
		"replyToken" => $sender_replyToken,
		"messages" => array (
			array (
				"type" => "template",
				"altText" => "this is a buttons template",
				"template" => array (
					"type" => "buttons",
					"thumbnailImageUrl" => "https://www.w3schools.com/css/paris.jpg",
					"title" => "Menu",
					"text" => "Please select",
					"actions" => array (
						array (
							"type" => "postback",
							"label" => "Buy",
							"data" => "action=buy&itemid=123"
						),
						array (
							"type" => "message",
							"label" => "Return",
							"text" => "This is text"
						),
						array (
							"type" => "datetimepicker",
							"label" => "Select date",
							"data" => "storeId=12345",
							"mode" => "datetime",
							"initial" => "2017-12-25t00:00",
							"max" => "2018-01-24t23:59",
							"min" => "2017-12-25t00:00"
						)
					)
				)
	  		)
		)
  	);
			
  	//fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  	$header[] = "Content-Type: application/json";
  	$header[] = "Authorization: Bearer RinZuAxd/Mro8TiOyUHjyL6SVy0NhwLQk6h+NKz4WojC2gIIx0Nzcp0waryjPR58967RkawdWLtjSOyGKbF/SGk0A/ZJGxo6VSkeHqzWByPZF0Uo8w6Cw7u0R7AG4tvD5MAxgcbqVf3SHk9YxRvHwwdB04t89/1O/w1cDnyilFU=";
  	$ch = curl_init("https://api.line.me/v2/bot/message/reply");
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
  	$result = curl_exec($ch);
  	curl_close($ch);
?>
