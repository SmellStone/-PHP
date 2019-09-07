<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/27
 * Time: 22:01
 */



header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$suphone = $request->uphone;
$yzm = $request->yzm;

/*$suphone = '15954698669';
$yzm = '7716';*/
$time = date("Y-m-d");


$servername="localhost";
$username="root";
$password="root";
$database="hlw";


function set_token()
{
    global $suphone;
    $admin = $suphone;
    $time = time();
    $end_time = time()+3*24*3600;
    $info = $admin. '.' .$time.'.'.$end_time;//设置token过期时间为3天
    //根据以上信息信息生成签名（密钥为 siasqr)
    $signature = hash_hmac('md5',$info,'siasqr');
    //最后将这两部分拼接起来，得到最终的Token字符串
    $token = $info . '.' . $signature;
    return $token;
}
$atoken=set_token();

function check_token()
{
    global $suphone;
    global $atoken;
    $ctime = time();
    $token = $atoken;
    $explode = explode('.',$token);//以.分割token为数组
    if($ctime>$explode[2])
    {
        $result=array(
            "yz"=>402,
        );
        return $result;
    }
    else
    {
        $result=array(
            "uphone"=>$uphone,
            "usf"=>$rs[2],
	    "umname"=>$rs[1],
            "verify"=>true,
            "token"=>set_token(),
            "yz"=>200,
        );
        return $result;
    }
}




//创建连接
$conn = new mysqli($servername,$username,$password,$database);

//检测连接
if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}
$sql="SELECT `uphone`,`umname`,`usf` FROM `user` where`uphone`='".$suphone."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

//测试查询数据
/*echo $row['uphone'];*/

$sql1="SELECT MAX(yid) FROM `yzm` WHERE `yphone` ='".$suphone."'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
//测试数据
//echo $row1['MAX(yid)'];

$maxyid = intval($row1['MAX(yid)']);
$sql2 = "SELECT `ynum` FROM `yzm` where`yid`='".$maxyid."'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
//测试数据
//echo $row2['ynum'];

if($row['uphone']!=null && $yzm == $row2['ynum'])
{
    echo json_encode(check_token());
}


if($row['uphone'] == null && $yzm == $row2['ynum'])
{
    $sql="INSERT INTO `user` (uphone, upwd, utime, umname, uimg, ucount, uhy, uclass, usf)VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql))
    {
        // 绑定参数
        mysqli_stmt_bind_param($stmt,'sssssssss',$uphone,$upwd,$utime,$umname,$uimg,$ucount,$uhy,$uclass,$usf);

        // 设置参数并执行
        $uphone = $suphone;
        $upwd = '666666';
        $utime = $time;
        $umname = 'musi'.$suphone;
        $uimg = 'http://188.131.173.104/hlw+/头像/info.png';
        $ucount = '0';
        $uhy = '普通';
	$uclass = '1';
	$usf = 's';
        mysqli_stmt_execute($stmt);
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    echo json_encode(check_token());

}

$conn->close();