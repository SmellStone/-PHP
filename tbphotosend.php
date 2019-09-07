<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

//$postdata = file_get_contents("php://input");
//$request = json_decode($postdata);
//$uphone = $request->uphone;
//$title = $request->title;
//$module = $request->module;

$uphone = $_POST["uphone"];
$title = $_POST["title"];
$module = $_POST["module"];


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
            move_uploaded_file($_FILES["upload"]["tmp_name"], "贴吧/" . $_FILES["upload"]["name"]);
            //echo "Stored in: " . "http://188.131.173.104/hlw+/头像/" . $_FILES["upload"]["name"];


            $sql1 ="INSERT INTO `ctieba` (cphone, ctitle, cmodule, cimg)VALUES (?, ?, ?, ?);";
    
    
            if (mysqli_stmt_prepare($stmt, $sql1)) {
                // 绑定参数c
                mysqli_stmt_bind_param($stmt,'ssss',$phone,$ctitle,$cmodule,$img);
    
                // 设置参数并执行
                $phone = $uphone;
                $ctitle = $title;
                $cmodule = $module;
                $img = "http://188.131.173.104/hlw+/贴吧/" . $_FILES["upload"]["name"];
                mysqli_stmt_execute($stmt);
                $result=array(
                    "verify"=>true,
                    "URL"=> "http://188.131.173.104/hlw+/贴吧/" . $_FILES["upload"]["name"]
                );
                echo json_encode($result);
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
}
else
{
    echo "Invalid file";
}
