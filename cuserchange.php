﻿<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/4
 * Time: 16:20
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uname = $request->uname; //姓名
$uphone = $request->uphone;;//手机号
$uhy = $request->uhy;//会员或者普通
$usex = $request->usex;//性别
$uemail =$request->uemail;//邮箱
$uintroduce = $request->uintroduce;//个人介绍
$umname = $request->umname;//昵称
$uqq = $request->uqq;//QQ
$uwx = $request->uwx;//微信
$ucount = $request->ucount;//积分
$uclass =$request->uclass;//等级





//$pageNow = 1;//当前页数

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql = "UPDATE `user` SET `uname` ='".$uname."' WHERE `uphone` ='".$uphone."' ";
$sql1 = "UPDATE `user` SET `uhy` ='".$uhy."' WHERE `uphone` ='".$uphone."' ";
$sql2 = "UPDATE `user` SET `usex` ='".$usex."' WHERE `uphone` ='".$uphone."' ";
$sql3 = "UPDATE `user` SET `uemail` ='".$uemail."' WHERE `uphone` ='".$uphone."' ";
$sql4 = "UPDATE `user` SET `uintroduce` ='".$uintroduce."' WHERE `uphone` ='".$uphone."' ";
$sql5 = "UPDATE `user` SET `umname` ='".$umname."' WHERE `uphone` ='".$uphone."' ";
$sql6 = "UPDATE `user` SET `uqq` ='".$uqq."' WHERE `uphone` ='".$uphone."' ";
$sql7 = "UPDATE `user` SET `uwx` ='".$uwx."' WHERE `uphone` ='".$uphone."' ";
$sql8 = "UPDATE `user` SET `ucount` ='".$ucount."' WHERE `uphone` ='".$uphone."' ";
$sql9 = "UPDATE `user` SET `uclass` ='".$uclass."' WHERE `uphone` ='".$uphone."' ";

if($conn->query($sql) && $conn->query($sql1) && $conn->query($sql2) && $conn->query($sql3) && $conn->query($sql4) && $conn->query($sql5) && $conn->query($sql6) && $conn->query($sql7) && $conn->query($sql8) && $conn->query($sql9))
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
