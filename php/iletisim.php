<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basit CSRF double-submit kontrolü: cookie ile POST içindeki token eşleşmeli
    $postToken = $_POST['csrf_token'] ?? '';
    $cookieToken = $_COOKIE['csrf_token'] ?? '';
    if (empty($postToken) || empty($cookieToken) || !hash_equals((string)$cookieToken, (string)$postToken)) {
        // Geçersiz token - güvenlik nedeni ile işlemi sonlandır
        http_response_code(400);
        echo '<!doctype html><html><head><meta charset="utf-8"><title>Geçersiz İstek</title></head><body style="background:#1c2533;color:#fff;padding:2rem;"><h1>Geçersiz veya eksik güvenlik tokeni.</h1><p>Lütfen formu tekrar doldurup gönderin.</p><p><a href="../iletisim.html" style="color:#ffd966;">Geri dön</a></p></body></html>';
        exit();
    }
    $safe = static fn($value) => htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');

    $ad = $safe($_POST['ad'] ?? 'Belirtilmedi');
    $konu = $safe($_POST['konu'] ?? 'Belirtilmedi');
    $mesaj = $safe($_POST['mesaj'] ?? 'Belirtilmedi');

    $emailRaw = trim((string)($_POST['email'] ?? ''));
    $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $safe($emailRaw) : 'Belirtilmedi';

    $allowedCinsiyet = ['Erkek', 'Kadın'];
    $cinsiyetRaw = (string)($_POST['cinsiyet'] ?? '');
    $cinsiyet = in_array($cinsiyetRaw, $allowedCinsiyet, true) ? $safe($cinsiyetRaw) : 'Belirtilmedi';

    $allowedSehir = ['Sakarya', 'Konya'];
    $sehirRaw = (string)($_POST['sehir'] ?? '');
    $sehir = in_array($sehirRaw, $allowedSehir, true) ? $safe($sehirRaw) : 'Belirtilmedi';

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
        <li class="nav-item"><a class="nav-link active" href="../iletisim.html">İletişim</a></li>
        <li class="nav-item"><a class="nav-link" href="../takimimiz.html">Takımımız</a></li>
        <li class="nav-item"><a class="nav-link" href="../ilgi.html">İlgi Alanım</a></li>
      </ul>
      <div class="ms-auto">
        <a href="../login.html" class="btn btn-outline-warning ms-3"><i class="fa fa-sign-in-alt"></i> Giriş Yap</a>
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
                    <li class="list-group-item p-3"><strong>Şehir:</strong> <?php echo $sehir; ?></li>
                    <li class="list-group-item p-3"><strong>Konu:</strong> <?php echo $konu; ?></li>
                    <li class="list-group-item p-3"><strong>Bilgilendirme Onayı:</strong> <?php echo $onay; ?></li>
                    <li class="list-group-item p-3">
                        <strong>Mesaj:</strong><br>
                        <p class="mt-2 text-muted"><?php echo nl2br($mesaj); ?></p>
                    </li>
                </ul>
            </div>
            <div class="text-center mt-5">
                <a href="../iletisim.html" class="btn btn-outline-light px-5 py-2 rounded-pill">Geri Dön</a>
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
    header("Location: ../iletisim.html");
    exit();
}
?>