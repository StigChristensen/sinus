<?php
require_once("globals.php");
$token = TOKEN;
$url = "https://api.instagram.com/v1/users/self/?access_token=".$token;
$userinfo = file_get_contents($url);
echo $userinfo;
?>
