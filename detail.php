<?php
header('Content-Type: application/json');
require "dom.php";
require "function.php";
$arrContextOptions = [
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ]
];
$app = $_GET['name'];
if (strlen($app) > 1) {
    $data = scrapeUbuntuPackageSearch($app);
    
    if (! strpos($data->plaintext, "Sorry, your") or ! strpos($data->plaintext, "keyword not valid")) {
        $data2 = scrapeAlldebSearch($app);
        $response['status'] = true;
        $response["message"] = "";
        $response["data"]["name"] = $app;
        $response["data"]["icon"] = getIconLink($app);

        $tmp = strip_tags($data->find('li')[0]);
        $tmp = explode(': 	', $tmp)[1];
        $tmp = explode(' [', $tmp)[0];
        $tmp = explode('  ', $tmp)[0];
        $tmp = explode(' (', $tmp)[0];
        $response["data"]["description"]["snapshot"] = $tmp;

        $tmp = $data2->find('em')[0]->plaintext;
        $tmp = explode('"  ', $tmp)[1];
        $tmp = explode(' "', $tmp)[0];
        $tmp = explode('Between the suggested packages', $tmp)[0];
        $tmp = preg_replace('/\s+/', ' ', $tmp);

        $response["data"]["description"]["full"] = $tmp;
    } else {
        $response["status"] = false;
        $response["data"]["name"] = $app;
        $response["message"] = "Paket tidak ditemukan, silahkan periksa kembali kata kunci pencarian";
    }
        
} else {
    $response["status"] = false;
    $response["message"] = "Masukkan kata kunci minimal 2 karakter";
    $response["data"]["name"] = $app;
}
echo json_encode($response);
?>