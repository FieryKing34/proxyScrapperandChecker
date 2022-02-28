<?php 
const BR = "<br>";

$status = "";
if (isset($_GET['proxy'])){
    if(isset($_GET['timeout'])){
        $timeout = intval($_GET['timeout']);
    } else{
        $timeout = 10;
    }
    $proxy = $_GET['proxy'];
    $proxyparts = explode(":", $proxy);
    $ip = $proxyparts[0];
    $port = $proxyparts[1];
    $url = 'https://google.com/';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    $error = curl_error($ch);
    $res = json_decode($result);
    curl_close($ch);
    if (strpos($error, 'Connection timed out') !== false){
        $status = "proxy dead";
    } elseif($error == ""){
        $status = "proxy live";
    } else{
        echo $error;
        $status = BR."status unknown";
    } echo json_encode($status);
} else{
    echo "pls enter proxy";
}


function pre_r($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
?>