<?php
header('Content-Type: application/json');

$response = @file_get_contents("https://zenquotes.io/api/random");

if ($response === FALSE) {
    echo json_encode([
        "quote" => "Dështoi marrja e thënies. Provo përsëri më vonë.",
        "author" => "Sistemi"
    ]);
    exit;
}
$data = json_decode($response, true);

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
