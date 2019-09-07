<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/23
 * Time: 23:08
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$cfy =$request->cfy;


//$cfy = 'sy';

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

$conn = new mysqli($servername,$username,$password,$database);

$sql = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku`WHERE `cfy` = '".$cfy."'";

$result = $conn->query($sql);

$info = array();

while ($rows = $result->fetch_assoc()) {
    $info[] = $rows;
}

echo json_encode($info);