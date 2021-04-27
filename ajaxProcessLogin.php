<?php

    require_once './functions.php';

    //print_r($_POST); exit;

	if(isset($_POST)){
		$email = cleanInput($_POST['email']);
        $password = cleanInput($_POST['pwd']);

        if( strlen($email) < 3 || strlen($password) < 5)
        {
            $err = 'Please fill in all fields';
        }else{
            $response = isLoginValid($email, $password);
            if($response){
                $sessionHandler->createSession('isLoggedIn', 'Yes');
                $sessionHandler->createSession('adusername', $email);

                $err = 'success';
            }else{
                $err = 'Invalid Username / Password ';
            }            
        }
        echo $err;
	}else{
        echo 'Unauthorized Request. Process Terminated';
	}

?>