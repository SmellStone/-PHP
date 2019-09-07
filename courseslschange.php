<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/5
 * Time: 0:22
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$cname = $request->cname; //课程名
$ctype = $request->ctype;//课程分类
$cpingjia = $request->cpingjia;//评价
$cjieshao =$request->cjieshao;//介绍
$cjianjie = $request->cjianjie;//简介
$cgaishu = $request->cgaishu;//概述
$cteacher = $request->cteacher;//授课老师
$cdengji = $request->cdengji;//授课老师职称
$cgonggao =$request->cgonggao;//公告
$cfy =$request->cfy;//费用：会员，私有……
$cschool =$request->cschool;//授课老师所在学校
$chot =$request->chot;//热度

//$cname = '你好'; //课程名
//$ctype = '123';//课程分类
//$cpingjia = '123';//评价
//$cjieshao ='12345';//介绍
//$cjianjie = '123456';//简介
//$cgaishu = '12345';//概述
//$cteacher = '456789';//授课老师
//$cdengji = '123456';//授课老师职称
//$cgonggao = '123456';//公告
//$cfy ='213456';//费用：会员，私有……
//$cschool ='4562123';//授课老师所在学校
//$chot ='123456';//热度

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql1 = "UPDATE `courseku` SET `ctype` ='".$ctype."' WHERE `cname` ='".$cname."' ";
$sql2 = "UPDATE `courseku` SET `cpingjia` ='".$cpingjia."' WHERE `cname` ='".$cname."' ";
$sql3 = "UPDATE `courseku` SET `cjieshao` ='".$cjieshao."' WHERE `cname` ='".$cname."' ";
$sql4 = "UPDATE `courseku` SET `cjianjie` ='".$cjianjie."' WHERE `cname` ='".$cname."' ";
$sql5 = "UPDATE `courseku` SET `cgaishu` ='".$cgaishu."' WHERE `cname` ='".$cname."' ";
$sql6 = "UPDATE `courseku` SET `cteacher` ='".$cteacher."' WHERE `cname` ='".$cname."' ";
$sql7 = "UPDATE `courseku` SET `cdengji` ='".$cdengji."' WHERE `cname` ='".$cname."' ";
$sql8 = "UPDATE `courseku` SET `cgonggao` ='".$cgonggao."' WHERE `cname` ='".$cname."' ";
$sql9 = "UPDATE `courseku` SET `cfy` ='".$cfy."' WHERE `cname` ='".$cname."' ";
$sql10 = "UPDATE `courseku` SET `cschool` ='".$cschool."' WHERE `cname` ='".$cname."' ";
$sql11 = "UPDATE `courseku` SET `chot` ='".$chot."' WHERE `cname` ='".$cname."' ";

if($conn->query($sql1) && $conn->query($sql2) && $conn->query($sql3) && $conn->query($sql4) && $conn->query($sql5) && $conn->query($sql6) && $conn->query($sql7) && $conn->query($sql8) && $conn->query($sql9) && $conn->query($sql10) && $conn->query($sql11))
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