<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/2
 * Time: 22:06
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$phone = $request->uphone;
$course = $request->course;


//$phone = "15954698669";
//$course = "大学英语";


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);


$sql="INSERT INTO `join` (uphone, class)VALUES (?, ?);";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数
    mysqli_stmt_bind_param($stmt,'ss',$uphone,$class);

    // 设置参数并执行
    $uphone = $phone;
    $class =$course;
    mysqli_stmt_execute($stmt);
    $result=array(
        "join"=>"success",
    );
    echo json_encode($result);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
