<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/3
 * Time: 15:48
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$cid = $request->cid;
$phone = $request->phone;


//$phone = '15954698669';
//$cid = '5';

$ctime = date("Y-m-d");

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql ="SELECT `cid`,`ctitle`,`comment`,`ctime` FROM `ctieba` WHERE `cid` ='".$cid."'";
$result = $conn->query($sql);
$rows = $result->fetch_row();
//print_r($rows);


$sql1 ="SELECT `umname`,`uimg`,`uclass`,`ucount` FROM `user` WHERE `uphone` ='".$phone."'";
$result1 = $conn->query($sql1);
$rows1 = $result1->fetch_row();
//print_r($rows1);

$info =array($rows,$rows1);

echo json_encode($info);