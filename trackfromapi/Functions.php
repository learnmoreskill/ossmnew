<?php
class Functions{
public function fetchData($tracker_username,$tracker_password) {

				$md5pw=md5("qFtAQwsz".$tracker_password);
				$url = 'http://202.52.240.149:82/BarcodeApp/grabapi.php?type=login';          
                $postData = array();
                $postData['username'] =$tracker_username;
                $postData['password'] =$md5pw;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                $result1 = curl_exec($ch);
                curl_close($ch);

$response["result"]="success";
$response["beingtracked"] = json_decode($result1);
return json_encode($response);

}

}

?>
