<?php
/**
 * FatEnTa Proje Merkezi Ayar Dosyası
 * Tüm güvenlik ve oturum ayarları buradan yönetilir.
 */

// 1. Hata Raporlama Ayarları (Yayına alırken 0 yapılacak)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Güvenli Session (Oturum) Ayarları
// session_start() çağrılmadan ÖNCE yapılmalıdır.
$cookieParams = [
    'lifetime' => 0,            // Tarayıcı kapanana kadar
    'path' => '/',
    'domain' => '',             // Localhost için boş, domain varsa domain yazılır
    'secure' => false,          // HTTPS kullanıyorsan true yapmalısın
    'httponly' => true,         // JS'nin çerezlere erişmesini engeller (XSS Koruması)
    'samesite' => 'Strict'      // CSRF saldırılarını engellemek için tarayıcı kısıtlaması
];

session_set_cookie_params($cookieParams);

// 3. Oturumu Başlat (Eğer başlatılmamışsa)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 4. Global CSRF Token Yönetimi
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 5. Zaman Dilimi Ayarı
date_default_timezone_set('Europe/Istanbul');
?>