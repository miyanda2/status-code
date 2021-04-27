<?php

    require_once './functions.php';

    //print_r($_POST); exit;

	if(isset($_POST)){
		$email = cleanInput($_POST['email']);
        $url = cleanInput($_POST['url']);
        $status = cleanInput($_POST['status']);
        $frequency = cleanInput($_POST['frequency']);

        if( strlen($email) < 3 || strlen($url) < 5 || $status == '-1' || $frequency == '-1')
        {
            $err = 'Please fill in all fields';
        }else{

            $sessionHandler = new HmsSessionHandler();
            $useremail = $sessionHandler->getSessionData('adusername');
            $user = getUserInfo($useremail);

            if ($user != false) { 
                $response = saveConfig($user->id, $email, $url, $status, $frequency);

                if($response == 'success'){
                    $msg = 'You have scheduled a frequency check for <b>'.$url.'</b> at an interval of '.$frequency.' Minutes.';
                    sendMail($msg, $useremail, 'Notification');
                    $err = 'success';
                }else{
                    $err = 'ERROR! Unable to complete request. Try again.';
                }
            }else{
                $err = 'ERROR! Access Denied.';
            }            
        }

        echo $err;
	}else{
        echo 'Unauthorized Request. Process Terminated';
	}

?>