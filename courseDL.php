<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/23
 * Time: 22:19
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
//$type =$request->type;
$direction = $request->direction;
$label = $request->label;

//$type = '计算机';
//$direction = '计算机';
//$label = '数据';

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

$conn = new mysqli($servername,$username,$password,$database);

if($direction != null && $label == null )
{
    $sql = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku`WHERE `ctype` = '".$direction."'";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}
if($direction == null && $label !=null)
{
    $sql = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku`WHERE `cname` LIKE '%".$label."%'";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}
if($direction !=null && $label !=null)
{
    $sql = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku`WHERE `ctype` = '".$direction."'and `cname` LIKE'%".$label."%'";

    $result = $conn->query($sql);

    $info = array();

    while ($rows = $result->fetch_assoc()) {
        $info[] = $rows;
    }

    echo json_encode($info);
}

$conn->close();