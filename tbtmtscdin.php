<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/5
 * Time: 23:37
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$ccid = $request->cid; //贴吧详情页返回数据时返回的cid
$csphone = $request->uphone;;//当前用户手机号
$csecond = $request->estimate;//评论
$cstime = $request->time;//时间
$cfirst = $request->first;//第一级评论




$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql="UPDATE `tbtmt` SET `sphone` = '".$csphone."' WHERE `cid` ='".$ccid."' AND `fphone` = '".$cfphone."' AND `firstes` = '".$cfirst."'";
$sql1="UPDATE `tbtmt` SET `secondes` = '".$csecond."' WHERE `cid` ='".$ccid."' AND `fphone` = '".$cfphone."'AND `firstes` = '".$cfirst."'";
$sql2="UPDATE `tbtmt` SET `stime` = '".$cstime."' WHERE `cid` ='".$ccid."' AND `fphone` = '".$cfphone."'AND `firstes` = '".$cfirst."'";


if($conn->query($sql) && $conn->query($sql1) && $conn->query($sql2))
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
