<?php
// Güvenlik: session cookie parametrelerini oturum başlamadan önce ayarla
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. CSRF Kontrolü (Session tabanlı)
$postToken = $_POST['csrf_token'] ?? '';
$sessionToken = $_SESSION['csrf_token'] ?? '';

if (empty($postToken) || empty($sessionToken) || !hash_equals($sessionToken, $postToken)) {
    // Hata mesajı kullanıcıya genel olarak iletilir; hassas token değerleri görünmez.
    // Detaylı bilgi gerekiyorsa sunucu log'una yazılmalıdır.
    error_log("CSRF token mismatch. POST token present=" . (empty($postToken) ? 'no' : 'yes') . ", session token present=" . (empty($sessionToken) ? 'no' : 'yes'));
    http_response_code(400);
    die("Güvenlik hatası: İstek doğrulanamadı. Lütfen formu yenileyip tekrar deneyin.");
}

$kullanici = isset($_POST['kullanici']) ? trim($_POST['kullanici']) : '';
$sifre = isset($_POST['sifre']) ? trim($_POST['sifre']) : '';

// Production simülasyonu: Bu örnekte kullanıcı ve parola sabit olarak tutuluyor.
// Gerçek uygulamada şifrelenmiş (hashed) şifreler veritabanında saklanmalı ve
// burada password_verify ile doğrulanmalıdır. Sabit parolayı kaydetmek
// kaynak kodunda güvenlik riskidir; bu proje için demonstratif bırakılmıştır.
$dogru_mail = "b241210079@sakarya.edu.tr";
// NOT: Aşağıdaki şekilde her istek için password_hash çağırmak çalışır ama
// ideal olanı DB'de önceden hesaplanmış hash'i saklamaktır. Burada mevcut yapıyı
// bozmamak için önceden hesaplanmış hash yerine runtime hash kullanıyoruz.
$hashed_password = password_hash("b241210079", PASSWORD_BCRYPT);

if ($kullanici === $dogru_mail && password_verify($sifre, $hashed_password)) {
    // OTURUM BİLGİLERİNİ GÜVENLİ ŞEKİLDE KAYDET
    session_regenerate_id(true);

    $display = "b241210079";
    $_SESSION['isLoggedIn'] = true;
    $_SESSION['userDisplay'] = $display;

    // Sonraki isteklerde de CSRF güvenli kalsın
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Ödev şartı: Başarılı girişte Hoşgeldiniz ekranı göster
    ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Hos Geldiniz | FatEnTa</title>
        <link href="../css/style.css" rel="stylesheet" />
        <link href="../lib/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../lib/css/all.min.css" rel="stylesheet" />
        <script>
            localStorage.setItem('isLoggedIn', 'true');
            localStorage.setItem('userDisplay', <?php echo json_encode($display); ?>);
        </script>
    </head>
    <body class="bg-dark text-white d-flex align-items-center justify-content-center min-vh-100">
        <div class="card auth-card p-4 shadow-lg border-0 bg-secondary bg-opacity-10 text-white text-center">
            <i class="fa-solid fa-circle-check text-success fa-4x mb-3"></i>
            <h1 class="fw-bold">Hosgeldiniz <?php echo htmlspecialchars($display, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="text-white-50 mb-4">Sisteme basariyla giris yaptiniz.</p>
            <a href="../index.html" class="btn btn-warning fw-bold">Ana Sayfaya Don</a>
        </div>
    </body>
    </html>
    <?php
    exit();
} else {
    // HATALI GİRİŞ: Doğrudan login sayfasına geri gönder
    header("Location: ../login.php?hata=1");
    exit();
}
?>
