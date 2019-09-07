<?php
/**
 * Created by PhpStorm.
 * User: 67554
 * Date: 2019/7/25
 * Time: 20:10
 */
header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$uphone = $request->uphone;
$upwd = $request->upwd;
$nocheck = $request->nocheck;



$mysqli = new mysqli('localhost', 'root', 'root', 'hlw');
$result = $mysqli->query("SELECT `upwd`,`umname`,`usf` FROM user WHERE `uphone` = "."'$uphone'");
$rs=$result->fetch_row();


function set_token()
{
    global $uphone;
    $admin = $uphone;
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
    global $uphone;
    global $rs;
    global $atoken;
    $ctime=time();
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
            "upwd"=>$rs[0],
            "usf"=>$rs[2],
	    "umname"=>$rs[1],
            "verify"=>true,
            "token"=>set_token(),
            "yz"=>200,
        );
        return $result;
    }
}



if($nocheck)
{
    if (!empty($rs)){
        if ($upwd != $rs[0]) {
            $result=array(
                "verify"=>false,
            );
            echo json_encode($result);
        }else{
            $expire=3*24*3600;
            $_SESSION['uphone']=$uphone;
            ini_set('session.gc_maxlifetime', $expire);//保存3天
            if (empty($_COOKIE['PHPSESSID'])) {
                session_set_cookie_params($expire);
                session_start();
            }else{
                session_start();
                setcookie('PHPSESSID', session_id(), time() + $expire);
            }
            echo json_encode(check_token());

        }
    }else{
        $result=array(
            "verify"=>false,
            "uphone"=>$uphone,
            "upwd"=>$upwd,
        );
        echo json_encode($result);
    }
}
else
{

    if($upwd==$rs[0])
    {
        echo json_encode(check_token());
    }
    else
    {
        $result=array(
            "verify"=>false,
        );
        echo json_encode($result);
    }
}