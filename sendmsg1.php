<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/11
 * Time: 19:53
 */


header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$suphone = $request->uphone;
//$suphone = $_POST["uemail"];

function getVarify(){
    $Array = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9");
    $Varify = $Array[mt_rand(0, 35)];
    return $Varify;
}

function makeVarify(){
    $word1 = getVarify();
    $word2 = getVarify();
    $word3 = getVarify();
    $word4 = getVarify();
    $words = $word1.$word2.$word3.$word4;
    return $words;
}

$yzword = makeVarify();
$yzm = $yzword;

$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$sql="INSERT INTO `yzm` (ynum)VALUES (?);";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数
    mysqli_stmt_bind_param($stmt,'s',$ynum);

    // 设置参数并执行
    $ynum = $yzm;
    mysqli_stmt_execute($stmt);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$Uid = '';
$Key = '';
$smsMob = $suphone;
$smsText = '您的验证码为：'.$yzm.'，请尽快验证，谨防泄漏。';
$url='http://utf8.api.smschinese.cn/?Uid='.$Uid.'&Key='.$Key.'&smsMob='.$smsMob.'&smsText='.$smsText;

function Get($url)
{
    $ch = curl_init();
// curl_init()需要php_curl.dll扩展
    $timeout = 5;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}

if(Get($url)==1)
{
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else
{
    $result=array(
        "verify"=>false,
    );
    echo json_encode($result);
}
