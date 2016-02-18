<?php
require_once("globals.php");
$token = TOKEN;
$url = "https://api.instagram.com/v1/users/self/media/recent/?access_token=".$token;
$userfeed = file_get_contents($url);
echo $userfeed;
?>
