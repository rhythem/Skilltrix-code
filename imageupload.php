<?php
include 'core/init.php';
session_start();
global $session_user_id;
$path = "images/user/cover/";

$valid_formats = array("jpg", "png", "bmp","jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
        $name = $_FILES['photoimg']['name'];
        $size = $_FILES['photoimg']['size'];
        if(strlen($name)){
                list($txt, $ext) = explode(".", $name);
                if(in_array($ext,$valid_formats)){
                        if($size<(1024*256)) // Image size max 256kb
                        {
                                $actual_image_name = time().$session_id.".".$ext;
                                $tmp = $_FILES['photoimg']['tmp_name'];
                                if(move_uploaded_file($tmp, $path.$actual_image_name))
                                {
                                        $actual_image_name = $path.$actual_image_name;
                                        mysql_query("UPDATE users SET cover ='$actual_image_name' WHERE user_id='$user_session_id'");
                                        echo "<img src='uploads/".$actual_image_name."' class='preview'>";
                                }
                                else
                                   echo "failed";
                         }else{
                                echo "Image file size max 1 MB";
                         }
                }
        else
                echo "Invalid file format..";
        }else{
                echo "Please select image..!";
        }
        exit;
}
?>
