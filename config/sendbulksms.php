<?php
function sendbulk($token,$numbers, $messages) {

	if (!empty($token) && !empty($numbers) && !empty($messages)) {

	        $url = 'http://aakashsms.com/admin/public/sms/v1/send';
	        $postData = array();
			$postData['auth_token'] = $token;
			$postData['from'] = '31001';
			$postData['to'] =$numbers;
			$postData['text'] =$messages;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
			$result = curl_exec($ch);
			curl_close($ch);
	        
	        $json = json_decode($result, true);

	        if($json['response_code']==201){
	        $response = "message sent successfully";
	        return $response;
	        }else{
	        $response = $json['response'];
	        return $response;
	        }
    } else {
   		$response="required fields are missing";
      return $response;

   	}
}


// for sms credit and send sms count
function bulksmsdetails($token) {
	       
	        $url = 'http://aakashsms.com/admin/public/sms/v1/credit';
	        $postData = array();
			$postData['auth_token'] = $token;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
			$result = curl_exec($ch);
			curl_close($ch);
	        
	        $json = json_decode($result, true);

	        return $json;
}

?>