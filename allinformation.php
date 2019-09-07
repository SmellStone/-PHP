<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/1
 * Time: 23:21
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uphone = $request->uphone;




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

$sql = "SELECT `uphone`,`uemail`,`uname`,`uimg`,`uintroduce`,`usex`,`umname`,`uqq` FROM `user` WHERE `uphone` = '".$uphone."'";

$result = $conn->query($sql);
$rows=$result->fetch_row();

$results = array(
    "uphone" => $rows[0],
    "uemail" => $rows[1],
    "uname" => $rows[2],
    "uimg" => $rows[3],
    "uintroduce"=> $rows[4],
    "usex" => $rows[5],
    "umname" => $rows[6],
    "uqq" => $rows[7]

);

echo json_encode($results);