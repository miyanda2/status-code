
<?php

    require_once './functions.php';

    //print_r($_POST); exit;

    $lists = getAllConfig();

    if($lists != false){
        date_default_timezone_set('Africa/Lagos'); // Set the Default Time Zone:
        $date = '';
        $d = new DateTime($date);
        //get the current datetime
        $cdate = $d->format('Y-m-d h:i:s');

        //loop through each of the records in the use configuration table
        foreach ($lists as $key => $list) {
            
            //check if the URl returns the status user wants to monitor
            if( urlExists($list['url'], $list['status']))
            {
                //get the time difference in minutes between the current time and the lastime the URL status was checked
                $first_date = new DateTime($cdate);
                $second_date = new DateTime($list['last_checked']);
                $interval = $first_date->diff($second_date);
                $minutes_diff = $interval->format('%I');

                //echo 'Minute Difference in Two Times: '.$minutes_diff.'<br/>';

                if($minutes_diff == $list['frequency']){ //if the time difference in minutes tally with the frequency the user sets

                    //draft message of email
                    $msg = 'Your watchlist URL '.$list['url'].' has shown the status '.$list['status'].'.';

                    //send email to user
                    $res = sendMail($msg, $list['email'], 'HTTP Status');
                    if($res == 'success'){ //if email is sent
                        //update the last checked column for this url
                        updateLastChecked($list['id']);

                        //echo success
                        echo 'success '.$list['email'].' <br/>';
                    }else{
                        //if email does not send
                        echo 'failed - '.$res.' - <br/>';
                    }
                }
            }else{
                //if URL check returns a different status than the one being monitored
                echo 'failed -- <br/>';
            }   
        }
    }

?>