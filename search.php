<?php
header("Content-Type: application/json");
require_once "dom.php";
require_once "function.php";
$keyword = sanitize($_GET["keyword"]);
if (strlen($keyword) > 1) {
    $data = scrapeUbuntuPackageSearch($keyword);
    if(! strpos($data->plaintext, "Sorry, your")){
        $response["status"] = true;
        $response["data"]["keyword"] = $keyword;
        $response["message"] = "Paket dengan keyword {$keyword} ditemukan";
    
        foreach ($data->find("a[class=resultlink]") as $key => $element) {
            $packageName = explode("/bionic/", $element->href)[1];
            if ($key == 0) {
                $response["data"]["name"] = $packageName;
                $tmp = strip_tags($data->find("li")[0]);
                $tmp = explode(": 	", $tmp)[1];
                $tmp = explode(" [", $tmp)[0];
                $tmp = explode("  ", $tmp)[0];
                $description = explode(" (", $tmp)[0];
                $response["data"]["description"] = $description;
            } else {
                $response["data"]["related_results"][$key-1] = $packageName;
            }
        }
    } else {
        $response["status"] = false;
        $response["data"]["keyword"] = $keyword;
        $response["data"]["name"] = null;
        $response["data"]["description"] = null;
        $response["data"]["related_results"] = [];
        $response["message"] = "Paket tidak ditemukan, silahkan periksa kembali kata kunci pencarian anda";
    }
} else {
    $response["status"] = false;
    $response["data"]["keyword"] = $keyword;
    $response["data"]["name"] = null;
    $response["data"]["description"] = null;
    $response["data"]["related_results"] = [];
    $response["message"] = "Masukkan kata kunci minimal 2 karakter";
}
echo json_encode($response);
?>