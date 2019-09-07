<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/1
 * Time: 23:21
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uphone = $request->uphone;
$umname = $request->umname;
$usex = $request->usex;
$uintroduce = $request->uintroduce;
$uname = $request->uname;
$uqq = $request->uqq;



$servername="localhost";
$username="root";
$password="root";
$database="hlw";

$conn=new mysqli($servername,$username,$password,$database);

//检测连接
if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}

$stmt = mysqli_stmt_init($conn);

$spn = true;
$sx = true;
$sndc = true;
$snm = true;
$sqq = true;

if($umname != null)
{
    $sql = "UPDATE `user` SET `umname` = '".$umname."' WHERE `uphone` = '".$uphone."'";
   if( $conn->query($sql))
    {
        $spn = true;
    }
    else
    {
        $spn = false;
    }
}

if($usex != null)
{
    $sql = "UPDATE `user` SET `usex` = '".$usex."' WHERE `uphone` = '".$uphone."'";
    if( $conn->query($sql))
    {
        $sx = true;
    }
    else
    {
        $sx = false;
    }
}

if($uintroduce != null)
{
    $sql = "UPDATE `user` SET `uintroduce` = '".$uintroduce."' WHERE `uphone` = '".$uphone."'";
    if( $conn->query($sql))
    {
        $sndc = true;
    }
    else
    {
        $sndc = false;
    }
}

if($uname != null)
{
    $sql = "UPDATE `user` SET `uname` = '".$uname."' WHERE `uphone` = '".$uphone."'";
    if( $conn->query($sql))
    {
        $snm = true;
    }
    else
    {
        $snm = false;
    }
}

if($uqq != null)
{
    $sql = "UPDATE `user` SET `uqq` = '".$uqq."' WHERE `uphone` = '".$uphone."'";
    if( $conn->query($sql))
    {
        $sqq = true;
    }
    else
    {
        $sqq = false;
    }
}

if($spn && $sndc && $snm && $sqq && $sx)
{
    $resulet = array(
        "update"=> true,
    );
    echo json_encode($resulet);
}
else
{
    $resulet = array(
        "update"=> false,
    );
    echo json_encode($resulet);
}