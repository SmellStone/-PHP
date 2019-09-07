<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/26
 * Time: 1:00
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');
header("Content-Type:text/html;charset=UTF-8");

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

$conn = new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `ctype` = '计算机' ORDER BY `chot` DESC LIMIT 5";
$sql1 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `ctype` = '外语' ORDER BY `chot` DESC LIMIT 5";
$sql2 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `ctype` = '管理' ORDER BY `chot` DESC LIMIT 5";
$sql3 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `ctype` = '经济学' ORDER BY `chot` DESC LIMIT 5";
$sql4 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `ctype` = '工学' ORDER BY `chot` DESC LIMIT 5";
$sql5 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `ctype` = '理学' ORDER BY `chot` DESC LIMIT 5";
$sql6 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `ctype` = '期末冲刺' ORDER BY `chot` DESC LIMIT 5";
$sql7 = "SELECT `cid`,`cname`,`cteacher`,`cfy`,`cimg`,`cschool`,`cgaishu` FROM `courseku` WHERE `ctype` = '考研' ORDER BY `chot` DESC LIMIT 5";



$result = $conn->query($sql);
$info = array();
while ($rows = $result->fetch_assoc()) {
    $info[] = $rows;
}

$result1 = $conn->query($sql1);
$info1 = array();
while ($rows1 = $result1->fetch_assoc()) {
    $info1[] = $rows1;
}

$result2 = $conn->query($sql2);
$info2 = array();
while ($rows2 = $result2->fetch_assoc()) {
    $info2[] = $rows2;
}

$result3 = $conn->query($sql3);
$info3 = array();
while ($rows3 = $result3->fetch_assoc()) {
    $info3[] = $rows3;
}

$result4 = $conn->query($sql4);
$info4 = array();
while ($rows4 = $result4->fetch_assoc()) {
    $info4[] = $rows4;
}

$result5 = $conn->query($sql5);
$info5 = array();
while ($rows5 = $result5->fetch_assoc()) {
    $info5[] = $rows5;
}

$result6 = $conn->query($sql6);
$info6 = array();
while ($rows6 = $result6->fetch_assoc()) {
    $info6[] = $rows6;
}

$result7 = $conn->query($sql7);
$info7 = array();
while ($rows7 = $result7->fetch_assoc()) {
    $info7[] = $rows7;
}

$info8 =array($info,$info2,$info3,$info4,$info5,$info6,$info7);
echo json_encode($info8);



/*print_r($info);echo '<br>';
print_r($info1);echo '<br>';
print_r($info2);echo '<br>';
print_r($info3);echo '<br>';
print_r($info4);echo '<br>';
print_r($info5);echo '<br>';
print_r($info6);echo '<br>';
print_r($info7);echo '<br>';*/
