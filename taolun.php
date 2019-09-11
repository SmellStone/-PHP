<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/2
 * Time: 20:09
 */
header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$ccourse = $request->course;
$phone = $request->phone;
$ccomment = $request->comment;


$ctime = date("Y-m-d");

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql="INSERT INTO `taolun` (cphone, course, comment, ctime)VALUES (?, ?, ?, ?);";

if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数
    mysqli_stmt_bind_param($stmt,'ssss',$cphone,$course,$comment,$time);

    // 设置参数并执行
    $cphone = $phone;
    $course =$ccourse;
    $comment = $ccomment;
    $time =$ctime;
    mysqli_stmt_execute($stmt);
    $result=array(
        "taolun"=>true,
    );
    echo json_encode($result);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

