<?php
/**
 * FatEnTa Proje Merkezi Ayar Dosyası
 * Tüm güvenlik ve oturum ayarları buradan yönetilir.
 */

// 1. Hata Raporlama Ayarları (Yayına alırken 0 yapılacak)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// 2. Güvenli Oturum Ayarları
$cookieParams = [
    'lifetime' => 0,            // Tarayıcı kapatılana kadar geçerli
    'path' => '/',
    'domain' => '',             // Varsayılan olarak geçerli alan adı
    'secure' => false,          // HTTPS kullanıyorsanız true yapın
    'httponly' => true,         // JavaScript erişimini engeller
    'samesite' => 'Strict'      // CSRF Koruması için SameSite özelliği

session_set_cookie_params($cookieParams);

// 3. Oturumu Başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 4. CSRF Token Oluşturma
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 5. Zaman Dilimi Ayarı
date_default_timezone_set('Europe/Istanbul');
?>