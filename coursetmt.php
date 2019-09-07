<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/5
 * Time: 21:36
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$course = $request->course; //课程名
$phone = $request->uphone;;//手机号
$score = $request->score;//评分
$estimate = $request->estimate;//评论
$time = $request->time;//时间

//$course = '数据结构';
//$phone = '15954698669';
//$score = '4';
//$estimate = '还不错';
//$time = date("Y-m-d");



//$pageNow = 1;//当前页数

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql="INSERT INTO `coursetmt` (course, cphone, cscore, ctime, cestimate)VALUES (?, ?, ?, ?, ?);";

if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数
    mysqli_stmt_bind_param($stmt,'ssiss',$ccourse,$cphone,$cscore,$ctime,$cestimate);

    // 设置参数并执行
    $ccourse = $course;
    $cphone = $phone;
    $cscore = intval($score);
    $ctime = $time;
    $cestimate = $estimate;

    mysqli_stmt_execute($stmt);
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}