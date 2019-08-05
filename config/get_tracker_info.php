<?php
    header('Content-Type: application/json');

    $response = array();

    if( !isset($_POST['functionname']) ) { $response['error'] = 'No function name!'; }

    if( !isset($_POST['arguments']) ) { $response['error'] = 'No function arguments!'; }

    if( !isset($response['error']) ) {

        switch($_POST['functionname']) {
            case 'gettrackinfo':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $response['error'] = 'Error in arguments!';
               }
               else {

                $url = 'http://202.52.240.149:82/BarcodeApp/grabapi.php?type=login';

          
                $postData = array();
                $postData['username'] =rawurlencode($_POST['arguments'][0]);
                $postData['password'] =rawurlencode($_POST['arguments'][1]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                $result = curl_exec($ch);
                curl_close($ch);
                    
                    //$json = json_decode($result, true);

                    //return $result;

                   $response['result'] = json_decode($result);
               }
               break;

            default:
               $response['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }

    echo json_encode($response);

?>