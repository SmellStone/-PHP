<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/22
 * Time: 23:14
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$phone = $request->uphone;
$ccourse = $request->ucourse;

//$phone = '15954698669';
//$ccourse = '大学法语';

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);


$sql ="INSERT INTO `collect` (cphone, ccourse)VALUES (?, ?);";
$sql1 = "SELECT COUNT(ccourse) FROM `collect` WHERE `cphone` = '".$phone."' and `ccourse` = '".$ccourse."'";
$sql2 = "UPDATE `courseku` SET `chot` = `chot`+1 WHERE `cname`= '".$ccourse."'";

$stmt = mysqli_stmt_init($conn);


$result1 = $conn->query($sql1);
$row = $result1->fetch_assoc();

if($row['COUNT(ccourse)']>=1)
{
    $result=array(
        "collect"=>"recollect",
    );
    echo json_encode($result);
}
else
{
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // 绑定参数
        mysqli_stmt_bind_param($stmt,'ss',$cphone,$course);

        // 设置参数并执行
        $cphone = $phone;
        $course =$ccourse;
        mysqli_stmt_execute($stmt);
        $result=array(
            "collect"=>"success",
        );
        echo json_encode($result);
        $conn->query($sql2);
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



//echo $row['COUNT(ccourse)'];

$conn->close();