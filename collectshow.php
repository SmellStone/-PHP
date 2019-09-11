<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/24
 * Time: 18:02
 */
header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$phone = $request->uphone;


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql = "SELECT `ccourse` FROM `collect` WHERE `cphone` = '".$phone."'";
$result = $conn->query($sql);
$info = array();

while ($rows = $result->fetch_assoc()) {
    $info[] = $rows;
}



echo json_encode($info);

//print_r($info);
$conn->close();
