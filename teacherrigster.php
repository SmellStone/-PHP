<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/5
 * Time: 16:20
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uname = $request->uname; //姓名
$uphone = $request->phone;;//手机号
$uemail =$request->uemail;//邮箱
$umname = $request->umname;//昵称
$uqq = $request->uqq;//QQ
$uwork = $request->uwork;//职业


$time = date("Y-m-d");


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql="INSERT INTO `user` (uphone, upwd, utime, umname, uimg, ucount, uhy, usf, uname, usex, uemail, uqq, uclass, uwork)VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数
    mysqli_stmt_bind_param($stmt,'ssssssssssssss',$phone,$upwd,$utime,$mname,$uimg,$ucount,$uhy,$usf,$name,$sex,$email,$qq,$class,$work);

    // 设置参数并执行
    $phone = $uphone;
    $upwd = '666666';
    $utime = $time;
    $mname = $umname;
    $uimg = 'http://188.131.173.104/hlw+/头像/info.png';
    $ucount = '0';
    $uhy = '会员';
    $usf = 't';
    $name = $uname;
    $sex = '保密';
    $email =$uemail;
    $qq = $uqq;
    $class = '1';
    $work = $uwork;
    mysqli_stmt_execute($stmt);
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}