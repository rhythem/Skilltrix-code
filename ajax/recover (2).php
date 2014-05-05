<?php

    $email =$_POST["email"];

    if($email !=''){
        include '/var/www/html/core/classes/users.php';
        $recover = new users();
        if($recover->email_exists($email)===true){
            
            
            $code = $recover->recover($email);
            $temp = 'Password sent to <b>'.$email.'</b>';

            echo json_encode(array("message" => $temp,"type" => "password","mode"=>"success","code" => $code,"email"=>$email));
        }else{
             echo json_encode(array("message" => "Email does not exist. Please try again","type" => "text","mode"=>"fail"));
        }
    } else {
        echo json_encode(array("message" => "Invalid email","type" => "text","mode"=>"fail"));
    }

?>