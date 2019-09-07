<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/24
 * Time: 23:56
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$course = $request->course;
//$course = '数据结构';


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql = "SELECT `cid`,`cname`,`cjieshao`,`cjianjie`,`cgaishu`,`cteacher`,`cdengji`,`cgonggao`,`cimg`,`cschool` FROM `courseku`WHERE `cname` = '".$course."'";

$result = $conn->query($sql);
$rows=$result->fetch_row();
//echo json_encode($rows);
//print_r($rows);

$sql3 = "SELECT COUNT(*) FROM `chapterlist` WHERE `course` = '".$course."'";
$result3 = $conn->query($sql3);
$rows3=$result3->fetch_row();
//print_r($rows3[0]);

$info = array();

for($i = 1;$i<=$rows3[0];$i++ )
{
    $sql4 = "SELECT `chapter` FROM `chapterlist` WHERE `uid` = '".$i."' AND `course` = '".$course."'";
    $result4 = $conn->query($sql4);
    $rows4 = $result4->fetch_row();
    for($k = 1;$k<=$rows3[0];$k++)
    {
        $sql5 = "SELECT `mid`,`knobble` FROM `courselist` WHERE `course` = '".$course."' AND `cid` = '".$k."' ORDER BY `mid` ASC";
        $result5 = $conn->query($sql5);
        $info5 = array();
        while ($rows5 = $result5->fetch_assoc()) {
            $info5[] = $rows5;
        }
        $info6[$k]=array($info5);
    }
    $info[$i] = array('0'=>$rows4[0],'1'=>$info6[$i]);
}

$info3 = array($rows,$info);

echo json_encode($info3);
//print_r($info3);

$conn->close();