<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/12
 * Time: 23:53
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$suphone = $request->uphone;
$supwd = $request->upwd;
$yzm = $request->yzm;
//$suemail = $request->uemail;
$reupwd = $request->reupwd;


$time = date("Y-m-d");


$servername="localhost";
$username="root";
$password="root";
$database="hlw";




//创建连接
$conn=new mysqli($servername,$username,$password,$database);

//检测连接
if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}
$sql="SELECT `uphone` FROM `user` where`uphone`='".$suphone."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

//测试查询数据
/*echo $row['uphone'];*/

$sql1="SELECT MAX(yid) FROM `yzm` WHERE `yphone` ='".$suphone."'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
//测试数据
//echo $row1['MAX(yid)'];

$maxyid = intval($row1['MAX(yid)']);
$sql2 = "SELECT `ynum` FROM `yzm` where`yid`='".$maxyid."'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
//测试数据
//echo $row2['ynum'];

if($row['uphone']!=null)
{
    $result=array(
        "verify"=>'rerjstr',
    );
    echo json_encode($result);
}
else
{
    if($yzm == $row2['ynum'])
    {
        if($supwd == $reupwd)
        {
            $sql="INSERT INTO `user` (uphone, upwd, utime, umname, uimg, ucount, uhy, uclass, usf)VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                // 绑定参数
                mysqli_stmt_bind_param($stmt,'sssssssss',$uphone,$upwd,$utime,$umname,$uimg,$ucount,$uhy,$uclass,$usf);

                // 设置参数并执行
                $uphone = $suphone;
                $upwd =$supwd;
                $utime = $time;
                $umname = 'musi'.$suphone;
                $uimg = 'http://188.131.173.104/hlw+/头像/info.png';
                $ucount = '0';
                $uhy = '普通';
		$uclass = '1';
		$usf = 's';
                mysqli_stmt_execute($stmt);
                $result=array(
                    "verify"=>true,
                );
                echo json_encode($result);
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else
        {
            $result=array(
                "verify"=>'bothfls',
            );
            echo json_encode($result);
        }
    }
    else
    {
        $result=array(
            "verify"=>'yzmfls',
        );
        echo json_encode($result);
    }
}

$conn->close();