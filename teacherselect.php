<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/4
 * Time: 22:33
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uname = $request->uname; //姓名
$usex = $request->usex;  //性别
$pageNow = $request->page;//当前页数


//$uname = null;
//$uhy = null;
//$usex = null;
//$pageNow = 1;//当前页数

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

//分页
if($uname != null && $usex != null )
{
    $sql ="SELECT COUNT(*) FROM `user` WHERE `uname` LIKE '%".$uname."%' AND `usex` = '".$usex."' AND `usf` ='t'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $recordCount = $row['COUNT(*)'];//总条数
}

if($uname == null && $usex == null)
{
    $sql ="SELECT COUNT(*) FROM `user`";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $recordCount = $row['COUNT(*)'];//总条数
}

if($uname != null && $usex == null)
{
    $sql ="SELECT COUNT(*) FROM `user` WHERE `uname` LIKE '%".$uname."%' AND `usf` ='t'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $recordCount = $row['COUNT(*)'];//总条数
}


if($uname == null && $usex != null)
{
    $sql ="SELECT COUNT(*) FROM `user` WHERE `usex` = '".$usex."' AND `usf` ='t'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $recordCount = $row['COUNT(*)'];//总条数
}



$pageSize = 10;
$pageCount=ceil($recordCount/$pageSize);

if ($pageNow < 1) {
    $pageNow = 1;
}elseif ($pageNow > $pageCount) {
    $pageNow = $pageCount;
}

$pageStart = ($pageNow-1)*$pageSize;//起始位置  每页从第几条数据显示


//查询结果
if($uname != null && $usex != null )
{
    $sql ="SELECT `uphone`,`uemail`,`uname`,`uimg`,`uintroduce`,`usex`,`umname`,`uqq`,`utime` FROM `user` WHERE `uname` LIKE '%".$uname."%' AND `usex` = '".$usex."' AND `usf` ='t' limit $pageStart,$pageSize";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}

if($uname == null && $usex == null)
{
    $sql ="SELECT `uphone`,`uemail`,`uname`,`uimg`,`uintroduce`,`usex`,`umname`,`uqq`,`utime` FROM `user` WHERE `usf` ='t'";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}

if($uname != null  && $usex == null)
{
    $sql ="SELECT `uphone`,`uemail`,`uname`,`uimg`,`uintroduce`,`usex`,`umname`,`uqq`,`utime` FROM `user` WHERE `uname` LIKE '%".$uname."%'  AND `usf` ='t' limit $pageStart,$pageSize";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}



if($uname == null && $usex != null)
{
    $sql ="SELECT `uphone`,`uemail`,`uname`,`uimg`,`uintroduce`,`usex`,`umname`,`uqq`,`utime` FROM `user` WHERE `usex` = '".$usex."' AND `usf` ='t' limit $pageStart,$pageSize";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}

