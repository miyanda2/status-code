<?php

	require_once("HmsSessionHandler.php");
	require_once 'phpmailer/class.phpmailer.php';
	
	$sessionHandler = new HmsSessionHandler();

	function getConnection()
	{
		// specify your own database credentials
		 
		$host = "127.0.0.1";
		$db_name = "miyanda";
		$username = "root";
		$password = "";


		try{
			$conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}catch(PDOException $exception){
			die("Connection error: " . $exception->getMessage());
			die("<h2> Server Error. Contact Administrator</h2>");
		}
	}

	//Sanitizes Inputs
	function cleanInput($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = addslashes($data);

		return $data;
	}

	function isLoginValid($username, $password)
	{
		$con = getConnection();

        try {
            $query = "SELECT * FROM tbluser WHERE email = '".$username."' AND password = '".$password."'";
            //return $query;
            $prepared_query = $con->prepare($query);
            $prepared_query->execute();
            $count = $prepared_query->rowCount();
            if($count > 0){
                return true;
            }else{
                return false;
                //return $count;
            }
        } catch (Exception $e) {
            return false;
            //return $e->getMessage();
        }
	}

	function isUserLoggedIn()
	{
		global $sessionHandler;

		if($sessionHandler->sessionExist('isLoggedIn')){
			return true;
		}else{
			return false;
		}
	}

	function isEmailRegistered($email)
	{
        $con = getConnection();

        try {
            $query = "SELECT * FROM tblusers WHERE email = '".$email."'";
            //return $query;
            $prepared_query = $con->prepare($query);
            $prepared_query->execute();
            $count = $prepared_query->rowCount();
            if($count > 0){
                return true;
            }else{
                return false;
                //return $count;
            }
        } catch (Exception $e) {
            return false;
            //return $e->getMessage();
        }
	}

	function getUserInfo($email)
    {
        $con = getConnection();

        try {
            $query = "SELECT * FROM tbluser WHERE email = '".$email."'";
            //return $query;
            $prepared_query = $con->prepare($query);
            $prepared_query->execute();
            $count = $prepared_query->rowCount();
            if($count > 0){
                $stmt = $prepared_query ->fetchObject();
                return $stmt;
            }else{
                return false;
                //return $count;
            }
        } catch (Exception $e) {
            return false;
            //return $e->getMessage();
        }
    }

    function getUserConfig($userid)
    {
        $con = getConnection();

        try {
            $query = "SELECT * FROM tblconfiguration WHERE userid = '".$userid."'";
            //return $query;
            $prepared_query = $con->prepare($query);
            $prepared_query->execute();
            $count = $prepared_query->rowCount();
            if($count > 0){
                $stmt = $prepared_query ->fetchObject();
                return $stmt;
            }else{
                return false;
                //return $count;
            }
        } catch (Exception $e) {
            return false;
            //return $e->getMessage();
        }
    }

    function saveConfig($userid, $email, $url, $status, $frequency)
    {
        $con = getConnection();

        date_default_timezone_set('Africa/Lagos'); // Set the Default Time Zone:
        $date = '';
        $d = new DateTime($date);
        $cdate = $d->format('Y-m-d h:i:s');

        $con->beginTransaction();


        try{

            $query1 = "INSERT INTO tblconfiguration (userid, email, url, status, frequency) 
                    VALUES (:userid, :email, :url, :status, :frequency)";
            $stmt1 = $con->prepare($query1);
            // prepare sql and bind parameters
            $stmt1->bindParam(':userid', $userid);
            $stmt1->bindParam(':email', $email);
            $stmt1->bindParam(':url', $url);
            $stmt1->bindParam(':status', $status);
            $stmt1->bindParam(':frequency', $frequency);
            
            $stmt1->execute();                 
            $stmt1->closeCursor();

            $con->commit();

            return true;

        } catch (Exception $e) {
            $con->rollBack();
            return false;
            //return $e->getMessage();
        }       
    }

    function createUser($name, $email, $password)
    {
        $con = getConnection();

        date_default_timezone_set('Africa/Lagos'); // Set the Default Time Zone:
        $date = '';
        $d = new DateTime($date);
        $cdate = $d->format('Y-m-d h:i:s');

        $con->beginTransaction();


        try{

            $query1 = "INSERT INTO tbluser (name, email, password) 
                    VALUES (:name, :email, :password)";
            $stmt1 = $con->prepare($query1);
            // prepare sql and bind parameters
            $stmt1->bindParam(':name', $name);
            $stmt1->bindParam(':email', $email);
            $stmt1->bindParam(':password', $password);
            
            $stmt1->execute();                 
            $stmt1->closeCursor();

            $con->commit();

            return true;

        } catch (Exception $e) {
            $con->rollBack();
            return false;
            //return $e->getMessage();
        }       
    }

    function redirectTo($url)
  	{
	    if(headers_sent()){
	      return "<script>window.location ='".$url."'</script>";
	    }
	    return header('LOCATION:' . $url);
  	}

  	function urlExists($url = NULL, $status = NULL)  
	{  
	    if($url == NULL) return false;  
	    $ch = curl_init($url);  
	    curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	    $data = curl_exec($ch);  
	    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
	    curl_close($ch);  
	    /*if($httpcode>=200 && $httpcode<300){  
	        return true;  
	    } else {  
	        return false;  
	    } */ 
	    if($httpcode == $status){  
	        return true;  
	    } else {  
	        return false;  
	    }
	}  

	function getAllConfig()
    {
        $con = getConnection();

        try {
            $query = "SELECT * FROM tblconfiguration";
            //return $query;
            $prepared_query = $con->prepare($query);
            $prepared_query->execute();
            $count = $prepared_query->rowCount();
            if($count > 0){
                $stmt = $prepared_query ->fetchAll();
                return $stmt;
            }else{
                return false;
                //return $count;
            }
        } catch (Exception $e) {
            return false;
            //return $e->getMessage();
        }
    }

    function sendMail($msg, $email, $subject)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = TRUE;
            $mail->SMTPSecure = "ssl";
            $mail->Port     = 465;  
            $mail->Username = "micheal@friqone.pro";
            $mail->Password = "5PzxM]8Pn;D?";
            $mail->Host     = "mail.friqone.pro";
            $mail->Mailer   = "smtp";
            $mail->SetFrom('micheal@friqone.pro', 'MIYANDA URL Status Check');
            $mail->AddReplyTo($email, $email);
            $mail->AddAddress($email);  
            $mail->Subject = ucwords($subject);
            $mail->WordWrap = 80;
            $mail->IsHTML(true);
            $mail->Body = $msg;
            //$mail->MsgHTML($content);
            
            
            //$data = json_encode(array('msg'=>$tt));
            //echo $data; die();
            
            
            if(!$mail->Send()) {
                return 'Problem in sending mail. Contact Admin';
            } else {
                return 'success';
            }                               
            
        } catch (phpmailerException $ep) {
          //echo $e->errorMessage(); //Pretty error messages from PHPMailer
          return 'Error Encountered. '.$ep->errorMessage(); 
        } catch (Exception $epp) {
          //echo $e->getMessage(); //Boring error messages from anything else!
          return 'Error Encountered: '.$epp->getMessage(); 
        }
    }

    function updateLastChecked($id)
    {
        $con = getConnection();

        date_default_timezone_set('Africa/Lagos'); // Set the Default Time Zone:
        $date = '';
        $d = new DateTime($date);
        $cdate = $d->format('Y-m-d h:i:s');

        try {

            $query = "UPDATE tblconfiguration SET last_checked = '".$cdate."' WHERE id = '".$id."'";
            //return $query;
            $prepared_query = $con->prepare($query);
            $prepared_query->execute();
            $count = $prepared_query->rowCount();
            if($count > 0){
                return 'success';
            }else{
                return false;
                //return $count;
            }

        } catch (Exception $e) {
            return false;
            //return $e->getMessage();
        }
    }


	

?>