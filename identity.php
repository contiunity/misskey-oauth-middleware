<?php
function send_post_json($url, $json)
{
    $jsonStr = json_encode($json);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($jsonStr)
        )
    );
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return json_decode($response,true);
}

if(!isset($_REQUEST["access_token"])){
    die();
}

$misskey_return = send_post_json("https://fedi.openclipsis.top/api/i",array("i"=>$_REQUEST["access_token"]));

die(json_encode(array(
    "id"=>(int)(base_convert(substr(md5($misskey_return["id"]),3,8),16,10)),
    "name"=>$misskey_return["username"],
    "nickname"=>$misskey_return["name"],
    "avatar_url"=>$misskey_return["avatarUrl"],
    "url"=>"https://fedi.openclipsis.top/users/".$misskey_return["id"],
    "html_url"=>"https://fedi.openclipsis.top/users/".$misskey_return["id"],
    "email"=>"misskey.".$misskey_return["id"]."@noreply.openclipsis.top"
)));
?>
