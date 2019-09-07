<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/26
 * Time: 0:42
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$yzm = $request->yzm;
$suphone = $request->uphone;

//$yzm ='7716';

$servername="localhost";
$username="root";
$password="root";
$database="hlw";


/*$uphone = '15954698669';*/

//创建连接
$conn=new mysqli($servername,$username,$password,$database);

//检测连接
if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}

$sql1="SELECT MAX(yid) FROM `yzm` WHERE `yphone` ='".$suphone."'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
//测试数据
//echo $row1['MAX(yid)'];

$maxyid = intval($row1['MAX(yid)']);
$sql2 = "SELECT `ynum` FROM `yzm` where`yid`='".$maxyid."'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
//测试数据
//echo $row2['ynum'];

if($yzm == $row2['ynum'])
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