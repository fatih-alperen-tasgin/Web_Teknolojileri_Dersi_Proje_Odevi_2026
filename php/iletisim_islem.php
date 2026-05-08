<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session tabanlı CSRF için session'ı başlatıyoruz
session_start();

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Session tabanlı CSRF Kontrolü
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        // Güvenlik gereği detay vermiyoruz, sadece log tutuyoruz
        error_log("Geçersiz CSRF denemesi: " . $_SERVER['REMOTE_ADDR']);
        http_response_code(400);
        echo '<body class="server-error-body">';
        echo '<h1>Güvenlik Hatası</h1>';
        echo '<p>Formun süresi dolmuş olabilir. Lütfen sayfayı yenileyip tekrar deneyin.</p>';
        echo '<a href="../iletisim.php" class="link-highlight">Geri Dön ve Tekrar Dene</a>';
        echo '</body>';
        exit();
    }

    // 2. Token kontrol geçti, session'ı yenile (Token Fixation saldırısını önle)
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    $safe = static fn($value) => htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');

    $ad = $safe($_POST['ad'] ?? 'Belirtilmedi');
    $konu = $safe($_POST['konu'] ?? 'Belirtilmedi');
    $mesaj = $safe($_POST['mesaj'] ?? 'Belirtilmedi');

    $emailRaw = trim((string)($_POST['email'] ?? ''));
    $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $safe($emailRaw) : 'Belirtilmedi';

    $allowedCinsiyet = ['Erkek', 'Kadın'];
    $cinsiyetRaw = (string)($_POST['cinsiyet'] ?? '');
    $cinsiyet = in_array($cinsiyetRaw, $allowedCinsiyet, true) ? $safe($cinsiyetRaw) : 'Belirtilmedi';

    $onay = isset($_POST['onay']) ? 'Kabul Edildi' : 'Kabul Edilmedi';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>FatEnTa | Gönderilen Bilgiler</title>
    <link href="../css/style.css" rel="stylesheet"/>
    <link href="../lib/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>
<body class="text-white">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
  <div class="container">
    <a class="navbar-brand" href="../index.html"><i class="fa-solid fa-house"></i></a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../index.html">Hakkında</a></li>
        <li class="nav-item"><a class="nav-link" href="../cv.html">CV</a></li>
        <li class="nav-item"><a class="nav-link" href="../sehir.html">Şehrim</a></li>
        <li class="nav-item"><a class="nav-link active" href="../iletisim.php">İletişim</a></li>
        <li class="nav-item"><a class="nav-link" href="../takimimiz.html">Takımımız</a></li>
        <li class="nav-item"><a class="nav-link" href="../ilgi.html">İlgi Alanım</a></li>
      </ul>
      <div class="ms-auto">
        <a href="../login.php" class="btn btn-outline-warning ms-3"><i class="fa fa-sign-in-alt"></i> Giriş Yap</a>
      </div>
    </div>
  </div>
</nav>

<div class="container my-5">
    <h1 class="text-center mb-5 mt-4">Form Gönderim Sonucu</h1>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-warning text-dark fw-bold py-3">
                    <i class="fa-solid fa-server me-2"></i> Sunucu Tarafı İşlemleri (PHP)
                </div>
                <ul class="list-group list-group-flush text-dark">
                    <li class="list-group-item p-3"><strong>Ad Soyad:</strong> <?php echo $ad; ?></li>
                    <li class="list-group-item p-3"><strong>E-posta:</strong> <?php echo $email; ?></li>
                    <li class="list-group-item p-3"><strong>Cinsiyet:</strong> <?php echo $cinsiyet; ?></li>
                    <li class="list-group-item p-3"><strong>Konu:</strong> <?php echo $konu; ?></li>
                    <li class="list-group-item p-3"><strong>Bilgilendirme Onayı:</strong> <?php echo $onay; ?></li>
                    <li class="list-group-item p-3">
                        <strong>Mesaj:</strong><br>
                        <p class="mt-2 text-muted"><?php echo nl2br($mesaj); ?></p>
                    </li>
                </ul>
            </div>
            <div class="text-center mt-5">
                <a href="../iletisim.php" class="btn btn-outline-light px-5 py-2 rounded-pill">Geri Dön</a>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center py-3 mt-auto fixed-bottom border-top border-secondary">
    <small>&copy; 2026 Fatih Alperen TAŞĞIN. Tüm hakları saklıdır.</small>
</footer>

<script src="../lib/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
} else {
    header("Location: ../iletisim.php");
    exit();
}
?>
