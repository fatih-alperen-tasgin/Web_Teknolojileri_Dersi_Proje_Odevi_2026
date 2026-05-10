<?php
require_once 'config.php';

// 1. CSRF Token Doğrulaması
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("Güvenlik ihlali: Geçersiz Token.");
}

$kullanici = $_POST['kullanici'] ?? '';
$sifre = $_POST['sifre'] ?? '';

// 2. Giriş Bilgilerini Doğrulama
$dogru_mail = "b241210079@sakarya.edu.tr";
$dogru_sifre = "b241210079";
$display = "b241210079";

if ($kullanici === $dogru_mail && $sifre === $dogru_sifre) {
    $_SESSION['isLoggedIn'] = true;
    $_SESSION['userDisplay'] = $display;
    ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Hoş Geldiniz | FatEnTa</title>
        <link href="../lib/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../lib/css/all.min.css" rel="stylesheet" />
        <script>
            localStorage.setItem('isLoggedIn', 'true');
            localStorage.setItem('userDisplay', <?php echo json_encode($display); ?>);
        </script>
    </head>
    <body class="bg-dark text-white d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-5 shadow-lg border-0 bg-secondary bg-opacity-10 text-white text-center" style="max-width: 500px; border-radius: 20px;">
            <i class="fa-solid fa-circle-check text-success fa-5x mb-4"></i>
            <h1 class="fw-bold mb-2">Hoş Geldiniz</h1>
            <h2 class="text-warning mb-4"><?php echo htmlspecialchars($display, ENT_QUOTES, 'UTF-8'); ?></h2>
            <p class="text-white-50 mb-4">Sisteme başarıyla giriş yaptınız.</p>
            <a href="../index.html" class="btn btn-warning px-5 fw-bold rounded-pill">Ana Sayfaya Dön</a>
        </div>
    </body>
    </html>
    <?php
    exit();
} else {
    header("Location: ../login.php?hata=1");
    exit();
}
?>