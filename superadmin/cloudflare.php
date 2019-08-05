<?php 
function addCloudflareEntry($aname){

	$name = $aname;

    /* Cloudflare.com | APİv4  */
    $apikey = '3eb2a2a90afde2dcbae2977e55cdbe36cbf1a'; // Cloudflare Global API
    $email = 'krishnagek@gmail.com'; // Cloudflare Email Adress
    $domain = 'a1pathshala.com';  // zone_name // Cloudflare Domain Name
    $zoneid = 'a93d82e0fca5e34a8b36bb7d4b66cfc8'; // zone_id // Cloudflare Domain Zone ID
    $content = '18.191.94.62';

		$ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zoneid."/dns_records");

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'X-Auth-Email: '.$email.'',
		'X-Auth-Key: '.$apikey.'',
		'Cache-Control: no-cache',
	    // 'Content-Type: multipart/form-data; charset=utf-8',
	    'Content-Type:application/json',
		'purge_everything: true'
		
		));

		// -d curl parametresi.
    		$data = array(
    		
    			'type' => 'A',
    			'name' => ''.$name.'',
    			'content' => ''.$content.'',
    			'zone_name' => ''.$domain.'',
    			'zone_id' => ''.$zoneid.'',
    			'proxiable' => true,
    			'proxied' => true,
    			"priority"=>0,
    			'ttl' => 1
    		);
		
		$data_string = json_encode($data);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);	

		$sonuc = curl_exec($ch);		


		$key = 'success';
		$key1 = 'errors';
		$key2= 'message';

		$sonc1 = json_decode($sonuc);
		if ($sonc1->$key) {
			return 'Successfully created entry in cloudflare';
		}else{
			return $sonc1->$key1[0]->$key2;
		}

		curl_close($ch);

}

?>