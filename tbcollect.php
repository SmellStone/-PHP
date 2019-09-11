<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/3
 * Time: 19:24
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$cid = $request->cid;
$phone = $request->phone;




$ctime = date("Y-m-d");

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql ="INSERT INTO `tbcollect` (cphone, tid)VALUES (?, ?);";

if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数c
    mysqli_stmt_bind_param($stmt,'ss',$uphone,$tid);

    // 设置参数并执行
    $uphone = $phone;
    $tid = $cid;
    mysqli_stmt_execute($stmt);
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
