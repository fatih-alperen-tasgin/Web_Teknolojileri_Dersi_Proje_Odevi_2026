<?php
// Güvenli session cookie parametrelerini oturum başlamadan önce ayarla
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
// PHP 7.3+ array tabanlı seçenekleri kullanıyoruz; daha eski sürümlerde
// session_set_cookie_params() farklı şekilde çağrılmalıdır.
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// Güvenli Token Üretimi (session tabanlı CSRF token)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>FatEnTa | Giriş Yap</title>
    <link href="css/style.css" rel="stylesheet" />
    <link href="lib/css/bootstrap.min.css" rel="stylesheet" />
    <link href="lib/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-dark text-white">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
    <div class="container">
        <a class="navbar-brand" href="index.html"><i class="fa-solid fa-house"></i></a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.html">Geri Dön</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center min-vh-80">
    <div class="card p-4 shadow-lg border-0 bg-secondary bg-opacity-10 text-white max-w-400">
        <div class="text-center mb-4">
            <i class="fa-solid fa-user-lock fa-3x text-warning mb-3"></i>
            <h2 class="fw-bold">Giriş Yap</h2>
            <p class="small text-white-50">Lütfen öğrenci bilgilerinizle giriş yapın.</p>
        </div>

        <!-- Hata mesajı parametre olarak gelirse gösterilir -->
        <?php if(isset($_GET['hata'])): ?>
        <div class="alert alert-danger py-2 small text-center">Hatalı kullanıcı adı veya şifre!</div>
        <?php endif; ?>

        <form action="php/login_islem.php" method="POST" id="loginForm">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" />
            <div class="mb-3">
                <label for="kullanici" class="form-label small fw-bold">E-posta (Öğrenci Maili)</label>
                <input type="email" class="form-control bg-dark text-white border-secondary" id="kullanici" name="kullanici" placeholder="b2412100001@sakarya.edu.tr" />
            </div>
            <div class="mb-3">
                <label for="sifre" class="form-label small fw-bold">Şifre (Öğrenci No)</label>
                <input type="password" class="form-control bg-dark text-white border-secondary" id="sifre" name="sifre" placeholder="b2412100001" />
            </div>
            <button type="submit" class="btn btn-warning w-100 fw-bold mt-2">Sisteme Giriş Yap</button>
        </form>
    </div>
</div>

<script src="js/login.js"></script>
</body>
</html>