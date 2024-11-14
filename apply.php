<?php
if(isset($_REQUEST["grant_type"])){
    if(isset($_REQUEST["code"])){
        die('{"access_token":"'.$_REQUEST["code"].'","refresh_token":"'.$_REQUEST["code"].'"}');
    }
    if(isset($_REQUEST["refresh_token"])){
        die('{"access_token":"'.$_REQUEST["refresh_token"].'","refresh_token":"'.$_REQUEST["refresh_token"].'"}');
    }
    die('');
}
if(!isset($_REQUEST["redirect"]) || !isset($_REQUEST["session"]) || !isset($_REQUEST["state"])){
    die();
}

$options = array(
'http' => array(
'method' => 'POST',
'content' => "",
'timeout' => 15 * 60 // 超时时间（单位:s）
)
);
$context = stream_context_create($options);

$perm = json_decode(file_get_contents("https://fedi.openclipsis.top/api/miauth/".$_REQUEST["session"]."/check",false,$context),true);

if(!$perm["ok"]){
    die();
}

$token = $perm["token"];
header("Location: ".$_REQUEST["redirect"]."?code=$token&state=".$_REQUEST["state"])
?>
