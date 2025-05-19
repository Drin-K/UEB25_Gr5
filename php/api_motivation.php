<?php
header('Content-Type: application/json');

// Thirr API-n me file_get_contents (më i thjeshtë se cURL)
$response = @file_get_contents("https://zenquotes.io/api/random");

// Kontrollo nëse mori përgjigje
if ($response === FALSE) {
    echo json_encode([
        "quote" => "Dështoi marrja e thënies. Provo përsëri më vonë.",
        "author" => "Sistemi"
    ]);
    exit;
}

// Dekodo JSON-in
$data = json_decode($response, true);

// Kontrollo nëse janë të pranishme fushat që duam
if (isset($data[0]['q']) && isset($data[0]['a'])) {
    echo json_encode([
        "quote" => $data[0]['q'],
        "author" => $data[0]['a']
    ]);
} else {
    echo json_encode([
        "quote" => "Nuk u morën të dhënat nga API.",
        "author" => "Sistemi"
    ]);
}
?>
