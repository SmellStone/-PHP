<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/15
 * Time: 19:22
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');
header("Content-Type:text/html;charset=UTF-8");
$servername="localhost";
$username="root";
$password="root";
$database="hlw";

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$pageNow = $request->page;//当前页数

//$pageNow = 1;//当前页数


//创建连接
$conn = new mysqli($servername,$username,$password,$database);
$sql="SELECT COUNT(*) FROM `courseku`";


//$sql1 = "SELECT `cname` FROM `courseku` WHERE `cid` = 1";
$stmt = mysqli_stmt_init($conn);

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$recordCount = $row['COUNT(*)'];//总条数
//$recordCount = $row['cname'];
//echo $recordCount;
$pageSize = 15;
$pageCount=ceil($recordCount/$pageSize);

if ($pageNow < 1) {
    $pageNow = 1;
}elseif ($pageNow > $pageCount) {
    $pageNow = $pageCount;
}

$pageStart = ($pageNow-1)*$pageSize;//起始位置  每页从第几条数据显示

$sql1 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` limit $pageStart,$pageSize";

$result1 = $conn->query($sql1);
$info = array();

/*$rows = $result1->fetch_assoc();
print_r($rows) ;*/


while ($rows = $result1->fetch_assoc()) {
    $info[] = $rows;
}
//将总页码保存到数组
$info[] = $pageCount;

//$a= json_encode($info);
//$b = json_decode($a);
//print_r($b);
echo json_encode($info);

$conn->close();

