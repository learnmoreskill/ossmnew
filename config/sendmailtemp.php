<?php

function sendemail($email1, $messages1) {

	if (!empty($email1) && !empty($messages1)) {
            
            $email= $email1;
            $comment =$messages1;
               
    //thank you mail to user
    $to = $email1;
    $subject = "Notice from School";
    $headers = "From: a1pathshala074@gmail.com\n";
    $message = $comment."\n
         From:\n
         A1Pathshala\n
         https://a1pathshala.com";
   
    
    
    if(mail($to,$subject,$message,$headers))
    {
        $response="msg sent successfully";
        return $response;
    }
    else
    {
        $response="msg not sent";
        return $response;
    }


    } else {
   		$response="required fields are missing";
        return $response;

   	}
}

?> 
