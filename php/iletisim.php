<?php
// JSON yanıt başlığı
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gelen verileri al (Vue.js verileri JSON formatında gönderir)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($input)) {
    $ad = htmlspecialchars($input['ad'] ?? '');
    $email = htmlspecialchars($input['email'] ?? '');
    $konu = htmlspecialchars($input['konu'] ?? '');
    $mesaj = htmlspecialchars($input['mesaj'] ?? '');

    // Mühendislik Notu: Burada mail() fonksiyonunu kullanabilirsin.
    // Ancak yerel sunucuda (Wamp) mail göndermek için SMTP ayarı gerekir.

    echo json_encode([
        "status" => "success",
        "message" => "Merhaba $ad, mesajın sunucuya ulaştı!"
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Geçersiz istek."
    ]);
}
?>