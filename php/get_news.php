<?php
// php/get_news.php
require_once 'config.php'; // veya config.php

// 1. API Anahtarını burada tanımlıyoruz (Kimse göremez)
$apiKey = "pub_db90c0b2fb864522b3f272cbff4ec12e";
$query = "galatasaray";
$language = "tr";

$apiUrl = "https://newsdata.io/api/1/news?apikey=" . $apiKey . "&language=" . $language . "&q=" . urlencode($query);

// 2. Haberleri çek (cURL veya file_get_contents)
// 2b. Prefer cURL for reliability
$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_TIMEOUT => 8,
	CURLOPT_FAILONERROR => false, // handle HTTP errors manually
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_SSL_VERIFYHOST => 2,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);

// If curl has an SSL certificate problem (common on Windows dev), retry once
// with relaxed verification so the dev site still works. Log the original error.
if ($response === false && !empty($curlErr) && stripos($curlErr, 'SSL') !== false) {
	error_log("get_news.php: SSL verification failed for upstream, retrying with relaxed verification. Error: $curlErr");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$curlErr2 = curl_error($ch);
	if ($response === false) {
		// keep the most useful error message
		$curlErr = $curlErr2 ?: $curlErr;
	} else {
		// success on retry: clear error
		$curlErr = '';
	}
}

curl_close($ch);

header('Content-Type: application/json');
if ($response === false || $httpCode >= 400) {
	// Return a JSON error object (client will handle gracefully)
	http_response_code(502);
	echo json_encode(['results' => [], 'error' => 'Upstream API hata', 'details' => $curlErr ?: "HTTP $httpCode"]);
	exit;
}

// 3. Yanıtı olduğu gibi döndür (API zaten JSON dönüyor)
echo $response;
?>