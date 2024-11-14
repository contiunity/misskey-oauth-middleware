<?php
if(!isset($_REQUEST["redirect_uri"])){
    die();
}
$redirect = $_REQUEST["redirect_uri"];
if(!isset($_REQUEST["state"])){
    $_REQUEST["state"] = "";
}
$orig_state = $_REQUEST["state"];

function  uuid()  {  
    $chars = md5(uniqid(mt_rand(), true));  
    $uuid = substr ( $chars, 0, 8 ) . '-'
            . substr ( $chars, 8, 4 ) . '-' 
            . substr ( $chars, 12, 4 ) . '-'
            . substr ( $chars, 16, 4 ) . '-'
            . substr ( $chars, 20, 12 );  
    return $uuid ;  
}  

$session = uuid();
$callback = urlencode("https://discuz.openclipsis.top/delegation/misskey-auth/apply.php?redirect=".urlencode($redirect)."&session=$session&state=$orig_state");
$miauth = "https://fedi.openclipsis.top/miauth/$session?name=SimpleAuth&callback=$callback&permission=read:account";

header("Location: $miauth");
?>
