<?php

    require_once './functions.php';

    //print_r($_POST); exit;

    if(isset($_POST)){
        $name = cleanInput($_POST['name']);
        $email = cleanInput($_POST['email']);
        $password = cleanInput($_POST['pwd']);
        $cpassword = cleanInput($_POST['cpwd']);

        if( strlen($name) < 3 || strlen($email) < 3 || strlen($password) < 5)
        {
            $err = 'Please fill in all fields';
        }else{
            if($password == $cpassword){
                $response = createUser($name, $email, $password);
                if($response){
                    $err = 'success';
                }else{
                    $err = 'ERROR! Unable to complete request.';
                }   
            }else{
                $err = 'Password do not match';
            }                     
        }
        echo $err;
    }else{
        echo 'Unauthorized Request. Process Terminated';
    }

?>
