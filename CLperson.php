<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/2
 * Time: 23:01
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$phone = $request->uphone;

//$phone = '15954698669';

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql = "SELECT `umname`,`uimg`,`uclass`,`utime`,`uhy` FROM `user` WHERE `uphone` = '".$phone."'";

$result = $conn->query($sql);
$rows = $result->fetch_assoc();
//print_r($rows);

//收藏
$sql1 = "SELECT `ccourse` FROM `collect` WHERE `cphone` ='".$phone."'";
$result1 = $conn->query($sql1);
$info1 = array();
while ($rows1 = $result1->fetch_assoc()) {
    $info1[] = $rows1;
}
//print_r($info1[0]['ccourse']);


$sql2 = "SELECT COUNT(*) FROM `collect` WHERE `cphone` = '".$phone."'";
$result2 = $conn->query($sql2);
$rows2 = $result2->fetch_row();
//print_r($rows2[0]);


$info3 =array();
for($i = 0; $i<$rows2[0]; $i++)
{
    $sql3 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `cname` ='".$info1[$i]['ccourse']."'";
    $result3 = $conn->query($sql3);
    $rows3 = $result3->fetch_row();
    $info3[$i] = $rows3;
}
//print_r($info3);


//加入
$sql4 = "SELECT `class` FROM `join` WHERE `uphone` ='".$phone."'";
$result4 = $conn->query($sql4);
$info4 = array();
while ($rows4 = $result4->fetch_assoc()) {
    $info4[] = $rows4;
}
//print_r($info1[0]['ccourse']);


$sql5 = "SELECT COUNT(*) FROM `join` WHERE `uphone` = '".$phone."'";
$result5 = $conn->query($sql5);
$rows5 = $result5->fetch_row();
//print_r($rows5[0]);


$info6 =array();
for($i = 0; $i<$rows5[0]; $i++)
{
    $sql6 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `cname` ='".$info1[$i]['ccourse']."'";
    $result6 = $conn->query($sql6);
    $rows6 = $result6->fetch_row();
    $info6[$i] = $rows6;
}
//print_r($info6);

$info = array($rows,$info3,$info6);
//print_r($info);

echo json_encode($info);

$conn->close();
