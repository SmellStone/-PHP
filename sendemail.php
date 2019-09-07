<?php

/*发送邮件方法

 *@param $to：接收者 $title：标题 $content：邮件内容

 *@return bool true:发送成功 false:发送失败

 */
header('Access-Control-Allow-Origin:*');
header('Content-Type:text/json; charset=UTF-8');


//$postdata = file_get_contents("php://input");
//$request = json_decode($postdata);
//$email = $request->uemail;

$email = $_POST["uemail"];


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

//测试生成验证码函数
//echo makeVarify();
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



function sendMail($to,$title,$content) {

    // 封装的类库可以直接调用

    require 'C:/phpstudy_pro/WWW/hlw+/PHPMailer/PHPMailerAutoload.php';



    $mail = new PHPMailer;

    //使用smtp鉴权方式发送邮件

    $mail->isSMTP();

    //smtp需要鉴权 这个必须是true

    $mail->SMTPAuth = true;

    // qq 邮箱的 smtp服务器地址，这里当然也可以写其他的 smtp服务器地址

    $mail->Host = 'smtp.qq.com';

    //smtp登录的账号 这里填入字符串格式的qq号即可

    $mail->Username = '1208984737@qq.com';

    // 授权码，一共16位

    $mail->Password = 'ewbzwifjwhdrhbbj';

    $mail->setFrom('1208984737@qq.com', '智慧校园');

    // $to 为收件人的邮箱地址，如果想一次性发送向多个邮箱地址，则只需要将下面这个方法多次调用即可

    $mail->addAddress($to);

    // 该邮件的主题

    $mail->Subject = $title;

    // 该邮件的正文内容

    $mail->Body = $content;



    // 使用 send() 方法发送邮件

    if(!$mail->send()) {

        return 'false ' . $mail->ErrorInfo;

    } else {

        return "true";

    }

}

try {
    $last= sendMail($email,'智慧校园验证码','您的验证码为：'.$yzword.'请及时使用，避免泄露。【星梦教育】为您提供优质的在线视频学习服务，获取更多信息请登陆官网。');
    $result=array(
        "verify"=>$last,
    );
    echo json_encode($result);
} catch (Exception $e) {
    print $e->getMessage();
    $result=array(
        "verify"=>false,
    );
    echo json_encode($result);
    exit();
}

// 调用发送方法，并在页面上输出发送邮件的状态

/*echo sendMail('675548733@qq.com','智慧校园验证码','您的验证码为：'.$yzword.'请及时使用，避免泄露。【星梦教育】为您提供优质的在线视频学习服务，获取更多信息请登陆官网。');*/