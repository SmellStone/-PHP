<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/30
 * Time: 0:42
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');


$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$cmodule = $request->module;
$ccomment = $request->comment;
$cphone = $request->uphone;
$ctitle = $request->title;
$ctime = $request->time;




$servername="localhost";
$username="root";
$password="root";
$database="hlw";

$conn=new mysqli($servername,$username,$password,$database);

//检测连接
if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}

$stmt = mysqli_stmt_init($conn);

$sql1 = "SELECT MAX(cid) FROM `ctieba` WHERE cphone = '".$cphone."'";
$result = $conn->query($sql1);
$rows = $result->fetch_assoc();

//echo $rows['MAX(cid)'];

$sql = "UPDATE `ctieba` SET `comment` = '".$ccomment."'WHERE `cid` = '".$rows['MAX(cid)']."'";
$sql2 = "UPDATE `ctieba` SET `ctime` = '".$ctime."'WHERE `cid` = '".$rows['MAX(cid)']."'";
$sql3 = "UPDATE `ctieba` SET `cmodule` = '".$cmodule."'WHERE `cid` = '".$rows['MAX(cid)']."'";
if($conn->query($sql) && $conn->query($sql2) && $conn->query($sql3))
{
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else {
    $result = array(
        "verify" => false,
    );
    echo json_encode($result);
}


