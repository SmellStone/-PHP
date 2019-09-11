<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/4
 * Time: 19:03
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uname = $request->uname; //姓名 1
$uphone = $request->phone;;//手机号 1
$usex = $request->usex;//性别 1
$uemail =$request->uemail;//邮箱 1
$uintroduce = $request->uintroduce;//个人介绍 1
$umname = $request->umname;//昵称 1
$uqq = $request->uqq;//QQ 1
$time = $request->time; //时间 1





$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql="INSERT INTO `user` (uphone, upwd, utime, umname, uimg, ucount, uhy, usf, uname, usex, uemail, uintroduce, uclass, uqq)VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数
    mysqli_stmt_bind_param($stmt,'ssssssssssssss',$phone,$upwd,$utime,$mname,$uimg,$ucount,$uhy,$usf,$name,$sex,$email,$introduce,$class,$qq);

    // 设置参数并执行
    $phone = $uphone;
    $upwd = '666666';
    $utime = $time;
    $mname = $umname;
    $uimg = 'http://188.131.173.104/hlw+/头像/info.png';
    $ucount = '0';
    $uhy = '普通';
    $usf = 's';
    $name = $uname;
    $sex = $usex;
    $email = $uemail;
    $introduce = $uintroduce;
    $class = '1';
    $qq = $uqq;
    mysqli_stmt_execute($stmt);
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
