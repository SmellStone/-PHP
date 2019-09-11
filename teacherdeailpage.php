<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/4
 * Time: 23:45
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uphone = $request->phone;;//手机号


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql ="SELECT `uname`,`umname`,`uphone`,`uemail`,`uqq`,`uintroduce`,`ucount` FROM `user` WHERE `uphone` = '".$uphone."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

//print_r($row);

echo json_encode($row);
