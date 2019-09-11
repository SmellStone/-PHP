<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/6
 * Time: 0:55
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$ccid = $request->cid; //贴吧详情页返回数据时返回的cid




$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql = "SELECT `cid`,`fphone`,`firstes`,`ftime`,`uimg`,`umname`,`uclass` FROM `tbtmt`,`user` WHERE `cid` ='".$ccid."' AND `fphone` = `uphone` ";
//$sql1 = "SELECT `cid`,`sphone`,`secondes`,`stime`,`uimg`,`umname`,`uclass` FROM `tbtmt`,`user` WHERE `cid` ='".$ccid."' AND `sphone` = `uphone` ";
$sql2 = "SELECT COUNT(*) FROM `tbtmt` WHERE `cid` = '".$ccid."'";

//评论条数
$result2 = $conn->query($sql2);
$rows2 = $result2->fetch_row();
//print_r($rows2[0]);


$info = array();
$info1 = array();
$info2 =array();

//获取一级评论及用户信息
$result = $conn->query($sql);
while ($rows = $result->fetch_assoc()) {
    $info[] = $rows;
}
//print_r($info);

////获取二级评论及用户信息
//$result1 = $conn->query($sql1);
//while ($rows1 = $result1->fetch_assoc()) {
//    $info1[] = $rows1;
//}
////print_r($info1);
//
////整合一二级评论及信息
//for($i=0;$i<$rows2[0];$i++)
//{
//    $info2[$i] = array($info[$i],$info1[$i]);
//}
//
////print_r($info2);

echo json_encode($info);
