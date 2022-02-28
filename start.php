<?php

//--------------------scrapping proxies-------------------//

$pages = array(file_get_contents('https://www.us-proxy.org/'), file_get_contents('https://free-proxy-list.net/'));
$allpages = implode("", $pages);

preg_match_all('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\:[0-9]{1,5}/', $allpages, $matches);
$proxies = array_values(array_unique($matches[0]));
//----------------------end scrapping proxies-------------//

//---------------cURL Multi-------------------//
$mh = curl_multi_init();
foreach($proxies as $key => $proxy){
    $name = 'ch'.$key;
    $$name = curl_init();
    curl_setopt_array($$name, array(
        CURLOPT_URL => 'checker.php'.'?proxy='.$proxy.'&timeout=10', // The url is just crated for the purpose of example. instead of the string 'checker.php' it should  be the path of the file checker.php that I have included in the repo.
        CURLOPT_RETURNTRANSFER => true
    ));
    curl_multi_add_handle($mh, $$name);
}
do {
    $result = curl_multi_exec($mh, $active);
    if ($active) {
        // Wait a short time for more activity
        curl_multi_select($mh);
    }
} while ($active && $result == CURLM_OK);
curl_multi_close($mh);
print_r($result);
//---------------end cURL Multi------------------//
?>
