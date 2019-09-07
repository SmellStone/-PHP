<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/28
 * Time: 23:00
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$pwd = $request->pwd;
$repwd = $request->repwd;
$uphone = $request->uphone;



$servername="localhost";
$username="root";
$password="root";
$database="hlw";

/*$pwd = '123456';
$repwd = '123456';
$uphone = '15954698669';*/

/*$uphone = '15954698669';*/

//创建连接
$conn=new mysqli($servername,$username,$password,$database);

//检测连接
if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}

$sql = "UPDATE `user` SET `upwd` = '".$pwd."' WHERE `uphone`= '".$uphone."'";

$stmt = mysqli_stmt_init($conn);

if($pwd == $repwd)
{
    $conn->query($sql);
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