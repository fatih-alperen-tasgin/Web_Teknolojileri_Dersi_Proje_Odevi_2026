<?php
// php/login.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici = $_POST['kullanici'] ?? '';
    $sifre = $_POST['sifre'] ?? '';

    // Ödevdeki örnek bilgiler: b2412100001@sakarya.edu.tr / b2412100001
    // Bu bilgileri kendi numaranla güncellemelisin!
    $dogru_mail = "b241210079@sakarya.edu.tr";
    $dogru_sifre = "b241210079";

    if ($kullanici === $dogru_mail && $sifre === $dogru_sifre) {
        // Bilgiler doğruysa başarı sayfası
        // Başarılı giriş kısmındaki script bloğuna ekle
        echo "<script>
            localStorage.setItem('isLoggedIn', 'true');
            localStorage.setItem('username', 'FatEnTa');
        </script>";
        echo "<!DOCTYPE html>
        <html lang='tr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Giriş Başarılı</title>
            <!-- Bootstrap ve Stil Dosyaların -->
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
            <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel='stylesheet'>
        </head>
        <body class='bg-light'>

            <div class='container d-flex justify-content-center align-items-center' style='min-height: 100vh;'>
                <div class='card shadow-sm border-0 p-4' style='max-width: 500px; width: 100%; border-radius: 15px;'>
                    <div class='text-center'>
                        <!-- Sade ve Şık Bir Onay İkonu -->
                        <div class='mb-4'>
                            <i class='fa-solid fa-circle-check text-success fa-4x'></i>
                        </div>

                        <h1 class='h2 fw-bold text-dark mb-2'>Hoşgeldiniz</h1>
                        <!-- Ödevin Zorunlu Öğrenci No Alanı -->
                        <h3 class='h4 text-primary mb-4'>b241210079</h3>

                        <hr class='my-4 opacity-25'>

                        <p class='text-secondary mb-4'>
                            Giriş işleminiz başarıyla tamamlandı. Sisteme erişim yetkiniz onaylanmıştır.
                        </p>

                        <!-- Ana Sayfaya Dönüş Butonu -->
                        <a href='../index.html' class='btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm'>
                            <i class='fa-solid fa-house me-2'></i>Ana Sayfaya Dön
                        </a>
                    </div>
                </div>
            </div>

        </body>
        </html>";
    } else {
        // Bilgiler hatalıysa login sayfasına hata mesajıyla yönlendir
        header("Location: ../login.html?hata=1");
        exit();
    }
} else {
    header("Location: ../login.html");
    exit();
}
?>