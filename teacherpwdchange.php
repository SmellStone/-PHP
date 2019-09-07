<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/9/4
 * Time: 22:05
 */

header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');


$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uphone = $request->uphone; //手机号
$opwd = $request->opwd;//原密码
$npwd = $request->npwd;//新密码
$rnpwd = $request->rnpwd;//二次确认

//$uphone = '17862178888';
//$opwd = '666666';//原密码
//$npwd = '123456';//新密码
//$rnpwd = '123456';//二次确认

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$stmt = mysqli_stmt_init($conn);

$sql ="SELECT `upwd` FROM `user` WHERE `uphone` = '".$uphone."'";
$result = $conn->query($sql);
$row = $result->fetch_row();
//print_r($row[0]);


if($opwd == $row[0])
{
    if($npwd == $rnpwd)
    {
        $sql1 = "UPDATE `user` SET `upwd` = '".$npwd."' WHERE `uphone` = '".$uphone."'";
        if($conn->query($sql1))
        {
            $result=array(
                "verify"=>true,//修改成功
            );
            echo json_encode($result);
        }
        else
        {
            $result=array(
                "verify"=>202,//前后两次密码不一致
            );
            echo json_encode($result);
        }
    }
}
else
{
    $result=array(
        "verify"=>201,//原密码不正确
    );
    echo json_encode($result);
}

