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

    // Mesazhi i plote i gabimit, i cili do te ruhet ne log file
    $mesazh = "$tipGabimi: $errstr në file: $errfile, linja: $errline";

    // Ruaj gabimin ne nje file log (mund ta ndryshosh path sipas nevojes)
    error_log("[".date('Y-m-d H:i:s')."] $mesazh\n", 3, __DIR__ . '/error_log.log');

    // Për përdoruesin, shfaq vetëm mesazhe të thjeshta, pa të dhëna teknike:
    if ($errno === E_USER_WARNING) {
        // paralajmërim të thjeshtë, mos ndalo skriptin
        // mos bëj asgjë, sepse e ke $error të printuar në faqen kryesore
    } elseif ($errno === E_USER_ERROR) {
        // Gabim kritik, ndalo ekzekutimin
        die("<div style='color:red; font-weight:bold;'>Ndodhi një gabim i rëndë. Ju lutem provoni përsëri më vonë.</div>");
    }

    // Nëse është gabim tjetër, mos e ndalo skriptin
    return true;
}

set_error_handler("error_handler");
?>
