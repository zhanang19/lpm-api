<?php

function sanitize($string = '') {
    return preg_replace('/[^\da-z-_]/i', '', $string);
}

function baseUrl() {
    return "http://localhost/lpm-api";
}

function scrapeUbuntuPackageSearch($keyword = '') {
    $arrContextOptions = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];
    return str_get_html(file_get_contents("https://packages.ubuntu.com/search?suite=bionic&section=all&arch=any&keywords={$keyword}&searchon=names", false, stream_context_create($arrContextOptions)));
}

function scrapeAlldebSearch($keyword = '') {
    $arrContextOptions = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];
    return str_get_html(file_get_contents("https://www.alldeb.net/webmaker/cari-bionic?aplikasi={$keyword}", false, stream_context_create($arrContextOptions)));
}

function scrapeAlldebDownload($packageName = '') {
    $arrContextOptions = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];
    return str_get_html(file_get_contents("https://www.alldeb.net/webmaker/bionic?varian=ubuntu&arsitektur=amd64&aplikasi={$packageName}", false, stream_context_create($arrContextOptions)));
}

function getIconLink($packageName = '') {
    $arrContextOptions = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];
    $baseUrl = 'https://raw.githubusercontent.com/PapirusDevelopmentTeam/papirus-icon-theme/master/Papirus/64x64/apps/';
    $baseExtension = '.svg';
    $link = $baseUrl . $packageName . $baseExtension;
    $data = file_get_contents($link, false, stream_context_create($arrContextOptions));
    if ($data == false) {
        return baseUrl() . '/default' . $baseExtension;
    } else {
        return $link;
    }
}