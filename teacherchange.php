<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/4
 * Time: 20:54
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uphone = $request->uphone; //手机号
$umname = $request->umname; //昵称
$uemail = $request->uemail; //邮箱
$uqq = $request->uqq; //QQ
$uplace = $request->uplace; //工作地点
$uschool = $request->uschool; //学校
$uwork = $request->uwork; //职业

//$uphone = '17862178888'; //手机号
//$umname = '张老师'; //昵称
//$uemail = '789456@163.com'; //邮箱
//$uqq = '789456'; //QQ
//$uplace = '北京'; //工作地点
//$uschool = '清华大学'; //学校
//$uwork = '教授'; //职业

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql = "UPDATE `user` SET `umname` ='".$umname."' WHERE `uphone` = '".$uphone."'";
$sql1 = "UPDATE `user` SET `uemail` ='".$uemail."' WHERE `uphone` = '".$uphone."'";
$sql2 = "UPDATE `user` SET `uqq` ='".$uqq."' WHERE `uphone` = '".$uphone."'";
$sql3 = "UPDATE `user` SET `uplace` ='".$uplace."' WHERE `uphone` = '".$uphone."'";
$sql4 = "UPDATE `user` SET `uschool` ='".$uschool."' WHERE `uphone` = '".$uphone."'";
$sql5 = "UPDATE `user` SET `uwork` ='".$uwork."' WHERE `uphone` = '".$uphone."'";

if( $conn->query($sql) && $conn->query($sql1) && $conn->query($sql2) && $conn->query($sql3) && $conn->query($sql4) && $conn->query($sql5))
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