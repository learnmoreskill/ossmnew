<?php 
if($_SERVER['REQUEST_METHOD']=='POST') {
	if (isset($_POST['nameofschool'])) {

        $nameofschool=$_POST['nameofschool'];
        $address=$_POST['address'];
        $name=$_POST['name'];
        $contact=$_POST['contact'];
        $email=$_POST['email'];

        if(!empty($nameofschool)){
        	if(!empty($address)){
        		if(!empty($name)){
        			if(!empty($contact)){

                        $url = 'https://krishnagek.000webhostapp.com/mail/index1.php';
                        $postData = array();
                        $postData['my_token'] = 'send4111@hackster';
                        $postData['from'] = 'tuntunkhtri@gmail.com';
                        $postData['to'] ='krishnagek@gmail.com';
                        $postData['text'] ='<h3>Name of School : '.$nameofschool.'</h3><p> Address : '.$address.'<br> Name : '.$name.'<br> Contact : '.$contact.'<br> Email : '.$email.'</p>';
                        $postData['subject'] ='Register new school';
                        $postData['headers'] ='From School Page';

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                        $result = curl_exec($ch);
                        curl_close($ch);

        				$msg="Thank you, we will contact you soon";

        	}else{ $msg="Please enter your mobile number";  }
            }else{ $msg="Please type your name";  }
            }else{ $msg="Please enter school address";  }
            }else{ $msg="Please enter school name";  }
            
  //$_SESSION['result_success']=$msg;
  echo $msg;
    }
}