<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/2
 * Time: 23:51
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$phone = $request->uphone;

$retime = date("Y-m-d");

function diffBetweenTwoDays ($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);

    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    return ($second1 - $second2) / 86400;
}


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql ="SELECT `umname`,`uimg`,`uclass`,`utime` FROM `user` WHERE `uphone` ='".$phone."'";
$result = $conn->query($sql);
$rows=$result->fetch_row();
//print_r($rows[3]);

$time =$rows[3];

$day = diffBetweenTwoDays($time,$retime);

$info = array($rows,$day);

//print_r($info);

echo json_encode($info);

$conn->close();
