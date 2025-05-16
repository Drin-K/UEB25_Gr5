<?php
header('Content-Type: application/json');

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://zenquotes.io/api/random",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => false, // Nëse ke problem me SSL certifikatat në localhost
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo json_encode([
        "quote" => "Dështoi marrja e thënies. Provo përsëri më vonë.",
        "author" => "Sistemi"
    ]);
    curl_close($curl);
    exit;
}

curl_close($curl);

// API kthen një array me një element të vetëm
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
