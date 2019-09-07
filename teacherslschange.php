<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/4
 * Time: 22:44
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uname = $request->uname; //姓名
$uphone = $request->phone;;//手机号
$usex = $request->usex;//性别
$uemail =$request->uemail;//邮箱
$uintroduce = $request->uintroduce;//个人介绍
$umname = $request->umname;//昵称
$uqq = $request->uqq;//QQ


//$uphone = '15954698669';
//$uname = '霸霸';
//$uhy = '会员';
//$usex = '保密';
//$uemail ='123456@163.com';
//$uintroduce = '我最牛逼';
//$umname = '我是你霸霸';
//$uqq = '666666888';
//$uwx = 'a666666888';
//$ucount = '9999';
//$uclass = '9';




//$pageNow = 1;//当前页数

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql = "UPDATE `user` SET `uname` ='".$uname."' WHERE `uphone` ='".$uphone."' ";
$sql1 = "UPDATE `user` SET `usex` ='".$usex."' WHERE `uphone` ='".$uphone."' ";
$sql2 = "UPDATE `user` SET `uemail` ='".$uemail."' WHERE `uphone` ='".$uphone."' ";
$sql3 = "UPDATE `user` SET `uintroduce` ='".$uintroduce."' WHERE `uphone` ='".$uphone."' ";
$sql4 = "UPDATE `user` SET `umname` ='".$umname."' WHERE `uphone` ='".$uphone."' ";
$sql5 = "UPDATE `user` SET `uqq` ='".$uqq."' WHERE `uphone` ='".$uphone."' ";


if($conn->query($sql) && $conn->query($sql1) && $conn->query($sql2) && $conn->query($sql3) && $conn->query($sql4) && $conn->query($sql5))
{
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else
{
    $result=array(
        "verify"=>false,
    );
    echo json_encode($result);
}