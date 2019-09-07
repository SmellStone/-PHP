<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/5
 * Time: 23:35
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$ccid = $request->cid; //贴吧详情页返回数据时返回的cid
$cfphone = $request->uphone;;//当前用户手机号
$cfirst = $request->estimate;//评论
$cftime = $request->time;//时间


//$ccid ='4';
//$cfphone = '15954698669';
//$cfirst = '说的很不错';
//$cftime = date("Y-m-d");


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql="INSERT INTO `tbtmt` (cid, fphone, firstes, ftime)VALUES (?, ?, ?, ?);";

if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数
    mysqli_stmt_bind_param($stmt,'ssss',$cid,$fphone,$firstes,$ftime);

    // 设置参数并执行
    $cid = $ccid;
    $fphone = $cfphone;
    $firstes = $cfirst;
    $ftime = $cftime;

    mysqli_stmt_execute($stmt);
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}