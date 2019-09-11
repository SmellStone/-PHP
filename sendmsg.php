<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/8/27
 * Time: 16:00
 */


//开启SESSION
session_start();

header("Content-type:text/html; charset=UTF-8");
header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$mobile = $request->uphone;

//$mobile ='15954698669';

//请求数据到短信接口，检查环境是否 开启 curl init。
function Post($curlPost,$url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    $return_str = curl_exec($curl);
    curl_close($curl);
    return $return_str;
}

//将 xml数据转换为数组格式。
function xml_to_array($xml){
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if(preg_match_all($reg, $xml, $matches)){
        $count = count($matches[0]);
        for($i = 0; $i < $count; $i++){
            $subxml= $matches[2][$i];
            $key = $matches[1][$i];
            if(preg_match( $reg, $subxml )){
                $arr[$key] = xml_to_array( $subxml );
            }else{
                $arr[$key] = $subxml;
            }
        }
    }
    return $arr;
}

//random() 函数返回随机整数。
function random($length = 6 , $numeric = 0) {
    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
    if($numeric) {
        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
    } else {
        $hash = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
    }
    return $hash;
}

//短信接口地址
$target = "http://106.ihuyi.com/webservice/sms.php?method=Submit";

//生成的随机数
$mobile_code = random(4,1);


$servername="localhost";
$username="root";
$password="root";
$database="hlw";

//创建连接
$conn=new mysqli($servername,$username,$password,$database);
$sql="INSERT INTO `yzm` (ynum, yphone)VALUES (?, ?);";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    // 绑定参数
    mysqli_stmt_bind_param($stmt,'ss',$ynum,$yphone);

    // 设置参数并执行
    $ynum = $mobile_code;
    $yphone = $mobile;
    mysqli_stmt_execute($stmt);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



if(empty($mobile)){
    exit('手机号码不能为空');
}
//防用户恶意请求
/*if(empty($_SESSION['send_code']) or $send_code!=$_SESSION['send_code']){
    exit('请求超时，请刷新页面后重试');
}*/

$post_data = "account=通行证&password=密码&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
//查看用户名 登录用户中心->验证码通知短信>产品总览->API接口信息->APIID
//查看密码 登录用户中心->验证码通知短信>产品总览->API接口信息->APIKEY
$gets =  xml_to_array(Post($post_data, $target));

/*if($gets['SubmitResult']['code']==2){
    $_SESSION['mobile'] = $mobile;
    $_SESSION['mobile_code'] = $mobile_code;
}*/

if($gets['SubmitResult']['code']==2)
{
    $result=array(
        "verify"=>true,
    );
    echo json_encode($result);
}
else
{
    $result=array(
        "verify"=>$gets['SubmitResult']['code'],
    );
    echo json_encode($result);
}
