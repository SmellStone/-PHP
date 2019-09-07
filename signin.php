<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/29
 * Time: 20:58
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$time = $request->day;
$suphone = $request->uphone;
$count = $request->count;
$estimate = $request->estimate;

$retime = date("Y-m-d");


/*$time = '2019-08-29';
$uphone = '15954698669';
$count = '1';
$estimate = true;*/



$servername="localhost";
$username="root";
$password="root";
$database="hlw";

$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql1 = "SELECT MAX(cid) FROM `signin` WHERE `cphone` = '".$suphone."'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();

$sql2 ="SELECT `ctime` FROM `signin` WHERE `cid` ='".$row1['MAX(cid)']."'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

//echo $row2['ctime'];


//检测连接
if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}

$sql3 = "UPDATE `user` SET `ucount` = `ucount`+'".$count."' WHERE `uphone` ='".$suphone."'";


if($estimate == true && $time == $retime)
{
    if($row1['MAX(cid)'] == null)
    {
        $sql="INSERT INTO `signin` (cphone, ctime)VALUES (?, ?);";
        if (mysqli_stmt_prepare($stmt, $sql)) {
            // 绑定参数
            mysqli_stmt_bind_param($stmt,'ss',$uphone,$utime);

            // 设置参数并执行
            $uphone = $suphone;
            $utime = $retime;
            mysqli_stmt_execute($stmt);
            $result=array(
                "verify"=>true,
            );
            echo json_encode($result);
        }
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $sql3 = "UPDATE `user` SET `ucount` = `ucount`+'".$count."' WHERE `uphone` ='".$suphone."'";
        $conn->query($sql3);
    }
    else
    {
        if($row2['ctime'] == $time )
        {
            $result=array(
                "verify"=>0,
            );
            echo json_encode($result);
        }
        else
        {
            $sql4 = "UPDATE `signin` SET `ctime` = '".$retime."'WHERE `cid` ='".$row1['MAX(cid)']."'";
            $conn->query($sql4);

            $sql3 = "UPDATE `user` SET `ucount` = `ucount`+'".$count."' WHERE `uphone` ='".$suphone."'";
            $conn->query($sql3);

            $result=array(
                "verify"=>true,
            );
            echo json_encode($result);
        }
    }
}
else
{
    $result=array(
        "verify"=>false,
    );
    echo json_encode($result);
}