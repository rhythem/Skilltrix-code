<?php
$email = $_POST["email"];

if($email !=''){
    include 'init.php';
    global $users;
    $recover = new users();

    if($recover->email_exists()===true){
        $to = $email;
        $subject = "Forgot Password";
        $headers = "From: Your Site <".$server_email.">\r\n";
        $headers .= "Content-type: text/html\r\n";
        $message = "You have requested that you forgot your password.<br>
                    Password: <b>".$r["password"]."<b>";
        
        //$this->outmail($to, $subject, $message, $headers);
    
        echo 'Password sent to <b>'.$email.'</b>';
    }else{
        echo 'Email does not exist.';
    }
} else {
    echo 'Invalid Email';
}
?>