<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/4
 * Time: 23:59
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$cname = $request->cname; //课程名
$ctype = $request->ctype; //课程类型：计算机，管理……
$pageNow = $request->page;//当前页数

//$cname = null;
//$ctype = null;
//$pageNow = '1';

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

//分页
if($cname != null && $ctype != null )
{
    $sql ="SELECT COUNT(*) FROM `courseku` WHERE `cname` LIKE '%".$cname."%' AND `ctype` = '".$ctype."'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $recordCount = $row['COUNT(*)'];//总条数
}

if(($cname == null && $ctype == null) || ($cname == '' && $ctype == null))
{
    $sql ="SELECT COUNT(*) FROM `courseku`";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $recordCount = $row['COUNT(*)'];//总条数
}

if($cname != null && $ctype == null)
{
    $sql ="SELECT COUNT(*) FROM `courseku` WHERE `cname` LIKE '%".$cname."%'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $recordCount = $row['COUNT(*)'];//总条数
}


if(($cname == null && $ctype != null) || ($cname == '' && $ctype != null))
{
    $sql ="SELECT COUNT(*) FROM `courseku` WHERE `ctype` = '".$ctype."'";

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

//查询
if($cname != null && $ctype != null )
{
    $sql ="SELECT * FROM `courseku` WHERE `cname` LIKE '%".$cname."%' AND `ctype` = '".$ctype."' limit $pageStart,$pageSize";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}

if($cname != null && $ctype == null )
{
    $sql ="SELECT * FROM `courseku` WHERE `cname` LIKE '%".$cname."%' limit $pageStart,$pageSize";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}

if(($cname == null && $ctype != null) || ($cname == '' && $ctype != null))
{
    $sql ="SELECT * FROM `courseku` WHERE `ctype` = '".$ctype."' limit $pageStart,$pageSize";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}

if(($cname == null && $ctype == null) || ($cname == '' && $ctype == null))
{
    $sql ="SELECT * FROM `courseku` limit $pageStart,$pageSize";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}
