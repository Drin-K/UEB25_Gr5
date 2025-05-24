<?php
$GLOBALS['error_messages'] = [];

function error_handler($errno, $errstr, $errfile, $errline) {
    $llojGabimi = [
        E_USER_WARNING => "Paralajmërim",
        E_USER_ERROR => "Gabim",
        E_USER_NOTICE => "Njoftim",
        E_WARNING => "Paralajmërim i sistemit",
        E_ERROR => "Gabim i sistemit",
        E_NOTICE => "Njoftim i sistemit"
    ];
    
    $tipGabimi = isset($llojGabimi[$errno]) ? $llojGabimi[$errno] : "Gabim i panjohur";

    $mesazh = "$tipGabimi: $errstr në file: $errfile, linja: $errline";

    error_log("[".date('Y-m-d H:i:s')."] $mesazh\n", 3, __DIR__ . '/error_log.log');

    if ($errno === E_USER_WARNING) {
    } elseif ($errno === E_USER_ERROR) {
        die("<div style='color:red; font-weight:bold;'>Ndodhi një gabim i rëndë. Ju lutem provoni përsëri më vonë.</div>");
    }

    return true;
}

set_error_handler("error_handler");
?>
