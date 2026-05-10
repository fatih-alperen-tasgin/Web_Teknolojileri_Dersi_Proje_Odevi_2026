<?php
require_once 'config.php';

// Formun POST ile gönderildiğinden emin olalım
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. CSRF Token Doğrulaması
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Güvenlik Hatası: Geçersiz Token!");
    }

    // 2. Kullanıcıdan Gelen Verileri Güvenli Hale Getirme
    $ad = htmlspecialchars($_POST['ad'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $konu = htmlspecialchars($_POST['konu'] ?? '', ENT_QUOTES, 'UTF-8');
    $mesaj = htmlspecialchars($_POST['mesaj'] ?? '', ENT_QUOTES, 'UTF-8');
    $cinsiyet = htmlspecialchars($_POST['cinsiyet'] ?? 'Belirtilmedi', ENT_QUOTES, 'UTF-8');
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
    <link href="../lib/css/all.min.css" rel="stylesheet" />
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
