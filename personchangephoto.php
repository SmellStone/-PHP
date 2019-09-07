<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/1
 * Time: 23:04
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');


$uphone = $_POST["uphone"];


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

$conn=new mysqli($servername,$username,$password,$database);

//检测连接
if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}

$stmt = mysqli_stmt_init($conn);



if ( (     ($_FILES["upload"]["type"] == "image/png")
        || ($_FILES["upload"]["type"] == "image/jpeg")
        || ($_FILES["upload"]["type"] == "image/pjpeg")
        || ($_FILES["upload"]["type"] == "image/jpg"))
    && ($_FILES["upload"]["size"] < 200000))
{
    if ($_FILES["upload"]["error"] > 0)
    {
        echo "Return Code: " . $_FILES["upload"]["error"] . "<br />";
    }
    else
    {
//        echo "Upload: " . $_FILES["upload"]["name"] . "<br />";
//        echo "Type: " . $_FILES["upload"]["type"] . "<br />";
//        echo "Size: " . ($_FILES["upload"]["size"] / 1024) . " Kb<br />";
//        echo "Temp file: " . $_FILES["upload"]["tmp_name"] . "<br />";

//        if (file_exists("贴吧/" . $_FILES["upload"]["name"]))
//        {
//            echo $_FILES["upload"]["name"] . " already exists. ";
//        }
//        else
//        {
        move_uploaded_file($_FILES["upload"]["tmp_name"], "头像/" . $_FILES["upload"]["name"]);
        //echo "Stored in: " . "http://188.131.173.104/hlw+/头像/" . $_FILES["upload"]["name"];

        $sql = "UPDATE `user` SET `uimg` = '"."http://188.131.173.104/hlw+/头像/" . $_FILES["upload"]["name"]."' WHERE `uphone` = '".$uphone."'";
        if($conn->query($sql))
        {
            $result=array(
                "verify"=>true,
                "URL"=> "http://188.131.173.104/hlw+/头像/" . $_FILES["upload"]["name"]
            );
            echo json_encode($result);
        }
        else {
            $result = array(
                "verify" => false,
            );
            echo json_encode($result);
        }
        //}
    }
}
else
{
    echo "Invalid file";
}