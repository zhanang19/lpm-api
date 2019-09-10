<?php
header("Content-Type: application/json");
require_once "dom.php";
require_once "function.php";
$packageName = sanitize($_GET["name"]);
$data = scrapeAlldebDownload($packageName);
if(strpos($data->plaintext, "Maaf") == false){
    $body = $data->find("a");
    $response["status"] = true;
    $response["message"] = "Paket berhasil diunduh";
    $response["data"]["name"] = $packageName;
    $response["data"]["link"] = "https://www.alldeb.net{$body[3]->href}";
    for($a = 1; $a < 5; $a++){
        $tmp = explode(" : ", $data->find("div")[0]->find("div")[6]->find("div")[0]->find("div")[2]->find("div")[0]->find("p")[$a]->plaintext);
        $response["data"]["detail"][strtolower(str_replace(" ", "_", $tmp[0]))] = $tmp[1];
    }
} else {
    $response["status"] = false;
    $response["message"] = "Paket tidak ditemukan";
    $response["data"]["name"] = $packageName;
    $response["data"]["link"] = null;
    $response["data"]["detail"] = [];
}
echo json_encode($response);
?>