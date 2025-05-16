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

    $mesazh = "<b>$tipGabimi:</b> $errstr në file: $errfile, linja: $errline";

    $GLOBALS['error_messages'][] = $mesazh;

    if ($errno === E_USER_ERROR || $errno === E_ERROR) {
        die("<div style='color:red; font-weight:bold;'>Gabim kritik: $errstr</div>");
    }

    return true;
}

set_error_handler("error_handler");
?>
