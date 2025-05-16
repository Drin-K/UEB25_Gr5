<?php
function error_handler($errno, $errstr, $errfile, $errline, $errcontext) {

    $llojGabimi = [
        E_USER_WARNING => "Paralajmërim",
        E_USER_ERROR => "Gabim",
        E_USER_NOTICE => "Njoftim"
    ];
    
    $tipGabimi = isset($llojGabimi[$errno]) ? $llojGabimi[$errno] : "Gabim i panjohur";
    
    echo "<b>$tipGabimi:</b> $errstr në file: $errfile, linja: $errline<br>";
}

set_error_handler("error_handler");
?>
