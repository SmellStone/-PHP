<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/27
 * Time: 22:38
 */
header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$ccid = $request->cid; //贴吧详情页返回数据时返回的cid

//$ccid ='4';



$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql2 = "SELECT COUNT(*) FROM `tbtmt` WHERE `cid` = '".$ccid."'";

//评论条数
$result2 = $conn->query($sql2);
$rows2 = $result2->fetch_row();
//print_r($rows2[0]);

$result=array(
    "num"=>$rows2[0],
);
echo json_encode($result);



